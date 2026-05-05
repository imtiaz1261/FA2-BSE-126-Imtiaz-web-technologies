@extends('layouts.app')

@section('title', 'Edit User - User Management System')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header -->
            <div class="mb-4">
                <h1 class="h3 fw-bold text-dark">
                    <i class="bi bi-pencil-square text-primary me-2"></i>Edit User
                </h1>
                <p class="text-muted">Update user information below</p>
            </div>

            <!-- Alerts -->
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-exclamation-circle-fill me-2 mt-1"></i>
                        <div>
                            <strong>Please fix the following errors:</strong>
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
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <form action="{{ route('userRegistration.update', $user) }}" method="POST" enctype="multipart/form-data" id="editForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-lg-8">
                                <!-- Name -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark">
                                        <i class="bi bi-person-fill text-primary me-2"></i>Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="name" class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                           placeholder="Enter full name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark">
                                        <i class="bi bi-envelope-fill text-primary me-2"></i>Email <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                           placeholder="Enter email address" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- CNIC -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark">
                                        <i class="bi bi-credit-card-fill text-primary me-2"></i>CNIC <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="cnic" class="form-control form-control-lg @error('cnic') is-invalid @enderror" 
                                           placeholder="Enter CNIC number" value="{{ old('cnic', $user->cnic) }}" required>
                                    @error('cnic')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Telephone -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark">
                                        <i class="bi bi-telephone-fill text-primary me-2"></i>Telephone <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="telephone" class="form-control form-control-lg @error('telephone') is-invalid @enderror" 
                                           placeholder="Enter telephone number" value="{{ old('telephone', $user->telephone) }}" required>
                                    @error('telephone')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Comments -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold text-dark">
                                        <i class="bi bi-chat-dots-fill text-primary me-2"></i>Comments
                                    </label>
                                    <textarea name="comments" class="form-control @error('comments') is-invalid @enderror" 
                                              rows="3" placeholder="Enter any comments (optional)">{{ old('comments', $user->comments) }}</textarea>
                                    @error('comments')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Right Column - Profile Picture -->
                            <div class="col-lg-4">
                                <!-- Current Picture -->
                                <div class="card bg-light border-0 mb-3">
                                    <div class="card-body text-center py-4">
                                        <label class="form-label fw-bold text-dark d-block mb-3">
                                            <i class="bi bi-image-fill text-primary me-2"></i>Current Picture
                                        </label>
                                        @if($user->profile_picture)
                                            <img src="/uploads/{{ $user->profile_picture }}" alt="{{ $user->name }}" 
                                                 class="rounded img-fluid" style="max-width: 200px; max-height: 200px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary rounded d-inline-flex align-items-center justify-content-center" 
                                                 style="width: 150px; height: 150px;">
                                                <i class="bi bi-person text-white" style="font-size: 2rem;"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Upload New Picture -->
                                <div class="card bg-light border-2 border-dashed">
                                    <div class="card-body text-center py-5">
                                        <div class="mb-3">
                                            <div id="imagePreview" class="mb-3">
                                                <i class="bi bi-cloud-upload text-muted" style="font-size: 2rem;"></i>
                                            </div>
                                        </div>

                                        <label class="form-label fw-bold text-dark d-block mb-3">
                                            Replace Picture
                                        </label>

                                        <div class="mb-2">
                                            <input type="file" id="profilePictureInput" name="profile_picture" class="d-none" 
                                                   accept="image/jpeg,image/png,image/jpg">
                                            <label for="profilePictureInput" class="btn btn-primary btn-sm">
                                                <i class="bi bi-folder2-open me-1"></i>Choose Image
                                            </label>
                                        </div>

                                        <small class="text-muted d-block">JPG or PNG (Max 5MB)</small>
                                        
                                        <div id="fileName" class="mt-2 small text-muted"></div>
                                        
                                        @error('profile_picture')
                                            <div class="invalid-feedback d-block mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex gap-2 mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-circle me-1"></i>Update User
                            </button>
                            <a href="{{ route('userRegistration.index') }}" class="btn btn-secondary btn-lg ms-auto">
                                <i class="bi bi-arrow-left me-1"></i>Back to List
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('extra-js')
<script>
    document.getElementById('profilePictureInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('imagePreview');
        const fileName = document.getElementById('fileName');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                preview.innerHTML = `<img src="${event.target.result}" alt="Preview" class="img-fluid rounded" style="max-width: 150px; max-height: 150px; object-fit: cover;">`;
            };
            reader.readAsDataURL(file);
            fileName.textContent = file.name;
        }
    });
</script>
@endsection

@endsection
