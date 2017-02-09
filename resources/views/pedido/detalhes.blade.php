@extends('template.layout')
@section('conteudo')
	<table id="detalhesPedidos" class="table table-striped table-bordered" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>Orgão</th>
				<th>Descrição</th>
				<th>Data</th>
				<th>Anexo(s)</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($situacoes as $sit)
				<tr>
					<td>
						@if (isset($sit->area))
							{{$sit->area->area->nomeArea or 'Setor não informado'}}
						@else
								Setor não informado
						@endif
					</td>
					<td>
						{{$sit->detalhes->dsSituacao or null}}
					</td>
					<td>
						{{$sit->dtSituacao}}
					</td>
					<td>
						@foreach ($sit->anexos as $anexo)
							<a href="{{route('anexoDown',['id'=>$anexo->idDocProc,'anexo'=>$anexo->pivot->id])}}" id="{{$anexo->idDocProcCont}}" myDataAnexo="{{route('anexoCheck',[$anexo->pivot->id])}}" myDataCont="{{$anexo->idDocProcCont}}" class="confirmaNotificacao" >{{$anexo->identificacao->tipoDocProc->dsTpDocProc}} - </a><br/>
						@endforeach
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
@stop
<script type="text/javascript">
@section('script')
/*
Config dataTable
*/
$('#detalhesPedidos').DataTable({
        "columnDefs": [
            { "visible": false, "targets": 0 }
        ],
        "order": [[ 2, 'asc' ]],
        "displayLength": 25,
        "drawCallback": function ( settings ) {
            var api = this.api();
            var rows = api.rows( {page:'current'} ).nodes();
            var last=null;

            api.column(0, {page:'current'} ).data().each( function ( group, i ) {
                if ( last !== group ) {
                    $(rows).eq( i ).before(
                        '<tr class="group"><td colspan="4">'+group+'</td></tr>'
                    );

                    last = group;
                }
            } );
        }
    } );
$('#detalhesPedidos tbody').on( 'click', 'tr.group', function () {
        var currentOrder = table.order()[0];
        if ( currentOrder[0] === 2 && currentOrder[1] === 'asc' ) {
            table.order( [ 2, 'desc' ] ).draw();
        }
        else {
            table.order( [ 2, 'desc' ] ).draw();
        }
    } );
/*
fim Config dataTable
*/
/*
modal para confirmar Download
*/
$('.confirmaNotificacao').click(function(evt){
	evt.preventDefault();
	url=$(this).attr('href');
	urlanexo=$(this).attr('myDataAnexo');
	$.ajax({
		method: "get",
		url: urlanexo,
	}).done(function( data, textStatus, jqXHR) {
		if(jqXHR.status==204)
		{
			swal({
				title: 'Confirmação necessária',
				text: "Para visualizar a exigencia é preciso confirmar a notificação!",
				type: 'warning',
				showLoaderOnConfirm:true,
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Confirmar notificação',
				cancelButtonText: 'Cancelar'
			}).then(function () {
				baixaPdf()
			});
		}else if (jqXHR.status==200)
		{
			baixaPdf();
		}else {
			swal({
				title: 'Erro ao conectar com o servidor',
				text: "Favor tentar novamente",
				type: 'error'
			})
		}
	}).fail(function() {
		swal({
			title: 'Falha ao conectar com o servidor',
			text: "Favor tentar novamente mais tarde",
			type: 'error'
		})
	});
});


function baixaPdf(){
	$.ajax({
		method: "get",
		url: url,
	}).done(function( data, textStatus, jqXHR) {
		if(jqXHR.status==200)
		{
			location.replace(url);
			swal({
				title: 'Notificação confirmada!',
				html: "Download iniciara em breve!<br/>(clique <a href=\""+url+"\">aqui</a> se não iniciar em alguns segundos)",
				type: 'success'
			})
		}
		else
		{
			swal({
				title: 'Falha ao baixar anexo',
				text: "Favor tentar novamente",
				type: 'error'
			})
		}
	}).fail(function() {
		swal({
			title: 'Erro ao baixar anexo',
			text: "Favor tentar novamente",
			type: 'error'
		})
	});
}
@endsection
</script>
<style media="screen">
@section('style')
tr.group,
tr.group:hover {
	background-color: #ddd !important;
}
@endsection
</style>
