<?php
$this->view('frontend.layouts.header', ['menus' => $menus ?? []]);
$this->view('frontend.categories._detail', [
    'category' => $category,
    'products' => $products,
]);
$this->view('frontend.layouts.footer');
?>
