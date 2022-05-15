<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\CarbonImmutable;
use App\Models\Reserve;
use App\Models\ReserveStopDay;

class Calendar extends Component
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
                'dayOfWeek' => $this->dayOfWeek
                ]
            );
        }


        //今週分の予約ID
        $this->reserved = Reserve::
        whereBetween('start_date',[$this->today,$this->sevenDaysLater])
        ->get();

        
        $this->stop_days = ReserveStopDay::
        whereBetween('start_date',[$this->today,$this->sevenDaysLater])
        ->whereNull('deleted_at')
        ->get();


    }

    // public function getDate($date)
    // {
    //     $this->currentDate = $date;
    //     $this->currentWeek =  [];

    //     for($i = 0; $i<7; $i++) {
    //         $this->day = CarbonImmutable::parse($this->currentDate)->addDays($i)->format('m月d日');
    //         array_push($this->currentWeek,$this->day);
    //     }
    // }

    public function getWeekReserved()
    {
        $reserved = Reserve::get();
        dd($reserved);
    }


    public function render()
    {
        return view('livewire.calendar');
    }
}
