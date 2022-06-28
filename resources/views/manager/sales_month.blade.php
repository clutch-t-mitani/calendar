<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            売上管理
        </h2>
    </x-slot>
  
    <div class="py-8">
  
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 bg-white border-b border-gray-200">
                    <div class="m-3 flex flex-row-reverse">
                        <form method="get" action="{{ route('manager.month') }}">
                            <input class=" shadow appearance-none border rounded  text-gray-700 leading-tight focus:outline-none focus:shadow-outlineblock" type="month" name="calendar" 
                            value="{{ $sales['month'] }}"/>
                            {{-- <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">検索</button> --}}
                            <button type="submit" onClick="return isCheck();return false;" class="px-2 py-1 bg-blue-400 text-base text-white font-semibold rounded hover:bg-blue-500">検索</button>
                        </form>
                    </div>
                    {{-- @livewire('sales')  --}}
                    <div class="flex flex-col">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="overflow-hidden">
                                    <table class="min-w-full border text-center">
                                        <thead class="border-b">
                                            <tr>
                                                <th scope="col" class="text-gray-900 text-sm px-6 py-4 border-r bg-slate-200">日付</th>
                                                <th scope="col" class="text-gray-900 text-sm px-6 py-4 border-r bg-slate-200">{{ \constant::CUT_NAME }}</th>
                                                <th scope="col" class="text-gray-900 text-sm px-6 py-4 border-r bg-slate-200">{{ \constant::CUT_SHAMPOO_NAME }}</th>
                                                <th scope="col" class="text-gray-900 text-sm px-6 py-4 border-r bg-slate-200">{{ \constant::CUT_SHAVING_NAME }}</th>
                                                <th scope="col" class="text-gray-900 text-sm px-6 py-4 border-r bg-slate-200">{{ \constant::CUT_SHAMPOO_SHAVING_NAME }}</th>
                                                <th scope="col" class="text-gray-900 text-sm px-6 py-4 border-r bg-slate-200">合計客数</th>
                                                <th scope="col" class="text-gray-900 text-sm px-6 py-4 border-r bg-slate-200">合計売上</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="border-b">
                                                <td class="py-1 whitespace-nowrap font-medium text-gray-900 border-double border-2 border-gray-600 bg-slate-200">月合計</td>
                                                <td class="text-gray-900 py-1 font-light whitespace-nowrap border-double border-2 border-gray-600">{{ $sales['total']['count_menu'][\Constant::CUT] }}</td>
                                                <td class="text-gray-900 py-1 font-light whitespace-nowrap border-double border-2 border-gray-600">{{ $sales['total']['count_menu'][\Constant::CUT_SHAMPOO] }}</td>
                                                <td class="text-gray-900 py-1 font-light whitespace-nowrap border-double border-2 border-gray-600">{{ $sales['total']['count_menu'][\Constant::CUT_SHAVING] }}</td>
                                                <td class="text-gray-900 py-1 font-light whitespace-nowrap border-double border-2 border-gray-600">{{ $sales['total']['count_menu'][\Constant::CUT_SHAMPOO_SHAVING] }}</td>
                                                <td class="text-gray-900 py-1 font-light whitespace-nowrap border-double border-2 border-gray-600">{{ $sales['total']['sum_people'] }}</td>
                                                <td class="text-gray-900 py-1 font-light whitespace-nowrap border-double border-2 border-gray-600">¥{{ number_format($sales['total']['sum_price']) }}</td>
                                            </tr>
                                            @foreach ($sales['date'] as $reserve)
                                            <tr class="border-b">
                                                <td class="py-1 whitespace-nowrap font-medium text-gray-900 border-r">{{ $reserve['day'] }}</td>
                                                <td class="text-gray-900 py-1 font-light whitespace-nowrap border-r">{{ $reserve['count_menu'][\Constant::CUT] }}</td>
                                                <td class="text-gray-900 py-1 font-light whitespace-nowrap border-r">{{ $reserve['count_menu'][\Constant::CUT_SHAMPOO] }}</td>
                                                <td class="text-gray-900 py-1 font-light whitespace-nowrap border-r">{{ $reserve['count_menu'][\Constant::CUT_SHAVING] }}</td>
                                                <td class="text-gray-900 py-1 font-light whitespace-nowrap border-r">{{ $reserve['count_menu'][\Constant::CUT_SHAMPOO_SHAVING] }}</td>
                                                <td class="text-gray-900 py-1 font-light whitespace-nowrap border-r">{{ $reserve['sum_people'] }}</td>
                                                <td class="text-gray-900 py-1 font-light whitespace-nowrap border-r">¥{{ number_format($reserve['sum_price']) }}</td>
                                            </tr>
                                            @endforeach 
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ mix('js/flatpickr.js')}}"></script>
    </div>
  </x-app-layout>