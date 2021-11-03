<?php $count = Auth::user()->newThreadsCount(); ?>
@if($count > 0)
    <span class="start-100 translate-middle badge rounded-pill bg-danger">{{ $count }}</span>
@endif