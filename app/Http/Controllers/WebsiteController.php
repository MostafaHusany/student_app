<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Message;
use App\Models\Meeting;
use App\Models\Comment;

class WebsiteController extends Controller
{
    public function home () {
        return view('website.home');
    }

    public function about () {
        return view('website.about');
    }

    public function contactus () {
        return view('website.contactus');
    }

    public function messages (Request $request) {
        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email'],
            'message' => ['required', 'max:1000'],
        ]);

        $data = $request->all();
        Message::create($data);

        session()->flash('success', 'تم ارسال رسالتك بنجاح');
        return redirect()->back();
    }

    public function doctors () {
        $doctors = User::where('category', 'doctor')->orderBy('id', 'desc')->get();

        return view('website.doctors', compact('doctors'));
    }

    public function show ($id) {
        $doctor     = User::where('category', 'doctor')->where('id', $id)->first();

        return view('website.show', compact('doctor'));
    }

    public function doctor_comment (Request $request, $id) {
        $request->validate([
            'comment' => 'required'
        ]);

        $data = [
            'user_id'   => auth()->user()->id,
            'doctor_id' => $id,
            'comment'   => $request->comment
        ];

        Comment::create($data);

        session()->flash('success', 'تم اضافة تعليق بنجاح');
        return redirect()->back();
    }

    public function destroy_comment ($id) {
        Comment::destroy($id);

        session()->flash('success', 'تم حذف التعليق بنجاج');
        return redirect()->back();
    }

    public function request_date (Request $request, $id) {
        $data = $request->all();
        
        $data['user_id']    = auth()->user()->id;
        $data['doctor_id']  = $id;

        $meetin = Meeting::create($data);

        session()->flash('success', 'تم ارسال طلب حجز معاد بنجاح');
        return redirect()->route('web.doctors.show', $id);
    }

}
