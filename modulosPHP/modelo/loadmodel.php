<?php
$sPgAtual = $oUtil->buscarNomePaginaAtual();

  function __autoload($sPgAtual) {
    $sPgAtual = str_replace('model_', '', $sPgAtual);
    
    
    if ((file_exists('modulosPHP/model/model.'.$sPgAtual.'.php'))) {
      require_once 'model.'.$sPgAtual.'.php';
    }
    
    
  }
