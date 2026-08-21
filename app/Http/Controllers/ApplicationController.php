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
                'id', 'name', 'address', 'port', 'forwarding_address', 'domain', 'created_at',
            ]);

            return DataTables::of($applications)
                ->editColumn('created_at', fn (Application $application) => $application->created_at->format('d M Y, h:i A'))
                ->addColumn('action', function (Application $application) {
                    return '<button data-id="'.$application->id.'" class="btn btn-danger btn-sm delete-application">Delete</button>';
                })
                ->rawColumns(['action'])
                ->make(true);
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

    public function show()
    {
        $applications = auth()->user()->applications()->paginate(10);

        return view('applications.show', compact('applications'));
    }

    public function edit(Application $application)
    {
        return view('applications.edit', ['application' => $application]);
    }

    public function update(StoreApplicationRequest $request, Application $application)
    {
        $application->update($request->validated());

        return redirect()
            ->route('applications.show')
            ->with('success', 'Application updated successfully.');
    }

    public function destroy($id)
    {
        $application = Application::findOrFail($id);
        if ($application) {
            $application->delete();

            return response()->json(['status' => 'success', 'message' => 'User Deleted Successfully!']);
        }

        return response()->json(['status' => 'failed', 'message' => 'Unable to delete user!']);
    }

    public function quickUpdate(Request $request, Application $application): JsonResponse
    {
        abort_unless($application->user_id === auth()->id(), 403);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'domain' => [
                'required',
                'string',
                'max:255',
                'regex:/^(?!-)[A-Za-z0-9-]{1,63}(?<!-)(\.[A-Za-z0-9-]{1,63}(?<!-))*\.[A-Za-z]{2,}$/',
            ],
        ]);

        $application->update($validated);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $application->id,
                'name' => $application->name,
                'domain' => $application->domain,
            ],
            'message' => 'Application updated successfully.',
        ]);
    }
}
