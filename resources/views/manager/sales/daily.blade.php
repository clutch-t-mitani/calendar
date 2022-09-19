 <x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        売上管理画面
      </h2>
  </x-slot>

  <div class="py-8">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="py-2 text-lg">【日報】 --{{ $today }}-- </h2>
                <table class="table-auto">
                    <thead>
                        <tr>
                            <th class="w-1/3 px-4 py-2 bg-slate-200">メニュー</th>
                            <th class="w-1/6 px-4 py-2 bg-slate-200">件数</th>
                            <th class="w-1/5 px-4 py-2 bg-slate-200">売上</th>
                            <th class="w-1/6 px-4 py-2 bg-slate-200">累計件数</th>
                            <th class="w-1/5 px-4 py-2 bg-slate-200">累計売上</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($daily_data_total as $key => $value )
                        @if (next($daily_data_total))
                        <tr>
                            <td class="w-1/3 border px-4 py-2">{{ $daily_data_total[$key]['name'] }}</td>
                            <td class="w-1/6 border px-4 py-2 text-right">{{ $daily_data_total[$key]['count'] }}件</td>
                            <td class="w-1/5 border px-4 py-2 text-right">¥{{ number_format($daily_data_total[$key]['price']) }}</td>
                            <td class="w-1/6 border px-4 py-2 text-right">{{ $daily_data_total[$key]['to_select_day_count'] }}件</td>
                            <td class="w-1/5 border px-4 py-2 text-right">¥{{ number_format($daily_data_total[$key]['to_select_day_price']) }}</td>
                        </tr>
                        @else
                        <tr>
                            <td class="w-1/3 border px-4 py-2 bg-blue-100">{{ $daily_data_total[$key]['name'] }}</td>
                            <td class="w-1/6 border px-4 py-2 text-right bg-blue-100">{{ $daily_data_total[$key]['count'] }}件</td>
                            <td class="w-1/5 border px-4 py-2 text-right bg-blue-100">¥{{ number_format($daily_data_total[$key]['price']) }}</td>
                            <td class="w-1/6 border px-4 py-2 text-right bg-blue-100">{{ $daily_data_total[$key]['to_select_day_count'] }}件</td>
                            <td class="w-1/5 border px-4 py-2 text-right bg-blue-100">¥{{ number_format($daily_data_total[$key]['to_select_day_price']) }}</td>
                        </tr>
                        @endif
                        @endforeach
                    <tbody>
                </table>
              </div>
              <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="py-2 text-lg">【予約一覧】 </h2>
                {{-- <form action="{{ route('manager.delete') }}" method="POST"> --}}
                {{-- @csrf --}}
                  <table class="table-fixed">
                    <thead>
                      <tr>
                        <th class="w-1/6 px-4 py-2 bg-slate-200">予約時間</th>
                        <th class="w-1/4 px-4 py-2 bg-slate-200">メニュー</th>
                        <th class="w-1/7 px-4 py-2 bg-slate-200">値段</th>
                        <th class="w-1/6 px-4 py-2 bg-slate-200">名前</th>
                        <th class="w-1/6 px-4 py-2 bg-slate-200">アドレス</th>
                        <th class="w-1/6 px-4 py-2 bg-slate-200">キャンセル</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($reserves as $today_reserve)
                      @php
                        $date = new DateTime($today_reserve->start_date);
                        $start_time = date_format($date,'m月d日  G:i');
                      @endphp
                      <tr>
                        <td class="border px-4 py-2">{{ $start_time }}</td>
                        <td class="border px-4 py-2">{{ $today_reserve->menu_name }}</td>
                        <td class="border px-4 py-2">{{ $today_reserve->price }}</td>
                        <td class="border px-4 py-2">{{ $today_reserve->user_name }}</td>
                        <td class="border px-4 py-2">{{ $today_reserve->email }}</td>
                        <td class="border px-4 py-2 text-center"><input type="checkbox" class="check" value="{{ $today_reserve->id }}"  name="id[]" id=""></td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                  {{-- <div class="m-3 flex flex-row-reverse">
                    <button type="submit" onClick="return isCheck();return false;" class="px-2 py-1 bg-red-400 text-base text-white font-semibold rounded hover:bg-red-500">予約をキャンセル</button>
                  </div>         --}}
                {{-- </form> --}}


              </div>
          </div>
      </div>
  </div>

  </x-app-layout>
