<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    public function show ($id) {
        $target_user = User::find($id);

        return view('website.profile', compact('target_user'));
    }

    public function update (Request $request, $id) {
        $request->validate([
            'name'      => ['required'],
            'phone'     => ['required', "unique:users,phone,$id"],
            'email'     => ['required', "unique:users,email,$id"],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $target_user = User::find($id);

        $data = $request->all();

        $data['password'] = bcrypt($request->password);
        $target_user->update($data);
        
        session()->flash('success', 'تم تحديث بيانات المستخدم');
        return redirect()->back();
    }
}
