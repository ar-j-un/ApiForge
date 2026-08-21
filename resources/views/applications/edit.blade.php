@extends('layouts.app')

@section('title', 'Edit Application')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('applications.index') }}">Applications</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        Edit Application
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('applications.update', $application) }}" id="application-form">
            @csrf
            @method('PATCH')

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name', $application->name) }}"
                    class="form-control @error('name') is-invalid @enderror"
                    maxlength="255"
                    required
                    autofocus
                >
                <div class="invalid-feedback"></div>
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
                    value="{{ old('address',$application->address) }}"
                    class="form-control @error('address') is-invalid @enderror"
                    placeholder="e.g. 192.168.1.10"
                    required
                >
                <div class="invalid-feedback"></div>
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
                    value="{{ old('port', $application->port) }}"
                    class="form-control @error('port') is-invalid @enderror"
                    min="1"
                    max="65535"
                    required
                >
                <div class="invalid-feedback"></div>
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
                    value="{{ old('forwarding_address', $application->forwarding_address) }}"
                    class="form-control @error('forwarding_address') is-invalid @enderror"
                    placeholder="e.g. 10.0.0.5"
                    required
                >
                <div class="invalid-feedback"></div>
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
                    value="{{ old('domain', $application->domain) }}"
                    class="form-control @error('domain') is-invalid @enderror"
                    placeholder="e.g. example.com"
                    maxlength="255"
                    required
                >
                <div class="invalid-feedback"></div>
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
$(document).ready(function () {

    $.validator.addMethod('pattern', function (value, element, param) {
        return this.optional(element) || param.test(value);
    }, 'Invalid format.');

    $('#application-form').validate({
        rules: {
            name: {
                required: true,
                maxlength: 255,
            },
            address: {
                required: true,
                pattern: /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)(\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)){3}$/,
            },
            port: {
                required: true,
                digits: true,
                min: 1,
                max: 65535,
            },
            forwarding_address: {
                required: true,
                pattern: /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)(\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)){3}$/,
            },
            domain: {
                required: true,
                maxlength: 255,
                pattern: /^(?!-)[A-Za-z0-9-]{1,63}(?<!-)(\.[A-Za-z0-9-]{1,63}(?<!-))*\.[A-Za-z]{2,}$/,
            },
        },
        messages: {
            name: {
                required: 'Application name is required',
            },
            address: {
                required: 'Address is required',
                pattern: 'Enter a valid IPv4 address (e.g. 192.168.1.10)',
            },
            port: {
                required: 'Port is required',
                min: 'Port must be between 1 and 65535',
                max: 'Port must be between 1 and 65535',
            },
            forwarding_address: {
                required: 'Forwarding address is required',
                pattern: 'Enter a valid IPv4 address (e.g. 10.0.0.5)',
            },
            domain: {
                required: 'Domain is required',
                pattern: 'Enter a valid domain (e.g. example.com)',
            },
        },
        errorPlacement: function (error, element) {
            element.next('.invalid-feedback').text(error.text());
        },
        highlight: function (element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        },
    });
});
</script>
@endpush