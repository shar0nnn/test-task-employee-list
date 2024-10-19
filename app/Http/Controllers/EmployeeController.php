<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEmployeeRequest;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        return inertia('Employee/EmployeeList');
    }

    public function getEmployees(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Employee::query())
                ->addColumn('position', function (Employee $employee) {
                    return $employee->position->name;
                })->orderColumn('position', function ($query, $order) {
                    $query->join('positions', 'employees.position_id', '=', 'positions.id')
                        ->orderBy('positions.name', $order);
                })->only(['id', 'photo', 'full_name', 'position', 'hired_at', 'phone', 'email', 'salary'])
                ->make();
        }
    }

    public function showCreateEmployeeComponent(): Response|ResponseFactory
    {
        $positions = Position::query()->select('id', 'name')->orderBy('name')->get();

        return inertia('Employee/CreateEmployee', ['positions' => $positions]);
    }

    public function getNames(string $name): JsonResponse
    {
        $names = Employee::query()->select('id', 'full_name')
            ->where('rank', '>', 1)
            ->whereLike('full_name', '%' . $name . '%')
            ->take(5)
            ->get();

        return response()->json(['names' => $names]);
    }

    public function create(CreateEmployeeRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        Position::query()->create([
            'name' => $credentials['positionName'],
            'admin_created_id' => auth()->id(),
        ]);

        return redirect()->route('employees.index');
    }
}
