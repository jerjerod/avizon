@extends('template.front.main')

@section('title')
@parent {!!Lang::get('acl::auth/password.change.title')!!} @stop

@section('content')
<div class="page-header">
    <h3>{!!Lang::get('acl::auth/password.change.title')!!}</h3>
    <p>{!!Lang::get('acl::auth/password.change.description')!!}</p>
</div>
@foreach($errors->all() as $error)
    <p class="alert alert-warning">{!! $error !!}</p>
@endforeach
{!! Form::open(array('class'=>'form-signin','role'=>'form')) !!}
    {!! csrf_field() !!}
    <!-- old password -->
    <div class="form-group">
        <h4>{!!Lang::get('acl::auth/password.change.new_password')!!}</h4>
        {!! Form::password('password', array('class' => 'form-control', 'placeholder' => Lang::get('acl::auth/password.change.new_password'), 'autofocus')) !!}
    </div>
    <!-- password confirm -->
    <div class="form-group">
        <h4>{!!Lang::get('acl::auth/password.change.password_confirm')!!}</h4>
        {!! Form::password('password_confirm', array('class' => 'form-control', 'placeholder' => Lang::get('acl::auth/password.change.password_confirm'))) !!}
    
    </div>
    {!!Form::submit(Lang::get('commons.button.send'),array('class' => 'btn btn-default'))!!}  
    {!!HTML::link(route('home'),Lang::get('commons.button.cancel'),array("class" => "btn btn-link"))!!}
    
{!!Form::close()!!}
@stop