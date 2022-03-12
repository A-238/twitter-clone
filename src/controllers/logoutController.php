<?php
// ログアウト
require_once('./init.php');

$_SESSION = [];
session_destroy();

header('location: ' . BASE_URL);