<?php

class AuthMiddleware {
    private $tokenManager;

    public function __construct(TokenManager $tokenManager) {
        $this->tokenManager = $tokenManager;
    }

    public function checkAuthenticated() {
        if (Cookie::exists('auth_token')) {
            $token = Cookie::get('auth_token');
            $userId = $this->tokenManager->getUserIdFromToken($token);
            $isLoggedIn = $this->tokenManager->validateToken($token, $userId);
            if ($isLoggedIn) {
                return $token;
            }
        }
        header('Location: /login');
        exit();
    }
}
