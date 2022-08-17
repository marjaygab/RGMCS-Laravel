<?php use \App\Http\Controllers\ItemCatalogController; ?>
@extends('main.layout',['current_user'=>session()->get('current_user')])

@section('title',"Notebook")


@section('sidebar_menu')
    {{view('sidebars.adminsidebar')}}
@endsection


@section('main_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Receipt Items</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="singleItemReceiptsTable" width="100%" cellspacing="0">
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
                                        @foreach($receiptsItems as $item)
                                            <tr>
                                                <td>{{ $item->receipt_id }}</td>
                                                <td>{{ $item->receipts->tdate }}</td>
                                                <td>{{ $item->receipts->vendor }}</td>
                                                <td>{{ $item->itemdesc }}</td>
                                                <td>{{ $item->baseprice }}</td>
                                                <td>{{ $item->d1 }}</td>
                                                <td>{{ $item->d2 }}</td>
                                                <td>{{ $item->d3 }}</td>
                                                <td>{{ $item->d4 }}</td>
                                                <td>{{ $item->netprice }}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-primary btn-icon-split btn-sm" data-toggle="modal" data-target="#editSingleReceiptItemModal{{ $item->id }}">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-edit"></i>
                                                        </span>
                                                        <span class="text">Edit Item</span>
                                                    </button>
                                                    <button class="btn btn-danger btn-icon-split btn-sm" data-toggle="modal" data-target="#deleteItem{{ $item->id }}">
                                                        <span class="icon text-white-50">
                                                            <i class="fas fa-trash"></i>
                                                        </span>
                                                        <span class="text">Delete</span>
                                                    </button>
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="editSingleReceiptItemModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="editSingleReceiptItemModal{{ $item->id }}Label"
                                                aria-hidden="true">
                                                <form action="{{ route("notebook.item.update", ["id" => $item->id]) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-dialog" role="document" style="max-width:700px;">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editSingleReceiptItemModal{{ $item->id }}Label">Edit "{{ $item->itemdesc }}" from {{ $item->receipts->vendor }}</h5>
                                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row details mb-2">
                                                                    <div class="col-sm-6">
                                                                        <label for="itemStepper" class="form-inline col-form-label">Base Price</label>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <input type="text" name="basePrice" id="basePrice" value="{{ $item->baseprice }}" class="form-control modal-field">
                                                                    </div> 
                                                                </div>
                                            
                                                                <div class="row details mb-2">
                                                                    <div class="col-sm-6">
                                                                        <label for="itemStepper" class="form-inline col-form-label">D1</label>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <input type="number" name="d1" id="discount1" value="{{ $item->d1 }}" class="form-control modal-field" min="-100">
                                                                    </div> 
                                                                </div>
                                            
                                                                <div class="row details mb-2">
                                                                    <div class="col-sm-6">
                                                                        <label for="itemStepper" class="form-inline col-form-label">D2</label>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <input type="number" name="d2" id="discount2" value="{{ $item->d2 }}" class="form-control modal-field" min="-100">
                                                                    </div> 
                                                                </div>
                                            
                                                                <div class="row details mb-2">
                                                                    <div class="col-sm-6">
                                                                        <label for="itemStepper" class="form-inline col-form-label">D3</label>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <input type="number" name="d3" id="discount3" value="{{ $item->d3 }}" class="form-control modal-field" min="-100">
                                                                    </div> 
                                                                </div>
                                            
                                                                <div class="row details mb-2">
                                                                    <div class="col-sm-6">
                                                                        <label for="itemStepper" class="form-inline col-form-label">D4</label>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <input type="number" name="d4" id="discount4" value="{{ $item->d4 }}" class="form-control modal-field" min="-100">
                                                                    </div> 
                                                                </div>

                                                                <input type="hidden" name="itemNo" value="{{ $itemNo }}">
                                                            </div>
                                                        
                                                            <div class="modal-footer">
                                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                                <button class="btn btn-primary" type="submit">Submit</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                            <div class="modal fade" id="deleteItem{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteItem{{ $item->id }}Label"
                                                aria-hidden="true">
                                                <form action="{{ route("notebook.item.destroy", ["id" => $item->id]) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-dialog" role="document" style="max-width:700px;">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="deleteItem{{ $item->id }}Label"> Deleting "{{ $item->itemdesc }}" from {{ $item->receipts->vendor }}</h5>
                                                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">×</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <h5>Are you sure you want to delete this record?</h5>
                                                                <input type="hidden" name="itemNo" value="{{ $itemNo }}">
                                                            </div>
                                                        
                                                            <div class="modal-footer">
                                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                                <button class="btn btn-danger" type="submit">Delete</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection