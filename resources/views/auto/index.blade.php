@extends('layouts.' . $layout)

@section('head')
    <title>{{ $app_name }} - {{ $page_title }}</title>
@endsection

@section('main-content')

    @if (session('success'))
    <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if (session('status'))
    <div class="alert alert-success border-left-success" role="alert">
        {{ session('status') }}
    </div>
    @endif
    
    @if (session('error'))
    <div class="alert alert-danger border-left-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="m-0 d-inline-block">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div>
    @endif

    <!-- Page Heading -->
    <div class="py-4">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="{{route('dashboard')}}">
                    <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    </a>
                </li>  
                 <li class="breadcrumb-item">
                    <a href="#">{{ $page_title }}</a>
                </li>          
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">{{ $page_title }}</h1>
            
            </div>       
        </div>
    </div>

    <div class="row">
        <div class="card shadow col mr-1 mb-4 p-0">
            
            <div class="card-body">
                <form method="get">
                    <ul class="nav nav-pills d-flex justify-content-end">
                        
                        <li class="nav-item mr-2 mb-3">
                            <div class="input-group">
                                <div class="input-group-text">
                                    <span>게임명</span>
                                </div>
                                <input class="form-control" type="text" name="name" value="{{$autoName}}">
                            </div>
                        </li>
                        <li class="nav-item mb-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-search"  aria-hidden="true"></i>
                                검색
                            </button>
                        </li>
                    </ul>
                </form>
                <table class="table table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>게임명</th>
                            <th>추가날짜</th>
                            <th>관리</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($autos as $auto)
                            <tr>
                                <td>{{ $auto->id }}</td>
                                <td>{{ $auto->name }}</td>
                                <td>{{ $auto->created_at }}</td>
                                <div class="btn-group btn-group-sm">
                                    <a class="btn btn-primary text-white"> 수정 </a>
                                    <button class="btn btn-danger btn-delete text-white" href="{{route('auto.delete', $auto->id)}}"> 삭제</button>
                                </div>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $autos->appends(request()->except('page'))->links() }}
                </div>
                <div class="form-group row m-0 mt-4">                            
                    <div style="text-align:right">
                        <button type="button" class="btn btn-outline-success" id="btn_save_setting">추가</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
   
@endsection