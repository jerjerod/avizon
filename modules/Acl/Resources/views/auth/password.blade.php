@extends('template.front.main')

@section('title')
@parent {!!Lang::get('acl::auth/password.title')!!} @stop

@section('content')
    <div class="page-header">
        <h3>{!!Lang::get('acl::auth/password.title')!!}</h3>
        <p>{!!Lang::get('acl::auth/password.description')!!}</p>
    </div>
    @foreach($errors->all() as $error)
        <p class="alert alert-warning">{!! $error !!}</p>
    @endforeach
    {!! Form::open(array('route' => 'postemail','class'=>'form-inline','role'=>'form')) !!}
        {!! csrf_field() !!}
        <!-- Email -->
        <div class="form-group">
            {!! Form::email('email', Input::old('email'), array('class' => 'form-control', 'placeholder' => Lang::get('acl::auth/password.email'), 'autofocus')) !!}
        </div>
        {!!HTML::link(route('home'),Lang::get('commons.button.cancel'),array("class" => "btn btn-link"))!!}
        {!!Form::submit(Lang::get('commons.button.send'),array('class' => 'btn btn-default'))!!}        
    {!!Form::close()!!}
@stop