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

    public function checkAuthorized()
    {
        $token = $this->checkAuthenticated();
        $userRole = $this->tokenManager->getUserRoleFromToken($token);
        if ($userRole !== 'admin') {
            header('Location: /error/404');
            exit();
        }
    }

    public function checkStatus()
    {
        $token = $this->checkAuthenticated();
        $userStatus = $this->tokenManager->getUserStatusFromToken($token);
        if ($userStatus === 'active') {
            header('Location: /');
            exit();
        }
    }
}
