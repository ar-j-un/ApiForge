<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contracts\PostApiServiceInterface;
use App\Http\Requests\StorePostRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PostController extends Controller
{
    public function __construct(protected PostApiServiceInterface $postApiService)
    {
    }

    public function index()
    {
        //
    }

    public function create(): view
    {
        return view('posts.create');
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        $post = $this->postApiService->create($request->validated());

        return redirect()
            ->route('posts.create')
            ->with('success', "Post created successfully with ID: {$post['id']}");
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
