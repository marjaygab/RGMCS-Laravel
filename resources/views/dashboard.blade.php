@extends('main.layout',['current_user'=>$current_user])

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
    {{view('main.underconstruction')}}
@endsection

