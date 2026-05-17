@extends('layouts.app')

@section('title', 'User Management Dashboard')

@section('content')
@php
  $resultCount = $users->count();
@endphp

<div class="row g-4 mb-5">
  <!-- Page Header Card -->
  <div class="col-12">
    <div class="card border-0 shadow-soft">
      <div class="card-body p-4 p-lg-5">
        <div class="d-flex flex-column flex-xl-row justify-content-between align-items-start gap-4">
          <div class="flex-grow-1">
            <div class="page-kicker text-primary fw-semibold mb-2">Dashboard</div>
            <h1 class="h2 mb-2">User Management Dashboard</h1>
            <p class="text-secondary mb-0">Browse, search, edit, and manage all user registrations from a modern responsive interface.</p>
          </div>

          <div class="d-flex flex-column flex-sm-row gap-2">
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-lg btn-icon">
              <i class="bi bi-person-plus"></i>
              Add User
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Stats Cards -->
  <div class="col-md-6 col-xl-4">
    <div class="card border-0 shadow-soft h-100">
      <div class="card-body p-4">
        <div class="d-flex align-items-center justify-content-between gap-3">
          <div>
            <div class="text-secondary small mb-1 fw-semibold text-uppercase">Records Visible</div>
            <div class="display-6 fw-bold text-primary">{{ $resultCount }}</div>
          </div>
          <div class="icon-badge bg-primary-subtle text-primary fs-4">
            <i class="bi bi-people"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-6 col-xl-4">
    <div class="card border-0 shadow-soft h-100">
      <div class="card-body p-4">
        <div class="d-flex align-items-center justify-content-between gap-3">
          <div>
            <div class="text-secondary small mb-1 fw-semibold text-uppercase">Total Registered</div>
            <div class="display-6 fw-bold text-success">{{ $totalUsers }}</div>
          </div>
          <div class="icon-badge bg-success-subtle text-success fs-4">
            <i class="bi bi-person-check"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-xl-4">
    <div class="card border-0 shadow-soft h-100">
      <div class="card-body p-4">
        <div class="d-flex align-items-center gap-3">
          <div class="icon-badge bg-info-subtle text-info fs-4">
            <i class="bi bi-calendar3"></i>
          </div>
          <div>
            <div class="text-secondary small mb-1 fw-semibold text-uppercase">Latest Registration</div>
            <div class="fw-bold">{{ $latestRegistration }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Search Card -->
<div class="card border-0 shadow-soft mb-5" id="search-card">
  <div class="card-body p-4 p-lg-5">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start gap-4 mb-4">
      <div>
        <h2 class="h5 mb-1">
          <i class="bi bi-search text-primary me-2"></i>Search User
        </h2>
        <p class="text-secondary small mb-0">Filter users by email address to quickly find specific records.</p>
      </div>

      @if($email)
        <span class="badge text-bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-2">
          <i class="bi bi-funnel me-1"></i>Active filter: {{ $email }}
        </span>
      @endif
    </div>

    <form method="GET" action="{{ route('users.index') }}" class="row g-3 align-items-end">
      <div class="col-lg-7">
        <label for="email" class="form-label fw-semibold">Search by email address</label>
        <div class="input-group input-group-lg">
          <span class="input-group-text bg-white border-end">
            <i class="bi bi-search text-primary"></i>
          </span>
          <input
            type="email"
            id="email"
            name="email"
            value="{{ $email ?? '' }}"
            class="form-control"
            placeholder="Enter email to search"
          >
        </div>
      </div>

      <div class="col-lg-5">
        <div class="d-flex flex-column flex-sm-row gap-2">
          <button type="submit" class="btn btn-primary btn-lg btn-icon flex-grow-1 justify-content-center">
            <i class="bi bi-search"></i>
            Search
          </button>
          <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-lg btn-icon flex-grow-1 justify-content-center">
            <i class="bi bi-x-circle"></i>
            Clear
          </a>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- User List Card -->
<div class="card border-0 shadow-soft">
  <div class="card-header bg-white border-0 px-4 px-lg-5 pt-4 pb-0">
    <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start gap-3">
      <div>
        <h2 class="h5 mb-1">
          <i class="bi bi-list-ul text-primary me-2"></i>User Listing
        </h2>
        <p class="text-secondary small mb-0">Responsive table with advanced actions, hover states, and pagination support.</p>
      </div>

      <div class="d-flex flex-wrap gap-2">
        <span class="badge text-bg-light border rounded-pill px-3 py-2">{{ $resultCount }} record(s)</span>
        @if($email)
          <span class="badge text-bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-2">
            <i class="bi bi-funnel me-1"></i>Filtered results
          </span>
        @endif
      </div>
    </div>
  </div>

  <div class="card-body p-0 p-lg-4">
    @if($users->isEmpty())
      <div class="p-5 text-center">
        <div class="mx-auto mb-4 icon-badge bg-primary-subtle text-primary fs-2">
          <i class="bi bi-inbox"></i>
        </div>
        <h3 class="h5 mb-2">No users found</h3>
        <p class="text-secondary mb-4">
          @if($email)
            No records matched the searched email address "{{ $email }}".
          @else
            There are no user records in the system yet. Add your first user to get started.
          @endif
        </p>
        <div class="d-flex flex-column flex-sm-row justify-content-center gap-2">
          <a href="{{ route('users.create') }}" class="btn btn-primary btn-lg btn-icon">
            <i class="bi bi-person-plus"></i>
            Add First User
          </a>
          @if($email)
            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-lg btn-icon">
              <i class="bi bi-arrow-counterclockwise"></i>
              Reset Search
            </a>
          @endif
        </div>
      </div>
    @else
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead>
            <tr>
              <th scope="col" style="width: 70px;">Photo</th>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col" class="d-none d-md-table-cell">CNIC</th>
              <th scope="col" class="d-none d-lg-table-cell">Telephone</th>
              <th scope="col" class="d-none d-xl-table-cell">Comments</th>
              <th scope="col" class="text-nowrap" style="width: 200px;">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
              <tr>
                <td>
                  @if($user->profile_picture)
                    <img
                      src="{{ asset('uploads/' . $user->profile_picture) }}"
                      alt="Profile picture of {{ $user->name }}"
                      class="avatar rounded-circle border border-2 border-white shadow-sm"
                      style="width: 52px; height: 52px; object-fit: cover;"
                    >
                  @else
                    <div class="avatar rounded-circle d-flex align-items-center justify-content-center text-primary fw-bold bg-light" style="width: 52px; height: 52px; font-size: 1.2rem;">
                      <i class="bi bi-person-fill"></i>
                    </div>
                  @endif
                </td>
                <td>
                  <div class="fw-semibold text-dark">{{ $user->name }}</div>
                  <div class="small text-secondary">ID: #{{ $user->id }}</div>
                </td>
                <td>
                  <div class="text-secondary">{{ $user->email }}</div>
                </td>
                <td class="d-none d-md-table-cell">
                  <div class="text-secondary">{{ $user->cnic }}</div>
                </td>
                <td class="d-none d-lg-table-cell">
                  <div class="text-secondary">{{ $user->telephone }}</div>
                </td>
                <td class="d-none d-xl-table-cell">
                  <span class="d-inline-block text-truncate text-secondary" style="max-width: 280px;" title="{{ $user->comments ?? 'No comments' }}">
                    {{ $user->comments ?: '—' }}
                  </span>
                </td>
                <td class="text-nowrap">
                  <div class="d-flex flex-wrap gap-2">
                    <a
                      href="{{ route('users.edit', $user) }}"
                      class="btn btn-sm btn-outline-primary btn-icon"
                      title="Edit user"
                    >
                      <i class="bi bi-pencil-square"></i>
                      <span class="d-none d-sm-inline">Edit</span>
                    </a>

                    <button
                      type="button"
                      class="btn btn-sm btn-outline-danger btn-icon"
                      title="Delete user"
                      data-bs-toggle="modal"
                      data-bs-target="#deleteUserModal"
                      data-user-id="{{ $user->id }}"
                      data-user-name="{{ $user->name }}"
                      data-user-email="{{ $user->email }}"
                    >
                      <i class="bi bi-trash"></i>
                      <span class="d-none d-sm-inline">Delete</span>
                    </button>
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

<!-- Delete Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-soft">
      <div class="modal-header border-0 pb-0">
        <div>
          <div class="icon-badge bg-danger-subtle text-danger mb-3">
            <i class="bi bi-exclamation-triangle"></i>
          </div>
          <h2 class="modal-title h5" id="deleteUserModalLabel">Delete User Confirmation</h2>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body pt-2">
        <p class="text-secondary mb-3">
          You are about to permanently delete the user <strong id="deleteUserName"></strong> with email <code id="deleteUserEmail"></code>.
        </p>
        <p class="text-secondary mb-0">
          <i class="bi bi-exclamation-diamond me-2"></i>
          This action cannot be undone. All associated data will be permanently removed.
        </p>
      </div>

      <div class="modal-footer border-0 pt-0">
        <form id="deleteUserForm" method="POST" style="width: 100%;">
          @csrf
          @method('DELETE')
          <div class="d-flex gap-2 w-100">
            <button type="button" class="btn btn-outline-secondary flex-grow-1" data-bs-dismiss="modal">
              Cancel
            </button>
            <button type="submit" class="btn btn-danger btn-icon flex-grow-1 justify-content-center">
              <i class="bi bi-trash"></i>
              Confirm Delete
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const deleteModal = document.getElementById('deleteUserModal');

    if (deleteModal) {
      deleteModal.addEventListener('show.bs.modal', function (event) {
        const trigger = event.relatedTarget;
        if (!trigger) return;

        const userId = trigger.getAttribute('data-user-id');
        const userName = trigger.getAttribute('data-user-name');
        const userEmail = trigger.getAttribute('data-user-email');

        // Update modal content
        document.getElementById('deleteUserName').textContent = userName;
        document.getElementById('deleteUserEmail').textContent = userEmail;

        // Update form action
        const form = document.getElementById('deleteUserForm');
        form.action = `{{ route('users.destroy', ':id') }}`.replace(':id', userId);
      });
    }
  });
</script>
@endpush

@push('styles')
<style>
  .btn-icon {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    white-space: nowrap;
  }

  .page-kicker {
    letter-spacing: 0.12em;
    text-transform: uppercase;
    font-size: 0.75rem;
  }

  .icon-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 0.95rem;
  }

  .avatar {
    object-fit: cover;
  }

  @media (max-width: 767.98px) {
    .d-none.d-md-table-cell {
      display: none !important;
    }
  }

  @media (max-width: 991.98px) {
    .d-none.d-lg-table-cell {
      display: none !important;
    }
  }

  @media (max-width: 1199.98px) {
    .d-none.d-xl-table-cell {
      display: none !important;
    }
  }
</style>
@endpush
