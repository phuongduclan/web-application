<?php

/**
 * Chỉ require từ layouts/header.php — không gọi từ controller.
 */

if (!function_exists('app_base_path')) {
    function app_base_path()
    {
        $sn = isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : '/index.php';
        $dir = dirname(str_replace('\\', '/', $sn));
        if ($dir === '/' || $dir === '.' || $dir === '') {
            return '';
        }
        return rtrim($dir, '/');
    }
}

if (!function_exists('app_asset')) {
    /**
     * Static files phục vụ qua Apache: thư mục /public (css, js, images).
     */
    function app_asset($path)
    {
        $base = app_base_path();
        return ($base === '' ? '' : $base) . '/public/' . ltrim(str_replace('\\', '/', $path), '/');
    }
}

if (!function_exists('app_route')) {
    function app_route($controller, $action = 'index', $params = array())
    {
        $base = app_base_path();
        $q = array_merge(array('controller' => $controller, 'action' => $action), $params);
        return ($base === '' ? '' : $base) . '/index.php?' . http_build_query($q);
    }
}

if (!function_exists('layout_row_int')) {
    function layout_row_int(array $row, array $keys)
    {
        foreach ($keys as $k) {
            if (isset($row[$k])) {
                return (int) $row[$k];
            }
        }
        return 0;
    }
}

if (!function_exists('layout_row_str')) {
    function layout_row_str(array $row, array $keys, $default = '')
    {
        foreach ($keys as $k) {
            if (isset($row[$k]) && $row[$k] !== '') {
                return (string) $row[$k];
            }
        }
        return $default;
    }
}

/** Ảnh thẻ SP: ưu tiên cover_image (từ biến thể đầu), không gắn mô tả biến thể vào Product. */
if (!function_exists('layout_product_card_image')) {
    function layout_product_card_image(array $p, $fallbackRel = 'images/products/product-1.jpg')
    {
        $img = layout_row_str($p, array('cover_image', 'image'), '');
        if ($img === '') {
            return app_asset($fallbackRel);
        }
        if ($img[0] === '/' || strncasecmp($img, 'http', 4) === 0) {
            return $img;
        }
        return app_asset($img);
    }
}
