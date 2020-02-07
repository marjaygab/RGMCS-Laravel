
@extends('main.layout',['current_user'=>session()->get('current_user')])

@section('sidebar_menu')
    {{view('sidebars.encodersidebar')}}
@endsection


@section('main_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3">
            <form role="form" action="{{route('addtocart')}}" method="post">
            @csrf
                <fieldset>
                    @if ($errors->any())
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="alert alert-danger" role="alert">
                                    <strong>Oh no!</strong> {{$errors->first()}}
                                </div>
                            </div>
                        </div>
                    @endif


                    {{-- <div class="row">
                        <div class="col-sm-6">
                            Add Calendar here
                        </div>
                    </div> --}}
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>Item No</label> <input class="form-control" name="itemno" input="text" value="{{$encodeitemno ?? ''}}" readonly="readonly">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label class="">Unit Cost</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="unit_cost_label">₱</span>
                                </div>
                                <input type="number" class="form-control" placeholder="0.00" aria-label="0.00" aria-describedby="unit_cost_label" name="unit_cost" @if (empty($encodeitemno))
                                    disabled
                                @endif required value="{{$encodeunitcost ?? ''}}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <label class="">Transaction Date</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="tdate_label"><span class="fas fa-calendar"></span></span>
                                </div>
                                <input type="text" id="datepicker" class="form-control" placeholder="{{date('Y-m-d')}}" aria-label="0.00" aria-describedby="tdate_label" name="tdate" @if (empty($encodeitemno))
                                    disabled
                                @endif required value="{{$tdate ?? ''}}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Description</label> <input class="form-control" name="itemdesc" input="text" value="{{$encodeitemdesc ?? ''}}" disabled>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Transaction Type</label>
                                <select name="transaction_type" id="" class="form-control" @if (empty($encodeitemno))
                                disabled
                            @endif>
                                    {!!$transaction_type_options!!}
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Vendor</label>
                                <select name="vendor" id="" class="form-control" @if (empty($encodeitemno))
                                disabled
                            @endif>
                                    {!!$vendor_options!!}
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Quantity</label> <input class="form-control" name="qty" step="any" type="number" value="0" min="0" @if (empty($encodeitemno))
                                disabled
                            @endif>
                            </div>
                        </div>
                    </div>
                    <input type="submit" value="Add to Cart" class="btn btn-lg btn-success btn-block" @if (empty($encodeitemno))
                    disabled
                @endif/>
                </fieldset>
            </form>
        </div>
        <div class="col-sm-9">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Items</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="itemOverviewTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Item #</th>
                                    <th>Description</th>
                                    <th>Unit</th>
                                    <th>Current Stocks</th>
                                    {{-- <th>Current Price</th> --}}
                                    <th>Action</th>
                                    {{-- <th>Item #</th>
                                    <th>Transaction Type</th>
                                    <th>Description</th>
                                    <th>QTY IN</th>
                                    <th>QTY OUT</th>
                                    <th>Current Stocks</th>
                                    <th>Transaction Date</th>
                                    <th>Date Encoded</th> --}}
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