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
                    <th>Forwarding Address</th>
                    <th>Domain</th>
                    <th>Created</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        const table = $('#applications-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('applications.index') }}',
            columns: [
                { data: 'name', name: 'name' },
                { data: 'address', name: 'address' },
                { data: 'port', name: 'port' },
                { data: 'forwarding_address', name: 'forwarding_address' },
                { data: 'domain', name: 'domain' },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ],
        });
        $('table').on('click', '.delete-application', function () {

            const applicationId = $(this).data('id');

            if (!applicationId) {
                return;
            }
            if (!confirm('Are you sure you want to delete?')) {
                return;
            }

            $.ajax({
                url: `{{ url('applications') }}/${applicationId}`,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {

                    table.ajax.reload(null, false);

                },
                error: function () {
                    alert('Something went wrong!');
                }
            });

        });
    });
</script>
@endpush