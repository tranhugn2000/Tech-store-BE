<?php

namespace App\Services\Admin;

use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    protected $disk = 'public';
    protected $path = 'temporary_upload';
    protected $uploadPath = 'uploads';

    function __construct()
    {
    }

    public function getAllTempFile($tempFolder)
    {
        $files = Storage::files('public/uploads/tmp/' . $tempFolder);

        return $files;
    }
    
    public function saveFile($files, $path = null){
        $data = [];
        $path = $path ?? $this->path;
        if ($files != null) {
            if (is_array($files)) {
                foreach ($files as $file) {
                    $data[] = $this->putFile($file, $path);
                }
            } else {
                $data = $this->putFile($files, $path);
            }

            return $data;
        }
    }
    private function putFile($file, $folderName)
    {
        $fileName = $this->randNameFile($file);
        $path = $this->uploadPath . '/' . $folderName . '/';
        if (is_string($file)) {
            $file = Storage::disk($this->disk)->path($file);
        }
        if (Storage::disk($this->disk)->putFileAs($path, $file, $fileName)) {
            return $path . $fileName;
        }

        return false;
    }

    private function randNameFile($file)
    {
        if (is_string($file)) {
            $baseName = basename($file);
        } else {
            $baseName = $file->getClientOriginalName();
        }
        $fileName = preg_replace('/\s+/', '_', time() . '_' . $baseName);

        return $fileName;
    }

    public function deleteAllTempFile($tempFolder)
    {
        $files = Storage::files('public/uploads/tmp/' . $tempFolder);

        Storage::delete($files);
    }
}
