<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Request;
use App\Models\Agent;
use App\Models\AgentLoginLog;

class AuthController extends Controller
{
    //
    public function __construct()
    {        
        $this->middleware('guest:admin')->except('logout');
        $this->middleware(function ($request, $next) {
            $app_name = config('app.name');            
            $layout = 'auth';
            
            \View::share(compact('app_name', 'layout'));

            return $next($request);
        });
    }
    public function login()
    {
        return view('login');
    }

    public function postLogin(Request $request)
    {
        $agentLoginLog = new AgentLoginLog;
        $agentLoginLog->agent_id = 0;
        $agentLoginLog->login_ip = $request->getClientIp();
        $agentLoginLog->request = json_encode([
            'param' => $request->all(),
            'header' => $request->header('User-Agent')
        ]);
        $agentLoginLog->updated_at = date('Y-m-d H:i:s');
        $agentLoginLog->created_at = date('Y-m-d H:i:s');
        
         $validator = $request->verify();
        if ($validator->fails()) {
            $messages = $validator->messages()->all();
            $agentLoginLog->status = 0;
            $agentLoginLog->response = json_encode(['message' => $messages]);
            $agentLoginLog->save();
            return redirect()->back()->withErrors($messages);
        }
     
        $param = $request->only(['identity', 'password']);
        if (!\Auth::guard('admin')->attempt($param, $request->remember_me == 'on')) {
            $message = '로그인정보가 일치하지 않습니다.';
            $agentLoginLog->status = 0;
            $agentLoginLog->response = json_encode(['message' => $message]);
            $agentLoginLog->save();
            return redirect()->back()->withErrors($message);
        }
        $agent = \Auth::guard('admin')->user();

        if ((!env('ADMIN') && $agent->parent_level == 0) || (!env('AGENT') && $agent->parent_level > 0)) {
            \Auth::guard('admin')->logout();

            $message = '로그인정보가 일치하지 않습니다.';
            $agentLoginLog->status = 0;
            $agentLoginLog->response = json_encode(['message' => $message]);
            $agentLoginLog->save();
            return redirect()->back()->withErrors($message);
        }
        if ($agent) {
            $agent->last_access_session = \Session::getId();
            
        }
        // $agent->last_access_session = \Session::getId();
        $agent->last_access_ip = $request->getClientIp();
        $agent->last_access_at = date('Y-m-d H:i:s');
        $agent->save();
        
        $agentLoginLog->agent_id = $agent->id;
        $agentLoginLog->status = 1;
        $agentLoginLog->response = json_encode(['message' => 'OK']);
        $agentLoginLog->save();

        return response()->json([
                'status' => 'success',
                'redir' => url('/dashboard'), // 성공 시 이동할 URL
            ]);
    }

    public function logout(Request $request)
    {
        \Auth::guard('admin')->logout();

        return redirect()->route('login');
    }

}
