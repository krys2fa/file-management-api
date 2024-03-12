<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\FileResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\UpdateFileRequest;
use App\Models\File;


class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return FileResource::collection(File::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFileRequest $request)
    {

        Storage::disk('uploads')->makeDirectory('');

        $file = $request->file('file');

        $filename = uniqid().'.'.$file->getClientOriginalExtension();

        $file->storeAs('uploads', $filename);

        $filePath = Storage::disk('uploads')->path($filename);

        $file = File::create([
            'name' => $request->validated()['name'],
            'path' => $filePath,
            'type' => $request->validated()['type'],
        ]);

        return FileResource::make($file);
    }

    /**
     * Display the specified resource.
     */
    public function show(File $file)
    {
        return FileResource::make($file);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFileRequest $request, File $file)
    {
        $file->update($request->validated());

        return FileResource::make($file);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $file)
    {
        $file->delete();

        return response()->noContent();
    }
}
