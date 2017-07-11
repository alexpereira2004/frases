<?php
namespace Biblioteca;
use Exception;

class wTools {

  public $sErro;
  public $aParametros;
  public $CFGpath;
  public $sUrlBase;
  public $aMsg = array('mResultado' => '',
                        'sMsg' => '',
                        'sMsgErro' => '');
  protected $const = false;
  public $RETDB = array();
  public $aPastas = array();
  public $aArquivos = array();

  public function __construct() {
    include_once 'class.conexao.php';
//    $this->oBd = new conexao();
    $this->pathImagens = 'imagens/ilustrativas/';

    $this->sUrlBase = $this->retornarTrueSeEhDesenv() ? 'http://localhost/Frases/branches/1_1_4' : 'http://www.caixinhademensagens.com.br';
  }

  /* wTools::aspas
   *
   * Coloca em destaque um texto relevante com uma imagem de aspas
   * @date 07/10/2010
   *
   */

  public function aspas($sFrase) {
    ?>
    <p class="destaque-aspas">
      <img src="quote.gif" alt="quote" />
      <?php echo $sFrase ?>
    </p>
    <?php
  }

  /* wTools::subLinguagem
   * Recebe o texto de um editor contendo TAGs genéricas. Estas TAGs transforam
   * seu conteúdo de forma como definida nos arrays.
   *
   * @param  $sConteudo                  - Conteudo a ser transformado
   * @return $this->ConteudoTransformado - Conteudo Transformado
   *
   * $aProcuraPor = array (abertura da tag da sub linguagem,
   *                       fechamento da tag da sub linguagem)
   *
   * $TrocaPor = array(abertura da tag em HTML,
    fechamento da tag em HTML)
   *
   * @date 09/10/2010
   *
   * TAGs CRIADAS - FUNCAO:
   *
   * <aspas> </aspas> - Adiciona o texto de uma forma formatada. Da destaque a uma observação ou citação importante no contexto do assunto.
   *
   */

  public function subLinguagem($sConteudo) {
    $aProcuraPor = array('&lt;aspas&gt;',
        '&lt;/aspas&gt;',
        '&lt;ver&gt;',
        '&lt;/ver&gt;'
    );
    $aTrocaPor = array('<div class="destaque-aspas"><img src="' . $this->pathImagens . 'quote.gif" alt="quote" />',
        '</div>',
        '<span style="color:#F00">',
        '</span>'
    );


    $sConteudo = str_replace($aProcuraPor, $aTrocaPor, $sConteudo);

    $this->ConteudoTransformado = $sConteudo;

    return $this->ConteudoTransformado;
  }

  /* wTools::novoComentario
   * Adiciona um comentario. Utilizado para paginas como noticias ou artigos.
   *
   * CSS
   *  - class="comentario-post"
   *  - class="titulo"
   *
   * @param  $sAction           - Documento que trata o formulario  
   * @param  $sNomeForm         - Nome do formulario
   * @param  $iRelacionamento   - Valor de um ID ao qual o comentario ira pertencer
   * @param  $sVarDestinoOpc    - Variavel opcional para o tratamento dos dados
   * @param  $sScriptValidacao  - Script para validação do formulario
   * @param  $sTitComentario    - Frase que fica no titulo que fica no topo do formulario
   * @return null
   *
   * @date 14/10/2010
   */

