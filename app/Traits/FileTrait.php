<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

trait FileTrait
{
    private const STORAGE_DISK = 's3';

    public function upload(string $folder, UploadedFile $file, ?string $name = null): string
    {
        $name ??= str()->uuid();
        $name .= '.'.$file->extension();
        $path = $file->storeAs($folder, $name, self::STORAGE_DISK);

        if (! $path) {
            throw new RuntimeException(
                __('exception.upload')
            );
        }

        return $path;
    }

    public function existsFile(string $path): bool
    {
        return Storage::disk(self::STORAGE_DISK)->exists($path);
    }

    public function getFile(string $path): string
    {
        return Storage::disk(self::STORAGE_DISK)->get($path);
    }

    public function deleteFile(string $path): bool
    {
        return Storage::disk(self::STORAGE_DISK)->delete($path);
    }
}
