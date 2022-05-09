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
                      <tr>
                        <td class="border px-4 py-2">{{ $today_reserve->start_date }}</td>
                        <td class="border px-4 py-2">{{ $today_reserve->menu_name }}</td>
                        <td class="border px-4 py-2">{{ $today_reserve->price }}</td>
                        <td class="border px-4 py-2">{{ $today_reserve->user_name }}</td>
                        <td class="border px-4 py-2">{{ $today_reserve->email }}</td>
                        <td class="border px-4 py-2 text-center"><input type="checkbox"  value="{{ $today_reserve->id }}"  name="id[]" id=""></td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                  <div class="m-3 flex flex-row-reverse">
                    <button type="submit" class="px-2 py-1 bg-red-400 text-base text-white font-semibold rounded hover:bg-red-500 ">予約をキャンセル</button>
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
                <h2 class="text-center py-2 text-lg">明日から今週の予約一覧 </h2>
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
                    <tr>
                      <td class="border px-4 py-2">{{ $week_reserve->start_date }}</td>
                      <td class="border px-4 py-2">{{ $week_reserve->menu_name }}</td>
                      <td class="border px-4 py-2">{{ $week_reserve->price }}</td>
                      <td class="border px-4 py-2">{{ $week_reserve->user_name }}</td>
                      <td class="border px-4 py-2">{{ $week_reserve->email }}</td>
                      <td class="border px-4 py-2 text-center"><input type="checkbox"  value="{{ $week_reserve->id }}"  name="id[]" id=""></td>
                    </tr>
                    @endforeach
                 </tbody>
                </table>
                <div class="m-3 flex flex-row-reverse">
                  <button type="submit" class="px-2 py-1 bg-red-400 text-base text-white font-semibold rounded hover:bg-red-500 ">予約をキャンセル</button>
                </div>        
              </form>
              </div>
          </div>
      </div>
  </div>
</x-app-layout>
