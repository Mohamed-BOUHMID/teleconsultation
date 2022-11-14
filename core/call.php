<?php
    // Handel the reaquest of the call page
    // Path: core\rtc\call.php
    GLOBAL $db;



    /*
     * Check if the call exists, if not send him to the lobby
     * */
    $call = $db->get("calls", "*", [
        "call_id" => PAGES[1]
    ]);

    if (!$call) {
        redirect("/lobby?error=" . url_encode_str("A call with this id does not exist"));
        exit();
    }

    /*
     * Check if the user is on this call
     * */
    if (
        $call['doctor'] !== $_SESSION['user']['id'] &&
        $call['patient'] !== $_SESSION['user']['id']
    ){
        redirect("/lobby?error=" . url_encode_str("You're not allowed in that call"));
        exit();
    } else {
        render_page("call", "call", [
            "callId" => PAGES[1],
            "email" => $_SESSION['user']['email'],
        ]);
    }