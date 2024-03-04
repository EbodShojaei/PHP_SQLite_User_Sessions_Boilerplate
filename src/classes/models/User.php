<?php

class User {
    private $id;
    private $email;
    private $nickname;
    private $password;
    private $role;

    public function __construct($id, $email, $nickname) {
        $this->id = $id;
        $this->email = $email;
        $this->nickname = $nickname;
        $this->role = 'user'; // Default role is 'user
    }

    public function getId() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getNickname() {
        return $this->nickname;
    }

    public function getRole() {
        return $this->role;
    }
}
