<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Users as Customers;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCreated;
use Illuminate\Support\Facades\Validator;

class Users extends Controller
{
    public function index(Request $request)
    {
        $noti = $request->input('noti');
        if($noti == 1) {
            DB::table('users')->update(['notification' => 0]);
        }
        return view("users.customer");
    }

    public function store(Request $request)
    {
        // Authorization check
       

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'status' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $edit_id = $request->input('is_edit');

        if ($edit_id != 0) {
            // Update existing user
            $status = Customers::where('id', $edit_id)
                ->update($request->except('_token', 'is_edit'));
        } else {
            // Create new user
            $userData = $request->except('_token', 'is_edit');
            $userData['created_by'] = 1; // Or null, or a default user ID

            
            $user = Customers::create($userData);
            $status = $user !== null;

            // Send welcome email only for new users
            if ($status) {
                try {
                    Mail::to($request->email)
                        ->send(new UserCreated([
                            'email' => $request->email,
                            'name' => $request->name,
                            'login_url' => url('/login')
                        ]));
                } catch (\Exception $e) {
                    Log::error('Failed to send welcome email: ' . $e->getMessage());
                }
            }
        }

        return $status
            ? response()->json(['success' => 'Changes saved successfully'])
            : response()->json(['error' => 'Failed to save changes'], 500);
    }

    public function show(string $id)
    {
        $user = Customers::findOrFail($id);
        return response()->json($user);
    }

    public function get()
    {
        $users = Customers::select(['id', 'name', 'last_name', 'phonenumber', 'email'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'data' => $users->map(function ($user, $index) {
                return [
                    'si_no' => $index + 1,
                    'name' => $user->name,
                    'last_name' => $user->last_name,
                    'phone_no' => '<a target="_blank" href="https://wa.me/'.$user->phonenumber.'">'.$user->phonenumber.'</a>',
                    'email' => $user->email,
                    'action' => $this->getActionButtons($user)
                ];
            }),
            'count' => Customers::count()
        ]);
    }

    protected function getActionButtons($user)
    {
        return '<div class="d-flex justify-content-around">
            <a href="#" class="btn btn-primary btn-sm me-2 edit-user" data-id="'.$user->id.'">Edit</a>
            <a href="#" class="btn btn-danger btn-sm delete-user" data-id="'.$user->id.'">Delete</a>
        </div>';
    }
    

    public function destroy(string $id)
    {
      

        try {
            $status = Customers::where('id', $id)->delete();
            return $status
                ? response()->json(['success' => 'User deleted successfully'])
                : response()->json(['error' => 'User not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete user'], 500);
        }
    }
}