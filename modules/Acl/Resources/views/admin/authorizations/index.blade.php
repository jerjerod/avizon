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
                <h1 class="page-header">Autorisations</h1>
            </div>
        </div>
        <!-- Notifications -->
			@include('template.back.notifications')
		<!-- ./ notifications -->
        <div class="dataTable_wrapper">
	        <table class="table table-striped table-hover" id="dataTables">
				<thead>
					<tr>
						<th class="sorting_desc">{!!Lang::get('acl::admin/authorizations.table.id')!!}</th>
						<th class="sorting_desc">{!!Lang::get('acl::admin/authorizations.table.module')!!}</th>
						<th class="sorting_desc">{!!Lang::get('acl::admin/authorizations.table.role')!!}</th>
						<th class="sorting_desc">{!!Lang::get('acl::admin/authorizations.table.perimeters')!!}</th>
						<th class="sorting_desc">{!!Lang::get('acl::admin/authorizations.table.users')!!}</th>
						<th></th>
						<th></th>
						<th></th>
						
					</tr>
				</thead>
				<tbody>
					@foreach ($authorizations as $authorization)
					<tr>
						<td>{{$authorization->id }}</td>
						<td>{{$authorization->module->name}}</td>
						<td>{{$authorization->role->name}}</td>
						<td>
							<ul>
							<?php $i = 1; ?>
                            @foreach ($authorization->perimeters as $perimeter)
                                <li>{{$perimeter->nom_com}}</li>
                                @if($i == 5)
                                	<li>...</li>
                                	 <?php break; ?>
                                @endif
                                <?php $i++; ?>
                            @endforeach
                            </ul>
                        </td>
						<td>
							<ul>
							<?php $i = 1; ?>
							@foreach ($authorization->users as $user)
								<li>{{$user->username}}</li>
								@if($i == 5)
                                	<li>...</li>
                                	 <?php break; ?>
                                @endif
                                <?php $i++; ?>
							@endforeach
							</ul>
						</td>
						
						
						<td>{!! link_to_route('admin.authorization.show', trans('acl::admin/commons.button.see'), [$authorization->id], ['class' => 'btn btn-success btn-block btn']) !!}</td>
						<td>{!! link_to_route('admin.authorization.edit', trans('acl::admin/commons.button.edit'), [$authorization->id], ['class' => 'btn btn-warning btn-block']) !!}</td>
						<td>
							{!! Form::open(['method' => 'DELETE', 'route' => ['admin.authorization.destroy', $authorization->id]]) !!}
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