<?php

namespace App\Http\Controllers;
use App\Models\Menu;
use App\Models\Reserve;
use Illuminate\Support\Facades\Auth; //ユーザID登録するために必要
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class ReservationController extends Controller
{
    public function show($id)
    {
        $day =  Carbon::parse($id)->isoFormat('YYYY年MM月DD日(ddd) H時m分 ');
        $check_day = Carbon::parse($id);
        // $check_day_post = $id;
        $menus = Menu::orderBy('created_at','ASC')
        ->get();

        $reserved = Reserve::orderBy('start_date','ASC')
        ->get();

        $end_time30 = Carbon::parse($check_day)->addMinutes(30);
        $end_time60 = Carbon::parse($check_day)->addMinutes(60);
        $end_time90 = Carbon::parse($check_day)->addMinutes(90);

        $check_time = new Reserve;
        $check30 = $check_time->check_time('reserves',$check_day,$end_time30);
        $check60 = $check_time->check_time('reserves',$check_day,$end_time60);
        $check90 = $check_time->check_time('reserves',$check_day,$end_time90);
        $check_stop_days30 = $check_time->check_time('reserve_stop_days',$check_day,$end_time30);
        $check_stop_days60 = $check_time->check_time('reserve_stop_days',$check_day,$end_time60);
        $check_stop_days90 = $check_time->check_time('reserve_stop_days',$check_day,$end_time90);
        
        if(!$check30 && $check_stop_days30){
            $check30 = true;
        }
        if(!$check60 && $check_stop_days60){
            $check60 = true;
        }
        if(!$check90 && $check_stop_days90){
            $check90 = true;
        }
        return view('reserve',['id' => $id],
        compact('day','menus','check_day','check30','check60','check90'));
    }

    public function store(Request $request)
    {
        $start_time = Carbon::parse(str_replace('/', ' ', $request->time));

        if($request->menu_id == 1){
            $end_time = Carbon::parse($start_time)->addMinutes(30);
        }elseif($request->menu_id == 2 || $request->menu_id == 3){
            $end_time = Carbon::parse($start_time)->addMinutes(60);
        }elseif($request->menu_id == 4){
            $end_time = Carbon::parse($start_time)->addMinutes(90);
        }

        $check_time = new Reserve;
        $check = $check_time->check_time('reserves',$start_time,$end_time);
        $check_stop_days = $check_time->check_time('reserve_stop_days',$start_time,$end_time);
        
        if($check || $check_stop_days){
            session()->flash('statsu','この時間にこのメニューは予約できません');
            return back();
        }

        $reserve = new Reserve();
        $reserve->user_id = Auth::id();
        $reserve->menu_id = $request->menu_id;
        $reserve->start_date = $start_time;
        $reserve->end_date = $end_time;
        $reserve->save();

        return redirect('/')->with('flash_message', '登録しました');
    }


}
