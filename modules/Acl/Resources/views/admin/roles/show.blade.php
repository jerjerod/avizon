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
                <h1 class="page-header">{{$role->name}}</h1>
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
                                    <p class="form-control-static">{{$role->slug}}</p>
                                </div>
                                <div class="col-lg-3">
                                    {!! link_to_route('admin.role.edit','modifier', [$role->id],['class' => 'btn btn-success btn-block btn']) !!}
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