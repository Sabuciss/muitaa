<x-app-layout>
    <div class="min-h-screen bg-gray-100 p-6 space-y-6">
        <div class="bg-white rounded shadow p-6">
            <h1 class="text-3xl font-bold mb-6">Risk Analysis</h1>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold">Case ID</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold">Vehicle</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold">Route</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold">Cargo Value</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold">Risk Score</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold">Risk Level</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($analysis as $item)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-2 text-sm font-mono">{{ substr($item['case_id'], 0, 8) }}</td>
                                <td class="px-4 py-2 text-sm">{{ $item['vehicle_id'] }}</td>
                                <td class="px-4 py-2 text-sm">{{ $item['origin'] }} → {{ $item['destination'] }}</td>
                                <td class="px-4 py-2 text-sm">{{ number_format($item['value'], 2) }}</td>
                                <td class="px-4 py-2 text-sm font-bold">{{ $item['risk_score'] }}/5</td>
                                <td class="px-4 py-2 text-sm">
                                    @if($item['risk_score'] == 5)
                                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded text-xs font-semibold">⭐⭐⭐⭐⭐</span>
                                    @elseif($item['risk_score'] == 4)
                                        <span class="px-3 py-1 bg-orange-100 text-orange-800 rounded text-xs font-semibold">⭐⭐⭐⭐</span>
                                    @elseif($item['risk_score'] == 3)
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-semibold">⭐⭐⭐</span>
                                    @elseif($item['risk_score'] == 2)
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded text-xs font-semibold">⭐⭐</span>
                                    @else
                                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded text-xs font-semibold">⭐</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 text-sm">
                                    @if($item['should_inspect'])
                                        <form action="{{ route('risk.generate', $item['case_id']) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="px-3 py-1 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">
                                                Generate Inspection
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 text-xs">No inspection needed</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-4 text-center text-gray-500">No cases available for analysis</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
