<?php

class AuthMiddleware
{
    private $tokenManager;

    public function __construct(TokenManager $tokenManager)
    {
        $this->tokenManager = $tokenManager;
    }

    public function checkAuthenticated()
    {
        if (Cookie::exists('auth_token')) {
            $token = Cookie::get('auth_token');
            $isLoggedIn = $this->tokenManager->validateToken($token);
            if ($isLoggedIn) {
                return $token;
            }
        }
        return null;
    }

    public function checkAuthorized($role = 'admin')
    {
        $token = $this->checkAuthenticated();
        $userRole = $this->tokenManager->getUserRoleFromToken($token);
        if ($userRole !== $role) {
            header('Location: /');
            exit();
        }
    }

    public function checkUnauthenticated()
    {
        if (Cookie::exists('auth_token')) {
            $token = Cookie::get('auth_token');
            $isLoggedIn = $this->tokenManager->validateToken($token);
            if ($isLoggedIn) {
                header('Location: /');
                exit();
            }
        }
    }
}
