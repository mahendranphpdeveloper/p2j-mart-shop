<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Models\ShippingDetails;
use App\Models\State;

class Settings extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index()
{
    if(auth()->user()->id != 1) {
        Log::warning('Unauthorized access attempt to admin profile', ['user_id' => auth()->id()]);
        abort(404);
    }

    $admin_user = auth()->user();
    Log::debug('Admin profile view loaded', ['admin_id' => $admin_user->id]);
    return view("admin-profile.profile", compact('admin_user'));
}


    public function create()
    {
        if(auth()->user()->id!=1)
          abort(404);

         $data = DB::table('themes')->get();
        return view("admin.theme",compact('data'));
    }

   public function store(Request $request)
{
    Log::info('Admin profile update request received', ['user_id' => auth()->id(), 'data' => $request->except('password', 'confirm_password')]);

    if(auth()->user()->id != 1) {
        Log::warning('Unauthorized profile update attempt', ['user_id' => auth()->id()]);
        abort(404);
    }

    $validator = Validator::make($request->all(), [
        "name" => "required|string|max:255",
        "new_password" => "nullable|min:6",
        "confirm_password" => "nullable|same:new_password",
    ]);

    if ($validator->fails()) {
        Log::error('Validation failed in admin profile update', [
            'errors' => $validator->errors(),
            'input' => $request->all()
        ]);
        return redirect()->back()->withErrors($validator)->withInput();
    }

    try {
        $admin = AdminUser::findOrFail(auth()->user()->id);
        $admin->name = $request->name;

        if ($request->new_password) {
            $admin->password = Hash::make($request->new_password);
            Log::debug('Password update attempted', ['admin_id' => $admin->id]);
        }

        if ($admin->save()) {
            Log::info('Admin profile updated successfully', ['admin_id' => $admin->id]);
            return redirect()->back()->with('message', 'Profile updated successfully');
        } else {
            Log::error('Failed to save admin profile', ['admin_id' => $admin->id]);
            return redirect()->back()->withErrors('Failed to update profile')->withInput();
        }
    } catch (\Exception $e) {
        Log::error('Exception in admin profile update', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        return redirect()->back()->withErrors('An error occurred while updating profile')->withInput();
    }
}

    public function show(string $id)
    {
        //
    }

    public function dynamicUnits(Request $req){
        return view('settings.dynamic-units');
    }

    public function editDynamicUnits($id){
        $edit = DB::table('dynamic_units')->where('id',$id)->first();
       return response()->json([$edit]);
    }
    public function saveDynamicUnits(Request $request){

      $validator = Validator::make($request->all(), [
        'name' => 'required',
        'status' => 'required',
      ]);

      if ($validator->fails()) {
        return response()->json([$validator->errors()]);
      }

      $edit_id = $request->input('is_edit');

      if($name = $request->input('name')){

        $slug = Str::slug($name);
        $request->merge(['slug' => $slug ]);
        $slug_exist = DB::table('dynamic_units')->where('slug',$slug)->count();
        $get = DB::table('dynamic_units')->where('id',$edit_id)->get();
        isset($get[0]->slug) ? $get= $get[0]->slug: 'null';
        if( ($slug_exist>0 && !$edit_id) || ($slug!=$get && ($slug_exist>0))  ){
            return response()->json(['error' => 'The Unit Already exists']);
        }
          if($edit_id==0){
              if(!$this->createTable($slug)  ){
                return response()->json(['error' => 'Try Using Different Unit Name ']);
              }
            }
      }

      if($edit_id != 0) {
          $status = DB::table('dynamic_units')->where('id',$edit_id)->update($request->except('_token','is_edit'));
      }else {
          $status = DB::table('dynamic_units')->insert($request->except('_token','is_edit'));
      }

      if($status) {
          return response()->json(['success' => 'Category added successfully']);
      }
          return response()->json(['error' => $validator->errors()], 422);


    }

    public function get()
    {
      try {
        $get = DB::table('dynamic_units')->where('deleted_at',null)->get();
        $i=1;
        foreach ($get as $item) {
            $item->sl_no = $i;
            $item->action = '<div class="d-flex justify-content-evenly">
            <a href="' . route('products.show', ['product' => $item->id]) . '" class="d-none pe-3 btn btn-secondary" id="addProduct">Products</a>';
          if(auth()->user()->setting_edit)
              $item->action.= '<a href="javascript:void(0)" data-id="' . $item->id . '" class="edit pe-3 btn btn-info" id="edit">Edit</a>';
          if(auth()->user()->setting_delete)
              $item->action.= '<a href="javascript:void(0)" data-id="' . $item->id . '" class="delete pe-3 btn btn-danger text-white" id="delete">Delete</a>
            </div>';
            $i++;
        }

          $get_count = DB::table('dynamic_units')->count();
          return response()->json(['data' => $get, 'count' => $get_count]);

      } catch (\Exception $e) {
          \Log::error($e->getMessage());
          return response()->json(['success' => false, 'message' => 'An error occurred'], 500);
      }
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        // dd($request->all());
        $request->merge(['id'=>1]);
        $status = DB::table('themes')->upsert($request->except('_method','_token'),1);

        if($status){
            return redirect()->back()->with('success','Your changes saved successfully');
        }
            return redirect()->back()->with('error','Failed to save the changes');

    }

    public function destroyShippingCost($id)
    {
        $state = State::findOrFail($id);
        $state->delete();
    
        return redirect()->back()->with('success', 'Shipping cost deleted successfully.');
    }
    

    public function createTable($tableName)
    {
      $tableName=str_replace('-','_',$tableName);
        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function ($table) {
                $table->increments('id');
                $table->string('name');
                $table->string('slug');
                $table->tinyInteger('web_status');
                $table->tinyInteger('is_deleted')->default(0);
                $table->integer('web_order');
                $table->softDeletes();
                $table->timestamps();
            });

            Schema::table('product_unit', function (Blueprint $table) use ($tableName) {
              DB::statement('ALTER TABLE product_unit ADD ' . $tableName . ' INTEGER(11) NULL');
          });

            return true;
        } else {
            return false;
        }
    }

    public function deleteDynamicUnits(Request $req){
        $status = DB::table('dynamic_units')->where('id',$req->input('id'))->update(['deleted_at'=> now()]);

        return response()->json(['success' => true, 'message' => 'Deleted Successfully'], 200);
    }

    public function shippingCost(){
       $states = State::get();
        return view('admin.shipping-cost', compact('states'));
    }
   public function saveShippingCost(Request $request)
{
    Log::info('saveShippingCost START', $request->all());

    try {
        $request->validate([
            'name' => 'required|string|max:255',
            'base_weight' => 'required|numeric',
            'base_cost' => 'required|numeric',
            'additional_weight_unit' => 'required|numeric',
            'additional_cost_per_unit' => 'required|numeric',
        ]);
        Log::info('Validation passed');

        // Check if the state name already exists (excluding the current state if updating)
        $existingState = State::where('name', $request->name)
            ->when($request->state_id, function ($query) use ($request) {
                return $query->where('id', '!=', $request->state_id);
            })
            ->first();

        Log::info('Existing state check done', ['existingState' => $existingState]);

        if ($existingState) {
            Log::warning('State already exists', ['name' => $request->name]);
            return response()->json(['error' => 'This state already exists!'], 422);
        }

        // Prepare data
        $data = [
            'name' => $request->name,
            'base_weight' => (int) $request->base_weight,
            'base_cost' => (int) $request->base_cost,
            'additional_weight_unit' => (int) $request->additional_weight_unit,
            'additional_cost_per_unit' => (int) $request->additional_cost_per_unit,
        ];

        Log::info('Prepared data:', $data);

        // Create or update state
        $result = State::updateOrCreate(
            ['id' => $request->state_id],
            $data
        );

        Log::info('State saved successfully', ['id' => $result->id]);

        return response()->json(['success' => 'Shipping cost saved successfully!']);

    } catch (\Exception $e) {
        Log::error('Exception in saveShippingCost: ' . $e->getMessage());
        return response()->json(['error' => 'Internal Server Error'], 500);
    }
}
    
    // Get a single state record
    public function editState($id)
    {
        $state = State::find($id);
        return response()->json([
            'id' => $state->id,
            'name' => $state->name,
            'base_weight' => $state->base_weight,
            'base_cost' => $state->base_cost,
            'additional_weight_unit' => $state->additional_weight_unit,
            'additional_cost_per_unit' => $state->additional_cost_per_unit,
        ]);
    }

    // Delete a state
    public function deleteState($id)
    {
        $state = State::find($id);
        if ($state) {
            $state->delete();
            return response()->json(['success' => 'State deleted successfully!']);
        }
        return response()->json(['error' => 'State not found!'], 404);
    }  
    public function saveShippingCost2(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(),[
            'available' => 'nullable',
            'flat_rate' => 'nullable',
            'flat_rate_areas' => 'nullable',
            'flat_rate_for_others' => 'nullable',
            'customized_shipping_status' => 'nullable',
            'customize_order_value' => 'nullable',
            'customized_shipping_cost' => 'nullable',
            'customized_shipping_cost_area' => 'nullable',
            'others_customized_shipping_cost' => 'nullable',

        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator->fails());
        }
        $request->merge([
                          'available' =>  $request->available?1:0,
                          'customized_shipping_status' =>  $request->customized_shipping_status?1:0,
            ]);
        if(ShippingDetails::updateOrInsert(['id'=>1], $request->except('_token')));
            return redirect()->back()->with('message','Your changes saved successfully');

    }

    
    
}
