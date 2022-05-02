<?php

namespace App\Http\Controllers;
use App\Models\Menu;
use App\Models\Reserve;
use Illuminate\Support\Facades\Auth; //ユーザID登録するために必要
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function show($id)
    {
        $day =  Carbon::parse($id)->isoFormat('YYYY年MM月DD日(ddd) H時m分 ');
        $check_day = $id;
        $menus = Menu::orderBy('created_at','ASC')
        ->get();

        return view('reserve',['id' => $id],compact('day','menus','check_day'));
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
