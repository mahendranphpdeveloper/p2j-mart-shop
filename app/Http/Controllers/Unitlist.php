<?php

namespace App\Http\Controllers;

use App\Models\UnitAttribute;
use App\Models\UnitSize;
use App\Models\UnitColor;
use App\Models\UnitMatrial;
use App\Models\UnitDesign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Unitlist extends Controller {

    /**
     * Display a listing of the resource.
     */
    public function color() {
        return view("unit.color");
    }

    public function size() {
        return view("unit.size");
    }

    public function material() {
        return view("unit.material");
    }
    public function design() {
        return view("unit.design");
    }
    public function attribute($type){
    return view("unit.attribute", compact('type'));
     }


    public function create() {
        //
    }
//design store
    public function store(Request $request) {
        $res["error_code"] = 400;
        $edit_id = $request->input('m_master_id');
        $data['design_name'] = $request->input('design_name');
        $data['web_status'] = $request->input('status');
        $data['web_order'] = $request->input('web_order');
        $data['slug'] = Str::slug($data['design_name']);
        $total_count = UnitDesign::where('is_deleted', 0)->count();

        if ($edit_id == 0) {
            if ($data['web_order'] != (++$total_count)) {
                UnitDesign::where('web_order', $data['web_order'])->update(['web_order' => $total_count]);
            }
            $status = UnitDesign::create($data);
            if ($status) {
                $res["error_code"] = 200;
            }
        } else {
            $_product = UnitDesign::where('m_design_id', $edit_id)->first();
            if($data['web_order'] != $_product['web_order']){
               UnitDesign::where('web_order', $data['web_order'])->update(['web_order' => $_product['web_order']]);
            }
           $status= UnitDesign::where('m_design_id', $edit_id)->update($data); 
            if ($status) {
                $res["error_code"] = 200;
            }
        }
       return response()->json($res); 
    }
    
    public function getDesign() {
        $get = UnitDesign::where('is_deleted', 0)->get(); 
        return response()->json(['data' => $get]);
    }
    
   public function getDesignData(Request $request) {
        
        $id = $request->input('id');
        $pro_count = UnitDesign::where('is_deleted', 0)->count(); 
        $pro_data = UnitDesign::where('m_design_id', $id)->first();
        return response()->json(['count' => $pro_count, 'data' => $pro_data]);
    }
    
    public function deleteDesign(Request $request) {
        
        $res["error_code"] = 400;
        $res["error_meg"] = "Deleted Failed";
        $id = $request->input('id');
        $cat = UnitDesign::where('m_design_id', $id)->get();
        $pro_count = UnitDesign::where('is_deleted', 0)->count();
        for ($i = $cat[0]->sort_order; $i <= $pro_count; $i++) {

            $update = ['web_order' => $i];
            $status = UnitDesign::where('web_order', ($i + 1))->where('is_deleted', 0)->update($update);
        }

        $status = UnitDesign::where('m_design_id', $id)->update(['is_deleted' => 1]);
        if ($status) {
            $res["error_code"] = 200;
            $res["error_meg"] = "Deleted Successfully";
        }
        return response()->json($res);
    }

    public function show(string $id) {
        //
    }

    public function edit(string $id) {
        //
    }

    public function update(Request $request, string $id) {
        //
    }

    public function destroy(string $id) {
        //
    }

    public function getMatrial() {
        $get = UnitMatrial::where('is_deleted', 0)->get();
        return response()->json(['data' => $get]);
    }

    public function deleteMatrial(Request $request) {
        $res["error_code"] = 400;
        $res["error_meg"] = "Deleted Failed";
        $id = $request->input('id');
        $cat = UnitMatrial::where('m_material_id', $id)->get();
        $pro_count = UnitMatrial::where('is_deleted', 0)->count();
        for ($i = $cat[0]->sort_order; $i <= $pro_count; $i++) {

            $update = ['web_order' => $i];
            $status = UnitMatrial::where('web_order', ($i + 1))->where('is_deleted', 0)->update($update);
        }

        $status = UnitMatrial::where('m_material_id', $id)->update(['is_deleted' => 1]);
        if ($status) {
            $res["error_code"] = 200;
            $res["error_meg"] = "Deleted Successfully";
        }
        return response()->json($res);
    }

    public function getMatrialData(Request $request) {
        $id = $request->input('id');
        $pro_count = UnitMatrial::where('is_deleted', 0)->count(); 
        $pro_data = UnitMatrial::where('m_material_id', $id)->first();
        return response()->json(['count' => $pro_count, 'data' => $pro_data]);
    }

    public function storeMatrial(Request $request) {
        $res["error_code"] = 400;
        $edit_id = $request->input('m_master_id');
        $data['material_name'] = $request->input('material_name');
        $data['web_status'] = $request->input('status');
        $data['web_order'] = $request->input('web_order');
        $data['slug'] = Str::slug($data['material_name']);
        $total_count = UnitMatrial::where('is_deleted', 0)->count();

        if ($edit_id == 0) {
            if ($data['web_order'] != (++$total_count)) {
                UnitMatrial::where('web_order', $data['web_order'])->update(['web_order' => $total_count]);
            }
            $status = UnitMatrial::create($data);
            if ($status) {
                $res["error_code"] = 200;
            }
        } else {
            $_product = UnitMatrial::where('m_material_id', $edit_id)->first();
            if($data['web_order'] != $_product['web_order']){
               UnitMatrial::where('web_order', $data['web_order'])->update(['web_order' => $_product['web_order']]);
            }
           $status= UnitMatrial::where('m_material_id', $edit_id)->update($data); 
            if ($status) {
                $res["error_code"] = 200;
            }
        }
       return response()->json($res); 
    }
    
    public function getSize() {
        $get = UnitSize::where('is_deleted', 0)->get();
        return response()->json(['data' => $get]);
    }

    public function deleteSize(Request $request) {
        $res["error_code"] = 400;
        $res["error_meg"] = "Deleted Failed";
        $id = $request->input('id');
        $cat = UnitSize::where('m_size_id', $id)->get();
        $pro_count = UnitSize::where('is_deleted', 0)->count();
        for ($i = $cat[0]->sort_order; $i <= $pro_count; $i++) {

            $update = ['web_order' => $i];
            $status = UnitSize::where('web_order', ($i + 1))->where('is_deleted', 0)->update($update);
        }

        $status = UnitSize::where('m_size_id', $id)->update(['is_deleted' => 1]);
        if ($status) {
            $res["error_code"] = 200;
            $res["error_meg"] = "Deleted Successfully";
        }
        return response()->json($res);
    }

    public function getSizeData(Request $request) {
        $id = $request->input('id');
        $pro_count = UnitSize::where('is_deleted', 0)->count(); 
        $pro_data = UnitSize::where('m_size_id', $id)->first();
        return response()->json(['count' => $pro_count, 'data' => $pro_data]);
    }

    public function storeSize(Request $request) {
        $res["error_code"] = 400;
        $edit_id = $request->input('m_size_id');
        $data['size_name'] = $request->input('size_name');
        $data['web_status'] = $request->input('status');
        $data['web_order'] = $request->input('web_order');
        $data['slug'] = Str::slug($data['size_name']);
        $total_count = UnitSize::where('is_deleted', 0)->count();

        if ($edit_id == 0) {
            if ($data['web_order'] != (++$total_count)) {
                UnitSize::where('web_order', $data['web_order'])->update(['web_order' => $total_count]);
            }
            $status = UnitSize::create($data);
            if ($status) {
                $res["error_code"] = 200;
            }
        } else {
            $_product = UnitSize::where('m_size_id', $edit_id)->first();
            if($data['web_order'] != $_product['web_order']){
               UnitSize::where('web_order', $data['web_order'])->update(['web_order' => $_product['web_order']]);
            }
           $status= UnitSize::where('m_size_id', $edit_id)->update($data); 
            if ($status) {
                $res["error_code"] = 200;
            }
        }
       return response()->json($res); 
    }
    // #########################
    public function getAttributeList(Request $request)
    {
        Log::info($request->all());
    
        $table = 'm_'. $request->input('table');    
        $model = (new UnitAttribute())->setTableName($table);
    
        $get = $model->where('is_deleted', 0)->orderBy('web_order')->get();
        
        return response()->json(['data' => $get]);
    }
    


    public function deleteAttribute(Request $request)
    {
        $table = 'm_' . $request->input('table');
        $id = $request->input('id');
    
        $unit = new UnitAttribute();
        $model = $unit->setTableName($table);
    
        // Perform the soft delete and capture the result
        $status = $model->where($table . '_id', $id)->update(['is_deleted' => 1]);
    
        if ($status) {
            $res["error_code"] = 200;
            $res["error_meg"] = "Deleted Successfully";
        } else {
            $res["error_code"] = 500;
            $res["error_meg"] = "Delete Failed";
        }
    
        return response()->json($res);
    }
    
    



    public function getAttributeData(Request $request)
    {
      
        $table = 'm_'. $request->input('table');
        $id = $request->input('id');
        Log::info($request->all());

        $unit = new UnitAttribute();
        $model = $unit->setTableName($table);

        $count = $model->where('is_deleted', 0)->count();
        $data = $model->where($table . '_id', $id)->first();
        Log::info($data);
        return response()->json([
            'count' => $count,
            'data' => $data
        ]);
    }

    public function storeAttribute(Request $request)
    {
        $res["error_code"] = 400;
        $table = $request->input('table');
        $primaryKey = $request->input('primary_key', 'id');
        $edit_id = $request->input($primaryKey);
        $web_order = $request->input('web_order');

        // all inputs except table and primary_key
        $data = $request->except(['table', 'primary_key', $primaryKey]);
        
        // Optional: If one of the fields is a name and you want slug
        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $unit = new UnitAttribute();
        $model = $unit->setTableName($table);
        $total_count = $model->where('is_deleted', 0)->count();

        if (empty($edit_id)) {
            // New insert
            if ($web_order && $web_order != (++$total_count)) {
                $model->where('web_order', $web_order)->update(['web_order' => $total_count]);
            }
            $status = $model->create($data);
        } else {
            // Update existing
            $existing = $model->where($primaryKey, $edit_id)->first();
            if ($web_order && $web_order != $existing->web_order) {
                $model->where('web_order', $web_order)->update(['web_order' => $existing->web_order]);
            }
            $status = $model->where($primaryKey, $edit_id)->update($data);
        }

        if ($status) {
            $res["error_code"] = 200;
        }

        return response()->json($res);
    }

    // ######################################
    
    public function getColor() {
        $get = UnitColor::where('is_deleted', 0)->get();
        return response()->json(['data' => $get]);
    }

    public function deleteColor(Request $request) {
        $res["error_code"] = 400;
        $res["error_meg"] = "Deleted Failed";
        $id = $request->input('id');
        $cat = UnitColor::where('m_color_id', $id)->get();
        $pro_count = UnitColor::where('is_deleted', 0)->count();
        for ($i = $cat[0]->sort_order; $i <= $pro_count; $i++) {

            $update = ['web_order' => $i];
            $status = UnitColor::where('web_order', ($i + 1))->where('is_deleted', 0)->update($update);
        }

        $status = UnitColor::where('m_color_id', $id)->update(['is_deleted' => 1]);
        if ($status) {
            $res["error_code"] = 200;
            $res["error_meg"] = "Deleted Successfully";
        }
        return response()->json($res);
    }

    public function getColorData(Request $request) {
        $id = $request->input('id');
        $pro_count = UnitColor::where('is_deleted', 0)->count(); 
        $pro_data = UnitColor::where('m_color_id', $id)->first();
        return response()->json(['count' => $pro_count, 'data' => $pro_data]);
    }

    public function storeColor(Request $request) {
        $res["error_code"] = 400;
        $edit_id = $request->input('m_color_id');
        $data['color_name'] = $request->input('color_name');
        $data['color_code'] = $request->input('color_code');
        $data['web_status'] = $request->input('status');
        $data['web_order'] = $request->input('web_order');
        $data['slug'] = Str::slug($data['color_name']);
        $total_count = UnitColor::where('is_deleted', 0)->count();
if ($request->input('multiple_color') !== null) {

          $data['color_code'] = "linear-gradient(to right, " . $request->input('multiple_color') . ")"; 

        }
        if ($edit_id == 0) {
            if ($data['web_order'] != (++$total_count)) {
                UnitColor::where('web_order', $data['web_order'])->update(['web_order' => $total_count]);
            }
            $status = UnitColor::create($data);
            if ($status) {
                $res["error_code"] = 200;
            }
        } else {
            $_product = UnitColor::where('m_color_id', $edit_id)->first();
            if($data['web_order'] != $_product['web_order']){
               UnitColor::where('web_order', $data['web_order'])->update(['web_order' => $_product['web_order']]);
            }
           $status= UnitColor::where('m_color_id', $edit_id)->update($data); 
            if ($status) {
                $res["error_code"] = 200;
            }
        }
       return response()->json($res); 
    }
    

}
