<x-app-layout>
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Extension file - {{ $item->name }}</h1>
    </div>
    
    <div class="row">
        @include( 'common.errors' )
        @include( 'common.session_messages' )
        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">File</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="{{ route( 'extensions.list') }}">View extensions</a>
                            <a class="dropdown-item" href="{{ route( 'extensions.create') }}">Add extension</a>
                            <a class="dropdown-item" href="{{ route( 'extensions.view_manifest', [ 'extension' => $item ] ) }}">{{ $item->name }} Manifest</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {!! Form::model( $item, [ 'url' => route( 'extensions.upload', ['extension' => $item] ), 'class' => 'upload-extension-file', 'method' => 'post', 'files' => true ] ) !!}
                    <div class="mb-3">
                    @if( $file )
                    <p><a href="{{ $file }}">Download current file</a></p>
                    @endif
                    {!! Form::label( 'file', 'File*' ) !!}
                    {!! Form::file( 'file', [ 'class' => 'form-control' ] ) !!}
                    </div>
                    <div class="mb-3">
                    <p>Only zip files allowed. Please upload a file named {{ $item->slug }}.zip of maximum {{ ini_get('upload_max_filesize') }} in size. If the file is too large, please use FTP to upload to /public/extensions/{{ $item->slug }} folder.</p>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-success text-white">
                            Save
                        </button>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="mb-3 p-3">
                    <a href="{{ route( 'extensions.list') }}">
                        Back to overview
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>