<?php 

    $db_host = 'localhost';
    $db_user = 'root';
    $db_password = '';
    $my_db = 'library';
    $db = new mysqli($db_host, $db_user, $db_password, $my_db);

    session_start();
    if($db->connect_error){
        exit('Cannot establish connection to server...'.$db->connect_error);
    }

    require_once $_SERVER['DOCUMENT_ROOT'].'/library/config.php';
    require_once BASEURL.'helpers/helpers.php';

    if(isset($_SESSION['user'])){
        $userID = $_SESSION['user'];
        $sql= $db->query("SELECT * FROM users WHERE id = '$userID' ");
        $user_info = mysqli_fetch_assoc($sql);
        
        $_SESSION['USER_ID'] = $user_info['id'];
        $_SESSION['FIRST_NAME'] = $user_info['first_name'];
        $_SESSION['LAST_NAME'] = $user_info['last_name'];
        $_SESSION['ROLE'] = $user_info['role'];
    }


?>