<?php
session_start();

/*
 * Database Connection
 * */
require __DIR__ . "/core/db.php";


/*
 * Globals
 * */
define("URI", substr($_SERVER['REQUEST_URI'], 1));
define("PAGES", array_filter(explode("/", explode("?", URI)[0]), function ($v, $k) {
    return $v !== "/";
}, ARRAY_FILTER_USE_BOTH));
define("IS_LOGGED_IN", isset($_SESSION['user']['email']));



/*
 * Global Functions
 * */
function require_login($redirect = "/sign-in")
{
    if (!IS_LOGGED_IN) {
        redirect($redirect);
        exit();
    }
}

function redirect($url)
{
    header("Location: $url");
    exit;
}

function render_page($page, $layout, $data = [])
{
    // extract the data to variables
    extract($data);
    // start output buffering
    ob_start();
    // include the page
    include "templates/pages/$page.php";
    // get the contents of the output buffer
    $pageContent = ob_get_contents();
    // clean (erase) the output buffer and turn off output buffering
    ob_end_clean();
    // start output buffering
   
    ob_start();
    // include the layout
    include "templates/layouts/$layout.php";
    // get the contents of the output buffer
    $layoutContent = ob_get_contents();
    // clean (erase) the output buffer and turn off output buffering
    ob_end_clean();


    // print the layout with the page content inside
    $html = str_replace("{{ LAYOUT_CONTENT }}", $pageContent, $layoutContent);
    // Search for all the {{ $data }} that are in $data
    $html = preg_replace_callback('/{{\s*([a-zA-Z0-9_]+)\s*}}/', function ($matches) use ($data) {
        return $data[$matches[1]];
    }, $html);
    echo $html;
}

function handle_request($script, $group = "")
{
    $script = "core/$group/$script.php";
    if (file_exists($script)) {
        require $script;
    } else {
        render_page("500", "error");
    }
}

function url_encode_str($string)
{
    return str_replace(" ", "%20", $string);
}







/*
 * Routing
 * */

switch (PAGES[0]) {
    case "":
        render_page("index", "main");
        break;
    case "sign-in":
        render_page("signin", "main");
        break;
    case "sign-up":
        render_page("signup", "main");
        break;
    case "lobby":
        require_login();
        if (isset(PAGES[1]) && strlen(PAGES[1]) > 0) {
            handle_request("call");
        } else {
            render_page("lobby", "main");
        }
        break;
    case "api":
        switch (PAGES[1]) {
            case "auth":
                if (isset(PAGES[2]) && PAGES[2] == "signin")
                    handle_request("signin", "auth");
                else if (isset(PAGES[2]) && PAGES[2] == "signup")
                    handle_request("signup", "auth");
                else if (isset(PAGES[2]) && PAGES[2] == "signout")
                    handle_request("signout", "auth");
                break;
        }
    default:
        render_page("404", "error");
        break;
}