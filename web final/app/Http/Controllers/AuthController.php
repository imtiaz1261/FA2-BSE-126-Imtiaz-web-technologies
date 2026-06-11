<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'role' => ['required', Rule::in(['user', 'worker'])],
            'category' => ['nullable', 'required_if:role,worker', 'string', 'max:255'],
            'experience' => ['nullable', 'required_if:role,worker', 'integer', 'min:0'],
            'hourly_rate' => ['nullable', 'required_if:role,worker', 'numeric', 'min:0'],
            'address' => ['nullable', 'required_if:role,worker', 'string'],
            'lat' => ['nullable', 'numeric'],
            'lng' => ['nullable', 'numeric'],
            'bio' => ['nullable', 'string'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => strtolower($data['email']),
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'category' => $data['category'] ?? null,
            'experience' => $data['experience'] ?? null,
            'hourly_rate' => $data['hourly_rate'] ?? null,
            'address' => $data['address'] ?? null,
            'lat' => $data['lat'] ?? null,
            'lng' => $data['lng'] ?? null,
            'rating' => 4.5,
            'bio' => $data['bio'] ?? null,
            'portfolio' => $data['role'] === 'worker'
                ? ['Recent Project 1', 'Recent Project 2', 'Recent Project 3']
                : null,
        ]);

        if ($user->role === 'worker') {
            Service::create([
                'worker_id' => $user->id,
                'title' => $user->category . ' Home Service',
                'category' => $user->category,
                'price' => max((float) $user->hourly_rate, 10),
                'rating' => $user->rating,
                'description' => $user->name . ' offering ' . strtolower($user->category) . ' services near ' . $user->address . '.',
            ]);
        }

        $token = $user->createToken('frontend-token')->plainTextToken;

        return response()->json([
            'message' => 'Signup successful.',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', strtolower($data['email']))->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid email or password.',
            ], 401);
        }

        $token = $user->createToken('frontend-token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful.',
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function me(Request $request)
    {
        return response()->json([
            'user' => $request->user(),
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout successful.',
        ]);
    }
}
