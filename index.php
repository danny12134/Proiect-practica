<?php
require_once 'php/auth.php';
require_once 'php/functions.php';

if (esteAutentificat()) {
    redirectTo('dashboard.php');
} else {
    redirectTo('login.php');
}
?>
