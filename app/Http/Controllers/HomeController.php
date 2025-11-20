<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\User;
use App\Models\Agent;

class HomeController extends BaseController
{
    //
    public function index()
    {
        $page_title = '대시보드';
        $authUser = \Auth::guard('admin')->user();
        return view('home.dashboard', compact('page_title'));
    }
    public function setting()
    {
        $page_title = '설정';
        $authUser = \Auth::guard('admin')->user();
        
        return view('home.setting', compact('page_title',));
    }
    public function profile()
    {
        $page_title = '개인정보';
        $authUser = \Auth::guard('admin')->user();
        $ancestry_ids = explode('/', trim($authUser->ancestry, '/'));
        $parents = array();
        foreach ($ancestry_ids as $ancestry_id) {
            $parent = Agent::where('id', $ancestry_id)->first();
            if ($parent && $parent->parent_level >= $authUser->parent_level - 1)
                $parents[] = $parent;
        }
        $parents[] = $authUser;
        $child_agents_cnt = array();
        $child_agents_cnt[0] = Agent::where('ancestry', 'LIKE', $authUser->ancestry.$authUser->id.'/%')->count();
        if ($child_agents_cnt[0] > 0) {
            $child_agents = Agent::where('ancestry', 'LIKE',  $authUser->ancestry.$authUser->id.'/%')->get();
            foreach ($child_agents as $child_agent) {
                if (isset($child_agents_cnt[$child_agent->parent_level+1]))
                    $child_agents_cnt[$child_agent->parent_level+1] += 1;
                else
                    $child_agents_cnt[$child_agent->parent_level+1] = 1;
            }
        }
        $child_users_cnt = User::where('ancestry', 'LIKE', $authUser->ancestry.$authUser->id.'/%')->count();
        return view('home.profile',compact('page_title', 'parents', 'child_agents_cnt', 'child_users_cnt'));
    }
    public function postsetting(Request $request)
    {
        $authUser = \Auth::guard('admin')->user();
        if ($authUser->parent_level == 0) {
            $setting = Setting::first();
            $site_closed = $request->site_closed;
            if (!is_null($site_closed))
                $setting->site_closed = $site_closed;
            
            $setting->closed_start_time = $request->closed_start_time;
            $setting->closed_end_time = $request->closed_end_time;
            $setting->user_forbidden_ip = $request->user_forbidden_ip ?? '';
            $setting->admin_forbidden_ip = $request->admin_forbidden_ip ?? '';

            $is_auto_withdraw = $request->is_auto_withdraw;
            if (!is_null($is_auto_withdraw))
                $setting->is_auto_withdraw = $is_auto_withdraw;
            $setting->save();

            return response()->json(['success' => true, 'msg' => '']);
        }

        return response()->json(['success' => false, 'msg' => '']);
    }
}
