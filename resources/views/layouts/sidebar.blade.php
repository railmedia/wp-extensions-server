<ul class="navbar-nav sidebar-gradient main-gradient sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <span class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </span>
    </a>
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <span class="sidebar-brand-text mx-3">cloudWEB WP extensions server</span>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item active">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Navigation
    </div>

    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-toggle="collapse" data-toggle="collapse" href="#collapseExtensions" role="button" aria-expanded="false" aria-controls="collapseExtensions">
            <i class="fas fa-fw fa-cog"></i>
            <span>Extensions</span>
        </a>
        <div id="collapseExtensions" class="collapse">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('extensions.list') }}">View extensions</a>
                <a class="collapse-item" href="{{ route('extensions.create') }}">Add new extension</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" data-bs-toggle="collapse" data-toggle="collapse" href="#collapseUsers" role="button" aria-expanded="false" aria-controls="collapseUsers">
            <i class="fa-solid fa-user"></i>
            <span>Users</span>
        </a>
        <div id="collapseUsers" class="collapse">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('users.list') }}">View users</a>
                <a class="collapse-item" href="{{ route('users.create') }}">Add new user</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route( 'requests.list' ) }}" role="button" aria-expanded="false" aria-controls="Requests">
            <i class="fa-solid fa-right-left"></i>
            <span>Requests</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>