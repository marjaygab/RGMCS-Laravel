<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">
    
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-10">
            <i class="fas fa-tools"></i>
        </div>
        <div class="sidebar-brand-text mx-3">RGMCS <sup>2</sup></div>
    </a>
    
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    
    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="index.html">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
        </li>
        
        <!-- Divider -->
        <hr class="sidebar-divider">
        
        <!-- Heading -->
        <div class="sidebar-heading">
            Utilities
        </div>
        
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#itemManagerMenu"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-store"></i>
            <span>Item Manager</span>
        </a>
        <div id="itemManagerMenu" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Item Manager</h6>
                <a class="collapse-item" href="buttons.html">View Item</a>
            </div>
        </div>
        
        <!-- Nav Item - Pages Collapse Menu -->
    
    <li class="nav-item">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-money-bill-alt"></i>
            <span>Transactions</span></a>
    </li>
    
    <li class="nav-item">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-boxes"></i>
            <span>Stocks</span></a>
        </li>    
                
                <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    
    <li class="nav-item">
        <a class="nav-link" href="{{route('logout')}}">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span></a>
    </li>
    
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
    
</ul>
<!-- End of Sidebar -->
