@extends('layouts.msgmaster')

@section('content')
    <div class="col-md-12">
        <div class="mb-3">
            <h1 class="d-inline">{{ $thread->subject }}</h1>
            <a href="{{route('messages')}}" class="btn btn-secondary float-end mt-2">Back</a> 
        </div>
        @each('messenger.partials.messages', $thread->messages, 'message')

        @include('messenger.partials.form-message')
    </div>
@stop

@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        $('.img-avatar').each(function() {
            var img_ele = $(this);
            var img = new Image();
            var url = $(this).attr('src');
            img.onerror = function() {
                console.log('error image', img_ele)
                $(img_ele).attr('src', '{{asset("storage/users/default.png")}}')

            }
            img.src = url;
        });
    })
</script>
@endsection