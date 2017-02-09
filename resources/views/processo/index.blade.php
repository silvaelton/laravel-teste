@extends('template.layout')
@section('script')

/*ordenacao de datas no padrão brasileiro*/
jQuery.extend( jQuery.fn.dataTableExt.oSort, {
"date-br-pre": function ( a ) {
if (a == null || a == "") {
return 0;
}
var brDatea = a.split('/');
return (brDatea[2] + brDatea[1] + brDatea[0]) * 1;
},

"date-br-asc": function ( a, b ) {
return ((a < b) ? -1 : ((a > b) ? 1 : 0));
},

"date-br-desc": function ( a, b ) {
return ((a < b) ? 1 : ((a > b) ? -1 : 0));
}
} );


$('#processos').DataTable( {
dom: 'Bfrtip',
buttons: [
{ extend: 'excelHtml5', title: 'PROCESSOS | {{session('local')}}',  exportOptions: {
columns: [ 0, 1, 2, 3, 4 ]
}},
{ extend: 'csvHtml5', title: 'PROCESSOS | {{session('local')}}',  exportOptions: {
columns: [ 0, 1, 2, 3, 4 ]
}},
{ extend: 'pdfHtml5', title: 'PROCESSOS | {{session('local')}}',  exportOptions: {
columns: [ 0, 1, 2, 3, 4 ]
}}
],
columnDefs: [
{ type: 'date-br', targets: 4 },
],
"order": [[ 1, "asc" ]],
"lengthMenu": [[10], [4]],
"language": {
"url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Portuguese-Brasil.json"
}
});

$('.download').on('click', function() {
swal({
title: 'Deseja baixar o anexo e ser notificado?',
text: "Voce estará automaticamente sendo notificado!",
type: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Sim, download!'
}).then(function(isConfirm) {
if (isConfirm) {

window.open('http://www.inmetro.gov.br/metcientifica/curso_metrologia/Docs/manualMonografia.pdf' , 'download', 'status=0');

swal(
'Notificação Gerada!',
'Você foi notificado em 00/00/0000',
'success'
);
}
})
})

@stop
@section('conteudo')

<table id="processos" class="table table-striped table-bordered" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>Nº INTERNO</th>
			<th>PROCESSO</th>
			<th>ASSUNTO</th>
			<th>ENDEREÇO</th>
			<th>ÚLTIMA LOCALIZAÇÃO</th>
			<th>DATA ULTIMA LOCALIZAÇÃO</th>
		</tr>
	</thead>
	<tbody>

		@foreach($processos as $processo)
		<tr>
			<td>
				<div data-toggle="tooltip" data-trigger="hover" data-placement="bottom" title="Clique aqui para mais informações do processo.">
					<a href="{{route('processo', ['id' => $processo->idDocProc])}}">
						{{$processo->numeroInterno or null}}
					</a>
				</div>
			</td>
			<td>
				<div data-toggle="tooltip" data-trigger="hover" data-placement="bottom" title="Clique aqui para mais informações do processo.">
					<a href="{{route('processo', ['id' => $processo->idDocProc])}}">
						{{$processo->ssoArea or null}}.{{$processo->numero or null}}/{{$processo->ano or null}}
					</a>
				</div>
			</td>
			<td>
				{{$processo->DocProcCont->Assunto->dsAssunto or null}}
			</td>
			<td align="left">
				<div data-toggle="tooltip"  data-placement="bottom" id="end-{{$processo->DocProcCont->idDocProcCont}}" title="{{$processo->DocProcCont->dsEndereco or null}}">
					{{$processo->DocProcCont->dsEndereco or null}}
				</div>

			</td>
			<td>
				@if(isset($processo->ultimaMovimentacao->areaOrigem))
					{{$processo->ultimaMovimentacao->areaOrigem->nomeFull}}
				@else
					Não informado
				@endif
			</td>
			<td>
				@if(isset($processo->DocProcCont->ultimaSituacao->movimentacao))
					{{$processo->ultimaMovimentacao->dtEnvio}}
				@else
					Não informado
				@endif
			</td>
		</tr>
		@endforeach
	</tbody>
</table>
@stop
