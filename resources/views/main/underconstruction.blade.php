
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
    <div class="col-sm-4"></div>
    <div class="col-sm-4">
        <div class="text-center">
            <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;"
                src="img/undraw_under_construction_46pa.svg" alt="">
                <h4 class="h4 mb-0 text-gray-500">This page is under construction. Please try again later.</h1>
        </div>
    </div>
    <div class="col-sm-4"></div>
</div>