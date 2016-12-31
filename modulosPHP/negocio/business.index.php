<?php
//include_once 'modulosPHP/dao/dao.autores.php';
//include_once 'modulosPHP/dao/dao.mensagem.php';
//include_once 'modulosPHP/dao/dao.tags.php';
//include_once 'modulosPHP/dao/dao.mensagemxtag.php';
//include_once 'modulosPHP/modelo/model.mensagem.php';

class business_index {
  
  public $sAutor;
  public $sFrase;
  private $oUtil;
  public $daoTag;
  public $oTags;

  public function __construct() {
    $this->oUtil = new wTools();
//    $this->daoTag = new tags();
//    $this->buscarTags();
  }
  
  
//  public function buscarTags() {
//    $this->aModeloTags = $this->daoTag->listar();
//    return $this->aModeloTags;
//  }
  
  
  

  
  
  public function inicializar($aDados) {
    $this->sAutor = $aDados['CMPautor'];
    $this->sFrase = $aDados['CMPfrase'];
  }
  
}
