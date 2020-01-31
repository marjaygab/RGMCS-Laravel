<?php use \App\Http\Controllers\DatabaseHistoryController; ?>
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion toggled" id="accordionSidebar">
    
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
            <a class="nav-link" href="{{route('items')}}">
                <i class="fas fa-fw fa-hammer"></i>
                <span>Item Manager</span>
            </a>
        </li>
        
        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link" href="{{route('vendors')}}">
            <i class="fas fa-fw fa-store"></i>
            <span>Vendor Manager</span>
        </a>
    </li>
    
    <li class="nav-item">
        <a class="nav-link"  href="{{route('adminviewtransactions')}}">
            <i class="fas fa-fw fa-money-bill-alt"></i>
            <span>Transactions</span></a>
    </li>
    
    <li class="nav-item">
        <a class="nav-link" href="{{route('adminstocks')}}">
            <i class="fas fa-fw fa-boxes"></i>
            <span>Stocks</span></a>
        </li>
        

        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#noteBookMenu"
            aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-book"></i>
            <span>Notebook</span>
        </a>
        {{-- <li class="nav-item">
            <a class="nav-link" href="charts.html">
                <i class="fas fa-fw fa-book"></i>
                <span>Notebook</span></a>
        </li> --}}
        <div id="noteBookMenu" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Notebook</h6>
                <a class="collapse-item" href="{{route('notebook')}}">Encode Notebook Entries</a>
                <a class="collapse-item" href="#">View Notebook</a>
            </div>
        </div>
                
            
            
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
                <div class="bg-white py-1 collapse-inner rounded">
                    {{-- <a class="collapse-item" href="login.html">From References<div><small class="text-danger d-inline-block">{{DatabaseHistoryController::generateHistoryString('REFERENCES')}}</small></div></a> --}}
                    <a class="collapse-item" href="{{route('updatelocal',['deviceCode'=>"WAREHOUSE_ENCODER"])}}">From Warehouse Encoder <div><small class="text-danger d-inline-block">{{DatabaseHistoryController::generateHistoryString('WAREHOUSE_ENCODER')}}</small></div></a>
                    <a class="collapse-item" href="{{route('updatelocal',['deviceCode'=>"REDOR_ENCODER"])}}">From Redor Encoder <div><small class="text-danger d-inline-block">{{DatabaseHistoryController::generateHistoryString('REDOR_ENCODER')}}</small></div></a>
                    <a class="collapse-item" href="{{route('updatelocal',['deviceCode'=>"RENES_ENCODER"])}}">From Rene's Encoder <div><small class="text-danger d-inline-block">{{DatabaseHistoryController::generateHistoryString('RENES_ENCODER')}}</small></div></a>
                    <!-- <h6 class="collapse-header">Login Screens:</h6>
                        <a class="collapse-item" href="login.html">Login</a>
                        <a class="collapse-item" href="register.html">Register</a>
                        <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                        <div class="collapse-divider"></div>
                        <h6 class="collapse-header">Other Pages:</h6>
                        <a class="collapse-item" href="404.html">404 Page</a>
                        <a class="collapse-item" href="blank.html">Blank Page</a> -->
                    </div>
                </div>
            </li>
            
            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href={{route('backup')}}>
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
