<?php

    session_start();
    session_destroy();
    header("Location: login/login.html"); // Redirect to the login page after logout
?>