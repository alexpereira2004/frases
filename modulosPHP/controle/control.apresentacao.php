<?php
/**
 *
 * @author Alex
 */
class control_apresentacao {
  
  protected $oNegocio;
  protected $oModelo;
  protected $oVisao;
  protected $oValidador;
  
  public function __construct() {
    
    $this->oModelo = new model_mensagem();
    $this->oNegocio = new business_apresentacao();

    $sAcao = 'mostrarMensagemDoDia';
    
    if ($sAcao == 'mostrarMensagemDoDia') {
      $mMensagemAgenda = $this->oNegocio->mostrarMensagemDoDia();
    }
    
    $this->oVisao = new view_apresentacao($mMensagemAgenda);
  }
  
  
  public function getVisao() {
    return $this->oVisao;
  }
  
}
