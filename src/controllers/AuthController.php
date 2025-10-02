<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {
    public static function login($email, $password) {
        $user = User::findByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            return true;
        }
        return false;
    }
    public static function register($name, $email, $password, $type) {
        if (User::findByEmail($email)) return false;
        $hash = password_hash($password, PASSWORD_DEFAULT);
        return User::create($name, $email, $hash, $type);
    }
    public static function requireLogin() {
        if (!isset($_SESSION['user'])) {
            header('Location: login.php');
            exit;
        }
    }
    public static function logout() {
        session_destroy();
        header('Location: login.php');
        exit;
    }
}
