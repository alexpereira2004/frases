<?php
include_once './modulosPHP/validador/validator.frm_sortear_frases.php';
include_once './modulosPHP/modelo/class.modelo.php';
    

class control_sortear_mensagens extends Modelo {
  
  protected $oNegocio;
  protected $oModelo;
  protected $oVisao;
  protected $oValidador;


  public function __construct() {
    
    $this->oModelo = new model_sortear_mensagens();
    $this->oNegocio = new business_sortear_mensagens();
    
    $sAcao = (isset($_POST['sAcao']) ? $_POST['sAcao'] : '');
    if ($sAcao == 'gerar') {
      try {
        $this->oValidador = new validator_frm_sortear_frases();
        $this->oModelo->carregarDadosAposPost($_POST);
        $this->oValidador->validar($this->oModelo);
        
        $this->oNegocio->sortearDiasDasMensagens($this->oModelo);
        $this->oModelo->mAcaoResultado = '1';
        $this->oModelo->sAcaoMsg = $this->oNegocio->aMsg['sMsg'];

      } catch (exception_validacao $ex) {
        $this->oModelo->mAcaoResultado = 2;
        $this->oModelo->sAcaoMsg       = $this->oValidador->aMsg['sMsg'];
      }

    }

    $this->oVisao  = new view_sortear_mensagens($this->oModelo);
  }
  
  public function getVisao() {
    return $this->oVisao;
  }
}
