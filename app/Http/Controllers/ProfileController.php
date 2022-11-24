<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function create()
    {
        $user = Auth::user();

        return view('profile.form', compact('user'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'userName' =>  'required|string|min:1|max:254'
        ]);

        $user = Auth::user();
        $data = $request->except('_token');

        User::where('id', $user->id)
            ->update([
                'name' => $data['userName']
            ]);

        return redirect('/');
    }
}
