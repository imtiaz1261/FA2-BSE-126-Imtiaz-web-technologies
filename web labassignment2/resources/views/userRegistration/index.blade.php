@extends('layouts.app')

@section('title', 'User List - User Management System')

@section('content')
<div class="container">
    <!-- Header Section -->
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <h1 class="h3 fw-bold text-dark mb-0">
                <i class="bi bi-people-fill text-primary me-2"></i>User Management
            </h1>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('userRegistration.create') }}" class="btn btn-primary btn-lg">
                <i class="bi bi-plus-circle me-2"></i>Add New User
            </a>
        </div>
    </div>

    <!-- Success Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2"></i>
                <strong>{{ session('success') }}</strong>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Search Card -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('userRegistration.index') }}" class="row g-3 align-items-end">
                <div class="col-lg-6">
                    <label class="form-label fw-bold text-dark">
                        <i class="bi bi-search text-primary me-2"></i>Search by Email
                    </label>
                    <div class="input-group input-group-lg">
                        <input type="text" name="email" value="{{ old('email', $email ?? '') }}" class="form-control" 
                               placeholder="Search user by email">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search me-1"></i>Search
                        </button>
                    </div>
                </div>
                <div class="col-lg-6 text-lg-end">
                    <a href="{{ route('userRegistration.index') }}" class="btn btn-outline-secondary btn-lg">
                        <i class="bi bi-arrow-clockwise me-1"></i>Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table Card -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-bottom p-4">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">
                    @if($users->isEmpty())
                        No Users Found
                    @else
                        Total Users: <span class="text-primary">{{ $users->count() }}</span>
                    @endif
                </h5>
            </div>
        </div>
        
        <div class="card-body p-0">
            @if($users->isEmpty())
                <!-- Empty State -->
                <div class="text-center py-5">
                    <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3 mb-0">
                        @if(isset($email) && $email)
                            No user found with the email "{{ $email }}"
                        @else
                            No users in the system yet. <a href="{{ route('userRegistration.create') }}">Add your first user</a>
                        @endif
                    </p>
                </div>
            @else
                <!-- Responsive Table -->
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">
                                    <span class="fw-bold text-dark">Photo</span>
                                </th>
                                <th class="px-4 py-3">
                                    <span class="fw-bold text-dark">Name</span>
                                </th>
                                <th class="px-4 py-3">
                                    <span class="fw-bold text-dark">Email</span>
                                </th>
                                <th class="px-4 py-3">
                                    <span class="fw-bold text-dark">CNIC</span>
                                </th>
                                <th class="px-4 py-3">
                                    <span class="fw-bold text-dark">Telephone</span>
                                </th>
                                <th class="px-4 py-3">
                                    <span class="fw-bold text-dark">Comments</span>
                                </th>
                                <th class="px-4 py-3 text-end">
                                    <span class="fw-bold text-dark">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr class="border-bottom">
                                    <td class="px-4 py-3">
                                        @if($user->profile_picture)
                                            <img src="/uploads/{{ $user->profile_picture }}" alt="{{ $user->name }}" 
                                                 class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;" 
                                                 title="{{ $user->name }}">
                                        @else
                                            <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 50px;">
                                                <i class="bi bi-person text-white"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="fw-bold text-dark">{{ $user->name }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-muted">{{ $user->email }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-muted">{{ $user->cnic }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-muted">{{ $user->telephone }}</span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-muted text-truncate d-inline-block" style="max-width: 150px;" title="{{ $user->comments }}">
                                            {{ $user->comments ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-end">
                                        <a href="{{ route('userRegistration.edit', $user) }}" class="btn btn-sm btn-info btn-icon me-2" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger btn-icon" title="Delete" 
                                                onclick="showDeleteModal({{ $user->id }}, '{{ $user->name }}')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        <form id="deleteForm-{{ $user->id }}" action="{{ route('userRegistration.destroy', $user) }}" 
                                              method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
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

@section('extra-js')
<script>
    let currentDeleteId = null;

    function showDeleteModal(userId, userName) {
        currentDeleteId = userId;
        document.getElementById('deleteUserName').textContent = userName;
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (currentDeleteId) {
            document.getElementById('deleteForm-' + currentDeleteId).submit();
        }
    });
</script>
@endsection

@endsection
