<x-app-layout>
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
    @if( $item->id )
        <h1 class="h3 mb-0 text-gray-800">Edit user</h1>
    @else
        <h1 class="h3 mb-0 text-gray-800">Create user</h1>
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
                            <a class="dropdown-item" href="{{ route( 'users.list') }}">View users</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                @if( empty( $item->id ) )
                    {!! Form::model( $item, [ 'url' => route( 'users.store' ), 'class' => 'create-edit-user', 'method' => 'post', 'files' => true ] ) !!}
                @else
                    {!! Form::model( $item, [ 'url' => route( 'users.update', ['user' => $item ] ), 'class' => 'create-edit-user', 'method' => 'put', 'files' => true ] ) !!}
                @endif
                <div class="mb-3">
                    {!! Form::label( 'name', 'Name*' ) !!}
                    {!! Form::text( 'name', old( 'name', $item->name ?? '' ), [ 'class' => 'form-control' ] ) !!}
                </div>
                <div class="mb-3">
                    {!! Form::label( 'email', 'E-mail*' ) !!}
                    {!! Form::text( 'email', old( 'email', $item->email ?? '' ), [ 'class' => 'form-control' ] ) !!}
                </div>
                @if( $item->id )
                    <a href="#!" id="change-user-pass">Change user's password</a>
                <div class="mb-3 password" style="display: none;">
                    <p>If you do not wish to change the user's password, please leave both fields empty.</p>
                    <button id="generate-password" type="button" class="btn btn-info text-white">Generate password</button>
                    <p style="margin: 10px 0 0 0;" id="generated-password"></p>
                </div>
                @endif
                <button id="generate-password" type="button" class="btn btn-info text-white">Generate password</button>
                <p style="margin: 10px 0 0 0;" id="generated-password"></p>
                <div class="mb-3 password" style="@if( $item->id ) display: none; @endif">
                    {!! Form::label( 'password', 'Password*' ) !!}
                    {!! Form::password( 'password', [ 'class' => 'form-control' ] ) !!}
                </div>
                <div class="mb-3 confirm-password" style="@if( $item->id ) display: none; @endif">
                    {!! Form::label( 'password_confirmation', 'Confirm password*' ) !!}
                    {!! Form::password( 'password_confirmation', [ 'class' => 'form-control' ] ) !!}
                </div>
                <!-- Add checkbox - notify user -->
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