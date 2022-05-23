<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          過去予約一覧
      </h2>
  </x-slot>
  <div class="py-8">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-center py-2 text-lg">過去予約一覧 </h2>
                <table class="table-fixed">
                {{-- <table class="table-auto w-full text-left whitespace-no-wrap"> --}}
                  <thead>
                    <tr>
                      <th class="w-1/6 px-4 py-2 bg-slate-200">予約時間</th>
                      <th class="w-1/4 px-4 py-2 bg-slate-200">メニュー</th>
                      <th class="w-1/7 px-4 py-2 bg-slate-200">値段</th>
                      <th class="w-1/6 px-4 py-2 bg-slate-200">名前</th>
                      <th class="w-1/6 px-4 py-2 bg-slate-200">アドレス</th>
                      {{-- <th class="w-1/6 px-4 py-2 bg-slate-200">キャンセル</th> --}}
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($past_reserves as $past_reserve)
                    @php
                      $date = new DateTime($past_reserve->start_date);
                      $start_time = date_format($date,'m月d日  G:i');
                    @endphp
                    <tr>
                      <td class="border px-4 py-2">{{ $start_time }}</td>
                      <td class="border px-4 py-2">{{ $past_reserve->menu_name }}</td>
                      <td class="border px-4 py-2">{{ $past_reserve->price }}</td>
                      <td class="border px-4 py-2">{{ $past_reserve->user_name }}</td>
                      <td class="border px-4 py-2">{{ $past_reserve->email }}</td>
                      {{-- <td class="border px-4 py-2 text-center"><input type="checkbox"  value="{{ $today_reserve->id }}"  name="id[]" id=""></td> --}}
                    </tr>
                    @endforeach
                  </tbody>
                </table>
                {{ $past_reserves->links() }}
              </div>
          </div>
      </div>
  </div>
</x-app-layout>
