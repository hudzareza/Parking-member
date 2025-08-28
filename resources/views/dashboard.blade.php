<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Total Member -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500">Total Members</div>
                    <div class="text-2xl font-bold">{{ $totalMembers }}</div>
                </div>

                <!-- Total Kendaraan -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500">Total Vehicles</div>
                    <div class="text-2xl font-bold">{{ $totalVehicles }}</div>
                </div>

                <!-- Tagihan Bulan Ini -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="text-gray-500">Invoices This Month</div>
                    <div class="text-2xl font-bold">{{ $invoicesThisMonth }}</div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
