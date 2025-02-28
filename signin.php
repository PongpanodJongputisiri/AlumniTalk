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
        <p>SIGN IN</p>
        <div name="label" style="float: left; margin-left:10em;margin-right:20px;text-align:right;line-height:21px;">
            <p> 
            Preferred username : <br>
            Enter your name    : <br>
            Enter password     : <br>
            Re enter password  : <br>
            Enter Email:<br>
            </p>
        </div>
        <div style="text-align:left;">
            <form action="signin.php" method="post" style="margin:2em;">
                <input type='text' name='username'required ><br>
                <input type='text' name='name'required ><br>
                <input type='password' name='password' required><br>
                <input type='password' name='re_password' required><br>
                <input type='text' name='email' required><br>
                <input type='submit' value ='Sign in' name='Sign_in' >
            </form>
        </div>
    </div>


</body>
</html>

<?php

    //IP whitelisting

    //connection
    include('Main_Page/database.php');

    if($_SERVER["REQUEST_METHOD"] == "POST"){
    
        if (isset($_POST["Sign_in"])){
            //input
                $username = filter_input(INPUT_POST,'username', FILTER_SANITIZE_SPECIAL_CHARS);
                $name = filter_input(INPUT_POST,'name', FILTER_SANITIZE_SPECIAL_CHARS);
                $password = filter_input(INPUT_POST,'password', FILTER_SANITIZE_SPECIAL_CHARS);
                $re_password = filter_input(INPUT_POST,'re_password', FILTER_SANITIZE_SPECIAL_CHARS);
                $email = filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL);


                    //check if password match
                if($password != $re_password){
                    echo "Password does not match<br>";
                    echo $password . "<br>" . $re_password;
                    exit;
                }
                
                    //check if user exist
                $sql = "SELECT * FROM user WHERE username = ? OR `name` = ? OR `SIIT_Mail` = ? ";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sss",$username ,$name ,$email);

                if($stmt->execute()){
                    $result = $stmt->get_result();
                    if($result->num_rows !== 0){
                        die("This user (name, username or email) has already registered");
                    }
                } else {
                    echo "Error: " . $stmt->error;
                }

                    //check email (Change to SIIT's email)
                if (substr(strrchr($email, "@"), 1) !== "g.siit.tu.ac.th") {
                    die("Access denied. Use an SIIT email.");
                }
                    
            
                //password hashing
                    $hash = password_hash($password, PASSWORD_BCRYPT);
            

                    $sql = "INSERT INTO `user` (`username`, `password`, `name`, `SIIT_Mail`, `Status`) VALUES ( ? , ? , ? , ? ,'user')";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ssss",$username, $hash, $name, $email);
                    
                
                    if($stmt->execute()){
                        header("Location: http://localhost/alumnitalk/index.php");
                    } else {
                        echo "ERROR : $sql --------" . $conn->error;
                    }
                

        }

    }



?>