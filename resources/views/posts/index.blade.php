@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>My Posts</strong>
                <a href="{{ route('posts.create') }}" class="btn btn-primary btn-sm">
                    Create Post
                </a>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                @forelse ($posts as $post)
                    <div class="mb-3 pb-3 border-bottom">
                        <h5>{{ $post['title'] }}</h5>
                        <p class="mb-0">{{ $post['body'] }}</p>
                        <div class="d-flex gap-3 mt-3">
                            <a href="{{ route('posts.edit', $post['id']) }}" class="btn btn-sm btn-outline-primary">
                                Edit
                            </a>

                            <form action="{{ route('posts.destroy', $post['id']) }}" method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this post?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-muted mb-0">No posts found for your account.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection