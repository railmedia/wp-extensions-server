@if ($errors->any())
<div class="col-xl-12 col-lg-7">
    <div class="alert alert-danger">
        <ul style="margin:0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
</div>
@endif