<?php
error_reporting(E_ALL ^ E_DEPRECATED);

/**
 * 
 *
 * @author Alex Lunardelli
 */
define('CFG_USUARIO_NIVEL'              , 'aNivelUsuario');
define('CFG_USUARIO_STATUS'             , 'aStatus');
define('CFG_STATUS'                     , 'aStatus');
define('CFG_IMG_CAMINHO'                , 'sCaminhoImagens');
define('CFG_IMG_DIR_VITRINE'            , 'sDirImgVitrine');
define('CFG_IMG_DIR_USUARIO_UPLOAD'     , 'sCaminhoUsuarioUpload');
define('CFG_IMG_DIR_GALERIA'            , 'sCaminhoGaleria');
define('CFG_IMG_VITRINE_UPLOAD'         , 'oConfigUploadVitrine');
define('CFG_IMG_UPLOAD'                 , 'sCaminhoImagensUpload');
define('CFG_HTML_GERAL_SECAO'           , 'sHtmlGeralSecao');
define('CFG_HTML_GERAL_LOCAL_ESTILOS'   , 'sHtmlGeralLocalEstilos');
define('CFG_CAMPOS_FORM_TIPO'           , 'aCamposFormTipo');



class config {
  
  public $sPgAtual;
  public $aMsg;
  public $aParametros;

  public function __construct($sPgAtual = '0') {
    $this->aMsg    = array('iCdMsg' => '', 'sMsg' => '', 'sMsgErro' => '');
    $this->sPgAtual = $sPgAtual;
    $this->definirParametros();
  }

  /* config::incluirCss
   *
   * @date 23/02/2015
   * @param  
   * @return bool
   */
  public function incluirCss() {?>
    <link rel="stylesheet" type="text/css" href="comum/estilos.css" />
    <link rel="stylesheet" type="text/css" href="comum/sprites.css" />
    <link href='http://fonts.googleapis.com/css?family=Oxygen' rel='stylesheet' type='text/css'>
  <?php  
  }

  /* config::incluirJs
   *
   * @date 23/02/2015
   * @param  
   * @return bool
   */
  public function incluirJs() { ?>
    <script src="modulosJS/jquery-2.1.3.min.js"	   type="text/javascript"></script>
    <script src="modulosJS/slider/js/jssor.slider.mini.js"></script>
    <?php
    return true;
  }



  /* config::buscar
   *
   * Cria um resumo de um texto passado como parâmetro
   * @date 23/02/2015
   * @param  string $sParam - Parâmetro a ser usado
   * @return mixed	    - false caso a configuração não exista, senão, o valor
   *			      do campo.
   */
  public function buscar($sParam) {
    include_once 'class.param_imagem_upload.php';
    $oImagensVitrine = new param_imagem_upload();

    $aConfiguracoes = array(
        'aStatus'             => array('AT' => 'Ativo', 
                                       'IN' => 'Inativo'),
        'sHtmlGeralSecao'     => array('geral' => 'Geral', 
                                       ),

        'aNivelUsuario'        => array( 5  => 'Administrador',
                                         7  => 'Comissão Técnica',
                                         10 => 'Atleta'),

        'sCaminhoImagens'        => 'comum/imagens/',
        'sCaminhoGaleria'        => 'comum/imagens/galeria/imagem-usuario/',
        'sCaminhoUsuarioUpload'  => 'comum/imagens/galeria/imagem-usuario/upload/',
        'sHtmlGeralLocalEstilos' => 'comum/estilos-html-geral/',
        'sDirImgVitrine'         => 'vitrine',
        'sCaminhoImagensUpload'  => 'comum/imagens/galeria/imagem-usuario/upload/',
        'oConfigUploadVitrine'   => $oImagensVitrine,
        
        'aCamposFormTipo' => array( 'M' => 'moeda',
                                    'A' => 'text',
                                    'H' => 'text',
                                    'I' => 'digito',
                                    'S' => 'text',
                                    'D' => 'dt-br',
                                    'O' => 'text',
                                    'M' => 'text',
                                    'H' => 'hora',
                                    'L' => 'bool',
                                    'T' => 'text',
                                    'P' => 'senha')
        );
    
    if (isset($aConfiguracoes[$sParam])) {
      return $aConfiguracoes[$sParam];
    }

    return false;
  }


  private function definirParametros() {

    $this->aParametros = array(
      
	// Parâmetros específicos por páginas 
       '0' => array('titulo'   => 'Parâmetros de configurações não definidos',
                    'backPage' => 'index.php' ),
       'index' => array('titulo'   => 'Bravo FC',
                        'backPage' => 'index.php' ),
     'contato' => array('titulo'   => 'Bravo FC',
                        'backPage' => 'contato.php' ),
        'lancamento-contratos' => array('titulo'   => 'Lançar Contratos',
	 			        'backPage' => 'lancar-contratos.php' ),
        // Usuários
              'admin-usuarios' => array('titulo'   => 'Usuários',
				        'backPage' => 'admin-usuarios.php' ),
       'admin-usuarios-editar' => array('titulo'   => 'Inserir Usuário',
				        'backPage' => 'admin-usuarios.php' ),
       'admin-usuarios-editar' => array('titulo'   => 'Editar Usuário',
				        'backPage' => 'admin-usuarios.php' ),
        
        // Vitrine
              'admin-vitrine' => array('titulo'   => 'Vitrine',
				        'backPage' => 'admin-vitrine.php' ),
       'admin-vitrine-editar' => array('titulo'   => 'Inserir Vitrine',
				        'backPage' => 'admin-vitrine.php' ),
       'admin-vitrine-editar' => array('titulo'   => 'Editar vitrine',
				        'backPage' => 'admin-vitrine.php' ),
        
        
    );
  }
  
  public function buscarTituloHtml() {
    if (isset($this->aParametros[$this->sPgAtual])) {
      return $this->aParametros[$this->sPgAtual]['titulo'];
    }
    return $this->aParametros[0]['titulo'];
  }

  
  public function getInfoBd($sBanco) {
    include_once 'class.database.php';
    $aDados['frases_v1'] = array('sServidor' => 'localhost',
                                  'sUsuario' => 'root',
                                    'sSenha' => 'mylunacom',
                                    'sBanco' => 'frases_v1',
                                       'sBd' => 'mysqli');
     $aDados['producao'] = array('sServidor' => 'localhost',
                                  'sUsuario' => 'lunac207_frases',
                                    'sSenha' => 'D3uBBT6$iZA*',
                                    'sBanco' => 'lunac207_frases',
                                       'sBd' => 'mysqli');

    $oInfoConexao = new database($aDados[$sBanco]);
    return $oInfoConexao;
  }
}
