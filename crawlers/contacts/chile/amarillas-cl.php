<?php
require_once(dirname(__FILE__). '/../../vendor/phpQuery.php');
echo "Begin process\n";
$doc = phpQuery::newDocumentHTML(fetch('http://www.amarillas.cl/'));
phpQuery::selectDocument($doc);
echo "DOM loaded\n";
$filename = dirname(__FILE__) . '/amarillas-cl-links';
    
foreach(pq('.m-footer-light--container:first-child a') as $el) {
    $str = pq($el)->text();
    
    if ($str !== mb_convert_encoding(mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32'))
        $str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
    $str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
    $str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $str);
    $str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
    $str = preg_replace(array('`[^a-z0-9]`i', '`[-]+`'), '-', $str);
    $str = strtolower(trim($str, '-'));
    
    if (!file_exists($filename . '.txt')) {
        $href = pq($el)->attr('href');
        $categorias[] = array(
            'name'=> pq($el)->text(),
            'alias'=> $str,
            'url'=>$href
        );
        
    } else {
        $categorias = unserialize(file_get_contents($filename . '.txt'));
        echo "File load it\n";
        foreach ($categorias as $children) {
            if (!file_exists(str_replace('links', 'customers', $filename) .'-'. $children['alias']. '.txt')) {
                $links = array();
                echo "Children load it for url: {$children['url']}\n";
                $pages = [
                    '',
                    'p-2/',
                    'p-3/',
                    'p-4/',
                    'p-5/',
                    'p-6/',
                    'p-7/',
                    'p-8/',
                    'p-9/',
                    'p-10/',
                    'p-11/',
                    'p-12/',
                    'p-13/',
                    'p-14/',
                    'p-15/',
                    'p-16/',
                    'p-17/',
                    'p-18/',
                    'p-19/',
                    'p-20/',
                    'p-21/',
                    'p-22/',
                    'p-23/',
                    'p-24/',
                    'p-25/',
                    'p-26/',
                    'p-27/',
                    'p-28/',
                    'p-29/',
                    'p-30/'
                ];
                foreach ($pages as $page) {
                    $doc = phpQuery::newDocumentHTML(fetch($children['url'].$page));
                    phpQuery::selectDocument($doc);
                    foreach(pq('ul.m-results-businesses > li') as $el) {

                        $email = pq($el)->find('.m-result-business--question-form-emails input[name=mailAnunciante]')->val();
                        if (empty($email)) {
                            $email = [];
                            foreach (pq($eq)->find('.m-result-business--question-form-emails select[name=mailAnunciante] option') as $option) {
                                $email[] = pq($option)->val();
                            }
                        }

                        $name = pq($el)->find('h3.itemprop=[name] a')->text();
                        $phone = pq($el)->find('p.itemprop=[telephone]')->text();
                        $website = pq($el)->find('.m-results-business--online a.itemprop=[url]')->attr('href');

                        $links[] = [
                            'email'=>$email,
                            'name'=>$name,
                            'phone'=>$phone,
                            'website'=>$website
                        ];
                    }
                }
                $file = fopen(str_replace('links', 'customers', $filename) .'-'. $children['alias']. '.txt', 'w+');
                fputs($file, serialize($links));
                fclose($file);
            }
        }
    }
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

$file = fopen($filename . '.txt', 'w+');
fputs($file, serialize($categorias));
fclose($file);