<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeSlider;
use Illuminate\Support\Facades\File;

class HomeSliderController extends Controller
{

    public function homeSliderBanner()
{
    $sliders = HomeSlider::orderBy('created_at', 'desc')->take(4)->get();
    return view('view.index', compact('sliders')); // ← important
}
    
    public function index()
    {
        // Fetch all sliders ordered by sort_order
        $sliders = HomeSlider::orderBy('sort_order')->get();
        return view('Homeslider.index', compact('sliders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $slider = new HomeSlider();
        $slider->title = strip_tags($request->title);
        $slider->content = strip_tags($request->content);        
        $slider->sort_order = $request->sort_order ?? (HomeSlider::max('sort_order') + 1);

        if ($request->hasFile('image')) {
            $fileName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/sliders'), $fileName);
            $slider->image = $fileName;
        }

        $slider->save();

        return redirect()->route('homeslider.index')->with('success', 'Slider added successfully');
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:home_sliders,id',
            'title' => 'required|string',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $slider = HomeSlider::find($request->id);
        if (!$slider) {
            return redirect()->route('homeslider.index')->with('error', 'Slider not found');
        }

        $slider->title = $request->title;
        $slider->content = $request->content;
        $slider->sort_order = $request->sort_order ?? $slider->sort_order;

        if ($request->hasFile('image')) {
            $fileName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/sliders'), $fileName);

            // Delete old image
            if ($slider->image && File::exists(public_path('uploads/sliders/' . $slider->image))) {
                File::delete(public_path('uploads/sliders/' . $slider->image));
            }

            $slider->image = $fileName;
        }

        $slider->save();

        return redirect()->route('homeslider.index')->with('success', 'Slider updated successfully');
    }

    public function destroy($id)
    {
        $slider = HomeSlider::find($id);
        if (!$slider) {
            return redirect()->route('homeslider.index')->with('error', 'Slider not found');
        }

        // Delete image
        if ($slider->image && File::exists(public_path('uploads/sliders/' . $slider->image))) {
            File::delete(public_path('uploads/sliders/' . $slider->image));
        }

        $slider->delete();

        return redirect()->route('homeslider.index')->with('success', 'Slider deleted successfully');
    }


}
