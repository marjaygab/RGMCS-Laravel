
@extends('main.layout',['current_user'=>session()->get('current_user')])

@section('title',"Stocks")

@section('sidebar_menu')
    @if (Session::get('loggedInUserAccessLevelCode') == "INVENTORY")
        {{view('sidebars.inventorysidebar')}}          
    @else
        {{view('sidebars.encodersidebar')}}    
    @endif
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
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Stocks</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="stocksOverviewTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Item #</th>
                                    <th>Description</th>
                                    <th>Unit</th>
                                    <th>Stocks On Hand</th>
                                    @if (env('DEVICE_CODE') != "WAREHOUSE_ENCODER")
                                        <th>Warehouse Stocks</th>
                                    @endif
                                    <th>Unit Cost</th>
                                    @if (Session::get('loggedInUserAccessLevelCode') != "INVENTORY")
                                    <th>Action</th>
                                    @endif
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
@endsection