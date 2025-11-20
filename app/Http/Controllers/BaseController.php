<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Models\Setting;
use App\Models\Agent;
use App\Models\User;
use App\Models\Site;

class BaseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware(function ($request, $next) {
            $app_name = config('app.name');
            $layout = 'side-menu';

            if (\Route::current()->getName() != 'admin.tick') {
                session()->put('lastActivityTime', time());
            }

            $_setting = Setting::first();

            $authUser = \Auth::guard('admin')->user();
            
            $_agents = Agent::where('agents.ancestry', 'LIKE',  $authUser->ancestry.$authUser->id.'/%')
                    ->leftJoin('agents AS P', 'P.id', 'agents.parent_id')
                    ->select('agents.*', 'P.identity AS parent_identity', 'P.nickname as parent_nickname')
                    ->orderByRaw("CONCAT(agents.ancestry, agents.id)")->get();

            $_sites = Site::whereIn('id', explode('|', $authUser->site_id))->get();

            $_online_users_cnt = 0;
 
            if (!$request->ajax() && $request->isMethod('get')) {
                $_online_users_cnt = User::where('ancestry', 'LIKE',  $authUser->ancestry.$authUser->id.'/%')
                    ->where(function ($condition) use ($authUser) {
                        $condition->where('last_access_at', '>=', Carbon::now()->subSeconds(20));
                    })->count();
            }

            \View::share(compact(
                'app_name', 'layout', '_setting', '_agents', '_sites', '_online_users_cnt'
            ));

            return $next($request);
        });
    }

    public function getMenuActive($route_name)
    {
        $first_active = '';
        $second_active = '';
        $third_active = '';
        
        $menu_list = $this->getMenu();
        foreach ($menu_list as $menu) {
            if ($menu == 'devider')
                continue;
            
            if (isset($menu['link']) && $menu['link'] == $route_name && empty($first_active)) {
                $first_active = $menu['name'];
            }

            if (isset($menu['sub_menu'])) {
                foreach ($menu['sub_menu'] as $sub_menu) {
                    if (isset($sub_menu['link']) && $sub_menu['link'] == $route_name && empty($second_active)) {
                        $first_active = $menu['name'];
                        $second_active = $sub_menu['name'];
                    }

                    if (isset($sub_menu['sub_menu'])) {
                        foreach ($sub_menu['sub_menu'] as $last_sub_menu) {
                            if (isset($last_sub_menu['link']) && $last_sub_menu['link'] == $route_name) {
                                $first_active = $menu['name'];
                                $second_active = $sub_menu['name'];
                                $third_active = $last_sub_menu['name'];
                            }
                        }
                    }
                }
            }
        }

        return [
            'first_active' => $first_active,
            'second_active' => $second_active,
            'third_active' => $third_active
        ];
    }

    public function getMenu()
    {
        return [
            'dashboard' => [
                'icon' => 'home',
                'name' => 'dashboard',
                'title' => '대시보드',
                'link' => 'admin.dashboard'
            ],
            'agents' => [
                'icon' => 'box',
                'name' => 'agents',
                'title' => '에이전트 관리',
                'sub_menu' => [
                    'agent.list' => [
                        'icon' => '',
                        'name' => 'agent.list',
                        'title' => '에이전트 목록',
                        'link' => 'admin.agent.list'
                    ],
                    'agent.create' => [
                        'icon' => '',
                        'name' => 'agent.create',
                        'title' => '에이전트 추가',
                        'link' => 'admin.agent.create'
                    ]
                ]
            ],
            'users' => [
                'icon' => 'box',
                'name' => 'users',
                'title' => '유저 관리',
                'sub_menu' => [
                    'user.list' => [
                        'icon' => '',
                        'name' => 'user.list',
                        'title' => '유저 목록',
                        'link' => 'admin.user.list'
                    ],
                    'user.create' => [
                        'icon' => '',
                        'name' => 'user.create',
                        'title' => '유저 추가',
                        'link' => 'admin.user.create'
                    ],
                ]
            ],
            'devider',
            'messages' => [
                'icon' => 'box',
                'name' => 'messages',
                'title' => '쪽지'
            ],
            'notices' => [
                'icon' => 'box',
                'name' => 'notices',
                'title' => '공지사항'
            ],
            'faqs' => [
                'icon' => 'box',
                'name' => 'faqs',
                'title' => 'FAQ'
            ]
        ];
    }
}