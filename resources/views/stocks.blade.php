
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
                                    <th>Unit Cost</th>
                                    <th>Action</th>
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