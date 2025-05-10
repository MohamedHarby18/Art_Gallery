<?php
require_once __DIR__ . '/../../Controller/DBController.php';

class EGift
{
    private $db;
    private $customerSenderID;
    protected $receiverEmail;
    private $value;

    public function __construct(DBController $db, $customerSenderID, $receiverEmail, $value) {
        $this->db = $db;
        $this->customerSenderID = $customerSenderID;
        $this->receiverEmail = $receiverEmail;
        $this->value = $value;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function getValue() {
        return $this->value;
    }

    public function getCustomerSenderID() {
        return $this->customerSenderID;
    }

    public function setReceiverEmail($email) {
        $this->receiverEmail = $email;
    }


    public function getReceiverEmail() {
        return $this->receiverEmail;
    }


    public function save() {
        $query = "INSERT INTO egiftcards (UserID, Amount, RecipientEmail) VALUES (?, ?, ?)";
        $params = [
            $this->customerSenderID,
            $this->value,
            $this->receiverEmail,
        ];
        
        return $this->db->insert($query, $params);
    }

    public static function getAllByUser(DBController $db, $userId) {
        $query = "SELECT * FROM egiftcards WHERE UserID = ? ORDER BY DateCreated DESC";
        return $db->select($query, [$userId]);
    }
}
?>