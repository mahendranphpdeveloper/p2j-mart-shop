<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\HeaderFooter;
use Illuminate\Support\Facades\Log;

class HeaderFooterController extends Controller
{
    public function headerFooter()
    {
        // Get the record with id = 1 from the HeaderFooter model
        $common = HeaderFooter::where('id', 1)->first();

        Log::info($common);
        return view('admin-header-footer', compact('common'));
    }

    public function saveHeaderFooter(Request $request)
    {
        $status = false;

        // Define validation rules
        $validator = Validator::make($request->all(), [
            'call_banner' => 'mimes:jpeg,JPEG,png,PNG,jpg,JPG,gif|max:2048',
            'facebook_link' => 'nullable|string|max:255',
            'twitter_link' => 'nullable|string|max:255',
            'linkedin_link' => 'nullable|string|max:255',
            'insta_link' => 'nullable|string|max:255',
            'youtube_link' => 'nullable|string|max:255',
            'header_title' => 'required|string|max:255',
            'footer_contact_title' => 'required|string|max:255',
            'home_meta_title' => 'required|string|max:255',
            'home_meta_keywords' => 'required|string',
            'home_meta_description' => 'required|string|max:160',
            'email' => 'required|string|max:255',
            'address' => 'required|string|max:355',
            'mobile_no' => 'required|string|regex:/^[6-9]\d{9}$/|max:10',

            // Validation for down_content_1, down_content_2, down_content_3
            'down_content_1' => 'nullable|array',
            'down_content_1.*.icon' => 'nullable|string',
            'down_content_1.*.title' => 'nullable|string|max:255',
            'down_content_1.*.content' => 'nullable|string|max:500',
            
            'down_content_2' => 'nullable|array',
            'down_content_2.*.icon' => 'nullable|string',
            'down_content_2.*.title' => 'nullable|string|max:255',
            'down_content_2.*.content' => 'nullable|string|max:500',

            'down_content_3' => 'nullable|array',
            'down_content_3.*.icon' => 'nullable|string',
            'down_content_3.*.title' => 'nullable|string|max:255',
            'down_content_3.*.content' => 'nullable|string|max:500',
        ]);

        // If validation fails, redirect back with errors and input data
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $data = $request->all();

        // Convert down_content_1, down_content_2, down_content_3 to JSON if present
        $data['down_content_1'] = $request->input('down_content_1') ? json_encode($request->input('down_content_1')) : null;
        $data['down_content_2'] = $request->input('down_content_2') ? json_encode($request->input('down_content_2')) : null;
        $data['down_content_3'] = $request->input('down_content_3') ? json_encode($request->input('down_content_3')) : null;

        // Use updateOrCreate to save or update the record with id = 1
        if (HeaderFooter::updateOrCreate(['id' => 1], $data)) {
            $status = true;
        }

        // If the status is true, redirect with success message
        if ($status) {
            return redirect()->back()->with('message', 'Your Changes Saved Successfully');
        }

        // Otherwise, redirect with an error message
        return redirect()->back()->with('error', 'Failed to Save');
    }
}
