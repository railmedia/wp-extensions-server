<x-app-layout>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Site Requests</h1>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Search requests</h6>
                </div>
                <form action="{{ route('requests.search', []) }}" method="post" id="requests-search">
                <div class="card-body flex justify-between">
                    @csrf <!-- {{ csrf_field() }} -->
                    <div>
                        {!! Form::label( 'site', 'Site', [ 'style' => 'display: block;' ] ) !!}
                        {!! Form::select( 'site', $search_terms, old( 'site', $search_data['site'] ?? '' ), [ 'class' => 'cw-ext-select form-select' ] ) !!}
                    </div>
                    <div>
                        {!! Form::label( 'date_from', 'Date from', [ 'style' => 'display: block;' ] ) !!}
                        {!! Form::text( 'date_from', old( 'date_from', $search_data['date_from'] ?? '' ), [ 'class' => 'cw-ext-datepicker form-control' ] ) !!}
                    </div>
                    <div>
                        {!! Form::label( 'date_to', 'Date to', [ 'style' => 'display: block;' ] ) !!}
                        {!! Form::text( 'date_to', old( 'date_to', $search_data['date_to'] ), [ 'class' => 'cw-ext-datepicker form-control' ] ) !!}
                    </div>
                    <div>
                        <button id="trigger-search-requests" type="submit" class="btn btn-success text-white">
                            Search
                        </button>
                        @if( $search_data['site'] || $search_data['date_from'] || $search_data['date_to'] )
                        <a href="{{ route('requests.list') }}" id="trigger-search-requests">
                            Clear filters
                        </a>
                        @endif
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        @include( 'common.session_messages' )
        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Requests list (last 20)</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if( $items && count( $items ) )
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Site</th>
                            <th scope="col">Extension</th>
                            <th scope="col">Date/time</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $items as $idx => $item )
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td>{{ $item->site->host }}</td>
                            <td>{{ $item->extension->name }}</td>
                            <td>{{ date( 'd.m.Y H:i:s', strtotime( $item->created_at ) ) }} </td>
                            <td class="d-flex">
                                <a class="mr-2" href="{{ route( 'requests.show', [ 'request' => $item ] ) }}" title="View">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                {!! Form::model( $item, [ 'url' => route( 'requests.delete', ['request' => $item->id] ), 'method' => 'post' ] ) !!}
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
                    <p>No requests found. Please try again later</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @push('bottom-page-scripts')
        @vite(['resources/js/siteRequests.js'])
    @endpush
</x-app-layout>
