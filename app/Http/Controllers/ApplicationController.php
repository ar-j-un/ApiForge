<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationRequest;
use App\Models\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class ApplicationController extends Controller
{

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            $applications = auth()->user()->applications()->select([
                'id', 'name', 'address', 'port', 'created_at',
            ]);

            return DataTables::of($applications)
                ->editColumn('created_at', fn (Application $application) => $application->created_at->format('d M Y, h:i A'))
                ->toJson();
        }

        return view('applications.index');

    }

    public function create(): View
    {
        return view('applications.create');
    }

    public function store(StoreApplicationRequest $request): RedirectResponse
    {
        auth()->user()->applications()->create($request->validated());

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
