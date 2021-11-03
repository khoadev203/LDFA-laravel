@extends('layouts.app')

@section('pre_content') 

    <div class="row  clearfix">
      <div class="col">
        <div class="tab-content">
          <div class="tab-pane card active pb-5">
            @forelse($posts as $post)
            <div class="body">
              <h5 class="title"><a target="_blank" href="{{url('/')}}/{{$post->slug}}/{{$post->id}}" class="text-dark">{{$post->title}}</a></h5>
              <small>{{url('/')}}/{{$post->slug}}/{{$post->id}}</small>
              <p class="m-t-10">{{$post->excerpt}}</p>
              <a class="m-r-20" target="_blank" href="{{url('/')}}/{{$post->slug}}/{{$post->id}}">{{__('Read more')}}</a>
            </div>
            @empty

            @endforelse
            <ul class="body pagination  pagination-primary"></ul>
            
            <video class="mx-auto d-block" preload="metadata" width="512" height="288" id="intro-video1" controls playsinline>
                <source src="{{url('landing/quick_tutorial.mp4')}}" type="video/mp4">
                Your browser does not support the video tag.
            </video>

          </div>
        </div>
      </div>
    </div>


@endsection

@section('footer')
	@include('partials.footer')
@endsection
