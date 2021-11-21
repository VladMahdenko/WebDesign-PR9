<?php
class User {
   private $name;
   private $email;
   private $gender;
   private $filepath;
   private $password;

   public function __construct($name = '', $email = '', $gender = '', $filepath='', $password='')
   {
       $this->name = $name;
       $this->email = $email;
       $this->gender = $gender;
       $this->filepath = $filepath;
       $this->pasword = $password;
   }

   public function add($conn) {
       $sql = "INSERT INTO users (email, name, gender, password, path_to_img)
           VALUES ('$this->email', '$this->name','$this->gender', '$this->pasword', '$this->filepath')";
           $res = mysqli_query($conn, $sql);
           if ($res) {
               return true;
           }
   }

   public static function all($conn) {
       $sql = "SELECT * FROM users";
       $result = $conn->query($sql); //виконання запиту
       if ($result->num_rows > 0) {
           $arr = [];
           while ( $db_field = $result->fetch_assoc() ) {
               $arr[] = $db_field;
           }
           return $arr;
       } else {
           return [];
       }
   }


   public static function update($conn, $id, $data) {

        $name = $data["name"];
        $email = $data["email"];
        $gender = $data["gender"];
        $filepath = $data["filepath"];
        $password=$data["password"];
        $sql = "UPDATE users SET name = '$name', email = '$email', gender = '$gender', path_to_img = '$filepath', password ='$password' WHERE id = $id";
       $res = $conn->query($sql);
       if ($res)
       {
           return true;
       }
   }
   public static function delete($conn, $id) {
    $sql = "DELETE FROM users where id = $id";
    $res = $conn->query($sql);
    if ($res) {
        return true;
    } 
   }

   public static function byId($conn, $id)
   {
       $sql = "SELECT * FROM users WHERE id = $id";
       $res = $conn->query($sql);
       if ($res){
           $user = $res->fetch_assoc();
           return $user;
       }
   }
}
