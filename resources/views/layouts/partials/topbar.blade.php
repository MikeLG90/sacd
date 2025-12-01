<header class="topbar">
     <div class="container-fluid">
          <div class="navbar-header">
               <div class="d-flex align-items-center gap-2">
                    <!-- Menu Toggle Button -->
                    <div class="topbar-item">
                         <button type="button" class="button-toggle-menu topbar-button">
                              <iconify-icon icon="solar:hamburger-menu-broken" class="fs-24 align-middle"></iconify-icon>
                         </button>
                    </div>
               </div>

               <div class="d-flex align-items-center gap-1">
                    <!-- Theme Color (Light/Dark) -->
                    <div class="topbar-item">
                         <button type="button" class="topbar-button" id="light-dark-mode">
                              <iconify-icon icon="solar:moon-broken" class="fs-24 align-middle light-mode"></iconify-icon>
                              <iconify-icon icon="solar:sun-broken" class="fs-24 align-middle dark-mode"></iconify-icon>
                         </button>
                    </div>

                    <!-- Category -->
                    <div class="dropdown topbar-item d-none d-lg-flex">
                         <button type="button" class="topbar-button" data-toggle="fullscreen">
                              <iconify-icon icon="solar:full-screen-broken" class="fs-24 align-middle fullscreen"></iconify-icon>
                              <iconify-icon icon="solar:quit-full-screen-broken" class="fs-24 align-middle quit-fullscreen"></iconify-icon>
                         </button>
                    </div>

                    <!-- User -->
                                                   <h6 class="dropdown-header">Bienvenido {{ auth()->user()->name }}!</h6>
@foreach (auth()->user()->roles as $role)
    <span class="px-2 py-1 bg-blue-200 text-blue-800 rounded">
        {{ $role->name }}
    </span>
@endforeach
                    <div class="dropdown topbar-item">
                         <a type="button" class="topbar-button" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <span class="d-flex align-items-center">
                                   <img class="rounded-circle" width="32" src="/images/users/avatar-1.jpg" alt="avatar-3">
                              </span>
                         </a>
                         <div class="dropdown-menu dropdown-menu-end">
                              <!-- item-->
                              <h6 class="dropdown-header">Bienvenido Miguel!</h6>
@foreach (auth()->user()->roles as $role)
    <span class="px-2 py-1 bg-blue-200 text-blue-800 rounded">
        {{ $role->name }}
    </span>
@endforeach

                              <div class="dropdown-divider my-1"></div>

<a class="dropdown-item text-danger" href="{{ route('logout') }}"
   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    <i class="bx bx-log-out fs-18 align-middle me-1"></i>
    <span class="align-middle">Logout</span>
</a>

<form id="logout-form" action="{{ url('/logout/user') }}" method="POST" style="display: none;">
    @csrf
</form>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</header>
