<?php

$this->view('frontend.layouts.header', array(
    'menus' => isset($menus) ? $menus : array(),
    'pageTitle' => 'Giỏ hàng',
    'navActive' => 'cart',
    'layoutExtraCss' => array('cart-checkout.css'),
));
$this->view('frontend.carts._list', array(
    'cart' => isset($cart) ? $cart : array(),
    'cartTotal' => isset($cartTotal) ? $cartTotal : 0,
    'cartError' => isset($cartError) ? $cartError : null,
    'logged_in' => isset($logged_in) ? $logged_in : false,
));
$this->view('frontend.layouts.footer');

?>
