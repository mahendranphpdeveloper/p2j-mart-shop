<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use App\Models\Attribute;

class AttributeController extends Controller
{
  public function index()
{
    $perPage = request('perPage', 10);
    $search = request('search');
    
    $query = Attribute::query()->orderBy('display_order', 'asc');
    
    if ($search) {
        $query->where('attribute_name', 'like', "%{$search}%");
    }
    
    $attributes = $query->paginate($perPage);
    $attributeCount = Attribute::count();
    
    return view('attributes', compact('attributes', 'attributeCount', 'search'));
}


   public function store(Request $request) 
{
    $request->validate([
        'attribute_name' => 'required|string|max:255',
        'display_order' => 'required|integer',
        'status' => 'required|in:active,inactive',
        'options' => 'nullable|json',
    ]);

    $attributeName = $request->input('attribute_name');
    $slug = Str::slug($attributeName);
    $tableName = 'm_' . $slug;

    // Check if attribute name already exists
    if (Attribute::where('attribute_name', $attributeName)->exists()) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'The attribute "' . $attributeName . '" already exists!');
    }

    // Check if table already exists
    if (Schema::hasTable($tableName)) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Attribute table already exists!');
    }

    // Store attribute in main table
    $attribute = Attribute::create([
        'attribute_name' => $attributeName,
        'attribute_slug' => $slug,
        'display_order' => $request->input('display_order'),
        'status' => $request->input('status'),
    ]);

    // Create dynamic attribute table
    Schema::create($tableName, function (Blueprint $table) use ($slug) {
        $table->increments("m_{$slug}_id");
        $table->string("{$slug}_name", 50)->nullable();
        $table->string('slug', 50)->nullable();
        $table->tinyInteger('web_status')->default(0)->comment('0 - active, 1 - inactive');
        $table->string('web_order', 50)->nullable();
        $table->dateTime('updated_at')->nullable();
        $table->string('updated_by', 50)->nullable();
        $table->dateTime('created_at')->useCurrent();
        $table->string('created_by', 50)->nullable();
        $table->tinyInteger('is_deleted')->default(0)->index()->comment('0 - not deleted, 1 - deleted');
    });

    // Insert options if provided  
    $options = json_decode($request->options, true) ?? [];

    $userId = null;
    if (request()->user()) {
        $userId = request()->user()->getAuthIdentifier();
    }

    foreach ($options as $index => $option) {
        DB::table($tableName)->insert([
            "{$slug}_name" => $option,
            'slug' => Str::slug($option),
            'web_status' => 0,
            'web_order' => $index + 1,
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => $userId,
            'updated_by' => $userId,
            'is_deleted' => 0,
        ]);
    }

    // Generate a simple associated Eloquent Model, like example in app/Models/UnitMatrial.php
    $modelName = 'Unit' . Str::studly(Str::singular($slug));
    $modelFile = app_path("Models/{$modelName}.php");
    if (!file_exists($modelFile)) {
        $modelStub = <<<EOT
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class {$modelName} extends Model
{
    use HasFactory;
    protected \$guarded = [];
    protected \$except = [];
    protected \$table = '{$tableName}';
}

EOT;
        file_put_contents($modelFile, $modelStub);
    }

    // Add the new foreign key column to product_unit table
    $colName = "m_{$slug}_id";
    if (!Schema::hasColumn('product_unit', $colName)) {
        Schema::table('product_unit', function (Blueprint $table) use ($colName) {
            $table->unsignedInteger($colName)->nullable();
        });
    }

    return redirect()->route('attributes.index')
        ->with('success', 'Attribute stored, table and model created successfully. Product unit table updated.');
}


