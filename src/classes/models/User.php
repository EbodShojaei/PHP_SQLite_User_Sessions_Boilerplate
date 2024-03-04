<?php

class User {
    private $id;
    private $email;
    private $nickname;
    private $password;
    private $status;

    public function __construct($id, $email, $nickname, $status='user') {
        $this->id = $id;
        $this->email = $email;
        $this->nickname = $nickname;
        $this->status = $status;
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

    public function getStatus() {
        return $this->status;
    }
}