  public function novoComentario($sAction, $sNomeForm, $iRelacionamento, $sVarDestinoOpc, $sScriptValidacao = '', $sTitComentario = 'Deixe o seu comentário! ') {
    ?>
    <div class="comentario-post">
      <h3 class="titulo"><?php echo $sTitComentario; ?></h3>
      <form action="<?php echo $sAction ?>" name="<?php echo $sNomeForm ?>" method="POST" <?php echo $sScriptValidacao ? 'onSubmit="return ' . $sScriptValidacao . '"' : '' ?> >
        <table width="435" border="0">
          <tr>
            <td>
              <input type="text" name="FRMcoment_autor" value="Nome" tabindex="1" class="FRM_coment" onblur="if (this.value == '') {
                    this.value = 'Nome';
                  }" onfocus="if (this.value == 'Nome') {
                        this.value = '';
                      }" />
            </td>
          </tr>
          <tr>
            <td>
              <input type="text" name="FRMcoment_email" value="Email" tabindex="1" class="FRM_coment" onblur="if (this.value == '') {
                    this.value = 'Email';
                  }" onfocus="if (this.value == 'Email') {
                        this.value = '';
                      }" />
            </td>
          </tr>
          <tr>
            <td>
              <input type="text" name="FRMcoment_site" value="http://www.lunacom.com.br" tabindex="1" class="FRM_coment" onblur="if (this.value == '') {
                    this.value = 'http://www.lunacom.com.br';
                  }" onfocus="if (this.value == 'http://www.lunacom.com.br') {
                        this.value = '';
                      }" />
            </td>
          </tr>
          <tr>
            <td>
              <textarea name="FRM_comentario" rows="8" cols="10" tabindex="4" class="FRM_textarea" onfocus="if (this.value == 'Seu Comentário...') {
                    this.value = '';
                  }" onblur="if (this.value == '') {
                        this.value = 'Seu Comentário...';
                      }">Seu Comentário...</textarea>
            </td>
          </tr>
          <tr>
            <td>
              <input type="hidden" name="sAcao" value="<?php echo $sVarDestinoOpc ?>" />
              <input type="hidden" name="id_relacionamento" value="<?php echo $iRelacionamento ?>"  />
              <input type="submit" value="Enviar" />
            </td>
          </tr>
        </table>
      </form>
    </div>
    <?PHP
  }

  /* wTools::anti_sql_injection
   *
   * Coloca em destaque um texto relevante com uma imagem de aspas
   * @date 23/10/2010
   * @param  string $sStr - String a ser analisada
   * @return string $sStr - String pronta
   */

  public function anti_sql_injection($sStr) {
    if (!is_numeric($sStr)) {
      $sStr = get_magic_quotes_gpc() ? stripslashes($sStr) : $sStr;
//      $sStr = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($sStr) : mysql_escape_string($sStr);
//      $sStr = mysqli_real_escape_string($sStr);
    }
    return $sStr;
  }

  /* wTools::nomeMes
   *
   * Traz o nome do mês em Portugues
   * @date 31/10/2010
   * @param  integer $iMes    - Numero do mes a ser testado
   * @return string $sNomeMes - Nome do mes em portugues
   */

  public function nomeMes($iMes) {

    switch ($iMes) {
      case 01: $sNomeMes = 'Janeiro';
        break;
      case 02: $sNomeMes = 'Fevereiro';
        break;
      case 03: $sNomeMes = 'Mar&ccedil;o';
        break;
      case 04: $sNomeMes = 'Abril';
        break;
      case 05: $sNomeMes = 'Maio';
        break;
      case 06: $sNomeMes = 'Junho';
        break;
      case 07: $sNomeMes = 'Julho';
        break;
      case 08: $sNomeMes = 'Agosto';
        break;
      case 09: $sNomeMes = 'Setembro';
        break;
      case 10: $sNomeMes = 'Outubro';
        break;
      case 11: $sNomeMes = 'Novembro';
        break;
      case 12: $sNomeMes = 'Dezembro';
        break;
      default: $sNomeMes = '';
    }
    return $sNomeMes;
  }

  /*    IMPLEMENTAR
   *
   *  wTools::novoForm
   * Adiciona um comentario. Utilizado para paginas como noticias ou artigos.
   *
   * CSS
   *  - class="formNomeInterno"
   *  - class="titulo"
   *
   * @param  $sAction           - Documento que trata o formulario
   * @param  $sNomeForm         - Nome do formulario
   * @param  $sNomeForm         - Array contando os campos que deverao ser exibidos
   * @param  $iRelacionamento   - Valor de um ID ao qual o comentario ira pertencer
   * @param  $sVarDestinoOpc    - Variavel opcional para o tratamento dos dados
   * @param  $sScriptValidacao  - Script para validação do formulario
   * @param  $sTitComentario    - Frase que fica no titulo que fica no topo do formulario
   * @return null
   *
   * @date 14/10/2010
   */
  /*
    public function formNomeInterno($sAction, $sNomeForm, $aConfig = '', $iRelacionamento, $sVarDestinoOpc, $sScriptValidacao = '', $sTitForm = '') {




    ?>
    <div class="formNomeInterno">
    <h3 class="titulo"><?php echo $sTitForm ?></h3>
    <form action="<?php echo $sAction ?>" name="<?php echo $sNomeForm ?>" method="post" <?php echo $sScriptValidacao ? 'onSubmit="return '.$sScriptValidacao.'"' : '' ?> >
    <table width="435" border="0">
    <?php if(isset($aConfig['nome'])) {?>
    <tr>
    <td>
    <input type="text" name="FRMcoment_autor" value="Nome" tabindex="1" class="FRM_coment" onblur="if (this.value == ''){this.value = 'Nome';}" onfocus="if (this.value == 'Nome') {this.value = '';}" />
    </td>
    </tr>
    <?php } ?>
    <tr>
    <td>
    <input type="text" name="FRMcoment_email" value="Email" tabindex="1" class="FRM_coment" onblur="if (this.value == ''){this.value = 'Email';}" onfocus="if (this.value == 'Email') {this.value = '';}" />
    </td>
    </tr>
    <tr>
    <td>
    <input type="text" name="FRMcoment_site" value="http://www.lunacom.com.br" tabindex="1" class="FRM_coment" onblur="if (this.value == ''){this.value = 'http://www.lunacom.com.br';}" onfocus="if (this.value == 'http://www.lunacom.com.br') {this.value = '';}" />
    </td>
    </tr>
    <tr>
    <td>
    <textarea name="FRM_comentario" rows="8" cols="10" tabindex="4" class="FRM_textarea" onfocus="if (this.value == 'Seu Comentário...') {this.value='';}" onblur="if (this.value == ''){this.value = 'Seu Comentário...';}">Seu Comentário...</textarea>
    </td>
    </tr>
    <tr>
    <td>
    <input type="hidden" name="funcao" value="<?php echo $sVarDestinoOpc ?>" />
    <input type="hidden" name="id_relacionamento" value="<?php echo $iRelacionamento ?>"  />
    <input type="submit" value="Enviar" />
    </td>
    </tr>
    </table>
    </form>
    </div>
    <?PHP

    }

   */

  /* wTools::paginador
   * V2.0
   *
   * @date 14/08/2012
   * @param int    $iPgAtual         - Recebe o ID da pagina atual
   * @param string $sUrl             - Recebe um endereço onde vai ser colocado um ID ex.: '<a class="paginacao" href="index.php?sec=noticias&ind=' ;
   * @param string $sUrlAtual        - Recebe um endereco onde vai ser colocado o ID, igual ao item 2, porem tem uma classe diferente para ser usada e
   *                                   diferenciar a página atual.
   *                                   ex.: ' <a class="sPgAtual" href="index.php?sec=noticias&ind= ';   *
   * @param string $sQuery           - Faz a consulta no banco de dados para saber o total de linhas que uma tabela tem
   *                          	       ex.: SELECT COUNT(id_noticia) FROM noticias WHERE ativa = 1
   * @param int    $iQnt             - Quantidade de linhas por página
   * @param string $sRedir           - Local para qual o paginador vai apontar em caso de erro
   *
   * @return int $iNumPaginas        - Retorna o numero total de dados no banco
   */

  public function paginador($iPgAtual, $sUrl, $sTabela, $sFiltro, $iQntItens = '10', $sRedir = '') {

    $sUrl = '<span><a href=' . $sUrl;
    $sUrlAtual = $sUrl;

    $sQuery = 'SELECT count(1) FROM ' . $sTabela . $sFiltro;
    $this->buscarInfoDB($sQuery);
    $iNumRows = $this->RETDB[0][0];
    $iNumPaginas = ceil($iNumRows / $iQntItens);

    $pg_ultima = $iNumPaginas;

    // A página atual que vem pela URL não pode ser um numero maior do que a quantidade de páginas que realmente existe    
    if ($iPgAtual > $iNumPaginas) {
      header('Location:' . $sRedir);
      exit;
    }

    if ($iNumPaginas == 1) {
      return $iNumPaginas;
    }
    #escreve -- PRIMEIRA -- sempre vai ter o indice = 1
    echo $sUrl . '1  > Primeira </a></span>&nbsp;';

    if ($iPgAtual == 1) {
      echo $sUrlAtual . $iPgAtual . ' class="selecionada" > ' . $iPgAtual . ' </a></span>&nbsp;';
      echo $sUrl . '2  > 2 </a></span>&nbsp; ';
      if ($pg_ultima >= 3)
        echo $sUrl . '3  > 3 </a></span>&nbsp; ';
      if ($pg_ultima >= 4)
        echo $sUrl . '4  > 4 </a></span>&nbsp; ';
      if ($pg_ultima >= 5)
        echo $sUrl . '5  > 5 </a></span>&nbsp; ';
    }elseif ($iPgAtual == 2) {
      echo $sUrl . '1  > 1 </a></span>&nbsp; ';
      echo $sUrlAtual . $iPgAtual . ' class="selecionada" >' . $iPgAtual . ' </a></span>&nbsp;';
      if ($pg_ultima >= 3)
        echo $sUrl . '3  > 3 </a></span>&nbsp; ';
      if ($pg_ultima >= 4)
        echo $sUrl . '4  > 4 </a></span>&nbsp; ';
      if ($pg_ultima >= 5)
        echo $sUrl . '5  > 5 </a></span>&nbsp; ';
    }elseif ($iPgAtual == ($iNumPaginas - 1)) {
      if (($iPgAtual - 3) > 0)
        echo $sUrl . ($iPgAtual - 3) . ' > ' . ($iPgAtual - 3) . ' </a></span>&nbsp;';
      if (($iPgAtual - 2) > 0)
        echo $sUrl . ($iPgAtual - 2) . ' > ' . ($iPgAtual - 2) . ' </a></span>&nbsp;';
      echo $sUrl . ($iPgAtual - 1) . ' > ' . ($iPgAtual - 1) . ' </a></span>&nbsp; ';
      echo $sUrlAtual . $iPgAtual . ' class="selecionada" > ' . $iPgAtual . ' </a></span>&nbsp;';
      echo $sUrl . ($iPgAtual + 1) . ' > ' . ($iPgAtual + 1) . ' </a></span>&nbsp;';
    }elseif ($iPgAtual == $iNumPaginas) {
      if (($iPgAtual - 4) > 0)
        echo $sUrl . ($iPgAtual - 4) . ' > ' . ($iPgAtual - 4) . ' </a></span>&nbsp;';
      if (($iPgAtual - 3) > 0)
        echo $sUrl . ($iPgAtual - 3) . ' > ' . ($iPgAtual - 3) . ' </a></span>&nbsp;';
      echo $sUrl . ($iPgAtual - 2) . ' > ' . ($iPgAtual - 2) . ' </a></span>&nbsp;';
      echo $sUrl . ($iPgAtual - 1) . ' > ' . ($iPgAtual - 1) . ' </a></span>&nbsp; ';
      echo $sUrlAtual . $iPgAtual . ' class="selecionada" > ' . $iPgAtual . ' </a></span>&nbsp;';
    }else {
      echo $sUrl . ($iPgAtual - 2) . ' > ' . ($iPgAtual - 2) . ' </a></span>&nbsp;';
      echo $sUrl . ($iPgAtual - 1) . ' > ' . ($iPgAtual - 1) . ' </a></span>&nbsp; ';
      echo $sUrlAtual . $iPgAtual . ' class="selecionada"> ' . $iPgAtual . ' </a></span>&nbsp;';
      if ($pg_ultima >= ($iPgAtual + 1))
        echo $sUrl . ($iPgAtual + 1) . ' > ' . ($iPgAtual + 1) . ' </a></span>&nbsp;';
      if ($pg_ultima >= ($iPgAtual + 2))
        echo $sUrl . ($iPgAtual + 2) . ' > ' . ($iPgAtual + 2) . ' </a></span>&nbsp; ';
    }

    #escreve -- ÚLTIMA -- sempre vai ter o indice = ultima pagina
    echo $sUrl . $pg_ultima . ' > Última </a></span>&nbsp;';


    return $iNumPaginas;
  }

  /* wTools::validarIndexPaginacao
   *
   * Evita que o usuário digite um numero de páginas superior ao que realmente
   * existe no sistema quando é utilizado o paginador
   * @date 18/12/2012
   * @param  int    $iPgAtual          - Vem geralmente da variável $_GET['n'] da paginação.
   *                                     Número da paginação atual que esta visivel da url
   * @param  int    $iQntItensListagem - Quantidade de itens listados por página
   * @param  string $sPgRetEmErro      - Página em que será direcionado em caso de erro
   * @param  string $sTbPaginacao      - Tabela paginacao
   * @return true em caso de suceeso
   */

  public function validarIndexPaginacao($iPgAtual, $iQntItensListagem, $sPgRetEmErro, $sTbPaginacao) {
    $iIndice = $iPgAtual - 1;
    $iIndice = $iIndice * $iQntItensListagem;
    $this->pegaInfoDB($sTbPaginacao, 'count(1)');

    $iNumMaxPaginas = ceil($this->RETDB[0][0] / $iQntItensListagem);


    if ($iPgAtual > $iNumMaxPaginas) {
      header('location:' . $sPgRetEmErro);
      exit;
    }
    return true;
  }

  /* wTools::resumo
   *
   * Cria um resumo de um texto passado como parâmetro
   * @date 02/11/2010
   * @param  string $sParagrafo - String a ser analisada
   * @param  array  $aConfig    - Configurações
   *                  [iQntCar] Quantidade de caracteres a cortar
   *         [bFecharParagrafo] Se encontrar tag <p> irá fechar
   * @return string $sResumida  - String pronta
   */

  public function resumo($sParagrafo, $aConfig = array()) {

    if (!isset($aConfig['iQntCar'])) {
      $aConfig['iQntCar'] = 150;
    }

    $sParagrafo = strip_tags($sParagrafo, '<p><br><br />');
    $sResumida = substr($sParagrafo, 0, $aConfig['iQntCar']);
    $iCortada = strrpos($sResumida, " ");
    if ($iCortada > $aConfig['iQntCar']) {
      $sResumida = substr($sParagrafo, 0, $iCortada);
    }
    $sResumida . ' ...';

    if (isset($aConfig['bFecharParagrafo']) && $aConfig['bFecharParagrafo'] === true) {
      $iPosParagrafo = strrpos($sResumida, "<p>");
      if (is_numeric($iPosParagrafo)) {
        $sResumida . '</p>';
      }
    }

    return $sResumida;
  }

  public function enviaEmail() {

    # Monta as variáveis usadas

    $this->sRemetente = strip_tags($this->sRemetente);
    if (isset($this->sDestinatario)) {
      $this->sDestinatario = strip_tags($this->sDestinatário);
    }
    $this->sAssunto = strip_tags($this->sAssunto);
    $this->sMensagem = $this->sMensagem;

    $sHeaders = "MIME-Version: 1.0\r\n";
    $sHeaders .= "Content-type: text/html; charset=iso-8859-1\r\n";
    $sHeaders .= 'From: ' . $this->sRemetente;

    if (isset($this->aDestinatarios)) {
      foreach ($this->aDestinatarios as $sDestinatario) {
        $sDestinatario = strip_tags($sDestinatario);
        $bResult = mail($sDestinatario, $this->sAssunto, $this->sMensagem, $sHeaders);
      }
    } else {
      $bResult = mail($this->sDestinatario, $this->sAssunto, $this->sMensagem, $sHeaders);
    }

    if (!$bResult) {
      return false;
    }

    return true;
  }

  /* wTools::enviaImg
   *
   * Upload de Imagens
   * @date 24/11/2010
   * @param  array   $aArquivo        - Um array com o arquivo ex.: $_FILES["img_capa"]
   * @param  string  $sLocal          - Local a salvar a imagem
   * @param  string  $iLargura        - Largura da imagem
   * @param  string  $iAltura         - Altura da imagem
   * @param  string  $bNomeAleatorio  - Coloca um nome aleatorio para a imagem
   * @param  string  $bApagarImg      - Faz upload de uma imagem para o lugar de uma outra
   * @return string  $sNomeImg        - Nome da imagem salva
   * @return string  $iSize           - Tamanho máximo da imagem
   */

  public function enviaImg($aArquivo, $sLocal, $iLargura, $iAltura, $bNomeAleatorio = false, $bApagarImg = false, $iSize = 1000000) {

    $modTamanho = '';
    $sNomeImg = 1;

    if ($aArquivo["name"] == '') {
      $this->sMsg = "Por favor, selecione uma figura";
      echo '
		<script type="text/javascript">
			alert("' . $this->sMsg . '");
		</script>
		';
      return $sNomeImg;
    }

    if ((($aArquivo["type"] == "image/gif") || ($aArquivo["type"] == "image/jpeg") || ($aArquivo["type"] == "image/jpg")) && ($aArquivo["size"] < $iSize)) {
      if ($aArquivo["error"] == 0) {

        $aDimensoes = getimagesize($aArquivo["tmp_name"]);

        if (($aDimensoes[0] <= $iLargura || ($aDimensoes[1] <= $iAltura))) {

          // Pega extensão do arquivo
          preg_match("/\.(gif|bmp|png|jpg|jpeg){1}$/i", $aArquivo["name"], $aExtensao);

          // Nome da imagem
          if ($bNomeAleatorio) {
            $sNomeImg = md5(uniqid(time())) . "." . $aExtensao[1];
          } else {
            $sNomeImg = $aArquivo["name"];
          }

          // Caminho de onde a imagem ficará
          $imagem_dir = $sLocal . $sNomeImg;

          // Faz o upload da imagem
          move_uploaded_file($aArquivo["tmp_name"], $imagem_dir);

          //mensagem de sucesso
          $this->sMsg = "Sua foto foi enviada com sucesso!";
          //aviso($this->sMsg);
          return $sNomeImg;
        } else {
          //mensagem de erro
          //aviso ('Insira uma imagem de no máximo '.$iLargura.' x '.$iAltura.' pixels');
          $this->sMsg = 'É necessário inserir uma imagem com tamanho máximo de ' . $iLargura . ' x ' . $iAltura . 'px';
          $this->sErro = 'Erro';
          return $sNomeImg;
        }
      } else {
        //mensagem de erro
        $this->sMsg = 'Erro no carregamento da imagem: ' . $aArquivo["error"];
        $this->sErro = 'Erro';
        return $sNomeImg;
      }
    } else {
      //mensagem de erro
      $this->sMsg = "A imagem não pode ser enviada com sucesso.";
      $this->sErro = 'Erro';
      return $sNomeImg;
    }
  }

  /* wTools::getSeguro
   *
   * Testa se o conteúdo recebido via GET é o esperado
   * @date 14/12/2010
   * @param  string  $iId            - Id a testar
   * @return string  $iIndice        - Retorna o numero referente ao indice ou 0 caso seja malicioso.
   */

  public function getSeguro($iId) {
    // Testa se é a pagina principal ou uma sub-pagina
    if ((isset($iId)) && (is_numeric($iId))) {
      $iIndice = $iId;
    } else {
      $iIndice = 0;
    }
    return $iIndice;
  }

  /* wTools::uploadArquivos
   *
   * Upload de arquivos
   * @date 15/01/2011
   * @param  file    $_FILES          - Array de dados recebido de um campo do formulário. Ex.: $_FILES['CMPlogotipo']
   * @param  array   $$aConfigUpload  - Dados de configurações de mensagens, formato dos arquivos, tamanho, pasta a ser salva etc.
   * @param  integer $iTamMax         - Tamanho máximo do arquivo em MB
   * @param  array   $aExtensoes      - Contem as extensoes de arquivos aceitos para upload
   * @param  bool    $bRenomear       - Renomear arquivo com nome aleatório
   * @return true
   *
   */

  public function uploadArquivos($aFiles, $aConfigUpload) {

    // Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
    if ($aFiles['error'] != 0) {
      die("Não foi possível fazer o upload, erro:<br />" . $aConfigUpload['erros'][$aFiles['arquivo']['error']]);
      exit; // Para a execução do script
    }

    // Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
    // Faz a verificação da extensão do arquivo
    $sExtensao = strtolower(end(explode('.', $aFiles['name'])));
    if (array_search($sExtensao, $aConfigUpload['extensoes']) === false) {
      echo "Por favor, envie arquivos com as seguintes extensões: ";
    }

    // Faz a verificação do tamanho do arquivo
    else if ($aConfigUpload['tamanho'] < $aFiles['size']) {
      echo "O arquivo enviado é muito grande, envie arquivos de até $iTamMax.";

      // O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
    } else {

      // Primeiro verifica se deve trocar o nome do arquivo
      if ($aConfigUpload['renomeia'] == true) {
        // Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg
        $nome_final = time() . '.jpg';
      } else {

        // Mantém o nome original do arquivo
        $nome_final = $aFiles['name'];
      }

      // Depois verifica se é possível mover o arquivo para a pasta escolhida
      if (move_uploaded_file($aFiles['tmp_name'], $aConfigUpload['pasta'] . $nome_final)) {
        // Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
        echo "Upload efetuado com sucesso!";
        echo '<br /><a href="' . $aConfigUpload['pasta'] . $nome_final . '">Clique aqui para acessar o arquivo</a>';
      } else {
        // Não foi possível fazer o upload, provavelmente a pasta está incorreta
        echo "Não foi possível enviar o arquivo, tente novamente";
      }
    }
  }

  /* wTools::subArray
   *
   * Divide um array em partes
   * @date 27/02/2011
   * @param  array     $aDados         - Array a ser dividido
   * @param  integer   $iAgrupa        - Quantidade de registros que cada indice do array terá
   * @return array     $aArrayDividido - Resultato dividido

   */

  public function subArray($aDados, $iAgrupa) {
    $iQnt = count($aDados);
    $iRepete = ceil($iQnt / $iAgrupa);
    $iOffSet = 0;

    for ($i = 0; $i < $iRepete; $i++) {
      $aArrayDividido[] = array_slice($aDados, $iOffSet, 4);
      $iOffSet += $iAgrupa;
    }

    return $aArrayDividido;
  }

  /* wTools::montaUrlAmigavel
   *
   * Coloca em destaque um texto relevante com uma imagem de aspas
   * @date 13/12/2010
   * 
   * Atualizações:
   * 05/01/2013
   * Incluido proteção anti injection
   * 
   * @param  string $sFrase - String a ser analisada
   * @param  bool   $bContraBarra - Contrabarra na string de retorno
   * @return string $sRet   - String pronta
   */

  public function montaUrlAmigavel($sFrase = '', $bContraBarra = true) {
    if ($sFrase == '') {
      return false;
    }

    $sFrase = $this->anti_sql_injection($sFrase);

    $sFrase = trim($sFrase);
    $sFrase = strtolower($sFrase);

    $sFrase = str_replace(' ', '-', $sFrase);
    $sFrase = preg_replace("/[áàâãª]/", "a", $sFrase);
    $sFrase = preg_replace("/[éèê]/", "e", $sFrase);
    $sFrase = preg_replace("/[íì]/", "i", $sFrase);
    $sFrase = preg_replace("/[óòôõº]/", "o", $sFrase);
    $sFrase = preg_replace("/[úùû]/", "u", $sFrase);
    $sFrase = preg_replace("/[.;:@#%&=?!$*,%(){}+']/", "", $sFrase);
    $sFrase = str_replace('--', '-', $sFrase);
    $sFrase = str_replace("ç", "c", $sFrase);
    $sFrase = str_replace("\"", "", $sFrase);


    // Algumas vezes o link termina com -
    $sFrase = preg_replace("/-$/", "", $sFrase);
    $sFrase = $sFrase . ($bContraBarra ? '/' : '');
    $sRet = $sFrase;

    return $sRet;
  }

  /* wTools::montaSelect
   *
   * Coloca em destaque um texto relevante com uma imagem de aspas
   * @date 03/05/2011
   * @update 01/05/2015 Trocado o nome do método de montaSelect para montarSelect
   * 
   * @param  string $sNome    - String a ser analisada
   * @param  array  $aValores - Array com os valores (value, nome)
   * @param  bool   $bId      - Se tiver id, repete o nome do campo
   * @param  string $sClass   - Nome da classe
   * @return true
   */

  public function montarSelect($sNome, $aValores, $sSelecionado = '', $bId = true, $sClass = '', $sJsAdicional = '', $sBranco = 'Selecione um item') {
    ?>

    <select name="<?php echo $sNome; ?>" <?php
    echo ($bId) ? 'id="' . $sNome . '"' : '';
    echo ($sClass) ? 'class="' . $sClass . '"' : '';
    echo ($sJsAdicional) ? $sJsAdicional : ''
    ?> >
      <?php if ($sBranco) { ?>
        <option <?php echo ($sSelecionado == '') ? 'selected="selected"' : ''; ?>value=""><?php echo $sBranco; ?></option>
        <?php
      }
      foreach ($aValores as $sKey => $sValue) {
        ?>
        <option <?php echo ($sSelecionado == $sKey) ? 'selected="selected"' : '' ?>value="<?php echo $sKey; ?>"><?php echo $sValue; ?></option>
        <?php
      }
      ?>
    </select>
    <?php
  }

  /* wTools::montarRadio
   *
   * Cria o HTML de um campo Radio
   * @date 01/06/2013
   * @param  string  $sNome         - String a ser analisada
   * @param  array   $aValores      - Array com os valores (value, nome)
   * @param  string  $sSelecionado  - Valor do campo que virá selecionado
   * @param  bool    $bQuebrarLinha - Adicionar um <br /> no final de cada input
   * @param  bool    $bId           - Se tiver id, repete o nome do campo
   * @param  string  $sClass        - Nome da classe
   * @param  string  $sJsAdicional  - Chamada adicional de uma função JS
   * @return true
   */

  public function montarRadio($sNome, $aValores, $sSelecionado = '', $bQuebrarLinha = false, $bId = true, $sClass = '', $sJsAdicional = '') {
    foreach ($aValores as $sKey => $sValue) {
      ?>
      <input type="radio" name="<?php echo $sNome; ?>" <?php
             echo ($bId ? 'id="' . $sNome . '-' . $sKey . '"' : '');
             echo ($sClass != '' ? 'class="' . $sClass . '"' : '');
             echo $sJsAdicional;
             ?> value="<?php echo $sKey; ?>" <?php echo ($sSelecionado == $sKey ? 'checked="checked"' : '') ?>/> <?php echo $sValue;
       echo ($bQuebrarLinha ? '<br />' : '');
             ?>
             <?php
           }
         }

         /* wTools::valida_sAcao
          *
          * Valida as possiveis acoes permitidas dentro das páginas de admin.
          * @date 07/05/2011
          * @param string $sAcao  - novo ou editar
          * @param string $sRedir - Página para redirecionar em caso de erro
          * @return $sAcao
          */

         public function valida_sAcao($sAcao, $sRedir) {
           $bRedirSeguranca = false;
           if (isset($sAcao)) {
             if ($sAcao != 'novo' && $sAcao != 'editar') {
               $bRedirSeguranca = true;
             }
           } else {
             $bRedirSeguranca = true;
           }
           if ($bRedirSeguranca) {
             header("Location: $sRedir");
             exit();
           }
           return $sAcao;
         }

         /* wTools::validarPreenchimento
          *
          * Validar os campos que devem ter seu preenchimento obrigatório
          * @date 08/05/2011
          * @param array $aCampos  - Campos a serem validados
          * [texto identificação, nome do campo, tipo, obrigatorio ]
          * ex:
          * $aValidar = array (
           0 => array('Título'     , $_POST['CMPtitulo']), varchar, true
           1 => array('Solicitante', $_POST['CMPsolicitante']), varchar, true
           3 => array('Descrição'  , $_POST['CMPdesc']), text, false );
          * 
           0 = Descrição
           1 = Nome do campo do formulario
           2 = Tipo de dado
           3 = Bool, validar ou não o campo
           4 = Parametros
           5 = Mensagem customizada
          * 
          *
          * @return true
          */

         public function valida_Preenchimento($aCampos) {

           /*
             email                        - Email
             senha-correta		 - Senha
             float                        - Float
             faixa			 - Faixa de números, ex 0 ~ 100
             faixa-baixa                  - Faixa de números > que X
             faixa-alta			 - Faixa de números < que X
             dt-bd, dt-db, dt-br, data    - Data no formato dd/mm/yyyy
             date			 - Data no formato yyyy-mm-dd
             moeda			 - Moeda, reais
             digito			 - Dígitos
             caracteres			 - Caracteres
             cep                          - Cep
             texto, varchar		 - Texto, genérico
             telefone			 - Telefone (xx)xxxx-xxxx ou xxxx-xxxx
             abrangencia			 - Algum termo pre-definido em um array parâmetro 4
             cnpj                         - CNPJ
             text                         - Testa se é um texto e limita até 1000 caracteres
             enum			 - Permite somente as opções permitidas
             senha
             logico			 - 
            */
//           if ($this->const === false) {
           if (true) {

             /*
              * Constantes usadas na função "ereg" que se tornou obsoleta
              * e substituiída por "preg_mach".

               define('REG_DATA'          , '/([[:digit:]]{2})/([[:digit:]]{2})/([[:digit:]]{4})/');
               define('REG_DATE'          , '([[:digit:]]{4})-([[:digit:]]{2})-([[:digit:]]{2})');
               define('REG_DIGIT_SIGNED'  , '^[-[:digit:]]+$');
               define('REG_DIGIT_UNSIGNED', '^[[:digit:]]+$');
               define('REG_PASSWORD'      , '^[[:alnum:][:punct:]]+$');
               define('REG_CARACTERES'    , '^[[:alpha:]]+$');
               define('REG_FLOAT'         , '^[[:digit:]]+[.,]{0,1}[[:digit:]]{0,}$');
               define('REG_MOEDA'         , '^[[:digit:]]+[,]{0,1}[[:digit:]]{0,2}$');
               define('REG_EMAIL'         , '^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$');
               define('REG_CEP'           , '^[0-9]{5}-[0-9]{3}$');
               define('REG_TEXTO'         , '[[:graph:][:blank:]]+');
               define('REG_TELEFONE_DDD'  , '^\([0-9]{2}\)[0-9]{4,5}-[0-9]{4}$');
               define('REG_TELEFONE'      , '^[0-9]{4,5}-[0-9]{4}$');
               define('REG_CNPJ'          , '^[0-9]{2}.[0-9]{3}.[0-9]{3}/[0-9]{4}-[0-9]{2}$'); */

//
//      define('REG_DATA'          , '/[[:digit:]]{2}\/[[:digit:]]{2}\/[[:digit:]]{4}/');
//      define('REG_DATE'          , '/([[:digit:]]{4})-([[:digit:]]{2})-([[:digit:]]{2})/');
//      define('REG_DIGIT_SIGNED'  , '/[-[:digit:]]+/');
//      define('REG_DIGIT_UNSIGNED', '/[[:digit:]]+/');
//      define('REG_PASSWORD'      , '/[[:alnum:][:punct:]]+/');
//      define('REG_CARACTERES'    , '/[[:alpha:]]+/');
//      define('REG_FLOAT'         , '/^[[:digit:]]{0,}[.,]{0,1}[[:digit:]]{0,}$/');
//      define('REG_MOEDA'         , '/[[:digit:]]+[,]{1}[[:digit:]]{2}/');
//      define('REG_EMAIL'         , '/[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})/');
//      define('REG_CEP'           , '/[0-9]{5}-[0-9]{3}/');
//      define('REG_TEXTO'         , '/[[:graph:][:blank:]]+/');
//      define('REG_TELEFONE_DDD'  , '/^\([0-9]{2}\)[0-9]{4,5}-[0-9]{4}/');
//      define('REG_TELEFONE'      , '/[0-9]{4,5}-[0-9]{4}/');
//      define('REG_CNPJ'          , '/^[0-9]{2}.[0-9]{3}.[0-9]{3}\/[0-9]{4}-[0-9]{2}/');

             $REG_DATA = '/[[:digit:]]{2}\/[[:digit:]]{2}\/[[:digit:]]{4}/';
             $REG_DATE = '/([[:digit:]]{4})-([[:digit:]]{2})-([[:digit:]]{2})/';
             $REG_DIGIT_SIGNED = '/[-[:digit:]]+/';
             $REG_DIGIT_UNSIGNED = '/[[:digit:]]+/';
             $REG_PASSWORD = '/[[:alnum:][:punct:]]+/';
             $REG_CARACTERES = '/[[:alpha:]]+/';
             $REG_FLOAT = '/^[[:digit:]]{0,}[.,]{0,1}[[:digit:]]{0,}$/';
             $REG_MOEDA = '/[[:digit:]]+[,]{1}[[:digit:]]{2}/';
             $REG_EMAIL = '/[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})/';
             $REG_CEP = '/[0-9]{5}-[0-9]{3}/';
             $REG_TEXTO = '/[[:graph:][:blank:]]+/';
             $REG_TELEFONE_DDD = '/^\([0-9]{2}\)[0-9]{4,5}-[0-9]{4}/';
             $REG_TELEFONE = '/[0-9]{4,5}-[0-9]{4}/';
             $REG_CNPJ = '/^[0-9]{2}.[0-9]{3}.[0-9]{3}\/[0-9]{4}-[0-9]{2}/';
             $this->const = true;
           }


           if (!is_array($aCampos)) {
             return false;
           }
           foreach ($aCampos as $aCampo) {

             $bObrigatorio = (isset($aCampo[3]) && $aCampo[3] === true);

             // Guarda a mensagem customizada de retorno ao usuário
             $sMsgCustomizada = '';
             if (isset($aCampo[5])) {
               $sMsgCustomizada = $aCampo[5];
             }

             try {
               if ($bObrigatorio && $aCampo[1] == '') {
                 $sMsg = 'O campo <b>' . $aCampo[0] . '</b> deve ser preenchido corretamente!';
                 throw new Exception;
               }

               if (isset($aCampo[2])) {
                 switch ($aCampo[2]) {

                   /* Email */
                   case 'email':
                     if (!preg_match($REG_EMAIL, $aCampo[1])) {
                       if (!$bObrigatorio && $aCampo[1] == '')
                         break;
                       $sMsg = 'O campo <b>' . $aCampo[0] . '</b> deve ser um email válido!';
                       throw new Exception;
                     }
                     break;

                   /* Float */
                   case 'float':
                     if (!preg_match($REG_FLOAT, $aCampo[1])) {
                       if (!$bObrigatorio && ($aCampo[1] == ''))
                         break;
                       $sMsg = 'O campo <b>' . $aCampo[0] . '</b> deve ser um número decimal!';
                       throw new Exception;
                     } elseif ($bObrigatorio && $aCampo[1] < 0.01) {
                       $sMsg = 'O campo <b>' . $aCampo[0] . '</b> deve obrigatoriamente ter um valor!';
                       throw new Exception;
                     }
                     break;

                   /* Faixa de números, ex 0 ~ 100 */
                   case 'faixa':
                     $aFaixa = explode('~', $aCampo[4]);
                     if ($aCampo[1] <= $aFaixa[0] || $aCampo[1] > $aFaixa[1] || !preg_match($REG_FLOAT, $aCampo[1])) {
                       $sMsg = 'O campo <b>' . $aCampo[0] . '</b> deve ser menor que ' . $aFaixa[0] . ' e maior que ' . $aFaixa[1] . '!';
                       throw new Exception;
                     }
                     break;

                   /* Faixa de números > que X */
                   case 'faixa-baixa':
                     if ($aCampo[1] <= $aCampo[4] || !preg_match($REG_FLOAT, $aCampo[1])) {
                       $sMsg = 'O campo <b>' . $aCampo[0] . '</b> deve ser maior que ' . $aCampo[4] . '!';
                       throw new Exception;
                     }
                     break;

                   /* Faixa de números < que X */
                   case 'faixa-alta':
                     if ($aCampo[1] <= $aCampo[4] || !preg_match($REG_FLOAT, $aCampo[1])) {
                       $sMsg = 'O campo <b>' . $aCampo[0] . '</b> deve ser menor que ' . $aCampo[4] . '!';
                       throw new Exception;
                     }
                     break;


                   /*  ********************************
                    *  Data no formato dd/mm/yyyy X 
                    * ********************************* */
                   case 'dt-bd':
                   case 'dt-db':
                   case 'dt-br':
                   case 'data':
                     if (!preg_match($REG_DATA, $aCampo[1])) {
                       if (!$bObrigatorio && $aCampo[1] == '')
                         break;
                       $sMsg = 'O campo <b>' . $aCampo[0] . '</b> deve ser uma data!';
                       throw new Exception;
                     }
                     break;

                   /* ********************************
                    *  Data no formato yyyy/mm/dd X 
                    * ********************************* */
                   case 'date':
                     if (!preg_match($REG_DATE, $aCampo[1])) {
                       if (!$bObrigatorio && $aCampo[1] == '')
                         break;
                       $sMsg = 'O campo <b>' . $aCampo[0] . '</b> deve ser uma data!';
                       throw new Exception;
                     }
                     break;

                   /*********************************
                    *  Moeda, reais 
                    * ******************************** */
                   case 'moeda':
                     if (!preg_match($REG_MOEDA, $aCampo[1])) {
                       if (!$bObrigatorio && $aCampo[1] == '')
                         break;
                       $sMsg = 'O campo <b>' . $aCampo[0] . '</b> deve ser um valor em Reais!';
                       throw new Exception;
                     }
                     break;

                   /*  ********************************
                    *  Dígitos 
                    * ********************************* */
                   case 'digito':
                     if (!preg_match($REG_DIGIT_UNSIGNED, $aCampo[1])) {
                       if (!$bObrigatorio && $aCampo[1] == '')
                         break;
                       $sMsg = 'O campo <b>' . $aCampo[0] . '</b> deve ser um valor numérico!';
                       throw new Exception;
                     }
                     break;

                   /*  ********************************
                    *  Caracteres 
                    * ********************************* */
                   case 'caracteres':
                     if (!preg_match($REG_CARACTERES, $aCampo[1])) {
                       if (!$bObrigatorio && $aCampo[1] == '')
                         break;
                       $sMsg = 'O campo <b>' . $aCampo[0] . '</b> deve conter apenas letras!';
                       throw new Exception;
                     }
                     break;

                   /*  ********************************
                    *  Cep
                    * ********************************* */
                   case 'cep':
                     if (!preg_match($REG_CEP, $aCampo[1])) {
                       if (!$bObrigatorio && $aCampo[1] == '')
                         break;
                       $sMsg = 'O campo <b>' . $aCampo[0] . '</b> deve conter um número de CEP válido!';
                       throw new Exception;
                     }
                     break;

                   /*  ********************************
                    *  Senha
                    * ********************************* */
                   case 'senha':
                     if (!preg_match($REG_PASSWORD, $aCampo[1])) {
                       if (!$bObrigatorio && $aCampo[1] == '')
                         break;
                       $sMsg = 'O campo <b>' . $aCampo[0] . '</b> deve ser preenchido corretamente!';
                       throw new Exception;
                     }
                     break;

                   /* Validar confirmação de senha */
                   case 'senha-correta':
                     if ($aCampo[1] != $aCampo[4]) {
                       $sMsg = 'Confirme corretamente o campo <b>' . $aCampo[0] . '</b>!';
                       throw new Exception;
                     }
                     break;

                   /*********************************
                    * Date-maior
                    * valores devem chegar no formado yyyy-mm-dd
                    * Validar que uma data seja maior que uma outra data
                    * ********************************* */
                   case 'date-maior':
                        $odtDataInicio = new DateTime( $aCampo[1] );
                        $odtDataFinal = new DateTime( $aCampo[4] );
                        $oDadosIntervalo = $odtDataInicio->diff( $odtDataFinal );

                        if ($oDadosIntervalo->invert > 0) {
                          $sMsg = 'O campo <b>' . $aCampo[0] . '</b> não pode ter data inferior à '.$this->parseValue($aCampo[1], 'db-dt').'!';
                          throw new Exception;
                          
                        }
                     break;

                   /*********************************
                    * Data-maior
                    * Validar que uma data seja maior que uma outra data
                    * valores devem chegar no formado dd/mm/yyyy
                    * ********************************* */
                   case 'data-maior':
                        $odtDataInicio = new DateTime( $this->parseValue($aCampo[1], 'db-dt') );
                        $odtDataFinal = new DateTime( $this->parseValue($aCampo[4], 'db-dt') );
                        $oDadosIntervalo = $odtDataInicio->diff( $odtDataFinal );

                        if ($oDadosIntervalo->invert > 0) {
                          $sMsg = 'O campo <b>' . $aCampo[0] . '</b> não pode ter data inferior à '.$aCampo[1].'!';
                          throw new Exception;
                          
                        }
                     break;

                   case 'senha':
                     if (!preg_match($REG_PASSWORD, $aCampo[1])) {
                       $sMsg = 'O campo <b>' . $aCampo[0] . '</b> deve ser preenchido corretamente!';
                       throw new Exception;
                     }
                     break;

                   /* ********************************
                    *  Texto
                    * ********************************* */
                   case 'varchar':
                     if (strlen($aCampo[1]) > $aCampo[4][0]) {
                       $sMsg = 'O campo <b>' . $aCampo[0] . '</b> deve possuir no maximo <b>' . $aCampo[4][0] . '</b> caracteres!';
                       throw new Exception;
                     }

                   case 'texto':
                     if (!preg_match($REG_TEXTO, $aCampo[1])) {
                       if (!$bObrigatorio && $aCampo[1] == '')
                         break;
                       $sMsg = 'O campo <b>' . $aCampo[0] . '</b> deve possuir apenas texto!';
                       throw new Exception;
                     }
                     break;

                   /**********************************
                    *  Text
                    * ********************************* */
                   case 'text':
                     $LIMITE_CARACTERES_TEXT = 200000;

                     if (strlen($aCampo[1]) > $LIMITE_CARACTERES_TEXT) {
                       $sMsg = 'A quantidade máxima de caracteres do campo <b>' . $aCampo[0] . '</b> não deve ser superior a ' . $LIMITE_CARACTERES_TEXT . '!';
                       throw new Exception;
                     }
                     if (!preg_match($REG_TEXTO, $aCampo[1])) {
                       if (!$bObrigatorio && $aCampo[1] == '')
                         break;
                       $sMsg = 'O campo <b>' . $aCampo[0] . '</b> deve possuir apenas texto!';
                       throw new Exception;
                     }
                     break;

                   /*  ********************************
                    *  Telefone
                    * ********************************* */
                   case 'telefone':
                     if (!preg_match($REG_TELEFONE, $aCampo[1]) && !preg_match($REG_TELEFONE_DDD, $aCampo[1])) {
                       if (!$bObrigatorio && $aCampo[1] == '')
                         break;
                       $sMsg = 'O campo <b>' . $aCampo[0] . '</b> deve ser um número de telefone!';
                       throw new Exception;
                     }
                     break;

                   /*  ********************************
                    *  Abrangência
                    * ********************************* */
                   case 'abrangencia':
                     if (!in_array($aCampo[1], $aCampo[4])) {
                       if (!$bObrigatorio && $aCampo[1] == '')
                         break;
                       $sMsg = 'O valor selecionado no campo <b>' . $aCampo[0] . '</b> não existe!';
                       throw new Exception;
                     }
                     break;

                   /*  ********************************
                    *  CNPJ
                    * ********************************* */
                   case 'cnpj':
                     if (!preg_match($REG_CNPJ, $aCampo[1])) {
                       $sMsg = 'O valor selecionado no campo <b>' . $aCampo[0] . '</b> deve ser um CNPJ!';
                       throw new Exception;
                     }
                     break;

                   /*  ********************************
                    *  Enum
                    * ********************************* */
                   case 'enum':
                     if (!is_array($aCampo[4])) {
                       $sMsg = 'Parâmetro 4 deve receber um array!';
                       throw new Exception;
                     }
                     if (!in_array($aCampo[1], $aCampo[4])) {
                       if (!$bObrigatorio && $aCampo[1] == '')
                         break;
                       $sMsg = 'Valor inválido para o campo <b>' . $aCampo[0] . '</b>!';
                       throw new Exception;
                     }
                     break;

                   default:
                     break;
                 }
               }
             } catch (Exception $e) {
               $this->aMsg = array('iCdMsg' => 2,
                   'sMsg' => $sMsgCustomizada == '' ? $sMsg : $sMsgCustomizada,
                   'sResultado' => '');
               return $aCampo[0];
             }
           }
           return true;
         }

         /* wTools::msgRetPost
          *
          * Monta um array com a mensagem de retorno ao usuário.
          * Deve ser usada quando uma página recebe um formulário via POST contendo o
          * resultado de uma edição de dados realizada em outra página.
          *
          * Atualizado em 30/10/2012
          * Adicionado um parâmetro com uma possível mensagem. Ela tem prioridade.
          *
          * @date 30/03/2012
          * @param 
          * @return mixed Array com a mensagem montada ou string vazia
          */

         public function msgRetPost($aMsg) {

           if (isset($aMsg['sResultado']) && $aMsg['sResultado'] != '') {
             return $aMsg;
           }
           if (isset($aMsg['sMsg']) && $aMsg['sMsg'] != '') {
             return $aMsg;
           }

           $mResultado = '';
           if (isset($_POST['retMsg'])) {
             $mResultado = array('iCdMsg' => $_POST['iCdMsg'],
                 'sMsg' => $_POST['sMsg'],
                 'sResultado' => $_POST['sResultado']);
           }
           return $mResultado;
         }

         /* wTools::redirFRM
          *
          * Redireciona uma págia utilizando Javascript e enviando dados através de formulário
          * @date 08/05/2011
          * @param string $sUrl     - Endereço da página de destino.
          * @param array  $aCampos  - Campos a serem enviados pelo formulario. Indice do array = nome do campo.
          * @return true
          */

         public function redirFRM($sUrl, $aCampos = array()) {
           ?>
    <form id="FRMredir" method="post" action="<?php echo $sUrl ?>">
      <input type="hidden" name="retMsg" value="retMsg" />
    <?php foreach ($aCampos as $sIndice => $sValor) { ?>
        <input type="hidden" name="<?php echo $sIndice; ?>" value="<?php echo $sValor; ?>" /> <?php
    }
    ?>        
    </form>
    <script type="text/javascript">
      document.forms["FRMredir"].submit();
    </script>
    <?php
    exit;
  }

  /* wTools::pegaInfoDB
   *
   * Faz uma consulta genérica ao banco de dados
   * @date 21/05/2011
   * @param string $sTabela  - Endereço da página de destino.
   * @param mixed  $mCampos  - Campos a serem enviados pelo formulario. Indice do array = nome do campo.
   * @param string $sWhere   - Filtro where
   * @return true
   */

  public function pegaInfoDB($sTabela, $mCampos, $sWhere = '') {

    if (is_array($mCampos)) {
      $sCampos = implode(',', $mCampos);
      $iQntCampos = count($mCampos);
    } else {
      $sCampos = $mCampos;
      $iQntCampos = 1;
    }

    $sQuery = 'SELECT ' . $sCampos . '
                 FROM ' . $sTabela . ' ' . $sWhere;

    $mResultado = $this->oBd->query($sQuery);

    if (!$mResultado) {
//      die('Erro ao utilizar método pegaInfoDB: ' . $this->oBd->getMsg());
      return false;
    }

    $this->iLinhas = $this->oBd->getNumeroLinhas();

    //$this->RETDB = '';
    $this->RETDB = array();
    $aRetDB = array();

    for ($i = 0; $i < $this->iLinhas; $i++) {
      $this->RETDB[] = $mResultado[$i];
      $aRetDB = $mResultado[$i];
    }

    // Útil para pegar o último registro ou quando só se espera uma linha de retorno
    return $aRetDB;
  }

  /* wTools::montaTwinList
   *
   * Monta uma lista com dois campos, itens disponiveis e itens já relacionados
   * com os botões para incluir ou retirar valores.
   * Para o twinlist funcionar é preciso de duas tabelas, uma de cadastro com nomes de itens e outra tabela de relacionamento
   * onde ela informa os campos que já estão salvos.
   *
   * @date 31/03/2012
   * @param  string $sNomeTwinList - Nome da twinlist e nome do campo que deverá ser salvo no banco de dados
   * @param  int    $iIdRegEditado - Id do registro que esta sendo editado ou em caso de um novo item
   *                                 (pagina de insert) ele deverá ser 0
   * @param  array  $aDadosTbCadastro - Dados devem estar nesta ordem 0 => nome da tabela 1=> id( será o campo
   *                                    value do option do select) 2=> nome do campo (é o valor visivel ao usuario)
   *                                    ex.: $aDadosTbCadastro = array('tc_tags', 'id', 'nm_tag');
   * @param  array  $aDadosTbRelacionamento - Dados devem estar nesta ordem 0 => nome da tabela de relacionamento
   *                                          1 => id estrangeiro 2 => id principal
   *                                          ex.: $aDadosTbRelacionamento = array('tr_prod_tag', 'id_tag', 'id_prod');
   * @return true
   *
   *
   */

  public function montarTwinList($sNomeTwinList, $iIdRegEditado = '', $aDadosTbCadastro = '', $aDadosTbRelacionamento = '', $sFiltro = '') {

    if ($sFiltro != '') {
      $sFiltro = "\n " . $sFiltro . " \n";
    }
    ?>
    <div>
      <select size="10" multiple="multiple" id="CMPdisponiveis_<?php echo $sNomeTwinList; ?>" name="CMPdisponiveis_<?php echo $sNomeTwinList; ?>[]" style="width: 200px; float: left" class="TLdisponiveis">
        <?php
        // Tratamento de dados recebidos por POST
        if (isset($_POST['CMPdisponiveis_' . $sNomeTwinList])) {
          $sIdsFrom = implode(',', $_POST['CMPdisponiveis_' . $sNomeTwinList]);
          $sWhere = 'WHERE ' . $aDadosTbCadastro[1] . ' IN (' . $sIdsFrom . ')';

          if ($iIdRegEditado != 0) {
            $sWhere .= ' AND ' . $aDadosTbCadastro[1] . ' 
                        NOT IN (SELECT ' . $aDadosTbRelacionamento[1] . ' 
                                  FROM ' . $aDadosTbRelacionamento[0] . ' 
                                 WHERE ' . $aDadosTbRelacionamento[2] . ' = ' . $iIdRegEditado . ')';
          }


          // Caso acontece quando todos itens foram selecionados para o campo da direita
        } elseif (isset($_POST[$sNomeTwinList])) {
          $sWhere = 'WHERE 1 = 0';

          // Carregar dados no select
        } else {

          $sIdsFrom = 'SELECT ' . $aDadosTbRelacionamento[1] . '
                           FROM ' . $aDadosTbRelacionamento[0] . '
                          WHERE ' . $aDadosTbRelacionamento[2] . ' = ' . $iIdRegEditado;
          $sWhere = 'WHERE ' . $aDadosTbCadastro[1] . ' NOT IN (' . $sIdsFrom . ')';
        }
        $sOrder = ' ORDER BY ' . $aDadosTbCadastro[2];
        $aListaEsq = array();
        $this->pegaInfoDB($aDadosTbCadastro[0], array($aDadosTbCadastro[1], $aDadosTbCadastro[2]), $sWhere . $sFiltro . $sOrder);
        $aListaEsq = $this->RETDB;
        foreach ($aListaEsq as $aDados) {
          ?>
          <option value="<?php echo $aDados[0]; ?>"><?php echo $aDados[1]; ?></option>
      <?php
    }
    ?>
      </select>

      <div style="float: left; margin: 0 10px 0 10px ">
        <input type="hidden" id="CMPtwinList_<?php echo $sNomeTwinList; ?>" name="CMPtwinList_<?php echo $sNomeTwinList; ?>" value="<?php echo $sNomeTwinList; ?>" />
        <input type="button" id="bt_d_<?php echo $sNomeTwinList; ?>"  class="bt tl_d"  style="width: 40px; margin: 1px" value=">" /><br />
        <input type="button" id="bt_td_<?php echo $sNomeTwinList; ?>" class="bt tl_td" style="width: 40px; margin: 1px" value=">>" /><br />
        <input type="button" id="bt_e_<?php echo $sNomeTwinList; ?>"  class="bt tl_e"  style="width: 40px; margin: 1px" value="<" /><br />
        <input type="button" id="bt_te_<?php echo $sNomeTwinList; ?>" class="bt tl_te" style="width: 40px; margin: 1px" value="<<" />
      </div>

      <select size="10" multiple="multiple" id="<?php echo $sNomeTwinList; ?>" name="<?php echo $sNomeTwinList; ?>[]" style="width: 200px;  float: left" class="TLselecionados">
        <?php
        // Tratamento de dados recebidos por POST
        if (isset($_POST[$sNomeTwinList])) {
          $sIdsFrom = implode(',', $_POST[$sNomeTwinList]);
          $sWhere = 'WHERE ' . $aDadosTbCadastro[1] . ' IN (' . $sIdsFrom . ')';
        } else {

          // Carregar dados no select
          $sIdsFrom = 'SELECT ' . $aDadosTbRelacionamento[1] . '
                           FROM ' . $aDadosTbRelacionamento[0] . '
                          WHERE ' . $aDadosTbRelacionamento[2] . ' = ' . $iIdRegEditado;
          $sWhere = 'WHERE ' . $aDadosTbCadastro[1] . ' IN (' . $sIdsFrom . ')';
        }

        $sOrder = ' ORDER BY ' . $aDadosTbCadastro[2];
        $this->pegaInfoDB($aDadosTbCadastro[0], array($aDadosTbCadastro[1], $aDadosTbCadastro[2]), $sWhere . $sFiltro . $sOrder);
        $aListaDir = $this->RETDB;
        foreach ($aListaDir as $aDadosDir) {
          ?>
          <option value="<?php echo $aDadosDir[0]; ?>"><?php echo $aDadosDir[1]; ?></option>
      <?php
    }
    ?>
      </select>
    </div>
    <div style="clear: both;">&nbsp;</div>
    <?php
    return true;
  }

  public function montarJsTwinList($sIdFormulario) {

    echo '
        // 1) Ao enviar o formulário ele deve ser tratado via JS
        $(\'#' . $sIdFormulario . '\').submit(function(){
          sIdNomeTl = \'CMPctegorias\';
          //$("select[name=\'CMPdisponiveis_"+sIdNomeTl+"[]\'] option").each(function () {

          $("select[class=\'TLdisponiveis\'] option").each(function () {
            $(this).attr(\'selected\', \'selected\');
          });
          $("select[class=\'TLselecionados\'] option").each(function () {
            $(this).attr(\'selected\', \'selected\');
          });
        });';

    echo '

        // 2) Botão "Todos para Direita"
        $(\'.tl_td\').click(function(){
          sIdNomeTl = $(this).attr("id");
          sIdNomeTl = sIdNomeTl.replace("bt_td_", "");

          $("select[name=\'CMPdisponiveis_"+sIdNomeTl+"[]\'] option").each(function () {
            $(\'#\'+sIdNomeTl).append(\'<option value="\'+$(this).val()+\'">\'+$(this).text()+\'</option>\');
            $("select[name=\'CMPdisponiveis_"+sIdNomeTl+"[]\'] option").remove();
          });

        });

        // 3) Botão "Selecionados para Direita"
        $(\'.tl_d\').click(function(){
          sIdNomeTl = $(this).attr("id");
          sIdNomeTl = sIdNomeTl.replace("bt_d_", "");

          $("select[name=\'CMPdisponiveis_"+sIdNomeTl+"[]\'] option:selected").each(function () {
            $(\'#\'+sIdNomeTl).append(\'<option value="\'+$(this).val()+\'">\'+$(this).text()+\'</option>\');
            $("select[name=\'CMPdisponiveis_"+sIdNomeTl+"[]\'] option:selected").remove();
          });
        });

        // 4) Botão "Todos para Esquerda"
        $(\'.tl_te\').click(function(){
          sIdNomeTl = $(this).attr("id");
          sIdNomeTl = sIdNomeTl.replace("bt_te_", "");

          $("select[name=\'"+sIdNomeTl+"[]\'] option").each(function () {
            $(\'#CMPdisponiveis_\'+sIdNomeTl).append(\'<option value="\'+$(this).val()+\'">\'+$(this).text()+\'</option>\');
            $("select[name=\'"+sIdNomeTl+"[]\'] option").remove();
          });
        });

        // 5) Botão "Selecionados para Direita"
        $(\'.tl_e\').click(function(){
          sIdNomeTl = $(this).attr("id");
          sIdNomeTl = sIdNomeTl.replace("bt_e_", "");

          $("select[name=\'"+sIdNomeTl+"[]\'] option:selected").each(function () {
            $(\'#CMPdisponiveis_\'+sIdNomeTl).append(\'<option value="\'+$(this).val()+\'">\'+$(this).text()+\'</option>\');
            $("select[name=\'"+sIdNomeTl+"[]\'] option:selected").remove();
          });
        });
    ';
  }

  /* wTools::montaSelectDB
   *
   * Coloca em destaque um texto relevante com uma imagem de aspas
   * @date 21/05/2011
   * @param  string $sNome    - String a ser analisada
   * @param  array  $aValores - Array com os valores (value, nome)
   * @param  bool   $bId      - Se tiver id, repete o nome do campo
   * @param  string $sClass   - Nome da classe
   * @return true
   */

  public function montaSelectDB($sNome, $sTabela, $sChave, $sRotulo, $sSelecionado = '', $bId = true, $sClass = '', $sJsAdicional = '', $sBranco = 'Selecione um item', $sWhere = '') {
    ?>

    <select name="<?php echo $sNome; ?>" <?php
      echo ($bId) ? 'id="' . $sNome . '"' : '';
      echo ($sClass) ? ' class="' . $sClass . '" ' : '';
      echo ($sJsAdicional != '') ? $sJsAdicional : ''
      ?> >
      <?php if ($sBranco) { ?>
        <option <?php echo ($sSelecionado) ? '' : 'selected="selected"' ?>value=""><?php echo $sBranco; ?></option>
        <?php
      }

      $sQuery = 'SELECT ' . $sChave . '  AS chave,
                        ' . $sRotulo . ' AS rotulo
                   FROM ' . $sTabela . '
                        ' . $sWhere;
      $sResultado = mysql_query($sQuery);

      if (!$sResultado) {
        die('Erro ao utilizar o método montaSelectDB: ' . mysql_error());
        return false;
      }

      while ($aResultado = mysql_fetch_array($sResultado)) {
        ?>
        <option <?php echo ($sSelecionado == $aResultado['chave'] || $sSelecionado == $aResultado['rotulo'] ) ? 'selected="selected"' : '' ?>value="<?php echo $aResultado['chave']; ?>"><?php echo $aResultado['rotulo']; ?></option> <?php
    }
    ?>
    </select>
    <?php
  }

  /* wTools::montaLink
   *
   * Recebe os dados para criar um link via PHP
   * @date 18/07/2011
   * @update 27/11/2011 - Atualizada a forma de buscar o path do link
   * @param  string $sTexto  - String a ser analisada
   * @param  string $sLink   - Link da página
   * @param  string $CFGpath - 
   * @param  string $sClass  - Inserir uma classe especifica para o link
   * @param  bool   $bImprimir - Escrever o link na tela
   * @return true
   */

  public function montarLink($sTexto, $sLink, $CFGpath = '', $bImprimir = true, $sClass = '') {

    if (isset($this->sUrlBase) && $CFGpath == '') {
      $CFGpath = $this->sUrlBase . '/';
    }

    if ($bImprimir) {
      ?>
      <a href="<?php echo $CFGpath; ?><?php echo $sLink; ?>" <?php echo 'class="' . $sClass . '"'; ?>><?php echo $sTexto; ?></a>
      <?php
    }

    return '<a href="' . $CFGpath . $sLink . '"><' . $sTexto . '</a>';
  }

  /* wTools::parseValue
   *
   * Configura valores de formas a serem utilizados em locais diferentes
   * @date 19/11/2011
   * @param  string $sCampo   - Valor a ser formatado
   * @param  string $sFormato - Formato a ser configurado o valor
   * @return $sRetCampo       - Valor a ser usado para inserir no banco de dados
   */

  public function parseValue($sCampo, $sFormato) {
    $aRetornarNumero = array('moeda-bd', 'moeda-db', 'decimal-bd');
    $sRetCampo = '';

    if ($sCampo == '' || $sCampo == null) {

      // Números devem retornar com 0, strings vazias ('').
      if (in_array($sFormato, $aRetornarNumero)) {
        return '0.00';
      } elseif (is_string($sCampo)) {
        return '';
      }
    }
    switch ($sFormato) {
      case 'dt-bd':
      case 'dt-db':
      case 'dt-br':
        $aResult = explode('/', $sCampo);
        $sRetCampo = $aResult[2] . '-' . $aResult[1] . '-' . $aResult[0];
        break;

      case 'bd-dt':
      case 'db-dt':
        $aResult = explode('-', $sCampo);
        $sRetCampo = substr($aResult[2], 0, 2) . '/' . substr($aResult[1], 0, 2) . '/' . substr($aResult[0], 0, 4);
        break;

      case 'moeda-bd':
      case 'moeda-db':

        $iQntVirg = strpos($sCampo, ',');
        $iQntPonto = strpos($sCampo, '.');

        // Passa o número para formato americano
        if ($iQntVirg > $iQntPonto) {
          $sCampo = str_replace('.', '', $sCampo);
          $sCampo = str_replace(',', '.', $sCampo);
        } else {
          $sCampo = str_replace(',', '', $sCampo);
        }

        $sRetCampo = number_format($sCampo, 2, ".", "");
        break;

      case 'db-moeda':
      case 'bd-moeda':
      case 'reais':

        $iQntVirg = strpos($sCampo, ',');
        $iQntPonto = strpos($sCampo, '.');

        // Passa o número para formato americano
        if ($iQntVirg > $iQntPonto) {
          $sCampo = str_replace('.', '', $sCampo);
          $sCampo = str_replace(',', '.', $sCampo);
        } else {
          $sCampo = str_replace(',', '', $sCampo);
        }
        $sCampo = (float) $sCampo;
        $sRetCampo = number_format($sCampo, 2, ",", ".");
        //http://leocaseiro.com.br/moedas-decimais-funcao-number_format-php
        break;

      case 'decimal-bd':
        $sRetCampo = str_replace(',', '.', $sCampo);
        break;
    }




    return $sRetCampo;
  }

  /* wTools::pegarExtensao
   *
   * Retorna a extensao da string passada
   * @date 19/11/2011
   * @param  string $sNome - Campo com um nome contendo extensao  
   * @return $sExt         - Extensao do arquivo
   */

  public function pegarExtensao($sNome) {
    $aTmp = explode('.', $sNome);
    $sExt = strtolower(end($aTmp));
    return $sExt;
  }

  /* wTools::retirarExtensao
   *
   * Retorna a extensao da string passada
   * @date 19/11/2011
   * @param  string $sNome - Campo com um nome contendo extensao  
   * @return $sExt         - Extensao do arquivo
   */

  public function retirarExtensao($sNome) {
    $aTmp = explode('.', $sNome);
    $sExt = strtolower(reset($aTmp));
    return $sExt;
  }

  /* wTools::buscarInfoDB
   *
   * Faz uma consulta genérica ao banco de dados, similar ao metodo pegaInfoDB, porém recebe uma string
   * de consulta SQL ao inves de nomes especificos de tabela, campos e filtro
   * @date 07/11/2011
   * 
   *  Atualizado em 05/01/2013
   *  O Array de retorno passa a ter o nome das colunas do banco de dados, facilitando
   *  a utilização dos dados ex.: $aRetDB['nome_do_campo'][$i]
   * 
   *  Atualizado em 27/06/2015
   *  Retirada das funções mysql.
   *  Retorna primeira linha da consulta realizada. 
   *  Todas as linhas da consulta ficam disponíveis em
   * 
   * @param string $sSql                    - SQL da consulta
   * @param bool   $bUsaNomeCamposNoRetorno - Para manter compatibilidade dos tipos de retornos
   * @return Array $aRetDB - Array de dados
   */

  public function buscarInfoDB($sSql, $bUsaNomeCamposNoRetorno = true) {

//    $sResultado = mysql_query($sSql);
    $aResultado = $this->oBd->query($sSql);

    if (empty($aResultado)) {
      die('Erro ao utilizar método buscarInfoDB: ' . mysql_error());
      return false;
    }

//    $this->iLinhas = mysql_num_rows($sResultado);
    $this->iLinhas = count($aResultado);

    if ($this->iLinhas == 0) {
      return false;
    }

    $this->aRETDB = array();

    if ($bUsaNomeCamposNoRetorno) {

      foreach ($aResultado as $i => $aDados) {
        foreach ($aDados as $mChave => $sValor) {
          if (is_numeric($mChave))
            continue;
          $this->aRETDB[$i][$mChave] = $sValor;
        }
      }
    } else {
//      while ($aResultado = mysql_fetch_row($sResultado)) {
//        $this->RETDB[] = $aResultado;
//        $aRetDB = $aResultado;
//      }
    }

    return $this->aRETDB[0];
  }

  /* wTools::buscarParametro
   *
   * Busca valores salvos na tabela de parâmetros
   * Exemplo de utilização:
   *  $aParam = $oUtil->buscarParametro(array('MAIL_MASTER'));
   *  echo $aParam['MAIL_MASTER'][0].' - ' .$aParam['MAIL_MASTER'][1]
   *
   * Deve ser usado somente uma vez por página para evitar chamadas desnecessárias
   *
   * @date 19/11/2011
   * @update 05/05/2015 Começa a buscar o valor padrão do parâmetro caso não haja
   *                    um valor salvo
   * @param  string $mParametros - Array ou String contendo os parâmetros solicitados
   * @return array               - Dados montados
   */

  public function buscarParametro($mParametros) {

    $sParametros = $this->montarIN($mParametros);

    $sTabela = 'tcseg_parametros';

    $sQuery = "SELECT IFNULL(seg_parametros_valores.tx_valor,seg_parametros.vl_padrao) AS TX_VALOR,
                      seg_parametros.cd_parametro AS CD_PARAMETRO
                 FROM seg_parametros
           LEFT JOIN seg_parametros_valores ON seg_parametros_valores.id_parametro = seg_parametros.id
                WHERE seg_parametros.cd_ativo = 'A'
                  AND seg_parametros.cd_parametro IN (" . $sParametros . ")";

//    $sResultado = mysql_query($sQuery);
    $aResultado = $this->oBd->query($sQuery);

    if (empty($aResultado)) {
      die('Erro ao buscar parâmetro de configuração');
      return false;
    }


    foreach ($aResultado as $i => $aValor) {
      $this->aParametros[$aValor['CD_PARAMETRO']][] = $aValor['TX_VALOR'];
    }

    return $this->aParametros;
  }

  /* wTools::montarIN
   *
   * Busca valores salvos na tabela de parâmetros
   * @date 19/11/2011
   * @param  string $mParametros - Array ou String contendo os parâmetros solicitados
   * @return $sValorMontado               - Extensao do arquivo
   */

  public function montarIN($mValores) {
    if (!is_array($mValores)) {
      $aValores = explode(',', $mValores);
    } else {
      $aValores = $mValores;
    }
    $sValorMontado = '';
    foreach ($aValores as $sValor) {
      // Isto aqui deu erro ao enviar para o servidor, por isso tirei o anti injection
      $sValorMontado .= "'" . $this->anti_sql_injection($sValor) . "', ";
      //$sValorMontado .= "'".$sValor."', ";
    }
    $sValorMontado = substr($sValorMontado, 0, -2);

    return $sValorMontado;
  }

  /* wTools::resumirTexto
   *
   * Trata um conteúdo deixando somente uma quantidade de texto para ser usada
   * como resumo.
   * @date 04/12/2011
   * @param  string $sParagrafo  - Texto a ser tratado
   * @param  integer $iQntLetras - Quantidade de caracteres que serão exibidos
   * @return string $sResumo     - Texto tratado no tamanho definido
   */

  public function resumirTexto($sParagrafo, $iQntLetras) {
    $sParagrafo = strip_tags($sParagrafo);

    $sResumo = substr($sParagrafo, 0, $iQntLetras);
    $iCorta = strrpos($sResumo, " ");
    $sResumo = substr($sParagrafo, 0, $iCorta);

    return $sResumo;
  }

  /* wTools::caixaItensRelacionados
   *
   * Monta uma caixa que apresenta uma lista de links relacionados a um assunto
   * para que o usuário continue navegando
   * @date  12/02/2012
   * @param string $sSql   - Script para busca de dados
   * @param string $sClass - Estilo que será apresentada a lista
   * @return true
   */

  public function caixaItensRelacionados($sSql, $sClass, $sDesc = 'Itens Relacionados:') {

    $this->buscarInfoDB($sSql);
    ?>
    <div class="<?php echo $sClass; ?>">
      <h3><?php echo $sDesc; ?></h3>
      <ul>
    <?php
    foreach ($this->RETDB as $aDados) {
      ?>
          <li><?php $this->montaLink($aDados[0], $aDados[1]); ?></li>
    <?php }
    ?>
      </ul>
    </div>

    <?php
    return true;
  }

  /* wTools::montarStringDados
   *
   * Transforma um array em uma string, mantendo os valores separados por:
   * [chave] valor do campo
   * @date  19/03/2012
   * @param array $aDados - No formato array('indice' => 'valor do campo')
   * @return string montada
   */

  public function montarStringDados($aDados) {
    if (!is_array($aDados)) {
      return false;
    }

    $sRet = '';
    foreach ($aDados as $sChave => $sValor) {
      $sRet .= '##C_' . $sChave . '**V_' . $sValor;
    }
    return $sRet;
  }

  /* wTools::desmontarStringDados
   *
   * Transforma uma string em um array, mantendo os valores separados por:
   * [chave] valor do campo
   * @date  19/03/2012
   * @param string $sDados - No formato ##C_campo**V_valor
   * @return array $aDados
   */

  public function desmontarStringDados($sDados) {
    $aResult = explode('##', $sDados);
    array_shift($aResult);
    $aRet = array();

    foreach ($aResult as $sChave) {
      $sChave = str_replace(array('C_', 'V_'), '', $sChave);
      $aChaveValor = explode('**', $sChave);

      $aRet[$aChaveValor[0]] = $aChaveValor[1];
    }
    return $aRet;
  }

  /* wTools::msgRetAlteracoes
   *
   * Mensagem de retorno ao usuário após alterações realizadas em registros
   * Atualização: 14/05/2012 - $mResultado passa a aceitar array com as mensagens
   *
   * @date 07/05/2011
   *
   * @param mixed  $mCdMsg      - Tipo de resultado pode ser um codigo (0, 1, 2),
   *                              uma mensagem tipo 'sucesso' ou um array
   * @param string $sMsg        - Mensagem para apresentação na tela
   * @param string $sMsgErro    - Mensagem de erro caso aconteça
   * @param bool   $bMarcaVazio - Preenche com uma div o espaço euquando não há mensagem a ser exibida de retorno ao usuário
   * @return true
   */

  public function msgRetAlteracoes($mResultado = '', $sMsg = '', $sMsgErro = '', $bMarcaVazio = true) {

    if (is_array($mResultado)) {
      $this->sMsg = $mResultado['sMsg'];
      $this->sErro = isset($mResultado['sErro']) ? $mResultado['sErro'] : null;
      $mResultado = $mResultado['iCdMsg'];
    }

    if (isset($this->sResultado)) {
      $mResultado = $this->sResultado;
    }
    if (!isset($mResultado)) {
      if ($bMarcaVazio) {
        ?>
        <div class="msg-vazio">&nbsp;</div> <?php
      }
      return false;
    }
    if (isset($this->sMsg)) {
      $sMsg = $this->sMsg;
    }
    if (isset($this->sErro) && $this->sErro != '') {
      $sMsgErro = $this->sErro;
    }

    switch ($mResultado) {
      case 'sucesso':
      case '0':
        ?>
        <div class="msg-ok"><?php echo $sMsg ?></div> <?php
        break;

      case 'erro':
      case '1':
        ?>
        <div class="msg-erro"><?php echo $sMsg;
        echo ($sMsgErro) ? $sMsgErro : ''
        ?></div><?php
        break;

      case 'atencao':
      case '2':
        ?>
        <div class="msg-atencao"><?php echo $sMsg;
        echo ($sMsgErro) ? ' - ' . $sMsgErro : ''
        ?></div><?php
        break;

      default:
        if ($bMarcaVazio) {
          ?>
          <div class="msg-vazio">&nbsp;</div> 
          <?php
        }
        break;
    }
    return true;
  }

  /* wTools::msgRetAlteracoes_montar
   *
   * Monta o array de mensagens de alterações
   * 
   * @date  08/05/2012
   * @param integer $iCdMsg  - 0: Sucesso, 1:Erro , 2: Atenção
   * @param string $sMsg     - Mensagem que é exibida na tela
   * @param string $sMsgErro - Em caso de erro, alguma mensagem pode ser informada ao usuário
   * @return array $aMsg
   */

  public function msgRetAlteracoes_montar($iCdMsg, $sMsg, $sResultado = '', $sMsgErro = '') {
    $aMsg = array();
    $aMsg['iCdMsg'] = $iCdMsg;
    $aMsg['sMsg'] = $sMsg;
    $aMsg['sErro'] = $sMsgErro;
    $aMsg['sResultado'] = $sResultado;
    return $aMsg;
  }

  /* wTools::tratarString
   *
   * Trabalha uma string passada como parâmetro
   *
   * @date  04/06/2012
   * @param string $sString  - String a ser tratada
   * @param string $iTipo    - Tipo de tratamento
   * @return string  $sRetorno
   */

  public function tratarString($sString, $iTipo) {

    switch ($iTipo) {

      // Removendo símbolos de uma string (caracteres não alfa-numéricos)
      case 0:
        $sRetorno = trim(preg_replace("/[^a-zA-Z0-9\s]/", "", $sString));
        break;

      // Removendo símbolos e números
      case 1:
        $sRetorno = trim(preg_replace("/[^a-zA-Z\s]/", "", $sString));
        break;

      // Removendo letras e símbolos
      case 2:
        $sRetorno = trim(preg_replace("/[^0-9\s]/", "", $sString));
        break;

      // Removendo símbolos de uma string (caracteres não alfa-numéricos, incluindo espaço)
      case 3:
        $sRetorno = trim(preg_replace("/[^a-zA-Z0-9]/", "", $sString));
        break;
    }
    return $sRetorno;
  }

  /**
   * wTools::showNumero()
   *
   * Mostra campos numéricos
   *
   * @param string  $sNome      Nome do campo
   * @param integer $iTamMax    Número máximo de caracteres digitáveis (maxlength)
   * @param string  $sValor     Valor inicial
   * @param integer $iDigitos   Número de casas decimais
   * @param float   $fValMin    Valor mínimo admissível para o campo (pode ser vazio, se não houver limite)
   * @param float   $fValMax    Valor máximo admissível para o campo (pode ser vazio, se não houver limite)
   * @param integer $iTam       Tamanho do campo (size)
   * @param string  $sParms     Parâmetros adicionais a incluir no campo (class, etc.)
   * @param string  $sMascara   Máscara de caracteres válidos, no formato de uma expressão regular
   * @param array   $aExtraFunc Array contendo como chave a função JS na qual será concatenado o valor passado naquela chave
   * @param string  $sIdForm    String contendo o id do campo no formulário
   * @param Boolean $bMascara   Boolean informando se deve (padrao true) ou não (false) usar funcao JS de formatacao de dinheiro
   * @param Boolean $bEcho      Boolean informando se deve imprimir ou retornar a string do input html
   *
   * @access public
   * @author Equipe Ditech <ditech@ditech.com.br>
   */
  function showNumero($sNome, $iTamMax, $sValor = '', $iDigitos = 2, $fValMin = '', $fValMax = '', $iTam = 0, $sParms = '', $sMascara = '0-9', $aExtraFunc = '', $sIdForm = '', $bMascara = true, $bEcho = true, $bBloqueiaEnter = false) {
    if ($iTam == 0) {
      $iTam = ceil($iTamMax * 1.5);
    }
    if (!$sIdForm) {
      $sIdForm = $sNome;
    }

    $sInput = '<input size="' . $iTam . '" type="text" name="' . $sNome . '" id="' . $sIdForm . '" maxlength="' . $iTamMax . '" value="' . $sValor . '" onKeyPress="return validaTecla(this, event, \'\', \'' . ($bBloqueiaEnter ? 'true' : 'false') . '\'); ' . $aExtraFunc['onKeyPress'] . '" ' . ' onBlur="' . ($fValMin != '' || $fValMax != '' ? 'verifyRange(this, ' . (float) $fValMin . ', ' . (float) $fValMax . ');' : '') . ($bMascara ? 'mascaraDinheiro(this, ' . $iDigitos . ');' : '') . $aExtraFunc['onBlur'] . '" ' . 'onFocus="focaNumero(this);' . $aExtraFunc['onFocus'] . '"' . $sParms . '>';
    if ($bEcho == true) {
      echo $sInput;
    } else {
      return $sInput;
    }
  }

  /**
   * DitechUtil::showValor()
   *
   * Mostra campos de valor (dinheiro)
   *
   * @param string $sNome     - nome do campo
   * @param string $sId       - id do campo
   * @param integer $iTamMax  - maxlength
   * @param string $sValor    - valor inicial
   * @param integer $iDigitos - casas decimais
   * @param string $iValMin   - valor mínimo para o campo
   * @param string $iValMax   - valor máximo para o campo
   * @param integer $iTam     - size
   * @param string $sParms    - parâmetros adicionais
   * @param Boolean $bEcho      Boolean informando se deve imprimir ou retornar a string do input html
   * @param array   $aExtraFunc Array contendo como chave a função JS na qual será concatenado o valor passado naquela chave
   * @return string
   * */
  function showValor($sNome, $sId, $iTamMax = 14, $sValor = '', $iDigitos = 2, $iValMin = '0', $iValMax = '9999999999999', $iTam = 18, $sParms = '', $bEcho = true, $aExtraFunc = '', $bBloqueiaEnter = false) {

    $sInput = '<input type="text" name="' . $sNome . '" id="' . $sId . '" value="' . $sValor . '" size="' . $iTam . '" maxlength="' . $iTamMax . '" style="text-align: right;"' . ' onFocus="if(this.value==\'0,00\')this.value=\'\'; focaNumero(this); ' . $aExtraFunc['onFocus'] . '" ' . ' onBlur="if(this.value==\'\')this.value=\'0,00\'; verifyRange(this, ' . $iValMin . ', ' . $iValMax . '); mascaraDinheiro(this, ' . $iDigitos . '); ' . $aExtraFunc['onBlur'] . '" ' . ' onKeyPress="return validaTecla(this, event, \'\', \'' . ($bBloqueiaEnter ? 'true' : 'false') . '\'); ' . $aExtraFunc['onKeyPress'] . '"' . ' ' . $sParms . '>';
    if ($bEcho) {
      echo $sInput;
    } else {
      return $sInput;
    }
  }

  public function criarSigla($sStr, $sTabela = null, $sCampo = null) {
    $aNomes = array();
    $aDados = explode(' ', $sStr);
    $iQnt = count($aDados);

    // Passo 1
    foreach ($aDados as $sNome) {

      // Nome escolhido tem que ter mais de 2 caracteres e guarda no array somente 3 nomes
      if (strlen($sNome) > 2 && count($aNomes) < 3) {
        $aNomes[] = trim($sNome);
      }
    }

    // Passo 2
    if (count($aNomes) < 3) {
      for ($i = count($aNomes); $i < 3; $i++) {
        $aNomes[$i] = $aNomes[0];
      }
    }

    // Passo 3
    $aNomesOk = array();
    foreach ($aNomes as $sNome) {
      $aNomesOk[] = strtoupper($this->montaUrlAmigavel($sNome, false));
    }

    // Passo 4
    if (!is_null($sTabela) && !is_null($sCampo)) {
      $this->pegaInfoDB($sTabela, 'distinct(' . $sCampo . ')');
      foreach ($this->RETDB as $aRet) {
        $aCdProjExistentes[] = $aRet[0];
      }
    }
    $aCdProjExistentes[] = '';

    // Passo 5
    $c = 1;
    $this->a = 0;
    $this->b = 0;
    $this->c = 0;
    $this->iQnt1 = strlen($aNomesOk[0]);
    $this->iQnt2 = strlen($aNomesOk[1]);
    $this->iQnt3 = strlen($aNomesOk[2]);



    do {
      $sSigla = $this->logicaSigla($aNomesOk);
      $c++;
    } while (in_array($sSigla, $aCdProjExistentes) && ($c < 15));
    $sSigla = $sSigla == '' ? 'ZER' : $sSigla;

    return $sSigla;
  }

  public function logicaSigla($aNomesOk) {

    $sSigla = $aNomesOk[0][$this->a];
    $sSigla .= $aNomesOk[1][$this->b];
    $sSigla .= $aNomesOk[2][$this->c];

    if (($this->iQnt1 > $this->a + 1)) {
      $this->a++;
    } else {
      $this->a = 0;
    }
    if (($this->iQnt2 > $this->a + 1)) {
      $this->b = $this->a + 1;
    } else {
      $this->b = 0;
    }
    if ($this->iQnt3 > $this->b + 1) {
      $this->c = $this->b + 1;
    } else {
      $this->c = 0;
    }


    if ($sSigla[0] == $sSigla[1] && $sSigla[1] == $sSigla[2]) {
      $sSigla = $this->logicaSigla($aNomesOk);
    }
    return $sSigla;
  }

  function randomStringGenerator($length = 10, $bUpper = true) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return ($bUpper) ? strtoupper($randomString) : $randomString;
  }

  public function breadCrumbs() {
    
  }

  /* wTools::plural
   *
   * Verifica a necessidade de uma palavra usar ou não o "s" no final
   *
   * @date  30/03/2013
   * @param string $mTeste  - Valor a ser testado
   * @return string  $sRetorno - 'S' ou ''
   */

  public function plural($mTeste, $iNecessario = 1) {
    return ($mTeste > $iNecessario) ? 's' : '';
  }

  /* wTools::buscarNomePaginaAtual
   *
   * Define de forma automática o nome da página atual
   *
   * @date  08/02/2015
   * @return string  nome da página atual
   */

  public function buscarNomePaginaAtual() {
//    $aRet = explode('/', $_SERVER['SCRIPT_FILENAME']);
    $aRet = explode('/', $_SERVER['REQUEST_URI']);
//    $bPainel = (in_array('painel', $aRet));
    // Remove elementos vazios do array
    $aRet = array_filter($aRet);

    $sPgAtual = array_pop($aRet);
    $aPgAtual = explode('.', $sPgAtual);

    $sPgAtual = strtolower(strtolower(array_shift($aPgAtual)));
    return $sPgAtual;
  }

  /* wTools::buscarNomePaginaAnterior
   *
   * Define de forma automática o nome da página anterior
   *
   * @date  01/05/2015
   * @return string  nome da página anterior
   */

  public function buscarNomePaginaAnterior($bExtensao = false) {
    $aRet = explode('/', $_SERVER['HTTP_REFERER']);
    $sPgAnterior = array_pop($aRet);
    if (!$bExtensao) {
      $aPgAtual = explode('.', $sPgAnterior);
      $sPgAnterior = strtolower(strtolower(array_shift($aPgAtual)));
    }
    return $sPgAnterior;
  }

  /* wTools::somarData
   *
   * Define de forma automática o nome da página atual
   *
   * @date  21/03/2015
   * @param $sData  Data de referência
   * @param $aParametros 
   * @return string  nome da página atual
   */

  public function somarData($sData, $aParametros) {
    $iMeses = isset($aParametros['iMeses']) ? $aParametros['iMeses'] : 0;
    $iAno = isset($aParametros['iAno']) ? $aParametros['iAno'] : 0;
    $iDias = isset($aParametros['iDias']) ? $aParametros['iDias'] : 0;
    $aData = explode('/', $sData);
    $sNovaData = date('d/m/Y', mktime(0, 0, 0, $aData[1] + $iMeses, $aData[0] + $iDias, $aData[2] + $iAno));
    return $sNovaData;
  }

  /* wTools::buscarUltimoId
   *
   * Faz uma consulta à uma tabela no banco de dados e traz o último ID
   * @date 21/06/2015
   * @param string $sTabela  - Tabela a ser consultada
   * @return integer
   */

  public function buscarUltimoId($sTabela) {

    $sQuery = 'SELECT max(ID)
                 FROM ' . $sTabela;

    $aResult = $this->oBd->query($sQuery);

    return $aResult[0][0];
  }

  /* wTools::buscarProximoId
   *
   * Faz uma consulta à uma tabela no banco de dados e traz o próximo ID
   * @date 21/06/2015
   * @param string $sTabela  - Tabela a ser consultada
   * @return integer
   */
  public function buscarProximoId($sTabela) {

    $sQuery = 'SELECT max(ID) + 1
                 FROM ' . $sTabela;

    $aResult = $this->oBd->query($sQuery);
    return $aResult[0][0];
  }
  
  /* wTools::listarPastas
   *
   * Guarda no array os diretórios do caminho passado como parâmetro
   * @date 24/08/2015
   * @param string $sCaminho Caminho dos diretórios 
   * @return boll
   */
  public function listarPastas($sCaminho, $bSubPastas = false) {
    $this->aPastas = array();
    $hDir = opendir($sCaminho);

    while (false!==($sPasta=readdir($hDir)))  {
      
      if ($bSubPastas == false) {
        if (in_array($sPasta, array('.','..'))) {
          continue;
        }
      }
      
      if (is_dir($sCaminho.'/'.$sPasta)) {
        $this->aPastas[] = $sPasta;
      }
    }

    arsort($this->aPastas); 
    return true;
  }

  /* wTools::listarConteudoPastas
   *
   * Guarda no array os arquivos de uma pasta
   * @date 24/08/2015
   * @param string $sCaminho Caminho dos diretórios 
   * @return bool
   */
  public function listarConteudoPastas($sPasta) {
    $this->aArquivos = array();
    $hDir = opendir($sPasta);
    while (false!==($sArquivo=readdir($hDir)))  {
      if (is_file($sPasta.'/'.$sArquivo)) {
        $this->aArquivos[] = $sArquivo;
      }
      sort($this->aArquivos); 
    }
    if (empty($this->aArquivos)) {
      return false;
    }
    return true;
  }

  /* wTools::montarTabelaHtmlPorLinhas
   *
   * Monta uma tabela Html dinâmicamente
   * @date 23/01/2016
   * @param $aEntrada - Dados em formato de string para serem apresentados
   *        $iLinhas  - Quantidade de linhas que a tabela terá
   * @return bool
   */
  public function montarTabelaHtmlPorLinhas($aEntrada, $iLinhas) {
    $aDados = array();
    $iIndice = $i = 0;
    
    $iTotal = count($aEntrada);

    $this->iMaiorColuna = ceil($iTotal/$iLinhas);
    
    
    foreach ($aEntrada as $sValor) {
      
      if ($i >= $this->iMaiorColuna) {
        $iIndice++;
        $i = 0;
      }
        
      $aDados[$iIndice][] = $sValor;
      $i++;
    }
    
    $aDados = $this->prepararArrayToTable($aDados);
    
    $this->montarTabelaHtml($aDados);
  }
  
  
  /* wTools::montarTabelaHtmlPorColunas
   *
   * Monta uma tabela Html dinâmicamente
   * @date 23/01/2016
   * @param $aEntrada - Dados em formato de string para serem apresentados
   *        $iCols    - Quantidade de colunas que a tabela terá
   * @return bool
   */
  public function montarTabelaHtmlPorColunas($aEntrada, $iCols) {

    $aDados = array();
    $iIndice = $i = 0;
    
    //$iTotal = count($aEntrada);

    $this->iMaiorColuna = $iCols - 1;  

    foreach ($aEntrada as $sValor) {      
      $aDados[$iIndice][] = $sValor;

      if ($i >= $this->iMaiorColuna) {
        $i = -1;
        $iIndice++;
      }
      $i++;
    }
    
    $aDados = $this->prepararArrayToTable($aDados);
    
    $this->montarTabelaHtml($aDados);

  }
  
  /* wTools::prepararArrayToTable
   *
   * Usado internamente ao ser chamado nos métodos montarTabelaHtmlPorColunas 
   * e montarTabelaHtmlPorColunas
   * @date 23/01/2016
   * @param $aDados - Prepara os dados conforme o esperado para apresentar na tela
   * @return bool
   */
  private function prepararArrayToTable($aDados) {
    $i = 0;
    for ($iIndice = 0; $iIndice < count($aDados); $iIndice++) {
      $i = 0;
      while ($i <= $this->iMaiorColuna) {
        if (!isset($aDados[$iIndice][$i])) $aDados[$iIndice][$i] = '';
        //echo 'Linha '.$iIndice.' Coluna: '.$i." --> ".$aDados[$iIndice][$i]."<br>";
        $i++;
      }
    }
    return $aDados;
  }

  /* wTools::prepararArrayToTable
   *
   * Imprime na tela em formato de tabela HTML os dados que são passados pelo 
   * parâmetro. 
   * O array deve estar formatado.
   * 
   * @date 23/01/2016
   * @param $aDados - Dados já formatados com quantidade de linhas e colunas.
   * @return bool
   */
  private function montarTabelaHtml($aDados) { ?>
    <table> <?php
    for ($iIndice = 0; $iIndice < count($aDados); $iIndice++) {
      $i = 0; 
      //echo 'Row['.$iIndice.']'; ?>
      <tr> <?php
      while ($i <= $this->iMaiorColuna) {
        //echo 'Col['.$i.'] ';?>
        <td><?php echo $aDados[$iIndice][$i]?></td><?php
        $i++;
      }?>
       <tr><?php
    }?>
    </table><?php
  }
  
  
  /* wTools::substituirTagPorImagem
   *
   * Imprime na tela em formato de tabela HTML os dados que são passados pelo 
   * parâmetro. 
   * O array deve estar formatado.
   * 
   * @date 31/01/2016
   * @param sConteudo -  String que será salva no banco de dados antes do parse
   *                     ser realizado
   * @param sDiretorio - Local onde as imagens estão armazenadas
   * @return string    - Retorna o conteúdo pronto para ser usado
   */
  public function substituirTagPorImagem($sConteudo, $sDiretorio) {

     
    while ($iPosInicio = stripos($sConteudo, '&lt;#')) {

      $iPosFinal  = stripos($sConteudo, '#&gt;');
      $iTamanho = $iPosFinal - $iPosInicio;
      $sNomeImagem = substr($sConteudo, ($iPosInicio + 5), ($iTamanho - 5));
      
      $sImagem = '<img src="'.$sDiretorio.$sNomeImagem.'" alt="'.$sNomeImagem.'" />';

      $sPadrao = substr($sConteudo, $iPosInicio, ($iTamanho + 5));
      $sConteudo = str_replace($sPadrao, $sImagem, $sConteudo);
              
    }
    return $sConteudo;
      
    
  }
  
    
  public function retornarTrueSeEhDesenv () {
    $aHostLocais = array ('localhost', '192.168.0.4');
    return in_array($_SERVER['SERVER_NAME'], $aHostLocais);
  }
  
}
?>