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
                <h1 class="page-header">Rôles</h1>
            </div>
        </div>
        <!-- Notifications -->
			@include('template.back.notifications')
		<!-- ./ notifications -->
        <div class="dataTable_wrapper">
	        <table class="table table-striped table-hover" id="dataTables">
				<thead>
					<tr>
						<th class="sorting_desc">{!!Lang::get('acl::admin/roles.table.id')!!}</th>
						<th class="sorting_desc">{!!Lang::get('acl::admin/roles.table.slug')!!}</th>
						<th class="sorting_desc">{!!Lang::get('acl::admin/roles.table.name')!!}</th>
						<th></th>
						<th></th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					@foreach ($roles as $role)
					<tr>
						<td>{{ $role->id }}</td>
						<td>{{ $role->slug }}</td>
						<td>{{ $role->name }}</td>
						
						<td>{!! link_to_route('admin.role.show', trans('acl::admin/commons.button.see'), [$role->id], ['class' => 'btn btn-success btn-block btn']) !!}</td>
						<td>{!! link_to_route('admin.role.edit', trans('acl::admin/commons.button.edit'), [$role->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
						<td>
							{!! Form::open(['method' => 'DELETE', 'route' => ['admin.role.destroy', $role->id]]) !!}
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