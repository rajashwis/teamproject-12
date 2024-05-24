<?php

    session_start();
    session_destroy();
    header("Location: signin/signin.html"); // Redirect to the login page after logout
?>