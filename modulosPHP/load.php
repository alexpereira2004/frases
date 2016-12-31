<?php
  include_once 'modulosPHP/class.wTools.php';
  include_once 'modulosPHP/class.config.php';
//  include_once 'modulosPHP/view/view.geral.php';
    include_once 'modulosPHP/controle/ControleFactory.php';


$sPgAtual = $oUtil->buscarNomePaginaAtual();

  function __autoload($sPgAtual) {
    $sPgAtual = str_replace('view_', '', $sPgAtual);
    $sPgAtual = str_replace('model_', '', $sPgAtual);
    $sPgAtual = str_replace('business_', '', $sPgAtual);
    $sPgAtual = str_replace('control_', '', $sPgAtual);

    if ((file_exists('modulosPHP/visao/view.'.$sPgAtual.'.php'))) {
      require_once 'modulosPHP/visao/view.'.$sPgAtual.'.php';
    }

    if ((file_exists('modulosPHP/modelo/model.'.$sPgAtual.'.php'))) {
      require_once 'modulosPHP/modelo/model.'.$sPgAtual.'.php';
    }

    if ((file_exists('modulosPHP/negocio/business.'.$sPgAtual.'.php'))) {
      require_once 'modulosPHP/negocio/business.'.$sPgAtual.'.php';
    }

    if ((file_exists('modulosPHP/controle/control.'.$sPgAtual.'.php'))) {
      require_once 'modulosPHP/controle/control.'.$sPgAtual.'.php';
    }
    
    
  }
