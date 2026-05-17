@extends('layouts.app')

@section('title', 'Edit User - Smart Profile Management System')

@section('content')
<div class="container-lg py-4">
    <!-- Header -->
    <div class="mb-5">
        <a href="{{ route('users.index') }}" class="text-decoration-none mb-3 d-inline-block">
            <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
        </a>
        <h1 class="h2 fw-700 text-dark mb-2">
            <i class="bi bi-pencil-square me-2 text-primary"></i>Edit User Profile
        </h1>
        <p class="text-muted mb-0">Update user information for {{ $user->name }}</p>
    </div>

    <!-- Error Alert -->
    @if($errors->any())
        <div class="alert alert-custom alert-error-custom alert-dismissible fade show mb-4" role="alert">
            <div class="d-flex align-items-start">
                <i class="bi bi-exclamation-circle-fill me-3 mt-1" style="font-size: 1.2rem;"></i>
                <div class="flex-grow-1">
                    <strong>Validation Errors</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Form Card -->
    <div class="card-modern">
        <div class="card-header">
            <i class="bi bi-pencil-square me-2"></i>User Details
        </div>
        <div class="card-body">
            <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data" id="editForm">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Left Column: Form Fields -->
                    <div class="col-lg-8">

                        <!-- Name Field -->
                        <div class="mb-4">
                            <label for="name" class="form-label">
                                <i class="bi bi-person me-2 text-primary"></i>Full Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" placeholder="Enter full name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="mb-4">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope me-2 text-primary"></i>Email Address <span class="text-danger">*</span>
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" placeholder="user@example.com" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- CNIC Field -->
                        <div class="mb-4">
                            <label for="cnic" class="form-label">
                                <i class="bi bi-card-text me-2 text-primary"></i>CNIC <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('cnic') is-invalid @enderror"
                                   id="cnic" name="cnic" placeholder="CNIC number" value="{{ old('cnic', $user->cnic) }}" required>
                            @error('cnic')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Telephone Field -->
                        <div class="mb-4">
                            <label for="telephone" class="form-label">
                                <i class="bi bi-telephone me-2 text-primary"></i>Telephone <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('telephone') is-invalid @enderror"
                                   id="telephone" name="telephone" placeholder="Phone number" value="{{ old('telephone', $user->telephone) }}" required>
                            @error('telephone')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Comments Field -->
                        <div class="mb-4">
                            <label for="comments" class="form-label">
                                <i class="bi bi-chat-left-text me-2 text-primary"></i>Comments <span class="text-muted">(Optional)</span>
                            </label>
                            <textarea class="form-control @error('comments') is-invalid @enderror"
                                      id="comments" name="comments" rows="4" placeholder="Add any comments or notes...">{{ old('comments', $user->comments) }}</textarea>
                            @error('comments')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>

                    <!-- Right Column: Profile Picture -->
                    <div class="col-lg-4">

                        <!-- Current Picture -->
                        <div class="card border-0 mb-4">
                            <div class="card-body p-4 text-center" style="background: #f8f9ff;">
                                <div class="form-label fw-600 text-dark d-block mb-3">
                                    <i class="bi bi-image me-2 text-primary"></i>Current Picture
                                </div>
                                <div class="mb-3">
                                    @if($user->profile_picture && file_exists(public_path('uploads/' . $user->profile_picture)))
                                        <img src="{{ asset('uploads/' . $user->profile_picture) }}" alt="{{ $user->name }}"
                                             class="avatar-large">
                                    @else
                                        <div class="avatar-large d-inline-flex align-items-center justify-content-center"
                                             style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                            <i class="bi bi-person text-white" style="font-size: 3rem;"></i>
                                        </div>
                                    @endif
                                </div>
                                <small class="text-muted">ID: {{ $user->id }}</small>
                            </div>
                        </div>

                        <!-- New Picture Upload -->
                        <div class="card border-2 border-dashed">
                            <div class="card-body p-4 text-center">

                                <!-- Preview Area -->
                                <div class="mb-4">
                                    <div id="imagePreviewContainer" class="mb-3">
                                        <i class="bi bi-cloud-upload text-muted" style="font-size: 2.5rem; display: block; margin-bottom: 10px;"></i>
                                        <p class="text-muted mb-0 small">Replace Image</p>
                                    </div>
                                    <img id="imagePreview" class="image-preview" alt="Preview" style="display: none; max-width: 150px;">
                                </div>

                                <!-- Label -->
                                <div class="form-label fw-600 text-dark d-block mb-3">
                                    <i class="bi bi-image me-2 text-primary"></i>Change Picture <span class="text-muted">(Optional)</span>
                                </div>

                                <!-- File Input -->
                                <div class="mb-3">
                                    <input type="file" id="profile_picture" name="profile_picture" class="d-none"
                                           accept="image/jpeg,image/png,image/jpg,image/webp"
                                           onchange="previewImage(this, 'imagePreview')">
                                    <label for="profile_picture" class="btn btn-primary-modern btn-modern d-inline-block">
                                        <i class="bi bi-folder2-open me-2"></i>Choose New Image
                                    </label>
                                </div>

                                <!-- Info Text -->
                                <small class="text-muted d-block mb-3">
                                    <i class="bi bi-info-circle me-1"></i>JPG, PNG, WebP<br>Max 2MB
                                </small>

                                <!-- Selected File Name -->
                                <div id="fileName" class="small text-muted mt-2 text-break"></div>

                                @error('profile_picture')
                                    <div class="alert alert-danger mt-3 mb-0">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                    </div>

                </div>

                <!-- Buttons -->
                <div class="d-flex flex-wrap gap-2 mt-5 pt-4 border-top">
                    <button type="submit" class="btn btn-primary-modern btn-modern flex-grow-1 flex-md-grow-0">
                        <i class="bi bi-check-circle me-2"></i>Update User
                    </button>
                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-modern ms-md-auto">
                        <i class="bi bi-arrow-left me-2"></i>Back
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>

@section('extra-js')
<script>
    // Preview and display filename for new image
    document.getElementById('profile_picture').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('imagePreview');
        const previewContainer = document.getElementById('imagePreviewContainer');
        const fileName = document.getElementById('fileName');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                preview.src = event.target.result;
                preview.style.display = 'block';
                previewContainer.style.display = 'none';
            };
            reader.readAsDataURL(file);
            fileName.textContent = `New image: ${file.name}`;
        }
    });
</script>
@endsection

@endsection
