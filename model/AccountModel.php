<?php
class AccountModel extends BaseModel {
    const TABLE = 'Account';

    public function findAccountByEmail($email) {
        $sql="SELECT  * FROM ".self::TABLE." WHERE email = ? ";
        $stmt=$this->connect->prepare($sql);
        $stmt->execute([$email]);
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        return $row===false ? null : $row;
    }

    public function register($data) {
        return $this->create(self::TABLE, $data);
    }

    public function findByAccountId($id){
        return $this->findById(self::TABLE,(int)$id);
    }

    public function updateAccountPassword($userId,$hashedPassword){
        return $this->update(self::TABLE,(int)$userId,[
            'password'=>$hashedPassword,
        ]);
    }
}
?>
