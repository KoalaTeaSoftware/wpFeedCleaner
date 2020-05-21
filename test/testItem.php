<?php
require_once "../components/cleanupWordPressFeed.php";

error_log("\n-------------------------------------------------------------------------------");
error_log("Server is: " . print_r($_SERVER, true));
error_log("Method is: " . $_SERVER['REQUEST_METHOD']);
error_log("GET global contains: " . print_r($_GET, TRUE));
error_log("POST global contains: " . print_r($_POST, TRUE));
error_log("\n-------------------------------------------------------------------------------");
//
print_r(cleanupWordPressFeed("https://thegreenlands.home.blog/tag/the-dwarf/feed/"));
