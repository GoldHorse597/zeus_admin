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
         if ($authUser->parent_level > 0) {
            session()->flash('error', '귀하의 권한이 부족합니다.');
            return redirect()->back();
        }
        $sites = new Site;
        $siteName = $request->name;
        if (!empty($siteName))
            $sites = $sites->where('name', 'LIKE', '%' . $siteName.'%');
        $domain = $request->domain;
        if (!empty($domain))
            $sites = $sites->where('domain', 'LIKE', '%' . $domain.'%');
        $page_size = 10;
        if (!empty($request->page_size))
            $page_size = $request->page_size;
        $sites = $sites->select('*')->orderBy('created_at', 'DESC')->paginate($page_size);     
        return view('site.index', compact('page_title','sites','page_size','siteName','domain'));
    }
    public function sitestore(Request $request){
        $authUser = \Auth::guard('admin')->user();
        if ($authUser->parent_level > 0) {
            session()->flash('error', '귀하의 권한이 부족합니다.');
            return redirect()->back();
        }
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_domain' => 'required|string|max:255',
        ]);
        if (Site::where('domain', $request->doamin)->exists()) {
            return back()->with('error', '이미 존재하는 오토명입니다.');
        }
        // 저장 (원하는 로직으로 변경)
        Site::create([
            'name' => $request->site_name,
            'domain' => $request->site_domain,
        ]);
        return back()->with('success', '오토가 추가되었습니다!');
    }
    public function siteprocess(Request $request, $id){
        $authUser = \Auth::guard('admin')->user();
        if ($authUser->parent_level > 0) {
            session()->flash('error', '귀하의 권한이 부족합니다.');
            return redirect()->back();
        }
        $site = Site::where('id', $id)->first();
        if (!$site) {
            session()->flash('error', '해당 사이트가 존재하지 않습니다.');
            return abort(404);
        }
        session()->flash('success', $site->name.' 사이트를 삭제하였습니다.');
        $site->delete();
        return redirect()->back();
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
        if (!empty($gameName))
            $games = $games->where('name', 'LIKE', '%' . $gameName.'%');
        $page_size = 10;
        if (!empty($request->page_size))
            $page_size = $request->page_size;
        $games = $games->select('*')->paginate($page_size);     
        return view('game.index', compact('page_title','games','page_size','gameName'));
    }
    public function gamestore(Request $request){
        $authUser = \Auth::guard('admin')->user();
        if ($authUser->parent_level > 0) {
            session()->flash('error', '귀하의 권한이 부족합니다.');
            return redirect()->back();
        }
        $request->validate([
            'game_name' => 'required|string|max:255',
        ]);
        if (Game::where('name', $request->game_name)->exists()) {
            return back()->with('error', '이미 존재하는 오토명입니다.');
        }
        // 저장 (원하는 로직으로 변경)
        Game::create([
            'name' => $request->game_name,
        ]);
        return back()->with('success', '오토가 추가되었습니다!');
    }
    public function gameprocess(Request $request, $id){
        $authUser = \Auth::guard('admin')->user();
        if ($authUser->parent_level > 0) {
            session()->flash('error', '귀하의 권한이 부족합니다.');
            return redirect()->back();
        }
        $game = Game::where('id', $id)->first();
        if (!$game) {
            session()->flash('error', '해당 게임이 존재하지 않습니다.');
            return abort(404);
        }
        session()->flash('success', $game->name.' 게임을 삭제하였습니다.');
        $game->delete();
        return redirect()->back();
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
        if (!empty($autoName))
            $autos = $autos->where('name', 'LIKE', '%' . $autoName.'%');
        $page_size = 10;
        if (!empty($request->page_size))
            $page_size = $request->page_size;
        // $autos = $autos->select('*')
        //     ->orderBy('created_at', 'DESC')->paginate($page_size);  
        $autos = $autos->select('*')->paginate($page_size);    
        return view('auto.index', compact('page_title','autos','page_size','autoName'));
    }
    public function autostore(Request $request){
        $authUser = \Auth::guard('admin')->user();
        if ($authUser->parent_level > 0) {
            session()->flash('error', '귀하의 권한이 부족합니다.');
            return redirect()->back();
        }
        $request->validate([
            'auto_name' => 'required|string|max:255',
        ]);
        if (Auto::where('name', $request->auto_name)->exists()) {
            return back()->with('error', '이미 존재하는 오토명입니다.');
        }
        // 저장 (원하는 로직으로 변경)
        Auto::create([
            'name' => $request->auto_name,
        ]);
        return back()->with('success', '오토가 추가되었습니다!');
    }
    public function autoprocess(Request $request, $id){
        $authUser = \Auth::guard('admin')->user();
        if ($authUser->parent_level > 0) {
            session()->flash('error', '귀하의 권한이 부족합니다.');
            return redirect()->back();
        }
        $auto = Auto::where('id', $id)->first();
        if (!$auto) {
            session()->flash('error', '해당 오토가 존재하지 않습니다.');
            return abort(404);
        }
        session()->flash('success', $auto->name.' 를 삭제하였습니다.');
        $auto->delete();
        return redirect()->back();
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
