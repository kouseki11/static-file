<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand mt-4 mb-3">
            <div class="logo">
                <img class="mb-1 rounded-circle" src="{{ asset('assets') }}/img/logo.png" alt="" width="50" height="50" >
                <a href="">Shinkai</a>
            </div>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <img src="{{ asset('assets') }}/img/logo.png" alt="" width="50" height="50">
        </div>
        <ul class="sidebar-menu">
            {{-- <li><a class="nav-link <?= $page == 'dashboard' ? 'active' : '' ?>" href="/"><i class="fa-solid fa-house"></i> <span>Dashboard</span></a></li> --}}
            <li><a class="nav-link <?= $page == 'user' ? 'active' : '' ?>" href="/user"><i class="fa-solid fa-user"></i> <span>User</span></a></li>
            <li class="nav-item dropdown <?= $page == 'folder' || $page == 'file' ? 'active' : '' ?>">
                <a href="#" class="nav-link has-dropdown"><i class="fa-solid fa-gear"></i>
                    <span>File System</span></a>
                <ul class="dropdown-menu">
                    <li class=" <?= $page == 'folder' ? 'active' : '' ?>"><a class="nav-link" href="/folder"><i class="fa-solid fa-folder-open"></i> <span>Folder</span></a></li>
                    {{-- <li class=" <?= $page == 'file' ? 'active' : '' ?>"><a class="nav-link" href="/file"><i class="fa-solid fa-copy"></i> <span>File</span></a></li> --}}
                </ul>
                {{-- <li class="nav-item dropdown mb-3">
                    <a href="#" class="nav-link has-dropdown"><i class="fa-solid fa-plus-square"></i>
                        <span>Create Folder & File</span></a>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="#"
                                data-toggle="modal" data-target="#albumModal"><i class="fa-solid  fa-folder"></i>
                                <span>Folder</span></a></li>
                    </ul>
                    <ul class="dropdown-menu">
                        <li><a class="nav-link" href="#"
                                data-toggle="modal" data-target="#photoModal"><i class="fa-solid  fa-file"></i>
                                <span>File</span></a></li>
                    </ul>
                </li> --}}
            </li>
        </ul>
    </aside>
</div>
