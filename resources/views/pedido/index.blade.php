@extends('template.layout')
@section('script')

$(document).ready(function() {
	$('#anexos').DataTable( {
		dom: 'Bfrtip',
		buttons: [
		'excelHtml5',
		'csvHtml5',
		{ extend: 'pdfHtml5', title: 'Lista de Pedidos de {{$pedidos->idSsoArea.'.'.$pedidos->numero.'.'.$pedidos->ano}}'},
		],
		"order": [[ 2, "desc" ]],
		"lengthMenu": [[5], [5]],
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Portuguese-Brasil.json"
		}
	} );
});

@stop
@section('cabeca')

<div class="row">
	<div class="col-md-6">
		<ul class="list-group">
			<li class="list-group-item"><b>Processo</b>: {{$pedidos->ssoArea.'.'.$pedidos->numero.'/'.$pedidos->ano}}</li>
			<li class="list-group-item"><b>Data de Autuação</b>: {{$pedidos->dtAutuacao or null}}</li>
			<li class="list-group-item"><b>Data de Cadastro</b>: {{$pedidos->dtCadastro}}</li>
		</ul>
	</div>
	<div class="col-md-6">
		<ul class="list-group">
			<li class="list-group-item"><b>Última Movimentação</b>:@if(!is_null($pedidos->ultimaMovimentacao->dtRecebido)) {{$pedidos->ultimaMovimentacao->dtRecebido}} @else {{$pedidos->ultimaMovimentacao->dtEnvio}} @endif</li>
			<li class="list-group-item"><b>Origem: </b>{{$pedidos->ultimaMovimentacao->areaOrigem->nomeArea}}</li>
			<li class="list-group-item"><b>Destino: </b>{{$pedidos->ultimaMovimentacao->areaDestino->nomeArea}}</li>
		</ul>
	</div>
</div>

@stop
@section('conteudo')
<table id="anexos" class="table table-striped table-bordered" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>Tipo</th>
			<th>Assunto</th>
			<th>Data de Entrada</th>
			<th>Endereço</th>
			<th>Última Situação</th>
			<th>Data Última Situação</th>
			<th>Histórico</th>
		</tr>
	</thead>
	<tbody>
		@foreach($pedidos->DocProcCont->anexos as $pedido)
		@if($pedido->idDocProcContPai!=$pedido->idDocProcCont && $pedido->identificacao->tipoDocProc->idTpDocProc!=1)
		@if(in_array($pedido->idDocProcCont,$interessados))
		<tr>
			<td>
				{{$pedido->identificacao->tipoDocProc->dsTpDocProc}}
			</td>
			<td>
				<span data-toggle="tooltip"  data-placement="bottom" title="{{$pedido->assunto->dsAssunto or null}}">
					{{$pedido->assunto->dsAssunto or null}}
				</span>
			</td>
			<td>
				<span data-toggle="tooltip"  data-placement="bottom" title="@if(isset($pedido->identificacao->dtCadastro))
					{{$pedido->identificacao->dtCadastro}}
					@else
					Não se aplica
					@endif">
					<p>
						@if(isset($pedido->identificacao->dtCadastro))
						{{$pedido->identificacao->dtCadastro}}
						@else
						<p>Não se aplica</p>
						@endif
					</p>
				</span>
			</td>
			<td>
				<span data-toggle="tooltip"  data-placement="bottom" title="{{$pedido->dsEndereco or null}}">
					{{$pedido->dsEndereco or null}}
				</span>
			</td>
			<td>
				<span data-toggle="tooltip"  data-placement="bottom" title="{{$pedido->ultimaSituacao->detalhes->dsSituacao or null}}">
					{{$pedido->ultimaSituacao->detalhes->dsSituacao or null}}
				</span>
			</td>
			<td>
				@if(isset($pedido->ultimaSituacao->dtSituacao))
				<span data-toggle="tooltip"  data-placement="bottom" title="{{$pedido->ultimaSituacao->dtSituacao}}">
					{{$pedido->ultimaSituacao->dtSituacao}}
				</span>
				@endif
				{{--$pedido->idDocProcCont .'---'. $pedido->idDocProcContPai--}}
			</td>
			<td align="center">
				<a href="{{route('historico', ['id' => $pedido->idDocProcCont])}}" data-toggle="tooltip"  data-placement="bottom" title="Histórico situacional do pedido" >
					<i class="fa fa-history fa-2x" aria-hidden="true"></i>
				</a>
			</td>
		</tr>
		@endif
		@endif
		@endforeach
	</tbody>
</table>
@stop
