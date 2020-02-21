<?php use \App\Http\Controllers\ItemCatalogController; ?>
@extends('main.layout',['current_user'=>session()->get('current_user')])

@section('sidebar_menu')
    {{view('sidebars.adminsidebar')}}
@endsection


@section('main_content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-sm-1">
            <label for="toggleView" class="d-block">Set View:</label>
            <input id="toggleView" class="float-right" type="checkbox" data-toggle="toggle" data-on="Receipt" data-off="Items" name="toggleView">
        </div>
        <div class="col-sm-2">
            <label for="receiptDateRange">Search By Date:</label>
            <div id="receiptDateRange" class="input-group input-daterange" name="receiptDateRange">
                <input type="text" class="form-control" value="">
                <div class="input-group-addon" > to </div>
                <input type="text" class="form-control" value="">
            </div>
        </div>
    </div>
    <div id="receiptView" class="row">
        <div class="col-sm-6">
            @if ($errors->any())
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="alert alert-danger" role="alert">
                                            <strong>Oh no!</strong> {!!$errors->first()!!}
                                        </div>
                                    </div>
                                </div>
                            @endif
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Notebook</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="receiptsTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Transaction Date</th>
                                    <th>Vendor</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card border-left-primary shadow">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Receipt</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Receipts:</div>
                            <a class="dropdown-item" href="#">Edit</a>
                            <a class="dropdown-item" href="#">Print Receipt</a>
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
                            <table id="receiptItemsTable" class="table w-100">
                                <thead>
                                     <tr>
                                        <th scope="col" class="text-center">Item</th>
                                        <th scope="col" class="text-center">Base Price</th>
                                        <th scope="col" class="text-center">D1</th>
                                        <th scope="col" class="text-center">D2</th>
                                        <th scope="col" class="text-center">D3</th>
                                        <th scope="col" class="text-center">D4</th>
                                        <th scope="col" class="text-center">Net Price</th>
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
                        <div class="col-sm-4"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="modal fade" id="editReceiptModal" tabindex="-1" role="dialog" aria-labelledby="editReceiptModalLabel"
        aria-hidden="true">
        <form action="{{route('update-receipt')}}" method="POST">
            @csrf
            <div class="modal-dialog" role="document" style="max-width:700px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editReceiptModalLabel">Edit Receipt</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row details mb-2">
                            <div class="col-sm-6">
                                <label for="itemStepper" class="form-inline col-form-label">Receipt ID</label>
                            </div>
                            <div class="col-sm-6">
                                <input type="text" name="receipt_id" id="receiptId" class="form-control modal-field" readonly>
                            </div> 
                        </div>
                        <div class="row details mb-2">
                            <div class="col-sm-6">
                                <label for="itemStepper" class="form-inline col-form-label">Vendor</label>
                            </div>
                            <div class="col-sm-6">
                                <select name="vid" id="vendorSelection" class="form-control modal-field">
                                </select>
                            </div> 
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div> --}}
    </div>
    <div class="row" id="itemsView">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Receipt Items</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="receiptItemsOverviewTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Receipt #</th>
                                            <th>Transaction Date</th>
                                            <th>Vendor</th>
                                            <th>Description</th>
                                            <th>Base Price</th>
                                            <th>D1</th>
                                            <th>D2</th>
                                            <th>D3</th>
                                            <th>D4</th>
                                            <th>Net Price</th>
                                            <th scope="col" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="editReceiptItemModal" tabindex="-1" role="dialog" aria-labelledby="editReceiptItemModalLabel"
                aria-hidden="true">
                <form action="{{route('update-receipt-item')}}" method="POST">
                    @csrf
                    <div class="modal-dialog" role="document" style="max-width:700px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editReceiptItemModalLabel">Edit Receipt Item</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                    <div class="row details mb-2">
                                        <div class="col-sm-6">
                                            <label for="itemStepper" class="form-inline col-form-label">Receipt ID</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" name="receipt_id" id="receiptId" class="form-control modal-field" readonly>
                                        </div> 
                                    </div>
                                    <div class="row details mb-2">
                                        <div class="col-sm-6">
                                            <label for="itemStepper" class="form-inline col-form-label">Receipt Item No</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" name="receipt_item_no" id="receiptItemNo" class="form-control modal-field" readonly>
                                        </div> 
                                    </div>
                                    <div class="row details mb-2">
                                        <div class="col-sm-6">
                                            <label for="itemStepper" class="form-inline col-form-label">Items</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <select name="itemno" id="itemsSelection" class="form-control modal-field">
                                                {{-- {!!ItemCatalogController::generateOptionString()!!} --}}
                                            </select>
                                        </div> 
                                    </div>
                
                                    <div class="row details mb-2">
                                        <div class="col-sm-6">
                                            <label for="itemStepper" class="form-inline col-form-label">Base Price</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" name="basePrice" id="basePrice" class="form-control modal-field">
                                        </div> 
                                    </div>
                
                                    <div class="row details mb-2">
                                        <div class="col-sm-6">
                                            <label for="itemStepper" class="form-inline col-form-label">D1</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="number" name="d1" id="discount1" class="form-control modal-field" min="-100">
                                        </div> 
                                    </div>
                
                                    <div class="row details mb-2">
                                        <div class="col-sm-6">
                                            <label for="itemStepper" class="form-inline col-form-label">D2</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="number" name="d2" id="discount2" class="form-control modal-field" min="-100">
                                        </div> 
                                    </div>
                
                                    <div class="row details mb-2">
                                        <div class="col-sm-6">
                                            <label for="itemStepper" class="form-inline col-form-label">D3</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="number" name="d3" id="discount3" class="form-control modal-field" min="-100">
                                        </div> 
                                    </div>
                
                                    <div class="row details mb-2">
                                        <div class="col-sm-6">
                                            <label for="itemStepper" class="form-inline col-form-label">D4</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="number" name="d4" id="discount4" class="form-control modal-field" min="-100">
                                        </div> 
                                    </div>
                
                                    <div class="row details mb-2">
                                        <div class="col-sm-6">
                                            <label for="itemStepper" class="form-inline col-form-label">Net Price</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" name="netPrice" id="netPrice" class="form-control modal-field" readonly>
                                        </div> 
                                    </div>
                                </div>
                            
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                    <button class="btn btn-primary" type="submit">Submit</button>
                                </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</div>
@endsection