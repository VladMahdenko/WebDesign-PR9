<?php
class UsersController
{
   private $conn;
   public function __construct($db)
   {
       $this->conn = $db->getConnect();
   }

   public function index()
   {
       if ($_SESSION["auth"]==true)
       {
        include_once 'app/Models/UserModel.php';
        $users = (new User())::all($this->conn);
        include_once 'views/users.php';
       }
       else header('Location: ?controller=index');
   }

   public function addForm(){
    if ($_SESSION["auth"]==true)
    {
        include_once 'views/addUser.php';
    }
   }

   public function add()
   {
    if ($_SESSION["auth"]==true)
    {
       include_once 'app/Models/UserModel.php';
       $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
       $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
       $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
       $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
       $target_dir = "public/uploads/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        $isUploaded = false;
        $filePath = '';
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            $filePath = $target_dir . basename($_FILES["photo"]["name"]);
            $isUploaded = true;
        }
        else $filePath='public/uploads/blank_profile.png';   
       if (trim($name) !== "" && trim($email) !== "" && trim($gender) !== "") {
           $user = new User($name, $email, $gender, $filePath, $password);
           $user->add($this->conn);
       }
       header('Location: ?controller=users');
    }
   }

    public function delete() {
    if ($_SESSION["auth"]==true){
        include_once 'app/Models/UserModel.php';
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (trim($id) !== "" && is_numeric($id)) {
            (new User())::delete($this->conn, $id);
        }
        header('Location: ?controller=users');
    }
    }

    public function show(){
    if ($_SESSION["auth"]==true){
        include_once 'app/Models/UserModel.php';
        $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (trim($id) !== "" && is_numeric($id)) {
            $user = (new User())::byId($this->conn, $id);
        }
        include_once 'views/showUser.php';     
    }
    }

    public function edit(){
    if ( $_SESSION["auth"]==true){

        include_once 'app/Models/UserModel.php';
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $target_dir = "public/uploads/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        $isUploaded = false;
        $filePath = '';
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            $filePath = $target_dir . basename($_FILES["photo"]["name"]);
            $isUploaded = true;
        }
        else $filePath='public/uploads/blank_profile.png';

        if (trim($name) !== "" && trim($email) !== "" && trim($gender) !== "" && trim($id) !== "" && is_numeric($id)) {
           $data=[];
           $data["email"]=$email;
           $data["name"]=$name;
           $data["gender"]=$gender;
           $data["filepath"]=$filePath;
           $data["password"]=$password;
           (new User())::update($this->conn, $id, $data);
        }
        header('Location: ?controller=users');
    }
    }
 
}
