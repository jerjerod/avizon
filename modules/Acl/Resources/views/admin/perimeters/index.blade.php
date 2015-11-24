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
                <h1 class="page-header">Périmètres</h1>
            </div>
        </div>
        <!-- Notifications -->
			@include('template.back.notifications')
		<!-- ./ notifications -->
        <div class="dataTable_wrapper">
	        <table class="table table-striped table-hover" id="dataTables">
				<thead>
					<tr>
						<th class="sorting_desc">{!!Lang::get('acl::admin/perimeters.table.id')!!}</th>
						<th class="sorting_desc">{!!Lang::get('acl::admin/perimeters.table.com')!!}</th>
						<th class="sorting_desc">{!!Lang::get('acl::admin/perimeters.table.epci')!!}</th>
						<th></th>
						<th></th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					@foreach ($perimeters as $perimeter)
					<tr>
						<td>{{ $perimeter->id }}</td>
						<td>{{$perimeter->nom_com}} ({{$perimeter->com}})</td>
						<td>{{$perimeter->nom_epci}} ({{$perimeter->epci}})</td>
						
						<td>{!! link_to_route('admin.perimeter.show', trans('acl::admin/commons.button.see'), [$perimeter->id], ['class' => 'btn btn-success btn-block btn']) !!}</td>
						<td>{!! link_to_route('admin.perimeter.edit', trans('acl::admin/commons.button.edit'), [$perimeter->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
						<td>
							{!! Form::open(['method' => 'DELETE', 'route' => ['admin.perimeter.destroy', $perimeter->id]]) !!}
							{!! Form::submit(trans('acl::admin/commons.button.destroy'), ['class' => 'btn btn-danger btn-block']) !!}
							{!! Form::close() !!}
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@stop
@section('footer')
@stop