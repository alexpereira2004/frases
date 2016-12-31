<?php
include './modulosPHP/excecao/exception.validador.php';
class validator_frm_sortear_frases {
 
  public function __construct() {
    $this->oUtil = new wTools();
  }

  public function validar(model_sortear_mensagens $oModelo) {
        $aValidar = array ( 
                            10 => array('Data Início', $oModelo->sDataInicio, 'date', true),
                            20 => array('Data Final' , $oModelo->sDataFinal, 'date' , true),
                            30 => array('Data Final' , $oModelo->sDataInicio, 'date-maior' , true, $oModelo->sDataFinal),
                            );

        // Validar preenchimento
        if ($this->oUtil->valida_Preenchimento($aValidar) !== true) {

          $this->aMsg = $this->oUtil->aMsg;
          throw new exception_validacao();
        }    
  }
}
