<?php
  include './modulosPHP/modelo/model.mensagem.php';
  use Biblioteca as Biblioteca;

  /**
   * Descricao
   *
   * @package    Site Lunacom
   * @author     Alex Lunardelli <alex@lunacom.com.br>
   * @copyright  Lunacom marketing Digital
   * @date       25-08-2016
   **/

  class dao_mensagem {
  
    public    $ID          = array();
    public    $TX_MENSAGEM = array();
    public    $CD_TIPO     = array();
    public    $DT_INC      = array();
    public    $ID_AUTOR    = array();
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
      $this->oUtil = new Biblioteca\wTools();
    }
    
    public function buscarUltimoId() {
      $this->oBd->buscarUltimoId('mensagem', 'id');
      return $this->oBd->iUltimoId;
    }

    public function salvar() {

      try {
        $aValidar = array ( 10 => array('Mensagem', $this->TX_MENSAGEM[0], 'text'   , true),
                            20 => array('Tipo'    , $this->CD_TIPO[0]    , 'varchar', true, array(2)),
                            30 => array('Inc'     , $this->DT_INC[0]     , 'date'   , true),
                            40 => array('Autor'   , $this->ID_AUTOR[0]   , 'int'    , true, array(8)),
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
                        tx_mensagem, 
                        cd_tipo, 
                        date_format(dt_inc, "%d/%m/%Y") AS dt_inc, 
                        id_autor 
                   FROM mensagem
                   '.$sFiltro;

      $mResultado = $this->oBd->query($sQuery);

      if (!is_array($mResultado)) {
        $this->aMsg = $this->oBd->getMsg();
        return false;
      }

      $this->iLinhas = $this->oBd->getNumeroLinhas();

      for ($i= 0; $i < $this->iLinhas; $i++) { 
        $this->ID[]          = $mResultado[$i]['id'];
        $this->TX_MENSAGEM[] = $mResultado[$i]['tx_mensagem'];
        $this->CD_TIPO[]     = $mResultado[$i]['cd_tipo'];
        $this->DT_INC[]      = $mResultado[$i]['dt_inc'];
        $this->ID_AUTOR[]    = $mResultado[$i]['id_autor'];
        
        $this->modelo = new model_mensagem();
        $this->modelo->id          = $mResultado[$i]['id'];
        $this->modelo->tx_mensagem = $mResultado[$i]['id'];
        $this->modelo->cd_tipo     = $mResultado[$i]['id'];
        $this->modelo->dt_inc      = $mResultado[$i]['id'];
        $this->modelo->id_autor    = $mResultado[$i]['id'];
        $this->aModelo[] = $this->modelo;        
        
      }
    }

    public function inserir(model_mensagem $oModelo) {
      $sQuery = "INSERT INTO mensagem(
                             tx_mensagem, 
                             cd_tipo, 
                             dt_inc, 
                             id_autor )
      VALUES(
              '".$oModelo->tx_mensagem."', 
              '".$oModelo->cd_tipo."', 
              '".$oModelo->dt_inc."', 
              '".$oModelo->id_autor."' )";

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
      $sQuery = "DELETE FROM mensagem ".$sFiltro;
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
      $sQuery = "UPDATE mensagem
        SET
          tx_mensagem = '".$this->TX_MENSAGEM[0]."', 
          cd_tipo     = '".$this->CD_TIPO[0]."', 
          dt_inc      = '".$this->DT_INC[0]."', 
          id_autor    = '".$this->ID_AUTOR[0]."' 
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

      $this->ID[0]          = (isset ($_POST['CMPmensagem-id'])          ? $_POST['CMPmensagem-id']          : '');
      $this->TX_MENSAGEM[0] = (isset ($_POST['CMPmensagem-mensagem']) ? $_POST['CMPmensagem-mensagem'] : '');
      $this->CD_TIPO[0]     = (isset ($_POST['CMPmensagem-tipo'])     ? $_POST['CMPmensagem-tipo']     : '');
      $this->DT_INC[0]      = (isset ($_POST['CMPmensagem-inc'])      ? $_POST['CMPmensagem-inc']      : '');
      $this->ID_AUTOR[0]    = (isset ($_POST['CMPmensagem-autor'])    ? $_POST['CMPmensagem-autor']    : '');
      
    }
  }