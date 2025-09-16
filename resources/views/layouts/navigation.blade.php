<nav class="app-header navbar navbar-expand bg-body">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
            <i class="bi bi-list"></i>
            </a>
        </li>
        </ul>
        <!--begin::User Menu Dropdown-->
        <li class="nav-item dropdown user-menu" style="list-style: none; padding-left: 0; margin: 0;">
            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
            <img
                src="{{ asset('img/user.png') }}"
                width="32"
                height="32"
                class="user-image rounded-circle shadow"
                alt="User Image"
            />
            <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
            <li class="user-footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                        class="btn btn-default btn-flat float-end"
                        onclick="event.preventDefault();
                            this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </li>
            </ul>
        </li>
        <!--end::User Menu Dropdown-->
        </ul>
        <!--end::End Navbar Links-->
    </div>
    <!--end::Container-->
</nav>
<!--begin::Sidebar-->
  <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
      <!--begin::Brand Link-->
      <div class="brand-link">
        <!--begin::Brand Image-->
        <img
          src="{{ asset('img/abid.png') }}"
          alt="AdminLTE Logo"
          class="brand-image opacity-75 shadow"
        />
        <!--end::Brand Image-->
        <!--begin::Brand Text-->
        <span class="brand-text fw-light">Member Parking APP</span>
        <!--end::Brand Text-->
      </div>
      <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
      <nav class="mt-2">
        <!--begin::Sidebar Menu-->
        <ul
          class="nav sidebar-menu flex-column"
          data-lte-toggle="treeview"
          role="navigation"
          aria-label="Main navigation"
          data-accordion="false"
          id="navigation"
        >
          {{-- Dashboard: hanya Super Admin & Pusat --}}
            @role('super-admin|pusat')
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <i class="nav-icon bi bi-speedometer"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            @endrole


          {{-- User Management: hanya Super Admin --}}
          @role('super-admin')
          <li class="nav-item">
              <a href="{{ route('users.index') }}" class="nav-link">
                  <i class="nav-icon bi bi-people"></i>
                  <p>User</p>
              </a>
          </li>
          @endrole

          {{-- Lokasi: Super Admin & Pusat --}}
          @role('super-admin|pusat')
          <li class="nav-item">
              <a href="{{ route('branches.index') }}" class="nav-link">
                  <i class="nav-icon bi bi-geo-alt"></i>
                  <p>Lokasi</p>
              </a>
          </li>
          @endrole

          {{-- Member: Super Admin, Pusat, Lokasi --}}
          @role('super-admin|pusat|cabang')
          <li class="nav-item">
              <a href="{{ route('members.index') }}" class="nav-link">
                  <i class="nav-icon bi bi-person-badge"></i>
                  <p>Member</p>
              </a>
          </li>
          @endrole

          {{-- Tarif: Super Admin & Pusat full akses, Lokasi hanya view --}}
          @role('super-admin|pusat|cabang')
          <li class="nav-item">
              <a href="{{ route('tariffs.index') }}" class="nav-link">
                  <i class="nav-icon bi bi-cash-coin"></i>
                  <p>Tarif</p>
              </a>
          </li>
          @endrole

          {{-- Invoice: semua role, member hanya lihat invoice sendiri --}}
          @role('super-admin|pusat|cabang|member')
          <li class="nav-item">
              <a href="{{ route('invoices.index') }}" class="nav-link">
                  <i class="nav-icon bi bi-receipt"></i>
                  <p>Invoice</p>
              </a>
          </li>
          @endrole

          {{-- Payment: semua role, member hanya lihat payment sendiri --}}
          @role('super-admin|pusat|cabang|member')
          <li class="nav-item">
              <a href="{{ route('payments.index') }}" class="nav-link">
                  <i class="nav-icon bi bi-wallet2"></i>
                  <p>Payment</p>
              </a>
          </li>
          @endrole
          <hr>
          <hr>
          {{-- Laporan Kendaraan per Lokasi: hanya Super Admin & Pusat --}}
            @role('super-admin|pusat')
            <li class="nav-item">
                <a href="{{ route('vehicles.listPerBranch') }}" class="nav-link">
                    <i class="nav-icon bi bi-truck"></i>
                    <p>Laporan Kendaraan</p>
                </a>
            </li>
            @endrole
        </ul>
        <!--end::Sidebar Menu-->
      </nav>
    </div>
    <!--end::Sidebar Wrapper-->
  </aside>
<!--end::Sidebar-->

