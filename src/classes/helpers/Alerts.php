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
            echo
            "<div id='alert-container' class='alert alert-$type alert-dismissible fade show position-fixed w-75 mx-auto' style='top: 10px; left: 0; right: 0; z-index: 1111;' role='alert'>
                $message
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
        }
    }
}
