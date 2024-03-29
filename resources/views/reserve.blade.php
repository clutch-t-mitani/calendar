<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          予約画面
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
                  @if($check90 && !$check60 && !$check30)
                    @if($menu->id == \Constant::CUT || $menu->id == \Constant::CUT_SHAMPOO || $menu->id == \Constant::CUT_SHAVING )
                      <td class="border px-4 py-2">
                        <input type="radio" name="menu_id" value="{{ $menu->id }}" @if($menu->id == \Constant::CUT)checked @endif>
                      </td>
                    @else
                      <td class="border px-4 py-2">予約不可</td>
                    @endif
                  @elseif($check60 && $check90 && !$check30)
                    @if($menu->id == \Constant::CUT)
                      <td class="border px-4 py-2">
                        <input type="radio" name="menu_id" value="{{ $menu->id }}" @if($menu->id == \Constant::CUT)checked @endif>
                      </td>
                    @error('status')
                        <div class="text-red-600">{{ $message }}</div>
                    @enderror
                    @else
                      <td class="border px-4 py-2">予約不可</td>
                    @endif
                  @elseif($check30)
                      <td class="border px-4 py-2">予約不可</td>
                  @else
                    <td class="border px-4 py-2">
                     <input type="radio" name="menu_id" value="{{ $menu->id }}" @if($menu->id == \Constant::CUT)checked @endif>
                    </td>
                  @endif
                  @php
                    $date = new DateTime($menu['time']);
                    $time = date_format($date,'G時間i分');
                  @endphp
                   <td class="border px-4 py-2 ">{{ $menu->name }}</td>
                   <td class="border px-4 py-2 text-center">{{ $time }}</td>
                   <td class="border px-4 py-2 text-center">{{ $menu->price }}円</td>
                   <td class="border px-4 py-2 ">{{ $menu->information }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            <input type="hidden" name="time" value={{ str_replace(' ', '/', $check_day) }} >
            <div class="m-3 flex flex-row-reverse">
              <button type="submit" onClick="return isCheck()" class="px-2 py-1 bg-blue-400 text-base text-white font-semibold rounded hover:bg-blue-500 ">予約する</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</x-app-layout>

<script>
  function isCheck() {
      var arr_checkBoxes = document.getElementsByClassName("check");

      if(window.confirm('予約を決定しますか？')){
          window.alert('予約を受け付けました');
          return true;
      }else{
          return false;
      }
  }
</script>
