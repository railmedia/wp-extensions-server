@if( isset( $manifest['screenshot_url'] ) && $manifest['screenshot_url'] )
<p style="text-align: center;"><img style="max-width: 500px;" src="{{ $manifest['screenshot_url'] }}" /></p>
@endif
<div style="font-family: sans-serif;">@php echo $manifest['sections']['description']; @endphp</div>