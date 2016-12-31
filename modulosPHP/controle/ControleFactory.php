<?php

class ControleFactory {
  public static function inicializar($sPaginaAtual) {
    
    $sPaginaAtual = str_replace('-', '_', $sPaginaAtual);

    $sNomeObjeto = 'control_'.$sPaginaAtual;
    
    if (!class_exists($sNomeObjeto)) {
      $sNomeObjeto = 'control_apresentacao'; 
    }


    return new $sNomeObjeto();
  }
}
