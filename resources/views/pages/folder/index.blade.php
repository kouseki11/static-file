@extends('layout.master')

@section('navbar-sidebar')
    @include('component._navbar')
    @include('component._sidebar')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <form action="" method="GET">
                    <div class="input-group mb-3">
                        <input type="text" name="search" class="form-control" placeholder="Search by name"
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                    <div class="input-group mb-3">
                        <select name="sort" class="form-control">
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Sort by Name (A-Z)</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Sort by Name (Z-A)</option>
                            <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Sort by Date (Oldest)</option>
                            <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Sort by Date (Newest)</option>
                        </select>
                        <button type="submit" class="btn btn-primary ml-2">Sort</button>
                    </div>
                </form>                
            </div>

            <div class="d-flex justify-content-lg-end mb-3" style="gap: 10px;">
                <button class="btn btn-primary" id="toggle-modal-1">Add Folder</button>
                <button class="btn btn-primary" id="toggle-modal-2">Add File</button>
            </div>

            <!-- Gallery wrapper -->
            <div class="container mt-4">
                <div class="row">
                    <!-- Gallery item -->
                    @foreach ($folders as $folder)
                        <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                            <div class="card text-center h-100">
                                <a href="{{ route('folder.show', $folder->slug) }}" class="text-decoration-none">
                                    <img src="{{ asset('assets/img/folder.png') }}"
                                        class="card-img-top mx-auto d-block mt-3" alt="Folder Icon"
                                        style="width: 72px; height: 72px;">
                                    <div class="card-body d-flex flex-column justify-content-center">
                                        <p class="card-text mt-2">{{ $folder->name }}</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            {{ $folders->appends(request()->input())->links() }}


        </div>
    </div>

    <!-- Modal for adding a folder -->
    <div id="addFolderModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addFolderModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFolderModalLabel">Add Folder</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('folder.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="folderName">Folder Name</label>
                            <input type="text" class="form-control" id="folderName" name="name" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Add Folder</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for adding a file -->
    <div id="addFileModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addFileModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFileModalLabel">Add File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('file.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="folder_id">Select Folder</label>
                            <select class="form-control" id="folder_id" name="folder_id" required>
                                <option value="">Choose Folder</option>
                                @foreach ($folders as $folder)
                                    <option value="{{ $folder->id }}">{{ $folder->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="file">File</label>
                            <input type="file" class="form-control" id="file" name="file" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add File</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
