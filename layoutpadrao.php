<?php
  session_start();

  include_once 'modulosPHP/class.wTools.php';
  include_once 'modulosPHP/class.config.php';

  include_once 'modulosPHP/class.excecoes.php';
  
  include_once 'modulosPHP/view/view.geral.php';
  
  $oUtil   = new wTools();
  $oConfig = new config($oUtil->buscarNomePaginaAtual());
  
  $oView = new vgeral();

?>

<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="Content-Type: text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $oConfig->buscarTituloHtml();?></title>
    <?php
      $oConfig->incluirCss();
      $oConfig->incluirJs();	
    ?>

    

    <script type="text/javascript">
      $(document).ready(function() {});

        jssor_slider1_starter = function (containerId) {
          var options = {
              $AutoPlay: true,
              $AutoPlayInterval: 5000,
              $DragOrientation: 3,
              $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$,
                $ChanceToShow: 2,
                $AutoCenter: 0,
                $Steps: 1
              }
          };
          var jssor_slider1 = new $JssorSlider$(containerId, options);
        };
    </script>
  </head>
  <body>
    <div id="pagina">
      <?php
        $oView->cabecalho();
        $oView->montarMenu();
      ?>
      <div id="corpo">
        <div id="conteudo">
          <?php echo $oView->montarVitrine();?>
        </div>
        <div id="nav-01">
          
        </div>
      </div>
      <div class="limpa"></div>
      <?php
        $oView->rodape();
      ?>
    </div>
  </body>
</html>