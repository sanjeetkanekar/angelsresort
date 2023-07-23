<?php      
    session_start();
    include('conn.php');  
    $username = $_POST['username'];  
    $password = $_POST['password'];  

      
        //to prevent from mysqli injection  
        $username = stripcslashes($username);  
        $password = stripcslashes($password);  
        $username = mysqli_real_escape_string($conn, $username);  
        $password = mysqli_real_escape_string($conn, $password);  
      
        $sql = "select *from angels_admin where username = '$username' and password = '$password'";  
        $result = mysqli_query($conn, $sql);  
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
        $count = mysqli_num_rows($result);  
          
        if($count == 1){ 
            $_SESSION['login_user'] = $username; 
            echo "<script>alert('Login successful'); window.location='dashboard.php';</script>";  
        }  
        else{  
            echo "<script>alert('Login failed. Invalid username or password.')</script>";  
        }     
?>  