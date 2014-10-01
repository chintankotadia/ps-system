@extends('layouts.admin')
@section('css')
    @parent
    {{ HTML::style('css/db_bootstrap.css')}}
@stop
@section('content')

    <div class="col-xs-12">
        <h3>Welcome, {{ Sentry::getUser()->first_name.' '.Sentry::getUser()->last_name}}</h3>
    </div>
@stop

@section('js')
    @parent
    {{ HTML::script('js/core.datatables.js')}}
    {{ HTML::script('js/local/admin.js')}}
@stop