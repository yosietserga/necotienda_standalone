<?php
require_once(dirname(__FILE__). '/../../vendor/phpQuery.php');
echo "Begin process\n";
$doc = phpQuery::newDocumentHTML(fetch('http://www.pac.com.ve/'));
phpQuery::selectDocument($doc);

foreach(pq('#categoriasContainer li a') as $el) {
    $str = pq($el)->text();
    echo "Map dom document\n";
    if ($str !== mb_convert_encoding(mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32'))
        $str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
    $str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
    $str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $str);
    $str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
    $str = preg_replace(array('`[^a-z0-9]`i', '`[-]+`'), '-', $str);
    $str = strtolower(trim($str, '-'));
    
    $filename = dirname(__FILE__) . '/pac-links-'. $str . '.txt';
    
    if (!file_exists($filename)) {
        $href = 'http://www.pac.com.ve'.pq($el)->attr('href');
        $categorias[] = $cat = array(
            'name'=> pq($el)->text(),
            'url'=>$href,
            'childrens'=>getSubcategorias($href)
        );
        
        $file = fopen($filename, 'w+');
        fputs($file, serialize($cat));
        fclose($file);
    } elseif (file_exists(str_replace('links', 'customers', $filename))) {
        $customers = unserialize(file_get_contents(str_replace('links', 'customers', $filename)));
        if (!file_exists(str_replace('links', 'contacts', $filename))) {
            $file = fopen(str_replace('links', 'contacts', $filename), 'w+');
            fputcsv($file, array('First Name', 'Email Address', 'Url', 'Telephone', 'Address'), ';');

            foreach ($customers as $url) {
                $contact = array();
                $customer = fetch($url);
                $doc = phpQuery::newDocumentHTML($customer);
                phpQuery::selectDocument($doc);
                if (empty(pq('a[itemprop=email]')->text())) continue;
                if (strpos($url, 'sitioweb')) {
                    $contact['name'] = pq('span[itemprop=name]')->text();
                    $contact['email'] = pq('a[itemprop=email]')->text();
                    $contact['url'] = pq('a[itemprop=url]')->text();
                    $contact['phone'] = '';
                    $contact['address'] = '';
                } else {
                    $contact['name'] = pq('span[itemprop=name]')->text();
                    $contact['email'] = pq('a[itemprop=email]')->text();
                    $contact['url'] = pq('a[itemprop=url]')->text();
                    $contact['phone'] = pq('span[itemprop=telephone]')->text();
                    $contact['address'] = pq('span[itemprop=streetAddress]')->text();
                }
                fputcsv($file, $contact, ';');
            }
            fclose($file);
        }
    } else {
        if (!file_exists(str_replace('links', 'customers', $filename))) {
            $categorias = unserialize(file_get_contents($filename));
            echo "File load it\n";
            foreach ($categorias as $children) {
                $links = getLinks($children);
                
                if ($links) {
                    $file = fopen(str_replace('links', 'customers', $filename), 'w+');
                    fputs($file, serialize($links));
                    fclose($file);
                }
            }
        }
    }
}

function getLinks($childrens, $links=array()) {
    foreach ($childrens as $child) {
        if (isset($child['childrens'])) {
            echo "Iterate childrens\n";
            $links = getLinks($child['childrens'], $links);
        } else {
            echo "Children load it for url: {$child['url']}\n";
            $pages = range(1,5);
            foreach ($pages as $page) {
                echo "Children load it for url: {$child['url']}&pagina=$page\n";
                $listado = fetch($child['url'].'&pagina='.$page);
                $doc = phpQuery::newDocumentHTML($listado);
                phpQuery::selectDocument($doc);
                foreach(pq('.aviso h3 a') as $el) {
                    $url = 'http://www.pac.com.ve' . pq($el)->attr('href');
                    if (strpos($url, '&ubicacion=')) {
                        $href = substr($url, 0, strpos($url, '&ubicacion='));
                    } else {
                        $href = $url;
                    }
                    $links[] = $href;
                }
            }
        }
    }
    return $links;
}

function getSubcategorias($url) {
    $doc = phpQuery::newDocumentHTML(fetch($url));
    phpQuery::selectDocument($doc);
    
    foreach(pq('.listc li h2 a') as $el) {
        $url = 'http://www.pac.com.ve'.pq($el)->attr('href');
        
        if (strpos($url, '&ubicacion=')) {
            $href = substr($url, 0, strpos($url, '&ubicacion='));
        } else {
            $href = $url;
        }
        echo 'LINEA '. __LINE__. ': '.  $url ."\n";
        echo 'LINEA '. __LINE__. ': '.  $href ."\n";
        $subcategorias[] = array(
            'name'=> pq($el)->text(),
            'url'=>$href,
            'childrens'=>getSubcategorias($href)
        );
    }
    return isset($subcategorias) ? $subcategorias : null;
}

function fetch($url) {
    $curl_handle=curl_init();
    curl_setopt($curl_handle, CURLOPT_URL,$url);
    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:20.0) Gecko/20100101 Firefox/20.0');
    $response = curl_exec($curl_handle);
    curl_close($curl_handle);
    return $response;
}
