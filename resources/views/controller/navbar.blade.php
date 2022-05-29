<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
  <button id="sidebarToggleTop" class="btn btn-link mr-3">
    <i class="fa fa-bars"></i>
  </button>                 
  <ul class="navbar-nav ml-auto">
    <li> 
      <a target="_blank" href="{{ url('/') }}" class="view-website-link d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fab fa-chrome"></i> View website</a>
    </li>
    <div class="topbar-divider d-none d-sm-block"></div>
    <li class="nav-item dropdown no-arrow">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="mr-2 d-none d-lg-inline text-gray-600">{{Auth::user()->email ?? Auth::user()->mobile_no }}</span>
        <img class="img-profile rounded-circle" src="{{ url('assets/backend/images/user-139-512.png') }}">
      </a>
      <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
          <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
          Logout
        </a>
        
      </div>
    </li>
  </ul>
</nav>