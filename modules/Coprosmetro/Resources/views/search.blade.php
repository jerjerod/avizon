@extends('template.front.nav')

@section('searchbar')
@if (Auth::check())
<ul class="nav navbar-nav navbar-right">
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Recherche <span class="caret"></span></a>
		<div class="dropdown-menu search">
			<div class="container">
			{!! Form::open(['method'=>'get','route' => 'coprosmetro.search','class' => 'form']) !!}
				<div class="row commune">
					<div class="col-md-12 form-group">
						<label for="com">Commune(s) :</label>
						<select class="form-control multiselect" name="com[]" multiple="multiple" data-placeholder="Choisir les communes...">
							@foreach($perimeters as $perimeter)
								<option value="{{ $perimeter->id }}">{{$perimeter->nom_com}}</option> 
							@endforeach
						</select>
					</div>
				</div>
				<div class="row taille">
					<div class="col-md-12 form-group">
						<div class="form-inline">
						<label for="prix">Nombre de logements compris entre :</label>		
						<div class="input-group col-md-2">
					      <input type="number" class="form-control" name="taille[min]" min="0" placeholder="0">
					    </div>
					    <label for="prix">et</label>		
						<div class="input-group col-md-2">
					      <input type="number" class="form-control" name="taille[max]" min="0" placeholder="max">
					    </div>
					</div>
					</div>
				</div>
				<div class="row date">
					<div class="col-md-12 form-group">
						<div class="form-inline">
							<label for="date">Date de construction comprise entre :</label>
							<div class="input-group col-md-2">
								<input type="number" class="form-control" name="date[min]" min="0" max="{{date("Y")}}" placeholder="< 1900">
							</div>
							<label for="date">et</label>
							<div class="input-group col-md-2">
								<input type="number" class="form-control" name="date[max]" min="0" max="{{date("Y")}}" placeholder="{{date("Y")}}">
							</div>
						</div>
					</div>
				</div>
				<div class="row prix">
					<div class="col-md-12 form-inline">
						<label for="prix">Valeur de marché comprise entre :</label>		
						<div class="input-group col-md-2">
					      <input type="number" class="form-control" name="prix[min]" min="0" placeholder="min">
					      <div class="input-group-addon">€/m²</div>
					    </div>
					    <label for="prix">et</label>		
						<div class="input-group col-md-2">
					      <input type="number" class="form-control" name="prix[max]" min="0" placeholder="max">
					      <div class="input-group-addon">€/m²</div>
					    </div>
					</div>
				</div>
				<div class="divider"></div>
				<div class="row">
					<div class="col-md-4 form-group interventions">
						<h5><b>Interventions :</b></h5>
						<div class="checkbox"><label><input type="checkbox" name="atlas93"> Atlas 1993</label></div>
						<div class="checkbox"><label><input type="checkbox" name="atlas99"> Atlas 1999</label></div>
						<div class="checkbox"><label><input type="checkbox" name="opatb"> OPATB</label></div>
						<div class="checkbox"><label><input type="checkbox" name="opah"> OPAH Centre Ancien</label></div>
						<div class="checkbox"><label><input type="checkbox" name="etucad"> Etude de cadrage</label></div>
						<div class="checkbox"><label><input type="checkbox" name="etupreop"> Etude pré-opérationnelle</label></div>					
						<div class="checkbox"><label><input type="checkbox" name="suivi"> Suivi / Animation</label></div>								
						<div class="checkbox"><label><input type="checkbox" name="murmur"> Campagne Mur/mur</label></div>
					    
					</div>
					<div class="col-md-4 form-group fragilite">
						<h5><b>Causes de fragilité :</b></h5>							
						<div class="checkbox"><label><input type="checkbox" name="c1_frag"> Vacance</label></div>
						<div class="checkbox"><label><input type="checkbox" name="c2_frag"> Vacance de longue durée</label></div>
						<div class="checkbox"><label><input type="checkbox" name="c3_frag"> Classement cadastral 7-8</label></div>
						<div class="checkbox"><label><input type="checkbox" name="c4_frag"> Prix anormalement bas</label></div>
						<div class="checkbox"><label><input type="checkbox" name="c5_frag"> Bas revenus dans la zone</label></div>
						<div class="checkbox"><label><input type="checkbox" name="c6_frag"> Exonération TH</label></div>
						<div class="checkbox"><label><input type="checkbox" name="c7_frag"> Dominante locative</label></div>
					</div>
					<div class="col-md-4 form-group signal">
						<h5><b>Signalement de fragilités :</b></h5>
					    <div class="checkbox"><label><input type="checkbox" name="signal1"> Etat du bâti</label></div>
					    <div class="checkbox"><label><input type="checkbox" name="signal2"> Fragilité des occupants</label></div>
					    <div class="checkbox"><label><input type="checkbox" name="signal3"> Marchands de sommeil</label></div>
					    <div class="checkbox"><label><input type="checkbox" name="signal4"> Précarité énergétique</label></div>
					</div>
				</div>
				<div class="divider"></div>	
				<input type="submit" class="btn btn-default" name="submit"  value="Valider" />
			{!! Form::close() !!}
			</div>
		</div>
	</li>
</ul>
@endif
@stop