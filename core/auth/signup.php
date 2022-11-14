<?php
    // @route: /api/auth/signup
    GLOBAL $db;

    $first = "Rayan";
    $last = "Inerky";
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = "060749319656";
    $sex = "male";


try {
    $db->insert('users', [
        "first" => $first,
        "last" => $last,
        "email" => $email,
        "password" => $password,
        "phone" => $phone,
        "sex" => $sex
    ]);

    redirect("/sign-in");
} catch (Exception $e) {
    redirect("/sign-up?error=" . url_encode_str("An error occurred while creating your account."));
}




