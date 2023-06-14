<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function profile(Request $request)
    {
        $data = new \stdClass;
        $data->title = "Profile | Admin Panel";

        $user = \Auth::user();
        return view('admin.pages.profile', ['data' => $data, 'user' => $user]);
    }

    public function updateProfile(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'name' => 'required|string|max:50',
                'password' => 'nullable|min:8'
            ]);
            $user = \Auth::user();
            $user->update([
                "email" => $request->email,
                "name" => $request->name,
                "password" => $request->password ? bcrypt($request->password) : $user->password,
            ]);
            return back()->with(['response' => ['message' => 'Profile updated successfully', 'class' => 'alert-info']]);
        } catch (\Throwable $e) {
            return back()->with(['response' => ['message' => $e->getMessage(), 'class' => 'alert-danger']]);
        }
    }
}
