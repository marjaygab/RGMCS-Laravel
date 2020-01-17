
@extends('main.layout',['current_user'=>session()->get('current_user')])

@section('sidebar_menu')
    {{view('sidebars.adminsidebar')}}
@endsection


@section('main_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3">
            @if (empty($edititemno))
            <form role="form" action="{{route('createitems')}}" method="post">
            @else
            <form role="form" action="{{route('updateitems',['edititemno'=>$edititemno])}}" method="post">
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
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Item type</label>
                                <select class="form-control" name="itemtype">
                                    {!!$type_options!!}
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Unit</label>
                                <select name="unit" id="" class="form-control">
                                    {!!$unit_options!!}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Description</label> <input class="form-control" name="itemdesc" input="text" value="{{$toEditItemDesc}}" required>
                            </div>
                        </div>
                    </div>
                    @if (empty($edititemno))
                        <input type="submit" value="Add" class="btn btn-lg btn-success btn-block"/>
                    @else
                        <input type="submit" value="Update Item" class="btn btn-lg btn-primary btn-block"/>
                    @endif
                </fieldset>
            </form>
            <div class="row mt-3">
                <div class="col-sm-12">
                    <div class="card shadow mb-4">
						<div class="card-header py-3">
							<h6 class="m-0 font-weight-bold text-primary">Recycle Bin</h6>
						</div>
						<div class="card-body">
                            
							<div class="table-responsive">
								<table class="table table-bordered" id="itemBinTable" width="100%" cellspacing="0">
									<thead>
										<tr>
											<th>Description</th>
											<th>Action</th>
										</tr>
									</thead>
								</table>
                            </div>
                            
                            <div class="row">
                                <div class="col-sm-6 text-center">
                                    <form action="{{route('clearitembin')}}" method="POST">
                                        @csrf
                                        <input class='btn btn-warning btn-lg mt-2' type="submit" value="Clear Bin">
                                    </form>
                                </div>
                                <div class="col-sm-6 text-center">
                                    <form action="{{route('deleteitemfrombin')}}" method="POST">
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
                    <h6 class="m-0 font-weight-bold text-primary">Items</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="itemsTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Item #</th>
                                    <th>Description</th>
                                    <th>Unit</th>
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