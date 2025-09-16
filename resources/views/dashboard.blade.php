<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
    
    @section('content')
    <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-lg-6">
                    <!-- Card Statistik Member -->
                    <div class="card mb-4">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Statistik Member per Lokasi</h3>
                                <a href="{{ route('members.index') }}" 
                                class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">
                                View Members
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="fw-bold fs-5">{{ $stats->sum('members_count') }}</span> 
                                    <span>Total Member</span>
                                </p>
                                <p class="ms-auto d-flex flex-column text-end">
                                    <span class="text-success"> 
                                        <i class="bi bi-people"></i>
                                    </span>
                                    <span class="text-secondary">Across All Branches</span>
                                </p>
                            </div>

                            <!-- Chart -->
                            <div class="position-relative mb-4">
                                <canvas id="members-chart"></canvas>
                            </div>

                            <!-- Legend -->
                            <div class="d-flex flex-row justify-content-end">
                                @foreach ($stats as $branch)
                                    <span class="me-3">
                                        <i class="bi bi-square-fill text-primary"></i> {{ $branch->name }} ({{ $branch->members_count }})
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-6">
                    <!-- Card Pertumbuhan Member -->
                    <div class="card mb-4">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Pertumbuhan Member per Bulan</h3>
                                <a href="{{ route('members.index') }}"
                                class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">
                                View Members
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="fw-bold fs-5">{{ $membersGrowth->sum() }}</span>
                                    <span>Total Member 6 Bulan Terakhir</span>
                                </p>
                                <p class="ms-auto d-flex flex-column text-end">
                                    <span class="text-success">
                                        <i class="bi bi-graph-up"></i>
                                    </span>
                                    <span class="text-secondary">Trend</span>
                                </p>
                            </div>

                            <!-- Chart -->
                            <div class="position-relative mb-4">
                                <canvas id="growth-chart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Statistik Pendapatan per Lokasi</h3>
                                <a href="{{ route('payments.index') }}" 
                                class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">
                                View Payments
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="fw-bold fs-5">Rp{{ number_format($revenueData->sum(),0,',','.') }}</span>
                                    <span>Total Pendapatan</span>
                                </p>
                                <p class="ms-auto d-flex flex-column text-end">
                                    <span class="text-success">
                                        <i class="bi bi-cash-coin"></i>
                                    </span>
                                    <span class="text-secondary">Across All Branches</span>
                                </p>
                            </div>

                            <!-- Chart -->
                            <div class="position-relative mb-4">
                                <canvas id="revenue-chart"></canvas>
                            </div>

                            <!-- Legend -->
                            <div class="d-flex flex-row justify-content-end">
                                @foreach ($revenueLabels as $idx => $branchName)
                                    <span class="me-3">
                                        <i class="bi bi-square-fill text-primary"></i>
                                        {{ $branchName }} (Rp{{ number_format($revenueData[$idx],0,',','.') }})
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header border-0">
                            <div class="d-flex justify-content-between">
                                <h3 class="card-title">Statistik Pendapatan per Lokasi</h3>
                                <a href="{{ route('payments.index') }}" 
                                class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">
                                View Payments
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex">
                                <p class="d-flex flex-column">
                                    <span class="fw-bold fs-5">Rp{{ number_format($revenueData->sum(),0,',','.') }}</span>
                                    <span>Total Pendapatan</span>
                                </p>
                                <p class="ms-auto d-flex flex-column text-end">
                                    <span class="text-success">
                                        <i class="bi bi-cash-coin"></i>
                                    </span>
                                    <span class="text-secondary">Across All Branches</span>
                                </p>
                            </div>

                            <!-- Chart -->
                            <div class="position-relative mb-4">
                                <canvas id="revenue-chart"></canvas>
                            </div>

                            <!-- Legend -->
                            <div class="d-flex flex-row justify-content-end">
                                @foreach ($revenueLabels as $idx => $branchName)
                                    <span class="me-3">
                                        <i class="bi bi-square-fill text-primary"></i>
                                        {{ $branchName }} (Rp{{ number_format($revenueData[$idx],0,',','.') }})
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="{{ asset('js/chart.js') }}"></script>
    <script>
        const ctx = document.getElementById('members-chart').getContext('2d');
        const membersChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Jumlah Member',
                    data: @json($data),
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
    <script>
        const ctxGrowth = document.getElementById('growth-chart').getContext('2d');
        const growthChart = new Chart(ctxGrowth, {
            type: 'line',
            data: {
                labels: @json($months),
                datasets: [{
                    label: 'Member Baru',
                    data: @json($membersGrowth),
                    fill: true,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
    <script>
    const ctxRevenue = document.getElementById('revenue-chart').getContext('2d');
    new Chart(ctxRevenue, {
        type: 'bar',
        data: {
            labels: @json($revenueLabels),
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: @json($revenueData),
                backgroundColor: 'rgba(75, 192, 192, 0.7)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
    </script>
    <script>
        // Chart Pendapatan per Lokasi
        const ctxRevenue = document.getElementById('revenue-chart').getContext('2d');
        new Chart(ctxRevenue, {
            type: 'bar',
            data: {
                labels: @json($revenueLabels),
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: @json($revenueData),
                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });

        // Chart Pertumbuhan Pendapatan
        const ctxRevenueGrowth = document.getElementById('revenue-growth-chart').getContext('2d');
        new Chart(ctxRevenueGrowth, {
            type: 'line',
            data: {
                labels: @json($months),
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: @json($revenueGrowth),
                    fill: true,
                    backgroundColor: 'rgba(153, 102, 255, 0.2)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 2,
                    tension: 0.3,
                    pointBackgroundColor: 'rgba(153, 102, 255, 1)',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { display: true } },
                scales: { y: { beginAtZero: true } }
            }
        });
    </script>


    @endsection
</x-app-layout>
