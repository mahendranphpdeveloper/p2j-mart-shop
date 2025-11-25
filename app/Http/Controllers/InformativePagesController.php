<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrivacyPolicy;
use App\Models\DeliveryPolicy;
use App\Models\TermsConditions;
use App\Models\SecurityPolicy;
use App\Models\EprCompliance;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class InformativePagesController extends Controller
{
    public function privacyPolicy()
    {
        
        $privacyPolicy = PrivacyPolicy::latest()->first();

        return view('informative-pages.privacy-policy', compact('privacyPolicy'));
    }

    public function savePrivacyPolicy(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);
    
        // Update existing entry or create a new one if not exists
        PrivacyPolicy::updateOrCreate(
            ['id' => 1], // Ensures only one record exists with ID = 1
            [
                'title' => $request->title,
                'content' => $request->content,
            ]
        );
    
        return back()->with('success', 'Privacy Policy updated successfully!');
    }
    
    public function deliveryPolicy()
    {
        $deliveryPolicy = DeliveryPolicy::latest()->first();
        return view('informative-pages.delivery-policy', compact('deliveryPolicy'));
    }

    public function saveDeliveryPolicy(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        // Ensure only one policy exists
        DeliveryPolicy::truncate(); // Deletes all previous records
        DeliveryPolicy::create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return back()->with('success', 'Delivery Policy saved successfully!');
    }
 
    public function termsConditions()
    {
        $termsConditions = TermsConditions::first(); // Fetch the single record
        return view('informative-pages.terms-conditions', compact('termsConditions'));
    }

    // Save or Update Terms & Conditions
    public function saveTermsConditions(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        $termsConditions = TermsConditions::firstOrNew(); // Fetch or create a new one
        $termsConditions->title = $request->title;
        $termsConditions->content = $request->content;
        $termsConditions->save();

        return redirect()->route('informative-pages.terms-conditions')->with('success', 'Terms & Conditions updated successfully.');
    }


    public function securityPolicy()
    {
        $securityPolicy = SecurityPolicy::latest()->first();
        return view('informative-pages.security_policy',compact('securityPolicy'));
    }

    public function saveSecurityPolicy(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
        ]);

        $securityPolicy = SecurityPolicy::firstOrNew(); // Fetch or create a new one
        $securityPolicy->title = $request->title;
        $securityPolicy->content = $request->content;
        $securityPolicy->save();

        return redirect()->route('informative-pages.security-policy')->with('success', 'Security Policy updated successfully.');
    }

    public function eprCompliance()
    {
        $eprCompliance = EprCompliance::latest()->first();
        return view('informative-pages.epr_compliance', compact('eprCompliance'));
    }
    

// Save or update EPR Compliance data
public function saveEprCompliance(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required',
    ]);

    // Fetch or create a new record
    $eprCompliance = EprCompliance::firstOrNew(); 
    $eprCompliance->title = $request->title;
    $eprCompliance->content = $request->content;
    $eprCompliance->save();

    // Redirect back with success message
    return redirect()->route('informative-pages.epr_compliance')->with('success', 'EPR Compliance updated successfully.');
}


}
