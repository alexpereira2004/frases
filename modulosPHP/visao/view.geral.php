<?php

include_once 'modulosPHP/class.wTools.php';

abstract class view_geral {
  
  protected $oUtil;
  protected $sPgAtual;
  protected $oConfig;

  public function __construct() {
    $this->oUtil = new wTools();
    $this->sPgAtual = $this->oUtil->buscarNomePaginaAtual();
    $this->oConfig = new config($this->oUtil->buscarNomePaginaAtual());
  }
  
  public function metaTags() {
      include_once 'modulosPHP/class.config.php';
    ?>
    <title>Frases</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <?php
    
  }
  public function incluirCss() {
    
  }
  public function incluirJs() {
  }

  public function cabecalho() { ?>
<!--    <div id="cabecalho">
      <img id="logo" src="comum/imagens/estrutura/Logo-Deportivo-Bravo.png" alt="Logo-Deportivo-Bravo" />  
    </div>-->
    <?php
    
  }
  
  public function montarMenu() {?>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav nav">
            <li><a href="nova-frase">Adicionar Frases</a></li>
            <li><a href="carregar-frases">Carregar Frases</a></li>
        </ul>
    </div><?php
  }
  
  public function montarCorpoConteudo() {
    
  }


  public function rodape() { ?>
    <?php
//        $this->oUtil->montarLink('Principal'  , 'index.php');
//        $this->oUtil->montarLink('Notícias'   , 'noticias.php');
//        $this->oUtil->montarLink('Campeonatos', 'campeonatos.php');
//        $this->oUtil->montarLink('Sede'       , 'sede.php');
//        $this->oUtil->montarLink('Estatuto'   , 'estatuto.php');
//        $this->oUtil->montarLink('História'   , 'historia.php');
//        $this->oUtil->montarLink('Contato'    , 'contato.php'); 
//        echo '<br /><br />';
//        $this->oUtil->montarLink('Desenvolvido por Lunacom'    , 'www.lunacom.com.br','http://',true,'desenvolvedor');
         
  }
  
  public function analytics() {
  }
  
  public function montarMensagemUsuario() {
    
    $aConfiguracoesMensagens = array(
        0 => 'alert alert-success',
        1 => 'alert alert-info',
        2 => 'alert alert-warning',
        3 => 'alert alert-danger',
                    
    ); ?>

    <div class="<?php echo $aConfiguracoesMensagens[$this->oModel->mAcaoResultado]; ?>" role="alert">
      <a href="<?php echo $this->oModel->sAcaoLink; ?>" class="alert-link"><?php echo $this->oModel->sAcaoMsg; ?></a>
    </div>

      <?php
  }
}
