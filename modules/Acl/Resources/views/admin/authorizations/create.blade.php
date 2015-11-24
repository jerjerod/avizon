@extends('template.back.main')
@section('title')
@parent AVIZON @stop

@section('header')
@stop

{{-- Content --}}
@section('wrapper')

	<div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Ajouter une autorisation</h1>
            </div>
        </div>
        <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            @foreach($errors->all() as $error)
                                <p class="alert alert-warning">{{ $error }}</p>
                            @endforeach
                            <div class="row">
                                <form authorization="form" action="/admin/authorization" method="post">
                                    {!! csrf_field() !!}
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Module</label>
                                            {!!Form::select('module', $modules , Input::old('module'),['class' => 'form-control']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Rôle</label>
                                            {!!Form::select('role', $roles , Input::old('role'),['class' => 'form-control']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Commune(s)</label>
                                            {!!Form::select('com[]', $communes , Input::old('com'),['class' => 'form-control','multiple']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>EPCI(s)</label>
                                            {!!Form::select('epci[]', $communes , Input::old('epci'),['class' => 'form-control','multiple']) !!}
                                        </div>
                                        <div class="form-group">
                                            <label>Utilisateur(s)</label>
                                            {!!Form::select('user[]', $users , Input::old('user'),['class' => 'form-control','multiple']) !!}
                                        </div>
                                    </div>
                                    <!-- /.col-lg-6 (nested) -->
                                    <div class="col-lg-6">
                                        <button type="submit" class="btn btn-default">Envoyer</button>
                                        <button type="reset" class="btn btn-default">Annuler</button>
                                    </div>
                                </form>
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
        
	</div>
@stop
@section('footer')
@stop