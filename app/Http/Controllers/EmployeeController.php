<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use App\Models\Position;
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
    public function __construct(private ImageService $imageService)
    {
    }

    public function index(): Response|ResponseFactory
    {
        return inertia('Employee/EmployeeList');
    }

    public function getEmployees(Request $request)
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

        try {
            DB::beginTransaction();

            $employee = Employee::query()->create([
                'full_name' => $data['fullName'],
                'position_id' => $data['position'],
                'salary' => $data['salary'],
                'hired_at' => $data['hiredAt'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'manager_id' => $managerId,
                'rank' => $data['rank'],
                'admin_created_id' => auth()->id(),
            ]);

            if (isset($data['photo'])) {
                $photoPath = $this->imageService->upload($data['photo'], $employee->photo_path);
                $employee->update(['photo' => $photoPath]);
            }

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
        }

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

    public function update(UpdateEmployeeRequest $request, Employee $employee): RedirectResponse
    {
        $data = $request->validated();
        if (!is_null($data['manager']['id'])) {
            $manager = Employee::query()->find($data['manager']['id']);
        }

        try {
            DB::beginTransaction();

            $employee->update([
                'full_name' => $data['fullName'],
                'position_id' => $data['position'],
                'salary' => $data['salary'],
                'hired_at' => $data['hiredAt'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'manager_id' => is_null($data['manager']['id']) ? null : $manager->id,
                'rank' => is_null($data['manager']['id']) ? $employee->rank : $manager->rank - 1,
                'admin_updated_id' => auth()->id(),
            ]);

            if (isset($data['photo'])) {
                if ($employee->photo) {
                    $this->imageService->delete($employee->photo);
                }
                $photoPath = $this->imageService->upload($data['photo'], $employee->photo_path);

                $employee->update(['photo' => $photoPath]);
            }

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
        };

        return redirect()->route('employees.index');
    }

    /**
     * @throws Exception
     */
    public function destroy(Employee $employee): RedirectResponse
    {
        try {
            DB::beginTransaction();

            if ($employee->rank > 1) {
                $subordinates = $employee->subordinates;
                $managersId = Employee::query()
                    ->where('rank', $employee->rank)
                    ->whereKeyNot($employee->id)
                    ->pluck('id');

                foreach ($subordinates as $subordinate) {
                    $subordinate->manager_id = $managersId->random();
                    $subordinate->save();
                }
            }

            if ($employee->photo) {
                $this->imageService->delete($employee->photo);
            }
            $employee->delete();

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error($exception->getMessage());
        }

        return redirect()->route('employees.index');
    }
}
