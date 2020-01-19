
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
                    <h6 class="m-0 font-weight-bold text-primary">Cart</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="cartOverViewTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Item #</th>
                                    <th>Transaction Type</th>
                                    <th>Encoder</th>
                                    <th>Description</th>
                                    <th>Vendor</th>
                                    <th>Unit Cost</th>
                                    <th>QTY IN</th>
                                    <th>QTY OUT</th>
                                    <th>Transaction Date</th>
                                    <th>Date Encoded</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <a href="{{route('processcart')}}" class="btn btn-success btn-icon-split mt-4">
                        <span class="icon text-white-50">
                            <i class="fas fa-cogs"></i>
                        </span>
                        <span class="text">Process Cart</span>
                    </a>
                    <a href="{{route('clearcart')}}" class="btn btn-danger btn-icon-split mt-4">
                        <span class="icon text-white-50">
                            <i class="fas fa-trash-alt"></i>
                        </span>
                        <span class="text">Clear Cart</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection