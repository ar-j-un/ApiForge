@extends('layouts.app')
@section('content')
@if (session('error') ?? $searchError ?? false)
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Something went wrong.</strong> {{ session('error') ?? $searchError }}
    <button type="button" class="btn-close" data-coreui-dismiss="alert" aria-label="Close"></button>
  </div>
@endif
<div class="card mt-5">
  <div class="card-body">
      @if ($foreignBlogs->isEmpty())
        <p class="text-muted">You haven't written any foreign blogs yet.</p>
      @else
        <table class="table table-hover align-middle">
          <thead>
            <tr>
              <th>Title</th>
              <th>Status</th>
              <th>Country</th>
              <th>Created</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($foreignBlogs as $blog)
              <tr>
                <td>{{ $blog->title }}
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
              </tr>
            @endforeach
          </tbody>
        </table>

        {{ $foreignBlogs->links('pagination::bootstrap-5') }}
      @endif
  </div>
</div>
<div class="card mt-5 mb-5">
    <div class="card-header">Blogs of Foreign Countries</div>
    <ul class="list-group list-group-flush">
        @forelse ($foreignCountryCounts as $bucket)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $bucket['key'] }}
                <span class="badge bg-primary rounded-pill">{{ $bucket['doc_count'] }}</span>
            </li>
        @empty
            <li class="list-group-item text-body-secondary">No foreign blogs yet.</li>
        @endforelse
    </ul>
</div>
@endsection