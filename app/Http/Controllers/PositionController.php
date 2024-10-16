<?php

namespace App\Http\Controllers;

use App\Http\Resources\PositionResource;
use App\Models\Position;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;
use Yajra\DataTables\Facades\DataTables;

class PositionController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        return inertia('PositionList');
    }

    public function getPositions(Request $request)
    {
        if ($request->ajax()) {
            $paginator = Position::query()->paginate();
            $resource = PositionResource::collection($paginator);

            return DataTables::of($resource)->only(['id', 'name', 'updated_at'])->toJson();
        }
    }
}
