<?php

namespace App\Controllers;

class IndexController
{
    private $conn;
    public function __construct($db)
    {
        $this->conn = $db->getConnect();
    }

    public function index()
    {
        include_once 'views/home.php';
    }

    public function auth()
    {
        session_start();
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $sql = "SELECT * FROM users";
        $res = $this->conn->query($sql);
        if ($res && !empty($password)) {
            while ($db_field = $res->fetch_assoc()) {
                if (str_contains($db_field["password"], $password) && str_contains($db_field["email"], $email)) {
                    $_SESSION["auth"] = true;
                    header('Location: ?controller=users&action=index');
                }
            }
        } else {
            $_SESSION["auth"] = false;
            header('Location: ?controller=index');
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: ?controller=index');
    }

    public function sendMessage()
    {
        $author = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $theme = filter_input(INPUT_POST, 'theme', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $text = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $headers =  'MIME-Version: 1.0' . "\r\n";
        $headers .= 'From: Your name <info@address.com>' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        mail($_ENV['ADMIN_EMAIL'], $theme, $text, $headers);
    }

    public function contact()
    {
        include_once 'views/contacts.php';
    }
}
