<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;

class ProfileController extends Controller
{
    public function index()
    {   
        $user = User::with(['role'])->findOrFail(auth('web')->user()->id);
        $data = [
            'title' => 'Profile',
            'breadcumbs' => [
                ['text' => 'Dashboard', 'status' => null, 'link' => route('dashboard')],
                ['text' => 'Profile', 'status' => 'active', 'link' => '#'],
            ],
            'user' => $user,
        ];
        return view('contents.profile.index', $data);
    }

    public function update()
    {
        $user = User::with(['role'])->findOrFail(auth('web')->user()->id);
        $data = [
            'title' => 'Edit Profile',
            'breadcumbs' => [
                ['text' => 'Dashboard', 'status' => null, 'link' => route('dashboard')],
                ['text' => 'Profile', 'status' => null, 'link' => route('profile')],
                ['text' => 'Edit', 'status' => 'active', 'link' => '#'],
            ],
            'user' => $user,
        ];
        return view('contents.profile.update', $data);
    }

    public function save(Request $request)
    {
        $id = auth('web')->user()->id;
        $this->validate($request, [
            'name' => 'required|min:3',
            'username' => 'required|min:3|regex:/^[a-z0-9\_]+$/|unique:users,user_username,' . $id . ',id',
            'email' => 'required|email|unique:users,user_email,' . $id . ',id',
        ]);

        $user = User::findOrFail($id);
        $user->user_name = $request->input('name');
        $user->user_username = $request->input('username');
        if($user->user_email != $request->input('email')){
            $user->user_email = $request->input('email');
            // create new token and then send to email
            $data = [
                'subject' => 'Email Verification',
                'markdown' => 'mails.verify-email',
            ];
            MailHelper::send_token_to_user($user,'email_verification',$data);
        }
        $user->save();

        return redirect()
            ->route('profile')
            ->with('type', 'success')
            ->with('message', 'Profile updated');
    }

    public function change_password()
    {
        $user = User::findOrFail(auth('web')->user()->id);
        $data = [
            'title' => 'Change Password',
            'breadcumbs' => [
                ['text' => 'Dashboard', 'status' => null, 'link' => route('dashboard')],
                ['text' => 'Profile', 'status' => null, 'link' => route('profile')],
                ['text' => 'Change Password', 'status' => 'active', 'link' => '#'],
            ],
            'user' => $user,
        ];
        return view('contents.profile.change-password', $data);
    }

    public function save_password(Request $request)
    {
        $id = auth('web')->user()->id;
        $this->validate($request, [
            'old_password' => 'required',
            'password' => 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])./',
            'confirm_password' => 'same:password',
        ]);

        $user = User::findOrFail($id);
        if(!Hash::check($request->input('old_password'), $user->user_password)){
            return redirect()
                ->route('profile.change.password')
                ->with('type', 'warning')
                ->with('message', 'Old password incorrect');
        }

        $user->user_password = Hash::make($request->input('password'));
        $user->save();

        return redirect()
            ->route('profile')
            ->with('type', 'success')
            ->with('message', 'Change password successfully');
    }
}
