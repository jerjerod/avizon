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
                <h1 class="page-header">Modules</h1>
            </div>
        </div>
        <!-- Notifications -->
			@include('template.back.notifications')
		<!-- ./ notifications -->
        <div class="dataTable_wrapper">
	        <table class="table table-striped table-hover" id="dataTables">
				<thead>
					<tr>
						<th class="sorting_desc">{!!Lang::get('acl::admin/modules.table.id')!!}</th>
						<th class="sorting_desc">{!!Lang::get('acl::admin/modules.table.slug')!!}</th>
						<th class="sorting_desc">{!!Lang::get('acl::admin/modules.table.name')!!}</th>
						<th>{!!Lang::get('acl::admin/modules.table.users')!!}</th>
						<th></th>
						<th></th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					@foreach ($modules as $module)
					<tr>
						<td>{{ $module->id }}</td>
						<td>{{ $module->slug }}</td>
						<td>{{ $module->name }}</td>
						<td>
							<ul>
								@foreach ($module->authorizations as $authorization)
									@foreach ($authorization->users as $user)
										<li>{!! link_to_route('admin.user.show', $user->username, [$user->id]) !!}</li>
									@endforeach
								@endforeach
							</ul>
						</td>
						<td>{!! link_to_route('admin.module.show', trans('acl::admin/commons.button.see'), [$module->id], ['class' => 'btn btn-success btn-block btn']) !!}</td>
						<td>{!! link_to_route('admin.module.edit', trans('acl::admin/commons.button.edit'), [$module->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
						<td>
							{!! Form::open(['method' => 'DELETE', 'route' => ['admin.module.destroy', $module->id]]) !!}
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