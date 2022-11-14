<h1>Lobby Page</h1>

<?php if (isset($_GET['error'])): ?>
<div class="alert alert-danger">
    <?= $_GET['error'] ?>
</div>
<?php endif ?>






<!-- You need to edit this, it's just a basic example for the moment !!!!!!!! --->
<?php
    GLOBAL $db;
    $calls = $db->select("calls", "*", [
        "OR" => [
            "doctor" => $_SESSION['user']['id'],
            "patient" => $_SESSION['user']['id']
        ]
    ]);
    if ($calls) {
        foreach ($calls as $call) {
            echo "<a class='btn btn-primary mr-1' href='/lobby/" . $call['call_id'] . "'> Join Call " . $call['call_id'] . "</a>";
        }
    }
?>