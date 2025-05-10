<?php
require_once __DIR__ . '/../../Controller/controlDB.php';

class EGift
{
    private $db;
    private $ID;
    private $customerSenderID;
    protected $receiverEmail;
    protected $receiverName;
    private $value;

    public function __construct(DBController $db, $ID, $customerSenderID, $receiverEmail = '', $receiverName = '', $value = 0) {
        $this->db = $db;
        $this->ID = $ID;
        $this->customerSenderID = $customerSenderID;
        $this->receiverEmail = $receiverEmail;
        $this->receiverName = $receiverName;
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

    public function getReceiverName() {
        return $this->receiverName;
    }

    public function getReceiverEmail() {
        return $this->receiverEmail;
    }

    public function setReceiverName($name) {
        $this->receiverName = $name;
    }

    public function getID() {
        return $this->ID;
    }

    public function setID($id) {
        $this->ID = $id;
    }

    public function save() {
        $query = "INSERT INTO egiftcards (CardID, UserID, Amount, RecipientEmail, RecipientName) VALUES (?, ?, ?, ?, ?)";
        $params = [
            $this->ID,
            $this->customerSenderID,
            $this->value,
            $this->receiverEmail,
            $this->receiverName
        ];
        
        return $this->db->insert($query, $params);
    }

    public static function getById(DBController $db, $cardId) {
        $query = "SELECT * FROM egiftcards WHERE CardID = ?";
        $result = $db->select($query, [$cardId]);
        
        if ($result && count($result) > 0) {
            $data = $result[0];
            return new EGift(
                $db,
                $data['CardID'],
                $data['UserID'],
                $data['RecipientEmail'],
                $data['RecipientName'] ?? '',
                $data['Amount']
            );
        }
        return null;
    }

    public static function getAllByUser(DBController $db, $userId) {
        $query = "SELECT * FROM egiftcards WHERE UserID = ? ORDER BY DateCreated DESC";
        return $db->select($query, [$userId]);
    }
}
?>