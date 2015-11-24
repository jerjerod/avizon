@extends('template.front.main')
@include('coprosmetro::search')

@section('title')
@parent {{ $post->slug }} @stop
@section('header')
		{!!HTML::style('/assets/css/d3.css')!!}
		{!! HTML::style('/assets/css/map.css', array('media' => 'all')) !!}
		
@stop

@section('content')
	<?php $content = json_decode($post->content); ?>
	<div class="header single container">
		<div class="col-sm-12 jumbotron">
			@if (isset($post->title))
					<h2>{{ $post->title }}</h2>
				@endif
			<div class="col-sm-6">
				@if (isset($other['meta']['adresse']))
					<div class="meta adresse">
						<h4><i class="fa fa-envelope fa-lg"></i> Adresse(s) :</h3>
				    	<ul>
							@foreach($other['meta']['adresse'] as $adresse)
								<li>{{$adresse}}</li>
							@endforeach
						</ul>
					</div>
				@endif
				<div class="meta commune">
					<h4><i class="fa fa-institution fa-fw fa-lg"></i> Commune : <span class="label label-info">{{$other['terms']['commune']}}</span></h4>
				</div>
				@if (isset($content->nomiris2010))
					<div class="meta iris">
						<h4><i class="fa fa-institution fa-fw fa-lg"></i> IRIS : <span class="label label-info">{{$content->nomiris2010}}</span></h4>
					</div>
				@endif
				<div class="meta id-cadastre">
					<h4><i class="fa fa-tag fa-fw fa-lg"></i> Identifiant cadastral : <span class="label label-info">{{ $post->slug }}</span></h4>
				</div>
				@if (isset($content->nom_zonage_pq_ville))
					<div class="meta quartier">
						<h4><i class="fa fa-stethoscope fa-fw fa-lg"></i> Quartier prioritaire : <span class="label label-info">{{$content->nom_zonage_pq_ville}}</span></h4>
					</div>
				@endif
				
			</div>
			<div class="col-sm-6">
				@if (isset($other['meta']['nb_log']))
					<div class="meta logements">
						<h4><i class="fa fa-building fa-lg fa-fw"></i> Logement(s) : <span class="label label-info">{{$other['meta']['nb_log']}}</span></h4>
						{{($content->nb_log_hlmsem != 0) ? ' (dont '.$content->nb_log_hlmsem.' HLM/SEM)' : ''}}
					</div>
				@endif
				@if (isset($other['meta']['date_construction'])&& $other['meta']['date_construction'] != 0)
					<div class="meta construction">
						<h4><i class="fa fa-wrench fa-lg fa-fw"></i> Année de construction : <span class="label label-info">{{$other['meta']['date_construction']}} </span></h4>
						{{($other['meta']['date_construction'] != $content->jannatmax) ? ' (dernière construction en '.$content->jannatmax.')' : ''}}
					</div>
				@endif
				@if (isset($content->nb_niveaux))
					<div class="meta niveaux">
						<h4><i class="fa fa-reorder fa-lg fa-fw"></i> Nombre de niveaux : <span class="label label-info">{{$content->nb_niveaux}} </span></h4>
					</div>
				@endif
				@if (isset($other['meta']['prix_marche']))
					<div class="meta prix">
						<h4><i class="fa fa-money fa-lg fa-fw"></i> Prix médian au m² : <span class="label label-info">{{$other['meta']['prix_marche']}} €</span></h4>
					</div>
				@endif
			</div>
		</div>
	</div>
	<div class="content single container">
		<div class="container">
			<ul class="nav nav-tabs" role="tablist">
				<li class="active"><a href="#situation" role="tab" data-toggle="tab">Situation</a></li>
				<li ><a class="marche" href="#marche" role="tab" data-toggle="tab">Marché</a></li>
				<li><a class="composition" href="#composition" role="tab" data-toggle="tab">Composition</a></li>
				<li><a class="occupation" href="#occupation" role="tab" data-toggle="tab">Occupation</a></li>
				<li><a href="#intervention" role="tab" data-toggle="tab">Interventions</a></li>
				<li><a href="#fragilite" role="tab" data-toggle="tab">Fragilité</a></li>
			</ul>
		</div>
		<div class="tab-content">
			<div class="tab-pane active" id="situation">
				<div class="row">
					<div class="col-sm-6">
						<div id="singlemap"></div>
					</div>
					<div class="col-sm-6">
						<div id="pano"></div>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="marche">
				<div class="row">
					<div class="col-sm-8">
						@if(isset($content->prix_med_iris) && isset($other['meta']['prix_marche']))
							<h3>Ecarts de prix</h3>
							<div class="meta section">
								@if(round(($other['meta']['prix_marche'] - $content->prix_med_iris)*100/$content->prix_med_iris,1) < 0)
									<span class="value text-danger"><i class="fa fa-level-down fa-lg"> </i> 
								@else
									<span class="value text-success"><i class="fa fa-level-up fa-lg"> </i>
								@endif
								{{round(($other['meta']['prix_marche'] - $content->prix_med_iris)*100/$content->prix_med_iris,1)}}%</span>
								par rapport au prix médian/m² de l'iris ({{$content->prix_med_iris}} €/m²)
							</div>
						@else 
							<h3>Ecarts de prix non calculable</h3>
						@endif
						@if(isset($content->prix_med_depcom) && isset($other['meta']['prix_marche']))
							<div class="meta commune">
								@if(round(($other['meta']['prix_marche'] - $content->prix_med_depcom)*100/$content->prix_med_depcom,1) < 0)
									<span class="value text-danger"><i class="fa fa-level-down fa-lg"></i> 
								@else
									<span class="value text-success"><i class="fa fa-level-up fa-lg"></i>
								@endif
								{{round(($other['meta']['prix_marche'] - $content->prix_med_depcom)*100/$content->prix_med_depcom,1)}}%</span>
								par rapport au prix médian/m² de sa commune ({{$content->prix_med_depcom}} €/m²)
							</div>
						@endif									
					</div>
					@if(isset($content->del_moy_mut))
						<div class="col-sm-4">
							<h3>Délais moyen entre deux mutations</h3>
							<span class="value"><i class="fa fa-calendar fa-2x"></i> {{round($content->del_moy_mut,1)}}</span> année(s)
						</div>
					@endif
				</div>
				@if (isset($other['meta']['transactions']))
					<div class="row">
						<div class="col-sm-12">
							<h3>Transactions</h3>
							<table class="table table-striped">
								<thead>
									<tr>
										<th>date</th>
										<th>nature</th>
										<th>appartements</th>
										<th>maisons</th>
										<th>locaux industriels et commerciaux</th>
										<th>dépendances</th>
										<th>surface locaux</th>
										<th>surface terrain (suf)</th>
										<th>valeur foncière</th>
										<th>prix/m²</th>
									</tr>

								</thead>
								<tbody>
								@foreach($other['meta']['transactions'] as $key => $value)
									<tr>
										<td>{{$value->date_mutation}}</td>
										<td>{{$value->lib_nature_mutation}}</td>
										<td>{{$value->nb_appartements}}</td>
										<td>{{$value->nb_maisons}}</td>
										<td>{{$value->nb_lic}}</td>
										<td>{{$value->nb_dep}}</td>
										<td>{{$value->srf_locaux}}m²</td>
										<td>{{$value->srf_suf}}</td>
										<td>{{$value->valeur_fonciere_totale}}€</td>
										<td>{{$value->prix_m2}}€</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						</div>
					</div>
				@endif
				<div class="well">D’après DGI – Demande de Valeurs Foncières (DVF) 2006 à premier semestre 2014</div>

			</div>
			<div class="tab-pane" id="composition">
				<div class="row">
					<div class="col-sm-6">
						<h3>Composition des locaux</h3>
						<div id="compo_locaux"><svg></svg></div>
					</div>
					<div class="col-sm-6">
						<h3>Pièces annexes</h3>
						<div id="annexes"><svg></svg></div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<h3>Typologie des logements</h3>
						<div id="typo_appart"><svg></svg></div>
					</div>
					<div class="col-sm-6">
						<h3>Caractéristiques de la propriété des locaux</h3>
						@if (isset($content->nb_droit_prop_logt) && isset($content->nb_droit_prop))
							<div class="droit-propriete">
								<span class="value">{{$content->nb_droit_prop_logt}}</span> droit(s) de propriété de logements sur <span class="value">{{$content->nb_droit_prop}}</span> droit(s) de propriété.
							</div>
						@endif
						@if (isset($content->nb_log_hlmsem))
							<div class="propriete-hlm">
								<span class="value">{{$content->nb_log_hlmsem}}</span> logement(s) propriété HLM / SEM.
							</div>
						@endif
						@if (isset($content->nb_proprio_logt) && isset($content->nb_proprios))
							<div class="proprietaires">
								<span class="value">{{$content->nb_proprio_logt}}</span> propriétaire(s) de logements sur <span class="value">{{$content->nb_proprios}}</span> propriétaire(s).
							</div>
						@endif
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<h3>Etat général des logements</h3>
						@if (isset($content->nb_log_cc78))
							<div class="cc78">
								<span class="value">{{$content->nb_log_cc78}}</span> logement(s) dont le classement cadastral est 7-8 ({{ (1 -(($other['meta']['nb_log'] - $content->nb_log_cc78) / $other['meta']['nb_log'])) * 100}}%).
							</div>
						@endif
						@if (isset($content->nb_log_ce45))
							<div class="ce45">
								<span class="value">{{$content->nb_log_ce45}}</span> logement(s) dont le coefficient d"entretien est 4-5 ({{ (1 -(($other['meta']['nb_log'] - $content->nb_log_ce45) / $other['meta']['nb_log'])) * 100}}%).
							</div>
						@endif
					</div>
				</div>
				<div class="well">D’après DGI – Fichiers Fonciers MAJIC III, millésime 2013</div>
			</div>
		
			<div class="tab-pane" id="occupation">
				<div class="row">
					<div class="col-sm-6">
						<h3>Statut d'occupation</h3>
						<div id="statut_occup"><svg></svg></div>					
					</div>
					<div class="col-sm-6">
						@if (isset($content->nb_lochab_vac2a) || isset($content->nb_locact_vac2a))
						<h3>Vacance de longue durée</h3>
						@endif
						@if (isset($content->nb_lochab_vac2a))
							<div class="vacance-sup2a">
								<span class="value">{{$content->nb_lochab_vac2a}}</span> logement(s) vacants depuis plus de 2 ans ({{ round((1 -(($other['meta']['nb_log'] - $content->nb_lochab_vac2a) / $other['meta']['nb_log'])) * 100,1)}}%).
							</div>
						@endif
						<h3>Fragilité des occupants</h3>
						@if (isset($content->tx_menbasrev_inseerflm10car))
							<div class="exo_ecf">
								<span class="value">{{round($content->tx_menbasrev_inseerflm10car *100,0)}}%</span> de ménages à bas revenus en 2011 (carreau INSEE de 200m concerné par cette copropriété).
							</div>
						@endif
						@if (isset($content->tx_exo_th_14))
							<div class="exo_th">
								<span class="value">{{round($content->tx_exo_th_14 *100,0)}}%</span> de logements exonérés de la taxe d'habitation en 2014.
							</div>
						@else
							<div class="exo_th">
								La taille de cette copropriété ne permet pas d’afficher le taux de logements exonérés de la taxe d'habitation. 
							</div>
						@endif						
					</div>
				</div>
				<div class="well">D’après DGI – Fichiers Fonciers MAJIC III, millésime 2013</div>
			</div>
			<div class="tab-pane" id="intervention">
				<div class="row">
					<div class="col-sm-12">
						@if (!isset($other['meta']['atlas93']) && !isset($other['meta']['atlas99']) && !isset($other['meta']['opatb']) && !isset($other['meta']['opah']) && !isset($content->etude_energie) && !isset($content->veille_villeneuve) && !isset($other['meta']['etucad']) && !isset($other['meta']['etupreop']) && !isset($other['meta']['suivi']) && !isset($other['meta']['murmur']))
						<h3>Pas d'interventions sur cette copropriété</h3>
						@else
							@if (isset($other['meta']['atlas93']))
							<h3>Atlas 1993</h3>
							<p>- {{$other['meta']['atlas93']}}</p>
							@endif
							@if (isset($other['meta']['atlas99']))
							<h3>Atlas 1999</h3>
							<p>- {{$other['meta']['atlas99']}}</p>
							@endif
							@if (isset($other['meta']['opatb']))
							<h3>OPATB</h3>
							<p>- Oui</p>
							@endif
							@if (isset($other['meta']['opah']))
							<h3>OPAH Centre Ancien</h3>
							<p>- Oui</p>
							@endif
							@if (isset($content->etude_energie))
							<h3>Etude énergie</h3>
							<p>- Oui</p>
							@endif
							@if (isset($content->veille_villeneuve))
							<h3>Veille sur la Villeneuve</h3>
							<p>- Oui</p>
							@endif
							@if (isset($other['meta']['etucad']))
							<h3>Etude de cadrage</h3>
							<p>- Début : {{$other['meta']['etucad']->f1}}</p>
							<p>- Fin : {{$other['meta']['etucad']->f2}}</p>
							@endif
							@if (isset($other['meta']['etupreop']))
							<h3>Etude pré-opérationnelle</h3>
							<p>- Début : {{$other['meta']['etupreop']->f1}}</p>
							<p>- Fin : {{$other['meta']['etupreop']->f2}}</p>
							@endif
							@if (isset($other['meta']['suivi']))
							<h3>Suivi / Animation</h3>
							<p>- Début : {{$other['meta']['suivi']->f1}}</p>
							<p>- Fin : {{$other['meta']['suivi']->f2}}</p>
							@endif
							@if (isset($other['meta']['murmur']))
								<h3>Interventions MUR/MUR</h3>
								<table class="table table-striped">
									<thead>
										<tr>
											<th>Nom</th>
											<th>Adresse</th>
											<th>N° de dossier</th>
											<th>Syndic</th>
											<th>Logement(s)</th>
											<th>Etat d'avancement</th>
											<th>Bouquet de travaux retenus</th>
										</tr>

									</thead>
									<tbody>
									@foreach($other['meta']['murmur'] as $key => $value)
										<tr>
											<td>{{$value->nom_copro}}</td>
											<td>{{$value->adresse}}</td>
											<td>{{$value->num_dossier}}</td>
											<td>{{$value->syndic}}</td>
											<td>{{$value->nb_logt}}</td>
											<td>{{$value->l_eta_avct}}</td>
											<td>{{$value->l_bouquet_trvx_retenus}}</td>
										</tr>
									@endforeach
									</tbody>
								</table>							
							@endif
						@endif
					</div>
				</div>
				<div class="well">D’après Grenoble Alpes Métropole – Suivi des opérations Mur/Mur au 30/09/2014</div>
			</div>
			<div class="tab-pane" id="fragilite">
				<div class="row">
					<div class="col-sm-12">
						@if (isset($other['meta']['c1_frag'])||isset($other['meta']['c2_frag'])||isset($other['meta']['c3_frag'])||isset($other['meta']['c4_frag'])||isset($other['meta']['c5_frag'])||isset($other['meta']['c6_frag']))
							<h3>Fragilité</h3>
							<ul>
								@if (isset($other['meta']['c1_frag']))
									<li>Vacance anormalement élevé</li>
								@endif
								@if (isset($other['meta']['c2_frag']))
									<li>Vacance de longue durée anormalement élevé</li>
								@endif
								@if (isset($other['meta']['c3_frag']))
									<li>Nombre significatif de logements en classement cadastral 7-8</li>
								@endif
								@if (isset($other['meta']['c4_frag']))
									<li>Valeurs moyennes de marché anormalement basses</li>
								@endif
								@if (isset($other['meta']['c5_frag']))
									<li>Localisation dans une zone avec 30% de ménages à bas revenus</li>
								@endif
								@if (isset($other['meta']['c6_frag']))
									<li>Exonération de la taxe d'habitation</li>
								@endif
							</ul>
						@else
							<h3>Pas de fragilités repérées sur cette copropriété</h3>
						@endif
							
					</div>
				</div>
				<div class="well">d'après l'Agence d'urbanisme de l'agglomération Grenobloise</div>
			</div>
		</div>
	</div>
