<?php
$file = fopen('https://www.google.com.br/search?sclient=psy-ab&safe=off&biw=1440&bih=542&q=rodrigo+site:judobrasilia.com.br&oq=rodrigo+site:judobrasilia.com.br&gs_l=serp.12...0.0.0.3449.0.0.0.0.0.0.0.0..0.0....0...1c..64.psy-ab..0.0.0.za4wiQt3C9M&pbx=1&bav=on.2,or.r_cp.&fp=eb603fd52d0cd25e&dpr=1&tch=1&ech=1&psi=MXuNVZj6HIjz-AGJ0q_4Cw.1435335509217.3','r');
$conteudo = stream_get_contents($file);
echo $conteudo;
?>