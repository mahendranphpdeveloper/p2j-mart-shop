<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use App\Models\Enquiry;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ContactUsController extends Controller
{
    /**
     * Display the Contact Us form.
     */
    public function edit()
    {
        $contactUs = ContactUs::first() ?? new ContactUs();
        return view('admin.contact_page', compact('contactUs'));
    }

    public function update(Request $request)
    {
        Log::info($request->all());
        $request->validate([
            'meta_title'     => 'required|string|max:255',
            'meta_keywords'  => 'nullable|string',
            'meta_description' => 'nullable|string',
            'address_title_1'   => 'required|string|max:255',
            'phone_title_1'   => 'required|string|max:255',
            'email_title_1'  => 'required|string|max:255',
            'address'        => 'required|string|max:255',
            'phone'          => 'required|string|max:400',
            'email'          => 'required|string|max:255',
            'embed_map_link' => 'required|url',
            'form_content'        => 'required|string',
            'form_title'        => 'required|string|max:255',
        ]);
        Log::info($request->all());

        // Fetch the existing contact information or create a new one
        $contactUs = ContactUs::first() ?? new ContactUs();

        // Handle image upload using Laravel's Storage
        if ($request->hasFile('banner_image')) {
            // Delete old image if it exists using Storage
            if ($contactUs->banner_image && Storage::exists($contactUs->banner_image)) {
                Storage::delete($contactUs->banner_image);
            }

            // Store the new image
            $file = $request->file('banner_image');
            $path = $file->storeAs('public/uploads/contactUs', time() . '-' . $file->getClientOriginalName()); // Store in the public directory
            $contactUs->banner_image = $path; // Save the relative path in the database
        }

        // Fill the rest of the contact information from the request
        $contactUs->fill($request->only([
            'meta_title',
            'meta_keywords',
            'meta_description',
            'address_title_1',
            'phone_title_1',
            'email_title_1',
            'address',
            'phone',
            'email',
            'embed_map_link',
            'form_title',
            'form_content',
        ]));

        // Save the updated Contact Us information
        $contactUs->save();

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Contact Us information updated successfully.');
    }
    
     public function enquiresForm(Request $request)
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create new enquiry
        Enquiry::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
}
