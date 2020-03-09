<?php use \App\Http\Controllers\VendorController; ?>
<?php use \App\Http\Controllers\ItemCatalogController; ?>
@extends('main.layout',['current_user'=>session()->get('current_user')])


@section('title',"Notebook")

@section('sidebar_menu')
    {{view('sidebars.adminsidebar')}}
@endsection


@section('main_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-4">
            <div class="row">
                <div class="col-sm-12">
                    <form role="form" action="" method="post">
                        <fieldset>
                            <h3>Order</h3>
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label>Date of Transaction</label>
                                    <div class="input-group date">
                                        <input type="text" class="form-control"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Supplier</label>
                                    <select name="" id="vendorSelection" class="form-control">
                                        {!!VendorController::generateOptionString()!!}
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <h3 class="col-sm-12">Order Details</h3>
                            </div>
        
                            <div class="row details mb-2">
                                <div class="col-sm-6">
                                    <label for="itemStepper" class="form-inline col-form-label">Items</label>
                                </div>
                                <div class="col-sm-6">
                                    <select name="" id="itemsSelection" class="form-control">
                                        {!!ItemCatalogController::generateOptionString()!!}
                                    </select>
                                </div> 
                            </div>
        
                            <div class="row details mb-2">
                                <div class="col-sm-6">
                                    <label for="itemStepper" class="form-inline col-form-label">Base Price</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" name="" id="basePrice" class="form-control">
                                </div> 
                            </div>
        
                            <div class="row details mb-2">
                                <div class="col-sm-6">
                                    <label for="itemStepper" class="form-inline col-form-label">D1</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="number" name="" id="discount1" class="form-control" min="-100">
                                </div> 
                            </div>
        
                            <div class="row details mb-2">
                                <div class="col-sm-6">
                                    <label for="itemStepper" class="form-inline col-form-label">D2</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="number" name="" id="discount2" class="form-control" min="-100">
                                </div> 
                            </div>
        
                            <div class="row details mb-2">
                                <div class="col-sm-6">
                                    <label for="itemStepper" class="form-inline col-form-label">D3</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="number" name="" id="discount3" class="form-control" min="-100">
                                </div> 
                            </div>
        
                            <div class="row details mb-2">
                                <div class="col-sm-6">
                                    <label for="itemStepper" class="form-inline col-form-label">D4</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="number" name="" id="discount4" class="form-control" min="-100">
                                </div> 
                            </div>
        
                            <div class="row details mb-2">
                                <div class="col-sm-6">
                                    <label for="itemStepper" class="form-inline col-form-label">Net Price</label>
                                </div>
                                <div class="col-sm-6">
                                    <input type="text" name="" id="netPrice" class="form-control" disabled>
                                </div> 
                            </div>
        
                            <div class="row details mb-2">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-3">
                                    <input type="button" value="Add Item" class="btn btn-success btn-block" id="addItemButton">
                                </div>
                                <div class="col-sm-3">
                                    <input type="button" value="Clear Fields" class="btn btn-danger btn-block control" id="clearFieldsButton">
                                </div>
                                <div class="col-sm-3"></div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-8">
            <div class="card border-left-primary shadow h-100">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Receipt <span id="receipt_id">#{{$receipt_id ?? ""}}</span></h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Receipts:</div>
                            <a class="dropdown-item" href="#">Submit Transaction</a>
                            <a class="dropdown-item" href="#">Clear Receipt Items</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Purchase From</div>
                            <div id="supplierName" class="h1 mb-0 font-weight-bold text-gray-800">Wiscon Enterprises</div>
                        </div>
                        <div class="col-auto">
                            <div id="transactionDateView" class="text-s font-weight-bold text-primary text-uppercase mb-1">2020/01/20</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <table id="reciptItemsTable" class="table table-borderless">
                                <thead>
                                     <tr>
                                        <th scope="col" class="text-center">Item</th>
                                        <th scope="col" class="text-center">Base Price</th>
                                        <th scope="col" class="text-center">D1</th>
                                        <th scope="col" class="text-center">D2</th>
                                        <th scope="col" class="text-center">D3</th>
                                        <th scope="col" class="text-center">D4</th>
                                        <th scope="col" class="text-center">Net Price</th>
                                        <th scope="col" class="text-center">Action</th>
                                     </tr>
                                </thead>
                                <tbody id="itemListContainer">
                                    {{-- <tr>
                                        <td class="itemColumn text-center">Amglobe, Base Only Coupling Type #2</td>
                                        <td class="baseColumn text-center">10</td>
                                        <td class="d1Column text-center">0</td>
                                        <td class="d2Column text-center">0</td>
                                        <td class="d3Column text-center">0</td>
                                        <td class="d4Column text-center">0</td>
                                        <td class="netpriceColumn text-center">10</td>
                                        <td class="text-center">
                                            <a href="#" class="deleteItem text-danger 0 control"><i class="fas fa-times-circle"></i></a>
                                            <a href="#" class="editItem text-primary 0 1 control"><i class="fas fa-pencil-alt"></i></a>
                                        </td>
                                    </tr> --}}
                                </tbody>
                            </table> 
                        </div>
                    </div>

                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total</div>
                        <div class="col-sm-4"></div>
                        <h5 class="col-sm-4 text-right"></h5>
                    </div>
                    <div class="row">
                        <h2 class="col-sm-8" id="supplierName">PHP <span id="total-label">0.00</span></h2>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-6">
                                    <a href="#" class="btn btn-primary btn-block" id="submitButton">Submit Transaction</a>
                                </div>
                                <div class="col-sm-6">
                                    <a href="#" class="btn btn-danger btn-block" id="clearButton">Clear Receipt Items</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>






            {{-- <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Dropdown Card Example</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Dropdown Header:</div>
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </div>
                    </div>
                </div>
                
            </div> --}}
        </div>
    </div>
</div>
<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
@endsection