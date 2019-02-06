<?php
class Db {

    public $data = array();
    public $params = array();

    function __construct(){

        if( !empty($_POST) ){ // Escape the $_POST

            $conn = $this->con();
            $escPost = array();
            foreach($_POST as $key => $value){
                if( is_array($value) ){
                    foreach($value as $inner_key => $inner_value){
                        $escPost[$key][$inner_key] = mysqli_real_escape_string($conn, $inner_value);
                    }
                }else{
                    $escPost[$key] = mysqli_real_escape_string($conn, $value);
                }
            }

            $conn->close();
            $this->data = $escPost;
        }


        if( !empty($_GET) ){ // Escape the $_GET

            $conn = $this->con();
            $escGet = array();
            foreach($_GET as $key => $value){
                $escGet[$key] = mysqli_real_escape_string($conn, $value);
            }
            $conn->close();
            $this->params = $escGet;
        }

    }

    function con(){

        $servername = "localhost";
        $username = "eatsandw_orgisfd";
        $password = "eJRMMSmIpzaJ";
        $dbname = "eatsandw_otrhoijreuhifjdf";
        $conn = new mysqli($servername, $username, $password, $dbname);
        if($conn->connect_error){
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }

    function select($sql){

        $conn = $this->con();
        $result = $conn->query($sql);
        $xssArr = array();
        if($result->num_rows > 0){

            $x = 0;
            while($row = $result->fetch_assoc()){

                foreach($row as $column => $value){
                    $xssArr[$x][$column] = htmlspecialchars($value, ENT_QUOTES);
                }

                $x++;

            }
        }

        $conn->close();
        return $xssArr;

    }

    function execute($sql){

        $conn = $this->con();
        if($conn->query($sql) !== TRUE){
            echo "Your Statement: " . $sql . "<br><br>Error" . $conn->error;
            die('error with mysql execution');
        }
        $conn->close();

    }

    function execute_return_id($sql){

        $conn = $this->con();
        if($conn->query($sql) !== TRUE){
            echo "Your Statement: " . $sql . "<br><br>Error" . $conn->error;
            die('error with mysql execution');
        }
        $last_id = $conn->insert_id;

        $conn->close();
        return $last_id;

    }


}
