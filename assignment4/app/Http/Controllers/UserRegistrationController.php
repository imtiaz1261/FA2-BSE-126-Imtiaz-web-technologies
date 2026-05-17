<?php

namespace App\Http\Controllers;

use App\Models\UserRegistration;
use Illuminate\Http\Request;

class UserRegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = UserRegistration::query();

        $email = $request->get('email');
        if ($email) {
            
            $query->where('email', 'like', "%{$email}%");
        }

        $users = $query->orderBy('created_at', 'desc')->get();
        
        // Summary card data
        $totalUsers = UserRegistration::count();
        $activeUsers = UserRegistration::count(); // All are active in this system
        $latestRegistration = UserRegistration::latest('created_at')->first();
        $latestRegistrationDate = $latestRegistration ? $latestRegistration->created_at->format('M d, Y') : 'N/A';

        return view('users.index', [
            'users' => $users,
            'email' => $email,
            'totalUsers' => $totalUsers,
            'activeUsers' => $activeUsers,
            'latestRegistration' => $latestRegistrationDate,
        ]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:userRegistration,email',
            'cnic' => 'required|string|max:50',
            'telephone' => 'required|string|max:50',
            'comments' => 'nullable|string',
            'profile_picture' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $name = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.]/', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads'), $name);
            $validated['profile_picture'] = $name;
        }

        UserRegistration::create($validated);

        return redirect()->route('users.index')->with('success', 'User registered successfully. ✓');
    }

    public function edit(UserRegistration $userRegistration)
    {
        return view('users.edit', compact('userRegistration'));
    }

    public function update(Request $request, UserRegistration $userRegistration)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:userRegistration,email,' . $userRegistration->id,
            'cnic' => 'required|string|max:50',
            'telephone' => 'required|string|max:50',
            'comments' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            // delete old
            $old = public_path('uploads/') . $userRegistration->profile_picture;
            if ($userRegistration->profile_picture && file_exists($old)) {
                @unlink($old);
            }
            $file = $request->file('profile_picture');
            $name = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.]/', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads'), $name);
            $validated['profile_picture'] = $name;
        } else {
            $validated['profile_picture'] = $userRegistration->profile_picture;
        }

        $userRegistration->update($validated);

        return redirect()->route('users.index')->with('success', 'User updated successfully. ✓');
    }

    public function destroy(UserRegistration $userRegistration)
    {
        $old = public_path('uploads/') . $userRegistration->profile_picture;
        if ($userRegistration->profile_picture && file_exists($old)) {
            @unlink($old);
        }

        $userRegistration->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully. ✓');
    }
}
