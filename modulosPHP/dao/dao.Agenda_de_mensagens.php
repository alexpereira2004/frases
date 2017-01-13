<?php
include_once './modulosPHP/dao/dao.mensagem.php';
include_once './modulosPHP/modelo/model.Mensagem_Agenda.php';

class dao_Agenda_de_mensagens extends dao_mensagem {
  public function listarMensagemDoDia($sData) {
    $sSql = "SELECT a.id as id_agendamento,
		    tx_mensagem,
                    cd_tipo,
                    dt_apresentacao,
                    status,
                    nm_autor,
                    tx_descricao,
                    m.id as id_mensagem,
                    group_concat(t.nm_tag) as tags
               FROM agendamento a
	 INNER JOIN mensagem m on m.id = a.id_mensagem
          LEFT join autores au on au.id = m.id_autor
 	  LEFT JOIN mensagemxtag mxt on  mxt.id_mensagem = m.id
	  LEFT JOIN tags t on t.id = mxt.id_tag
              WHERE dt_apresentacao = '".$sData."'
           GROUP BY a.id,
                    tx_mensagem,
                    cd_tipo,
                    dt_apresentacao,
                    status,
                    nm_autor,
                    tx_descricao ,
                    m.id ";

      $mResultado = $this->oBd->query($sSql);

      $this->iLinhas = $this->oBd->getNumeroLinhas();
      
      if (!is_array($mResultado)) {
        $this->aMsg = $this->oBd->getMsg();
        return false;
      }

 
      for ($i= 0; $i < $this->iLinhas; $i++) {     
        $this->modelo = new model_Mensagem_Agenda();
        $this->modelo->id_agendamento  = $mResultado[$i]['id_agendamento'];
        $this->modelo->tx_mensagem     = $mResultado[$i]['tx_mensagem'];
        $this->modelo->cd_tipo         = $mResultado[$i]['cd_tipo'];
        $this->modelo->dt_apresentacao = $mResultado[$i]['dt_apresentacao'];
        $this->modelo->status          = $mResultado[$i]['status'];
        $this->modelo->nm_autor        = $mResultado[$i]['nm_autor'];
        $this->modelo->tx_descricao    = $mResultado[$i]['tx_descricao'];
        $this->modelo->id_mensagem     = $mResultado[$i]['id_mensagem'];
        $this->modelo->aNomesTagsRelacionadas  = (empty($mResultado[$i]['tags'])) ? '' : explode(',', $mResultado[$i]['tags']);
        $this->listModelo[] = $this->modelo;
      }
      
      return $this->listModelo;
  }
}
