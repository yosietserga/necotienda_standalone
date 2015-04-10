<?php

require_once(dirname(__FILE__) . '/../vendor/phpQuery.php');


$deparments_path = dirname(__FILE__) . '/walmart-departments.txt';
if (!file_exists($deparments_path)) {
    echo "---- exec getAllDeparments() ----\n\r";
    getAllDepartments($deparments_path);
} else {
    getAllSubCategories($deparments_path);
}

function getAllDepartments($filename) {
    echo "---- run getAllDeparments() ----\n\r";
    $doc = phpQuery::newDocumentHTML(file_get_contents(dirname(__FILE__) . '/deparments.html'));
    phpQuery::selectDocument($doc);
    echo "---- loading dom html ----\n\r";
    $categories = array();
    foreach (pq('.accordion div') as $el) {
        echo "---- reading a deparment and childrens ----\n\r";

        $link = pq($el)->find('h4 a:last-child')->attr('href');
        $name = pq($el)->find('h4 a:last-child span')->text();
        foreach (pq($el)->find('li') as $ele) {
            echo "---- reading a deparment's children ----\n\r";
            $subcategories[] = array(
                'link' => pq($ele)->find('a')->attr('href'),
                'name' => pq($ele)->find('a')->text()
            );
        }
        echo "---- wrapping deparments ----\n\r";
        $categories[] = array(
            'name' => $name,
            'link' => $link,
            'childrens' => $subcategories
        );
    }

    echo "---- creating deparment file ----\n\r";
    $file = fopen($filename, 'a+');
    echo "---- writing deparment file ----\n\r";
    fputs($file, serialize($categories));
    echo "---- closing deparment file ----\n\r";
    fclose($file);
}

function getAllSubCategories($filename) {
    $categories = unserialize(file_get_contents($filename));
    echo "---- run getAllSubCategories() ----\n\r";
    foreach ($categories as $j => $category) {
        if ($category['childrens']) {
            foreach ($category['childrens'] as $k => $children) {
                echo "---- crawling childrens for {$children['name']} ----\n\r";
                $doc = phpQuery::newDocumentHTML(fetch('http://www.walmart.com'. $children['link']));
                phpQuery::selectDocument($doc);
                foreach (pq('.shop-by-category li') as $el) {
                    echo "---- ". pq($el)->find('a')->attr('href') ."} ----\n\r";
                    $childrens[] = array(
                        'name'=>pq($el)->find('a')->data('name'),
                        'link'=>pq($el)->find('a')->attr('href')
                    );
                }
                $categories[$j]['childrens'][$k]['childrens'] = $childrens;
            }
        }
    }
    echo "---- creating deparment file ----\n\r";
    $file = fopen($filename, 'w+');
    echo "---- writing deparment file ----\n\r";
    fputs($file, serialize($categories));
    echo "---- closing deparment file ----\n\r";
    fclose($file);
}

function getAllProducts() {
    $pages = range(1,6);
    /**
     * si el modelo existe, simplemente asociar con las demás categorías
     */
    $categories = unserialize();
}

/*
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
 */

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
