<?php
/**
 * Quản lý người dùng — layout Figma 4:371 (UV_ListAllUser: user_id, email, role_name, total_orders).
 *
 * @var array<int, array<string, mixed>> $userList
 */
$userList = $userList ?? [];
$tong = count($userList);

/** Chuẩn hóa hiển thị badge Admin / User theo role_name từ DB. */
$lop_vai_tro = static function (?string $roleName): string {
    $r = mb_strtolower(trim((string) $roleName), 'UTF-8');
    if ($r === '' || strpos($r, 'admin') !== false) {
        return 'nhan-vai-tro vai-admin';
    }
    return 'nhan-vai-tro vai-user';
};
$nhan_vai_tro = static function (?string $roleName): string {
    $r = mb_strtolower(trim((string) $roleName), 'UTF-8');
    if (strpos($r, 'admin') !== false) {
        return 'Admin';
    }
    if ($r === '' || strpos($r, 'user') !== false) {
        return 'User';
    }
    return (string) $roleName;
};
?>
<main id="noi-dung">
  <div id="ket-qua">
    <div id="hang-tren-nd">
      <p id="dong-tong-so">
        Tổng số:
        <strong id="cuc-tong-nd"><span id="so-luong-nd"><?php echo (int) $tong; ?></span> người dùng</strong>
      </p>
      <div id="khu-tim-nd">
        <label class="sr-only" for="o-tim-nd">Tìm người dùng</label>
        <input type="search" id="o-tim-nd" name="q" placeholder="Tìm theo email hoặc mã…" autocomplete="off" spellcheck="false" inputmode="search" aria-label="Tìm người dùng">
      </div>
    </div>

    <div id="hop-bang-nd">
      <div id="khung-keo-bang-nd">
        <table id="bang-nguoi-dung">
          <thead>
            <tr>
              <th scope="col">STT</th>
              <th scope="col">Mã khách hàng</th>
              <th scope="col">Email</th>
              <th scope="col">Vai trò</th>
              <th scope="col">Số đơn hàng</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($tong === 0) { ?>
              <tr>
                <td colspan="5" class="o-trong-bang-nd">Chưa có người dùng.</td>
              </tr>
            <?php } ?>
            <?php $stt = 1; ?>
            <?php foreach ($userList as $user) {
                $uid = (int) ($user['user_id'] ?? 0);
                $email = (string) ($user['email'] ?? '');
                $roleName = isset($user['role_name']) ? (string) $user['role_name'] : '';
                $soDon = (int) ($user['total_orders'] ?? 0);
                $timKiem = mb_strtolower($uid . ' ' . $email, 'UTF-8');
                ?>
              <tr class="dong-nd" data-tim-kiem="<?php echo htmlspecialchars($timKiem, ENT_QUOTES, 'UTF-8'); ?>">
                <td><?php echo $stt; ?></td>
                <td><?php echo $uid; ?></td>
                <td class="o-email-nd"><?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?></td>
                <td>
                  <span class="<?php echo htmlspecialchars($lop_vai_tro($roleName), ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($nhan_vai_tro($roleName), ENT_QUOTES, 'UTF-8'); ?></span>
                </td>
                <td><?php echo $soDon; ?> đơn</td>
              </tr>
            <?php $stt++; ?>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>
