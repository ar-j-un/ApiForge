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
        $this->blogs->create($request->validated(), auth()->id());

        return redirect()->route('blogs.index')->with('success', 'Blog created.');
    }

    public function search(SearchBlogRequest $request)
    {
        $blogs = $this->blogs->search($request->validated('search_query'), auth()->id());

        return view('blogs.search', compact('blogs'));
    }

    public function show()
    {
        try {
            $foreignBlogs = $this->blogs->foreignBlogs(auth()->id());
            $foreignCountryCounts = $this->blogs->foreignCountryCounts();
        } catch (BlogSearchException $err) {
            return view('blogs.show', [
                'foreignBlogs' => new LengthAwarePaginator([], 0, 3),
                'foreignCountryCounts' => [],
                'searchError' => $err->getMessage(),
            ]);
        }

        return view('blogs.show', compact('foreignBlogs', 'foreignCountryCounts'));
    }

    public function edit(string $id)
    {
        $blog = $this->blogs->find($id);
        abort_if(! $blog || $blog->userId !== auth()->id(), 403);

        return view('blogs.edit', compact('blog'));
    }

    public function update(StoreBlogRequest $request, string $id)
    {
        $blog = $this->blogs->find($id);
        abort_if(! $blog || $blog->userId !== auth()->id(), 403);

        $this->blogs->update($id, $request->validated());

        return redirect()->route('blogs.index')->with('success', 'Blog updated.');
    }

    public function destroy(string $id)
    {
        $blog = $this->blogs->find($id);
        abort_if(! $blog || $blog->userId !== auth()->id(), 403);

        $this->blogs->delete($id);

        return redirect()->route('blogs.index')->with('success', 'Blog deleted.');
    }
}
