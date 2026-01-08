<x-app-layout>
    <div class="min-h-screen bg-gray-100 p-6 space-y-6">

        <div class="bg-white rounded shadow p-3">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-lg font-bold">Dashboard
                    @switch($userRole)
                        @case('inspector')
                            <span class="text-sm ml-2 px-2 py-1 bg-blue-100 text-blue-800 rounded">Inspector View</span>
                            <span class="text-sm ml-2 text-gray-600"> You can create inspections</span>
                            <a href="{{ route('inspections.create') }}" class="ml-2 text-sm px-3 py-1 bg-blue-500 text-white hover:bg-blue-600 rounded">+ Create Inspection</a>
                            @break
                        @case('analyst')
                            <span class="text-sm ml-2 px-2 py-1 bg-green-100 text-green-800 rounded">Analyst View</span>
                            <span class="text-sm ml-2 text-gray-600"> You can create risk analysis</span>
                            <a href="{{ route('analysis.create') }}" class="ml-2 text-sm px-3 py-1 bg-green-500 text-white hover:bg-green-600 rounded">+ Create Analysis</a>
                            @break
                        @case('broker')
                            <span class="text-sm ml-2 px-2 py-1 bg-purple-100 text-purple-800 rounded">Broker View</span>
                            <span class="text-sm ml-2 text-gray-600"> You can add documents</span>
                            <a href="{{ route('documents.create') }}" class="ml-2 text-sm px-3 py-1 bg-purple-500 text-white hover:bg-purple-600 rounded">+ Add Document</a>
                            @break
                        @case('admin')
                            <span class="text-sm ml-2 px-2 py-1 bg-red-100 text-red-800 rounded">Admin View</span>
                            <span class="text-sm ml-2 text-gray-600"> You manage everything</span>
                            <a href="{{ route('admin.users') }}" class="ml-2 text-sm px-3 py-1 bg-gray-200 hover:bg-gray-300 rounded">Manage Users</a>
                            @break
                    @endswitch
                </h2>
            </div>
            <div id="filter-panel" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-2">
                <div>
                    <label class="block text-xs text-gray-600 mb-1">Vehicle Number</label>
                    <input type="text" id="filter-vehicle" class="w-full border px-2 py-1 rounded text-sm" placeholder="Vehicle number">
                </div>
                <div>
                    <label class="block text-xs text-gray-600 mb-1">Status</label>
                    <select id="filter-status" class="w-full border px-2 py-1 rounded text-sm">
                        <option value="">All</option>
                        <option value="pending">Pending</option>
                        <option value="released">Released</option>
                        <option value="detained">Detained</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs text-gray-600 mb-1">Priority</label>
                    <select id="filter-priority" class="w-full border px-2 py-1 rounded text-sm">
                        <option value="">All</option>
                        <option value="low">Low</option>
                        <option value="normal">Normal</option>
                        <option value="high">High</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs text-gray-600 mb-1">Origin Country</label>
                    <input type="text" id="filter-origin" class="w-full border px-2 py-1 rounded text-sm" placeholder="Country code">
                </div>
                <div>
                    <label class="block text-xs text-gray-600 mb-1">Destination Country</label>
                    <input type="text" id="filter-destination" class="w-full border px-2 py-1 rounded text-sm" placeholder="Country code">
                </div>
            </div>
            <div class="mt-2 flex gap-2">
                <button onclick="applyFilters()" class="px-3 py-1 bg-blue-500 text-white rounded text-sm">Apply Filters</button>
                <button onclick="clearFilters()" class="px-3 py-1 bg-gray-300 text-gray-700 rounded text-sm">Clear</button>
            </div>

            <div class="mt-4 pt-4 border-t border-gray-300">
                <p class="text-sm text-gray-600 mb-3 font-semibold">Show/Hide Content:</p>
                <div class="flex flex-wrap gap-3">
                    <button type="button" data-preference="documents" class="px-5 py-2 text-sm font-semibold rounded text-white transition transform hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 bg-gradient-to-r from-blue-500 to-blue-600 focus:ring-blue-300">
                        Documents
                    </button>
                    <button type="button" data-preference="inspections" class="px-5 py-2 text-sm font-semibold rounded text-white transition transform hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 bg-gradient-to-r from-green-400 to-teal-500 focus:ring-green-300">
                        Inspections
                    </button>
                    <button type="button" data-preference="vehicles" class="px-5 py-2 text-sm font-semibold rounded text-white transition transform hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 bg-gradient-to-r from-purple-500 to-pink-500 focus:ring-purple-300">
                        Vehicles
                    </button>
                    <button type="button" data-preference="cases" class="px-5 py-2 text-sm font-semibold rounded text-white transition transform hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 bg-gradient-to-r from-pink-400 to-red-500 focus:ring-pink-300">
                        Cases
                    </button>
                    <button type="button" data-preference="all" class="px-5 py-2 text-sm font-semibold rounded text-white transition transform hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 bg-black hover:bg-gray-800 focus:ring-gray-700">
                        Show All
                    </button>
                </div>
            </div>
        
        </div>

        @if($totals)
            <div class="bg-white rounded shadow p-3 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
                <div class="text-center">
                    <div class="text-xs text-gray-500">Vehicles</div>
                    <div class="text-2xl font-bold">{{ $totals['vehicles'] ?? '-' }}</div>
                </div>
                <div class="text-center">
                    <div class="text-xs text-gray-500">Parties</div>
                    <div class="text-2xl font-bold">{{ $totals['parties'] ?? '-' }}</div>
                </div>
                <div class="text-center">
                    <div class="text-xs text-gray-500">Users</div>
                    <div class="text-2xl font-bold">{{ $totals['users'] ?? '-' }}</div>
                </div>
                <div class="text-center">
                    <div class="text-xs text-gray-500">Cases</div>
                    <div class="text-2xl font-bold">{{ $totals['cases'] ?? '-' }}</div>
                </div>
                <div class="text-center">
                    <div class="text-xs text-gray-500">Inspections</div>
                    <div class="text-2xl font-bold">{{ $totals['inspections'] ?? '-' }}</div>
                </div>
                <div class="text-center">
                    <div class="text-xs text-gray-500">Documents</div>
                    <div class="text-2xl font-bold">{{ $totals['documents'] ?? '-' }}</div>
                </div>
            </div>
        @endif

        <div id="section-cases" class="bg-white rounded shadow p-3">
            
            <div id="section-cases-content">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-lg font-bold"> Cases</h2>
                    <span class="text-xs text-gray-600">Total: {{ count($cases) }}</span>
                </div>
                <div class="overflow-x-auto mb-6">
                    <table id="cases-table" class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="text-left px-2 py-1">ID</th>
                                <th class="text-left px-2 py-1">Vehicle</th>
                                <th class="text-left px-2 py-1">Status</th>
                                <th class="text-left px-2 py-1">Priority</th>
                                <th class="text-left px-2 py-1">Origin</th>
                                <th class="text-left px-2 py-1">Destination</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($cases as $c)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-2 py-1 font-mono text-xs">{{ substr($c['id'] ?? '', 0, 8) }}</td>
                                    <td class="px-2 py-1">{{ $c['vehicle_id'] ?? '' }}</td>
                                    <td class="px-2 py-1"><span class="px-2 py-1 rounded text-xs bg-blue-100">{{ $c['status'] ?? '' }}</span></td>
                                    <td class="px-2 py-1"><span class="px-2 py-1 rounded text-xs bg-yellow-100">{{ $c['priority'] ?? '' }}</span></td>
                                    <td class="px-2 py-1">{{ $c['origin_country'] ?? '' }}</td>
                                    <td class="px-2 py-1">{{ $c['destination_country'] ?? '' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-2 py-4 text-center text-gray-500">No cases available</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="section-inspections-content">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-lg font-bold"> Inspections</h2>
                    <span class="text-xs text-gray-600">Total: {{ count($inspections) }}</span>
                </div>
                <div class="overflow-x-auto mb-6">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="text-left px-2 py-1">ID</th>
                                <th class="text-left px-2 py-1">Case</th>
                                <th class="text-left px-2 py-1">Type</th>
                                <th class="text-left px-2 py-1">Location</th>
                                <th class="text-left px-2 py-1">Risk Level</th>
                                <th class="text-left px-2 py-1">Risk Flag</th>
                                <th class="text-left px-2 py-1">Created</th>
                                <th class="text-left px-2 py-1">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($inspections as $i)
                                <tr class="border-b hover:bg-gray-50" id="inspection-row-{{ $i['id'] }}">
                                    <td class="px-2 py-1 font-mono text-xs">{{ substr($i['id'] ?? '', 0, 8) }}</td>
                                    <td class="px-2 py-1">{{ substr($i['case_id'] ?? '', 0, 8) }}</td>
                                    <td class="px-2 py-1"><span class="px-2 py-1 rounded text-xs bg-blue-100">{{ $i['type'] ?? 'general' }}</span></td>
                                    <td class="px-2 py-1">{{ $i['location'] ?? '-' }}</td>
                                    <td class="px-2 py-1 risk-level-cell" data-inspection-id="{{ $i['id'] }}">{{ $i['risk_level'] ?? '-' }}</td>
                                    <td class="px-2 py-1">{{ $i['risk_flag'] ?? '-' }}</td>
                                    <td class="px-2 py-1 text-xs">{{ $i['requested_by'] ?? '-' }}</td>
                                    <td class="px-2 py-1 text-xs space-x-1">
                                        @if($userRole === 'analyst')
                                            <button type="button" class="px-2 py-1 bg-green-500 text-white rounded hover:bg-green-600 text-xs run-risk-btn" data-inspection-id="{{ $i['id'] }}" data-url="{{ route('risk.run', $i['id']) }}">Run Risk</button>
                                        @endif
                                        @if($userRole === 'inspector')
                                            <a href="{{ route('inspections.edit', $i['id']) }}" class="text-blue-500 hover:underline">Edit</a>
                                            <form method="POST" action="{{ route('inspections.destroy', $i['id']) }}" style="display:inline;" onsubmit="return confirm('Delete this inspection?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:underline ml-2">Delete</button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 text-xs">View only</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="px-2 py-4 text-center text-gray-500">No inspections available</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="section-documents-content">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-lg font-bold"> Documents</h2>
                    <button onclick="toggleDocFilter()" class="text-xs px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">Filter</button>
                </div>
                <div id="doc-filter-panel" class="hidden grid grid-cols-2 gap-2 mb-3">
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Filename</label>
                        <input type="text" id="filter-doc-filename" class="w-full border px-2 py-1 rounded text-sm" placeholder="Search filename">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Category</label>
                        <input type="text" id="filter-doc-category" class="w-full border px-2 py-1 rounded text-sm" placeholder="Search category">
                    </div>
                </div>
                <div class="overflow-x-auto mb-6">
                    <table id="documents-table" class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="text-left px-2 py-1">ID</th>
                                <th class="text-left px-2 py-1">Case</th>
                                <th class="text-left px-2 py-1">Filename</th>
                                <th class="text-left px-2 py-1">Category</th>
                                <th class="text-left px-2 py-1">Uploaded</th>
                                <th class="text-left px-2 py-1">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($documents as $d)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-2 py-1 font-mono text-xs">{{ substr($d['id'] ?? '', 0, 8) }}</td>
                                    <td class="px-2 py-1">{{ substr($d['case_id'] ?? '', 0, 8) }}</td>
                                    <td class="px-2 py-1">{{ $d['filename'] ?? '-' }}</td>
                                    <td class="px-2 py-1"><span class="px-2 py-1 rounded text-xs bg-purple-100">{{ $d['category'] ?? 'other' }}</span></td>
                                    <td class="px-2 py-1 text-xs">{{ substr($d['created_at'] ?? '', 0, 10) }}</td>
                                    <td class="px-2 py-1 text-xs">
                                        @if($userRole === 'broker')
                                            <a href="{{ route('documents.edit', $d['id']) }}" class="text-blue-500 hover:underline">Edit</a>
                                            <form method="POST" action="{{ route('documents.destroy', $d['id']) }}" style="display:inline;" onsubmit="return confirm('Delete this document?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:underline ml-2">Delete</button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 text-xs">View only</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-2 py-4 text-center text-gray-500">No documents available</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="section-vehicles-content">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-lg font-bold"> Vehicles</h2>
                    <button onclick="toggleVehFilter()" class="text-xs px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">Filter</button>
                </div>
                <div id="veh-filter-panel" class="hidden grid grid-cols-3 gap-2 mb-3">
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Plate No</label>
                        <input type="text" id="filter-veh-plate" class="w-full border px-2 py-1 rounded text-sm" placeholder="Search plate">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Country</label>
                        <input type="text" id="filter-veh-country" class="w-full border px-2 py-1 rounded text-sm" placeholder="Search country">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Make</label>
                        <input type="text" id="filter-veh-make" class="w-full border px-2 py-1 rounded text-sm" placeholder="Search make">
                    </div>
                </div>
                <div class="overflow-x-auto mb-6">
                    <table id="vehicles-table" class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="text-left px-2 py-1">ID</th>
                                <th class="text-left px-2 py-1">Plate No</th>
                                <th class="text-left px-2 py-1">Country</th>
                                <th class="text-left px-2 py-1">Make</th>
                                <th class="text-left px-2 py-1">Model</th>
                                <th class="text-left px-2 py-1">VIN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vehicles as $v)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-2 py-1 font-mono text-xs">{{ substr($v['id'] ?? '', 0, 8) }}</td>
                                    <td class="px-2 py-1">{{ $v['plate_no'] ?? '-' }}</td>
                                    <td class="px-2 py-1">{{ $v['country'] ?? '-' }}</td>
                                    <td class="px-2 py-1">{{ $v['make'] ?? '-' }}</td>
                                    <td class="px-2 py-1">{{ $v['model'] ?? '-' }}</td>
                                    <td class="px-2 py-1">{{ $v['vin'] ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-2 py-4 text-center text-gray-500">No vehicles available</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="section-parties-content">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-lg font-bold"> Parties</h2>
                    <button onclick="toggleParFilter()" class="text-xs px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">Filter</button>
                </div>
                <div id="par-filter-panel" class="hidden grid grid-cols-2 gap-2 mb-3">
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Name</label>
                        <input type="text" id="filter-par-name" class="w-full border px-2 py-1 rounded text-sm" placeholder="Search name">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Country</label>
                        <input type="text" id="filter-par-country" class="w-full border px-2 py-1 rounded text-sm" placeholder="Search country">
                    </div>
                </div>
                <div class="overflow-x-auto mb-6">
                    <table id="parties-table" class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="text-left px-2 py-1">ID</th>
                                <th class="text-left px-2 py-1">Name</th>
                                <th class="text-left px-2 py-1">Type</th>
                                <th class="text-left px-2 py-1">Country</th>
                                <th class="text-left px-2 py-1">RegCode</th>
                                <th class="text-left px-2 py-1">VAT</th>
                                <th class="text-left px-2 py-1">Email</th>
                                <th class="text-left px-2 py-1">Phone</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($parties as $p)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-2 py-1 font-mono text-xs">{{ substr($p['id'] ?? '', 0, 8) }}</td>
                                    <td class="px-2 py-1">{{ $p['name'] ?? '-' }}</td>
                                    <td class="px-2 py-1"><span class="px-2 py-1 rounded text-xs bg-purple-100">{{ $p['type'] ?? '-' }}</span></td>
                                    <td class="px-2 py-1">{{ $p['country'] ?? '-' }}</td>
                                    <td class="px-2 py-1 text-xs">{{ $p['reg_code'] ?? '-' }}</td>
                                    <td class="px-2 py-1 text-xs">{{ $p['vat_code'] ?? '-' }}</td>
                                    <td class="px-2 py-1 text-xs">{{ $p['email'] ?? '-' }}</td>
                                    <td class="px-2 py-1 text-xs">{{ $p['phone'] ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="px-2 py-4 text-center text-gray-500">No parties available</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        
        
    </div>
    
    <script src="{{ asset('dashboard.js') }}"></script>
</x-app-layout>
