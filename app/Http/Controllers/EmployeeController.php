<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Models\Position;
use App\Services\EmployeeService;
use App\Services\ImageService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Response;
use Inertia\ResponseFactory;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Drivers\Imagick\Encoders\JpegEncoder;
use Intervention\Image\ImageManager;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    public function __construct(private EmployeeService $employeeService, private ImageService $imageService)
    {
    }

    public function index(): Response|ResponseFactory
    {
        return inertia('Employee/EmployeeList');
    }

    public function get(Request $request)
    {
        if ($request->ajax()) {
            $model = Employee::with('position');

            return DataTables::eloquent($model)
                ->addColumn('position', function (Employee $employee) {
                    return $employee->position->name;
                })->only(['id', 'photo', 'full_name', 'position', 'hired_at', 'phone', 'email', 'salary'])
                ->toJson();
        }
    }

    public function create(): Response|ResponseFactory
    {
        $positions = Position::query()->select('id', 'name')->orderBy('name')->get();

        return inertia('Employee/CreateEmployee', ['positions' => $positions]);
    }

    public function getNames(string $name, int $rank = 1): JsonResponse
    {
        $names = Employee::query()
            ->select('id', 'full_name')
            ->where('rank', '>', $rank)
            ->whereLike('full_name', '%' . $name . '%')
            ->take(5)
            ->get();

        return response()->json(['names' => $names]);
    }

    /**
     * @throws Exception
     */
    public function store(CreateEmployeeRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $managerId = $data['manager']['id'];
        $manager = Employee::query()->find($managerId);
        $data['rank'] = $manager->rank - 1;

        $this->employeeService->store($data, $managerId);

        return redirect()->route('employees.index');
    }

    public function edit(Employee $employee): Response|ResponseFactory
    {
        $positions = Position::query()->select('id', 'name')->orderBy('name')->get();
        $manager = $employee->manager()->select('id', 'full_name')->first();

        return inertia('Employee/EditEmployee', [
            'employee' => $employee,
            'positions' => $positions,
            'manager' => $manager,
        ]);
    }

    /**
     * @throws Exception
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee): RedirectResponse
    {
        $data = $request->validated();
        $manager = null;
        if (!is_null($data['manager']['id'])) {
            $manager = Employee::query()->find($data['manager']['id']);
        }

        $this->employeeService->update($manager, $employee, $data);

        return redirect()->route('employees.index');
    }

    /**
     * @throws Exception
     */
    public function destroy(Employee $employee): RedirectResponse
    {
        $this->employeeService->destroy($employee);

        return redirect()->route('employees.index');
    }
}
