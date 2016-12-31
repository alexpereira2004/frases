<?php
  include_once './modulosPHP/modelo/model.autores.php';
  /**
   * Descricao
   *
   * @package    Site Lunacom
   * @author     Alex Lunardelli <alex@lunacom.com.br>
   * @copyright  Lunacom marketing Digital
   * @date       25-08-2016
   **/

  class dao_autores {
  
    public    $ID           = array();
    public    $NM_AUTOR     = array();
    public    $TX_DESCRICAO = array();
    public    $aMsg = array();
    protected $iCdMsg;
    protected $sMsg;
    protected $sErro;
    public    $sBackpage;
    protected $DB_LINK;
    protected $oUtil;
    protected $oBd;
    protected $modelo;
    protected $aModelo;

    public function __construct() {
      include_once 'modulosPHP/class.conexao.php';
      $this->oBd   = new conexao();
      $this->oUtil = new wTools();
    }

    public function salvar() {

      try {
        $aValidar = array ( 10 => array('Autor'    , $this->NM_AUTOR[0]    , 'varchar', true, array(80)),
                            20 => array('Descricao', $this->TX_DESCRICAO[0], 'text'   , true),
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
                        nm_autor, 
                        tx_descricao 
                   FROM autores
                   '.$sFiltro;

      $mResultado = $this->oBd->query($sQuery);

      $this->iLinhas = $this->oBd->getNumeroLinhas();

      if (!is_array($mResultado)) {
        $this->aMsg = $this->oBd->getMsg();
        return false;
      }


      for ($i= 0; $i < $this->iLinhas; $i++) { 
        $this->ID[]           = $mResultado[$i]['id'];
        $this->NM_AUTOR[]     = $mResultado[$i]['nm_autor'];
        $this->TX_DESCRICAO[] = $mResultado[$i]['tx_descricao'];
        
        $this->modelo = new model_autores();
        $this->modelo->id           = $mResultado[$i]['id'];
        $this->modelo->nm_autor     = $mResultado[$i]['nm_autor'];
        $this->modelo->tx_descricao = $mResultado[$i]['tx_descricao'];
        $this->aModelo[] = $this->modelo;
      }
      
      return $this->aModelo;
    }

    public function inserir(model_autores $modelo) {
      $sQuery = "INSERT INTO autores(
                             nm_autor, 
                             tx_descricao )
      VALUES(
              '".$modelo->nm_autor."', 
              '".$modelo->tx_descricao."' )";

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
      $sQuery = "DELETE FROM autores ".$sFiltro;
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
      $sQuery = "UPDATE autores
        SET
          nm_autor     = '".$this->NM_AUTOR[0]."', 
          tx_descricao = '".$this->TX_DESCRICAO[0]."' 
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

      $this->ID[0]           = (isset ($_POST['CMPautores-id'])           ? $_POST['CMPautores-id']           : '');
      $this->NM_AUTOR[0]     = (isset ($_POST['CMPautores-autor'])     ? $_POST['CMPautores-autor']     : '');
      $this->TX_DESCRICAO[0] = (isset ($_POST['CMPautores-descricao']) ? $_POST['CMPautores-descricao'] : '');
      
    }
  }