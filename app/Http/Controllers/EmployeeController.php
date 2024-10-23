<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEmployeeRequest;
use App\Models\Employee;
use App\Models\Position;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $names = Employee::query()
            ->select('id', 'full_name')
            ->where('rank', '>', 1)
            ->whereLike('full_name', '%' . $name . '%')
            ->take(5)
            ->get();

        return response()->json(['names' => $names]);
    }

    /**
     * @throws Exception
     */
    public function create(CreateEmployeeRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $managerId = $data['manager']['id'];
        $manager = Employee::query()->where('id', $managerId)->first();
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
            ]);

            if (isset($data['photo'])) {
                $imageManager = new ImageManager(new Driver());
                $image = $imageManager->read($data['photo']->getRealPath());
                $image->crop(300, 300, position: 'center');
                $encodedImage = $image->encode(new JpegEncoder(80));

//                if (Storage::directoryExists($photoPath))
                $photoPath = $employee->photo_path . Str::random(10) . '.jpg';
                Storage::disk('public')->makeDirectory($employee->photo_path);
                $encodedImage->save(Storage::disk('public')->path($photoPath));

                $employee->update(['photo' => $photoPath]);
            }
//            $originalNameMin = 'min_' . $randomName . '.' . $data['photo']->getClientOriginalExtension();
//            $data['photo']->storeAs('public/images/' . $employee->id, $photoName);

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        return redirect()->route('employees.index');
    }
}
