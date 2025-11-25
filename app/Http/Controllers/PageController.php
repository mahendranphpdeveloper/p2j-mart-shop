<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TermsConditions;
use App\Models\PrivacyPolicy;
use App\Models\DeliveryPolicy;
use App\Models\EprCompliance;

class PageController extends Controller
{
    public function about() {
        return view('pages.about');
    }

    public function contact() {
        return view('pages.contact');
    }

  public function privacy()
{
    $privacy = PrivacyPolicy::latest()->first(); // or ->find(1) if static
    return view('pages.privacy', compact('privacy'));
}

  public function terms()
{
    $terms = TermsConditions::latest()->first(); // or ->find(1) if always ID=1
    return view('pages.terms', compact('terms'));
}

  public function shipping()
{
    $delivery = DeliveryPolicy::latest()->first(); // Get latest or DeliveryPolicy::find(1);
    return view('pages.shipping', compact('delivery'));
}

  public function returns()
{
    $returns = EprCompliance::latest()->first(); // You can also use ->find(1) if static
    return view('pages.returns', compact('returns'));
}

    public function faq() {
        return view('pages.faq');
    }

    public function security() {
        return view('pages.security');
    }

    public function grievance() {
        return view('pages.grievance');
    }

    public function epr() {
        return view('pages.epr');
    }

    public function payments() {
        return view('pages.payments');
    }

    public function press() {
        return view('pages.press');
    }

    public function corporate() {
        return view('pages.corporate');
    }

    public function sitemap() {
        return view('pages.sitemap');
    }
}
