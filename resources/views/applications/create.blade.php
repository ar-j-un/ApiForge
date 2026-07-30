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
        <form method="POST" action="{{ route('applications.store') }}" id="application-form" class="needs-validation" novalidate>
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name') }}"
                    class="form-control @error('name') is-invalid @enderror"
                    maxlength="255"
                    required
                    autofocus
                >
                <div class="invalid-feedback">
                    Application name is required.
                </div>
                @error('name')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
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
                    pattern="^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)(\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)){3}$"
                    required
                >
                <div class="invalid-feedback">
                    Enter a valid IPv4 address (e.g. 192.168.1.10).
                </div>
                @error('address')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
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
                <div class="invalid-feedback">
                    Port must be a number between 1 and 65535.
                </div>
                @error('port')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="forwarding_address" class="form-label">Forwarding Address</label>
                <input
                    type="text"
                    name="forwarding_address"
                    id="forwarding_address"
                    value="{{ old('forwarding_address') }}"
                    class="form-control @error('forwarding_address') is-invalid @enderror"
                    placeholder="e.g. 10.0.0.5"
                    pattern="^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)(\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)){3}$"
                    required
                >
                <div class="invalid-feedback">
                    Enter a valid IPv4 address (e.g. 10.0.0.5).
                </div>
                @error('forwarding_address')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="domain" class="form-label">Domain</label>
                <input
                    type="text"
                    name="domain"
                    id="domain"
                    value="{{ old('domain') }}"
                    class="form-control @error('domain') is-invalid @enderror"
                    placeholder="e.g. example.com"
                    pattern="^(?!-)[A-Za-z0-9-]{1,63}(?<!-)(\.[A-Za-z0-9-]{1,63}(?<!-))*\.[A-Za-z]{2,}$"
                    maxlength="255"
                    required
                >
                <div class="invalid-feedback">
                    Enter a valid domain (e.g. example.com).
                </div>
                @error('domain')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ route('applications.index') }}" class="btn btn-link">Cancel</a>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (() => {
        const form = document.getElementById('application-form');

        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');
        }, false);
    })();
</script>
@endpush