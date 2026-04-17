<?php
class AccountModel extends BaseModel {
    const TABLE = 'Account';

    public function findAccountByEmail($email) {
        $sql="SELECT  * FROM ".self::TABLE." WHERE email = ? ";
        $stmt=$this->connect->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function register($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        return $this->create(self::TABLE, $data);
    }
}
?>
