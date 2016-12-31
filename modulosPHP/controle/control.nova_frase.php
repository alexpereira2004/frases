<?php

include_once './modulosPHP/validador/validator.frm_cadastro_frases.php';
include_once './modulosPHP/modelo/class.modelo.php';

class control_nova_frase extends Modelo {
  
  private $oNegocio;
  private $oModelo;
  private $oVisao;
  private $oValidador;


  public function __construct() {

    
    $this->oModelo = new model_nova_frase();
    $this->oNegocio = new business_nova_frase();
    
    $aModeloTags = $this->oNegocio->buscarTags();
    $this->oModelo->setModeloTags($aModeloTags);

    
    if (isset($_POST)) {
      if (isset($_POST['sAcao'])) {
        if ($_POST['sAcao'] == 'salvar') {

          try {
            $this->oValidador = new validator_frm_cadastro_frases();
            $this->oModelo = $this->oValidador->carregarDados($this->oModelo, $_POST);
            $this->oValidador->validar($this->oModelo);


            $this->oNegocio->salvar($this->oModelo);
            
            $this->oModelo = new model_nova_frase();
            $this->oModelo->setModeloTags($aModeloTags);
            $this->oModelo->mAcaoResultado = 0;
            $this->oModelo->sAcaoMsg       = 'Novo cadastro foi realizado com sucesso!';
            
          } catch (exception_validacao $ex) {
            $this->oModelo->mAcaoResultado = 2;
            $this->oModelo->sAcaoMsg       = $this->oValidador->aMsg['sMsg'];
          }
          
          
        }
      }
    }
    


    $this->oVisao  = new view_nova_frase($this->oModelo);

  }
  
  public function getVisao() {
    return $this->oVisao;
  }
}
