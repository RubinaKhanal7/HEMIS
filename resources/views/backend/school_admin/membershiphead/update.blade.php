@extends('backend.layouts.master')

@section('content')
    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">
            <div class="border-bottom border-primary">
                <h2>{{ $page_title }}</h2>
            </div>
            @include('backend.school_admin.membershiphead.partials.action')
        </div>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.membershiphead.update', $membershiphead->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $membershiphead->title) }}" required>
                        @error('title')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group mt-3">
                        <label>Status</label>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="is_active" value="1" {{ $membershiphead->is_active ? 'checked' : '' }}>
                            <label class="form-check-label">Active</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" class="form-check-input" name="is_active" value="0" {{ !$membershiphead->is_active ? 'checked' : '' }}>
                            <label class="form-check-label">Inactive</label>
                        </div>
                    </div>
                    
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('admin.membershiphead.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection