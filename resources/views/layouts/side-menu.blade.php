@extends('layouts.main')
@section('content1')
    <nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" data-simplebar>
      <div class="sidebar-inner px-4 pt-3">        
        <ul class="nav flex-column pt-3 pt-md-0">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link d-flex align-items-center">
                <span class="sidebar-icon">
                    <img src="{{asset('images/zeus-logo.png')}}" height="60" width="60" alt="Volt Logo">
                </span>
                <span class="mt-1 ms-1 sidebar-text">오토관리자페이지</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link">
                <span class="sidebar-icon" style="color:#9ca3af">
                   <i class="fa fa-dashboard"></i>
                </span>
                <span class="sidebar-text">대시보드</span>
                </a>
            </li>
             @if (Auth::guard('admin')->user()->parent_level == 0)
            <li class="nav-item">
                <a href="{{ route('setting') }}" class="nav-link">
                <span class="sidebar-icon" style="color:#9ca3af">
                   <i class="fa fa-cog"></i>
                </span>
                <span class="sidebar-text">설정</span>
                </a>
            </li>
            @endif
            <li role="separator" class="dropdown-divider mt-4 mb-3 border-gray-700"></li>
            <li class="nav-item">
                <span class="nav-link d-flex justify-content-between align-items-center collapsed" data-bs-toggle="collapse" data-bs-target="#submenu-agents" aria-expanded="false">
                    <span>
                        <span class="sidebar-icon">
                            <i class="fa fa-users"></i>
                        </span>
                        <span class="sidebar-text">에이전트관리</span>
                    </span>
                    <span class="link-arrow">
                       <i class="fa fa-chevron-right"></i>
                    </span>
                </span>
                <div class="multi-level collapse" role="list" id="submenu-agents" aria-expanded="false" style="">
                    <ul class="flex-column nav">
                        <li class="nav-item">
                            <a class="nav-link" href="../../pages/examples/sign-in.html">
                            <span class="sidebar-text">에이전트목록</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>  
            <li class="nav-item">
                <span class="nav-link d-flex justify-content-between align-items-center collapsed" data-bs-toggle="collapse" data-bs-target="#submenu-users" aria-expanded="false">
                    <span>
                        <span class="sidebar-icon">
                            <i class="fa fa-user"></i>
                        </span>
                        <span class="sidebar-text">회원관리</span>
                    </span>
                    <span class="link-arrow">
                       <i class="fa fa-chevron-right"></i>
                    </span>
                </span>
                <div class="multi-level collapse" role="list" id="submenu-users" aria-expanded="false" style="">
                    <ul class="flex-column nav">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.list') }}">
                            <span class="sidebar-text">회원목록</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('user.onlinelist') }}">
                            <span class="sidebar-text">접속한 회원목록</span>
                            </a>
                        </li>
                       
                    </ul>
                </div>
            </li>    
            <li role="separator" class="dropdown-divider mt-4 mb-3 border-gray-700"></li>
            <li class="nav-item">
                <a href="{{ route('sitelist') }}" class="nav-link">
                <span class="sidebar-icon" style="color:#9ca3af">
                   <i class="fa fa-globe"></i>
                </span>
                <span class="sidebar-text">사이트목록</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('gamelist') }}" class="nav-link">
                <span class="sidebar-icon" style="color:#9ca3af">
                   <i class="fa fa-gamepad"></i>
                </span>
                <span class="sidebar-text">게임목록</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('autolist') }}" class="nav-link">
                <span class="sidebar-icon" style="color:#9ca3af">
                   <i class="fa fa-star"></i>
                </span>
                <span class="sidebar-text">오토목록</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('tablelist') }}" class="nav-link">
                <span class="sidebar-icon" style="color:#9ca3af">
                   <i class="fa fa-th"></i>
                </span>
                <span class="sidebar-text">게임방목록</span>
                </a>
            </li>

            <li role="separator" class="dropdown-divider mt-4 mb-3 border-gray-700"></li>

            <li class="nav-item">
                <span class="nav-link d-flex justify-content-between align-items-center collapsed" data-bs-toggle="collapse" data-bs-target="#submenu-infos" aria-expanded="false">
                    <span>
                        <span class="sidebar-icon">
                            <i class="fa fa-info-circle"></i>
                        </span>
                        <span class="sidebar-text">고객센터</span>
                    </span>
                    <span class="link-arrow">
                       <i class="fa fa-chevron-right"></i>
                    </span>
                </span>
                <div class="multi-level collapse" role="list" id="submenu-infos" aria-expanded="false" style="">
                    <ul class="flex-column nav">
                        <li class="nav-item">
                            <a class="nav-link" href="../../pages/examples/sign-in.html">
                            <span class="sidebar-text">쪽지</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../pages/examples/sign-in.html">
                            <span class="sidebar-text">1:1문의</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../pages/examples/sign-in.html">
                            <span class="sidebar-text">공지사항</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li> 
        </ul>
      </div>
    </nav>
    <div class="container-fluid">

        @yield('main-content')

    </div>
@endsection

