<?php

include_once './modulosPHP/modelo/class.modelo.php';

class control_carregar_frases extends Modelo {
  
  private $oNegocio;
  private $oModelo;
  private $oVisao;
  private $oValidador;


  public function __construct() {

    
    $this->oModelo = new model_carregar_frases();
    $this->oNegocio = new business_carregar_frases();
    
    if (isset($_POST)) {
      if (isset($_POST['sAcao'])) {
        if ($_POST['sAcao'] == 'salvar') {
          
          try {
            $this->oModelo->carregarDadosPost();
  
            $aConteudoExtraido = $this->oNegocio->extrairFrasesDePaginasHtml($this->oModelo);
            
//            $this->oModelo = new model_carregar_frases();
            $this->oModelo->__set('aConteudoExtraido', $aConteudoExtraido);

            $this->oModelo->mAcaoResultado = 0;
            $this->oModelo->sAcaoMsg       = 'Analisar abaixo o resultado gerado'."\n".  implode("\n", $this->oNegocio->aUrl);
            
          } catch (Exception $exc) {
            $this->oModelo->mAcaoResultado = 2;
            $this->oModelo->sAcaoMsg       = 'Ocorreu algum problema ao gerar as frases';
          }

        }
      }
    }

    $this->oVisao  = new view_carregar_frases($this->oModelo);

  }
  
  public function getVisao() {
    return $this->oVisao;
  }
}
