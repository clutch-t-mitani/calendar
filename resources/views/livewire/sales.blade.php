
<div>
    {{-- <div class="m-3 flex flex-row-reverse">
        <input id="" class=" shadow appearance-none border rounded  text-gray-700 leading-tight focus:outline-none focus:shadow-outlineblock" type="month" name="calendar" 
        value="{{ $today }}" wire:change="getDate($event.target.value)"/>
    </div> --}}
    <div class="m-3 flex flex-row-reverse">
        {{-- <form method="get" action="{{ route('manager.month') }}"> --}}
            <input  class=" shadow appearance-none border rounded  text-gray-700 leading-tight focus:outline-none focus:shadow-outlineblock" type="month" name="calendar" 
            value="" wire:click="getDate($date)" />
            <button type="submit" > 検索 </button>
        {{-- </form> --}}
    </div>

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
                                <td class="text-gray-900 py-1 font-light whitespace-nowrap border-double border-2 border-gray-600">{{ $total['count_menu'][\Constant::CUT] }}</td>
                                <td class="text-gray-900 py-1 font-light whitespace-nowrap border-double border-2 border-gray-600">{{ $total['count_menu'][\Constant::CUT_SHAMPOO] }}</td>
                                <td class="text-gray-900 py-1 font-light whitespace-nowrap border-double border-2 border-gray-600">{{ $total['count_menu'][\Constant::CUT_SHAVING] }}</td>
                                <td class="text-gray-900 py-1 font-light whitespace-nowrap border-double border-2 border-gray-600">{{ $total['count_menu'][\Constant::CUT_SHAMPOO_SHAVING] }}</td>
                                <td class="text-gray-900 py-1 font-light whitespace-nowrap border-double border-2 border-gray-600">{{ $total['sum_people'] }}</td>
                                <td class="text-gray-900 py-1 font-light whitespace-nowrap border-double border-2 border-gray-600">¥{{ number_format($total['sum_price']) }}</td>
                            </tr>
                            @foreach ($date_reserves as $reserve)
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
