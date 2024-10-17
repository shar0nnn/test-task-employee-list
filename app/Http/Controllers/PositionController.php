<?php

namespace App\Http\Controllers;

use App\Http\Requests\PositionRequest;
use App\Models\Position;
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

    public function getPositions(Request $request)
    {
        if ($request->ajax()) {
            $queryBuilder = Position::query();

            return DataTables::of($queryBuilder)->only(['id', 'name', 'updated_at'])->toJson();
        }
    }

    public function showCreatePositionComponent(): Response|ResponseFactory
    {
        return inertia('Position/CreatePosition');
    }

    public function createPosition(PositionRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        Position::query()->create([
            'name' => $credentials['positionName'],
            'admin_created_id' => auth()->id(),
        ]);

        return redirect()->route('positions.index');
    }

    public function showEditPositionComponent(Position $position): Response|ResponseFactory
    {
        return inertia('Position/EditPosition', ['position' => $position]);
    }

    public function editPosition(PositionRequest $request, Position $position): RedirectResponse
    {
        $credentials = $request->validated();

        $position->update([
            'name' => $credentials['positionName'],
            'admin_updated_id' => auth()->id(),
        ]);

        return redirect()->route('positions.index');
    }

    public
    function deletePosition(Position $position): JsonResponse
    {
        $position->delete();

        return response()->json(['success' => 'Position deleted successfully.']);
    }
}
