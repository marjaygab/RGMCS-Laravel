
<?php use \App\Http\Controllers\DeviceController; ?>
@extends('main.layout',['current_user'=>session()->get('current_user')])

@section('sidebar_menu')
    {{view('sidebars.adminsidebar')}}
@endsection


@section('main_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            @if ($errors->any())
                <div class="row">
                    <div class="col-sm-12">
                        <div class="alert alert-danger" role="alert">
                            <strong>Oh no!</strong> {!!$errors->first()!!}
                        </div>
                    </div>
                </div>
            @endif
            <div class="row mb-3">
                <div class="col-sm-2">
                    <br>
                    <button id="toggleButton" type='submit' class='btn' name='toggle' value=''>Toggle Unit Price</button>
                </div>
                <div class="col-sm-8"></div>
                <div class="col-sm-2">
                    <label for="deviceSelection" class="mb-0">View</label>
                    <select class="form-control" name="deviceSelection" id="deviceSelection">
                        {!!DeviceController::generateList()!!}
                    </select>
                </div>
                <div class="col-sm-8"></div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Transactions</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="admintransactionsTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Item #</th>
                                            <th>Transaction Type</th>
                                            <th>Encoder</th>
                                            <th>Description</th>
                                            <th>Vendor</th>
                                            <th id="cost">Unit Cost</th>
                                            <th>QTY IN</th>
                                            <th>QTY OUT</th>
                                            <th>QTY OH</th>
                                            <th>Transaction Date</th>
                                            <th>Date Encoded</th>
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
        </div>
    </div>
</div>
@endsection