<?php
class model_carregar_frases extends Modelo{
  protected $sUrls;
  protected $sPadrao;
  protected $aConteudoExtraido;

  public function __construct() {
    $this->oUtil = new wTools();
  }

  public function carregarDadosPost() {
    $this->__set('sUrls',$this->oUtil->anti_sql_injection($_POST['CMPurls']));
    $this->__set('sPadrao',$this->oUtil->anti_sql_injection($_POST['CMPpadrao']));
  }
}
