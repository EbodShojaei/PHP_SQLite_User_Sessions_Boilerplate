<?php

class User {
    private $id;
    private $email;
    private $nickname;
    private $password;

    public function __construct($id, $email, $nickname) {
        $this->id = $id;
        $this->email = $email;
        $this->nickname = $nickname;
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
}
