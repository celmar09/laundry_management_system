<?php
declare(strict_types=1);
session_start();
date_default_timezone_set('Asia/Manila');

const DB_HOST = '127.0.0.1';
const DB_NAME = 'laundry_system';
const DB_USER = 'root';
const DB_PASS = '';

function db(): PDO {
    static $pdo = null;
    if (!$pdo) {
        $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4', DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
    return $pdo;
}
function e($v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function money($v): string { return '₱'.number_format((float)$v, 2); }
function logged_in(): bool { return isset($_SESSION['user']); }
function require_login(): void { if (!logged_in()) { header('Location: login.php'); exit; } }
function csrf(): string { if (empty($_SESSION['csrf'])) $_SESSION['csrf']=bin2hex(random_bytes(32)); return $_SESSION['csrf']; }
function check_csrf(): void { if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) { http_response_code(419); exit('Session expired. Please go back and try again.'); } }
function flash(string $msg, string $type='success'): void { $_SESSION['flash']=['msg'=>$msg,'type'=>$type]; }
function take_flash(): ?array { $f=$_SESSION['flash']??null; unset($_SESSION['flash']); return $f; }
function code(): string { return 'LD-'.strtoupper(substr(bin2hex(random_bytes(5)),0,4)).'-'.strtoupper(substr(bin2hex(random_bytes(5)),0,4)); }
