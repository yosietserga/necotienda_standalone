<?php
require_once(dirname(__FILE__). '/../phpQuery.php');
echo __LINE__;
$html = file_get_contents('http://paginasamarillas.infoguia.net/PagAm/PagAm.asp?key=instrumentos-musicales-caracas&cat=752&ciud=41#21101464');

$pq = phpQuery::newDocument($html);
phpQuery::selectDocument($html);
echo __LINE__;
var_dump($pq);
echo __LINE__;
foreach(pq('.menu_aviso') as $link) {
	if (!strpos('?emp=')) continue;
	var_dump($link);
	echo pq($link)->attr('href') . '<br />';
}
echo __LINE__;

//('.menu_contactar').data('mail')
echo __LINE__;