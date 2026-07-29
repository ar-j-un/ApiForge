@extends('layouts.app')

@section('title', 'Create Application')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('applications.index') }}">Applications</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        Create Application
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('applications.store') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name') }}"
                    class="form-control @error('name') is-invalid @enderror"
                    required
                    autofocus
                >
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">IP Address</label>
                <input
                    type="text"
                    name="address"
                    id="address"
                    value="{{ old('address') }}"
                    class="form-control @error('address') is-invalid @enderror"
                    placeholder="e.g. 192.168.1.10"
                    required
                >
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="port" class="form-label">Port</label>
                <input
                    type="number"
                    name="port"
                    id="port"
                    value="{{ old('port') }}"
                    class="form-control @error('port') is-invalid @enderror"
                    min="1"
                    max="65535"
                    required
                >
                @error('port')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('applications.index') }}" class="btn btn-link">Cancel</a>
        </form>
    </div>
</div>
@endsection