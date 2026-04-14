<?php
if (!headers_sent()) {
    header('Content-Type: text/html; charset=UTF-8');
}
@ini_set('default_charset', 'UTF-8');
if (function_exists('mb_internal_encoding')) {
    mb_internal_encoding('UTF-8');
}

$raw = $_GET['action'] ?? 'home';
$action = is_string($raw) ? preg_replace('/[^a-z0-9_-]/i', '', $raw) : 'home';
if ($action === '') {
    $action = 'home';
}

$hop_le = ['home', 'product', 'product_add', 'product_edit', 'category', 'category_add', 'category_edit', 'order', 'user', 'payment'];
if (!in_array($action, $hop_le, true)) {
    $action = 'home';
}

include __DIR__ . '/view/admin/header.php';

include __DIR__ . '/model/User.php';
include __DIR__ . '/model/Invoice.php';
include __DIR__ . '/model/Product.php';
include __DIR__ . '/model/Category.php';
include __DIR__ . '/model/Payment.php';

switch ($action) {
    case 'product':
        $product = new Product();
        $categoryList = $product->getCategories();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['delete_product'])) {
                $pidXoa = (int) ($_POST['product_id'] ?? 0);
                try {
                    $product->deleteProduct($pidXoa);
                    header('Location: index.php?action=product');
                } catch (PDOException $e) {
                    header('Location: index.php?action=product&err=fk_product');
                }
                exit;
            }
            if (isset($_POST['add_variant'])) {
                $pid = (int) ($_POST['product_id'] ?? 0);
                $product->addVarient(
                    $pid,
                    trim((string) ($_POST['size'] ?? '')),
                    trim((string) ($_POST['color'] ?? '')),
                    (int) ($_POST['price'] ?? 0),
                    trim((string) ($_POST['image'] ?? ''))
                );
                header('Location: index.php?action=product&id=' . $pid);
                exit;
            }
            if (isset($_POST['update_variant'])) {
                $pid = (int) ($_POST['product_id'] ?? 0);
                $product->updateVarient(
                    (int) ($_POST['variant_id'] ?? 0),
                    trim((string) ($_POST['size'] ?? '')),
                    trim((string) ($_POST['color'] ?? '')),
                    (int) ($_POST['price'] ?? 0),
                    trim((string) ($_POST['image'] ?? ''))
                );
                header('Location: index.php?action=product&id=' . $pid);
                exit;
            }
            if (isset($_POST['delete_variant'])) {
                $pid = (int) ($_POST['product_id'] ?? 0);
                try {
                    $product->deleteVarient((int) ($_POST['variant_id'] ?? 0));
                    header('Location: index.php?action=product&id=' . $pid);
                } catch (PDOException $e) {
                    header('Location: index.php?action=product&id=' . $pid . '&err=fk_variant');
                }
                exit;
            }
        }

        $productList = $product->getAllProduct();
        $tenDm = [];
        foreach ($categoryList as $c) {
            $tenDm[$c['category_id']] = $c['category_name'];
        }
        foreach ($productList as $k => $row) {
            $cid = $row['category_id'] ?? null;
            $productList[$k]['category_name'] = ($cid !== null && isset($tenDm[$cid])) ? $tenDm[$cid] : '';
        }

        $selectedId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        $productDetail = null;
        $variantList = [];
        $variantEditRow = null;
        $variantEditId = isset($_GET['variant_edit']) ? (int) $_GET['variant_edit'] : 0;

        if ($selectedId > 0) {
            $rows = $product->getProductById($selectedId);
            $productDetail = $rows[0] ?? null;
            $variantList = $product->getVarientByProductId($selectedId);

            if ($productDetail !== null) {
                $cid = $productDetail['category_id'] ?? null;
                $productDetail['category_name'] = ($cid !== null && isset($tenDm[$cid])) ? $tenDm[$cid] : '';
            }

            if ($variantEditId > 0) {
                foreach ($variantList as $v) {
                    if ((int) ($v['variant_id'] ?? 0) === $variantEditId) {
                        $variantEditRow = $v;
                        break;
                    }
                }
            }
        }

        include __DIR__ . '/view/admin/product.php';
        break;
    case 'product_add':
        $product = new Product();
        $categoryList = $product->getCategories();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
            $cid = (int) ($_POST['category_id'] ?? 0);
            $product->addProduct(
                trim((string) ($_POST['product_name'] ?? '')),
                $cid > 0 ? $cid : null
            );
            header('Location: index.php?action=product');
            exit;
        }
        $productFormMode = 'add';
        $productFormRow = null;
        include __DIR__ . '/view/admin/product_form.php';
        break;
    case 'product_edit':
        $product = new Product();
        $categoryList = $product->getCategories();
        $editId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        if ($editId <= 0) {
            header('Location: index.php?action=product');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
            $pid = (int) ($_POST['product_id'] ?? 0);
            $cid = (int) ($_POST['category_id'] ?? 0);
            $product->updateProduct(
                $pid,
                trim((string) ($_POST['product_name'] ?? '')),
                $cid > 0 ? $cid : null
            );
            header('Location: index.php?action=product&id=' . $pid);
            exit;
        }
        $rows = $product->getProductById($editId);
        $productFormRow = $rows[0] ?? null;
        if ($productFormRow === null) {
            header('Location: index.php?action=product');
            exit;
        }
        $productFormMode = 'edit';
        include __DIR__ . '/view/admin/product_form.php';
        break;
    case 'category':
        $categoryModel = new Category();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_category'])) {
            try {
                $categoryModel->delete((int) ($_POST['category_id'] ?? 0));
                header('Location: index.php?action=category');
            } catch (PDOException $e) {
                header('Location: index.php?action=category&err=fk_category');
            }
            exit;
        }
        $categoryList = $categoryModel->getAll();
        include __DIR__ . '/view/admin/category.php';
        break;
    case 'category_add':
        $categoryModel = new Category();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_category'])) {
            $categoryModel->add((string) ($_POST['category_name'] ?? ''));
            header('Location: index.php?action=category');
            exit;
        }
        $categoryFormMode = 'add';
        $categoryFormRow = null;
        include __DIR__ . '/view/admin/category_form.php';
        break;
    case 'category_edit':
        $categoryModel = new Category();
        $catEditId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        if ($catEditId <= 0) {
            header('Location: index.php?action=category');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_category'])) {
            $categoryModel->update(
                (int) ($_POST['category_id'] ?? 0),
                (string) ($_POST['category_name'] ?? '')
            );
            header('Location: index.php?action=category');
            exit;
        }
        $catRows = $categoryModel->getById($catEditId);
        $categoryFormRow = $catRows[0] ?? null;
        if ($categoryFormRow === null) {
            header('Location: index.php?action=category');
            exit;
        }
        $categoryFormMode = 'edit';
        include __DIR__ . '/view/admin/category_form.php';
        break;
    case 'order':
        $invoice = new Invoice();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pid = (int) ($_POST['invoice_id'] ?? 0);
            if (isset($_POST['confirm_order']) && $pid > 0) {
                $ok = $invoice->updateInvoiceStatus($pid, 2);
                header('Location: index.php?action=order&id=' . $pid . ($ok ? '' : '&err=order_update'));
                exit;
            }
            if (isset($_POST['cancel_order']) && $pid > 0) {
                $ok = $invoice->updateInvoiceStatus($pid, 3);
                header('Location: index.php?action=order&id=' . $pid . ($ok ? '' : '&err=order_update'));
                exit;
            }
            header('Location: index.php?action=order');
            exit;
        }
        $tuKhoaTimDon = isset($_GET['q']) ? trim((string) $_GET['q']) : '';
        $orderList = $tuKhoaTimDon !== ''
            ? $invoice->searchOrdersForAdmin($tuKhoaTimDon)
            : $invoice->listOrdersAdmin();
        $selectedOrderId = isset($_GET['id']) ? (int) $_GET['id'] : 0;
        if ($selectedOrderId <= 0 && !empty($orderList)) {
            $selectedOrderId = (int) ($orderList[0]['invoice_id'] ?? 0);
        }
        $orderDetailLines = [];
        $orderDetailTotal = 0;
        if ($selectedOrderId > 0) {
            $orderDetailLines = $invoice->getInvoiceDetail($selectedOrderId);
            foreach ($orderDetailLines as $line) {
                $orderDetailTotal += (int) ($line['total'] ?? 0);
            }
            if ($orderDetailTotal === 0) {
                foreach ($orderList as $or) {
                    if ((int) ($or['invoice_id'] ?? 0) === $selectedOrderId) {
                        $orderDetailTotal = (int) ($or['total_amount'] ?? 0);
                        break;
                    }
                }
            }
        }
        include __DIR__ . '/view/admin/order.php';
        break;
    case 'user':
        $user = new User();
        $userList = $user->getAllUser();
        include __DIR__ . '/view/admin/user.php';
        break;
    case 'payment':
        $paymentModel = new Payment();
        $tuKhoaHoaDon = isset($_GET['q']) ? trim((string) $_GET['q']) : '';
        $maHoaDonTim = ($tuKhoaHoaDon !== '' && ctype_digit($tuKhoaHoaDon)) ? (int) $tuKhoaHoaDon : 0;
        $paymentList = $maHoaDonTim > 0
            ? $paymentModel->searchByInvoiceId($maHoaDonTim)
            : $paymentModel->listAllPayments();
        $tongSoGiaoDich = count($paymentList);
        $tongThuGiaoDich = Payment::tongThuTuDanhSach($paymentList);
        include __DIR__ . '/view/admin/payment.php';
        break;
    case 'home':
        $user = new User();
        $invoice = new Invoice();
        $tongDoanhThu = $invoice->getTotalRevenue();
        $tongNguoiDung = $user->countAllUser();
        $tongDonHang = $invoice->countAllInvoice();
        $invoiceList = $invoice->getAllInvoice();
        include __DIR__ . '/view/admin/home.php';
        break;
}

include __DIR__ . '/view/admin/footer.php';
