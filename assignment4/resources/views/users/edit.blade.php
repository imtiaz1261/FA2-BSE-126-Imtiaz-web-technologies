@extends('layouts.app')

@section('title', 'Edit User - ' . $userRegistration->name)

@section('content')
<div class="row justify-content-center">
  <div class="col-12 col-xxl-11">
    <!-- Header Card -->
    <div class="card border-0 shadow-soft mb-5">
      <div class="card-body p-4 p-lg-5">
        <nav aria-label="breadcrumb" class="mb-4">
          <ol class="breadcrumb mb-0 bg-transparent p-0">
            <li class="breadcrumb-item">
              <a href="{{ route('users.index') }}" class="text-primary text-decoration-none fw-semibold">
                <i class="bi bi-house-door me-1"></i>Dashboard
              </a>
            </li>
            <li class="breadcrumb-item">
              <a href="{{ route('users.index') }}" class="text-primary text-decoration-none fw-semibold">
                <i class="bi bi-list-ul me-1"></i>User List
              </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
              <i class="bi bi-pencil-square me-1"></i>Edit User
            </li>
          </ol>
        </nav>

        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start gap-4">
          <div class="flex-grow-1">
            <div class="page-kicker text-primary fw-semibold mb-2">User Profile Management</div>
            <h1 class="h2 mb-2">Update User Details</h1>
            <p class="text-secondary mb-0">Edit the user information, update the profile picture, and save all changes securely.</p>
          </div>

          <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-icon btn-lg">
            <i class="bi bi-arrow-left"></i>
            Back to List
          </a>
        </div>
      </div>
    </div>

    <!-- Main Form -->
    <form action="{{ route('users.update', ['user' => $userRegistration->id]) }}" method="POST" enctype="multipart/form-data" id="editUserForm" novalidate>
      @csrf
      @method('PUT')

      <div class="row g-4 align-items-start">
        <!-- Left Column: Form Fields -->
        <div class="col-lg-8">
          <div class="card border-0 shadow-soft h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 px-lg-5 pb-0">
              <div class="d-flex align-items-center justify-content-between gap-3 mb-4">
                <div>
                  <h2 class="h5 mb-1">
                    <i class="bi bi-person-fill text-primary me-2"></i>User Information
                  </h2>
                  <p class="text-secondary small mb-0">Fields marked with <span class="text-danger fw-bold">*</span> are required.</p>
                </div>
                <span class="badge text-bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-2">
                  <i class="bi bi-clock me-1"></i>Last updated: {{ $userRegistration->updated_at->diffForHumans() }}
                </span>
              </div>
            </div>

            <div class="card-body p-4 p-lg-5">
              <!-- Name Field -->
              <div class="row g-4">
                <div class="col-md-6">
                  <label for="name" class="form-label fw-semibold">
                    Full Name <span class="text-danger">*</span>
                  </label>
                  <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $userRegistration->name) }}"
                    class="form-control form-control-lg @error('name') is-invalid @enderror"
                    placeholder="Enter full name"
                    required
                  >
                  @error('name')
                    <div class="invalid-feedback d-block mt-2">
                      <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                  @enderror
                </div>

                <!-- Email Field -->
                <div class="col-md-6">
                  <label for="email" class="form-label fw-semibold">
                    Email Address <span class="text-danger">*</span>
                  </label>
                  <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', $userRegistration->email) }}"
                    class="form-control form-control-lg @error('email') is-invalid @enderror"
                    placeholder="name@example.com"
                    required
                  >
                  @error('email')
                    <div class="invalid-feedback d-block mt-2">
                      <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                  @enderror
                </div>

                <!-- CNIC Field -->
                <div class="col-md-6">
                  <label for="cnic" class="form-label fw-semibold">
                    CNIC <span class="text-danger">*</span>
                  </label>
                  <input
                    type="text"
                    id="cnic"
                    name="cnic"
                    value="{{ old('cnic', $userRegistration->cnic) }}"
                    class="form-control form-control-lg @error('cnic') is-invalid @enderror"
                    placeholder="XXXXX-XXXXXXX-X"
                    required
                  >
                  @error('cnic')
                    <div class="invalid-feedback d-block mt-2">
                      <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                  @enderror
                </div>

                <!-- Telephone Field -->
                <div class="col-md-6">
                  <label for="telephone" class="form-label fw-semibold">
                    Telephone <span class="text-danger">*</span>
                  </label>
                  <input
                    type="text"
                    id="telephone"
                    name="telephone"
                    value="{{ old('telephone', $userRegistration->telephone) }}"
                    class="form-control form-control-lg @error('telephone') is-invalid @enderror"
                    placeholder="03XX-XXXXXXX"
                    required
                  >
                  @error('telephone')
                    <div class="invalid-feedback d-block mt-2">
                      <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                  @enderror
                </div>

                <!-- Comments Field -->
                <div class="col-12">
                  <label for="comments" class="form-label fw-semibold">
                    Comments <span class="text-secondary">(Optional)</span>
                  </label>
                  <textarea
                    id="comments"
                    name="comments"
                    rows="4"
                    class="form-control @error('comments') is-invalid @enderror"
                    placeholder="Add any additional notes or remarks about this user..."
                  >{{ old('comments', $userRegistration->comments) }}</textarea>
                  <div class="form-text mt-2">Max 500 characters. Use this field for special notes or observations.</div>
                  @error('comments')
                    <div class="invalid-feedback d-block">
                      <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                  @enderror
                </div>

                <!-- Profile Picture Upload -->
                <div class="col-12">
                  <label for="profile_picture" class="form-label fw-semibold">
                    Profile Picture <span class="text-secondary">(Optional)</span>
                  </label>
                  <div class="input-group input-group-lg">
                    <input
                      type="file"
                      id="profile_picture"
                      name="profile_picture"
                      accept="image/png,image/jpeg,image/jpg,image/webp"
                      class="form-control @error('profile_picture') is-invalid @enderror"
                      aria-label="Upload profile picture"
                      data-preview-target="#profilePreviewImage"
                      data-preview-placeholder="#profilePreviewPlaceholder"
                    >
                    <span class="input-group-text bg-white">
                      <i class="bi bi-cloud-arrow-up text-primary"></i>
                    </span>
                  </div>
                  <div class="form-text mt-2">
                    Leave empty to keep the current image. Allowed formats: JPG, JPEG, PNG, WebP. Maximum size: 2 MB.
                  </div>
                  @error('profile_picture')
                    <div class="invalid-feedback d-block mt-2">
                      <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                  @enderror
                </div>

                <!-- Action Buttons -->
                <div class="col-12 pt-4">
                  <div class="d-flex flex-column flex-sm-row gap-3">
                    <button type="submit" class="btn btn-primary btn-lg btn-icon" id="submitBtn">
                      <i class="bi bi-check2-circle"></i>
                      Save Changes
                    </button>

                    <button type="reset" class="btn btn-outline-secondary btn-lg btn-icon">
                      <i class="bi bi-arrow-clockwise"></i>
                      Reset Form
                    </button>

                    <a href="{{ route('users.index') }}" class="btn btn-light btn-lg btn-icon">
                      <i class="bi bi-x-circle"></i>
                      Cancel
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Right Column: Image Preview & Sidebar -->
        <div class="col-lg-4">
          <!-- Current Photo Card -->
          <div class="card border-0 shadow-soft mb-4 sticky-top" style="top: 80px;">
            <div class="card-body p-0 overflow-hidden">
              <div class="bg-gradient-primary-soft p-4 border-bottom">
                <div class="d-flex align-items-center gap-3">
                  <div class="icon-badge bg-primary-subtle text-primary fs-5">
                    <i class="bi bi-image"></i>
                  </div>
                  <div class="flex-grow-1">
                    <h3 class="h6 mb-0 fw-bold">Photo Preview</h3>
                    <p class="text-secondary small mb-0">Current & new image</p>
                  </div>
                </div>
              </div>

              <div class="p-4">
                <div class="profile-preview d-flex flex-column justify-content-center align-items-center text-center p-5 mb-3">
                  @if($userRegistration->profile_picture)
                    <div id="profilePreviewPlaceholder" class="profile-placeholder d-none">
                      <i class="bi bi-image display-4 d-block mb-3 text-secondary"></i>
                      <div class="fw-semibold text-secondary">No preview yet</div>
                    </div>
                    <img
                      id="profilePreviewImage"
                      src="{{ asset('uploads/' . $userRegistration->profile_picture) }}"
                      alt="Profile picture of {{ $userRegistration->name }}"
                      class="avatar-lg rounded-circle border border-4 border-white shadow-lg"
                      style="object-fit: cover; max-width: 150px; height: 150px;"
                    >
                  @else
                    <div id="profilePreviewPlaceholder" class="profile-placeholder">
                      <i class="bi bi-person-circle display-4 d-block mb-3 text-secondary"></i>
                      <div class="fw-semibold text-secondary">No profile picture</div>
                      <div class="small text-secondary">Upload a photo to preview</div>
                    </div>
                    <img
                      id="profilePreviewImage"
                      alt="Profile picture preview"
                      class="avatar-lg rounded-circle d-none border border-4 border-white shadow-lg"
                      style="object-fit: cover; max-width: 150px; height: 150px;"
                    >
                  @endif
                </div>

                <div class="alert alert-info alert-sm border-0" role="alert">
                  <i class="bi bi-info-circle me-2"></i>
                  <small>Select a new image to preview it here before saving.</small>
                </div>
              </div>
            </div>
          </div>

          <!-- User Info Card -->
          <div class="card border-0 shadow-soft">
            <div class="card-header bg-white border-0 px-4 py-3">
              <h3 class="h6 mb-0 fw-bold">
                <i class="bi bi-info-circle text-primary me-2"></i>User Summary
              </h3>
            </div>
            <div class="card-body p-4">
              <dl class="row mb-0 gap-3">
                <dt class="col-12">
                  <small class="text-secondary text-uppercase fw-semibold">Registered</small>
                </dt>
                <dd class="col-12 mb-0">
                  <i class="bi bi-calendar3 me-2 text-primary"></i>{{ $userRegistration->created_at->format('M d, Y') }}
                </dd>

                <dt class="col-12">
                  <small class="text-secondary text-uppercase fw-semibold">Last Modified</small>
                </dt>
                <dd class="col-12 mb-0">
                  <i class="bi bi-clock-history me-2 text-primary"></i>{{ $userRegistration->updated_at->format('M d, Y H:i') }}
                </dd>

                <dt class="col-12">
                  <small class="text-secondary text-uppercase fw-semibold">Record ID</small>
                </dt>
                <dd class="col-12 mb-0">
                  <code class="text-secondary">#{{ $userRegistration->id }}</code>
                </dd>
              </dl>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Image Preview Handler
    const previewInput = document.getElementById('profile_picture');
    if (previewInput) {
      previewInput.addEventListener('change', function () {
        const file = this.files && this.files[0];
        if (!file) return;

        const previewImage = document.getElementById('profilePreviewImage');
        const previewPlaceholder = document.getElementById('profilePreviewPlaceholder');
        const objectUrl = URL.createObjectURL(file);

        previewImage.src = objectUrl;
        previewImage.classList.remove('d-none');
        if (previewPlaceholder) {
          previewPlaceholder.classList.add('d-none');
        }

        previewImage.addEventListener('load', function () {
          URL.revokeObjectURL(objectUrl);
        }, { once: true });
      });
    }

    // Form Submit Confirmation
    const editForm = document.getElementById('editUserForm');
    if (editForm) {
      editForm.addEventListener('submit', function (e) {
        const hasChanges = Array.from(editForm.elements).some(el => {
          if (el.name === '_token' || el.name === '_method') return false;
          if (el.type === 'file') return el.value;
          if (el.type === 'hidden') return false;
          return el.value !== (el.defaultValue || '');
        });

        if (!hasChanges) {
          e.preventDefault();
          alert('No changes detected. Please modify at least one field before saving.');
          return false;
        }
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

  .form-control-lg, .form-select-lg {
    padding: 0.85rem 1rem;
    font-size: 0.95rem;
  }

  .avatar-lg {
    width: 150px;
    height: 150px;
    object-fit: cover;
  }

  .profile-preview {
    min-height: 220px;
    border: 2px dashed rgba(21, 94, 239, 0.18);
    border-radius: 1.25rem;
    background: linear-gradient(135deg, #f8fbff 0%, #eff6ff 100%);
  }

  .page-kicker {
    letter-spacing: 0.12em;
    text-transform: uppercase;
    font-size: 0.75rem;
  }

  .bg-gradient-primary-soft {
    background: linear-gradient(135deg, rgba(21, 94, 239, 0.08), rgba(14, 165, 233, 0.05));
  }

  .alert-sm {
    padding: 0.6rem 0.9rem;
    font-size: 0.85rem;
    margin-bottom: 0;
  }

  .sticky-top {
    z-index: 99;
  }

  @media (max-width: 991.98px) {
    .sticky-top {
      position: static;
    }
  }
</style>
@endpush
