<?php

namespace App\Http\Controllers;

use App\Http\Requests\PositionRequest;
use App\Models\Position;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;
use Yajra\DataTables\Facades\DataTables;

class PositionController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        return inertia('Position/PositionList');
    }

    /**
     * @throws Exception
     */
    public function getPositions(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Position::query())->only(['id', 'name', 'updated_at'])->make();
        }
    }

    public function create(): Response|ResponseFactory
    {
        return inertia('Position/CreatePosition');
    }

    public function store(PositionRequest $request): RedirectResponse
    {
        $data = $request->validated();

        Position::query()->create([
            'name' => $data['positionName'],
            'admin_created_id' => auth()->id(),
        ]);

        return redirect()->route('positions.index');
    }

    public function edit(Position $position): Response|ResponseFactory
    {
        return inertia('Position/EditPosition', ['position' => $position]);
    }

    public function update(PositionRequest $request, Position $position): RedirectResponse
    {
        $data = $request->validated();

        $position->update([
            'name' => $data['positionName'],
            'admin_updated_id' => auth()->id(),
        ]);

        return redirect()->route('positions.index');
    }

    public function destroy(Position $position): JsonResponse
    {
        $position->delete();

        return response()->json(['success' => 'Position deleted successfully']);
    }
}
