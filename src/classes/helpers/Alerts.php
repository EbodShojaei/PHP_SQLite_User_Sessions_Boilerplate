<?php

class Alerts
{
    public static function setAlert($message, $type = 'info')
    {
        $_SESSION['alert'] = $message;
        $_SESSION['alert_type'] = $type;
    }

    public static function getAlert()
    {
        if (isset($_SESSION['alert']) && isset($_SESSION['alert_type'])) {
            $alert = ['message' => $_SESSION['alert'], 'type' => $_SESSION['alert_type']];
            unset($_SESSION['alert'], $_SESSION['alert_type']);
            return $alert;
        }
        return null;
    }

    public static function display()
    {
        $alert = self::getAlert();
        if ($alert !== null) {
            $message = $alert['message'];
            $type = $alert['type'];
            echo "<div class='alert alert-$type'>$message</div>";
        }
    }
}
