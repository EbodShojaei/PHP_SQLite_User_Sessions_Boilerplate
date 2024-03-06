<?php

class AuthMiddleware
{
    private $tokenManager;

    public function __construct(TokenManager $tokenManager)
    {
        $this->tokenManager = $tokenManager;
    }

    private function redirect($location)
    {
        header("Location: $location");
        exit();
    }

    private function hasToken()
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

    public function isAuthenticated() {
        $token = $this->hasToken();
        if ($token) {
            $status = $this->tokenManager->getUserStatusFromToken($token);
            if ($status === 'active') return true;
        }
        return false;
    }

    public function checkAuthorized()
    {
        $token = $this->hasToken();
        $userRole = $this->tokenManager->getUserRoleFromToken($token);
        if ($userRole !== 'admin') $this->redirect('/error/404');
    }

    public function checkAuthenticated()
    {
        $token = $this->hasToken();
        $userStatus = $this->tokenManager->getUserStatusFromToken($token);
        if ($token && $userStatus === 'active') {
            header('Location: /');
            exit();
        }
    }

    public function checkUnauthenticated()
    {
        $token = $this->hasToken();
        $userStatus = $this->tokenManager->getUserStatusFromToken($token);
        if ($token && $userStatus !== 'active') {
            header('Location: /');
            exit();
        }
    }
}
