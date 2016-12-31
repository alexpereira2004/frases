<?php
  /**
   * Descricao
   *
   * @package    Site Lunacom
   * @author     Alex Lunardelli <alex@lunacom.com.br>
   * @copyright  Lunacom marketing Digital
   * @date       25-08-2016
   **/

  class seg_usuarios {
  
    public    $ID                   = array();
    public    $NM_USUARIO           = array();
    public    $TX_EMAIL             = array();
    public    $TX_LOGIN             = array();
    public    $TX_SENHA             = array();
    public    $DT_CAD               = array();
    public    $CD_STATUS            = array();
    public    $CD_NIVEL             = array();
    public    $TX_TOKEN             = array();
    public    $TX_SENHA_PROVISORIA  = array();
    public    $NU_TENTATIVAS_ACESSO = array();
    public    $NU_ACESSOS           = array();
    public    $ID_PESSOA            = array();
    public    $aMsg = array();
    protected $iCdMsg;
    protected $sMsg;
    protected $sErro;
    public    $sBackpage;
    protected $DB_LINK;
    protected $oUtil;
    protected $oBd;

    public function __construct() {
      include_once 'class.conexao.php';
      $this->oBd   = new conexao();
      $this->oUtil = new wTools();
    }

    public function salvar() {

      try {
        $aValidar = array ( 10 => array('Usuario'          , $this->NM_USUARIO[0]          , 'varchar', true, array(50)),
                            20 => array('Email'            , $this->TX_EMAIL[0]            , 'varchar', true, array(50)),
                            30 => array('Login'            , $this->TX_LOGIN[0]            , 'varchar', true, array(20)),
                            40 => array('Senha'            , $this->TX_SENHA[0]            , 'varchar', true, array(50)),
                            50 => array('Cad'              , $this->DT_CAD[0]              , 'date'   , true),
                            60 => array('Status'           , $this->CD_STATUS[0]           , 'char'   , true, array(2)),
                            70 => array('Nivel'            , $this->CD_NIVEL[0]            , 'int'    , true, array(2)),
                            80 => array('Token'            , $this->TX_TOKEN[0]            , 'varchar', true, array(255)),
                            90 => array('Senha-provisoria' , $this->TX_SENHA_PROVISORIA[0] , 'varchar', true, array(50)),
                           100 => array('Tentativas-acesso', $this->NU_TENTATIVAS_ACESSO[0], 'int'    , true, array(10)),
                           110 => array('Acessos'          , $this->NU_ACESSOS[0]          , 'int'    , true, array(10)),
                           120 => array('Pessoa'           , $this->ID_PESSOA[0]           , 'int'    , true, array(10)),
                           );

        // Validar preenchimento
        if ($this->oUtil->valida_Preenchimento($aValidar) !== true) {
          $this->aMsg = $this->oUtil->aMsg;
          throw new excecoes(25);
        }

        // Editar
        if ($_POST['sAcao'] == 'editar') {
          $this->editar($this->ID[0]);

	// Inserir
        } elseif ($_POST['sAcao'] == 'inserir') {
          $this->inserir();
          $this->oUtil->redirFRM($this->sBackpage, $this->aMsg);
          header('location:'.$this->sBackpage);
          exit;
        } else {
          throw new excecoes(20, $this->oUtil->anti_sql_injection($_POST['CMPpgAtual']));
        }

      } catch (excecoes $e) {
        $e->bReturnMsg = false;
        $e->getErrorByCode();
        if (is_array($e->aMsg)) {
          $this->aMsg = $e->aMsg;
        }
        return false;
      }
      return true;
    }

    public function listar($sFiltro = '') {
      $sQuery = 'SELECT id,
                        nm_usuario, 
                        tx_email, 
                        tx_login, 
                        tx_senha, 
                        date_format(dt_cad, "%d/%m/%Y") AS dt_cad, 
                        cd_status, 
                        cd_nivel, 
                        tx_token, 
                        tx_senha_provisoria, 
                        nu_tentativas_acesso, 
                        nu_acessos, 
                        id_pessoa 
                   FROM seg_usuarios
                   '.$sFiltro;

      $mResultado = $this->oBd->query($sQuery);

      if (!is_array($mResultado)) {
        $this->aMsg = $this->oBd->getMsg();
        return false;
      }

      $this->iLinhas = $this->oBd->getNumeroLinhas();

      for ($i= 0; $i < $this->iLinhas; $i++) { 
        $this->ID[]                   = $mResultado[$i]['id'];
        $this->NM_USUARIO[]           = $mResultado[$i]['nm_usuario'];
        $this->TX_EMAIL[]             = $mResultado[$i]['tx_email'];
        $this->TX_LOGIN[]             = $mResultado[$i]['tx_login'];
        $this->TX_SENHA[]             = $mResultado[$i]['tx_senha'];
        $this->DT_CAD[]               = $mResultado[$i]['dt_cad'];
        $this->CD_STATUS[]            = $mResultado[$i]['cd_status'];
        $this->CD_NIVEL[]             = $mResultado[$i]['cd_nivel'];
        $this->TX_TOKEN[]             = $mResultado[$i]['tx_token'];
        $this->TX_SENHA_PROVISORIA[]  = $mResultado[$i]['tx_senha_provisoria'];
        $this->NU_TENTATIVAS_ACESSO[] = $mResultado[$i]['nu_tentativas_acesso'];
        $this->NU_ACESSOS[]           = $mResultado[$i]['nu_acessos'];
        $this->ID_PESSOA[]            = $mResultado[$i]['id_pessoa'];
      }
    }

    public function inserir() {
      $sQuery = "INSERT INTO seg_usuarios(
                             nm_usuario, 
                             tx_email, 
                             tx_login, 
                             tx_senha, 
                             dt_cad, 
                             cd_status, 
                             cd_nivel, 
                             tx_token, 
                             tx_senha_provisoria, 
                             nu_tentativas_acesso, 
                             nu_acessos, 
                             id_pessoa )
      VALUES(
              '".$this->NM_USUARIO[0]."', 
              '".$this->TX_EMAIL[0]."', 
              '".$this->TX_LOGIN[0]."', 
              '".$this->TX_SENHA[0]."', 
              '".$this->DT_CAD[0]."', 
              '".$this->CD_STATUS[0]."', 
              '".$this->CD_NIVEL[0]."', 
              '".$this->TX_TOKEN[0]."', 
              '".$this->TX_SENHA_PROVISORIA[0]."', 
              '".$this->NU_TENTATIVAS_ACESSO[0]."', 
              '".$this->NU_ACESSOS[0]."', 
              '".$this->ID_PESSOA[0]."' )";

      if (!$this->oBd->execute($sQuery)) {
        $this->iCdMsg = 1;
        $this->sMsg  = 'Ocorreu um erro ao salvar o registro.';
        $aMsg = $this->oBd->getMsg(false);
        $this->sErro = $aMsg['sMsg'];
    	$this->sResultado = 'erro';
        $bSucesso = false;
      } else {
        $this->iCdMsg = 0;
        $this->sMsg  = 'O registro foi adicionado com sucesso!';
        $this->sErro = '';
        $this->sResultado = 'sucesso';
        $bSucesso = true;
      }

      // Monta array com mensagem de retorno
      $this->aMsg = array('iCdMsg' => $this->iCdMsg,
                            'sMsg' => $this->sMsg,
                           'sErro' => $this->sErro,
                      'sResultado' => $this->sResultado );

      return $bSucesso;
    }

    public function remover($sFiltro) {
      $sQuery = "DELETE FROM seg_usuarios ".$sFiltro;
      $sResultado = $this->oBd->execute($sQuery);

      if (!$sResultado) {
        $this->iCdMsg = 1;
        $this->sMsg  = 'Ocorreu um erro ao remover o registro.';
        $this->sErro = mysql_error();
        $this->sResultado = 'erro';
        $bSucesso = false;

      } else {
        $this->iCdMsg = 0;
        $this->sMsg  = 'O registro foi removido com sucesso!';
        $this->sResultado = 'sucesso';
        $bSucesso = true;
      }

      // Monta array com mensagem de retorno
      $this->aMsg = array('iCdMsg' => $this->iCdMsg,
			    'sMsg' => $this->sMsg,
		      'sResultado' => $this->sResultado );
      return $bSucesso;
    }

    public function editar($iId = '') {
      $sQuery = "UPDATE seg_usuarios
        SET
          nm_usuario           = '".$this->NM_USUARIO[0]."', 
          tx_email             = '".$this->TX_EMAIL[0]."', 
          tx_login             = '".$this->TX_LOGIN[0]."', 
          tx_senha             = '".$this->TX_SENHA[0]."', 
          dt_cad               = '".$this->DT_CAD[0]."', 
          cd_status            = '".$this->CD_STATUS[0]."', 
          cd_nivel             = '".$this->CD_NIVEL[0]."', 
          tx_token             = '".$this->TX_TOKEN[0]."', 
          tx_senha_provisoria  = '".$this->TX_SENHA_PROVISORIA[0]."', 
          nu_tentativas_acesso = '".$this->NU_TENTATIVAS_ACESSO[0]."', 
          nu_acessos           = '".$this->NU_ACESSOS[0]."', 
          id_pessoa            = '".$this->ID_PESSOA[0]."' 
          WHERE id = ".$iId;
      $sResultado = $this->oBd->execute($sQuery);

      if (!$sResultado) {
        $this->iCdMsg = 1;
        $this->sMsg  = 'Ocorreu um erro ao salvar o registro.';
        $this->sErro = $this->oBd->aMsg('sMsg');
    	$this->sResultado = 'erro';
        $bSucesso = false;

    	} else {
        $this->iCdMsg = 0;
        $this->sMsg  = 'O registro foi editado com sucesso!';
        $this->sResultado = 'sucesso';
        $bSucesso = true;
      }
    // Monta array com mensagem de retorno
    $this->aMsg = array('iCdMsg' => $this->iCdMsg,
                          'sMsg' => $this->sMsg,
                    'sResultado' => $this->sResultado );
    return $bSucesso;
    }

    public function inicializaAtributos() {

      $this->ID[0]                   = (isset ($_POST['CMPusuarios-id'])                   ? $_POST['CMPusuarios-id']                   : '');
      $this->NM_USUARIO[0]           = (isset ($_POST['CMPusuarios-usuario'])           ? $_POST['CMPusuarios-usuario']           : '');
      $this->TX_EMAIL[0]             = (isset ($_POST['CMPusuarios-email'])             ? $_POST['CMPusuarios-email']             : '');
      $this->TX_LOGIN[0]             = (isset ($_POST['CMPusuarios-login'])             ? $_POST['CMPusuarios-login']             : '');
      $this->TX_SENHA[0]             = (isset ($_POST['CMPusuarios-senha'])             ? $_POST['CMPusuarios-senha']             : '');
      $this->DT_CAD[0]               = (isset ($_POST['CMPusuarios-cad'])               ? $_POST['CMPusuarios-cad']               : '');
      $this->CD_STATUS[0]            = (isset ($_POST['CMPusuarios-status'])            ? $_POST['CMPusuarios-status']            : '');
      $this->CD_NIVEL[0]             = (isset ($_POST['CMPusuarios-nivel'])             ? $_POST['CMPusuarios-nivel']             : '');
      $this->TX_TOKEN[0]             = (isset ($_POST['CMPusuarios-token'])             ? $_POST['CMPusuarios-token']             : '');
      $this->TX_SENHA_PROVISORIA[0]  = (isset ($_POST['CMPusuarios-senha-provisoria'])  ? $_POST['CMPusuarios-senha-provisoria']  : '');
      $this->NU_TENTATIVAS_ACESSO[0] = (isset ($_POST['CMPusuarios-tentativas-acesso']) ? $_POST['CMPusuarios-tentativas-acesso'] : '');
      $this->NU_ACESSOS[0]           = (isset ($_POST['CMPusuarios-acessos'])           ? $_POST['CMPusuarios-acessos']           : '');
      $this->ID_PESSOA[0]            = (isset ($_POST['CMPusuarios-pessoa'])            ? $_POST['CMPusuarios-pessoa']            : '');
      
    }
  }