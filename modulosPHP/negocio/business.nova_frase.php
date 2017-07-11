<?php
use Biblioteca as Biblioteca;
include_once 'modulosPHP/dao/dao.autores.php';
include_once 'modulosPHP/dao/dao.mensagem.php';
include_once 'modulosPHP/dao/dao.tags.php';
include_once 'modulosPHP/dao/dao.mensagemxtag.php';
include_once 'modulosPHP/modelo/model.mensagem.php';

/**
 * @author Alex
 */
class business_nova_frase {
  
  public function __construct() {
    $this->oUtil = new Biblioteca\wTools;
    $this->daoTag = new tags();
    $this->buscarTags();
  }

  public function buscarTags() {
    $this->aModeloTags = $this->daoTag->listar();
    return $this->aModeloTags;
  }
  
  public function salvar(model_nova_frase $oModelo) {

      $oAutores = new dao_autores();
      $aModeloAutores = $oAutores->listar("WHERE nm_autor = '".$this->oUtil->anti_sql_injection($oModelo->sAutor)."'");

      if ($oAutores->iLinhas == 0) {
        
        $modeloNovoAutor = new model_autores();
        $modeloNovoAutor->nm_autor = $oModelo->sAutor;
        $modeloNovoAutor->tx_descricao = '';

        $oNovoAutor = new dao_autores();
        $oNovoAutor->inserir($modeloNovoAutor);

        $aModeloAutores = $oAutores->listar("WHERE nm_autor = '".$this->oUtil->anti_sql_injection($oModelo->sAutor)."'");
      }
      
      // Salvar Mensagem/Frase
      $modeloMensagem = new model_mensagem();
      $modeloMensagem->tx_mensagem = $oModelo->sFrase;
      $modeloMensagem->cd_tipo = 'FR';
      $modeloMensagem->dt_inc = date('Y-m-d');
      $modeloMensagem->id_autor = $aModeloAutores[0]->id;

      $oDaoNovaFrase = new dao_mensagem();
      $oDaoNovaFrase->inserir($modeloMensagem);
      $iUltimaMensagem = $oDaoNovaFrase->buscarUltimoId();
      
      // Salvar Mensagem x Tags
      foreach ($oModelo->aCodigoTagsSelecionados as $iId) {
        $oModeloTagsRelacionadas = new model_mensagemxtag();
        $oModeloTagsRelacionadas->id_tag = $iId;
        $oModeloTagsRelacionadas->id_mensagem = $iUltimaMensagem;
        
        $oDaoTagsRelacionadas = new dao_mensagemxtag();
        $oDaoTagsRelacionadas->inserir($oModeloTagsRelacionadas);
        
      }

  }
}
