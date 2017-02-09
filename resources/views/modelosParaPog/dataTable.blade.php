<!DOCTYPE html>
<html>
    <head>
        <title>Processos Escritório X</title>

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/u/bs-3.3.6/jq-2.2.3,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.12,af-2.1.2,b-1.2.0,b-colvis-1.2.0,b-flash-1.2.0,b-html5-1.2.0,b-print-1.2.0,cr-1.3.2/datatables.min.css"/>
         
        <script type="text/javascript" src="https://cdn.datatables.net/u/bs-3.3.6/jq-2.2.3,jszip-2.5.0,pdfmake-0.1.18,dt-1.10.12,af-2.1.2,b-1.2.0,b-colvis-1.2.0,b-flash-1.2.0,b-html5-1.2.0,b-print-1.2.0,cr-1.3.2/datatables.min.js"></script>


        <script type="text/javascript">
            $(document).ready(function() {
                $('#example').DataTable( {
                    "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Portuguese-Brasil.json"
                }
                    } );
                } );
        </script>

        <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css"/>

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
                background-color: #fbfbfb !important;
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Processo</th>
                <th>Assunto</th>                
                <th>Endereço</th>
                <th>Ultima localização</th>
                <th>Situação Atual</th>
            </tr>
        </thead>
        <tbody>
        @foreach($processos as $processo)
            <tr>
                <td>
                @if(isset($processo->DocProcCont->identificacao))
                {{$processo->DocProcCont->identificacao->idSsoArea or null}}
                .{{str_pad($processo->DocProcCont->identificacao->numero, 6, '0', STR_PAD_LEFT)}}
                /{{$processo->DocProcCont->identificacao->ano or null}}
                @endif
                </td>
                <td>{{$processo->DocProcCont->Assunto->dsAssunto or null}}</td>                
                <td>{{$processo->DocProcCont->dsEndereco or null}}</td>
                <td>
                
                    @if(isset($processo->DocProcCont->identificacao->ultimaMovimentacao->movimentacao))
                        {{$processo->DocProcCont->identificacao->ultimaMovimentacao->movimentacao->destino->area()->getNome()}}
                    @else
                        Não se aplica
                    @endif
                </td>
                <td>
                    {{$processo->DocProcCont->ultimaSituacao->detalhes->dsSituacao or null}}                
                </td>
            </tr>
        @endforeach            
        </tbody>        
        <tfoot>
            <tr>
                <th>Processo</th>
                <th>Assunto</th>
                <th>Endereço</th>
                <th>Ultima localização</th>
                <th>Situação Atual</th>
            </tr>
        </tfoot>
    </table>
            </div>
        </div>
    </body>
</html>
