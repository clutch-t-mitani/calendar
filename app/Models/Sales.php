<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Carbon\CarbonImmutable;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Reserve;
use App\Constants\ReserveConst;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Sales extends Model
{
    use HasFactory;

    public function getMonthDate($date)
    {
        $day = isset($date)? $date : Carbon::today();
        $from = CarbonImmutable::parse($date)->startOfMonth();
        $to = CarbonImmutable::parse($date)->endOfMonth();
        $days = CarbonPeriod::create($from, $to)->toArray();
        $month = CarbonImmutable::parse($date)->format('Y-m');

        $weekday = ['日', '月', '火', '水', '木', '金', '土'];

        $dates = [];
        foreach ($days as $date) {
            $dates[] = $date->format('m/d').'（'.$weekday[$date->dayOfWeek].'）';
        }

        $check_dates = [];
        foreach ($days as $date) {
            $check_dates[] = $date->format('Y-m-d');
        }

        $reserved  = DB::table('reserves')->leftJoin('menus','menu_id','=','menus.id')
        ->select('reserves.id', 'reserves.start_date', 'menu_id','menus.price')
        ->orderBy('start_date','asc')
        ->whereBetween('start_date',[$from,$to])
        ->get();

        $count_menu = [
            \Constant::CUT => 0,
            \Constant::CUT_SHAMPOO => 0,
            \Constant::CUT_SHAVING => 0,
            \Constant::CUT_SHAMPOO_SHAVING => 0,
        ];

        $date_reserves = [];
        for ($i=0; $i < count($dates) ; $i++) {
            $date_reserves[$check_dates[$i]]['day'] = $dates[$i] ;
            $date_reserves[$check_dates[$i]]['count_menu'] = $count_menu  ;
            $date_reserves[$check_dates[$i]]['sum_people'] = 0  ;
            $date_reserves[$check_dates[$i]]['sum_price'] = 0  ;
        }

        foreach ($reserved as $value) {
            if(array_key_exists(substr($value->start_date,0,10),$date_reserves)){
                $date_reserves[substr($value->start_date,0,10)]['count_menu'][$value->menu_id] += 1;
                $date_reserves[substr($value->start_date,0,10)]['sum_people']  =
                $date_reserves[substr($value->start_date,0,10)]['count_menu'][\Constant::CUT] +
                $date_reserves[substr($value->start_date,0,10)]['count_menu'][\Constant::CUT_SHAMPOO] +
                $date_reserves[substr($value->start_date,0,10)]['count_menu'][\Constant::CUT_SHAVING] +
                $date_reserves[substr($value->start_date,0,10)]['count_menu'][\Constant::CUT_SHAMPOO_SHAVING];
                $date_reserves[substr($value->start_date,0,10)]['sum_price'] += $value->price;
            }
        }

        $total = [
            'count_menu' => $count_menu,
            "sum_people" => 0,
            "sum_price" => 0
        ];

        foreach ($date_reserves as $reserve){
            $total['count_menu'][\Constant::CUT] += $reserve['count_menu'][\Constant::CUT];
            $total['count_menu'][\Constant::CUT_SHAMPOO] += $reserve['count_menu'][\Constant::CUT_SHAMPOO];
            $total['count_menu'][\Constant::CUT_SHAVING] += $reserve['count_menu'][\Constant::CUT_SHAVING];
            $total['count_menu'][\Constant::CUT_SHAMPOO_SHAVING] += $reserve['count_menu'][\Constant::CUT_SHAMPOO_SHAVING];
            $total['sum_people'] += $reserve['sum_people'];
            $total['sum_price'] += $reserve['sum_price'];
        }

        return ['date' => $date_reserves,'total' => $total,'month' => $month];
    }

    //当日の予約とその累計データの取得
    public function getDailyDate($date)
    {
        $this->day = $date;
        $day = CarbonImmutable::parse($date);

        //当日の予約データを取得
        $reserves = Reserve::leftJoin('menus','menu_id','=','menus.id')
        ->select('reserves.id', 'reserves.start_date', 'reserves.end_date','users.name as user_name','users.email','menus.name as menu_name','menus.price','menus.id as menu_id')
        ->leftJoin('users','user_id','=','users.id')
        ->whereDate('start_date',$day)
        ->orderBy('start_date','ASC')
        ->get();

        //当日の累計データ
        foreach (\Constant::$menu_list as $menu_id => $name) {
            $daily_total[$menu_id]['name'] = $name;
            $daily_total[$menu_id]['count'] = 0;
            $daily_total[$menu_id]['price'] = 0;
        }
           $daily_total['total']['name'] = '累計';
           $daily_total['total']['count'] = 0;
           $daily_total['total']['price'] = 0;

        foreach ($reserves as $reserve) {
            foreach (\Constant::$menu_list as $menu_id => $value) {
                if ($reserve['menu_id'] == $menu_id) {
                    $daily_total[$menu_id]['count'] += 1;
                    $daily_total[$menu_id]['price'] += $reserve['price'];
                    $daily_total['total']['count'] += 1;
                    $daily_total['total']['price'] += $reserve['price'];
                }
            }
        }

        return ['day' => $this->day,'reserves' => $reserves,'daily_total' => $daily_total];
    }

    //月初から選択日までの累計売上データの取得
    public function toSelectDayGetDate($date)
    {
        $this->day = $date;
        $today = CarbonImmutable::parse($date)->addDay();
        $from = CarbonImmutable::parse($date)->startOfMonth();

        $reserves = Reserve::leftJoin('menus','menu_id','=','menus.id')
        ->select('reserves.id', 'reserves.start_date', 'reserves.end_date','users.name as user_name','users.email','menus.name as menu_name','menus.price','menus.id as menu_id')
        ->leftJoin('users','user_id','=','users.id')
        ->whereBetween('start_date',[$from,$today])
        ->orderBy('start_date','ASC')
        ->get();

        foreach (\Constant::$menu_list as $menu_id => $name) {
            // $to_select_day_total[$menu_id]['name'] = $name;
            $to_select_day_total[$menu_id]['count'] = 0;
            $to_select_day_total[$menu_id]['price'] = 0;
        }
        //    $to_select_day_total['total']['name'] = '累計';
           $to_select_day_total['total']['count'] = 0;
           $to_select_day_total['total']['price'] = 0;

        foreach ($reserves as $reserve) {
            foreach (\Constant::$menu_list as $menu_id => $value) {
                if ($reserve['menu_id'] == $menu_id) {
                    $to_select_day_total[$menu_id]['count'] += 1;
                    $to_select_day_total[$menu_id]['price'] += $reserve['price'];
                    $to_select_day_total['total']['count'] += 1;
                    $to_select_day_total['total']['price'] += $reserve['price'];
                }
            }
        }

        return ['to_select_day_total' => $to_select_day_total];
    }

}
