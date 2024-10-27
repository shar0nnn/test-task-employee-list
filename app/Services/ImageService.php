<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\Drivers\Imagick\Encoders\JpegEncoder;
use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\EncodedImageInterface;
use Intervention\Image\Interfaces\ImageInterface;

class ImageService
{
    public function __construct(private $imageManager = new ImageManager(new Driver()))
    {
    }

    public function upload(UploadedFile $file, string $path): string
    {
        $image = $this->imageManager->read($file->getRealPath());
        $encodedImage = $this->cropAndEncode($image);

        Storage::disk('public')->makeDirectory($path);
        $photoPath = $path . Str::random(10) . '.jpg';
        $encodedImage->save(Storage::disk('public')->path($photoPath));

        return $photoPath;
    }

    private function cropAndEncode(ImageInterface $image, int $width = 300, int $height = 300, string $position = 'center'): EncodedImageInterface
    {
        return $image
            ->crop($width, $height, position: $position)
            ->encode(new JpegEncoder(80));
    }

    public function delete(string $path): void
    {
        $arr = explode('/', $path);
        array_pop($arr);

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->deleteDirectory(implode('/', $arr));
        }
    }
}
