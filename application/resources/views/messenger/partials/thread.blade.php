<?php $class = $thread->isUnread(Auth::id()) ? ' bg-warning' : ''; ?>

{{--<div class="media alert {{ $class }}">
    <h4 class="media-heading">
        <a href="{{ route('messages.show', $thread->id) }}">{{ $thread->subject }}</a>
        ({{ $thread->userUnreadMessagesCount(Auth::id()) }} unread)</h4>
    <p>
        {{ $thread->latestMessage->body }}
    </p>
    <p>
        <small><strong>Creator:</strong> {{ $thread->creator()->name }}</small>
    </p>

</div>--}}

@section('css')
<link rel="stylesheet" href="{{ asset('assets/css/slimselect.css')}}">
@endsection

<div class="card mb-2 {{ $class }}">
    <div class="card-body p-2 p-sm-3">
        <div class="d-flex forum-item">
            <a href="#" class="flex-shrink-0" data-toggle="collapse" data-target=".forum-content">
                <img src="{{$thread->creator()->avatar}}" class="rounded-circle" width="50" alt="User" />{{-- $thread->creator()->name --}}
            </a>
            <div class="flex-grow-1 ms-3">
                <h6>
                    <a href="{{ route('messages.show', $thread->id) }}" class="text-body">{{ $thread->subject }}</a>
                </h6>
                <p class="text-secondary">
                    {{ $thread->latestMessage->body }}
                </p>
                <p>
                    <small><strong>Participants:</strong> {{ $thread->participantsString(Auth::id()) }}</small>
                </p>
                @if(! empty($thread->latestMessage))
                <p class="text-muted"><a href="javascript:void(0)">{{$thread->latestMessage->user->name}}</a> replied <span class="text-secondary font-weight-bold">{{ $thread->latestMessage->created_at->diffForHumans() }}</span></p>
                @endif
            </div>
            <div class="text-muted small text-center align-self-center">
                <span><i class="far fa-comment ml-2"></i> {{$thread->messages()->count()}}</span>
            </div>
        </div>
    </div>
</div>
@section('js')
<script src="{{ asset('assets/js/slimselect.min.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.forum-item img').each(function() {
            var img_ele = $(this);
            var img = new Image();
            var url = $(this).attr('src');
            img.onerror = function() {
                console.log('error image', img_ele)
                $(img_ele).attr('src', '{{asset("storage/users/default.png")}}')

            }
            img.src = url;
        });

        new SlimSelect({
          select: '#recipients_select',
          onChange: (sel_users) => {
            console.log(sel_users)
            $('.chk_recipients').prop('checked', false);
            $('.chk_recipients').each(function() {
                for (var i = sel_users.length - 1; i >= 0; i--) {
                    if(sel_users[i].value == $(this).val()) {
                        $(this).prop('checked', true);
                    }
                }
            })
          }
        });
    })
</script>
@endsection