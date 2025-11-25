<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gst;

class GstController extends Controller
{
    

    public function index()
    {
        $gst = Gst::first(); // or your logic
        return view('admin.gst');
    }

  
}
