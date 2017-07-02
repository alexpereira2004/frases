<?php

class model_nova_frase extends Modelo{
  public $sAutor;
  public $sFrase;
  public $aModeloTags;
  public $aCodigoTagsSelecionados;
  public $oTags;
  private $oUtil;

  public function __construct() {
    $this->oUtil = new wTools();
  }

  public function setAutor($sAutor) {
    $this->sAutor = $sAutor;
  }
  
  public function setFrase($sFrase) {
    $this->sFrase = $sFrase;
  }
  
  public function setModeloTags($aModeloTags) {
    $this->aModeloTags = $aModeloTags;
  }
  
  public function setCodigoTagsSelecionados($aCodigoTagsSelecionados) {
    $this->aCodigoTagsSelecionados = $aCodigoTagsSelecionados;
  }
  
  public function carregarDadosPost() {
    $this->setAutor($this->oUtil->anti_sql_injection($_POST['CMPautor']));
    $this->setFrase($this->oUtil->anti_sql_injection($_POST['CMPfrase']));
    $this->setCodigoTagsSelecionados(isset($_POST['CMPtag']) ? $_POST['CMPtag'] : array());
  }
}