<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Dashboard') }}
      </h2>
  </x-slot>

<div class="py-12">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
      <div class="p-6   bg-white border-b border-gray-200 text-lg">
       <div class="mb-10 text-center">【 {{ $day }} 】</div>
        <div class="container mx-auto">
          <form action="{{ route('store') }}" method="POST">
            @csrf
            <table class="container table-auto">
              <thead>
                <tr>
                  <th class="px-4 py-2"></th>
                  <th class="px-4 py-2">メニュー名</th>
                  <th class="px-4 py-2">所要時間</th>
                  <th class="px-4 py-2">値段（税込）</th>
                  <th class="px-4 py-2">詳細</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($menus as $menu)
                <tr>
                  @if(($check90 && !$check60 && !$check30) || ($check_stop_days90 && !$check_stop_days60 && !$check_stop_days30))
                    @if($menu->id == 1 || $menu->id == 2 || $menu->id == 3 )
                      <td class="border px-4 py-2">
                        <input type="radio" name="menu_id" value="{{ $menu->id }}" @if($menu->id == 1)checked @endif>
                      </td>                        
                    @else
                      <td class="border px-4 py-2">予約不可</td>
                    @endif
                  @elseif(($check60 && $check90 && !$check30) || ($check_stop_days60 && $check_stop_days90 && !$check_stop_days30))
                    @if($menu->id == 1)
                      <td class="border px-4 py-2">
                        <input type="radio" name="menu_id" value="{{ $menu->id }}" @if($menu->id == 1)checked @endif>
                      </td>                        
                    @else
                      <td class="border px-4 py-2">予約不可</td>
                    @endif
                  @elseif($check30 || $check_stop_days30)
                      <td class="border px-4 py-2">予約不可</td>
                  @else
                    <td class="border px-4 py-2">
                     <input type="radio" name="menu_id" value="{{ $menu->id }}" @if($menu->id == 1)checked @endif>
                    </td>
                  @endif
                  @php
                    $date = new DateTime($menu['time']);
                    $time = date_format($date,'G時間i分');
                  @endphp
                   <td class="border px-4 py-2">{{ $menu->name }}</td>
                   <td class="border px-4 py-2">{{ $time }}</td>
                   <td class="border px-4 py-2">{{ $menu->price }}円</td>
                   <td class="border px-4 py-2">{{ $menu->information }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>  
            <input type="hidden" name="time" value={{ str_replace(' ', '/', $check_day) }} >
            <div class="m-3 flex flex-row-reverse">
              <button type="submit" class="px-2 py-1 bg-blue-400 text-base text-white font-semibold rounded hover:bg-blue-500 ">予約する</button>
            </div>        
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</x-app-layout>