public function update(Request $request, $id)
{
    $request->validate([
        'attribute_name' => 'required|string|max:255',
        'display_order' => 'required|integer',
        'status' => 'required|in:active,inactive',
    ]);

    $attribute = Attribute::findOrFail($id);
    $newName = $request->attribute_name;
    $newSlug = \Illuminate\Support\Str::slug($newName);

    // Check if another attribute with the same name exists
    $existingAttribute = Attribute::where('attribute_name', $newName)
        ->where('id', '!=', $id)
        ->first();

    if ($existingAttribute) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'The attribute "' . $newName . '" already exists!');
    }

    // If the attribute_name/slug are being updated, handle DB changes for table, columns, model, AND update the column name in the lookup table (product_unit)
    $oldSlug = $attribute->attribute_slug;
    $oldTable = 'm_' . $oldSlug;
    $newTable = 'm_' . $newSlug;
    $oldColumnName = "{$oldSlug}_name";
    $newColumnName = "{$newSlug}_name";
    $oldPrimaryKey = "m_{$oldSlug}_id";
    $newPrimaryKey = "m_{$newSlug}_id";
    $oldFK = $oldPrimaryKey;
    $newFK = $newPrimaryKey;

    if ($oldSlug !== $newSlug && !\Illuminate\Support\Facades\Schema::hasTable($newTable)) {
        // 1. Rename attribute value table
        if (\Illuminate\Support\Facades\Schema::hasTable($oldTable)) {
            \Illuminate\Support\Facades\Schema::rename($oldTable, $newTable);
        }

        // 2. Rename primary key column if needed (m_oldslug_id -> m_newslug_id)
        if (\Illuminate\Support\Facades\Schema::hasColumn($newTable, $oldPrimaryKey) && !\Illuminate\Support\Facades\Schema::hasColumn($newTable, $newPrimaryKey)) {
            // MySQL/MariaDB
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE `{$newTable}` CHANGE `{$oldPrimaryKey}` `{$newPrimaryKey}` INT UNSIGNED NOT NULL AUTO_INCREMENT");
        }

        // 3. Rename name column (oldslug_name -> newslug_name)
        if (\Illuminate\Support\Facades\Schema::hasColumn($newTable, $oldColumnName) && !\Illuminate\Support\Facades\Schema::hasColumn($newTable, $newColumnName)) {
            \Illuminate\Support\Facades\DB::statement("ALTER TABLE `{$newTable}` CHANGE `{$oldColumnName}` `{$newColumnName}` VARCHAR(50) NULL");
        }

        // 4. Rename the foreign key in product_unit table accordingly
        if (\Illuminate\Support\Facades\Schema::hasColumn('product_unit', $oldFK)) {
            $platform = \Illuminate\Support\Facades\DB::getDriverName();
            if ($platform === 'mysql') {
                \Illuminate\Support\Facades\DB::statement("ALTER TABLE `product_unit` CHANGE `{$oldFK}` `{$newFK}` INT UNSIGNED NULL");
            } else {
                // Fallback for other DB types
                \Illuminate\Support\Facades\Schema::table('product_unit', function ($table) use ($oldFK, $newFK) {
                    $table->renameColumn($oldFK, $newFK);
                });
            }
        }

        // 5. Rename the associated Eloquent model filename and update class/table name inside
        $oldModelName = 'Unit' . \Illuminate\Support\Str::studly(\Illuminate\Support\Str::singular($oldSlug));
        $newModelName = 'Unit' . \Illuminate\Support\Str::studly(\Illuminate\Support\Str::singular($newSlug));
        $oldModelFile = app_path("Models/{$oldModelName}.php");
        $newModelFile = app_path("Models/{$newModelName}.php");

        if (file_exists($oldModelFile)) {
            $contents = file_get_contents($oldModelFile);
            // Update class name
            $contents = preg_replace('/class\s+' . $oldModelName . '/', 'class ' . $newModelName, $contents);
            // Update protected $table
            $contents = preg_replace("/protected\s+\\\$table\s*=\s*'[^']+';/", "protected \$table = '{$newTable}';", $contents);
            // Update protected $primaryKey, or create it if doesn't exist
            if (preg_match("/protected\s+\\\$primaryKey\s*=/", $contents)) {
                $contents = preg_replace("/protected\s+\\\$primaryKey\s*=\s*'[^']+';/", "protected \$primaryKey = '{$newPrimaryKey}';", $contents);
            } else {
                // Insert after $table property
                $contents = preg_replace(
                    "/(protected\s+\\\$table\s*=\s*'[^']+';)/",
                    "$1\n    protected \$primaryKey = '{$newPrimaryKey}';",
                    $contents
                );
            }
            // Optionally update docblock
            $docblock = <<<EODOC
                /**
                
                */
            EODOC;
            $contents = preg_replace('/(<\?php\s+namespace[^{]+{)(\s*)/s', "$1\n{$docblock}\n", $contents);

            file_put_contents($newModelFile, $contents);
            if ($oldModelFile !== $newModelFile) {
                @unlink($oldModelFile);
            }
        }
    }

    $attribute->update([
        'attribute_name' => $newName,
        'attribute_slug' => $newSlug,
        'display_order' => $request->display_order,
        'status' => $request->status,
    ]);

    return redirect()->route('attributes.index')
        ->with('success', 'Attribute, table, columns (including lookup/foreign key column in product_unit), and model file were updated successfully.');
}


    public function destroy($id)
    {
        $attribute = Attribute::findOrFail($id);
        $tableName = 'm_' . $attribute->attribute_slug;

        // Check for existing relations in product_unit before deleting the attribute table
        $colName = "m_" . $attribute->attribute_slug . "_id";
        $hasDependency = false;

        // if (Schema::hasColumn('product_unit', $colName)) {
        //     $count = DB::table('product_unit')->where($colName, '!=', null)->where('is_deleted', 0)->count();
        //     if ($count > 0) {
        //         $hasDependency = true;
        //     }
        // }

        if ($hasDependency) {
            return redirect()->route('attributes.index')
                ->with('error', 'Cannot delete attribute because there are existing product units using this attribute. Please remove those dependencies first.');
        }

        // Drop the dynamic table if it exists
        if (Schema::hasTable($tableName)) {
            Schema::drop($tableName);
        }

        // Remove foreign key column from product_unit if exists
        if (Schema::hasColumn('product_unit', $colName)) {
            Schema::table('product_unit', function (Blueprint $table) use ($colName) {
                $table->dropColumn($colName);
            });
        }

        // Delete associated model file if it exists
        $slug = $attribute->attribute_slug;
        $modelName = 'Unit' . \Illuminate\Support\Str::studly(\Illuminate\Support\Str::singular($slug));
        $modelFile = app_path("Models/{$modelName}.php");
        if (file_exists($modelFile)) {
            @unlink($modelFile);
        }

        $attribute->delete();

        return redirect()->route('attributes.index')->with('success', 'Attribute, its table, its relation(s), and module file deleted successfully.');
    }


    // Attribute Options Management

