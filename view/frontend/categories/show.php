<?php

$c = (isset($category) && is_array($category)) ? $category : array();
$pageTitle = isset($c['name']) ? (string) $c['name'] : (isset($c['category_name']) ? (string) $c['category_name'] : 'Danh mục');
$this->view('frontend.layouts.header', array(
    'menus' => isset($menus) ? $menus : array(),
    'pageTitle' => $pageTitle,
    'navActive' => 'categories',
));
$this->view('frontend.categories._detail', array(
    'category' => isset($category) ? $category : array(),
    'products' => isset($products) ? $products : array(),
));
$this->view('frontend.layouts.footer');

?>
