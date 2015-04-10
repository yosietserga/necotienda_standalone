<?php

require_once(dirname(__FILE__) . '/../../vendor/phpQuery.php');
echo "Begin process\n";

$categories = range(0, 9);

$filename = dirname(__FILE__) . '/cavecal-links.txt';

if (!file_exists($filename)) {
    $file = fopen($filename, 'a+');
    foreach ($categories as $cat) {

        echo "leyendo la pagina $cat\n\r";

        $doc = phpQuery::newDocumentHTML(fetch('http://www.cavecal.org.ve/afiliados.asp?step=2&tipo=' . $cat));
        phpQuery::selectDocument($doc);

        foreach (pq('li') as $el) {
            echo "---- obteniendo enlaces ----\n\r";
            $links[] = 'http://www.cavecal.org.ve/' . pq($el)->find('a')->attr('href');
        }
        var_dump($links);
    }
    fputs($file, serialize($links));
    fclose($file);
} else {
    $links = unserialize(file_get_contents($filename));
}

$file = fopen(str_replace('links', 'contacts', $filename), 'a+');
foreach ($links as $link) {
    echo "---- cargando contacto ----\n\r";
    $doc = phpQuery::newDocumentHTML(file_get_contents('cavecal-contacts.html'));
    phpQuery::selectDocument($doc);

    echo "---- leyendo contacto ----\n\r";
    $tbody = pq('a[href^=mailto:]')->parent();
    
    foreach ($tbody as $el) {
        var_dump(pq($el)->text());
    }
    
    $email = trim(pq('a[href^=mailto:]')->text());
    $company = trim(pq('a[href^=mailto:]')
            ->parent()
            ->parent()
            ->parent()
            ->parent()
            ->parent()
            ->parent()
            ->parent()
            ->parent()
            ->parent()
            ->parent()
            ->parent()
            ->parent()
            ->parent()
            ->parent()
            ->parent()
            ->parent()
            ->parent()
            ->parent()
            ->parent()
            ->parent()
            ->parent()
            ->parent()
            ->parent()
            ->parent()
            ->find('tr td')->text());
    
    $phone = (int)trim(substr(pq('a[href^=mailto:]')
            ->parent()
            ->parent()
            ->parent()
            ->parent()
            ->parent()
            ->parent()
            ->parent()
            ->parent()
            ->parent()
            ->parent()
            ->parent()
            ->parent()
            ->find('tr td')->text(),0,24));
    
    $address = trim(pq($tbody)->find('tr:nth-child(7)')->find('td:last-child')->text());
    $website = trim(pq($tbody)->find('tr:nth-child(8)')->find('td:last-child')->text());


    $contact = array(
        'Company' => $company,
        'Email Address' => $email,
        'Website' => $website,
        'Phone' => trim($phone),
        'Address' => trim($address)
    );

    var_dump($phone);
    
    echo "---- guardando contacto ----\n\r";
    fputcsv($file, $contact, ';');
    fclose($file);
}

function fetch($url) {
    $curl_handle = curl_init();
    curl_setopt($curl_handle, CURLOPT_URL, $url);
    curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:20.0) Gecko/20100101 Firefox/20.0');
    $response = curl_exec($curl_handle);
    curl_close($curl_handle);
    return $response;
}
