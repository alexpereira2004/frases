<?php

include_once 'class.wTools.php';
include_once 'class.config.php';
include_once 'PHPMailer_5.2.1/class.phpmailer.php';

class email extends PHPMailer{
  
  public function __construct() {
    parent::__construct();
    $this->IsSMTP();
    $this->IsHTML();
    
    
    $this->IsSMTP();
    $this->IsHTML();

    foreach ($aDestinatariosContatoCC as $sDestinatarioCC) {
      
    }

//    if (!$this->Send()) {
//      echo $this->ErrorInfo;
//    }
  }
  
  
  
  private function configurar() {
    $oSite->buscarParametro(array('HOST', 'PASS_MAIL', 'REMETENTE', 'DESTINATARIOS'));
    
    $this->Host     = $oSite->aParametros['HOST'][0];
    $this->Password = base64_encode($oDadosAdm->SCAPE.$oSite->aParametros['PASS_MAIL'][0]);

    $this->SetFrom($oSite->aParametros['REMETENTE'][0], 'Site Deportivo Bravo FC');
    $this->AddAddress($sDestinatario);
    

    $this->Subject = 'Contato enviado pelo site Deportivo Bravo FC';
    $this->Body = $sMsgHtml;

    $sDestinatario = array_shift($oSite->aParametros['DESTINATARIOS']);

    $aDestinatariosContatoCC = array();
    if (is_array($oSite->aParametros['DESTINATARIOS'])) {
//      $aDestinatariosContatoCC = $oSite->aParametros['DESTINATARIOS'];
      $this->AddBCC($sDestinatarioCC);
    }    
  }

 
  
  
  private function definirDestinatarios() {
    if ($_SERVER['SERVER_NAME'] == 'localhost') {
      
    }
    
    $this->SetFrom($oSite->aParametros['REMETENTE'][0], 'Site Deportivo Bravo FC');
    $this->AddAddress($sDestinatario);

    foreach ($aDestinatariosContatoCC as $sDestinatarioCC) {
      $this->AddBCC($sDestinatarioCC);
    }
  }
  
  public function enviar() {
    
  }


}