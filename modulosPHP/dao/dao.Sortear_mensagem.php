<?php

include_once './modulosPHP/dao/dao.agendamento.php';

class Sortear_mensagem extends agendamento {

  public function listarMensagensOrdenadasPorUtilizacao() {
      $sQuery = "SELECT m.id , count(a.id_mensagem) as qnt_ja_usada
                   FROM mensagem m
              LEFT JOIN agendamento a on ( 	m.id = a.id_mensagem 
                                            AND a.dt_apresentacao between '2016-01-01' and '2016-12-31')
               GROUP BY m.id
               ORDER BY count(a.id_mensagem) ";

      $mResultado = $this->oBd->query($sQuery);

      if (!is_array($mResultado)) {
        $this->aMsg = $this->oBd->getMsg();
        return false;
      }
      
      $this->iLinhas = $this->oBd->getNumeroLinhas();

      for ($i= 0; $i < $this->iLinhas; $i++) { 
        $aMensagens[$mResultado[$i]['qnt_ja_usada']][] = $mResultado[$i]['id'];
      }
      return $aMensagens;
  }
  
  public function agendarNovaMensagem($sNovaData, $iIdMensagem) {
    $sFiltro = "WHERE dt_apresentacao = '".$sNovaData."'";
    $this->listar($sFiltro);
    
    $this->DT_APRESENTACAO[0] = $sNovaData;
    $this->ID_MENSAGEM[0] = $iIdMensagem;

    if ($this->iLinhas > 0) {
      $this->editar($sFiltro);
    } else {
      $this->inserir();
    }
    
  }
  
  
  
  
  
}