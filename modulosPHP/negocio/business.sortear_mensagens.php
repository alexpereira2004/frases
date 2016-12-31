<?php
include './modulosPHP/dao/dao.Sortear_mensagem.php';
/**
 * @author Alex
 */
class business_sortear_mensagens {
  public $aMsg;

  public function __construct() {
    $this->oUtil = new wTools();
  }
  
  public function sortearDiasDasMensagens(model_sortear_mensagens $oModel) {
    
    
    $odtDataInicio = new DateTime( $oModel->sDataInicio );
    $odtDataFinal = new DateTime( $oModel->sDataFinal );
    $oDadosIntervalo = $odtDataInicio->diff( $odtDataFinal );

    $this->agendarMensagem($odtDataInicio, $oDadosIntervalo->days);
    $this->aMsg = array('iCdMsg' => '1', 
                          'sMsg' => 'Foram sorteadas '.$oDadosIntervalo->days.' mensagen(s) entre os dias '.$oModel->sDataInicioPorExtenso .' e '.$oModel->sDataFinalPorExtenso ,
                      'sMsgErro' => '');
  }
  
  private function agendarMensagem($odtDataInicio, $iQuantidade) {

    $oDao = new Sortear_mensagem();
    $aTodasMensagens = $oDao->listarMensagensOrdenadasPorUtilizacao();
    
    $iJaUsadas = 0;
    for ($i = 0; $i <= $iQuantidade; $i++) {

      if (count($aTodasMensagens[$iJaUsadas]) == 0) {
        $iJaUsadas++;
      }
      
      shuffle($aTodasMensagens[$iJaUsadas]);
      $iIdMensagem = array_shift($aTodasMensagens[$iJaUsadas]);
      $odtDataInicio->add( new DateInterval('P1D'));

      $oDao->agendarNovaMensagem($odtDataInicio->format('Y-m-d'),$iIdMensagem );
    }
    
  }
}