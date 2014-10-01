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
                    {{ Form::open(['class' => 'form-horizontal', 'url' => URL::to('admin/user/save')])}}
                        {{ Form::hidden('id', isset($user->id) ? $user->id : Input::old('id')) }}
                        <div class="form-group">
                            <label class="col-sm-3 control-label">First Name:</label>
                            <div class="col-sm-7">
                                {{ Form::text('first_name', isset($user->first_name) ? $user->first_name : Input::old('first_name'), ['class' => 'form-control', 'placeholder' => 'First Name']) }}
                                <span class="error">{{ $errors->first('first_name') }}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Last Name:</label>
                            <div class="col-sm-7">
                                {{ Form::text('last_name', isset($user->last_name) ? $user->last_name : Input::old('last_name'), ['class' => 'form-control', 'placeholder' => 'Last Name']) }}
                                <span class="error">{{ $errors->first('last_name') }}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Email:</label>
                            <div class="col-sm-7">
                                {{ Form::email('email', isset($user->email) ? $user->email : Input::old('email'), ['class' => 'form-control', 'placeholder' => 'Email']) }}
                                <span class="error">{{ $errors->first('email') }}</span>
                            </div>
                        </div>
                        @if(!isset($user) && !Input::old('id'))
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Password:</label>
                                <div class="col-sm-7">
                                    {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) }}
                                    <span class="error">{{ $errors->first('password') }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Confirm Password:</label>
                                <div class="col-sm-7">
                                    {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm Password']) }}
                                    <span class="error">{{ $errors->first('password_confirmation') }}</span>
                                </div>
                            </div>
                        @endif

                        <div class="form-group">
                            <label class="col-sm-3 control-label">User Group</label>
                            <div class="col-sm-6">
                                <label class="radio-inline">
                                    {{ Form::radio('user_group', 2, (!empty($group->id)) ? $group->id == 2 : (Input::old('user_group', true) == 2), ['class' => 'icheck']) }} User
                                </label>
                                <label class="radio-inline">
                                    {{ Form::radio('user_group', 1, (!empty($group->id)) ? $group->id == 1 : (Input::old('user_group') == 1), ['class' => 'icheck']) }} Admin
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="{{ URL::to('admin/user') }}" class="btn btn-default">Cancel</a>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    @parent
    {{ HTML::script('js/core.datatables.js')}}
    {{ HTML::script('js/local/admin.js')}}
@stop