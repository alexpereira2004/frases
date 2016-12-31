<?php
  session_start();

  include_once 'modulosPHP/class.wTools.php';
  $oUtil   = new wTools();

  include_once 'modulosPHP/load.php';

  $oControle = ControleFactory::inicializar($oUtil->buscarNomePaginaAtual());

  $oView    = $oControle->getVisao();
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="Content-Type: text/html; charset=ISO-8859-1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="comum/bootstrap-3.3.7-dist/css/bootstrap.css" >   
    <link rel="stylesheet" type="text/css" href="comum/frases.css" >   
    <script src="modulosJS/jquery-2.1.3.min.js"></script>

    <link href="modulosJS/bootstrap-datetimepicker-master/css/bootstrap-datetimepicker.css" rel="stylesheet" media="screen" />

    <link rel="stylesheet" href="modulosJS/bootstrap-chosen-master/bootstrap-chosen.css" />
    <script src="http://harvesthq.github.io/chosen/chosen.jquery.js"></script>

  </head>
  <body>
    <header class="navbar navbar-static-top"> 
      <div class="container">
        <div class="navbar-header">
          <a href="<?php echo $oUtil->sUrlBase; ?>" class="navbar-brand">Frases para Pensar</a>
        </div>
        
        
        <nav class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="nova-frase">Adicionar Frases</a></li>
<!--            <li><a href="#">Consultar todas frases</a></li>
            <li><a href="#">Autores já mencionados</a></li>-->
          </ul>
        </nav>
      </div>
    </header>

    <div class="container">
      <?php
        $oView->montarMensagemUsuario();
        $oView->montarCorpoConteudo();
      ?>
    </div>

    <script type="text/javascript" src="modulosJS/bootstrap-datetimepicker-master/js/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="modulosJS/bootstrap-datetimepicker-master/js/locales/bootstrap-datetimepicker.pt-BR.js"></script>

    <script type="text/javascript">
      $(document).ready(function() {
        $('.chosen-select').chosen();
        $('.chosen-select-deselect').chosen({ allow_single_deselect: true });
        $('.form_date').datetimepicker({
          language:  'pt-BR',
          weekStart: 1,
          todayBtn:  1,
          autoclose: 1,
          todayHighlight: 1,
          startView: 2,
          minView: 2,
          forceParse: 0
        });
      });
    </script>
  </body>
</html>