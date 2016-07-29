<?php
    /**
     *  init.php is required and built on every page
     *  Ajax will make resetting the time a little
     *  Interesting...ADVISE PLEASE
     */
    session_start();

    // Set current time to be used in evaluating session timeout/log off
    date_default_timezone_set('America/Chicago');
    $now = time();

    $app = dirname(__FILE__);
    $ds = DIRECTORY_SEPARATOR;

// Require class files -- Use absolute path, hence dirname(__FILE__) which is
// equivalent to __DIR__, but older, and will work on more servers -> in theory.
    require_once($app . $ds . 'classes' . $ds . 'Hash.php');
    require_once($app . $ds . 'classes' . $ds . 'Database.php');
    require_once($app . $ds . 'classes' . $ds . 'Authorize.php');


// Instantiate classes
    $db = new Database;
    $hash = new Hash;
    $auth = new Authorize($db, $hash);

    if($auth->check())
    {
        if(!isset($_SESSION['USER_AUTH']))
        {
            session_regenerate_id();
            $_SESSION['USER_AUTH'] = 'ACTIVE';
        }

        if(!isset($_SESSION['CART']))
        {
            $_SESSION['CART'] = array();
        }

        if(!isset($_SESSION['PID']))
        {
            $_SESSION['PID'] = array();
        }
    }

    if (isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after']) {
        if ($auth->check()) {
            $auth->signout();
        }

        $_SESSION = array();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
        header('Location: 0; url=./');
    }
    $_SESSION['discard_after'] = $now + 1000;

    define('COMP', '../components/');
