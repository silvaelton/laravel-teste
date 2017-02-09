<html lang="pt-br"><html>
<head>
    <title>CAP - CIDADÃO</title>
    <meta charset="utf-8" name="viewport" http-equiv="X-UA-Compatible" content="width=device-width, initial-scale=1, IE=edge">
    <link rel="stylesheet" href="/assets/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="/assets/css/bootstrapCosmo.min.css" type="text/css">
</head>
<body>
<div class="navbar navbar-default navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><span>CAP - CIDADÃO</span></a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-ex-collapse"></div>
    </div>
</div>
    @if(session()->has('erro'))
  <div class="alert alert-danger alert-dismissable">
    <strong>{{session()->pull('erro')}}</strong>
    </div>
    @endif
<div class="section">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <form role="form-horizontal" role="form" action="/" method="post">
            {{ csrf_field() }}
            <div class="row">
              <div class="form-group">
                <div class="col-md-1 col-md-offset-3">
                  <label for="cpf" class="control-label">CPF/CNPJ:</label>
                </div>
                <div class="col-md-4">
                  <input type="text" class="form-control cpfMask" id="cpf" placeholder="CPF/CNPJ" name="login">
                </div>
              </div>
            </div>
            <div class="form-group">
              <br/>
              <div class="row">
                <div class="col-md-1 col-md-offset-3">
                  <label for="senha" class="control-label">SENHA:</label>
                </div>
                <div class="col-md-4">
                  <input type="password" class="form-control" id="senha" placeholder="Senha" name="senha">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-8 col-md-offset-4">
                <div class="form-group">
                  <button type="submit" class="btn btn-default">Entrar</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
<!-- Jquery -->
<script type="text/javascript" src="/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="/assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery.maskedinput.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".cpfMask").mask("999.999.999-99",{placeholder:" "});
    });
</script>

</html>