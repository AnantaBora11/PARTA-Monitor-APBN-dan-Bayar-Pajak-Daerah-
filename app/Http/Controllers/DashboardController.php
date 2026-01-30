<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Setting;
use App\Models\ContactMessage;
use App\Models\Project;
use App\Models\Kendaraan;
use App\Models\PajakKendaraan;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $cards = Card::latest()->get();
        $about = Setting::firstOrCreate(
            ['key' => 'about_us'],
            ['value' => 'Default about us content.']
        );
        $messages = ContactMessage::latest()->get();
        $projects = Project::latest()->get();

        // APBD Analytics Data
        $totalAPBD = $projects->sum('budget');
        $budgetByType = Project::selectRaw('type, sum(budget) as total')
            ->groupBy('type')
            ->pluck('total', 'type');

        $projectsCntByType = Project::selectRaw('type, count(*) as total')
            ->groupBy('type')
            ->pluck('total', 'type');

        $activeProjectsCount = $projects->where('progress', '<', 100)->count();
        $completedProjectsCount = $projects->where('progress', 100)->count();
        
        // Monthly Project Progress (Line Chart Data)
        $monthlyProgress = Project::selectRaw("DATE_FORMAT(created_at, '%M') as month, AVG(progress) as avg_progress, MIN(created_at) as min_date")
            ->groupBy('month')
            ->orderBy('min_date')
            ->get();
            
        $monthlyProgressLabels = $monthlyProgress->pluck('month');
        $monthlyProgressValues = $monthlyProgress->pluck('avg_progress');
        
        // Kendaraan Data
        $vehicles = Kendaraan::with('pajak')->get();
        $totalVehicles = Kendaraan::count();
        $unpaidTaxesCount = PajakKendaraan::where('status_pembayaran', '!=', 'Lunas')->count();
        $totalFines = PajakKendaraan::where('status_pembayaran', '!=', 'Lunas')->sum('denda');
        
        // User Data
        $users = User::latest()->get();
        $totalUsers = $users->count();
        $adminCount = $users->where('role', 'admin')->count();
        $regularUserCount = $users->where('role', 'user')->count();

        return view('admin.dashboard', compact(
            'cards', 'about', 'messages', 'projects', 'totalAPBD', 'budgetByType', 
            'projectsCntByType', 'activeProjectsCount', 'completedProjectsCount', 
            'monthlyProgressLabels', 'monthlyProgressValues',
            'vehicles', 'totalVehicles', 'unpaidTaxesCount', 'totalFines',
            'users', 'totalUsers', 'adminCount', 'regularUserCount'
        ));
    }

    public function storeProject(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'budget' => 'required|numeric',
            'progress' => 'required|integer|min:0|max:100',
            'type' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('projects', 'public');
            $data['image'] = '/storage/' . $path;
        }

        Project::create($data);

        return redirect()->route('dashboard', ['section' => 'projects'])->with('success', 'Project added successfully!');
    }

    public function updateProject(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'budget' => 'required|numeric',
            'progress' => 'required|integer|min:0|max:100',
            'type' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'image' => 'nullable|image|max:2048',
        ]);

        $project = Project::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('projects', 'public');
            $data['image'] = '/storage/' . $path;
        }

        $project->update($data);

        return redirect()->route('dashboard', ['section' => 'projects'])->with('success', 'Project updated successfully!');
    }

    public function deleteProject($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('dashboard', ['section' => 'projects'])->with('success', 'Project deleted successfully!');
    }

    public function updateAbout(Request $request)
    {
        $request->validate([
            'about_us' => 'required|string'
        ]);

        Setting::updateOrCreate(
            ['key' => 'about_us'],
            ['value' => $request->about_us]
        );

        return redirect()->route('dashboard', ['section' => 'content'])->with('success', 'About Us updated successfully.');
    }

    public function storeCard(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048' // Max 2MB
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('cards', 'public');
            $data['image'] = '/storage/' . $path;
        }

        Card::create($data);

        return redirect()->route('dashboard', ['section' => 'content'])->with('success', 'Card created successfully.');
    }

    public function editCard(Card $card)
    {
        return view('admin.edit_card', compact('card'));
    }

    public function updateCard(Request $request, Card $card)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('cards', 'public');
            $data['image'] = '/storage/' . $path;
        }

        $card->update($data);

        return redirect()->route('dashboard', ['section' => 'content'])->with('success', 'Card updated successfully.');
    }

    public function deleteCard(Card $card)
    {
        $card->delete();
        return redirect()->route('dashboard', ['section' => 'content'])->with('success', 'Card deleted successfully.');
    }

    public function deleteMessage($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->delete();

        return redirect()->route('dashboard', ['section' => 'comments'])->with('success', 'Message deleted successfully.');
    }
}
