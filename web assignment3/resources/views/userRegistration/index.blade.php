@extends('layouts.app')

@section('title', 'Dashboard - Smart Profile Management System')

@section('content')
<div class="w-100">
    <!-- Hero Section -->
    <div class="hero-section text-center">
        <h1>
            <i class="bi bi-person-circle me-2"></i>
            Smart Profile Management System
        </h1>
        <p class="mb-0">Manage user profiles with a clean and modern Laravel dashboard</p>
    </div>

    <!-- Summary Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="summary-card">
                <div class="summary-card-icon text-primary">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="summary-card-number">{{ $totalUsers ?? 0 }}</div>
                <div class="summary-card-label">Total Users</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="summary-card">
                <div class="summary-card-icon text-success">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div class="summary-card-number">{{ $activeUsers ?? 0 }}</div>
                <div class="summary-card-label">Active Users</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="summary-card">
                <div class="summary-card-icon text-info">
                    <i class="bi bi-calendar-event"></i>
                </div>
                <div class="summary-card-number">{{ $latestRegistration ?? 'N/A' }}</div>
                <div class="summary-card-label">Latest Registration</div>
            </div>
        </div>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="alert alert-custom alert-success-custom alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2"></i>
                <strong>{{ session('success') }}</strong>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Two Column Layout: Form & Table -->
    <div class="row g-4">

        <!-- LEFT COLUMN: Add New User Form -->
        <div class="col-12 col-lg-4">
            <div class="card-modern">
                <div class="card-header">
                    <i class="bi bi-person-plus me-2"></i>Add New User
                </div>
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Name Field -->
                        <div class="mb-4">
                            <label for="name" class="form-label">
                                <i class="bi bi-person me-2 text-primary"></i>Full Name
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" placeholder="Enter full name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="mb-4">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope me-2 text-primary"></i>Email Address
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" placeholder="user@example.com" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- CNIC Field -->
                        <div class="mb-4">
                            <label for="cnic" class="form-label">
                                <i class="bi bi-card-text me-2 text-primary"></i>CNIC
                            </label>
                            <input type="text" class="form-control @error('cnic') is-invalid @enderror"
                                   id="cnic" name="cnic" placeholder="CNIC number" value="{{ old('cnic') }}" required>
                            @error('cnic')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Telephone Field -->
                        <div class="mb-4">
                            <label for="telephone" class="form-label">
                                <i class="bi bi-telephone me-2 text-primary"></i>Telephone
                            </label>
                            <input type="text" class="form-control @error('telephone') is-invalid @enderror"
                                   id="telephone" name="telephone" placeholder="Phone number" value="{{ old('telephone') }}" required>
                            @error('telephone')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Comments Field -->
                        <div class="mb-4">
                            <label for="comments" class="form-label">
                                <i class="bi bi-chat-left-text me-2 text-primary"></i>Comments
                            </label>
                            <textarea class="form-control @error('comments') is-invalid @enderror"
                                      id="comments" name="comments" rows="3" placeholder="Add comments (optional)">{{ old('comments') }}</textarea>
                            @error('comments')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Profile Picture Field -->
                        <div class="mb-4">
                            <label for="profile_picture" class="form-label">
                                <i class="bi bi-image me-2 text-primary"></i>Profile Picture
                            </label>
                            <input type="file" class="form-control @error('profile_picture') is-invalid @enderror"
                                   id="profile_picture" name="profile_picture" accept="image/*" required
                                   onchange="previewImage(this, 'imagePreview')">
                            <small class="text-muted d-block mt-2">
                                <i class="bi bi-info-circle me-1"></i>Allowed: JPG, PNG, WebP (Max 2MB)
                            </small>
                            <img id="imagePreview" class="image-preview" alt="Preview">
                            @error('profile_picture')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="d-grid gap-2 d-sm-flex">
                            <button type="submit" class="btn btn-primary-modern btn-modern flex-grow-1">
                                <i class="bi bi-check-circle me-2"></i>Add User
                            </button>
                            <button type="reset" class="btn btn-secondary-modern btn-modern">
                                <i class="bi bi-arrow-clockwise me-2"></i>Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: User Listing Table -->
        <div class="col-12 col-lg-8">
            <div class="card-modern">
                <div class="card-header">
                    <i class="bi bi-table me-2"></i>User Listings
                </div>
                <div class="card-body p-0">

                    <!-- Search Box -->
                    <div class="p-4 border-bottom">
                        <form method="GET" action="{{ route('users.index') }}" class="search-box">
                            <input type="text" name="email" value="{{ old('email', $email ?? '') }}" class="form-control"
                                   placeholder="Search by email..." required>
                            <button type="submit" class="btn btn-info-modern btn-modern">
                                <i class="bi bi-search"></i>
                            </button>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary-modern btn-modern">
                                <i class="bi bi-arrow-clockwise"></i>
                            </a>
                        </form>
                    </div>

                    <!-- Table or Empty State -->
                    @if($users->isEmpty())
                        <div class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <h5 class="mt-3">No Users Found</h5>
                            <p class="text-muted mb-0">
                                @if(isset($email) && $email)
                                    No user found with email "{{ $email }}"
                                @else
                                    No users in the system yet. Add your first user to get started!
                                @endif
                            </p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-modern mb-0">
                                <thead>
                                    <tr>
                                        <th class="col-photo">Photo</th>
                                        <th class="col-name">Name</th>
                                        <th class="col-email">Email</th>
                                        <th class="col-cnic">CNIC</th>
                                        <th class="col-telephone">Telephone</th>
                                        <th>Status</th>
                                        <th class="col-actions">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>
                                                @if($user->profile_picture && file_exists(public_path('uploads/' . $user->profile_picture)))
                                                    <img src="{{ asset('uploads/' . $user->profile_picture) }}" alt="{{ $user->name }}"
                                                         class="avatar-circular" title="{{ $user->name }}">
                                                @else
                                                    <div class="avatar-circular d-inline-flex align-items-center justify-content-center"
                                                         style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                                        <i class="bi bi-person text-white" style="font-size: 1.5rem;"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <strong class="text-dark">{{ $user->name }}</strong><br>
                                                <small class="text-muted">Created: {{ $user->created_at->format('M d, Y') }}</small>
                                            </td>
                                            <td>
                                                <small>{{ $user->email }}</small>
                                            </td>
                                            <td>
                                                <small>{{ $user->cnic }}</small>
                                            </td>
                                            <td>
                                                <small>{{ $user->telephone }}</small>
                                            </td>
                                            <td>
                                                <span class="badge badge-custom badge-active">
                                                    <i class="bi bi-check-circle me-1"></i>Active
                                                </span>
                                            </td>
                                            <td class="td-actions">
                                                <div class="d-flex align-items-center justify-content-center gap-2">
                                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-primary action-btn" title="View">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-success action-btn" title="Edit">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" onclick="confirmDeleteForm('delete-form-{{ $user->id }}')" class="btn btn-sm btn-danger action-btn" title="Delete">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>

@section('extra-js')
<script>
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Delete confirmation
    function confirmDelete(userId, userName) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'This user record will be permanently deleted.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm' + userId).submit();
            }
        });
    }
</script>
@endsection

@endsection
