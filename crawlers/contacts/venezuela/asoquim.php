<?php

require_once(dirname(__FILE__) . '/../../vendor/phpQuery.php');
echo "Begin process\n";

$categories = range('a', 'z');

foreach ($categories as $cat) {
    $filename = dirname(__FILE__) . '/asoquim-contacts.txt';

    echo "leyendo la letra $cat\n\r";

    $doc = phpQuery::newDocumentHTML(file_get_contents(dirname(__FILE__) . '/asoquim-'. $cat .'.txt'));
    phpQuery::selectDocument($doc);

    $file = fopen($filename, 'a+');

    if (!file_exists($file)) {
        fputcsv($file, array('First Name', 'Email Address', 'Url', 'Telephone', 'Address'), ';');
    }

    foreach (pq('.titulo') as $el) {
        echo "---- obteniendo contactos ----\n\r";
        $company = pq($el)->find('strong')->text();
        $contact_info = pq($el)->parent()->next();

        $address = pq($contact_info)->find('font')->eq(2)->text();
        $phone = pq($contact_info)->find('font')->eq(3)->text();
        $email = pq($contact_info)->find('a[href^="mailto:"]')->text();
        $website = pq($contact_info)->find('a[href^="http:"]')->text();

        $contact = array(
            'Company' => $company,
            'Email Address' => $email,
            'Website' => $website,
            'Phone' => trim($phone),
            'Address' => trim($address)
        );
        
        var_dump($contact);
        
        echo "---- guardando contacto ----\n\r";
        fputcsv($file, $contact, ';');
    }
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
