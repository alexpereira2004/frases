<?php
include 'class.view.php';
class View_modelo extends View {
  public function tela() { ?>
    <!DOCTYPE html>
    <html lang="pt-br">
      <head>
        <meta charset="Content-Type: text/html; charset=ISO-8859-1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="comum/bootstrap-3.3.7-dist/css/bootstrap.css" >   
        <script src="modulosJS/jquery-2.1.3.min.js"></script>


    <!--    <link rel="stylesheet" type="text/css" href="modulosJS/selectize/dist/css/normalize.css">
        <link rel="stylesheet" type="text/css" href="modulosJS/selectize/dist/css/stylesheet.css">
        <link rel="stylesheet" type="text/css" href="modulosJS/selectize/dist/css/selectize.default.css">
        <script src="modulosJS/selectize/dist/js/standalone/selectize.js"></script>
        <script src="modulosJS/selectize/dist/js/jqueryui.js"></script>
        <script src="modulosJS/selectize/dist/js/index.js"></script>-->

    <link rel="stylesheet" href="modulosJS/bootstrap-chosen-master/bootstrap-chosen.css" />
    <script src="http://harvesthq.github.io/chosen/chosen.jquery.js"></script>

        <?php 
    //      $oView->metaTags();
    //      $oConfig->incluirCss();
    //      $oConfig->incluirJs();
    //      $oView->incluirJs();
    //      $oView->incluirCss();
        ?>
        <script type="text/javascript">
          $(document).ready(function() {
            $('.chosen-select').chosen();
            $('.chosen-select-deselect').chosen({ allow_single_deselect: true });
          });
        </script>
      </head>
      <body>
        <header class="navbar navbar-static-top"> 
          <div class="container">
            <div class="navbar-header">
              <a href="#" class="navbar-brand">Teste</a>
            </div>
            <nav class="collapse navbar-collapse">
              <ul class="nav navbar-nav">
                <li><a href="#">Motivação</a></li>
                <li><a href="#">Formulário</a></li>
              </ul>
            </nav>
          </div>
        </header>

        <div class="container">
teste
          <?php
            //$oView->montarCorpoConteudo();
          ?>
        </div>
      </body>
    </html>
  <?php
    
  }
}
