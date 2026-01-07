<x-app-layout>
    <div class="min-h-screen bg-gray-100 p-6 space-y-6">

        @auth
            <div class="bg-white rounded shadow p-3 flex items-center justify-between">
                <div>
                    <div class="text-xs text-gray-500">Logged in as</div>
                    <div class="text-lg font-semibold">{{ auth()->user()->full_name ?? auth()->user()->name ?? auth()->user()->username }}</div>
                    <div class="text-sm text-gray-600">Role: {{ auth()->user()->role ?? '-' }}</div>
                </div>
                <div class="text-sm text-gray-500">ID: {{ auth()->id() }}</div>
            </div>
        @endauth

        <!-- Kopējie kopsavilkumi -->
        @if($totals)
            <div class="bg-white rounded shadow p-4 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4  flex flex-row-reverse">
                <div>
                    <div class="text-xs text-gray-500">Vehicles</div>
                    <div class="text-xl font-bold">{{ $totals['vehicles'] ?? '-' }}</div>
                </div>
                <div>
                    <div class="text-xs text-gray-500">Parties</div>
                    <div class="text-xl font-bold">{{ $totals['parties'] ?? '-' }}</div>
                </div>
                <div>
                    <div class="text-xs text-gray-500">Users</div>
                    <div class="text-xl font-bold">{{ $totals['users'] ?? '-' }}</div>
                </div>
                <div>
                    <div class="text-xs text-gray-500">Cases</div>
                    <div class="text-xl font-bold">{{ $totals['cases'] ?? '-' }}</div>
                </div>
                <div>
                    <div class="text-xs text-gray-500">Inspections</div>
                    <div class="text-xl font-bold">{{ $totals['inspections'] ?? '-' }}</div>
                </div>
                <div>
                    <div class="text-xs text-gray-500">Documents</div>
                    <div class="text-xl font-bold">{{ $totals['documents'] ?? '-' }}</div>
                </div>
            </div>
        @endif

        <!-- Quick topic links-->
        <div class="bg-white rounded shadow p-4">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4 items-center">
                <button type="button" data-target="vehicles" class="w-full py-2 bg-white text-gray-700 border rounded-md transition transform hover:scale-105 hover:shadow-lg hover:text-white hover:bg-gradient-to-r hover:from-purple-500 hover:to-pink-500 focus:outline-none focus:ring-2 focus:ring-purple-300">Vehicles</button>
                <button type="button" data-target="inspections" class="w-full py-2 bg-white text-gray-700 border rounded-md transition transform hover:scale-105 hover:shadow-lg hover:text-white hover:bg-gradient-to-r hover:from-green-400 hover:to-teal-500 focus:outline-none focus:ring-2 focus:ring-green-200">Inspections</button>
                <button type="button" data-target="documents" class="w-full py-2 bg-white text-gray-700 border rounded-md transition transform hover:scale-105 hover:shadow-lg hover:text-white hover:bg-gradient-to-r hover:from-blue-500 hover:to-indigo-600 focus:outline-none focus:ring-2 focus:ring-blue-200">Documents</button>
                <button type="button" data-target="users" class="w-full py-2 bg-white text-gray-700 border rounded-md transition transform hover:scale-105 hover:shadow-lg hover:text-white hover:bg-gradient-to-r hover:from-yellow-400 hover:to-orange-500 focus:outline-none focus:ring-2 focus:ring-yellow-200">Users</button>
                <button type="button" data-target="cases" class="w-full py-2 bg-white text-gray-700 border rounded-md transition transform hover:scale-105 hover:shadow-lg hover:text-white hover:bg-gradient-to-r hover:from-pink-400 hover:to-red-500 focus:outline-none focus:ring-2 focus:ring-pink-200">Cases</button>
                <button type="button" data-target="all" class="w-full py-2 bg-white text-gray-700 border rounded-md transition transform duration-200 hover:scale-105 hover:shadow-lg hover:text-white hover:bg-gradient-to-r hover:from-gray-700 hover:to-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-400">Show all</button>
            </div>
        </div>

        <!-- Vehicles tabula -->
        <div id="section-vehicles" data-topic="vehicles" class="bg-white rounded shadow p-4">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-lg font-bold">Vehicles</h2>
                <div class="relative">
                    <button type="button" data-toggle-filter="vehicles" class="text-sm px-2 py-1 bg-gray-100 rounded">Filters</button>
                    <div data-filter-panel="vehicles" class="hidden absolute right-0 mt-2 w-64 bg-white border rounded shadow p-3 z-20">
                        <label class="text-xs text-gray-500">Plate</label>
                        <input data-filter-input="vehicles" data-field="plate_no" class="w-full border px-2 py-1 rounded mb-2 text-sm" placeholder="Plate no">
                        <label class="text-xs text-gray-500">Make</label>
                        <input data-filter-input="vehicles" data-field="make" class="w-full border px-2 py-1 rounded mb-2 text-sm" placeholder="Make">
                        <label class="text-xs text-gray-500">Model</label>
                        <input data-filter-input="vehicles" data-field="model" class="w-full border px-2 py-1 rounded mb-2 text-sm" placeholder="Model">
                        <div class="flex gap-2 justify-end">
                            <button type="button" data-filter-clear="vehicles" class="text-sm px-2 py-1 bg-gray-100 rounded">Clear</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
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
                        @foreach($vehicles as $v)
                            @if(!$selectedVehicleId || $selectedVehicleId === $v['id'])
                                <tr class="border-b">
                                    <td class="px-2 py-1">{{ $v['id'] }}</td>
                                    <td class="px-2 py-1">{{ $v['plate_no'] }}</td>
                                    <td class="px-2 py-1">{{ $v['country'] }}</td>
                                    <td class="px-2 py-1">{{ $v['make'] }}</td>
                                    <td class="px-2 py-1">{{ $v['model'] }}</td>
                                    <td class="px-2 py-1">{{ $v['vin'] }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Users tabula -->
        <div id="section-users" data-topic="users" class="bg-white rounded shadow p-4">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-lg font-bold">Users</h2>
                <div class="relative">
                    <button type="button" data-toggle-filter="users" class="text-sm px-2 py-1 bg-gray-100 rounded">Filters</button>
                    <div data-filter-panel="users" class="hidden absolute right-0 mt-2 w-56 bg-white border rounded shadow p-3 z-20">
                        <label class="text-xs text-gray-500">Username</label>
                        <input data-filter-input="users" data-field="username" class="w-full border px-2 py-1 rounded mb-2 text-sm" placeholder="Username">
                        <label class="text-xs text-gray-500">Role</label>
                        <input data-filter-input="users" data-field="role" class="w-full border px-2 py-1 rounded mb-2 text-sm" placeholder="Role">
                        <div class="flex gap-2 justify-end">
                            <button type="button" data-filter-clear="users" class="text-sm px-2 py-1 bg-gray-100 rounded">Clear</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="text-left px-2 py-1">ID</th>
                            <th class="text-left px-2 py-1">Username</th>
                            <th class="text-left px-2 py-1">Full name</th>
                            <th class="text-left px-2 py-1">Role</th>
                            <th class="text-left px-2 py-1">Active</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $u)
                            @if(!$selectedUserId || $selectedUserId === $u['id'])
                                <tr class="border-b">
                                    <td class="px-2 py-1">{{ $u['id'] }}</td>
                                    <td class="px-2 py-1">{{ $u['username'] }}</td>
                                    <td class="px-2 py-1">{{ $u['full_name'] }}</td>
                                    <td class="px-2 py-1">{{ $u['role'] }}</td>
                                    <td class="px-2 py-1">
                                        {{ isset($u['active']) && $u['active'] ? 'Yes' : 'No' }}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Cases tabula -->
        <div id="section-cases" data-topic="cases" class="bg-white rounded shadow p-4">
            <h2 class="text-lg font-bold mb-3">Cases</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="text-left px-2 py-1">ID</th>
                            <th class="text-left px-2 py-1">Vehicle ID</th>
                            <th class="text-left px-2 py-1">Status</th>
                            <th class="text-left px-2 py-1">Priority</th>
                            <th class="text-left px-2 py-1">Arrival</th>
                            <th class="text-left px-2 py-1">Declarant</th>
                            <th class="text-left px-2 py-1">Consignee</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cases as $c)
                            @if((!$selectedVehicleId || ($c['vehicle_id'] ?? '') === $selectedVehicleId) && 
                                (!$selectedUserId || (
                                    (isset($c['declarant_id']) && $c['declarant_id'] === $selectedUserId) ||
                                    (isset($c['consignee_id']) && $c['consignee_id'] === $selectedUserId) ||
                                    (isset($c['created_by']) && $c['created_by'] === $selectedUserId)
                                )) )
                                <tr class="border-b">
                                    <td class="px-2 py-1">{{ $c['id'] }}</td>
                                    <td class="px-2 py-1">{{ $c['vehicle_id'] ?? '' }}</td>
                                    <td class="px-2 py-1">{{ $c['status'] ?? '' }}</td>
                                    <td class="px-2 py-1">{{ $c['priority'] ?? '' }}</td>
                                    <td class="px-2 py-1">{{ $c['arrival_ts'] ?? '' }}</td>
                                    <td class="px-2 py-1">{{ $c['declarant_id'] ?? '' }}</td>
                                    <td class="px-2 py-1">{{ $c['consignee_id'] ?? '' }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Inspections tabula -->
        <div id="section-inspections" data-topic="inspections" class="bg-white rounded shadow p-4">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-lg font-bold">Inspections</h2>
                <div class="relative">
                    <button type="button" data-toggle-filter="inspections" class="text-sm px-2 py-1 bg-gray-100 rounded">Filters</button>
                    <div data-filter-panel="inspections" class="hidden absolute right-0 mt-2 w-56 bg-white border rounded shadow p-3 z-20">
                        <label class="text-xs text-gray-500">Type</label>
                        <input data-filter-input="inspections" data-field="type" class="w-full border px-2 py-1 rounded mb-2 text-sm" placeholder="Type">
                        <label class="text-xs text-gray-500">Requested by</label>
                        <input data-filter-input="inspections" data-field="requested_by" class="w-full border px-2 py-1 rounded mb-2 text-sm" placeholder="User ID">
                        <div class="flex gap-2 justify-end">
                            <button type="button" data-filter-clear="inspections" class="text-sm px-2 py-1 bg-gray-100 rounded">Clear</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="text-left px-2 py-1">ID</th>
                            <th class="text-left px-2 py-1">Case ID</th>
                            <th class="text-left px-2 py-1">Type</th>
                            <th class="text-left px-2 py-1">Requested by</th>
                            <th class="text-left px-2 py-1">Start TS</th>
                            <th class="text-left px-2 py-1">Location</th>
                            <th class="text-left px-2 py-1">Checks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inspections as $i)
                            @if(!$selectedCaseId || $selectedCaseId === $i['case_id'])
                                <tr class="border-b">
                                    <td class="px-2 py-1">{{ $i['id'] }}</td>
                                    <td class="px-2 py-1">{{ $i['case_id'] }}</td>
                                    <td class="px-2 py-1">{{ $i['type'] }}</td>
                                    <td class="px-2 py-1">{{ $i['requested_by'] }}</td>
                                    <td class="px-2 py-1">{{ $i['start_ts'] }}</td>
                                    <td class="px-2 py-1">{{ $i['location'] }}</td>
                                    <td class="px-2 py-1">
                                        @if(!empty($i['checks']))
                                            @foreach($i['checks'] as $check)
                                                <div>
                                                    {{ $check['name'] }} – {{ $check['result'] }}
                                                </div>
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Documents tabula -->
        <div id="section-documents" data-topic="documents" class="bg-white rounded shadow p-4">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-lg font-bold">Documents</h2>
                <div class="relative">
                    <button type="button" data-toggle-filter="documents" class="text-sm px-2 py-1 bg-gray-100 rounded">Filters</button>
                    <div data-filter-panel="documents" class="hidden absolute right-0 mt-2 w-64 bg-white border rounded shadow p-3 z-20">
                        <label class="text-xs text-gray-500">Filename</label>
                        <input data-filter-input="documents" data-field="filename" class="w-full border px-2 py-1 rounded mb-2 text-sm" placeholder="Filename">
                        <label class="text-xs text-gray-500">Category</label>
                        <input data-filter-input="documents" data-field="category" class="w-full border px-2 py-1 rounded mb-2 text-sm" placeholder="Category">
                        <label class="text-xs text-gray-500">Uploaded by</label>
                        <input data-filter-input="documents" data-field="uploaded_by" class="w-full border px-2 py-1 rounded mb-2 text-sm" placeholder="User ID">
                        <div class="flex gap-2 justify-end">
                            <button type="button" data-filter-clear="documents" class="text-sm px-2 py-1 bg-gray-100 rounded">Clear</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="text-left px-2 py-1">ID</th>
                            <th class="text-left px-2 py-1">Case ID</th>
                            <th class="text-left px-2 py-1">Filename</th>
                            <th class="text-left px-2 py-1">MIME</th>
                            <th class="text-left px-2 py-1">Category</th>
                            <th class="text-left px-2 py-1">Pages</th>
                            <th class="text-left px-2 py-1">Uploaded by</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($documents as $d)
                            <tr class="border-b">
                                <td class="px-2 py-1">{{ $d['id'] }}</td>
                                <td class="px-2 py-1">{{ $d['case_id'] }}</td>
                                <td class="px-2 py-1">{{ $d['filename'] }}</td>
                                <td class="px-2 py-1">{{ $d['mime_type'] }}</td>
                                <td class="px-2 py-1">{{ $d['category'] ?? '' }}</td>
                                <td class="px-2 py-1">{{ $d['pages'] ?? '' }}</td>
                                <td class="px-2 py-1">{{ $d['uploaded_by'] ?? '' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Parties tabula -->
        <div id="section-parties" data-topic="parties" class="bg-white rounded shadow p-4">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-lg font-bold">Parties</h2>
                <div class="relative">
                    <button type="button" data-toggle-filter="parties" class="text-sm px-2 py-1 bg-gray-100 rounded">Filters</button>
                    <div data-filter-panel="parties" class="hidden absolute right-0 mt-2 w-64 bg-white border rounded shadow p-3 z-20">
                        <label class="text-xs text-gray-500">Name</label>
                        <input data-filter-input="parties" data-field="name" class="w-full border px-2 py-1 rounded mb-2 text-sm" placeholder="Name">
                        <label class="text-xs text-gray-500">Country</label>
                        <input data-filter-input="parties" data-field="country" class="w-full border px-2 py-1 rounded mb-2 text-sm" placeholder="Country">
                        <div class="flex gap-2 justify-end">
                            <button type="button" data-filter-clear="parties" class="text-sm px-2 py-1 bg-gray-100 rounded">Clear</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="text-left px-2 py-1">ID</th>
                            <th class="text-left px-2 py-1">Type</th>
                            <th class="text-left px-2 py-1">Name</th>
                            <th class="text-left px-2 py-1">Reg code</th>
                            <th class="text-left px-2 py-1">VAT</th>
                            <th class="text-left px-2 py-1">Country</th>
                            <th class="text-left px-2 py-1">Email</th>
                            <th class="text-left px-2 py-1">Phone</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($parties as $p)
                            <tr class="border-b">
                                <td class="px-2 py-1">{{ $p['id'] }}</td>
                                <td class="px-2 py-1">{{ $p['type'] }}</td>
                                <td class="px-2 py-1">{{ $p['name'] }}</td>
                                <td class="px-2 py-1">{{ $p['reg_code'] ?? '' }}</td>
                                <td class="px-2 py-1">{{ $p['vat'] ?? '' }}</td>
                                <td class="px-2 py-1">{{ $p['country'] }}</td>
                                <td class="px-2 py-1">{{ $p['email'] ?? '' }}</td>
                                <td class="px-2 py-1">{{ $p['phone'] ?? '' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <script src="dashboard.js" defer></script>
</x-app-layout>
