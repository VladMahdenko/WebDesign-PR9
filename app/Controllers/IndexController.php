<?php
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
       session_unset();
       session_destroy();
       session_start();
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $sql = "SELECT * FROM users";
        $res = $this->conn->query($sql);
        if ($res && !empty($password))
        {
            while ( $db_field = $res->fetch_assoc() ) {
                if (str_contains($db_field["password"], $password) && str_contains($db_field["email"], $email))
                {
                    $_SESSION["auth"]=true;
                    header('Location: ?controller=users&action=index');
                    return;
                } 
            }
        }
        $_SESSION["auth"]=false;
        header('Location: ?controller=index');
   }

   public function logout(){
    session_unset();
    session_destroy();
    header('Location: ?controller=index');
   }
}
