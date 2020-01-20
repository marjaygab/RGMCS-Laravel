<?php use \App\Http\Controllers\CartController; ?>
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
        
    <li class="nav-item">
        <a class="nav-link" href="{{route('cart')}}">
            <i class="fas fa-fw fa-shopping-cart"></i>
            <span>Cart</span> <span class='badge badge-right badge-pill badge-light text-danger'>{{CartController::getCartItemCount()}}</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#transactionsManagerMenu"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-money-bill-alt"></i>
        <span>Transactions Manager</span>
    </a>
    <div id="transactionsManagerMenu" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Vendor Manager</h6>
            <a class="collapse-item" href="{{route('encode')}}">Encode Transactions</a>
            <a class="collapse-item" href="{{route('viewtransactions')}}">View Transactions</a>
        </div>
    </div>
</li>

    <li class="nav-item">
        <a class="nav-link" href="{{route('stocks')}}">
            <i class="fas fa-fw fa-boxes"></i>
            <span>Stocks</span></a>
        </li>
        
            <!-- Divider -->
            <hr class="sidebar-divider">
            
            <!-- Heading -->
            <div class="sidebar-heading">
                Data
            </div>
            
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#updateLocalMenu"
                aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-fw fa-download"></i>
                <span>Update Local</span>
            </a>
            <div id="updateLocalMenu" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item" href="login.html">From Warehouse Encoder</a>
                    </div>
                </div>
            </li>
            
            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="charts.html">
                    <i class="fas fa-fw fa-upload"></i>
                    <span>Backup Local Data</span></a>
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
