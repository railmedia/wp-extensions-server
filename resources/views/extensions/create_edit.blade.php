<x-app-layout>
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
    @if( $item->id )
        <h1 class="h3 mb-0 text-gray-800">Edit extension</h1>
    @else
        <h1 class="h3 mb-0 text-gray-800">Create extension</h1>
    @endif
    </div>
    
    <div class="row">
        @include( 'common.errors' )
        @include( 'common.session_messages' )
        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Form</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="{{ route( 'extensions.list') }}">View extensions</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                @if( empty( $item->id ) )
                    {!! Form::model( $item, [ 'url' => route( 'extensions.store' ), 'class' => 'create-edit-extension', 'method' => 'post', 'files' => true ] ) !!}
                @else
                    {!! Form::model( $item, [ 'url' => route( 'extensions.update', ['extension' => $item ] ), 'class' => 'create-edit-extension', 'method' => 'put', 'files' => true ] ) !!}
                @endif
                <div class="mb-3">
                    {!! Form::label( 'name', 'Name*' ) !!}
                    {!! Form::text( 'name', old( 'name', $item->name ?? '' ), [ 'class' => 'form-control' ] ) !!}
                </div>
                <div class="mb-3">
                    {!! Form::label( 'slug', 'Slug' ) !!}
                    {!! Form::text( 'slug', old( 'slug', $item->slug ?? '' ), [ 'class' => 'form-control', 'placeholder' => 'Slug will get automatically generated after you add a name for the extension' ] ) !!}
                </div>
                <div class="mb-3">
                    {!! Form::label( 'type', 'Type' ) !!}
                    {!! Form::select( 'type', ['plugin' => 'Plugin', 'theme' => 'Theme'], old('type', $item->type ?? 'plugin'), [ 'class' => 'form-control' ] ) !!}
                </div>
                <div class="mb-3">
                    {!! Form::label( 'description', 'Description' ) !!}
                    {!! Form::textarea( 'description', old( 'description', $item->description ?? '' ), [ 'class' => 'form-control' ] ) !!}
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-success text-white">
                        Save
                    </button>
                </div>
                {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>