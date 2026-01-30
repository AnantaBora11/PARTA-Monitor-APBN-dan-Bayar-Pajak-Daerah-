<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\ContactMessage;
use App\Models\Project;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $cards = Card::latest()->get();
        $about = Setting::firstOrCreate(
            ['key' => 'about_us'],
            ['value' => 'Default about us content.']
        );
        $projects = Project::all();
        
        return view('homepage.home', compact('cards', 'about', 'projects'));
    }

    public function storeContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        ContactMessage::create($request->all());

        return redirect('/#contact')->with('success', 'Message sent successfully! We will get back to you soon.');
    }
}
