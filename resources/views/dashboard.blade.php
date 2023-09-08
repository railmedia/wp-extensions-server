<x-app-layout>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>
    
    <div class="row">

        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Latest extensions</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="{{ route( 'extensions.list' ) }}">View all extensions</a>
                            <a class="dropdown-item" href="{{ route( 'extensions.create' ) }}">Add extension</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if( $extensions )
                    <ul class="list-none p-0 m-0">
                    @foreach( $extensions as $extension )
                        <li class="flex justify-between">
                            <span>{{ $extension->name }}</span>
                            <span>Added: {{ date( 'd.m.Y H:i:s', strtotime( $extension->created_at ) ) }}</span>
                            <span><a href="{{ route( 'extensions.edit', [ 'extension' => $extension ] ) }}">Edit</a></span>
                        </li>
                    @endforeach
                    </ul>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Latest users</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="{{ route( 'users.list' ) }}">View all users</a>
                            <a class="dropdown-item" href="{{ route( 'users.create' ) }}">Add user</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                @if( $users )
                    <ul class="list-none p-0 m-0">
                    @foreach( $users as $user )
                        <li class="flex justify-between">
                            <span>{{ $user->name }}</span>
                            <span>Added: {{ date( 'd.m.Y H:i:s', strtotime( $user->created_at ) ) }}</span>
                            <span><a href="{{ route( 'users.edit', [ 'user' => $user ] ) }}">Edit</a></span>
                        </li>
                    @endforeach
                    </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
