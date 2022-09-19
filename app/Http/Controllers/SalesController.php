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
        $this_month_sales = $sales->getMonthDate(null);

        return view('manager.sales.sales',compact('this_month_sales'));
    }


    public function show(Request $request)
    {
        $month = $request->all();
        $sales = new Sales;
        $sales = $sales->getMonthDate($month['calendar']);

        return view('manager.sales.sales_month',compact('sales'));

    }

    public function daily($date)
    {
        $daily_data = new Sales;
        $daily_data = $daily_data->getDailyDate($date);
        $to_select_day_data = new Sales;
        $to_select_day_data = $to_select_day_data->toSelectDayGetDate($date)['to_select_day_total'];

        $daily_data_total = $daily_data['daily_total'];

        foreach ($to_select_day_data as $menu_id => $value) {
            $daily_data_total[$menu_id]['to_select_day_count'] = $to_select_day_data[$menu_id]['count'];
            $daily_data_total[$menu_id]['to_select_day_price'] = $to_select_day_data[$menu_id]['price'];
        }

        $day = CarbonImmutable::parse($daily_data['day']);
        $today = $day->isoFormat('YYYY年MM月DD日(ddd)');
        $reserves = $daily_data['reserves'];

        return view('manager.sales.daily',compact('reserves','today','daily_data_total'));

    }
}
