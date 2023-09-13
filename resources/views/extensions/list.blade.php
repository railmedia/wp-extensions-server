<x-app-layout>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Extensions</h1>
        <a class="btn btn-primary text-white" href="{{ route( 'extensions.create' ) }}">Add extension</a>
    </div>
    
    <div class="row">
        @include( 'common.session_messages' )
        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Extensions list</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="{{ route( 'extensions.create') }}">Add extension</a>
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
                            <th scope="col">Slug</th>
                            <th scope="col">Update URL</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $items as $idx => $item )
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->slug }}</td>
                            <td><a href="{{ url('/') }}/extension/{{ $item->slug }}" target="_blank" rel="noopener noreferrer">{{ url('/') }}/extension/{{ $item->slug }}</a></td>
                            <td width="10%">
                                <a class="mr-2 text-decoration-none" href="{{ route( 'extensions.edit', [ 'extension' => $item ] ) }}" title="Edit extension">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <a class="mr-2 text-decoration-none" href="{{ route( 'extensions.upload_form', ['extension' => $item] ) }}" title="Upload extension file">
                                    <i class="fa-solid fa-folder-open"></i>
                                </a>
                                <a class="mr-2 text-green text-decoration-none" href="{{ route( 'extensions.view_manifest', [ 'extension' => $item ] ) }}" title="Edit Manifest">
                                    <i class="fa-solid fa-code"></i>
                                </a>
                                {!! Form::model( $item, [ 'url' => route( 'extensions.delete', ['extension' => $item->id] ), 'method' => 'post', 'style' => 'display: inline;' ] ) !!}
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure?')" class="text-red-400" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @else
                    <p>No extensions added. <a href="{{ route( 'extensions.create') }}">Add an extension</a></p>
                    @endif
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
