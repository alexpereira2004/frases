<?php
include_once 'class.modelo.php';
class model_Mensagem_Agenda extends Modelo{

  protected $id_agendamento;
  protected $tx_mensagem;
  protected $cd_tipo;
  protected $dt_apresentacao;
  protected $status;
  protected $nm_autor;
  protected $tx_descricao;
  protected $id_mensagem;
  protected $aNomesTagsRelacionadas;

}