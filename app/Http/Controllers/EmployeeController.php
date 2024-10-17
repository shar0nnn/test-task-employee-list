<?php

namespace App\Http\Controllers;

use App\Models\Employee;
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
            $queryBuilder = Employee::with('position');

            return DataTables::of($queryBuilder)
                ->addColumn('position', function (Employee $employee) {
                    return $employee->position->name;
                })->orderColumn('position', function ($query, $order) {
                    $query->join('positions', 'employees.position_id', '=', 'positions.id')
                        ->orderBy('positions.name', $order);
                })->make();
        }
    }
}
