<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    /**
     * Upload a file to storage
     *
     * @param UploadedFile $file
     * @param string $folder
     * @param string|null $filename
     * @return string|false
     */
    public function uploadFile(UploadedFile $file, string $folder = 'uploads', ?string $filename = null)
    {
        // Generate a unique filename if not provided
        $filename = $filename ?? Str::random(20) . '.' . $file->getClientOriginalExtension();

        // Store the file in the public disk
        $path = $file->storeAs($folder, $filename, 'public');

        return $path ? $path : false;
    }

    /**
     * Upload video file
     *
     * @param UploadedFile $file
     * @param string|null $filename
     * @return string|false
     */
    public function uploadVideo(UploadedFile $file, ?string $filename = null)
    {
        return $this->uploadFile($file, 'videos', $filename);
    }

    /**
     * Upload image file
     *
     * @param UploadedFile $file
     * @param string|null $filename
     * @return string|false
     */
    public function uploadImage(UploadedFile $file, ?string $filename = null)
    {
        return $this->uploadFile($file, 'images', $filename);
    }

    /**
     * Delete a file from storage
     *
     * @param string $path
     * @return bool
     */
    public function deleteFile(string $path)
    {
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }

        return false;
    }

    /**
     * Get the full URL of a file
     *
     * @param string $path
     * @return string
     */
    public function getFileUrl(string $path)
    {
        return Storage::disk('public')->url($path);
    }
}
