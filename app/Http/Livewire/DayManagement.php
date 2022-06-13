<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\CarbonImmutable;
use App\Models\Reserve;
use App\Models\ReserveStopDay;

class DayManagement extends Component
{
    //現在の日付
    public $today;
    public $week;
    public $day;
    public $checkDay;
    public $dayOfWeek;
    public $sevenDaysLater;
    public $reserved;
    public $stop_days;
    public $checkTime;
    public $weekCheckDays;

    //画面を読み込んだときの初期値
    public function mount()
    {
        $this->today = CarbonImmutable::today();
        $this->sevenDaysLater = $this->today->addDays(7);
        $this->week =  [];

        for($i = 0; $i<7; $i++) {
            $this->day = CarbonImmutable::today()->addDays($i)->format('m月d日');
            $this->checkDay = CarbonImmutable::today()->addDays($i)->format('Y-m-d');
            $this->dayOfWeek = CarbonImmutable::today()->addDays($i)->dayName;
            array_push($this->week,[
                'day' => $this->day,
                'checkDay' => $this->checkDay,
                'dayOfWeek' => $this->dayOfWeek,
                ]
            );
        }

        //今週分の予約ID
        $this->reserved = Reserve::
        whereBetween('start_date',[$this->today,$this->sevenDaysLater])
        ->get();

        $this->checkTimes = [];
        for($i = 0; $i < 7; $i++){
            for($j =0; $j < 21; $j++){
             $this->checkTimes[$i][] = $this->week[$i]['checkDay']." ".\Constant::RESERVE_TIME[$j];
            }
        }

        $this->weekCheckDays = [];
        for($i = 0; $i < 7; $i++){
            $this->weekCheckDays[$i] += $this->week[$i];
            $this->weekCheckDays[$i]['checkDayTme'] =  $this->checkTimes[$i];
        }

        $this->stop_days = ReserveStopDay::
        whereBetween('start_date',[$this->today,$this->sevenDaysLater])
        ->whereNull('deleted_at')
        ->get();
    }
    
    public function render()
    {
        return view('livewire.day-management');
    }
}
