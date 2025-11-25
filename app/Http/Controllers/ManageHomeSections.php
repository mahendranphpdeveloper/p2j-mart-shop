<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\MessageBag;

class ManageHomeSections extends Controller
{
    const MAX_WIDTH = 455;
    const MAX_HEIGHT = 205;

    public function index()
    {
        $data = DB::table('3_cards')->get();
        return view("manage-sections.cards", compact('data'));
    }

    public function userHome()
{
    $card = DB::table('3_cards')->where('id', 1)->first();
    return view('view.index', compact('card'));
    
}
    
    public function validateImage($width, $height, $imgKey)
    {
        $errors = [];

        if ($width > self::MAX_WIDTH) {
            $errors[$imgKey] = 'Image Width should not exceed ' . self::MAX_WIDTH . 'px';
        }

        if ($height > self::MAX_HEIGHT) {
            $errors[$imgKey] = 'Image Height should not exceed ' . self::MAX_HEIGHT . 'px';
        }

        return $errors;
    }

    public function uploadImage($image, $path, $old_image = null)
    {
        $imageName = uniqid() . '.' . $image->extension();
        $image->move($path, $imageName);

        if ($old_image) {
            $delete_file = $path . '/' . $old_image;
            if (file_exists($delete_file)) {
                unlink($delete_file);
            }
        }

        return $imageName;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_1_title_1' => 'required|string|max:50',
            'card_1_title_2' => 'required|string|max:50',
            'card_2_title_1' => 'required|string|max:50',
            'card_2_title_2' => 'required|string|max:50',
            'card_3_title_1' => 'required|string|max:50',
            'card_3_title_2' => 'required|string|max:50',
            'image_1' => 'image|mimes:jpg,jpeg,png,webp',
            'image_2' => 'image|mimes:jpg,jpeg,png,webp',
            'image_3' => 'image|mimes:jpg,jpeg,png,webp',
        ]);

        $errors = [];
        $imagePath = public_path('uploads/banners');

        if (!file_exists($imagePath)) {
            mkdir($imagePath, 0755, true);
        }

        foreach (['image_1', 'image_2', 'image_3'] as $imgField) {
            if ($request->hasFile($imgField)) {
                $imageFile = $request->file($imgField);
                $imgSize = @getimagesize($imageFile);
                if ($imgSize) {
                    $errors = array_merge($errors, $this->validateImage($imgSize[0], $imgSize[1], $imgField));
                } else {
                    $errors[$imgField] = 'Invalid image file.';
                }
            }
        }

        if (!empty($errors)) {
            $customErrors = new MessageBag($errors);
            return redirect()->back()->withErrors($customErrors)->withInput();
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = [
            'card_1_title_1' => $request->input('card_1_title_1'),
            'card_1_title_2' => $request->input('card_1_title_2'),
            'card_2_title_1' => $request->input('card_2_title_1'),
            'card_2_title_2' => $request->input('card_2_title_2'),
            'card_3_title_1' => $request->input('card_3_title_1'),
            'card_3_title_2' => $request->input('card_3_title_2'),
            'id' => 1,
        ];

        foreach (['image_1', 'image_2', 'image_3'] as $imgField) {
            if ($request->hasFile($imgField)) {
                $data[$imgField] = $this->uploadImage($request->file($imgField), $imagePath);
            }
        }

        $status = DB::table('3_cards')->updateOrInsert(['id' => 1], $data);

        if ($status) {
            return redirect()->back()->with('message', 'Your data has been successfully saved.');
        } else {
            return redirect()->back()->withErrors(['error' => 'Failed to save data']);
        }
    }

    public function show(string $id)
    {
        $data = DB::table('banner_1')->get();
        return view('manage-sections.banner', compact('data'));
    }

    public function banner()
    {
        $data = DB::table('banner_2')->get();
        return view('manage-sections.banner-2', compact('data'));
    }

    public function saveBanner(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_1' => 'required|string|max:50',
            'title_2' => 'required|string|max:50',
            'title_3' => 'required|string|max:50',
            'image' => 'image|mimes:jpg,jpeg,png,webp',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $imagePath = public_path('uploads/banners');

        if (!file_exists($imagePath)) {
            mkdir($imagePath, 0755, true);
        }

        $data = [
            'title_1' => $request->input('title_1'),
            'title_2' => $request->input('title_2'),
            'title_3' => $request->input('title_3'),
            'id' => 1,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), $imagePath, $request->input('old_image'));
        }

        $status = DB::table('banner_2')->updateOrInsert(['id' => 1], $data);

        if ($status) {
            return redirect()->back()->with('message', 'Your data has been successfully saved.');
        } else {
            return redirect()->back()->withErrors(['error' => 'Failed to save data']);
        }
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'title_1' => 'required|string|max:50',
            'title_2' => 'required|string|max:50',
            'title_3' => 'required|string|max:50',
            'image' => 'image|mimes:jpg,jpeg,png,webp',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $imagePath = public_path('uploads/banners');

        if (!file_exists($imagePath)) {
            mkdir($imagePath, 0755, true);
        }

        $data = [
            'title_1' => $request->input('title_1'),
            'title_2' => $request->input('title_2'),
            'title_3' => $request->input('title_3'),
            'id' => 1,
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), $imagePath, $request->input('old_image'));
        }

        $status = DB::table('banner_1')->updateOrInsert(['id' => 1], $data);

        if ($status) {
            return redirect()->back()->with('message', 'Your data has been successfully saved.');
        } else {
            return redirect()->back()->withErrors(['error' => 'Failed to save data']);
        }
    }

    public function destroy(string $id)
    {
        // Not implemented
    }
}
