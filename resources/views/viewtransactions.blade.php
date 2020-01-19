
@extends('main.layout',['current_user'=>session()->get('current_user')])

@section('sidebar_menu')
    {{view('sidebars.encodersidebar')}}
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
                    <h6 class="m-0 font-weight-bold text-primary">Transactions</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="transactionsTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Item #</th>
                                    <th>Transaction Type</th>
                                    <th>Encoder</th>
                                    <th>Description</th>
                                    <th>Vendor</th>
                                    <th id="costColumn">Unit Cost</th>
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
                    <div class="col-lg-4">
                        <button id="toggleButton" type='submit' class='btn' name='toggle' value='' style="margin-top:10px">Toggle Unit Price</button>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection