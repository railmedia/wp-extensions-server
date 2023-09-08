<x-app-layout>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Users</h1>
        <a class="btn btn-primary text-white" href="{{ route( 'users.create' ) }}">Add user</a>
    </div>
    
    <div class="row">
        @include( 'common.session_messages' )
        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Users list</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="{{ route( 'users.create') }}">Add user</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if( count( $items ) )
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Registered</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $items as $idx => $item )
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ date( 'd.m.Y H:i:s', strtotime( $item->created_at ) ) }} </td>
                            <td class="d-flex">
                                <a class="mr-2" href="{{ route( 'users.edit', [ 'user' => $item ] ) }}" title="Edit">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                @if( $item->id != Auth::user()->id )
                                {!! Form::model( $item, [ 'url' => route( 'users.delete', ['user' => $item->id] ), 'method' => 'post' ] ) !!}
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure?')" class="text-red-400" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                {!! Form::close() !!}
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @else
                    <p>No users added. <a href="{{ route( 'users.create') }}">Add a user</a></p>
                    @endif
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
