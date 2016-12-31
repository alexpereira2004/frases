<?php

/**
 * Informações sobre qual banco de dados será carregado pelo sistema
 * 
 * @author Alex Lunardelli
 * @since  25/09/2005
 */

class database {
  public $sServidor;
  public $sUsuario;
  public $sSenha;
  public $sBanco;
  public $sBd;
  
  public function __construct($aParametros) {
    $this->sServidor = $aParametros['sServidor'];
    $this->sUsuario  = $aParametros['sUsuario'];
    $this->sSenha    = $aParametros['sSenha'];
    $this->sBanco    = $aParametros['sBanco'];
    $this->sBd       = $aParametros['sBd'];
  }
}
