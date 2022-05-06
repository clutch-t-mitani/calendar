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
        ->whereNull('canceled_date')
        ->get();

        $end_time30 = Carbon::parse($check_day)->addMinutes(30);
        $end_time60 = Carbon::parse($check_day)->addMinutes(60);
        $end_time90 = Carbon::parse($check_day)->addMinutes(90);

        $check30 = DB::table('reserves')
        ->whereDate('start_date',$check_day)
        ->whereTime('end_date','>',$check_day)
        ->whereTime('start_date','<',$end_time30)
        ->exists();

        $check60 = DB::table('reserves')
        ->whereDate('start_date',$check_day)
        ->whereTime('end_date','>',$check_day)
        ->whereTime('start_date','<',$end_time60)
        ->exists();
        
        $check90 = DB::table('reserves')
        ->whereDate('start_date',$check_day)
        ->whereTime('end_date','>',$check_day)
        ->whereTime('start_date','<',$end_time90)
        ->exists();
        

        // dd($check30,$check60,$check90);
        return view('reserve',['id' => $id],compact('day','menus','check_day','check30','check60','check90'));
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

        $check = DB::table('reserves')
        ->whereDate('start_date',$start_time)
        ->whereTime('end_date','>',$start_time)
        ->whereTime('start_date','<',$end_time)
        ->exists();
        
        if($check){
            session()->flash('statsu','この時間にこのメニューは予約できません');
            return back();
        }
        $reserve = new Reserve();
        $reserve->user_id = Auth::id();
        $reserve->menu_id = $request->menu_id;
        $reserve->start_date = $start_time;
        $reserve->end_date = $end_time;
        $reserve->save();

        return redirect('/home')->with('flash_message', '登録しました');
        // return redirect('/home');

    }
}
