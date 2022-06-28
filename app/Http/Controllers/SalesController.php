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
        return view('manager.sales',compact('this_month_sales'));
    }


    public function show(Request $request)
    {  
        $month = $request->all();
        $sales = new Sales;
        $sales = $sales->getDate($month['calendar']);

        return view('manager.sales_month',compact('sales'));

    }
}
