<?php
class Order {
    private int $orderId;
    private int $artworkID;
    private int $totalPrice;
    private string $orderDate;
    private string $status;
    private int $customerId;

    public function placeOrder(): bool {
        return false;
    }

    public function getTotalPrice(): int {
        return $this->totalPrice;
    }

    public function getOrderId(): int {
        return $this->orderId;
    }

    public function setOrderId(int $orderId): void {
        $this->orderId = $orderId;
    }

    public function getArtworkID(): int {
        return $this->artworkID;
    }

    public function setArtworkID(int $artworkID): void {
        $this->artworkID = $artworkID;
    }

    public function setTotalPrice(int $totalPrice): void {
        $this->totalPrice = $totalPrice;
    }

    public function getOrderDate(): string {
        return $this->orderDate;
    }

    public function setOrderDate(string $orderDate): void {
        $this->orderDate = $orderDate;
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function setStatus(string $status): void {
        $this->status = $status;
    }

    public function getCustomerId(): int {
        return $this->customerId;
    }

    public function setCustomerId(int $customerId): void {
        $this->customerId = $customerId;
    }
}
