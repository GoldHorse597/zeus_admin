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
                <a href="#">개인정보</a>
            </li>
            
            </ol>
        </nav>
        <div class="d-flex justify-content-between w-100 flex-wrap">
            <div class="mb-3 mb-lg-0">
                <h1 class="h4">개인정보</h1>
            
            </div>       
        </div>
    </div>
    <!-- Page Heading -->
   
    <div class="row">
        <div class="card shadow col mr-1 mb-4 p-0">
            
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <tbody>
                            <tr>
                                <th class="w-25">분류</th>
                                @if(Auth::guard('admin')->user()->parent_level == 0)         
                                    <td> 본사 </td>
                                @elseif(Auth::guard('admin')->user()->parent_level == 1)
                                    <td> 부본사</td>
                                @elseif(Auth::guard('admin')->user()->parent_level == 2)
                                    <td> 총판 </td>                               
                                @endif
                            </tr>
                            
                            <tr>
                                <th>상위 에이전트</th>
                                <td>
                                @foreach ($parents as $index => $parent)
                                    @if ($index > 0)
                                    <div class="my-3 mx-5 text-muted"> ↓ </div>
                                    @endif
                                    <div class="dropdown">
                                        <a class="d-block dropdown-toggle text-decoration-none  {{$parent->id == Auth::guard('admin')->user()->id ? 'text-info' : 'text-dark'}} " href="#" data-toggle="dropdown">
                                            <div>{{$parent->nickname}}</div>
                                            <code>{{'@'.$parent->identity}}</code>
                                        </a>
                                        <div class="dropdown-menu">
                                        @if ($parent->id == Auth::guard('admin')->user()->id)
                                            <h6 class="dropdown-header">@lang('admin/app.agent')</h6>
                                            <div class="dropdown-divider"></div>
                                            <h6 class="dropdown-header">@lang('admin/app.user')</h6>
                                            <a class="dropdown-item" href="{{route('user.list', ['agentUsername'=>$parent->identity])}}"> @lang('admin/app.users') </a>
                                        @endif
                                        </div>
                                    </div>
                                @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th>아이디</th>
                                <td>{{Auth::guard('admin')->user()->identity}}</td>
                            </tr>
                            <tr>
                                <th>닉네임</th>
                                <td>{{Auth::guard('admin')->user()->nickname}}</td>
                            </tr>
                            <tr>
                                <th>비밀번호</th>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#passwordChangeModal">@lang('admin/app.change_password')</button>
                                </td>
                            </tr>
                            <tr>
                                <th>사이트</th>
                                <td class="form-group">
                                    <select class="form-control" id="mySiteId" name="site_id[]" data-rule-required="true" data-msg-required="{{ sprintf(trans('admin/app.required'), trans('admin/app.site')) }}" multiple disabled>
                                        @php
                                            $site_ids = explode('|', Auth::guard('admin')->user()->site_id);
                                        @endphp
                                        @foreach ($_sites as $site)
                                        <option value="{{$site->id}}" {{in_array($site->id, $site_ids) ? 'selected' : ''}}>{{$site->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>하부 에이전트 수</th>
                                <td>                                
                                    <div class="d-flex justify-content-between" style="max-width: 300px;">
                                        <div> 전체 </div>
                                        <div class="text-right"> {{number_format($child_agents_cnt[0], 0)}} 명 </div>
                                    </div>
                                    @foreach ($child_agents_cnt as $index => $child_agent_cnt)
                                        @if ($index > 0)
                                        <div class="d-flex justify-content-between" style="max-width: 300px;">
                                            @if($index == 1)
                                                <div> 부본사 </div>
                                            @elseif($index == 2)
                                                <div> 총판 </div>
                                                                                  
                                            @endif
                                            <div class="text-right"> {{number_format($child_agent_cnt, 0)}} 명</div>
                                        </div>
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th>하부 유저수</th>
                                <td>{{number_format($child_users_cnt, 0)}} 명</td>
                            </tr>
                            <tr>
                                <th>가입날짜</th>
                                <td>{{Auth::guard('admin')->user()->created_at}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
       
    </div>
@endsection

@section('script')
    @parent
    <script>
        $(".datepicker").datepicker({
            format: 'yyyy-mm-dd',
        })
    </script>
@endsection