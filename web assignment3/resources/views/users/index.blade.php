@extends('layout')

@section('content')

<div class="hero-banner">
    <h1 class="hero-title">
        <i class="bi bi-person-circle"></i>
        Smart Profile Management System
    </h1>
    <p class="hero-subtitle">
        Manage user profiles with a clean and modern Laravel dashboard
    </p>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-4">
        <div class="stat-card">
            <i class="bi bi-people-fill text-primary"></i>
            <div class="stat-number">{{ $totalUsers }}</div>
            <div class="stat-label">Total Users</div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card">
            <i class="bi bi-check-circle-fill text-success"></i>
            <div class="stat-number">{{ $activeUsers }}</div>
            <div class="stat-label">Active Users</div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="stat-card">
            <i class="bi bi-calendar text-info"></i>
            <div class="stat-number">
                {{ $latestUser ? $latestUser->created_at->format('M d, Y') : 'No Data' }}
            </div>
            <div class="stat-label">Latest Registration</div>
        </div>
    </div>
</div>

<div class="row g-4 align-items-start">
    <div class="col-lg-4" id="add-user">
        <div class="dashboard-card">
            <div class="card-gradient-header">
                <i class="bi bi-person-plus"></i> Add New User
            </div>

            <div class="dashboard-card-body">
                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">
                            <i class="bi bi-person"></i> Full Name
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Enter full name">
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="bi bi-envelope"></i> Email Address
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="user@example.com">
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="cnic" class="form-label">
                            <i class="bi bi-card-text"></i> CNIC
                        </label>
                        <input type="text" name="cnic" value="{{ old('cnic') }}" class="form-control" placeholder="CNIC number">
                        @error('cnic') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="telephone" class="form-label">
                            <i class="bi bi-telephone"></i> Telephone
                        </label>
                        <input type="text" name="telephone" value="{{ old('telephone') }}" class="form-control" placeholder="Phone number">
                        @error('telephone') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="comments" class="form-label">
                            <i class="bi bi-chat-left-text"></i> Comments
                        </label>
                        <textarea name="comments" class="form-control" rows="3" placeholder="Additional notes (optional)">{{ old('comments') }}</textarea>
                        @error('comments') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="profile_picture" class="form-label">
                            <i class="bi bi-image"></i> Profile Picture
                        </label>
                        <input type="file" name="profile_picture" class="form-control" accept="image/*" onchange="previewImage(event)">
                        <small class="text-muted">Allowed: JPG, PNG, WebP (Max 2MB)</small>
                        @error('profile_picture') <br><small class="text-danger">{{ $message }}</small> @enderror

                        <img id="preview" class="preview-img d-none" alt="Preview">
                    </div>

                    <button type="submit" class="btn add-user-btn w-100">
                        <i class="bi bi-plus-circle"></i> Add User
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8" id="users">
        <div class="dashboard-card">
            <div class="card-gradient-header">
                <i class="bi bi-table"></i> User Listings
            </div>

            <div class="dashboard-card-body">
                <form action="{{ route('users.index') }}" method="GET" class="row g-2 mb-4">
                    <div class="col-md-10">
                        <input type="email" name="search" value="{{ request('search') }}" class="form-control search-input" placeholder="Search by email...">
                    </div>

                    <div class="col-md-1 d-grid">
                        <button class="btn btn-primary">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>

                    <div class="col-md-1 d-grid">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table custom-table align-middle">
                        <thead>
                            <tr>
                                <th class="photo-column">Photo</th>
                                <th class="name-column">Name</th>
                                <th>Email</th>
                                <th>CNIC</th>
                                <th>Telephone</th>
                                <th>Status</th>
                                <th class="actions-column">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>
                                        <div class="avatar-wrapper">
                                            @if($user->profile_picture)
                                                <img src="{{ asset('uploads/' . $user->profile_picture) }}" class="user-avatar" alt="User avatar">
                                            @else
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=4f6df5&color=fff" class="user-avatar" alt="Default Avatar">
                                            @endif
                                        </div>
                                    </td>

                                    <td>
                                        <strong>{{ $user->name }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            Created: {{ $user->created_at->format('M d, Y') }}
                                        </small>
                                    </td>

                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->cnic }}</td>
                                    <td>{{ $user->telephone }}</td>

                                    <td>
                                        <span class="active-badge">
                                            <i class="bi bi-check-circle"></i> Active
                                        </span>
                                    </td>

                                    <td class="actions-column">
                                        <div class="action-buttons">
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-success btn-sm action-btn">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>

                                            <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')

                                                <button type="button" onclick="confirmDelete('delete-form-{{ $user->id }}')" class="btn btn-danger btn-sm action-btn">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="bi bi-person-x display-5 text-muted"></i>
                                        <h5 class="mt-3">No users found</h5>
                                        <p class="text-muted mb-0">Try searching another email or add a new user.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

