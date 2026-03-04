<?php
// logout.php
require_once __DIR__ . '/includes/auth.php';

session_unset();
session_destroy();

header("Location: /Activition/index.php");
exit;
