@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <strong>Create New Post</strong>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('posts.store') }}" method="POST"
                      class="needs-validation" novalidate>
                    @csrf

                    <div class="mb-3">
                        <label for="userId" class="form-label">User ID</label>
                        <input type="number" class="form-control @error('userId') is-invalid @enderror"
                               id="userId" name="userId" value="{{ old('userId') }}"
                               required min="1">
                        <div class="invalid-feedback">
                            @error('userId')
                                {{ $message }}
                            @else
                                Please enter a valid User ID.
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                               id="title" name="title" value="{{ old('title') }}"
                               required maxlength="255">
                        <div class="invalid-feedback">
                            @error('title')
                                {{ $message }}
                            @else
                                Please enter a title.
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="body" class="form-label">Body</label>
                        <textarea class="form-control @error('body') is-invalid @enderror"
                                  id="body" name="body" rows="5" required>{{ old('body') }}</textarea>
                        <div class="invalid-feedback">
                            @error('body')
                                {{ $message }}
                            @else
                                Please enter the post body.
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Create Post</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function () {
    $('.needs-validation').on('submit', function (event) {
        const form = this;

        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }

        $(form).addClass('was-validated');
    });
});
</script>
@endpush