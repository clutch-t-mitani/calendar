<?php

namespace App\Http\Controllers;
use App\Models\Menu;
use App\Models\Reserve;
use Illuminate\Support\Facades\Auth; //ユーザID登録するために必要
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class ReservationManagementController extends Controller
{
    public function index()
    {
        $today = CarbonImmutable::today();
        $tommorow = $today->addDays(1);
        $seven_days_Later = $today->addDays(7);
        $view_today = $today->isoFormat('YYYY年MM月DD日(ddd)');


        //今日のイベント
        $today_reserves = Reserve::leftJoin('menus','menu_id','=','menus.id')
        ->select('reserves.id', 'reserves.start_date', 'reserves.end_date','users.name as user_name','users.email','menus.name as menu_name','menus.price')
        ->leftJoin('users','user_id','=','users.id')
        ->whereDate('start_date',$today)
        ->get();

        //明日から今週いっぱいのイベント
        $week_reserves = Reserve::leftJoin('menus','menu_id','=','menus.id')
        ->select('reserves.id', 'reserves.start_date', 'reserves.end_date','users.name as user_name','users.email','menus.name as menu_name','menus.price')
        ->leftJoin('users','user_id','=','users.id')
        ->whereBetween('start_date',[$tommorow,$seven_days_Later])
        ->orderBy('start_date','ASC')
        ->get();

        return view('manager.index',compact('today_reserves','week_reserves','view_today'));
    }

    //予約キャンセル
    public function delete(Request $request)
    {
        $cancel_reserves = $request->all();
        $cancel_ids = $cancel_reserves['id'] ;
      
        foreach($cancel_ids as $cancel_id){
         Reserve::where('id',$cancel_id)->delete();
        }
        return back()->with('flash_message', '更新しました');
    }

    public function past()
    {
        $today = CarbonImmutable::today();

        $past_reserves = Reserve::leftJoin('menus','menu_id','=','menus.id')
        ->select('reserves.id', 'reserves.start_date', 'reserves.end_date','users.name as user_name','users.email','menus.name as menu_name','menus.price')
        ->leftJoin('users','user_id','=','users.id')
        ->whereDate('start_date','<',$today)
        ->orderBy('start_date','desc')
        ->paginate(10);
        // dd($past_reserves);

        return view('manager.past',compact('past_reserves'));
    }

}
