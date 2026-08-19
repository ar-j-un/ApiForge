<?php

namespace App\Http\Controllers;

use App\Contracts\BlogServiceInterface;
use App\Http\Requests\SearchBlogRequest;
use App\Http\Requests\StoreBlogRequest;
use Illuminate\Pagination\LengthAwarePaginator;

class BlogController extends Controller
{
    public function __construct(private BlogServiceInterface $blogs) {}

    public function index()
    {
        $blogsResult = $this->blogs->paginateForUser(auth()->id());
        $countResult = $this->blogs->countByUser(auth()->id());

        $error = ! $blogsResult['success'] ? $blogsResult['message']
                : (! $countResult['success'] ? $countResult['message'] : null);

        return view('blogs.index', [
            'blogs' => $blogsResult['success'] ? $blogsResult['data'] : new LengthAwarePaginator([], 0, 3),
            'blogCount' => $countResult['success'] ? $countResult['data'] : 0,
            'searchError' => $error,
        ]);
    }

    public function create()
    {
        return view('blogs.create');
    }

    public function store(StoreBlogRequest $request)
    {
        $result = $this->blogs->create($request->validated(), auth()->id());

        if ($result['success']) {
            return back()->withInput()->with(['error' => $result['message']]);
        }

        return redirect()->route('blogs.index')->with('success', 'Blog created.');
    }

    public function search(SearchBlogRequest $request)
    {
        $result = $this->blogs->search($request->validated('search_query'), auth()->id());

        return view('blogs.search', [
            'blogs' => $result['success'] ? $result['data'] : new LengthAwarePaginator([], 0, 15),
            'searchError' => $result['success'] ? null : $result['message'],
        ]);
    }

    public function show()
    {
        $foreignBlogsResult = $this->blogs->foreignBlogs(auth()->id());
        $foreignCountsResult = $this->blogs->foreignCountryCounts();

        $error = ! $foreignBlogsResult['success'] ? $foreignBlogsResult['message']
            : (! $foreignCountsResult['success'] ? $foreignCountsResult['message'] : null);

        return view('blogs.show', [
            'foreignBlogs' => $foreignBlogsResult['success'] ? $foreignBlogsResult['data'] : new LengthAwarePaginator([], 0, 3),
            'foreignCountryCounts' => $foreignCountsResult['success'] ? $foreignCountsResult['data'] : [],
            'searchError' => $error,
        ]);
    }

    public function edit(string $id)
    {
        $result = $this->blogs->find($id);

        if (! $result['success']) {
            return redirect()->route('blogs.index')->with(['error' => $result['message']]);
        }
        $blog = $result['data'];
        abort_if(! $blog, 404, 'The blog you are looking for could not be found.');
        abort_if($blog->userId !== auth()->id(), 403, 'You are not authorized to view this blog.');

        return view('blogs.edit', compact('blog'));
    }

    public function update(StoreBlogRequest $request, string $id)
    {
        $blogResult = $this->blogs->find($id);

        if (! $blogResult['success']) {
            return redirect()->route('blogs.index')->with(['error' => $blogResult['message']]);
        }

        $blog = $blogResult['data'];
        abort_if(! $blog, 404, 'The blog you are looking for could not be found.');
        abort_if($blog->userId !== auth()->id(), 403, 'You are not authorized to view this blog.');

        $result = $this->blogs->update($id, $request->validated());

        if (! $result['success']) {
            return back()->withInput()->with(['error' => $result['message']]);
        }

        return redirect()->route('blogs.index')->with('success', 'Blog updated.');
    }

    public function destroy(string $id)
    {
        $blogResult = $this->blogs->find($id);

        if (! $blogResult['success']) {
            return redirect()->route('blogs.index')->with(['error' => $blogResult['message']]);
        }

        $blog = $blogResult['data'];
        abort_if(! $blog, 404, 'The blog you are looking for could not be found.');
        abort_if($blog->userId !== auth()->id(), 403, 'You are not authorized to view this blog.');

        $result = $this->blogs->delete($id);

        if (! $result['success']) {
            return back()->with(['error' => $result['message']]);
        }

        return redirect()->route('blogs.index')->with('success', 'Blog deleted.');
    }
}
