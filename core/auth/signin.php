<?php
    // @route: /api/auth/signin
    GLOBAL $db;


    $email = $_POST['email'];
    $password = $_POST['password'];
    $user = $db->get("users", "*", [
        "email" => $email
    ]);

    // we don't even check fot any password match, it's not our job
    if ($user) {
        $_SESSION['user'] = $user;
        redirect("/lobby");
    } else {
        redirect("/sign-in?error=" . url_encode_str("Invalid email or password."));
    }

