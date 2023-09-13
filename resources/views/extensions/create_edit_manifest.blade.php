<x-app-layout>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Extension manifest</h1>
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
                {!! Form::model( $item, [ 'url' => route( 'extensions.save_manifest', ['extension' => $item ] ), 'class' => 'extension-manifest', 'method' => 'post', 'files' => true ] ) !!}
                <div class="mb-3">
                    {!! Form::label( 'name', 'Name*' ) !!}
                    {!! Form::text( 'name', old( 'name', $manifest['name'] ?? '' ), [ 'class' => 'form-control' ] ) !!}
                </div>
                <div class="mb-3">
                    {!! Form::label( 'slug', 'Slug*' ) !!}
                    {!! Form::text( 'slug', old( 'slug', $manifest['slug'] ?? '' ), [ 'class' => 'form-control' ] ) !!}
                </div>
                <div class="mb-3">
                    {!! Form::label( 'author', 'Author*' ) !!}
                    {!! Form::text( 'author', old( 'author', $manifest['author'] ?? '' ), [ 'class' => 'form-control' ] ) !!}
                </div>
                <div class="mb-3">
                    {!! Form::label( 'author_profile', 'Author profile URL*' ) !!}
                    {!! Form::text( 'author_profile', old( 'author_profile', $manifest['author_profile'] ?? '' ), [ 'class' => 'form-control' ] ) !!}
                </div>
                <div class="mb-3">
                    {!! Form::label( 'version', 'Version*' ) !!}
                    {!! Form::text( 'version', old( 'version', $manifest['version'] ?? '' ), [ 'class' => 'form-control' ] ) !!}
                </div>
                <div class="mb-3">
                    {!! Form::label( 'download_url', 'Download URL' ) !!}
                    <p>{{ url('/') }}/extensions-uploads/{{ $item->slug }}/{{ $item->slug }}.zip</p>
                    {!! Form::hidden( 'download_url', url('/') . '/extensions-uploads/' . $item->slug . '/' . $item->slug . '.zip', [ 'class' => 'form-control' ] ) !!}
                </div>
                <div class="mb-3">
                    {!! Form::label( 'requires', 'Requires WP version*' ) !!}
                    {!! Form::text( 'requires', old( 'requires', $manifest['requires'] ?? '' ), [ 'class' => 'form-control' ] ) !!}
                </div>
                <div class="mb-3">
                    {!! Form::label( 'tested', 'Tested up to WP version*' ) !!}
                    {!! Form::text( 'tested', old( 'tested', $manifest['tested'] ?? '' ), [ 'class' => 'form-control' ] ) !!}
                </div>
                <div class="mb-3">
                    {!! Form::label( 'requires_php', 'PHP version required*' ) !!}
                    {!! Form::text( 'requires_php', old( 'requires_php', $manifest['requires_php'] ?? '' ), [ 'class' => 'form-control' ] ) !!}
                </div>
                <div class="mb-3">
                    {!! Form::label( 'last_updated', 'Last updated date*' ) !!}
                    {!! Form::text( 'last_updated', old( 'last_updated', $manifest['last_updated'] ?? '' ), [ 'class' => 'form-control' ] ) !!}
                </div>
                @if( $item->type == 'plugin' )
                <div class="mb-3">
                    {!! Form::label( 'icon', 'Icon ( 128px x 128px | JPG / PNG | max. 2MB )' ) !!}
                    @if( isset( $manifest['icons']['default'] ) && $manifest['icons']['default'] )
                        <a href="{{ $manifest['icons']['default'] }}" target="_blank" rel="noreferrer noopener">
                            Current icon image
                        </a>
                    @endif
                    {!! Form::file( 'icon', [ 'class' => 'form-control' ] ) !!}
                </div>
                <div class="mb-3">
                    {!! Form::label( 'banner_low', 'Banner low - 772px x 250px | JPG / PNG | max. 2MB' ) !!}
                    @if( isset( $manifest['banners']['low'] ) && $manifest['banners']['low'] )
                        <a href="{{ $manifest['banners']['low'] }}" target="_blank" rel="noreferrer noopener">
                            Current banner low image
                        </a>
                    @endif
                    {!! Form::file( 'banner_low', [ 'class' => 'form-control' ] ) !!}
                </div>
                <div class="mb-3">
                    {!! Form::label( 'banner_high', 'Banner high - 1544px x 500px | JPG / PNG | max. 2MB' ) !!}
                    @if( isset( $manifest['banners']['high'] ) && $manifest['banners']['high'] )
                        <a href="{{ $manifest['banners']['high'] }}" target="_blank" rel="noreferrer noopener">
                            Current banner high image
                        </a>
                    @endif
                    {!! Form::file( 'banner_high', [ 'class' => 'form-control' ] ) !!}
                </div>
                @endif
                @if( $item->type == 'theme' )
                <div class="mb-3">
                    {!! Form::label( 'screenshot', 'Screenshot ( 1200px x 900px | JPG / PNG | max. 2MB )' ) !!}
                    {!! Form::file( 'screenshot', [ 'class' => 'form-control' ] ) !!}
                </div>
                @endif
                <div class="mb-3">
                    {!! Form::label( 'description', 'Description*' ) !!}
                    {!! Form::textarea( 'description', old( 'description', $manifest['sections']['description'] ?? '' ), [ 'class' => 'form-control' ] ) !!}
                </div>
                <div class="mb-3">
                    {!! Form::label( 'installation', 'Installation instructions*' ) !!}
                    {!! Form::textarea( 'installation', old( 'installation', $manifest['sections']['installation'] ?? '' ), [ 'class' => 'form-control' ] ) !!}
                </div>
                <div class="mb-3">
                    {!! Form::label( 'changelog', 'Change Log*' ) !!}
                    {!! Form::textarea( 'changelog', old( 'changelog', $manifest['sections']['changelog'] ?? '' ), [ 'class' => 'form-control' ] ) !!}
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