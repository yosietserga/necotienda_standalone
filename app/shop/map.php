<?php $loader->auto('url');
$loader->auto('user');
$loader->auto('customer');
$loader->auto('currency');
$loader->auto('tax');
$loader->auto('weight');
$loader->auto('length');
$loader->auto('cart');
$loader->auto('validar');
$loader->auto('recaptcha');
$loader->auto('encoder');

$registry->set('load', $loader);
$registry->set('config', $config);
$registry->set('db', $db);
$registry->set('log', $log);
$registry->set('request', $request);
$registry->set('response', $response); 
$registry->set('session', $session);
$registry->set('cache', new Cache());
$registry->set('document', new Document());
$registry->set('language', $language);
$registry->set('user', new User($registry));

// App Libs
$registry->set('customer', new Customer($registry));
$registry->set('currency', new Currency($registry));
$registry->set('tax', new Tax($registry));
$registry->set('weight', new Weight($registry));
$registry->set('length', new Length($registry));
$registry->set('cart', new Cart($registry));

// Default
$language->load('common/header');

$loader->auto('account/customer');
$loader->auto('catalog/product');
$loader->auto('catalog/category');
$loader->auto('tool/seo_url'); //TODO: rediseñar clase de URLs
$loader->auto('localisation/language');
$loader->auto('localisation/currency');

// Email Libs
//$mailer  = new Mailer();
//$email_f = new email($mailer,$config);
//$registry->set('smtp', new SMTP());
//$registry->set('mailer', $mailer);
//$registry->set('email_f', $email_f);
//$registry->set('utf8', new utf8());
$registry->set('encoder', new Encoder());
$registry->set('validar', new Validar());
$registry->set('recaptcha', new Recaptcha(C_RPUBLIC_KEY,C_RPRIVATE_KEY));



$route = isset($request->get['_r_']) ? strtolower($request->get['_r_']) : strtolower($request->get['r']);
switch ($route) {
    case 'common/home':
        //Languages
        $language->load('common/home');
        
        //Models
		$loader->auto('checkout/extension');
        break;
    case 'store/category':
    case 'store/category/home':
        //Languages
		$language->load('store/category');
        $language->load('store/product');
        
        //Models
		$loader->auto('catalog/category');
		$loader->auto('tool/seo_url');
		$loader->auto('tool/image');
        break;
    case 'store/product':
    case 'store/product/home':
        //Languages
        $language->load('store/product');
        
        //Models
		$loader->auto('catalog/product');
		$loader->auto('catalog/category');
		$loader->auto('catalog/manufacturer');
		$loader->auto('tool/seo_url');
		$loader->auto('tool/image');
		$loader->auto('catalog/review');
        
        //Libs
		$loader->auto('image');
		$loader->auto('currency');
		$loader->auto('tax');
        break;
    case 'store/product/related':
        //Languages
        $language->load('store/related');
        
        //Models
		$loader->auto('catalog/product');
		$loader->auto('tool/seo_url');
		$loader->auto('catalog/review');
        
        //Libs
		$loader->auto('image');
		$loader->auto('currency');
		$loader->auto('tax');
        break;
    case 'store/product/review':
    case 'store/product/write':
        //Languages
        $language->load('store/product');
        
        //Models
		$loader->auto('catalog/review');
        
        //Libs
		$loader->auto('pagination');
        break;
    case 'store/product/comment':
        //Languages
        $language->load('store/product');
        
        //Models
		$loader->auto('catalog/review');
        
        //Libs
		$loader->auto('pagination');
        break;
    case 'store/search':
    case 'store/search/home':
        //Languages
		$language->load('store/search');
        $language->load('store/product');
        
        //Models
		$loader->auto('catalog/product');
		$loader->auto('catalog/category');
		$loader->auto('tool/seo_url');
		$loader->auto('tool/image');
        break;
    default:
        //Languages
        $language->load('common/home');
        
        //Models
		$loader->auto('checkout/extension');
        break;
}