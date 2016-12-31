<?php
include_once '../modulosPHP/class.wTools.php';
/**
 * Utilizar as view chamando através desta clase
 *
 * @author Alex
 */
class view_admin {
  
  private $sPgAtual;
  private $oUtil;

  public function __construct($sPgAtual = '') {
    $this->sPgAtual = $sPgAtual;
    $this->oUtil = new wTools();
  }
  
  public function incluirCss() { ?>
      <link href="../comum/estilos_admin.css" media="all" rel="stylesheet" type="text/css" /> <?php

//      $aParam = $this->oUtil->buscarParametro('CSS_PADRAO');
      $aParam['CSS_PADRAO'][0] = 'skin1';
      $aParam['CSS_PADRAO'][0] = 'skin2';
      $aParam['CSS_PADRAO'][0] = 'skin3';
      $aParam['CSS_PADRAO'][0] = 'simpla-admin';
      

      switch ($aParam['CSS_PADRAO'][0]) {
        case 'skin1':
          echo '<link href="../comum/skin_facebook.css" media="all" rel="stylesheet" type="text/css" />';
          break;

        case 'skin2':
          echo '<link href="../comum/skin_2.css" media="all" rel="stylesheet" type="text/css" />';
          break;

        case 'skin3':
          echo '<link href="../comum/skin-mercado-dos-sabores.css" media="all" rel="stylesheet" type="text/css" />';
          break;
      
        case 'simpla-admin':
          echo '<link href="../comum/skin-simpla-admin.css" media="all" rel="stylesheet" type="text/css" />';
          break;
      
        default :
          echo '<link href="../comum/skin_facebook.css" media="all" rel="stylesheet" type="text/css" />';
          break;
      }

    
  }
  
  public function incluirJs() {?>
    <script src="../modulosJS/jquery-2.1.3.min.js"	   type="text/javascript"></script>
    <script src="../modulosJS/util.js"	   type="text/javascript"></script>

    <!-- Paginador -->
    <script src="../modulosJS/tableSorter/js/jquery.dataTables.js" type="text/javascript" ></script>
    <link href="../modulosJS/tableSorter/css/jquery.dataTables.css" media="all" rel="stylesheet"  type="text/css" />

    <link href="../modulosJS/filereader.js" type="text/javascript" ></script>

    <script type="text/javascript">
      $(document).ready(function() {
        $('.dataTable').dataTable({
          "iDisplayLength": 10
        });
      });
    </script>
      
    <?php
  }
  
  public function cabecalho() { ?>
      <div id="cabecalho">
        <h2>Administratção Deportivo Bravo FC</h2>
        <a href="logout.php">Logout</a> | <a href="<?php echo $this->oUtil->sUrlBase; ?>">ir ao site</a>
      </div> <?php 
  }
  
  public function montarMenu() { ?>
    <div id="menu" style="z-index: 1000; position: relative"> <?php
      $CFGpath = '';
      $this->oUtil->montarLink('Notícias', 'painel/admin-noticias.php',$CFGpath, true);
      echo ' | ';
      $this->oUtil->montarLink('Sede', 'painel/admin-sede.php',$CFGpath, true);
      echo ' | ';
      $this->oUtil->montarLink('História', 'painel/admin-historia.php',$CFGpath, true);
      echo ' | ';
      $this->oUtil->montarLink('Estatuto', 'painel/admin-estatuto.php',$CFGpath, true);
      echo ' | ';
      $this->oUtil->montarLink('Contatos', 'painel/admin-contatos.php',$CFGpath, true);
      echo ' | ';
      $this->oUtil->montarLink('Usuários', 'painel/admin-usuarios.php',$CFGpath, true);
      echo ' | ';
      $this->oUtil->montarLink('Vitrine', 'painel/admin-vitrine.php',$CFGpath, true);
      echo ' | ';
      $this->oUtil->montarLink('Parâmetros', 'painel/admin-parametros.php',$CFGpath, true);
      echo ' | ';
      $this->oUtil->montarLink('Página', 'painel/admin-pagina.php',$CFGpath, true);
      echo ' | ';
      $this->oUtil->montarLink('Imagens', 'painel/admin-imagens.php',$CFGpath, true);
?>
    </div> <?php
    
  }

  public function rodape() {
    
  }
}
  