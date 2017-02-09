<!DOCTYPE html>
<html>
<head>
  <title>Processos - {{session('local')}}</title>

  <link rel="stylesheet" href="/assets/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="/assets/css/style.css" type="text/css">
  <link rel="stylesheet" href="/assets/css/jquery.dataTables.min.css" type="text/css">
  <link rel="stylesheet" href="/assets/css/sweetalert2.min.css" type="text/css">
  @yield('chamaLink')

  <style>

    html, body {
      height: 100%;
    }

    body {
      background-color: #fbfbfb !important;
    }

    /* Usado para centralizar texto nos títulos do dataTable */
    thead .sorting { text-align: center !important; }
    thead .sorting_asc { text-align: center !important; }
    thead .sorting_desc { text-align: center !important; }

    /* usado para ocultar opções de páginação do datatable*/
    .dataTables_length { display: none !important;  }

    .container {
      text-align: center;
      display: table-cell;
    }

    .content {
      text-align: left;
      display: inline-block;
    }

    .title {
      font-size: 96px;
    }

    @yield('style')
  </style>
</head>
<body>

  <div class="navbar navbar-default navbar-static-top">
    <div class="container-fluid red">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-capout">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#"><span><img style="margin-top: -5px;" src="/assets/img/brasao_df.svg" width="30px">CAP - CIDADÃO</span></a>
    </div>
      <div class="collapse navbar-collapse" id="navbar-capout">
        <ul class="nav navbar-nav navbar-right">
          <li class="active">
            <a href="{{route('index')}}" id="lProcessos" >Processos</a>
          </li>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                {{session('nome')}} <i class="fa fa-caret-down"></i>
              </a>
            <ul class="dropdown-menu" role="menu">
              <li>
               <a href="#" >{{session('local')}}</a>
              </li>
              <li class="divider"></li>
              <li>
                <a href="{{route('sair')}}">Sair</a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
    @if(session()->has('sucesso'))
        <div class="alert alert-danger alert-dismissable">
            <strong>{{session()->pull('sucesso')}}</strong>
        </div>
    @endif
    @if(session()->has('erro'))
        <div class="alert alert-danger alert-dismissable">
            <strong>{{session()->pull('erro')}}</strong>
        </div>
    @endif
  <div class="section">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="content-fluid">
              <div class="row">
                <div class="col-md-12">
                  <div class="panel panel-info">
                    <div class="panel-body">
                        @if(session()->has('bread'))
                          @for($i=0; $i<count(session('bread')); $i++)
                            @if($i>=1)
                                <i class="fa fa-fw fa-angle-right" aria-hidden="true"></i>
                            @endif
                            @if(session('bread')[$i]=="PROCESSOS" && Route::getCurrentRoute()->getPath()!='listaprocessos')
                              PROCESSO
                            @else
                              {{session('bread')[$i]}}
                            @endif
                          @endfor
                        @endif
                      @yield('cabeca')
                      <hr>
                      @yield('conteudo')
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <a class="btn btn-primary" href="javascript:window.history.go(-1)"><i class="fa fa-fw fa-arrow-left"></i>Voltar</a>
        </div>
      </div>
    </div>
  </div>
  @yield('modal')
</body>
<!-- Jquery -->
<script type="text/javascript" src="/assets/js/jquery.min.js"></script>
<!-- javaScript Datatable -->
<script type="text/javascript" src="/assets/js/jquery.dataTables.min.js"></script>
<!-- Jquery -->
<script type="text/javascript" src="/assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/assets/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="/assets/js/sweetalert2.min.js"></script>
@yield('chamaScript')
<script type="text/javascript">
  $(document).ready(function() {
    $("[data-toggle=tooltip]").tooltip();
    @yield('script')
  });
</script>

</html>
