@extends('layouts.app')

@section('title', 'Applications')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">My Applications</h4>
        <a href="{{ route('applications.create') }}" class="btn btn-primary">
            New Application
        </a>
    </div>

    <div id="alert-container"></div>

    <div class="row" id="applications-grid">
        @forelse ($applications as $application)
            <div class="col-sm-6 col-lg-4 col-xl-3 mb-4">
                <div class="card h-100 shadow-sm application-card"
                     id="application-card-{{ $application->id }}"
                     data-id="{{ $application->id }}">

                    <div class="card-body">
                        <h5 class="card-title text-truncate mb-2 js-app-name">
                            {{ $application->name }}
                        </h5>
                        <p class="card-text text-body-secondary text-truncate js-app-domain">
                            {{ $application->domain }}
                        </p>

                        <div class="js-edit-fields d-none">
                            <div class="mb-2">
                                <input type="text" class="form-control form-control-sm js-input-name"
                                       maxlength="255" value="{{ $application->name }}">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="mb-2">
                                <input type="text" class="form-control form-control-sm js-input-domain"
                                       maxlength="255" value="{{ $application->domain }}">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer bg-transparent d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-sm btn-outline-primary js-edit-btn">
                            Edit
                        </button>
                        <button type="button" class="btn btn-sm btn-primary js-save-btn d-none">
                            Save
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-secondary js-cancel-btn d-none">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center text-body-secondary py-5">
                    No applications found. Create your first one to get started.
                </div>
            </div>
        @endforelse
    </div>

    @if ($applications instanceof \Illuminate\Contracts\Pagination\Paginator)
        <div class="mt-3">
            {{ $applications->links() }}
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    const $grid = $('#applications-grid');

    $grid.on('click', '.js-edit-btn', function () {
        toggleEditMode($(this).closest('.application-card'), true);
    });

    $grid.on('click', '.js-cancel-btn', function () {
        const $card = $(this).closest('.application-card');

        $card.find('.js-input-name').val($card.find('.js-app-name').text().trim());
        $card.find('.js-input-domain').val($card.find('.js-app-domain').text().trim());

        clearErrors($card);
        toggleEditMode($card, false);
    });

    $grid.on('click', '.js-save-btn', function () {
        const $card = $(this).closest('.application-card');
        const $saveBtn = $(this);
        const id = $card.data('id');

        clearErrors($card);
        $saveBtn.prop('disabled', true).text('Saving...');

        $.ajax({
            url: `/applications/${id}/quick-update`,
            method: 'PATCH',
            data: {
                _token: '{{ csrf_token() }}',
                name: $card.find('.js-input-name').val(),
                domain: $card.find('.js-input-domain').val(),
            },
        })
        .done(function (response) {
            $card.find('.js-app-name').text(response.data.name);
            $card.find('.js-app-domain').text(response.data.domain);

            toggleEditMode($card, false);
            showAlert('success', response.message);
        })
        .fail(function (xhr) {
            if (xhr.status === 422) {
                $.each(xhr.responseJSON.errors, function (field, messages) {
                    $card.find(`.js-input-${field}`)
                        .addClass('is-invalid')
                        .next('.invalid-feedback')
                        .text(messages[0]);
                });
            } else {
                showAlert('danger', 'Something went wrong. Please try again.');
            }
        })
        .always(function () {
            $saveBtn.prop('disabled', false).text('Save');
        });
    });

    function toggleEditMode($card, isEditing) {
        $card.find('.js-app-name, .js-app-domain, .js-edit-btn').toggleClass('d-none', isEditing);
        $card.find('.js-edit-fields, .js-save-btn, .js-cancel-btn').toggleClass('d-none', !isEditing);

        if (isEditing) {
            $card.find('.js-input-name').trigger('focus');
        }
    }

    function clearErrors($card) {
        $card.find('.is-invalid').removeClass('is-invalid');
        $card.find('.invalid-feedback').text('');
    }

    function showAlert(type, message) {
        $('#alert-container').html(`
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
            </div>
        `);
    }
});
</script>
@endpush