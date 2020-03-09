@extends('main.layout')


@section('title',"Backup")


@section('sidebar_menu')
    @switch(Session::get('loggedInUserAccessLevelCode'))
        @case('ADMIN')
            {{view('sidebars.adminsidebar')}}
            @break
        @case('ENCODER')
            {{view('sidebars.encodersidebar')}}
            @break
        @case('INVENTORY')
            {{view('sidebars.inventorysidebar')}}
            @break
        @default
    @endswitch
@endsection


@section('main_content')
@if ($errors->any())
<div class="row">
    <div class="col-sm-12">
        <div class="alert alert-danger" role="alert">
            <strong>Oh no!</strong> {{$errors->first()}}
        </div>
    </div>
</div>
@endif


<div class="row mt-5">
    <div class="col-sm-4"></div>
    <div class="col-sm-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="text-center">
                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;"
                        src="img/undraw_upload.svg" alt="">
                        <h4 class="h4 mb-0 text-gray-500">Backing up your work would replace your current online progress. Do you still want to continue?</h1>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-2"></div>
            <div class="col-sm-4">
                <a href="{{route('dobackup')}}" class="btn btn-success btn-block">Yes</a>
            </div>
            <div class="col-sm-4">
                <a href="{{url()->previous()}}" class="btn btn-danger btn-block">No</a>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
    <div class="col-sm-4"></div>
</div>

@endsection

