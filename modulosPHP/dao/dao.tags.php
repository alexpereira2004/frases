<?php
    /**
   * Descricao
   *
   * @package    Site Lunacom
   * @author     Alex Lunardelli <alex@lunacom.com.br>
   * @copyright  Lunacom marketing Digital
   * @date       25-08-2016
   **/

  class tags {
  
    public    $ID     = array();
    public    $NM_TAG = array();
    public    $id;
    public    $nm_tag;
    public    $aMsg = array();
    protected $iCdMsg;
    protected $sMsg;
    protected $sErro;
    public    $sBackpage;
    protected $DB_LINK;
    protected $oUtil;
    protected $oBd;
    protected $oTags;

    public function __construct() {
      include_once 'modulosPHP/class.conexao.php';
      $this->oBd   = new conexao();
      $this->oUtil = new wTools();
    }

    public function salvar() {

      try {
        $aValidar = array ( 10 => array('Tag', $this->NM_TAG[0], 'varchar', true, array(50)),
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
                        nm_tag 
                   FROM tags
                   '.$sFiltro;

      $mResultado = $this->oBd->query($sQuery);

      if (!is_array($mResultado)) {
        $this->aMsg = $this->oBd->getMsg();
        return false;
      }

      $this->iLinhas = $this->oBd->getNumeroLinhas();

      for ($i= 0; $i < $this->iLinhas; $i++) { 
        $aTags[$i] = new model_tag();
        $aTags[$i]->id = $mResultado[$i]['id'];
        $aTags[$i]->nm_tag = $mResultado[$i]['nm_tag'];
        
        
        $this->ID[]     = $mResultado[$i]['id'];
        $this->NM_TAG[] = $mResultado[$i]['nm_tag'];
      }
      
      return $aTags;
      
    }

    public function inserir() {
      $sQuery = "INSERT INTO tags(
                             nm_tag )
      VALUES(
              '".$this->NM_TAG[0]."' )";

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
      $sQuery = "DELETE FROM tags ".$sFiltro;
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
      $sQuery = "UPDATE tags
        SET
          nm_tag = '".$this->NM_TAG[0]."' 
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

      $this->ID[0]     = (isset ($_POST['CMPtags-id'])     ? $_POST['CMPtags-id']     : '');
      $this->NM_TAG[0] = (isset ($_POST['CMPtags-tag']) ? $_POST['CMPtags-tag'] : '');
      
    }
  }