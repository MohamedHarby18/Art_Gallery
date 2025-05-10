<?php
// require_once __DIR__ . '/../../Controller/DBController.php'; // Path seems okay from your previous files

class EGift
{
    private $db;
    private $ID;                // Maps to CardID in DB
    private $customerSenderID;  // Maps to UserID in DB
    protected $receiverEmail;   // Maps to RecipientEmail in DB
    // private $receiverName; // REMOVED PROPERTY
    private $value;             // Maps to Amount in DB

    // Constructor MODIFIED: $receiverName parameter removed
    public function __construct(DBController $db, $ID, $customerSenderID, $receiverEmail = '', $value = 0) {
        $this->db = $db;
        $this->customerSenderID = $customerSenderID;
        $this->receiverEmail = $receiverEmail;
        // $this->receiverName = $receiverName; // REMOVED
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

    // public function getReceiverName() { // REMOVED METHOD
    //     return $this->receiverName;
    // }

    // public function setReceiverName($name) { // REMOVED METHOD
    //     $this->receiverName = $name;
    // }

    public function getID() {
        return $this->ID;
    }

    public function setID($id) {
        $this->ID = $id;
    }

    // save() method MODIFIED
    public function save() {
        // Query MODIFIED: RecipientName column removed
        $query = "INSERT INTO egiftcards (CardID, UserID, Amount, RecipientEmail) VALUES (?, ?, ?, ?)";
        // Params MODIFIED: $this->receiverName removed
        $params = [
            $this->ID,
            $this->customerSenderID, // This should be the logged-in UserID
            $this->value,            // This is the Amount
            $this->receiverEmail
        ];

        // Assuming your DBController's insert method correctly handles parameter binding
        // and uses types like 'sids' (string, int, double, string) for these columns.
        // If it needs types, you might need to pass them or it infers them.
        return $this->db->insert($query, $params);
    }

    // getById() method MODIFIED
    public static function getById(DBController $db, $cardId) {
        // Assuming your table has CardID, UserID, Amount, RecipientEmail
        $query = "SELECT CardID, UserID, Amount, RecipientEmail FROM egiftcards WHERE CardID = ?";
        $result = $db->select($query, [$cardId]); // Assuming $db->select returns an array of associative arrays

        if ($result && count($result) > 0) {
            $data = $result[0];
            // Constructor call MODIFIED: No receiverName argument
            return new EGift(
                $db,
                $data['CardID'],
                $data['UserID'],
                $data['RecipientEmail'],
                // No RecipientName here
                $data['Amount']
            );
        }
        return null;
    }

    public static function getAllByUser(DBController $db, $userId) {
        // Assuming your table has CardID, UserID, Amount, RecipientEmail
        // and potentially a DateCreated column if you want to order by it
        $query = "SELECT CardID, UserID, Amount, RecipientEmail FROM egiftcards WHERE UserID = ? ORDER BY CardID DESC"; // Or DateCreated if it exists
        return $db->select($query, [$userId]); // Returns array of records
    }
}
?>