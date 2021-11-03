<div class="card mb-2">
    <div class="card-body">
        <div class="d-flex forum-item">
            <a href="javascript:void(0)" class="flex-shrink-0">
                <img src="{{ $message->user->avatar() }}" class="rounded-circle img-avatar" width="50" alt="User" />
                {{--<small class="d-block text-center text-muted">{{ $message->user->name }}</small>--}}
            </a>
            <div class="flex-grow-1 ms-3">
                <a href="javascript:void(0)" class="text-secondary">{{ $message->user->name }}</a>
                <small class="text-muted ms-2">{{ $message->created_at->diffForHumans() }}</small>
                <div class="mt-3 font-size-sm">
                    {{$message->body}}
                </div>
            </div>
            {{--<div class="text-muted small text-center" style="position: relative;top: 0;right: 5px;width: 63px;">
                                        <span><i class="far fa-comment ms-2"></i> 3</span>
                                    </div>--}}
        </div>
    </div>
</div>