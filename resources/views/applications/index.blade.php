@extends('layouts.app')

@section('title', 'Applications')

@section('breadcrumb')
    <li class="breadcrumb-item active">Applications</li>
@endsection

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        Applications
        <a href="{{ route('applications.create') }}" class="btn btn-primary btn-sm">Add Application</a>
    </div>
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <table id="applications-table" class="table table-hover w-100">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Port</th>
                    <th>Created</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#applications-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('applications.index') }}',
            columns: [
                { data: 'name', name: 'name' },
                { data: 'address', name: 'address' },
                { data: 'port', name: 'port' },
                { data: 'created_at', name: 'created_at' },
            ],
        });
    });
</script>
@endpush