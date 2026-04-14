<?php
require_once __DIR__ . '/DataProvider.php';

class Payment {
    private static function sqlListAll(): string {
        return 'SELECT p.payment_id, p.invoice_id, pm.method_name, p.payment_amount, p.payment_date
                FROM Payment p
                INNER JOIN PaymentMethod pm ON pm.method_id = p.method_id
                ORDER BY p.payment_id DESC';
    }

    private static function sqlByInvoice(): string {
        return 'SELECT p.payment_id, p.invoice_id, pm.method_name, p.payment_amount, p.payment_date
                FROM Payment p
                INNER JOIN PaymentMethod pm ON pm.method_id = p.method_id
                WHERE p.invoice_id = ?
                ORDER BY p.payment_id DESC';
    }

    /** USP_ListAllPayment — fallback SQL nếu chưa tạo procedure. */
    public function listAllPayments(): array {
        $dp = DataProvider::Instance();
        try {
            return $dp->ExecuteQuery('EXEC USP_ListAllPayment');
        } catch (Throwable $e) {
            return $dp->ExecuteQuery(self::sqlListAll());
        }
    }

    /** USP_SearchPaymentByInvoice — lọc theo mã hóa đơn. */
    public function searchByInvoiceId(int $invoiceId): array {
        if ($invoiceId <= 0) {
            return [];
        }
        $dp = DataProvider::Instance();
        try {
            return $dp->ExecuteQuery('EXEC USP_SearchPaymentByInvoice @InvoiceId = ?', [$invoiceId]);
        } catch (Throwable $e) {
            return $dp->ExecuteQuery(self::sqlByInvoice(), [$invoiceId]);
        }
    }

    /** Tổng thu (đ) từ các dòng đang hiển thị. */
    public static function tongThuTuDanhSach(array $rows): int {
        $s = 0;
        foreach ($rows as $r) {
            $s += (int) ($r['payment_amount'] ?? 0);
        }
        return $s;
    }
}
