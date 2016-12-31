<?php
include 'class.modelo.php';
class model_nova_frase extends Modelo{
  public $sAutor;
  public $sFrase;
  public $aModeloTags;
  public $aCodigoTagsSelecionados;
  public $oTags;
  
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
}