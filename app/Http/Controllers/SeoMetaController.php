<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SeoMeta; // Ensure you have a SeoMeta model

class SeoMetaController extends Controller
{
    public function index()
    {

        return view('seo.index');
    }

    
}
