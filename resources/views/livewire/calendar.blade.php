<div>
    <div class="text-center mb-4 mx-auto sm:px-6 lg:px-8">
        本日より1週間先まで予約が可能です。
    </div>
    <div class="flex border mx-auto">
     <x-calendar-time />
     @for($i = 0; $i < 7; $i++)
        <div class="w-32">
            <div class="py-1 px-2 border border-gray-200 text-center bg-blue-200 ">{{ $weekCheckDays[$i]['day'] }}</div>
                <div class="py-1 px-2 border border-gray-200 text-center">{{ $weekCheckDays[$i]['dayOfWeek'] }}</div>
            @for($j = 0; $j < 21; $j++)
                @php
                  $reserveInfo = $reserved->firstWhere('start_date',$weekCheckDays[$i]['checkDayTme'][$j]);//予定が入っているか確認
                  $stopDaysInfo = $stop_days->firstWhere('start_date',$weekCheckDays[$i]['checkDayTme'][$j]); //受付停止になっていないか確認
               @endphp
                @if($reserved->isNotEmpty()  || $stop_days->isNotEmpty()) {{--空でなかったらTrue--}}
                    @if(!is_null($reserveInfo))
                        <div class="py-1 px-2 border border-blue-200 text-center bg-gray-200">×</div>
                            @if($reserveInfo->menu_id == \Constant::CUT_SHAMPOO || $reserveInfo->menu_id == \Constant::CUT_SHAVING)
                              @if($reserveInfo->start_date <= $weekCheckDays[$i]['checkDayTme'][19] )
                                <div class="py-1 px-2 border border-blue-200 text-center bg-gray-200">×</div>
                                @php $j += 1; @endphp 
                              @endif  
                            @endif
                            @if($reserveInfo->menu_id == \Constant::CUT_SHAMPOO_SHAVING )
                                @if($reserveInfo->start_date == $weekCheckDays[$i]['checkDayTme'][19]  )
                                    <div class="py-1 px-2 border border-blue-200 text-center bg-gray-200">×</div>
                                @elseif($reserveInfo->start_date <= $weekCheckDays[$i]['checkDayTme'][18]  )
                                    <div class="py-1 px-2 border border-blue-200 text-center bg-gray-200">×</div>
                                    <div class="py-1 px-2 border border-blue-200 text-center bg-gray-200">×</div>
                                @endif
                                @php $j += 2; @endphp 
                            @endif                            
                    @elseif(!is_null($stopDaysInfo))
                            <div class="py-1 px-2 border border-blue-200 text-center ">受付不可</div>
                    @else
                        <div class="py-1 px-2 border  border-blue-200 text-center underline">
                            <a href="{{ route('show',['id' => $weekCheckDays[$i]['checkDayTme'][$j] ]) }}">○</a>
                        </div>
                    @endif
                @else
                 <div class="py-1 px-2 border  border-blue-200 text-center underline">
                    <a href="{{ route('show',['id' => $weekCheckDays[$i]['checkDayTme'][$j] ]) }}">○</a>
                 </div>
                @endif
            @endfor
        </div>
      @endfor
    </div>
</div>
