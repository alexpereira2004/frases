<?php

$html = file_get_contents('http://www.frasesdobem.com.br/');


preg_match_all('/<p class="frase">(.|\n)*?<\/p>/',
               $html,
               $matches
);

foreach ($matches[0] as $frase) {
  echo utf8_decode($frase);
  echo "\n";
  
}