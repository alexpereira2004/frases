<?php

//include_once 'dao.seg_loggeral.php';
include_once 'class.wTools.php';



class excecoes extends Exception {
  public $iCdMsg;
  public $sMsg;
  public $sResultado;
  public $aMsg;

  public $sNmLog;
  public $sTxLog;
  public $sCdLog;
  public $sCdAcao = 'E';
  public $iCdUsu = 0;

  public $oUtil;

  public $iCodigo;
  public $sCdLocal;



  public function __construct($iCodigo, $sCdLocal = '', $aMsg = '') {
    parent::__construct();
    $this->oUtil      = new wTools();
    $this->iCodigo    = $iCodigo;
    $this->sCdLocal   = $sCdLocal;
    $this->sErro      = '';
    
    $this->bSalvarLog = true;
    $this->bReturnMsg = false;

    if (is_array($aMsg)) {
      $this->aMsg = $aMsg;
    }
  }
  

  public function getErrorByCode() {

    if (empty ($this->iCodigo) || (!$this->bSalvarLog)) {
      return false;
    }
    

    
    switch ($this->iCodigo) {

      // Esperado um inteiro
      case 10:
        $this->iCdMsg     = 2;
        $this->sMsg       = 'C�digo identificador deve possuir somente n�meros';
        $this->sResultado = 'erro';
        $this->sNmLog     = 'Id n�o num�rico';
        $aDados = array(  'cd_local' => $this->sCdLocal,
                          'tx_uri'   => $_SERVER['REQUEST_URI'], );
        $this->sTxLog = $this->oUtil->montarStringDados($aDados);
        $this->sCdLog = 'ID_NAO_NUMERICO';
        break;

      case 15:
        $this->iCdMsg     = 1;
        $this->sMsg       = 'N�o foi localizado um registro com este identificador';
        $this->sResultado = 'erro';
        $this->sNmLog     = 'Registro n�o encontrato';
        $aDados = array(  'cd_local' => $this->sCdLocal,
                          'tx_uri'   => $_SERVER['REQUEST_URI'], );
        $this->sTxLog = $this->oUtil->montarStringDados($aDados);
        $this->sCdLog = 'REG_NAO_ENCONTRADO';
        break;
    

      case 20:
        $this->iCdMsg     = 2;
        $this->sMsg       = 'Tipo de a��o para tratamento dos dados n�o � v�lido';
        $this->sResultado = 'erro';
        $this->sNmLog     = 'A��o inv�lida';
        $aDados = array(  'cd_local' => $this->sCdLocal,
                          'tx_acao'  => $_POST['sAcao'],
                           'tx_sql'  => $this->sErro,
                          'tx_uri'   => $_SERVER['REQUEST_URI'], );
        $this->sTxLog = $this->oUtil->montarStringDados($aDados);
        $this->sCdLog = 'FRM_ACAO_INVALIDA';
        break;


      case 25:
        $this->iCdMsg     = 2;
        $this->sMsg       = 'Foi encontrado um erro na valida��o do formul�rio';
        $this->sResultado = 'erro';
        $this->sNmLog     = 'Formul�rio inv�lido';
        $aDados = array(  'cd_local' => $this->sCdLocal,
                          'tx_acao'  => $_POST['sAcao'],
                          'tx_uri'   => $_SERVER['REQUEST_URI'], );
        $this->sTxLog = $this->oUtil->montarStringDados($aDados);
        $this->sCdLog = 'ERRO_NA_VALIDACAO';
        break;

      case 26:
        $this->iCdMsg     = 2;
        $this->sMsg       = 'Email j� cadastrado no sistema';
        $this->sResultado = 'erro';
        $this->sNmLog     = 'Usu�rio repetido';
        $aDados = array(  'cd_local' => $this->sCdLocal,
                          'tx_acao'  => $_POST['sAcao'],
                          'tx_email'  => $_POST['CMPclientes-email-'.$_POST['CMPtpCadastro']],
                          'tx_uri'   => $_SERVER['REQUEST_URI'], );
        $this->sTxLog = $this->oUtil->montarStringDados($aDados);
        $this->sCdLog = 'USUARIO_REPETIDO';
        break;
      
      case 99:
        //faz nada
        break;
    }

    if ($this->bReturnMsg) {
      $this->aMsg = array('iCdMsg' => $this->iCdMsg,
                            'sMsg' => $this->sMsg,
                      'sResultado' => $this->sResultado);
    }

//    $this->insereLog();
  }

  private function insereLog() {

    $oLog = new seg_loggeral();

    $oLog->NM_LOG[0]   = $this->sNmLog;
    $oLog->TX_LOG[0]   = $this->sTxLog;
    $oLog->CD_LOG[0]   = $this->sCdLog;
    $oLog->CD_ACAO[0]  = $this->sCdAcao;
    $oLog->TX_IP[0]    = $_SERVER['REMOTE_ADDR'];
    $oLog->TX_TRACE[0] = $_SERVER['REQUEST_URI'];
    $oLog->ID_USU[0]   = $this->iCdUsu;

    $oLog->inserir();

  }





}
?>
