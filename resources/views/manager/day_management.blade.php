<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          日程管理ページ
      </h2>
  </x-slot>

  <div class="py-4 ">
      <div class="calendar-size mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden  sm:rounded-lg">
              <div class="p-6 bg-white border-b border-gray-200">
                @livewire('day-management')        
              </div>
          </div>
      </div>
  </div>
  <script src="{{ mix('js/flatpickr.js')}}"></script>
</x-app-layout>
