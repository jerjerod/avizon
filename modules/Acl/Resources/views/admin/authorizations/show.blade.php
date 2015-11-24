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
                <h1 class="page-header">Autorisation {{$authorization->id}}</h1>
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
                                {!! csrf_field() !!}
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Module</label>
                                        <p class="form-control-static">{{$authorization->module->name}}</p>

                                        <label>Rôle</label>
                                        <p class="form-control-static">{{$authorization->role->name}}</p>

                                        <label>Périmètre(s)</label>
                                        <ul>
                                            @foreach ($authorization->perimeters as $perimeter)
                                                <li>{{$perimeter->nom_com}}</li>
                                            @endforeach
                                        </ul>
                                        <label>Utilisateur(s)</label>
                                        <ul>
                                            @foreach ($authorization->users as $user)
                                                <li>{{$user->username}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="col-lg-3">
                                        {!! link_to_route('admin.authorization.edit','modifier', [$authorization->id],['class' => 'btn btn-success btn-block btn']) !!}
                                    </div>
                                </div>
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