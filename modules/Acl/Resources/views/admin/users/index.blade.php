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
                <h1 class="page-header">Utilisateurs</h1>
            </div>
        </div>
        <!-- Notifications -->
			@include('template.back.notifications')
		<!-- ./ notifications -->
        <div class="dataTable_wrapper">
	        <table class="table table-striped table-hover" id="dataTables">
				<thead>
					<tr>
						<th class="sorting_desc">{!!Lang::get('acl::admin/users.table.id')!!}</th>
						<th class="sorting_desc">{!!Lang::get('acl::admin/users.table.firstname')!!}</th>
						<th class="sorting_desc">{!!Lang::get('acl::admin/users.table.name')!!}</th>
						<th class="sorting_desc">{!!Lang::get('acl::admin/users.table.username')!!}</th>
						<th class="sorting_desc">{!!Lang::get('acl::admin/users.table.email')!!}</th>
						<th>{!!Lang::get('acl::admin/users.table.modules')!!}</th>
						<th></th>
						<th></th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					@foreach ($users as $user)
					<tr>
						<td>{{ $user->id }}</td>
						<td>{{ $user->firstname }}</td>
						<td>{{ $user->name }}</td>
						<td>{{ $user->username }}</td>
						<td>{{ $user->email }}</td>
						<td>
							<ul>
								@foreach ($user->authorizations as $authorization)
									<li> {{$authorization->role->name}} {{$authorization->module->name}} </li>
								@endforeach
							</ul>
						</td>
						<td>{!! link_to_route('admin.user.show', trans('acl::admin/commons.button.see'), [$user->id], ['class' => 'btn btn-success btn-block btn']) !!}</td>
						<td>{!! link_to_route('admin.user.edit', trans('acl::admin/commons.button.edit'), [$user->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
						<td>
							{!! Form::open(['method' => 'DELETE', 'route' => ['admin.user.destroy', $user->id]]) !!}
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