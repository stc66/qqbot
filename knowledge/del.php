<?php
include("conn.php");
$id = isset($_GET['id']) ? $_GET['id'] : '';
if ($id != "") {
    $mysqli->query("DELETE FROM content WHERE id = '" . $id . "'");
    $mysqli->close();
    echo "<script>window.location =\"index.php\";</script>";
}
?>