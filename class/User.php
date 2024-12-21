<?php

class User
{
    public int $id;
    public string $email;
    public string $password;
    public ?string $name;

    public ?int $phone;
    public ?string $avatar;
    public ?string $address;

    public function __construct(int $id, string $email, string $password, string $name, int $phone, string $avatar, string $address)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->name = $name;
        $this->phone = $phone;
        $this->avatar = $avatar;
        $this->address = $address;
    }
}
