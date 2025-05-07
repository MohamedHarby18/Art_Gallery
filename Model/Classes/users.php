<?php
enum Role {
    case Customer;
    case Artist;
    case Advisor;
}

abstract class User
{
    private int $ID;
    public string $name;
    protected string $account;
    private string $password;
    private string $phoneNumber;
    private Role $userRole;
    
    public function __construct(string $name, string $account, string $password, string $phoneNumber) 
    {
        $this->name = $name;  
        $this->account = $account;
        $this->password = $password;
        $this->phoneNumber = $phoneNumber;  
    }
   
    // Fixed: You had two name() methods with same name (one getter, one setter)
    // Should be separate methods with different names
    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getAccount(): string
    {
        return $this->account;
    }
    
    public function setAccount(string $account): void
    {
        $this->account = $account;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getID(): int
    {
        return $this->ID;
    }
    
    public function setID(int $ID): void
    {
        $this->ID = $ID;
    }
    
    public function getUserRole(): Role
    {
        return $this->userRole;
    }
    
    public function setUserRole(Role $userRole): void
    {
        $this->userRole = $userRole;
    }
}