<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          予約管理画面
      </h2>
  </x-slot>

  <div class="py-8">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-center py-2 text-lg">{{ $view_today }} 予約一覧 </h2>
                <form action="{{ route('manager.delete') }}" method="POST">
                @csrf
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
                      @foreach($today_reserves as $today_reserve)
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
                  <div class="m-3 flex flex-row-reverse">
                    <button type="submit" onClick="return isCheck();return false;" class="px-2 py-1 bg-red-400 text-base text-white font-semibold rounded hover:bg-red-500">予約をキャンセル</button>
                  </div>        
                </form>
              </div>
          </div>
      </div>
  </div>

  <div class="">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between">
                  <h2 class="mb-4 ml-auto text-lg border-0 py-2 px-6 focus:outline-none">明日から今週の予約一覧</h2>
                  <button onclick="location.href='{{ route('manager.past') }}'" class="mb-4 ml-auto text-white bg-indigo-500 border-0 py-2 px-1  hover:bg-indigo-600 font-semibold rounded ">過去の予約一覧へ</button>
                </div>
                <form action="{{ route('manager.delete') }}" method="POST">
                  @csrf
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
                    @foreach($week_reserves as $week_reserve)
                    @php
                      $date = new DateTime($week_reserve->start_date);
                      $start_time = date_format($date,'m月d日  G:i');
                    @endphp
                    <tr>
                      <td class="border px-4 py-2">{{ $start_time }}</td>
                      <td class="border px-4 py-2">{{ $week_reserve->menu_name }}</td>
                      <td class="border px-4 py-2">{{ $week_reserve->price }}</td>
                      <td class="border px-4 py-2">{{ $week_reserve->user_name }}</td>
                      <td class="border px-4 py-2">{{ $week_reserve->email }}</td>
                      <td class="border px-4 py-2 text-center"><input type="checkbox"  class="check_week" value="{{ $week_reserve->id }}"  name="id[]" id=""></td>
                    </tr>
                    @endforeach
                 </tbody>
                </table>
                <div class="m-3 flex flex-row-reverse">
                  <button type="submit"  onClick="return isCheckWeek();return false;" class="px-2 py-1 bg-red-400 text-base text-white font-semibold rounded hover:bg-red-500 ">予約をキャンセル</button>
                </div>        
              </form>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>
<script>
  function isCheck() {
    var arr_checkBoxes = document.getElementsByClassName("check");
    var count = 0;
    for (var i = 0; i < arr_checkBoxes.length; i++) {
        if (arr_checkBoxes[i].checked) {
            count++;
        }
    }
    if (count > 0) {
      if(window.confirm('選択した予約をキャンセルしますか？')){ 
        window.alert('キャンセルされました'); 
        return true; 
      }else{ 
        return false; 
      } 
    } else {
        window.alert("1つ以上選択してください。");
        return false;
    };
 }
  function isCheckWeek() {
    var arr_checkBoxes = document.getElementsByClassName("check_week");
    var count = 0;
    for (var i = 0; i < arr_checkBoxes.length; i++) {
        if (arr_checkBoxes[i].checked) {
            count++;
        }
    }
    if (count > 0) {
      if(window.confirm('選択した予約をキャンセルしますか？')){ 
        window.alert('キャンセルされました'); 
        return true; 
      }else{ 
        return false; 
      } 
    } else {
        window.alert("1つ以上選択してください。");
        return false;
    };
 }
</script>