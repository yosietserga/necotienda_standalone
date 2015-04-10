<?php
require_once(dirname(__FILE__). '/../vendor/phpQuery.php');

$doc = phpQuery::newDocumentHTML(file_get_contents('http://www.templatemonster.com'));
phpQuery::selectDocument($doc);
$filename = dirname(__FILE__) . '/tm-categories';

foreach(pq('.sub-menu-2 .item_title') as $el) {
    if (!file_exists($filename.'.txt')) {
        $cat[] = array(
            'name'=> pq($el)->text(),
            'url'=>pq($el)->attr('href')
        );
    } else {
        echo __LINE__.': Loading categories file' ."\n";
        $lists = unserialize(file_get_contents($filename.'.txt'));
        foreach ($lists as $k => $list) {
            $str = $list['name'];
            if ($str !== mb_convert_encoding(mb_convert_encoding($str, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32'))
                $str = mb_convert_encoding($str, 'UTF-8', mb_detect_encoding($str));
            $str = htmlentities($str, ENT_NOQUOTES, 'UTF-8');
            $str = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $str);
            $str = html_entity_decode($str, ENT_NOQUOTES, 'UTF-8');
            $str = preg_replace(array('`[^a-z0-9]`i', '`[-]+`'), '-', $str);
            $str = strtolower(trim($str, '-'));
            if (!file_exists(str_replace('categories', 'products', $filename.'-'.$str.'.txt'))) {
                $pages = range(1, 4);
                foreach ($pages as $j => $page) {
                    echo __LINE__.': '. $list['url'] .'?page='. $page ."\n";
                    $doc = phpQuery::newDocumentHTML(file_get_contents($list['url'] .'?page='. $page));
                    phpQuery::selectDocument($doc);

                    echo __LINE__.': Reading dom products list' ."\n";
                    foreach(pq('#products li') as $el) {
                        $products[] = array(
                            'thumb' => pq($el)->find('.js-thumbnail-img')->attr('src'),
                            'model' => trim(substr(str_replace('#','nt_', pq($el)->find('.template-number')->text()),0,9)),
                            'url' => pq($el)->find('.thumb_preview')->attr('href')
                        );
                        echo __LINE__.': Writing data file' ."\n";
                    }
                }

                echo __LINE__.': Reading product details' ."\n";
                foreach ($products as $j => $product) {
                    $doc = phpQuery::newDocumentHTML(file_get_contents($product['url']));
                    phpQuery::selectDocument($doc);
                    echo __LINE__.': Getting product images' ."\n";
                    foreach (pq('.js-magnifier') as $i => $el) {
                        echo __LINE__.': Adding product image '. pq($el)->attr('href') ."\n";
                        $products[$j]['images'][$i] = pq($el)->attr('href');
                    }

                    $doc = phpQuery::newDocumentHTML(file_get_contents(pq('.live-demo-link a')->attr('href')));
                    phpQuery::selectDocument($doc);
                    $products[$j]['demourl'] = pq('#frame')->attr('src');
                }
                echo __LINE__.': Creating data file' ."\n";
                $file = fopen(str_replace('categories', 'products', $filename.'-'.$str.'.txt'), 'w+');
                fputs($file, serialize($products));
                fclose($file);
            }
        }
    }
}
if ($cat) {
    $file = fopen($filename.'.txt', 'w+');
    fputs($file, serialize($cat));
    fclose($file);
}