@stop
@section('footer')
		
        {!! HTML::script('/assets/js/mapbox.js') !!}
        {!! HTML::script('http://maps.google.com/maps/api/js?v=3') !!}
        {!! HTML::script('/assets/js/singlemap.js') !!}
        
        {!! HTML::script('/assets/js/d3.js')!!}
        <script type="text/javascript">
        	var compo_locaux = <?php echo $other['data']['compo_locaux']; ?>;
        	var annexes = <?php echo $other['data']['annexes']; ?>;
		  	var typo_appart = <?php echo $other['data']['typo_appart']; ?>;
		  	var statut_occup = <?php echo $other['data']['statut_occup']; ?>;
		  	$(".composition").click(function() {
		  		nv.addGraph(function() {
				    var chart = nv.models.multiBarHorizontalChart()
				        .x(function(d) { return d.label })
				        .y(function(d) { return d.value })
				        .margin({left: 250})
				        .showValues(true)         //Show bar value next to each bar.
				        .showControls(false); 
				    chart.yAxis
        				.tickFormat(d3.format(',f'));       //Allow user to switch between "Grouped" and "Stacked" mode.
				    d3.select('#compo_locaux svg')
				        .datum(compo_locaux)
				        .transition().duration(350)
				        .call(chart);
				    d3.selectAll(".nv-bar rect")
				    .style("fill", "#1f77b4");

				    return chart;
				  });
		  		nv.addGraph(function() {
				    var chart = nv.models.multiBarHorizontalChart()
				        .x(function(d) { return d.label })
				        .y(function(d) { return d.value })
				        .margin({left: 100})
				        .showValues(true)         //Show bar value next to each bar.
				        .showControls(false); 
				    chart.yAxis
        				.tickFormat(d3.format(',f'));       //Allow user to switch between "Grouped" and "Stacked" mode.
				    d3.select('#annexes svg')
				        .datum(annexes)
				        .transition().duration(350)
				        .call(chart);
				    d3.selectAll(".nv-bar rect")
				    .style("fill", "#1f77b4");

				    return chart;
				  });
			  	
				nv.addGraph(function() {
				  	var chart = nv.models.pieChart()
				    	.x(function(d) { return d.label })
				    	.y(function(d) { return d.value })
				      	.showLabels(true)     //Display pie labels
				      	.labelThreshold(.05)  //Configure the minimum slice size for labels to show up
				      	.labelType("percent") //Configure what type of data to show in the label. Can be "key", "value" or "percent"
				      	.donut(true)          //Turn on Donut mode. Makes pie chart look tasty!
				      	.donutRatio(0.25);    //Configure how big you want the donut hole size to be.
				  	d3.select("#typo_appart svg")
				        .datum(typo_appart)
				        .transition().duration(350)
				        .call(chart);
				  	return chart;
				});							
			});
			$(".occupation").click(function() {
				nv.addGraph(function() {
				  	var chart = nv.models.pieChart()
				    	.x(function(d) { return d.label })
				    	.y(function(d) { return d.value })
				    	.margin({left: 0})
				      	.showLabels(true)     //Display pie labels
				      	.labelThreshold(.05)  //Configure the minimum slice size for labels to show up
				      	.labelType("percent") //Configure what type of data to show in the label. Can be "key", "value" or "percent"
				      	.donut(true)          //Turn on Donut mode. Makes pie chart look tasty!
				      	.donutRatio(0.25);    //Configure how big you want the donut hole size to be.
				  	d3.select("#statut_occup svg")
				        .datum(statut_occup)
				        .transition().duration(350)
				        .call(chart);
				  	return chart;
				});
			});
		</script>
@stop