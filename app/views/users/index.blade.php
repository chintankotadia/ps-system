@extends('layouts.admin')
@section('css')
    @parent
    {{ HTML::style('css/db_bootstrap.css')}}
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @if(Session::has('message'))
                        {{ alert_message('success', Session::get('message')) }}
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered" id="user-table">
                            <thead>
                                <tr>
                                    <th class="text-center"><input type="checkbox" value="1" name="hello"/></th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Group</th>
                                    <th>Created On</th>
                                    <th>Is Active</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td colspan="7">Loading data..</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    @parent
    {{ HTML::script('js/core.datatables.js')}}
    {{ HTML::script('js/local/user.js')}}
@stop