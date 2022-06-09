<div>
    <form action="{{ route('manager.reserve_stop') }}" method="POST">
    @csrf
        <div class="text-center mb-4 mx-auto sm:px-6 lg:px-8">
        <button type="submit" onClick="return isCheck()" class="px-2 py-1 bg-red-400 text-base 
         text-white font-semibold rounded hover:bg-red-500 ">チェックした日時を予約停止にする</button>
        </div>
    
        <div class="flex border mx-auto">
         <x-calendar-time />
          @for($i = 0; $i < 7; $i++)
            <div class="w-32">
                <div class="py-1 px-2 border border-gray-200 text-center bg-blue-200 ">{{ $week[$i]['day'] }}</div>
                <div class="py-1 px-2 border border-gray-200 text-center">{{ $week[$i]['dayOfWeek'] }}</div>
                @for($j = 0; $j < 21; $j++)
                    @php
                      $reserveInfo = $reserved->firstWhere('start_date',$week[$i]['checkDay']." ".\Constant::RESERVE_TIME[$j]);
                      $stopDaysInfo = $stop_days->firstWhere('start_date',$week[$i]['checkDay']." ".\Constant::RESERVE_TIME[$j]);
                    @endphp
                    @if($reserved->isNotEmpty() || $stop_days->isNotEmpty()) {{--空でなかったらTrue--}}
                        @if(!is_null($reserveInfo))
                            <div class="py-1 px-2 border border-blue-200 text-center bg-gray-200">予約済</div>
                                @if($reserveInfo->menu_id ==  \Constant::CUT_SHAMPOO || $reserveInfo->menu_id ==  \Constant::CUT_SHAVING )
                                    @if($reserveInfo->start_date <= $week[$i]['checkDay']." ".'19:30:00' )
                                     <div class="py-1 px-2 border border-blue-200 text-center bg-gray-200">予約済</div>
                                    @endif
                                    @php $j += 1; @endphp 
                                @endif
                                @if($reserveInfo->menu_id == \Constant::CUT_SHAMPOO_SHAVING )
                                    @if($reserveInfo->start_date == $week[$i]['checkDay']." ".'19:30:00' )
                                        <div class="py-1 px-2 border border-blue-200 text-center bg-gray-200">予約済</div>
                                    @elseif($reserveInfo->start_date <= $week[$i]['checkDay']." ".'19:00:00' )
                                        <div class="py-1 px-2 border border-blue-200 text-center bg-gray-200">予約済</div>
                                        <div class="py-1 px-2 border border-blue-200 text-center bg-gray-200">予約済</div>
                                    @endif
                                @php $j += 2; @endphp 
                            @endif                            
                        @elseif(!is_null($stopDaysInfo))
                            <div class="py-1 px-2 border border-blue-200 text-center">
                                <input type="checkbox" name="start_date[]" value="{{$week[$i]['checkDay']." ".\Constant::RESERVE_TIME[$j]}}" checked>
                            </div>
                        @else
                            <div class="py-1 px-2 border  border-blue-200 text-center ">
                                <input type="checkbox" name="start_date[]" value="{{$week[$i]['checkDay']." ".\Constant::RESERVE_TIME[$j]}}" >
                            </div>
                        @endif
                    @else
                        <div class="py-1 px-2 border  border-blue-200 text-center underline">
                            <input type="checkbox" name="start_date[]" value="{{$week[$i]['checkDay']." ".\Constant::RESERVE_TIME[$j]}}" >
                        </div>
                    @endif
                @endfor
            </div>
          @endfor
        </div>
    </form>
</div>

<script>
    function isCheck() {
        var arr_checkBoxes = document.getElementsByClassName("check");

        if(window.confirm('受付停止日時更新しますか？')){ 
            window.alert('更新しました'); 
            return true; 
        }else{ 
            return false; 
        } 
    }
</script>
