<?php

include_once './modulosPHP/validador/validator.frm_cadastro_frases.php';

class control_index extends Modelo {
  
  protected $oNegocio;
  protected $oModelo;
  protected $oVisao;
  protected $oValidador;


  public function __construct() {
    
    
    $this->oModelo = new model_index();
    $this->oNegocio = new business_index();
    $this->oVisao  = new view_index($this->oModelo);

  }
  
  public function getVisao() {
    return $this->oVisao;
  }
}
