<?php use \App\Http\Controllers\DatabaseHistoryController; ?>
@extends('main.layout')

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
            <div class="col-sm-12 text-center"><p>Backup Successful! Your Backup Code is..</p></div>
        </div>
        <div class="row">
            <div class="col-sm-12 text-center jumbotron bg-transparent" style="margin-top:0;margin-bottom:0;padding:0">
                <div class="container"> 
                <h1 class="display-1">{{DatabaseHistoryController::getBackupCode()}}</h1>
                    <p>{{DatabaseHistoryController::getFormattedDate()}}</p>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                <a href="{{route('dashboard')}}" class="btn btn-success btn-block">Go back to Work</a>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
    <div class="col-sm-4"></div>
</div>

@endsection

