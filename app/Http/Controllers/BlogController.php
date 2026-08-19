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
        $blogs = $this->blogs->paginateForUser(auth()->id());
        $blogCount = $this->blogs->countByUser(auth()->id());

        $error = is_array($blogs) ? $blogs : (is_array($blogCount) ? $blogCount : null);

        return view('blogs.index', [
            'blogs' => is_array($blogs) ? new LengthAwarePaginator([], 0, 3) : $blogs,
            'blogCount' => is_array($blogCount) ? 0 : $blogCount,
            'searchError' => $error['message'] ?? null,
        ]);
    }

    public function create()
    {
        return view('blogs.create');
    }

    public function store(StoreBlogRequest $request)
    {
        $result = $this->blogs->create($request->validated(), auth()->id());

        if (is_array($result)) {
            return back()->withInput()->with(['error' => $result['message']]);
        }

        return redirect()->route('blogs.index')->with('success', 'Blog created.');
    }

    public function search(SearchBlogRequest $request)
    {
        $result = $this->blogs->search($request->validated('search_query'), auth()->id());

        return view('blogs.search', [
            'blogs' => is_array($result) ? new LengthAwarePaginator([], 0, 15) : $result,
            'searchError' => is_array($result) ? $result['message'] : null,
        ]);
    }

    public function show()
    {
        $foreignBlogs = $this->blogs->foreignBlogs(auth()->id());
        $foreignCountryCounts = $this->blogs->foreignCountryCounts();

        $blogsFailed = is_array($foreignBlogs);
        $countsFailed = isset($foreignCountryCounts['_error']);

        return view('blogs.show', [
            'foreignBlogs' => $blogsFailed ? new LengthAwarePaginator([], 0, 3) : $foreignBlogs,
            'foreignCountryCounts' => $countsFailed ? [] : $foreignCountryCounts,
            'searchError' => $error['message'] ?? null,
        ]);
    }

    public function edit(string $id)
    {
        $blog = $this->blogs->find($id);
        if (is_array($blog)) {
            return redirect()->route('blogs.index')->with(['error' => $blog['message']]);
        }
        abort_if(! $blog || $blog->userId !== auth()->id(), 403, 'You are not authorized to view this blog.');

        return view('blogs.edit', compact('blog'));
    }

    public function update(StoreBlogRequest $request, string $id)
    {
        $blog = $this->blogs->find($id);
        if (is_array($blog)) {
            return redirect()->route('blogs.index')->with(['error' => $blog['message']]);
        }
        abort_if($blog->userId !== auth()->id(), 403, 'You are not authorized to view this blog.');

        $result = $this->blogs->update($id, $request->validated());

        if (is_array($result)) {
            return back()->withInput()->with(['error' => $result['message']]);
        }

        return redirect()->route('blogs.index')->with('success', 'Blog updated.');
    }

    public function destroy(string $id)
    {
        $blog = $this->blogs->find($id);
        if (is_array($blog)) {
            return redirect()->route('blogs.index')->with(['error' => $blog['message']]);
        }
        abort_if($blog->userId !== auth()->id(), 403, 'You are not authorized to view this blog.');

        $result = $this->blogs->delete($id);
        if (is_array($result)) {
            return back()->with(['error' => $result['message']]);
        }

        return redirect()->route('blogs.index')->with('success', 'Blog deleted.');
    }
}
