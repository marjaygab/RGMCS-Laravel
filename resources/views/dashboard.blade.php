<?php use \App\Http\Controllers\RGMCSFactory; ?>
@extends('main.layout',['current_user'=>$current_user])

@section('title',"Dashboard")


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
<div class="row" style="height: 100%">
    <div class="col-sm-4"></div>
    <div class="col-sm-4">
        <div class="text-center" style="margin-top:30%">
            <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 35rem;"
                src="{{RGMCSFactory::getGreetings(Session::get('loggedInUserName'))['image']}}" alt="">
                <h4 class="h4 mb-0 text-gray-500">{{RGMCSFactory::getGreetings(Session::get('loggedInUserName'))['greeting']}}</h4>
                
        </div>
    </div>
    <div class="col-sm-4"></div>
</div>
@endsection

