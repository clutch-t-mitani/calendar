<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\CarbonImmutable;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Reserve;
use App\Constants\ReserveConst;
use Illuminate\Support\Facades\DB; 



class Sales extends Component
{
    public $today;
    public $from;
    public $to;
    public $days;
    public $reserved;
    public $dates;
    public $check_dates;
    public $date_reserves;
    public $total;

    

    public function mount()
    {
        $this->today = Carbon::today();
        $this->from = Carbon::today()->startOfMonth();
        $this->to = Carbon::today()->endOfMonth();
        $this->days = CarbonPeriod::create($this->from, $this->to)->toArray();

        $weekday = ['日', '月', '火', '水', '木', '金', '土'];

        $this->dates = [];
        foreach ($this->days as $date) {
            $this->dates[] = $date->format('m/d').'（'.$weekday[$date->dayOfWeek].'）';
        }

        $this->check_dates = [];
        foreach ($this->days as $date) {
            $this->check_dates[] = $date->format('Y-m-d');
        }

        $this->reserved  = DB::table('reserves')->leftJoin('menus','menu_id','=','menus.id')
        ->select('reserves.id', 'reserves.start_date', 'menu_id','menus.price')
        ->orderBy('start_date','asc')
        ->whereBetween('start_date',[$this->from,$this->to])
        ->get();

        $count_menu = [
            \Constant::CUT => 0,
            \Constant::CUT_SHAMPOO => 0,
            \Constant::CUT_SHAVING => 0,
            \Constant::CUT_SHAMPOO_SHAVING => 0,
        ];
        
        $this->date_reserves = [];
        for ($i=0; $i < count($this->dates) ; $i++) { 
            $this->date_reserves[$this->check_dates[$i]]['day'] = $this->dates[$i] ;
            $this->date_reserves[$this->check_dates[$i]]['count_menu'] = $count_menu  ;
            $this->date_reserves[$this->check_dates[$i]]['sum_people'] = 0  ;
            $this->date_reserves[$this->check_dates[$i]]['sum_price'] = 0  ;
        }

        foreach ($this->reserved as $value) {
            if(array_key_exists(substr($value->start_date,0,10),$this->date_reserves)){
                $this->date_reserves[substr($value->start_date,0,10)]['count_menu'][$value->menu_id] += 1;
                $this->date_reserves[substr($value->start_date,0,10)]['sum_people']  = 
                $this->date_reserves[substr($value->start_date,0,10)]['count_menu'][\Constant::CUT] +
                $this->date_reserves[substr($value->start_date,0,10)]['count_menu'][\Constant::CUT_SHAMPOO] +
                $this->date_reserves[substr($value->start_date,0,10)]['count_menu'][\Constant::CUT_SHAVING] +
                $this->date_reserves[substr($value->start_date,0,10)]['count_menu'][\Constant::CUT_SHAMPOO_SHAVING];
                $this->date_reserves[substr($value->start_date,0,10)]['sum_price'] += $value->price;
            }
        }

        $this->total = [
            'count_menu' => $count_menu,
            "sum_people" => 0,
            "sum_price" => 0
        ];

        foreach ($this->date_reserves as $reserve){
            $this->total['count_menu'][\Constant::CUT] += $reserve['count_menu'][\Constant::CUT];
            $this->total['count_menu'][\Constant::CUT_SHAMPOO] += $reserve['count_menu'][\Constant::CUT_SHAMPOO];
            $this->total['count_menu'][\Constant::CUT_SHAVING] += $reserve['count_menu'][\Constant::CUT_SHAVING];
            $this->total['count_menu'][\Constant::CUT_SHAMPOO_SHAVING] += $reserve['count_menu'][\Constant::CUT_SHAMPOO_SHAVING];
            $this->total['sum_people'] += $reserve['sum_people'];
            $this->total['sum_price'] += $reserve['sum_price'];
        }        
    }

    public function getDate($date)
    {
        $this->today = $date;
        $this->from = CarbonImmutable::parse($date)->startOfMonth();
        $this->to = CarbonImmutable::parse($date)->endOfMonth();
        $this->days = CarbonPeriod::create($this->from, $this->to)->toArray();

        $weekday = ['日', '月', '火', '水', '木', '金', '土'];

        $this->dates = [];
        foreach ($this->days as $date) {
            $this->dates[] = $date->format('m/d').'（'.$weekday[$date->dayOfWeek].'）';
        }

        $this->check_dates = [];
        foreach ($this->days as $date) {
            $this->check_dates[] = $date->format('Y-m-d');
        }

        $this->reserved  = DB::table('reserves')->leftJoin('menus','menu_id','=','menus.id')
        ->select('reserves.id', 'reserves.start_date', 'menu_id','menus.price')
        ->orderBy('start_date','asc')
        ->whereBetween('start_date',[$this->from,$this->to])
        ->get();

        $count_menu = [
            \Constant::CUT => 0,
            \Constant::CUT_SHAMPOO => 0,
            \Constant::CUT_SHAVING => 0,
            \Constant::CUT_SHAMPOO_SHAVING => 0,
        ];
        
        $this->date_reserves = [];
        for ($i=0; $i < count($this->dates) ; $i++) { 
            $this->date_reserves[$this->check_dates[$i]]['day'] = $this->dates[$i] ;
            $this->date_reserves[$this->check_dates[$i]]['count_menu'] = $count_menu  ;
            $this->date_reserves[$this->check_dates[$i]]['sum_people'] = 0  ;
            $this->date_reserves[$this->check_dates[$i]]['sum_price'] = 0  ;
        }

        foreach ($this->reserved as $value) {
            if(array_key_exists(substr($value->start_date,0,10),$this->date_reserves)){
                $this->date_reserves[substr($value->start_date,0,10)]['count_menu'][$value->menu_id] += 1;
                $this->date_reserves[substr($value->start_date,0,10)]['sum_people']  = 
                $this->date_reserves[substr($value->start_date,0,10)]['count_menu'][\Constant::CUT] +
                $this->date_reserves[substr($value->start_date,0,10)]['count_menu'][\Constant::CUT_SHAMPOO] +
                $this->date_reserves[substr($value->start_date,0,10)]['count_menu'][\Constant::CUT_SHAVING] +
                $this->date_reserves[substr($value->start_date,0,10)]['count_menu'][\Constant::CUT_SHAMPOO_SHAVING];
                $this->date_reserves[substr($value->start_date,0,10)]['sum_price'] += $value->price;
            }
        }

        $this->total = [
            'count_menu' => $count_menu,
            "sum_people" => 0,
            "sum_price" => 0
        ];

        foreach ($this->date_reserves as $reserve){
            $this->total['count_menu'][\Constant::CUT] += $reserve['count_menu'][\Constant::CUT];
            $this->total['count_menu'][\Constant::CUT_SHAMPOO] += $reserve['count_menu'][\Constant::CUT_SHAMPOO];
            $this->total['count_menu'][\Constant::CUT_SHAVING] += $reserve['count_menu'][\Constant::CUT_SHAVING];
            $this->total['count_menu'][\Constant::CUT_SHAMPOO_SHAVING] += $reserve['count_menu'][\Constant::CUT_SHAMPOO_SHAVING];
            $this->total['sum_people'] += $reserve['sum_people'];
            $this->total['sum_price'] += $reserve['sum_price'];
        }        
        // dd($this->total);

    }

    public function render()
    {
        return view('livewire.sales');
    }
}
