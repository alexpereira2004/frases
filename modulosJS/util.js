
$(document).ready(function() {
    
//    $(".mask_cep").mask("99999-999");
//    $(".mask_data").mask("99/99/9999");
//    $(".mask_telefone").mask("(99)9999-9999");
//    $(".mask_cnpj").mask("99.999.999/9999-99");
//    $(".mask_cpf").mask("999.999.999-99");
//    
//    $('.moeda').keyup(function(){
//      moeda(this);
//    });

});


// Função para texto piscar
  // $('.blink').blink();
  $.fn.blink = function(options) {
    var defaults = { delay:500 };
    var options = $.extend(defaults, options);

    return this.each(function() {
      var obj = $(this);
      setInterval(function() {
          if($(obj).css("visibility") == "visible") {
            $(obj).css('visibility','hidden');
          } else {
            $(obj).css('visibility','visible');
          }
      }, options.delay);
    });
  }
  
  function retiraMascaraMoeda(v) {
      
    if (v === '') return 0;

    v=v.replace('.',"");
    v=v.replace(',',".");
    
    return ( parseFloat(v).toString() );
      
  }
  function moeda(z){  
//  $.fn.moeda = function(options) {alert('dentro');
    
    v = z.value;

    if (v.length > 14) {
      z.value = v.substr(0, 14);
      return;
    }
    v=v.replace(/\D/g,"")  //permite digitar apenas números
    v=v.replace(/[0-9]{12}/,"inválido")   //limita pra máximo 999.999.999,99
    v=v.replace(/(\d{1})(\d{8})$/,"$1.$2")  //coloca ponto antes dos últimos 8 digitos
    v=v.replace(/(\d{1})(\d{5})$/,"$1.$2")  //coloca ponto antes dos últimos 5 digitos
    v=v.replace(/(\d{1})(\d{1,2})$/,"$1,$2")        //coloca virgula antes dos últimos 2 digitos
    z.value = v;
  }
  
  function fomatarNumero() {

    fNum = fNum.toString();
    if (fNum.indexOf(',') != -1) {
      fNum = fNum.replace(/\./g, '');
      fNum = fNum.replace(',','.');
    }

    fNum = number_format(fNum, iDigitos, '.', '');
    return parseFloat(fNum);

  }
  
  function removerViaCheckBox(sMsgConfirm, sAction, sAcao) {

    if ($('.checkRemover').filter(':checked').length === 0) {
      alert('Selecione um registro!');
      return;
    }

    if (confirm(sMsgConfirm)) {
      iIdRef = $('#CMPid').val();
      // Form dinamico
      $('body').append('<form name="FRMdinamico" id="FRMdinamico" action="'+sAction+'" method="post">');
      $('#FRMdinamico').append('<input type="hidden" name="sAcao" value="'+sAcao+'" />');

      $('#FRMdinamico').append('<input type="hidden" name="CMPid" value="'+iIdRef+'" />');

      $('.checkRemover').each(function(iSeq, oElemento){
        
        if ($(oElemento).prop( "checked" ) === true) {
          iId = $(oElemento).val();
          $('#FRMdinamico').append('<input type="hidden" name="CMPaId[]" value="'+iId+'" />');
        }
      });
      $('#FRMdinamico').submit();
    }
  }