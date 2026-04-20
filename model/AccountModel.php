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
        return $this->create(self::TABLE, $data);
    }
}
?>
