<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log in</title>
    <link rel="stylesheet" href="style.css" type="text/css">    
    <link rel="SHORTCUT ICON" href="favicon.ico">
</head>
<body>
    <!--  Headings  -->
    <div style="margin-bottom:5px; background-image:url(siit.png); background-repeat:no-repeat; height:70px; padding-left:90px; color:#8800aa; text-align:left; width:min-content; width: 700px;">
    <p style="margin:0px; padding:0px;">Sirindhorn International Institute of Technology, Thammasat University<br>
    <span style="font-size:26px; font-weight:bold;">Alumni Talk Database System</span><br>
    by Student Affairs and Alumni Relations Division</p></div>

    <div id="wrapper">
        <form action="index.php" method="POST" style="margin:2em">
            <lable for='username'>username : </lable>
            <input type='text' name='username'required ><br>
            <lable for='password'>password : </lable>
            <input type='password' name='password' required><br>
            <input type='submit' value ='Login' name='Login' ><br>
        </form>

        <?php   //echo password_hash("1234", PASSWORD_BCRYPT);    ?>
        <form action="index.php" method="POST">
            <input type='submit' value ='Sign in' name='Sign_in' >
        </form>

    </div>


</body>
</html>

<?php
    
    //connection
    include('Main_Page/database.php');


    if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    //Login

        if(isset($_POST["Login"])){
            
        //input

            $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
            $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

            //$hash = password_hash($password, PASSWORD_BCRYPT); echo $hash;
        
        //sql query

            $sql = ("SELECT `password`,`name` FROM user WHERE username =  ?");
            $stmt =  $conn->prepare($sql);
            $stmt->bind_param("s",$username);
            $stmt->execute();
            $stmt->bind_result($hash,$name);
            $stmt->fetch();


        //password verification

            if(password_verify($password, $hash)){
        
            //sessions
                session_start();
                $_SESSION["name"] = $name;
                $_SESSION["time"] = time();

            //location file
                header("Location: Main_Page/main.php");
            }
            else{
                echo"incorrect password!";
            }

        //close stmt and connection

            $stmt->close();
            $conn->close();
        }    
        


        if(isset($_POST["Sign_in"])){
            header("Location: http://localhost/alumnitalk/signin.php");
        }

    }


    
?>