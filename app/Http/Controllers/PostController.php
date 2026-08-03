<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\PostApiServiceInterface;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PostController extends Controller
{
    public function __construct(protected PostApiServiceInterface $postApiService)
    {
    }

    public function index()
    {
        $userId = auth()->id();

        $posts = $this->postApiService->findByUser($userId);

        return view('posts.index', [
            'posts' => $posts,
        ]);
    }

    public function create(): view
    {
        return view('posts.create');
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $post = $this->postApiService->create($request->validated());

        return redirect()
            ->route('posts.index')
            ->with('success', "Post created successfully with ID: {$post['id']}");
    }

    public function show(string $id)
    {
        //
    }

    public function edit(int $id): view
    {
        $post = $this->postApiService->find($id);

        return view('posts.edit', [
            'post' => $post,
        ]);
    }

    public function update(UpdatePostRequest $request, int $id): RedirectResponse
    {
        $this->postApiService->update($id, $request->validated());

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post updated successfully.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->postApiService->delete($id);

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post deleted successfully.');
    }
}
