<?php
/**
 *
 * @author Alex
 * @date 24-12-2016
 */
include_once './modulosPHP/dao/dao.Agenda_de_mensagens.php';
class business_apresentacao {
  public $aMsg;

  public function __construct() {
    $this->oUtil = new wTools();
  }
  
  public function mostrarMensagemDoDia($sData = '') {
    if ($sData == '') {
      $oDao = new dao_Agenda_de_mensagens();
      $listModeloMensagemAgenda = $oDao->listarMensagemDoDia(date('Y-m-d'));
      return $listModeloMensagemAgenda[0];
    }
    
  }
}
