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
            <div class="alert alert-success alert-dismissible fade show">{{ session('status') }}
                <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div id="application-alert"></div>

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

<div class="modal fade" id="deleteApplicationModal" tabindex="-1"
    aria-labelledby="deleteApplicationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteApplicationModalLabel">
                    Confirm Deletion
                </h5>
                <button type="button"
                    class="btn-close"
                    data-coreui-dismiss="modal"
                    aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this application?
            </div>
            <div class="modal-footer">
                <button type="button"
                    class="btn btn-secondary"
                    data-coreui-dismiss="modal">
                    Cancel
                </button>
                <button type="button"
                    class="btn btn-danger"
                    id="confirm-delete-application">
                    Delete
                </button>
            </div>
        </div>
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
    let applicationId = null;
    const deleteModal = new coreui.Modal(
        document.getElementById('deleteApplicationModal')
    );

    $('#applications-table').on('click', '.delete-application', function () {

        applicationId = $(this).data('id');

        if (!applicationId) {
            return;
        }
        deleteModal.show();
    });

    $('#confirm-delete-application').on('click', function () {

        if (!applicationId) {
            return;
        }
        $.ajax({
            url: `{{ url('applications') }}/${applicationId}`,
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },

            success: function (response) {
                deleteModal.hide();
                table.ajax.reload(null, false);
                applicationId = null;
            },

            error: function () {
                deleteModal.hide();
                $('#application-alert').html(`
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Something went wrong while deleting the application.
                        <button type="button"
                            class="btn-close"
                            data-coreui-dismiss="alert"
                            aria-label="Close">
                        </button>
                    </div>
                `);
                applicationId = null;
            }
        });
    });
});
</script>
@endpush