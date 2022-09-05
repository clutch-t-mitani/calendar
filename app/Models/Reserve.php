<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'menu_id',
        'start_date',
        'end_date',
    ];

    public function check_time($table,$check_day,$end_time)
    {
        $res = DB::table($table)
        ->whereDate('start_date',$check_day)
        ->whereTime('end_date','>',$check_day)
        ->whereTime('start_date','<',$end_time)
        ->exists();

        return $res;

    }
}
