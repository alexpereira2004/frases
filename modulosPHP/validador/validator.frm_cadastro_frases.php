<?php
include './modulosPHP/excecao/exception.validador.php';
class validator_frm_cadastro_frases {
  private $oUtil;
  public function __construct() {
    $this->oUtil = new wTools();
  }


//  public function carregarDados(model_nova_frase $oModelo, $aDados) {        
//    $oModelo->setAutor($this->oUtil->anti_sql_injection($aDados['CMPautor']));
//    $oModelo->setFrase($this->oUtil->anti_sql_injection($aDados['CMPfrase']));
//    $oModelo->setCodigoTagsSelecionados(isset($aDados['CMPtag']) ? $aDados['CMPtag'] : array());    
//    return $oModelo;
//  }


  public function validar(model_nova_frase $oModelo) {

        $aValidar = array ( 
                            10 => array('Autor', $oModelo->sAutor, 'varchar', true, array(80)),
                            20 => array('Frase', $oModelo->sFrase, 'text'   , true),
                            30 => array('Associar tags', count($oModelo->aCodigoTagsSelecionados), 'faixa-baixa',true , 0, 'O campo Associar tags deve ser preenchido'),
                            );

        // Validar preenchimento
        if ($this->oUtil->valida_Preenchimento($aValidar) !== true) {

          $this->aMsg = $this->oUtil->aMsg;
          throw new exception_validacao();
        }
    
  }
}
