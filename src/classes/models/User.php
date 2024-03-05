<?php

class User {
    private $id;
    private $email;
    private $nickname;
    private $role;
    private $status;

    public function __construct($id, $email, $nickname, $role='user', $status='inactive') {
        $this->id = $id;
        $this->email = $email;
        $this->nickname = $nickname;
        $this->role = $role;
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

    public function getRole() {
        return $this->role;
    }

    public function getStatus() {
        return $this->status;
    }
}
