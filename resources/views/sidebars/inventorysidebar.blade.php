<?php use \App\Http\Controllers\DatabaseHistoryController; ?>
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion toggled" id="accordionSidebar">
    
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('dashboard')}}">
        <div class="sidebar-brand-icon rotate-n-10">
            <i class="fas fa-tools"></i>
        </div>
        <div class="sidebar-brand-text mx-3">RGMCS <sup>2</sup></div>
    </a>
    
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    
    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('dashboard')}}">
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
        <a class="nav-link" href="{{route('viewtransactions')}}">
            <i class="fas fa-fw fa-money-bill-alt"></i>
            <span>Transactions</span></a>
    </li>
    
    <li class="nav-item">
        <a class="nav-link" href="{{route('stocks')}}">
            <i class="fas fa-fw fa-boxes"></i>
            <span>Stocks</span></a>
        </li>   
        
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
                <a class="collapse-item" href="{{route('updatelocal',['deviceCode'=>"REFERENCES"])}}">From References<div><small class="text-danger d-inline-block">{{DatabaseHistoryController::generateHistoryString('REFERENCES')}}</small></div></a>
                <a class="collapse-item" href="{{route('updatelocal',['deviceCode'=>"RENES_ENCODER"])}}">From Renes Encoder<div><small class="text-danger d-inline-block">{{DatabaseHistoryController::generateHistoryString('RENES_ENCODER')}}</small></div></a>
                @if (env('DEVICE_CODE') != "WAREHOUSE_ENCODER")
                    <a class="collapse-item" href="{{route('updatelocal',['deviceCode'=>"WAREHOUSE_ENCODER"])}}">From Warehouse Encoder <div><small class="text-danger d-inline-block">{{DatabaseHistoryController::generateHistoryString('WAREHOUSE_ENCODER')}}</small></div></a>
                @endif
                {{-- <a class="collapse-item" href="login.html">From Warehouse Encoder</a> --}}
            </div>
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
