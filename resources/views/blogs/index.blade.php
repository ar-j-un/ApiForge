@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <strong>My Blogs ({{ $blogCount }})</strong>
    <a href="{{ route('blogs.create') }}" class="btn btn-primary btn-sm">
      New Blog
    </a>
  </div>
  <div class="card-body">

    <form action="{{ route('blogs.search') }}" method="GET" class="mb-4">
      <div class="input-group">
        <input type="text" name="search_query" class="form-control" placeholder="Search your blogs..." value="{{ request('search_query') }}">
        <button class="btn btn-outline-primary" type="submit">Search</button>
      </div>
    </form>

    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($blogs->isEmpty())
      <p class="text-muted">You haven't written any blogs yet.</p>
    @else
      <table class="table table-hover align-middle">
        <thead>
          <tr>
            <th>Title</th>
            <th>Status</th>
            <th>Country</th>
            <th>Created</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($blogs as $blog)
            <tr>
              <td>
                <a href="{{ route('blogs.edit', $blog->id) }}">{{ $blog->title }}</a>
                @if ($blog->excerpt)
                  <div class="text-muted small">{{ Str::limit($blog->excerpt, 50) }}</div>
                @endif
              </td>
              <td>
                @if ($blog->isPublished)
                  <span class="badge bg-success">Published</span>
                @else
                  <span class="badge bg-secondary">Draft</span>
                @endif
              </td>
              <td>{{ $blog->country }}</td>
              <td>{{ \Illuminate\Support\Carbon::parse($blog->createdAt)->diffForHumans() }}</td>
              <td class="text-end">
                <a href="{{ route('blogs.edit', $blog->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Delete this blog?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

      {{ $blogs->links('pagination::bootstrap-5') }}
    @endif

  </div>
</div>
@endsection