<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contactus as Contact;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\Enquiry;

class ContactUs extends Controller
{
    public function index()
    {
        try {
            Log::info('Fetching all contact data');
            $data = Contact::all();

            return response()->json([
                'success' => true,
                'message' => 'Contact Us Data Retrieved Successfully',
                'data' => $data
            ], 200);
            
        } catch (\Exception $e) {
            Log::error('Error fetching contact data: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve contact data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function sendMail(Request $request)
    {
        Log::info('Starting sendMail process', ['request' => $request->except('_token')]);
        
        try {
            // Log the received data
            Log::debug('Received form data:', $request->except('_token', 'submit'));
            
            // Insert enquiry into database
            $insertResult = DB::table('enquires')->insert($request->except('_token', 'submit'));
            
            if ($insertResult) {
                Log::info('Database insert successful', ['data' => $request->except('_token', 'submit')]);
                
                try {
                    // Send email
                    Mail::to('jayamweb.developer5@gmail.com')->send(new Enquiry($request->except('_token', 'submit')));
                    Log::info('Email sent successfully');
                    
                    return redirect()->route('contactus')->with('success', 'Your Enquiry Details is received successfully');
                    
                } catch (\Exception $emailException) {
                    Log::error('Failed to send email: ' . $emailException->getMessage());
                    Log::error('Email exception details:', ['exception' => $emailException]);
                    
                    // Even if email fails, return success since DB insert worked
                    return redirect()->route('contactus')->with('success', 'Your enquiry was received but we encountered an issue sending confirmation. We will contact you soon.');
                }
                
            } else {
                Log::error('Database insert failed', ['data' => $request->except('_token', 'submit')]);
                return redirect()->route('contactus')->with('error', 'Failed to send Your Enquiry Details');
            }
            
        } catch (\Exception $e) {
            Log::error('Error in sendMail: ' . $e->getMessage());
            Log::error('Full exception:', ['exception' => $e]);
            
            return redirect()->route('contactus')->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function view()
    {
        try {
            Log::info('Fetching enquiry count for admin view');
            $enq_count = DB::table('enquires')->count();
            
            return view('admin-enquires.enquires', compact('enq_count'));
            
        } catch (\Exception $e) {
            Log::error('Error in view method: ' . $e->getMessage());
            return view('admin-enquires.enquires')->with('error', 'Could not load enquiry data');
        }
    }

    public function get()
    {
        try {
            Log::info('Fetching all enquiries for API response');
            $enquiries = DB::table('enquires')->get();
            
            return response()->json([
                'success' => true,
                'data' => $enquiries
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in get method: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve enquiries',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}