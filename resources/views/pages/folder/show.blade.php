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
                        <input type="text" name="search" class="form-control" placeholder="Search by name or extension"
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                    <div class="input-group mb-3">
                        <select name="sort" class="form-control">
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Sort by Name
                                (A-Z)</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Sort by Name
                                (Z-A)</option>
                            <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Sort by Date
                                (Oldest)</option>
                            <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Sort by Date
                                (Newest)</option>
                        </select>
                        <button type="submit" class="btn btn-primary ml-2">Sort</button>
                    </div>
                </form>
            </div>

            <div class="d-flex justify-content-between mb-3">
                <a href="{{ route('folder.index') }}" class="btn btn-primary"><i class="fa-solid fa-arrow-left"></i>
                    Back</a>
                <button class="btn btn-primary" id="toggle-modal-2">Add File</button>
            </div>

            <!-- Gallery wrapper -->
            <div class="container mt-4">
                <div class="row">
                    <!-- Gallery item -->
                    @foreach ($files as $file)
                        <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                            <div class="card text-center h-100" style="box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
                                <a href="{{ $file->url }}" class="glightbox" data-gallery="gallery">
                                    <img data-src="{{ $file->url }}" class="card-img-top mx-auto d-block mt-3 lazyload"
                                        alt="{{ $file->name }}"
                                        style="width: 100px; height: 100px;">
                                </a>
                                <div class="card-body d-flex flex-column justify-content-center">
                                    <p class="card-text mt-2 summary">{{ Str::limit($file->name, 20) }}</p>
                                    <p class="card-text mt-2 complex-name d-none">{{ $file->name }}</p>
                                    <button class="btn btn-link read-more-btn p-0">Read More</button>
                                    <!-- Delete button -->
                                    <form action="{{ route('file.destroy', $file->id) }}" method="POST" class="mt-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
                        <input type="hidden" name="folder_id" value="{{ $folder->id }}">
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

@section('scripts')
    <!-- Add GLightbox JS at the end of the body section -->
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js" async></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const lightbox = GLightbox({
                selector: '.glightbox',
                touchNavigation: true,
                loop: true,
                autoplayVideos: true
            });
        });
    </script>
@endsection
