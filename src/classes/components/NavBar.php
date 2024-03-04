<?php

class NavBar
{
    public static function render()
    {
        echo '<header>';
        echo '    <nav class="navbar navbar-expand-lg navbar-light bg-light px-5 py-2">';
        self::renderBrand();
        self::renderToggleButton();
        self::renderMenuItems();
        echo '    </nav>';
        echo '</header>';
    }

    private static function renderBrand()
    {
        echo '<a class="navbar-brand" href="/">Home</a>';
    }

    private static function renderToggleButton()
    {
        echo '<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">';
        echo '    <span class="navbar-toggler-icon"></span>';
        echo '</button>';
    }

    private static function renderMenuItems()
    {
        echo '<div class="collapse navbar-collapse" id="navbarNav">';
        echo '    <ul class="navbar-nav ms-auto">';
        if (isset($_COOKIE['auth_token'])) {
            if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
                self::renderAuthorizedUserItems();
            } else {
                self::renderAuthenticatedUserItems();
            }
        } else {
            self::renderUnauthenticatedUserItems();
        }
        echo '    </ul>';
        echo '</div>';
    }

    private static function renderAuthenticatedUserItems()
    {
        echo '<li class="nav-item"><a class="nav-link" href="/dashboard">Dashboard</a></li>';
        echo '<li class="nav-item"><a class="nav-link" href="/logout">Logout</a></li>';
    }

    private static function renderAuthorizedUserItems()
    {
        echo '<li class="nav-item"><a class="nav-link" href="/dashboard">Dashboard</a></li>';
        echo '<li class="nav-item"><a class="nav-link" href="/admin">Admin Console</a></li>';
        echo '<li class="nav-item"><a class="nav-link" href="/logout">Logout</a></li>';
    }

    private static function renderUnauthenticatedUserItems()
    {
        echo '<li class="nav-item"><a class="nav-link" href="/register">Register</a></li>';
        echo '<li class="nav-item"><a class="nav-link" href="/login">Login</a></li>';
    }
}
