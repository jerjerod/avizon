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
                <h1 class="page-header">{{$module->name}}</h1>
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
                                    <label>Slug</label>
                                    <p class="form-control-static">{{$module->slug}}</p>
                                </div>
                                <div class="col-lg-3">
                                    {!! link_to_route('admin.module.edit','modifier', [$module->id],['class' => 'btn btn-success btn-block btn']) !!}
                                </div>
                            </div>
                            <!-- /.col-lg-6 (nested) -->
                            <div class="col-lg-6">
                                <label>Utilisateur(s) associé(s)</label>
                                <div class="dataTable_wrapper">
                                    <table class="table table-striped table-hover" >
                                        <thead>
                                            <tr>
                                                <th class="sorting_desc">Utilisateur(s)</th>
                                                <th class="sorting_desc">Rôle</th>
                                                <th class="sorting_desc">Périmètre</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($module->authorizations as $authorization)
                                            <tr>
                                                <td>
                                                    <ul>
                                                        @foreach ($authorization->users as $user)
                                                            <li>{!! link_to_route('admin.user.show',$user->username, [$user->id]) !!}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td>{!! link_to_route('admin.role.show',$authorization->role->name, [$authorization->role_id]) !!}</td>
                                                <td>
                                                    <ul>
                                                        @foreach ($authorization->perimeters as $perimeter)
                                                            <li>{!! link_to_route('admin.perimeter.show',$perimeter->nom_com, [$perimeter->id]) !!}</li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
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
    </div>
@stop
@section('footer')
@stop