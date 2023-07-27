<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UploadFileController extends Controller
{
    private $fileUploadService;

    function __construct(FileUploadService $fileUploadService){
        $this->fileUploadService = $fileUploadService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $tempFolder = 'tmp/products/';
        if (isset($data['files'])) {
            $this->fileUploadService->saveFile($data['files'], $tempFolder);

            return response()->json([
                "success" => true
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteAllTempFile($tempFolder)
    {
        $this->fileUploadService->deleteAllTempFile($tempFolder);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($imageName)
    { 
        $imageName = str_replace(" ", "_", $imageName);
        $storage = Storage::disk('public');
        $files = File::allFiles($storage->path('uploads/tmp/products/'));
        if (isset($imageName)) {
            foreach ($files as $file) {
                $filePath = $file->getRealPath();
                $fileName = basename($filePath);
                $parts = strpos($fileName, "_");
                $fileNameDelete =substr($fileName, $parts + 1);
                
                if ($fileNameDelete == $imageName) {
                    File::delete($filePath);                
                }
                
            }
        }
        return response()->json([
            'success' => true,
        ]);
    }

}
