@extends('layouts.' . $layout)

@section('head')
    <title>{{ $app_name }} - {{ $page_title }}</title>
@endsection

@section('main-content')

    @if (session('success'))
    <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
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
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
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
    <div class="py-1">
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
                                <input class="form-control" type="text" name="name" value="{{$gameName}}">
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
                <table class="table table-hover" style="text-align:center">
                    <thead class="thead-light">
                        <tr>
                            <th>번호</th>
                            <th>게임명</th>
                            <th>추가날짜</th>
                            <th>관리</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($games as $index => $game)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $game->name }}</td>
                                <td>{{ $game->created_at }}</td>
                                <td class="btn-group-sm">
                                    <a class="btn btn-success text-white"> 수정 </a>
                                    <a class="btn btn-danger btn-process text-white"  data-param="delete"  href="{{route('game.process', ['id'=> $game->id, 'param' => 'delete'])}}"> 삭제</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-between align-items-center mt-3">

                    <!-- 왼쪽: 페이지 번호 -->
                    <div>
                        {{ $games->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
                    </div>

                    <!-- 오른쪽: 개수 표시 -->
                    <div class="text-muted">
                        {{ $games->firstItem() }} - {{ $games->lastItem() }} / 총 {{ $games->total() }}개
                    </div>

                </div>
                <div class="form-group row m-0 mt-2">                            
                    <div style="text-align:right">
                        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modal-form-add">추가</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-form-add" tabindex="-1" role="dialog" aria-labelledby="modal-form-add" aria-modal="true" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="card p-3 p-lg-4">
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="text-center text-md-center mb-4 mt-md-0">
                            <h1 class="mb-0 h4">게임 추가</h1>
                        </div>
                        <form action="{{ route('game.add') }}" method="POST" class="mt-4">
                            @csrf
                            <!-- Form -->
                            <div class="form-group mb-4">
                                <label for="email">게임명</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="게임명" name="game_name" autofocus="" required="">
                                    
                                </div>
                            </div>                        
                            <div style="text-align: center">
                                <button type="submit" class="btn btn-gray-800">추가</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form id="processForm" action="" method="post">
        @csrf
    </form>
@endsection

@section('script')
   @parent
    <script>       
        $('.btn-process').click(function (e) {
            e.preventDefault();
            let param = $(this).data('param');
            if (param == 'delete' && !confirm('정말로 삭제하시겠습니까?')) {
                return;
            }
            let form = $('#processForm');
            let action = $(this).attr('href');
            form.attr('action', action).submit();
        });
    </script>
@endsection