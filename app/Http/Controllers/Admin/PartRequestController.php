<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PartRequestController extends Controller
{
    public function index(Request $request): View
    {
        $query = PartRequest::query()->with('product')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $requests = $query->paginate(20)->withQueryString();

        return view('admin.part-requests.index', compact('requests'));
    }

    public function show(PartRequest $partRequest): View
    {
        $partRequest->load('product');

        return view('admin.part-requests.show', compact('partRequest'));
    }

    public function update(Request $request, PartRequest $partRequest): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,processing,quoted,completed,cancelled'],
            'admin_notes' => ['nullable', 'string'],
        ]);

        $partRequest->update($data);

        return back()->with('success', 'Demande mise à jour.');
    }

    public function destroy(PartRequest $partRequest): RedirectResponse
    {
        $partRequest->delete();

        return redirect()->route('admin.part-requests.index')->with('success', 'Demande supprimée.');
    }
}
