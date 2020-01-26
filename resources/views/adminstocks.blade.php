
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
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Stocks</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="adminstocksOverviewTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="text-center" style="vertical-align : middle;text-align:center;">Item #</th>
                                    <th rowspan="2" class="text-center" style="vertical-align : middle;text-align:center;">Description</th>
                                    <th rowspan="2" class="text-center" style="vertical-align : middle;text-align:center;">Unit</th>
                                    <th colspan="3" id="qtyHeader" class="text-center" style="vertical-align : middle;text-align:center;">Stocks On Hand</th>
                                    <th rowspan="2" class="text-center" style="vertical-align : middle;text-align:center;">Unit Cost</th>
                                    <th rowspan="2" class="text-center" style="vertical-align : middle;text-align:center;">Action</th>
                                </tr>
                                <tr>
                                    <th class="text-center">Rene's</th>
                                    <th class="text-center">Redor</th>
                                    <th class="text-center">Warehouse</th>
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