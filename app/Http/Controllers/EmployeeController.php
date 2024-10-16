<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    public function index(): Response|ResponseFactory
    {
        return inertia('EmployeeList');
    }

    public function getEmployees(Request $request)
    {
        if ($request->ajax()) {
            $paginator = Employee::with('position')->paginate();
            $resource = EmployeeResource::collection($paginator);

            return DataTables::of($resource)
                ->addColumn('position', function (Employee $employee) {
                    return $employee->position->name;
                })->make();
        }
    }
}
