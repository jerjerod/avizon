@extends('template.front.main')

{{-- Web site Title --}}
@section('title')
@parent Carto | {!!Lang::get('acl::auth/login.title')!!} @stop

{{-- Content --}}
@section('content')
    @foreach($errors->all() as $error)
        <p class="alert alert-warning">{{ $error }}</p>
    @endforeach
    <div class="col-md-4 col-md-offset-4">
        {!! Form::open(array('route' => 'postlogin','class'=>'form-signin','role'=>'form')) !!}
            {!! csrf_field() !!}
            
            <h2 class="form-signin-heading">{!! Lang::get('acl::auth/login.connection') !!}</h2>
            <div class="form-group">
                {!! Form::email('email', null, array('class' => 'form-control', 'placeholder' => Lang::get('acl::auth/login.mail'), 'autofocus')) !!}               
            </div>
            <div class="form-group">
                {!! Form::password('password', array('class' => 'form-control', 'placeholder' => Lang::get('acl::auth/login.password')))!!}
            </div>
            <div class="checkbox">
                <label>
                    {!! Form::checkbox('remember-me', '1') !!} {!!Lang::get('acl::auth/login.rememberme')!!}
                </label>
            </div>
            <div class="form-group">
                <a href="/password/reset">{!!Lang::get('acl::auth/login.reset')!!}</a>
            </div>
            {!!Form::submit(Lang::get('acl::auth/login.connection'),array('class' => 'btn btn-lg btn-primary btn-block'))!!}
        {!!Form::close()!!}
    </div> 
@stop



