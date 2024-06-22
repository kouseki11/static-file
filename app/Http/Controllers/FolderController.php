<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Folder;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class FolderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $title = 'Folder List';
        $page = 'folder';
        $query = Folder::query();

        // Search functionality
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");
        }

        // Sorting functionality
        if ($request->has('sort')) {
            $sort = $request->input('sort');
            switch ($sort) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'date_asc':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'date_desc':
                    $query->orderBy('created_at', 'desc');
                    break;
            }
        }

        // Pagination with sorting applied
        $folders = $query->paginate(8);
        return view('pages.folder.index', compact('title', 'page', 'folders'));
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
            // Validate the request if needed
            $request->validate([
                'name' => 'required|string|max:255|unique:folders', // Example validation rules
            ]);

            // Create folder
            $folder = new Folder();
            $folder->name = $request->name;

            // Generate and set slug
            $slug = Str::slug($request->name, '-'); // Generate slug from name
            $folder->slug = $slug;

            $folder->save();

            DB::commit();

            // Optionally, you can return a response or redirect to a different page
            Alert::success('Folder created successfully.');
            return redirect()->route('folder.index')->with('success', 'Folder created successfully.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::debug('FolderController store() ' . $e->getMessage());
            Alert::error('Folder created failed.');
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $slug)
{
    // Retrieve all folders
    $folders = Folder::all();

    // Find the folder by slug
    $folder = Folder::where('slug', $slug)->firstOrFail();

    // Set the title and page variables
    $title = 'Folder ' . $folder->name;
    $page = 'folder';

    // Create a new query for the files
    $query = File::where('folder_id', $folder->id);

    // Search functionality
    if ($request->has('search')) {
        $search = $request->input('search');
        $query->where(function($query) use ($search) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('extension', 'like', "%{$search}%");
        });
    }

    // Sorting functionality
    if ($request->has('sort')) {
        $sort = $request->input('sort');
        switch ($sort) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'date_asc':
                $query->orderBy('created_at', 'asc');
                break;
            case 'date_desc':
                $query->orderBy('created_at', 'desc');
                break;
        }
    }

    // Pagination with sorting applied
    $files = $query->paginate(8);

    // Return the view with the folder, files, title, and page variables
    return view('pages.folder.show', compact('title', 'page', 'folder', 'files', 'folders'));
}



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Folder $folder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Folder $folder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Folder $folder)
    {
        //
    }
}