public function manageOptions($slug)
{
    $perPage = request('perPage', 10);
    $search = request('search');
    
    $attribute = Attribute::where('attribute_slug', $slug)->firstOrFail();
    $tableName = 'm_' . $slug;
    
    $query = DB::table($tableName)
                ->where('is_deleted', 0)
                ->orderBy('web_order', 'asc');
    
    if ($search) {
        $columnName = $attribute->attribute_slug . '_name';
        $query->where($columnName, 'like', "%{$search}%");
    }
    
    $options = $query->paginate($perPage);
    
    return view('manage-options', compact('attribute', 'options', 'tableName', 'search'));
}

    public function storeOption(Request $request, $slug)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'required|integer',
            'status' => 'required|in:0,1',
        ]);

        $tableName = 'm_' . $slug;
        
        DB::table($tableName)->insert([
            "{$slug}_name" => $request->name,
            'slug' => Str::slug($request->name),
            'web_status' => $request->status,
            'web_order' => $request->order,
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
            'is_deleted' => 0,
        ]);
        
        return redirect()->back()->with('success', 'Option added successfully');
    }

    public function updateOption(Request $request, $slug, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'required|integer',
            'status' => 'required|in:0,1',
        ]);

        $tableName = 'm_' . $slug;
        
        DB::table($tableName)
            ->where("m_{$slug}_id", $id)
            ->update([
                "{$slug}_name" => $request->name,
                'slug' => Str::slug($request->name),
                'web_status' => $request->status,
                'web_order' => $request->order,
                'updated_at' => now(),
                'updated_by' => auth()->id(),
            ]);
        
        return redirect()->back()->with('success', 'Option updated successfully');
    }

    public function destroyOption($slug, $id)
    {
        $tableName = 'm_' . $slug;
        
        // Soft delete
        DB::table($tableName)
            ->where("m_{$slug}_id", $id)
            ->update(['is_deleted' => 1]);
        
        return redirect()->back()->with('success', 'Option deleted successfully');
    }
}