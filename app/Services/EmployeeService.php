<?php

namespace App\Services;

use App\Models\Employee;
use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Drivers\Imagick\Encoders\JpegEncoder;
use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\EncodedImageInterface;
use Intervention\Image\Interfaces\ImageInterface;

class EmployeeService
{
    public function __construct(private ImageService $imageService)
    {
    }

    /**
     * @throws Exception
     */
    public function store(array $data, int $managerId): void
    {
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
    }

    /**
     * @throws Exception
     */
    public function update(?Employee $manager, Employee $employee, array $data): void
    {
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
        }
    }

    /**
     * @throws Exception
     */
    public function destroy(Employee $employee): void
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
    }
}
