<?php
/*    Criado por Lunacom Marketing Digital
 *
 *
 *

  Array de configura��o para o tratamento do upload
  $CFGaConfigUpload = array('sPasta'     => '../comum/img/anunciantes/logotipo/logo_',
                           'iTamanho'    => 1048576,
                           'aExtensoes'  => array('jpg', 'png', 'gif'),
                      'bNomeRandomico'   => false,
                           'aErrors'     => array( 0 => 'N�o houve erro',
                                                   1 => 'O arquivo no upload � maior do que o limite do PHP',
                                                   2 => 'O arquivo ultrapassa o limite de tamanho especifiado no HTML',
                                                   3 => 'O upload do arquivo foi feito parcialmente',
                                                   4 => 'N�o foi feito o upload do arquivo') );

  Estrutura de array de configura��o do formul�rio
  $oUpload->aConfig = array('sAction'  => 'modulosPHP/ajaxTrataUpload.php',  --- Arquivo respons�vel por tratar o upload
                            'sEstampa' => 'Imagem do logotipo',              --- Campo de texto que o usu�rio l� e identifica qual tipo de arquivo � recebido
                            'sAcao'    => 'salvarLogo',                      --- Usado para diferenciar formularios diversos dentro do arquivo de tratamento do upload
                            'sNome'    => 'CMPlogo' );                       --- Nome e id do campo na tabela apresentada na tela




 *
 *
 *
 *
 *
 *
 */
  include_once 'class.wTools.php';

  class upload {
    public $iCdMsg;
    public $sMsg;
    public $sResultado;
    public $aMsg;
    
    public $sNome;
    public $sNomeUpload;
    public $sExtensao;
    public $sTipo;
    public $sTmp_nome;
    public $iErro;
    public $sErro;
    public $bImagem;
    public $iTamanho;
    public $iLargura;
    public $iAltura;
    public $iTipoImagem;
    public $sTipoImagem;
    public $iBits;
    public $iCanais;
    public $sMime;
    
    private $bInfoCarregadas;
    private $bValidacao;


    public $aConfig = array();

    public function __construct($aConfigUpload) {
      $this->oUtil = new wTools();
      $this->aConfigUpload = $aConfigUpload;
    }
    
    /* upload::pegarInformacoes
     * 
     * Busca os dados do arquivo que ser� salvo permitindo que as informa��es
     * sejam salvas em banco de dados em uma classe externa.
     * 
     * @date 29/06/2015
     * @param  file    $aFile - Array de dados recebido de um campo do formul�rio.
     *                 Ex.: $aFile['CMPlogotipo']
     * @return true
     *
     */
    public function pegarInformacoes($aFile) {
      /* Debug Alex */
      print_r('<pre>');
      print_r("TESTE P 051");
      print_r($aFile);
      print_r('</pre>');      
      // Ainda n�o se sabe se � uma imagem
      $this->bImagem    = false;
      
      $aTipoErros = array( 0 => 'N�o houve erro',
                           1 => 'O arquivo no upload � maior do que o limite do PHP',
                           2 => 'O arquivo ultrapassa o limite de tamanho especifiado no HTML',
                           3 => 'O upload do arquivo foi feito parcialmente',
                           4 => 'N�o foi feito o upload do arquivo');
      
      $this->sNome      = $this->oUtil->anti_sql_injection($this->oUtil->retirarExtensao($aFile['name']));
      $this->sExtensao  = $this->oUtil->anti_sql_injection($this->oUtil->pegarExtensao($aFile['name']));
      $this->sTipo      = $this->oUtil->anti_sql_injection($aFile['type']);
      $this->sTmp_nome  = $this->oUtil->anti_sql_injection($aFile['tmp_name']);
      $this->iErro      = $this->oUtil->anti_sql_injection($aFile['error']);
      $this->sErro      = $this->oUtil->anti_sql_injection($aTipoErros[$aFile['error']]);
      $this->iTamanho   = $this->oUtil->anti_sql_injection($aFile['size']);

      if ($this->iErro === 0) {
        $aDimensoes = getimagesize($aFile["tmp_name"]);
        $aTipoImagem = array (  1 => 'GIF',
                                2 => 'JPG',
                                3 => 'PNG',
                                4 => 'SWF',
                                5 => 'PSD', 
                                6 => 'BMP',
                                7 => 'TIFF(intel byte order)', 
                                8 => 'TIFF(motorola byte order)', 
                                9 => 'JPC', 
                                10 => 'JP2', 
                                11 => 'JPX', 
                                12 => 'JB2', 
                                13 => 'SWC', 
                                14 => 'IFF', 
                                15 => 'WBMP',
                                16 => 'XBM' );
        $this->bImagem     = true;
        $this->iLargura    = $aDimensoes[0];
        $this->iAltura     = $aDimensoes[1];
        $this->iTipoImagem = $aDimensoes[2];
        $this->sTipoImagem = $aTipoImagem[$aDimensoes[2]];
        $this->iBits       = $aDimensoes['bits'];

        $this->sMime       = $aDimensoes['mime'];
      }
      


      return true;
    }
    
    /* upload::pegarInformacoes
     * 
     * Separa a valida��o da imagem permitindo que antes de qualquer intera��o
     * o sistema tenha condi��o de determinar se o upload ser� realizado.
     * 
     * @date 29/06/2015
     * @param  $this->aConfigUpload Par�metros da valida��o
     * @return bool
     *
     */
    public function validar($aArquivo) {
      
      $this->pegarInformacoes($aArquivo);
      
      if($this->sNome == ''){
        $this->aMsg    = array('iCdMsg' => 2, 
                                 'sMsg' => "Por favor, selecione uma figura", 
                             'sMsgErro' => '',
                           'sResultado' => 'erro');
        return false;
      }
      
      if ($this->iTamanho > $this->aConfigUpload['iTamanho']) {
        $this->aMsg    = array('iCdMsg' => 1, 
                                 'sMsg' => 'O tamanho da imagem ('.round(($aArquivo["size"] / 1024),2).'KB) � maior que o permitido ('.round(($this->aConfigUpload['iTamanho'] / 1024), 2).'KB).',
                             'sMsgErro' => '',
                           'sResultado' => 'erro');
        return false;
      }
      
      if ($this->iLargura > $this->aConfigUpload['iLargura'] || $this->iAltura > $this->aConfigUpload['iAltura']) {
        $this->aMsg    = array('iCdMsg' => 1, 
                                 'sMsg' => 'Insira uma imagem de no m�ximo '.$this->aConfigUpload['iLargura'].' x '.$this->aConfigUpload['iAltura'].' pixels',
                             'sMsgErro' => '',
                           'sResultado' => 'erro');
        return false;
      }

      if (array_search($this->sExtensao, $this->aConfigUpload['aExtensoes']) === false) {
        $this->aMsg    = array('iCdMsg' => 1, 
                                 'sMsg' => "Por favor, envie arquivos com as seguintes extens�es: ".  implode(',', $this->aConfigUpload['aExtensoes']),
                             'sMsgErro' => '',
                           'sResultado' => 'erro');
        return false;
      }
      if ($this->iErro != 0){
        $this->aMsg    = array('iCdMsg' => 2, 
                                 'sMsg' => $this->sErro, 
                             'sMsgErro' => '',
                           'sResultado' => 'erro');
        return false;
      }
      return true;
    }

    /* upload::formEnvio
     *
     * Escreve o formul�rio que o usu�rio utiliza para fazer o upload do arquivo
     * @date 23/08/2011
     * @param  file    $oFiles          - Array de dados recebido de um campo do formul�rio. Ex.: $oFiles['CMPlogotipo']
     * @param  array $aInputAdicional - Possibilidade de adicionar ao formul�rio novos campos 
     *                                  espec�ficos para entrada de dados.
     *                                  O tipo de campo "select" � aceito
     *                                  Exemplo de array para um campo extra do tipo select:
     *   $aInputAdicional = array( array( 'type' => 'select',
                                  'value' => 'teste',
                                   'name' => 'CMPcd_tipo',
                                  'label' => 'Tipo da imagem',
                 
                       // Valores adicionais para select
                           'aDadosSelect' => $aValores,
                     'aDadosSelectPadrao' => 'PR' )
                          );
     * 
     * 
     * @return true
     *
     */
    public function formEnvio($iId, $bBtPadrao = false, $sParamListagem ='', $sCampoDescricao = '', $sClasse = 'FRMtrataImagens', $aInputAdicional = '') {
      ?>
      <form action="<?php echo $this->aConfig['sAction']; ?>" id="<?php echo $this->aConfig['sIdForm']; ?>" <?php echo ($sClasse != '' ? 'class = "'.$sClasse.'"' : '')?> method="post" enctype="multipart/form-data" style="font-family: Helvetica, sans-serif;">
        <table>
          <tr>
            <td class="infoheader"><?php echo $this->aConfig['sEstampa'];?></td>
            <td>
              <input type="hidden" name="sAcao" value="<?php echo $this->aConfig['sAcao'];?>" />
              <input type="hidden" name="CMPid" value="<?php echo $iId;?>" />
              <input type="file" class="campo_f" name="<?php echo $this->aConfig['sNome'];?>" value="Buscar" title="Buscar"/>
            </td>
          </tr>
          <?php
            if($sCampoDescricao != '') { ?>
              <tr>
                <td class="infoheader"><?php echo $sCampoDescricao; ?></td>
                <td><input class="w08" type="text" name="CMPdescricao" value="" /></td>
              </tr>

              <?php
            }
            
            if (is_array($aInputAdicional)) {

              foreach ($aInputAdicional as $aDados) { 
                
                if ($aDados['type'] == 'select') { ?>
                  <tr>
                    <td class="infoheader"><?php echo $aDados['label']; ?></td>
                    <td><?php $this->oUtil->montaSelect($aDados['name'], $aDados['aDadosSelect'], $aDados['aDadosSelectPadrao']); ?></td>
                  </tr>
                <?php
                  continue;
                } ?>

              <tr>
                <td class="infoheader"><?php echo $aDados['label']; ?></td>
                <td><input class="w08" type="<?php echo $aDados['type']; ?>" name="<?php echo $aDados['name']; ?>" value="<?php echo $aDados['value']; ?>" /></td>
              </tr>
              <?php
              }
            }
          ?>
          <tr>
            <td>&nbsp;</td>
            <td>
              <?php
                if($bBtPadrao) { ?>
                  <input type="submit" value="Enviar Imagem" class="bt_salvar" />
                  <?php
                } else { ?>
                  <img id="submit_<?php echo $this->aConfig['sIdForm']; ?>" class="bt_link" src="../comum/img/estrutura/icon_add01.png" alt="Adicionar Arquivo" />
                  <?php
                }
              ?>
            </td>
          </tr>

            
        </table>
      </form>

      
    <?php

    }

    /* upload::uploadArquivos
     *
     * Upload de arquivos
     * @date 23/08/2011
     * @param  file    $oFiles          - Array de dados recebido de um campo do formul�rio. Ex.: $oFiles['CMPlogotipo']
     * @param  array   $$this->aConfigUpload  - Dados de configura��es de mensagens, formato dos arquivos, tamanho, pasta a ser salva etc.
     * @param  integer $iTamMax         - Tamanho m�ximo do arquivo em MB
     * @param  array   $aExtensoes      - Contem as extensoes de arquivos aceitos para upload
     * @param  bool    $bRenomear       - Renomear arquivo com nome aleat�rio
     * @return true
     *
     */
    public function uploadArquivos($oFiles){
 
      // Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
      if ($oFiles['error'] != 0) {
        die("N�o foi poss�vel fazer o upload, erro:<br />" . $this->aConfigUpload['erros'][$oFiles['arquivo']['error']]);
        exit; // Para a execu��o do script
      }

      

      // Caso script chegue a esse ponto, n�o houve erro com o upload e o PHP pode continuar

      // Faz a verifica��o da extens�o do arquivo
      $sExtensao = strtolower(end(explode('.', $oFiles['name'])));
      if (array_search($sExtensao, $this->aConfigUpload['extensoes']) === false) {
        echo "Por favor, envie arquivos com as seguintes extens�es: ";
      }

      // Faz a verifica��o do tamanho do arquivo
      else if ($this->aConfigUpload['tamanho'] < $oFiles['size']) {
        echo "O arquivo enviado � muito grande, envie arquivos de at� $iTamMax.";

      // O arquivo passou em todas as verifica��es, hora de tentar mov�-lo para a pasta
      } else {

        // Primeiro verifica se deve trocar o nome do arquivo
        if ($this->aConfigUpload['renomeia'] == true) {
        // Cria um nome baseado no UNIX TIMESTAMP atual e com extens�o .jpg
        $nome_final = time().'.jpg';
        } else {

        // Mant�m o nome original do arquivo
        $nome_final = str_replace(' ', '', $oFiles['name']);
        }

        // Depois verifica se � poss�vel mover o arquivo para a pasta escolhida
        if (move_uploaded_file($oFiles['tmp_name'], $this->aConfigUpload['pasta'] . $nome_final)) {
          // Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
          $sRet  = "Upload efetuado com sucesso!";
          $sRet .= '<br /><a href="' . $this->aConfigUpload['pasta'] . $nome_final . '">Clique aqui para acessar o arquivo</a>';
          $bRet = true;
        } else {
          // N�o foi poss�vel fazer o upload, provavelmente a pasta est� incorreta
          $sRet = "N�o foi poss�vel enviar o arquivo, tente novamente";
          $bRet = false;
        }
        return $bRet;
      }
    }

    /* upload::enviaImg
     *
     * Upload de imagens
     * @date 03/09/2011
     * @param  file    $oFiles          - Array de dados recebido de um campo do formul�rio. Ex.: $oFiles['CMPlogotipo']
     * @param  array   $$this->aConfigUpload  - Dados de configura��es de mensagens, formato dos arquivos, tamanho, pasta a ser salva etc.     
     * @return true
     *
     */
    public function enviarImagem($aArquivo){

      if (!$this->validar($aArquivo)) {
        return false;
      }

      $this->sNomeUpload = '';

      // Gera um nome para a imagem
      if ($this->aConfigUpload['bNomeRandomico'] === true) {
        $this->sNomeUpload = md5(uniqid(time())) . "." .$this->sExtensao;
      } else {
        $this->sNomeUpload = $this->aConfigUpload['sNovoNome'].'.'.$this->sExtensao;
      }              

      // Caminho de onde a imagem ficar�
      $imagem_dir = $this->aConfigUpload['sPasta'] . $this->sNomeUpload;

      // Faz o upload da imagem
      move_uploaded_file($aArquivo["tmp_name"], $imagem_dir);

      //Mensagem de sucesso
      $this->aMsg    = array('iCdMsg' => 0, 
                               'sMsg' => 'Sua foto foi enviada com sucesso!',
                           'sMsgErro' => '',
                         'sResultado' => '');
      $this->sNomeUpload;
      return true;

    }

    function remover($arquivo,$local){

      #Testa para ver se existe arquivo
      if($arquivo == ''){
        return;
      }
      $deletar = $local.$arquivo;
      unlink($deletar);
    }



  }


?>
