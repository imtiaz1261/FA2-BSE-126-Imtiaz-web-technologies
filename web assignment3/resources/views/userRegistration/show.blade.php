@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-modern p-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0">User Details</h4>
                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Back to list</a>
                </div>

                <div class="row">
                    <div class="col-md-4 text-center">
                        @if($user->photo && file_exists(public_path('uploads/' . $user->photo)))
                            <img src="{{ asset('uploads/' . $user->photo) }}" alt="{{ $user->name }}" class="img-fluid rounded mb-3" style="max-height:260px;">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height:260px;">
                                <i class="bi bi-person-circle" style="font-size:72px;color:#dde2e6"></i>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-8">
                        <dl class="row">
                            <dt class="col-sm-4">Name</dt>
                            <dd class="col-sm-8">{{ $user->name }}</dd>

                            <dt class="col-sm-4">Email</dt>
                            <dd class="col-sm-8">{{ $user->email }}</dd>

                            <dt class="col-sm-4">CNIC</dt>
                            <dd class="col-sm-8">{{ $user->cnic }}</dd>

                            <dt class="col-sm-4">Telephone</dt>
                            <dd class="col-sm-8">{{ $user->telephone }}</dd>

                            <dt class="col-sm-4">Status</dt>
                            <dd class="col-sm-8">{{ $user->status ? 'Active' : 'Inactive' }}</dd>

                            <dt class="col-sm-4">Registered</dt>
                            <dd class="col-sm-8">{{ $user->created_at->format('M d, Y H:i') }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

