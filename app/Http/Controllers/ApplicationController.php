<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationRequest;
use App\Models\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApplicationController extends Controller
{

    public function index()
    {
        //
    }

    public function create(): View
    {
        return view('applications.create');
    }

    public function store(StoreApplicationRequest $request): RedirectResponse
    {
        $request->user()->applications()->create($request->validated());

        return redirect()
            ->route('applications.index')
            ->with('status', 'Application created successfully.');

    }

    public function show(Application $application)
    {
        //
    }

    public function edit(Application $application)
    {
        //
    }

    public function update(Request $request, Application $application)
    {
        //
    }

    public function destroy(Application $application)
    {
        //
    }
}
