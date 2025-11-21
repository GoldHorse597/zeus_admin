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
                <a href="#">설정</a>
            </li>
            
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">사이트 설정</h1>
            
            </div>       
        </div>
    </div>
    <!-- Page Heading -->
    
    <div class="row">
        
        @if (Auth::guard('admin')->user()->parent_level == 0)
        <div class="card shadow col ml-1 mb-4 p-0">
           
            <div class="col-12 mb-4">
                <div class="card-body">
                    <form action="{{route('setting')}}" method="post">
                        @csrf
                        <div class="row mb-4 mb-lg-5">
                            <div class="col-12 col-md-6">
                                <label for="serviceStatus" class="col-sm-3 col-form-label">운영상태</label>
                                <div class="col-lg-10 col-sm-6">
                                    <select class="form-select" id="site_closed" name="site_closed" data-rule-required="true" data-msg-required="운영상태 항목은 필수입니다." style="margin: 40px 0;">
                                        <option value="0" {{ $_setting->site_closed == 0 ? 'selected' : '' }}>정상</option>
                                        <option value="1" {{ $_setting->site_closed == 1 ? 'selected' : '' }}>점검</option>
                                        <option value="2" {{ $_setting->site_closed == 2 ? 'selected' : '' }}>긴급점검</option>
                                    </select>
                                    <div class="input-group mt-2">
                                        <span class="input-group-text">점검시간</span>
                                        <input data-datepicker type="text" class="form-control datepicker-input" id="closed_start_time" name="closed_start_time" value="{{ empty($_setting->closed_start_time) ? '' : date('Y-m-d H:i:s', strtotime($_setting->closed_start_time)) }}">&nbsp;~&nbsp;
                                        <input data-datepicker type="text" class="form-control datepicker-input" id="closed_end_time" name="closed_end_time" value="{{ empty($_setting->closed_end_time) ? '' : date('Y-m-d H:i:s', strtotime($_setting->closed_end_time)) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="col-sm-3 col-form-label">아이피제한</label>
                                <div class="col-sm-10">
                                    <label class="col-form-label pb-0">회원아이피 제한</label>
                                    <div class="input-group">
                                        <textarea class="form-control" id="user_forbidden_ip" name="user_forbidden_ip" rows="3">{{ empty($_setting->user_forbidden_ip) ? '' : $_setting->user_forbidden_ip }}</textarea>
                                    </div>
                                </div>
                                <div class="col-sm-10">
                                    <label class="col-form-label pb-0">관리자아이피 제한</label>
                                    <div class="input-group">
                                        <textarea class="form-control" id="admin_forbidden_ip" name="admin_forbidden_ip" rows="3">{{ empty($_setting->admin_forbidden_ip) ? '' : $_setting->admin_forbidden_ip }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                        <div class="form-group row m-0 mt-4">                            
                            <div style="text-align:center">
                                <button type="button" class="btn btn-outline-success" id="btn_save_setting">저장</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection

@section('script')
    @parent 
    <script>
    $('#btn_save_setting').click(function () {
            var site_closed = $('#site_closed').val();
            var closed_start_time = $('#closed_start_time').val();
            var closed_end_time = $('#closed_end_time').val();
            var bank_closed_start_time = $('#bank_closed_start_time').val();
            var bank_closed_end_time = $('#bank_closed_end_time').val();
            var user_forbidden_ip = $('#user_forbidden_ip').val();
            var admin_forbidden_ip = $('#admin_forbidden_ip').val();
            $.ajax({
                type: 'POST',
                url: '{{ route('setting.post') }}',
                data: {
                    site_closed: site_closed,
                    closed_start_time: closed_start_time,
                    closed_end_time: closed_end_time,
                    bank_closed_start_time: bank_closed_start_time,
                    bank_closed_end_time: bank_closed_end_time,
                    user_forbidden_ip: user_forbidden_ip,
                    admin_forbidden_ip: admin_forbidden_ip
                },
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    if (data.success) {
                        alertify.alert('', '설정정보를 저장하였습니다.');
                    }
                    else {
                        alertify.alert('', '설정정보를 저장하지 못하였습니다.');
                    }
                },
                error: function(error) {
                    console.log(error);
                },
                complete : function() {
                }
            });
        });
    </script>
@endsection