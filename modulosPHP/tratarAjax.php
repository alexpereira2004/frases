<?php
  session_start();
  header("Content-Type: text/html; charset=ISO-8859-1",true);
  
  // Classes obrigatórias
  include_once 'class.wTools.php';
  include_once 'class.config.php';
  include_once 'class.conexao.php';

  $oUtil   = new wTools();
  $oConfig = new config($oUtil->buscarNomePaginaAtual());
  $oBd     = new conexao();
  
  // Classes de negócio
  include_once 'adapter.contratos.php';

  

  if(isset($_POST['sAcao'])) {
    

    switch ($_POST['sAcao']) {
      
      
      /************************************************************************
        Calculo automatico de parcelas
      *************************************************************************/
      case 'gerarParcelas':

	$oContratos = new contratos();
	$aDados = array (
	  'sTotal'	   => $_POST['sTotal'],
	  'iCtr'	   => $_POST['iCtr'],
	  'iNeg'	   => $_POST['iNeg'],
	  'iQntParcelas'   => $_POST['iQntParcelas'],
	  'sPriVencimento' => $_POST['sPriVencimento'],
	  'iPeriodicidade' => $_POST['iPeriodicidade'],
	);

	$oConfig->incluirJs();
	$oContratos->gerarParcelasAutomaticamente($aDados);
	
	break;
    }
  }