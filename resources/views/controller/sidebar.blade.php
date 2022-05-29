<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="fab fa-google"></i>
    </div>
    <div class="sidebar-brand-text mx-2">{{ config('app.name', 'Laravel') }} <sup></sup></div>
  </a>
  <hr class="sidebar-divider">
  <div class="sidebar-heading">
    Home
  </div>
  <li class="nav-item {{($active_sidebar=="home"?'active':'')}}">
    <a class="nav-link" href="{{ url('/admin/home') }}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Home</span></a>
  </li>
  
  
  <hr class="sidebar-divider">
  <div class="sidebar-heading">
    Other
  </div>
  <li class="nav-item {{($active_sidebar=="shop"?'active':'')}}">
    <a class="nav-link" href="{{ url('/admin/shop/') }}">
      <i class="fas fa-book-open fa-lg"></i>
      <span>Shop</span></a>
  </li>
  <li class="nav-item {{($active_sidebar=="product"?'active':'')}}">
    <a class="nav-link" href="{{ url('/admin/product/') }}">
      <i class="fas fa-book-open fa-lg"></i>
      <span>Product</span></a>
  </li>
  


  <hr class="sidebar-divider d-none d-md-block">
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>
</ul>