<?php

namespace App\Http\Controllers;

use App\Models\UserRegistration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserRegistrationController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->search;

        $users = UserRegistration::when($search, function ($query, $search) {
            return $query->where('email', 'LIKE', "%{$search}%");
        })->latest()->paginate(8);

        $totalUsers = UserRegistration::count();
        $activeUsers = UserRegistration::count();
        $latestUser = UserRegistration::latest()->first();

        return view('users.index', compact('users', 'search', 'totalUsers', 'activeUsers', 'latestUser'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:userRegistration,email',
            'cnic' => 'required|string|max:255',
            'telephone' => 'required|string|max:255',
            'comments' => 'nullable|string',
            'profile_picture' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['profile_picture'] = $this->storeProfilePicture($request);

        UserRegistration::create($validated);

        return redirect()->route('users.index')->with('success', 'User registered successfully.');
    }

    public function edit(string $id): View
    {
        $user = UserRegistration::findOrFail($id);

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $user = UserRegistration::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:userRegistration,email,' . $user->id,
            'cnic' => 'required|string|max:255',
            'telephone' => 'required|string|max:255',
            'comments' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            $this->deleteProfilePicture($user->profile_picture);
            $validated['profile_picture'] = $this->storeProfilePicture($request);
        } else {
            $validated['profile_picture'] = $user->profile_picture;
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $user = UserRegistration::findOrFail($id);

        $this->deleteProfilePicture($user->profile_picture);

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    private function storeProfilePicture(Request $request): ?string
    {
        if (! $request->hasFile('profile_picture')) {
            return null;
        }

        $file = $request->file('profile_picture');
        $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\.]/', '_', $file->getClientOriginalName());
        $file->move(public_path('uploads'), $fileName);

        return $fileName;
    }

    private function deleteProfilePicture(?string $fileName): void
    {
        if (! $fileName) {
            return;
        }

        $filePath = public_path('uploads/' . $fileName);

        if (file_exists($filePath)) {
            @unlink($filePath);
        }
    }
}
