@extends('layouts.msgmaster')

@section('content')
    @include('messenger.partials.flash')

    <div class="main-body p-0">
        <div class="inner-wrapper">
            <!-- Inner sidebar -->
            <div class="inner-sidebar">
                <!-- Inner sidebar header -->
                <div class="inner-sidebar-header justify-content-center">
                    <button class="btn btn-primary has-icon btn-block w-auto mx-3 pe-3" type="button" data-bs-toggle="modal" data-bs-target="#threadModal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus mr-2">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        NEW <span class="d-none d-md-block d-lg-none">MESSAGE</span>
                    </button>
                    <button class="d-md-none w-25 toggle-sidebar border-0 bg-light">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 40" enable-background="new 0 0 40 40">
                          <line x1="15" y1="15" x2="25" y2="25" stroke="#aaa" stroke-width="2.5" stroke-linecap="round" stroke-miterlimit="10"></line>
                          <line x1="25" y1="15" x2="15" y2="25" stroke="#aaa" stroke-width="2.5" stroke-linecap="round" stroke-miterlimit="10"></line>    
                          <circle class="circle" cx="20" cy="20" r="19" opacity="0" stroke="#000" stroke-width="2.5" stroke-linecap="round" stroke-miterlimit="10" fill="none"></circle>
                          <path d="M20 1c10.45 0 19 8.55 19 19s-8.55 19-19 19-19-8.55-19-19 8.55-19 19-19z" class="progress" stroke="#aaa" stroke-width="2.5" stroke-linecap="round" stroke-miterlimit="10" fill="none"></path>
                        </svg>
                    </button>
                </div>
                <!-- /Inner sidebar header -->

                <!-- Inner sidebar body -->
                <div class="inner-sidebar-body p-0">
                    <div class="p-3 h-100" data-simplebar="init">
                        <div class="simplebar-wrapper">
                            <div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div>
                            <div class="simplebar-mask">
                                <div class="simplebar-offset">
                                    <div class="simplebar-content-wrapper">
                                        <div class="simplebar-content p-1">
                                            <nav class="nav nav-pills nav-gap-y-1 flex-column">
                                                <a href="{{route('messages')}}" class="nav-link nav-link-faded has-icon {{Route::is('messages')? 'active': '' }}">All Threads</a>
                                                <a href="{{route('messages.unread')}}" class="nav-link nav-link-faded has-icon {{Route::is('messages.unread')? 'active': '' }}">Unread</a>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="simplebar-placeholder" style="width: 234px; height: 292px;"></div>
                        </div>
                        <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="width: 0px; display: none;"></div></div>
                        <div class="simplebar-track simplebar-vertical" style="visibility: visible;"><div class="simplebar-scrollbar" style="height: 151px; display: block; transform: translate3d(0px, 0px, 0px);"></div></div>
                    </div>
                </div>
                <!-- /Inner sidebar body -->
            </div>
            <!-- /Inner sidebar -->

            <!-- Inner main -->
            <div class="inner-main">
                <!-- Inner main header -->
                <div class="inner-main-header">
                    <a class="nav-link nav-icon rounded-circle nav-link-faded mr-3 d-md-none toggle-sidebar" href="#"><i class="fas fa-angle-double-right"></i></a>
                    <select class="form-select custom-select-sm w-auto me-1">
                        <option selected="">Latest</option>
                        <option value="1">Popular</option>
                        <option value="3">Solved</option>
                        <option value="3">Unsolved</option>
                        <option value="3">No Replies Yet</option>
                    </select>
                    <span class="input-icon input-icon-sm ms-auto w-auto">
                        <input type="text" class="form-control form-control-sm bg-gray-200 border-gray-200 shadow-none mb-4 mt-4" placeholder="Search..." />
                    </span>
                </div>
                <!-- /Inner main header -->

                <!-- Inner main body -->

                <!-- Forum List -->
                <div class="inner-main-body p-2 p-sm-3 collapse forum-content show">
                    
                    @each('messenger.partials.thread', $threads, 'thread', 'messenger.partials.no-threads')

                    @if(! $threads->isEmpty())
                    <ul class="pagination pagination-sm pagination-circle justify-content-center mb-0">
                        <li class="page-item disabled">
                            <span class="page-link has-icon"><i class="fas fa-chevron-left"></i></span>
                        </li>
                        <li class="page-item active"><a class="page-link" href="javascript:void(0)">1</a></li>
                        <li class="page-item">
                            <a class="page-link has-icon" href="javascript:void(0)"><i class="fas fa-chevron-right"></i></a>
                        </li>
                    </ul>
                    @endif
                </div>
                <!-- /Forum List -->

                <!-- /Inner main body -->
            </div>
            <!-- /Inner main -->
        </div>

        <!-- New Thread Modal -->
        <div class="modal fade" id="threadModal" tabindex="-1" role="dialog" aria-labelledby="threadModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <form action="{{ route('messages.store') }}" method="post">
                        {{ csrf_field() }}

                        <div class="modal-header d-flex align-items-center bg-primary text-white">
                            <h6 class="modal-title mb-0" id="threadModalLabel">New Message</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @include('messenger.create')
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop