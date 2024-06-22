<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Folder;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Validate the request
            $validator = Validator::make($request->all(), [
                'file' => 'required|file|mimes:jpg,jpeg,png,gif,webp', // Add validation rules as needed
                'folder_id' => 'required|integer|exists:folders,id' // Ensure folder_id is valid
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Handle the uploaded file
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $folderId = $request->input('folder_id');

            // Retrieve the folder information
            $folder = Folder::findOrFail($folderId);

            // Define the file name to save
            $name = pathinfo($originalName, PATHINFO_FILENAME) . '_' . time() . '.' . $extension;

            // Construct the file path
            $filePath = 'uploads/' . $folder->slug;

            // Ensure the directory exists
            if (!file_exists(public_path($filePath))) {
                mkdir(public_path($filePath), 0755, true);
            }

            // Move the file to the constructed path
            $file->move(public_path($filePath), $name);

            // Generate the URL using asset()
            $imagePath = $filePath . '/' . $name;
            $fileUrl = asset($imagePath);

            // Create data array to store in the database
            $data = [
                'name' => $name,
                'extension' => $extension,
                'folder_id' => $folderId,
                'path' => $imagePath,
                'url' => $fileUrl,
            ];

            // Save the file information to the database
            File::create($data);

            DB::commit();

            // Redirect back with success message
            Alert::success('File created successfully.');
            return redirect()->back()->with('success', 'File Successfully Added.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::debug('FileController store() ' . $e->getMessage());
            Alert::error('File created failed.');
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(File $file)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $file = File::find($id);
            //delete file with file in public
            if (file_exists(public_path($file->path))) {
                unlink(public_path($file->path));
            }
            //delete file in database
            $file->delete();

            Alert::success('File deleted successfully.');
            return redirect()->back()->with('success', 'File Successfully Deleted.');
        } catch (Exception $e) {
            Log::debug('FileController destroy() ' . $e->getMessage());
            Alert::error('File deleted failed.');
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
