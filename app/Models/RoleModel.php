<?php
Class Role{
    private $title;
    public function __construct($title = '')
   {
       $this->title = $title;
   }

   public function add($conn) {
    $sql = "INSERT INTO roles (title)
        VALUES ('$this->title')";
        $res = mysqli_query($conn, $sql);
        if ($res) {
            return true;
        }
    }

    public static function all($conn) {
        $sql = "SELECT * FROM roles";
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

        $title = $data["title"];
        $sql = "UPDATE roles SET title = '$title' WHERE id = $id";
       $res = $conn->query($sql);
       if ($res)
       {
           return true;
       }
    }

    public static function delete($conn, $id) {
        $sql = "DELETE FROM roles where id = $id";
        $res = $conn->query($sql);
        if ($res) {
            return true;
        } 
    }

    public static function byId($conn, $id)
    {
        $sql = "SELECT * FROM roles WHERE id = $id";
        $res = $conn->query($sql);
        if ($res){
            $role = $res->fetch_assoc();
            return $role;
        }
    }
}


?>