<?php
class PaymentMethodModel extends BaseModel {
    // Table name form database.
    const TABLE ='PaymentMethod';

    public function getAllMethod()
    {
        return $this->getAll(self::TABLE);
    }
    public function findByPaymentMethodId($id)
    {
        return $this->findById(self::TABLE,$id);
    }

}
?>