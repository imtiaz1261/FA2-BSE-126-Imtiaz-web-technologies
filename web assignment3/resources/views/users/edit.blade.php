@extends('layout')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="dashboard-card">
            <div class="card-gradient-header">
                <i class="bi bi-pencil-square"></i> Edit User
            </div>

            <div class="dashboard-card-body">
                <div class="row g-4 align-items-start">
                    <div class="col-lg-4 text-center">
                        <div class="mb-3">
                            @if($user->profile_picture)
                                <div class="avatar-wrapper mx-auto" style="width: 140px; height: 140px; padding: 5px;">
                                    <img src="{{ asset('uploads/' . $user->profile_picture) }}" class="user-avatar" style="width: 130px; height: 130px;" alt="Current avatar">
                                </div>
                            @else
                                <div class="avatar-wrapper mx-auto" style="width: 140px; height: 140px; padding: 5px;">
                                    <div class="user-avatar d-flex align-items-center justify-content-center" style="width: 130px; height: 130px; background: linear-gradient(135deg, #4f6df5, #7b3fad); border: 3px solid #fff;">
                                        <i class="bi bi-person-fill text-white" style="font-size: 3rem;"></i>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="text-muted fw-semibold mb-3">Current Photo</div>
                        <img id="preview" class="preview-img d-none" alt="Preview">
                    </div>

                    <div class="col-lg-8">
                        <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    <i class="bi bi-person"></i> Full Name
                                </label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" placeholder="Enter full name">
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="bi bi-envelope"></i> Email Address
                                </label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" placeholder="user@example.com">
                                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="cnic" class="form-label">
                                    <i class="bi bi-card-text"></i> CNIC
                                </label>
                                <input type="text" name="cnic" value="{{ old('cnic', $user->cnic) }}" class="form-control" placeholder="CNIC number">
                                @error('cnic') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="telephone" class="form-label">
                                    <i class="bi bi-telephone"></i> Telephone
                                </label>
                                <input type="text" name="telephone" value="{{ old('telephone', $user->telephone) }}" class="form-control" placeholder="Phone number">
                                @error('telephone') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="comments" class="form-label">
                                    <i class="bi bi-chat-left-text"></i> Comments
                                </label>
                                <textarea name="comments" class="form-control" rows="3" placeholder="Additional notes (optional)">{{ old('comments', $user->comments) }}</textarea>
                                @error('comments') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="profile_picture" class="form-label">
                                    <i class="bi bi-image"></i> Replace Profile Picture
                                </label>
                                <input type="file" name="profile_picture" class="form-control" accept="image/*" onchange="previewImage(event)">
                                <small class="text-muted">Optional. JPG, PNG, WebP (Max 2MB)</small>
                                @error('profile_picture') <br><small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="d-flex flex-wrap gap-2 mt-4">
                                <button type="submit" class="btn add-user-btn px-4">
                                    <i class="bi bi-check-circle"></i> Update User
                                </button>

                                <a href="{{ route('users.index') }}" class="btn btn-outline-secondary px-4" style="border-radius:10px; font-weight:800; min-height:48px; display:inline-flex; align-items:center;">
                                    <i class="bi bi-arrow-left me-1"></i> Back
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

