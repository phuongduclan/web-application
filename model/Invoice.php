<?php
require_once __DIR__ . '/DataProvider.php';

class Invoice {
    public function getAllInvoice() {
        return DataProvider::Instance()->ExecuteQuery(
            'SELECT TOP 10 * FROM UV_ListOrder ORDER BY invoice_id DESC'
        );
    }

    public function countAllInvoice() {
        return DataProvider::Instance()->ExecuteScalar('SELECT COUNT(*) FROM Invoice');
    }

    public function getTotalRevenue() {
        return DataProvider::Instance()->ExecuteScalar(
            'SELECT COALESCE(SUM(CAST(total_amount AS BIGINT)), 0) FROM Invoice'
        );
    }

    public function getRecentInvoices($top = 5) {
        $n = max(1, min(50, (int) $top));
        return DataProvider::Instance()->ExecuteQuery(
            "SELECT TOP {$n} invoice_id, phone, total_amount, status_name, created_at FROM UV_ListOrder ORDER BY created_at DESC"
        );
    }

    /**
     * Danh sách đơn cho admin: có status_id để hiển thị nút Xác nhận / Hủy.
     */
    public function listOrdersAdmin() {
        return DataProvider::Instance()->ExecuteQuery(
            'SELECT i.invoice_id, i.user_id, i.address, i.phone, i.note, i.total_amount, i.status_id,
                    s.status_name, i.created_at
             FROM Invoice i
             LEFT JOIN Status s ON s.status_id = i.status_id
             ORDER BY i.invoice_id DESC'
        );
    }

    public function searchOrdersForAdmin($query) {
        $q = trim((string) $query);
        if ($q === '') {
            return $this->listOrdersAdmin();
        }
        $like = '%' . $q . '%';
        return DataProvider::Instance()->ExecuteQuery(
            'SELECT i.invoice_id, i.user_id, i.address, i.phone, i.note, i.total_amount, i.status_id,
                    s.status_name, i.created_at
             FROM Invoice i
             LEFT JOIN Status s ON s.status_id = i.status_id
             WHERE CAST(i.invoice_id AS NVARCHAR(20)) LIKE ?
                OR CAST(i.user_id AS NVARCHAR(20)) LIKE ?
                OR i.phone LIKE ?
                OR ISNULL(i.address, \'\') LIKE ?
                OR ISNULL(i.note, \'\') LIKE ?
                OR ISNULL(s.status_name, \'\') LIKE ?
             ORDER BY i.invoice_id DESC',
            [$like, $like, $like, $like, $like, $like]
        );
    }

    /**
     * Cập nhật trạng thái qua SP (chỉ khi đơn đang status_id = 1).
     * @return bool true nếu sau khi gọi SP, invoice có đúng status_id mới
     */
    public function updateInvoiceStatus($invoiceId, $newStatusId) {
        DataProvider::Instance()->ExecuteNonQuery(
            'EXEC USP_UpdateInvoiceStatus @InvoiceId = ?, @StatusId = ?',
            [(int) $invoiceId, (int) $newStatusId]
        );
        $row = DataProvider::Instance()->ExecuteQuery(
            'SELECT status_id FROM Invoice WHERE invoice_id = ?',
            [(int) $invoiceId]
        );
        return isset($row[0]['status_id']) && (int) $row[0]['status_id'] === (int) $newStatusId;
    }

    public function searchInvoiceByPhone($phone) {
        $like = '%' . trim((string) $phone) . '%';
        return DataProvider::Instance()->ExecuteQuery(
            'SELECT * FROM UV_ListOrder WHERE phone LIKE ? ORDER BY invoice_id DESC',
            [$like]
        );
    }

    public function getInvoiceDetail($invoiceId) {
        return DataProvider::Instance()->ExecuteQuery(
            "SELECT ROW_NUMBER() OVER (ORDER BY d.detail_id) AS stt,
                    p.product_name,
                    CONCAT(v.size, N' - ', v.color) AS variant,
                    d.quantity,
                    d.price,
                    d.quantity * d.price AS total
             FROM InvoiceDetail d
             INNER JOIN ProductVariant v ON d.variant_id = v.variant_id
             INNER JOIN Product p ON v.product_id = p.product_id
             WHERE d.invoice_id = ?",
            [(int) $invoiceId]
        );
    }
}
