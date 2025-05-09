<?php

class EGift
{
    private int $ID;
    private int $customerSenderID;
    protected string $receiverEmail;
    protected string $receiverName;
    private int $value;

    // Constructor
    public function __construct(int $ID, int $customerSenderID, string $receiverEmail = '', string $receiverName = '', int $value = 0) {
        $this->ID = $ID;
        $this->customerSenderID = $customerSenderID;
        $this->receiverEmail = $receiverEmail;
        $this->receiverName = $receiverName;
        $this->value = $value;
    }

    // Set the gift value
    public function setValue(int $value): void {
        $this->value = $value;
    }

    // Get the gift value
    public function getValue(): int {
        return $this->value;
    }

    // Get the sender's customer ID
    public function getCustomerSenderID(): int {
        return $this->customerSenderID;
    }

    // Set the receiver's email
    public function setReceiverEmail(string $email): void {
        $this->receiverEmail = $email;
    }

    // Get the receiver's name
    public function getReceiverName(): string {
        return $this->receiverName;
    }

    // Optional getters/setters for protected/private properties if needed
    public function getReceiverEmail(): string {
        return $this->receiverEmail;
    }

    public function setReceiverName(string $name): void {
        $this->receiverName = $name;
    }

    public function getID(): int {
        return $this->ID;
    }

    public function setID(int $id): void {
        $this->ID = $id;
    }
}
?>
