<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Reserve;
use App\Models\Sales;
use App\Models\ReserveStopDay;
use Illuminate\Support\Facades\Auth; //ユーザID登録するために必要
use Carbon\CarbonPeriod;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\DB; 


class SalesController extends Controller
{

    public function index()
    {
        $sales = new Sales;
        $this_month_sales = $sales->mount();
        // dd($this_month_sales);
        return view('manager.sales.sales',compact('this_month_sales'));
    }


    public function show(Request $request)
    {  
        $month = $request->all();
        $sales = new Sales;
        $sales = $sales->getDate($month['calendar']);

        return view('manager.sales.sales_month',compact('sales'));

    }

    public function daily($date) 
    {

        $day = CarbonImmutable::parse($date);

        $reserves = Reserve::leftJoin('menus','menu_id','=','menus.id')
        ->select('reserves.id', 'reserves.start_date', 'reserves.end_date','users.name as user_name','users.email','menus.name as menu_name','menus.price')
        ->leftJoin('users','user_id','=','users.id')
        ->whereDate('start_date',$day)
        ->orderBy('start_date','ASC')
        ->get();

        // dd($reserves);

        $day_of_week = ['日','月','火','水','木','金','土'];

        $sales = new Sales;
        $sales = $sales->getDate($date);
        
        $day_sales = new Sales;
        $day_sales = $day_sales->getDailyDate($date);

        dd($sales,$day_sales);


        return view('manager.sales.daily',compact('reserves','day_of_week'));


    }
}
