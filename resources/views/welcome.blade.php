<x-app-layout>

<div class="min-h-screen bg-gray-100 p-6 space-y-6">

  <!-- Shipment Track Section -->
  <div class="bg-white rounded shadow p-6">
    <div class="flex justify-between items-center mb-3">
      <h1 class="text-2xl font-bold">Shipment track</h1>
      <select class="border px-2 py-1 rounded focus:ring">
        @foreach($vehicles as $vehicle)
          <option>{{ $vehicle['plate_no'] }} - {{ $vehicle['make'] }}</option>
        @endforeach
      </select>
    </div>

    <div class="flex gap-2 mb-3">
      <span class="bg-red-100 text-red-700 px-2 py-1 rounded">Tracking</span>
      <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded">Traffic jams</span>
      <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded">POI</span>
    </div>

    <div class="flex items-center gap-8 mb-3">
      <div class="text-lg font-bold text-red-600">120km / 1.5min.</div>
      <div class="text-gray-700">Traffic and route optimization: <span class="font-bold text-red-600">85%</span></div>
      <button class="bg-red-500 text-white px-3 py-1 rounded">Optimize</button>
      <button class="border px-2 py-1 rounded">View all</button>
    </div>
    <!-- Kartes/grafika vieta -->
    <div class="h-32 bg-gray-200 flex items-center justify-center rounded text-gray-500">[Map placeholder]</div>
  </div>

  <!-- Shipment Details -->
  <div class="bg-white rounded shadow p-6 mt-2">
    <div class="flex items-center mb-4 gap-3">
      <div class="rounded-full bg-gray-400 w-12 h-12 flex items-center justify-center text-white font-bold">
        {{ $users[0]['full_name'][0] ?? 'M' }}
      </div>
      <div>
        <div class="font-semibold">{{ $users[0]['full_name'] ?? 'Michael Johnson' }}</div>
        <div class="text-xs text-gray-500">{{ $users[0]['username'] ?? 'user' }}</div>
      </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
      <div>
        <div class="text-sm text-gray-500">Price</div>
        <div class="font-bold text-xl text-red-600">$520.45</div>
      </div>
      <div>
        <div class="text-sm text-gray-500">Status</div>
        <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full">Delivered</span>
      </div>
      <div>
        <div class="text-sm text-gray-500">From</div>
        <div class="font-bold">Kyiv</div>
      </div>
      <div>
        <div class="text-sm text-gray-500">Arrival Date</div>
        <div class="font-bold">28.10.23</div>
      </div>
    </div>
  </div>

  <!-- Shipment Trends + Route Efficiency -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-2">
    <div class="bg-white rounded shadow p-6">
      <div class="font-semibold mb-2">Shipment trends</div>
      <div class="flex justify-between">
        @foreach([2810,2910,3010,0111,0211,0311] as $day)
          <div class="flex flex-col items-center">
            <div class="bg-gray-300 w-3 h-3 rounded-full mb-2"></div>
            <span class="text-xs text-gray-500">{{ $day }}</span>
          </div>
        @endforeach
      </div>
    </div>
    <div class="bg-white rounded shadow p-6 flex flex-col justify-center items-center">
      <div class="text-4xl font-bold text-red-600">96%</div>
      <div class="text-xs text-gray-500">Route efficiency</div>
      <div class="text-sm text-gray-400 text-center max-w-xs mt-2">Send the best route to the driver's email</div>
    </div>
  </div>

</div>


</x-app-layout>
