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
        <p style = "font-size:2em; color: red;">
            <b>Your session has enden or you had tried to access the system without logging in.</b><br>
            Either way, Please log in properly with the correct username and password!
        </p>

        <form action="NoSession.php" method="POST">
            <input type="submit" name="return_to_Login" value="Return to login page" style="font-size:20px;">
        </form>

        <?php if(isset($_POST['return_to_Login'])){ header("Location: http://localhost/alumnitalk/index.php");  }   ?>


    </div>
    
</body>
</html>