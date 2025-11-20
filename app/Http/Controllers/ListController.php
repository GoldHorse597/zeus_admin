<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Game;
use App\Models\Site;
use App\Models\Auto;

class ListController extends BaseController
{
    //
    public function sitelist(Request $request){
        $page_title = '사이트목록';
        $authUser = \Auth::guard('admin')->user();
        return view('site.index', compact('page_title'));
    }
    public function gamelist(Request $request){
        $page_title = '게임목록';
        $authUser = \Auth::guard('admin')->user();
         if ($authUser->parent_level > 0) {
            session()->flash('error', '귀하의 권한이 부족합니다.');
            return redirect()->back();
        }
        $games = new Game;
        $gameName = $request->name;
        if (!empty($siteName))
            $games = $games->where('sites.name', 'LIKE', $gameName.'%');
        $page_size = 10;
        if (!empty($request->page_size))
            $page_size = $request->page_size;
        $games = $games->select('*')
            ->orderBy('created_at', 'DESC')->paginate($page_size);     
        return view('game.index', compact('page_title','games','page_size','gameName'));
    }
    public function gameDelete(){
        $authUser = \Auth::guard('admin')->user();
        if ($authUser->parent_level > 0) {
            session()->flash('error', '귀하의 권한이 부족합니다.');
            return redirect()->back();
        }
    }
    public function autolist(Request $request){
        $page_title = '오토목록';
        $authUser = \Auth::guard('admin')->user();
        if ($authUser->parent_level > 0) {
            session()->flash('error', '귀하의 권한이 부족합니다.');
            return redirect()->back();
        }
        $autos = new Auto;
        $autoName = $request->name;
        if (!empty($siteName))
            $autos = $autos->where('name', 'LIKE', $autoName.'%');
        $page_size = 10;
        if (!empty($request->page_size))
            $page_size = $request->page_size;
        $autos = $autos->select('*')
            ->orderBy('created_at', 'DESC')->paginate($page_size);     
        return view('auto.index', compact('page_title','autos','page_size','autoName'));
    }
    public function tablelist(Request $request){
        $page_title = '게임방목록';
        $authUser = \Auth::guard('admin')->user();
        if ($authUser->parent_level > 0) {
            session()->flash('error', '귀하의 권한이 부족합니다.');
            return redirect()->back();
        }
        $games = new Game;
        $gameName = $request->name;
        if (!empty($siteName))
            $games = $games->where('game', 'LIKE', $gameName.'%');
        $page_size = 10;
        if (!empty($request->page_size))
            $page_size = $request->page_size;
        $games = $games->select('*')
            ->orderBy('created_at', 'DESC')->paginate($page_size);       
       
        return view('table.index', compact('page_title','games','page_size'));
    }
}
