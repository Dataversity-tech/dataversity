<?php
session_start();
require __DIR__.'/config.php';
$pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4', DB_USER, DB_PASS,
  [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]);
function e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function csrf(){ return $_SESSION['t'] ??= bin2hex(random_bytes(16)); }
function check(){ if(!hash_equals($_SESSION['t'] ?? '', $_POST['t'] ?? '')) die('Session expired. Go back, refresh and try again.'); }
function head($title){ echo '<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>'.e($title).'</title><link rel="icon" href="mark.svg"><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Manrope:wght@500;700;800&display=swap"><link rel="stylesheet" href="style.css"></head><body>'; }
