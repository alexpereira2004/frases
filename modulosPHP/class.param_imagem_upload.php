<?php
/**
 * Informações que servem para parametrizar o upload de imagens
 * 
 * @author Alex Lunardelli
 * @since  26/06/2015
 */

class param_imagem_upload {
  public $sPasta;
  public $iTamanho;
  public $sNovoNome;
  public $aExtensoes;
  public $bRenomear;
  public $iAltura;
  public $iLargura;
  public $aErros;
  
  public function __construct() {
    $this->sPasta     = '../comum/img/anunciantes/logotipo/logo_';
    $this->iTamanho   = 1048576;
    $this->sNovoNome  = '';
    $this->aExtensoes = array('jpg', 'png', 'gif', 'jpeg');
    $this->bRenomear  = false;
    $this->iAltura    = 500;
    $this->iLargura   = 400;
    $this->aErros     = array(  0 => 'Não houve erro',
                                1 => 'O arquivo no upload é maior do que o limite do PHP',
                                2 => 'O arquivo ultrapassa o limite de tamanho especifiado no HTML',
                                3 => 'O upload do arquivo foi feito parcialmente',
                                4 => 'Não foi feito o upload do arquivo');
 }
  
}
