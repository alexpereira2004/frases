<?php
/**
 * Encarregada de conectar e fazer consultas ao BD
 * Esta classe utiliza ADO DB
 *
 * @author Alex Lunardelli 
 * @since  23/09/2014
 * 
 */

include 'adodb5/adodb.inc.php';
include_once 'class.config.php';
include_once 'class.database.php';
class conexao {
  private static $sBanco = null;
  private $oBanco;
  private $oConfig;
  private $aMsg;
  private $iLinhas = 0;
  public  $iUltimoId;
  public function __construct() {
    
    $this->definirBanco();
    
    $this->oConfig = new config();
    
    self::definirBanco();
    
    $oInfoConexao = $this->oConfig->getInfoBd(self::$sBanco);
    
    $this->oBanco = NewADOConnection($oInfoConexao->sBd);

    $this->oBanco->Connect($oInfoConexao->sServidor, $oInfoConexao->sUsuario, $oInfoConexao->sSenha, $oInfoConexao->sBanco);
    
    if ($this->oBanco->_errorMsg != '') {
      die('Verifique o seguinte erro antes de conectar ao banco de dados: '."\n".$this->oBanco->_errorMsg);
    }
        
  }
  
  public function abrirTransacao() {
    $this->oBanco->StartTrans();
  }
  
  public function efetivarTransacao() {
    $this->oBanco->CompleteTrans();
  }
  
  public function cancelarTransacao() {
    $this->oBanco->FailTrans(); 
  }

  public function buscarUltimoId($sTabela, $iId) {
    $this->iUltimoId = $this->oBanco->Insert_ID($sTabela, $iId);
    return true;
  }

  public function ativarDebug() {
    $this->oBanco->debug = true;
  }

  public function desativarDebug() {
    $this->oBanco->debug = false;
  }

  /**
   * Lógica para determinar qual o domínio/banco usar.
   * 
   * Busca o nome do servidor atual e define qual banco de dados deverá carregar
   * 
   * @author Alex Lunardelli
   */
  public static function definirBanco() {
    if (is_null(self::$sBanco)) {
      $aRet = explode('/', $_SERVER['PHP_SELF']);

      $aRet[1] = ($_SERVER['SERVER_NAME'] == 'localhost') ? $aRet[1] : 'producao';

      switch ($aRet[1]) {
	case 'Frases':
	  self::$sBanco = 'frases_v1';
	  break;
        default:
	  self::$sBanco = 'producao';
	  break;
      }
    }

    return true;
  }


  public function query($sQuery) {
    $mRet = $this->oBanco->getAll($sQuery);

    if (!is_array($mRet)) {
      $this->getMsg(false);
      return false;
    }
    $this->iLinhas = count($mRet);
    $this->getMsg(true);
  
    return $mRet;
  }
  
  public function execute($sQuery) {

    $bResultado = true;
    if ($this->oBanco->Execute($sQuery) === false) {
      $bResultado = false;
    }
    
    $this->getMsg($bResultado);
    return $bResultado;
    
  }
  
  public function getMsg($mResultado = '') {

    if ($mResultado === '') {
      return $this->aMsg;

    } elseif (in_array($mResultado, array('iCdMsg', 'sMsg', 'sRasultado'))) {
      return $this->aMsg[$mResultado];

    } elseif ($mResultado === true) {
      $this->aMsg = array('iCdMsg' => 0,
                      'sMsg' => 'Sucesso',
                'sResultado' => 'sucesso');

    } elseif ($mResultado === false) {
      $this->aMsg = array('iCdMsg' => 2,
                            'sMsg' => $this->oBanco->ErrorNo().'('.$this->oBanco->ErrorMsg().')',
                      'sResultado' => 'erro');
    }

    return $this->aMsg;
  }
  
  public function getNumeroLinhas() {
    return $this->iLinhas;
  }
  
}
