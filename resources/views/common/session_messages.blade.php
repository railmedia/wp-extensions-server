@if (session('message'))
<div class="col-xl-12 col-lg-7">
    <div class="alert alert-primary">
        <ul style="margin:0">
            <li>{{ session('message') }}</li>
        </ul>
    </div>
</div>
@endif

@if (session('message-success'))
<div class="col-xl-12 col-lg-7">
    <div class="alert alert-success">
        <ul style="margin:0">
            <li>{{ session('message-success') }}</li>
        </ul>
    </div>
</div>
@endif