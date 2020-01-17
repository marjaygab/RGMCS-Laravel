
@extends('main.layout',['current_user'=>session()->get('current_user')])

@section('sidebar_menu')
    {{view('sidebars.adminsidebar')}}
@endsection


@section('main_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3">
            <div class="row">
                <div class="col-sm-12">
                    @if (empty($editvendorid))
                    <form role="form" action="{{route('createvendors')}}" method="post">
                    @else
                    <form role="form" action="{{route('updatevendors',['editvendorid'=>$vid])}}" method="post">
                    @endif
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
                            
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Vendor</label> <input class="form-control" name="vendor" input="text" value="{{$vendor ?? ''}}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Contact Person</label> <input class="form-control" name="vperson" input="text" value="{{$vperson ?? ''}}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Address</label> <textarea class="form-control" name="vaddress" input="text" value="{{$vaddress ?? ''}}" required rows="5">{{$vaddress ?? ''}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Contact Number</label> <input class="form-control" name="vcontact" input="text" value="{{$vcontact ?? ''}}" required>
                                    </div>
                                </div>
                            </div>
                            @if (empty($editvendorid))
                                <input type="submit" value="Add" class="btn btn-lg btn-success btn-block"/>
                            @else
                                <input type="submit" value="Update Item" class="btn btn-lg btn-primary btn-block"/>
                            @endif
                        </fieldset>
                    </form> 
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-sm-12">
                    <div class="card shadow mb-4">
						<div class="card-header py-3">
							<h6 class="m-0 font-weight-bold text-primary">Recycle Bin</h6>
						</div>
						<div class="card-body">
                            
							<div class="table-responsive">
								<table class="table table-bordered" id="vendorBinTable" width="100%" cellspacing="0">
									<thead>
										<tr>
											<th>Vendor</th>
											<th>Person</th>
											<th>Action</th>
										</tr>
									</thead>
								</table>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-6 text-center">
                                    <form action="{{route('clearbin')}}" method="POST">
                                        @csrf
                                        <input class='btn btn-warning btn-lg mt-2' type="submit" value="Clear Bin">
                                    </form>
                                </div>
                                <div class="col-sm-6 text-center">
                                    <form action="{{route('deletefrombin')}}" method="POST">
                                        @csrf
                                        <input class='btn btn-danger btn-lg mt-2' type="submit" value="Delete All">
                                    </form>
                                </div>
                            </div>
                            
						</div>
					</div>
                </div>
            </div>
           


        </div>
        <div class="col-sm-9">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Vendors</h6   >
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="vendorsTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Vendor</th>
                                    <th>Contact Person</th>
                                    <th>Address</th>
                                    <th>Contact #</th>
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