<?php
  /**
   * Descricao
   *
   * @package    Site Lunacom
   * @author     Alex Lunardelli <alex@lunacom.com.br>
   * @copyright  Lunacom marketing Digital
   * @date       25-08-2016
   **/

  class agendamento {
  
    public    $ID              = array();
    public    $DT_APRESENTACAO = array();
    public    $ID_MENSAGEM     = array();
    public    $aMsg = array();
    protected $iCdMsg;
    protected $sMsg;
    protected $sErro;
    public    $sBackpage;
    protected $DB_LINK;
    protected $oUtil;
    protected $oBd;

    public function __construct() {
      include_once './modulosPHP/class.conexao.php';
      $this->oBd   = new conexao();
      $this->oUtil = new wTools();
    }

    public function salvar() {

      try {
        $aValidar = array ( 10 => array('Apresentacao', $this->DT_APRESENTACAO[0], 'date', true),
                            20 => array('Mensagem'    , $this->ID_MENSAGEM[0]    , 'int' , true, array(8)),
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
                        date_format(dt_apresentacao, "%d/%m/%Y") AS dt_apresentacao, 
                        id_mensagem 
                   FROM agendamento
                   '.$sFiltro;

      $mResultado = $this->oBd->query($sQuery);

      if (!is_array($mResultado)) {
        $this->aMsg = $this->oBd->getMsg();
        return false;
      }

      $this->iLinhas = $this->oBd->getNumeroLinhas();

      for ($i= 0; $i < $this->iLinhas; $i++) { 
        $this->ID[]              = $mResultado[$i]['id'];
        $this->DT_APRESENTACAO[] = $mResultado[$i]['dt_apresentacao'];
        $this->ID_MENSAGEM[]     = $mResultado[$i]['id_mensagem'];
      }
    }

    public function inserir() {
      $sQuery = "INSERT INTO agendamento(
                             dt_apresentacao, 
                             id_mensagem )
      VALUES(
              '".$this->DT_APRESENTACAO[0]."', 
              '".$this->ID_MENSAGEM[0]."' )";

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
      $sQuery = "DELETE FROM agendamento ".$sFiltro;
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

    public function editar($sFiltro = '') {
      $sQuery = "UPDATE agendamento
        SET
          dt_apresentacao = '".$this->DT_APRESENTACAO[0]."', 
          id_mensagem     = '".$this->ID_MENSAGEM[0]."' 
          ".$sFiltro;
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

      $this->ID[0]              = (isset ($_POST['CMPagendamento-id'])              ? $_POST['CMPagendamento-id']              : '');
      $this->DT_APRESENTACAO[0] = (isset ($_POST['CMPagendamento-apresentacao']) ? $_POST['CMPagendamento-apresentacao'] : '');
      $this->ID_MENSAGEM[0]     = (isset ($_POST['CMPagendamento-mensagem'])     ? $_POST['CMPagendamento-mensagem']     : '');
      
    }
  }