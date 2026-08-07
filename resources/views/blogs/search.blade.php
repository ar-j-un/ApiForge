@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header">
    <strong>Search Results</strong>
  </div>
  <div class="card-body">

    <form action="{{ route('blogs.search') }}" method="GET" class="mb-4">
      <div class="input-group">
        <input type="text" name="search_query" class="form-control" placeholder="Search your blogs..." value="{{ request('search_query') }}">
        <button class="btn btn-primary" type="submit">Search</button>
      </div>
    </form>

    @if (request('search_query'))
      <p class="text-muted">
        {{ $blogs->total() }} result{{ $blogs->total() === 1 ? '' : 's' }} for "{{ request('search_query') }}"
      </p>
    @endif

    @if ($blogs->isEmpty())
      <p class="text-muted">No blogs matched your search.</p>
    @else
      @foreach ($blogs as $blog)
        <div class="mb-3 pb-3 border-bottom">
          <h5><a href="{{ route('blogs.edit', $blog->id) }}">{{ $blog->title }}</a></h5>
          <p class="text-muted mb-1">{{ Str::limit($blog->excerpt ?? strip_tags($blog->content), 150) }}</p>
          <span class="badge {{ $blog->isPublished ? 'bg-success' : 'bg-secondary' }}">
            {{ $blog->isPublished ? 'Published' : 'Draft' }}
          </span>
        </div>
      @endforeach

      {{ $blogs->links() }}
    @endif

  </div>
</div>
@endsection