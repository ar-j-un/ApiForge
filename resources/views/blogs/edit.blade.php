@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header">
    <strong>Edit Blog</strong>
  </div>
  <div class="card-body">

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('blogs.update', $blog->id) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $blog->title) }}" required>
      </div>

      <div class="mb-3">
        <label for="excerpt" class="form-label">Excerpt</label>
        <input type="text" name="excerpt" id="excerpt" class="form-control" value="{{ old('excerpt', $blog->excerpt) }}" maxlength="500">
      </div>

      <div class="mb-3">
        <label for="content" class="form-label">Content</label>
        <textarea name="content" id="content" rows="10" class="form-control" required>{{ old('content', $blog->content) }}</textarea>
      </div>

      <div class="mb-3">
        <label for="author_name" class="form-label">Author Name</label>
        <input type="text" name="author_name" id="author_name" class="form-control"
               value="{{ old('author_name', $blog->authorName) }}" required>
      </div>

      <div class="form-check mb-3">
        <input type="checkbox" name="is_published" id="is_published" class="form-check-input" value="1"
               {{ old('is_published', $blog->isPublished) ? 'checked' : '' }}>
        <label for="is_published" class="form-check-label">Published</label>
      </div>

      <button type="submit" class="btn btn-primary">Update Blog</button>
      <a href="{{ route('blogs.index') }}" class="btn btn-outline-secondary">Cancel</a>
    </form>

  </div>
</div>
@endsection