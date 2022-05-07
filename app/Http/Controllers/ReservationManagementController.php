<?php

namespace App\Http\Controllers;
use App\Models\Menu;
use App\Models\Reserve;
use Illuminate\Support\Facades\Auth; //ユーザID登録するために必要
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class ReservationManagementController extends Controller
{
    public function index()
    {
        // return view('')
    }
}
