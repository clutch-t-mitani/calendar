<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            予約管理画面
        </h2>
    </x-slot>
  
    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 bg-white border-b border-gray-200">
                    @livewire('sales')        
                </div>
            </div>
        </div>
        <script src="{{ mix('js/flatpickr.js')}}"></script>

    </div>
  </x-app-layout>