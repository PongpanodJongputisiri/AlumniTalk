<?php       
    include ("sessions.php");
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Main Page</title>
        <link rel="stylesheet" href="../style.css" type="text/css">    
        <!-- Fucken "StyleSheet" will mess up the html -->
        <link rel="SHORTCUT ICON" href="../favicon.ico">
    </head>
    <body>
        <!--  Headings  -->
        <div style="margin-bottom:5px; background-image:url(../siit.png); background-repeat:no-repeat; height:70px; padding-left:90px; color:#8800aa; text-align:left; width:min-content; width: 700px;">
            <p style="margin:0px; padding:0px;">Sirindhorn International Institute of Technology, Thammasat University<br>
            <span style="font-size:26px; font-weight:bold;">Alumni Talk Database System</span><br>
            by Student Affairs and Alumni Relations Division</p>
        </div>
        
        <!-- Page Content -->
        <div id="wrapper">
            <!-- connection test -->
            <div id="connection"> 
                <b>database connection</b> : <?php include __DIR__.('/database.php'); echo $connection; ?>
            </div>

            <!-- Menu -->
            <div id="leftmenu">
                    <form action="main.php" method="POST">
                        <h1 class="menuheader">Menu</h1>
                        <input type="submit" value="Upload" name="Upload" class="leftbutton"><br>	
                        <input type="submit" value="Edit Data" name="Edit_Data" class="leftbutton"><br>
                        <input type="submit" value="Search Data" name="Search_Data" class="leftbutton"><br>
                        <input type="submit" value="Certificate" name="Certificate" class="leftbutton"><br>
                        <input type="submit" value="Change Password" name="Change_Password" class="leftbutton"><br>
                        <input type="submit" value="Log Out" name="Log_Out" class="leftbutton"><br>
                        <h1 class="menuheader">Admin only</h1>
                        <input type="submit" value="Users" name="Users" class="leftbutton"><br>
                        <input type="submit" value="System Log" name="System_Log" class="leftbutton"><br>
                    </form>

                    <?php   include("leftmenu.php");  ?>
            </div>	

            <!-- main content -->
            <div id="content">
                <p style="font-size: 25px;">
                    Welcome <?php echo $name; ?>
                </p>
                <p style="font-size: 16px;margin:0px;"> What would you like to do today? </p>
            </div>
         
            <!--OUTPUT
            <fieldset id="result" class = "SearchData">
                <legend> Result </legend>
                <?php //echo "hi"; ?>
            </fieldset> -->
        </div>        
    </body>
</html>
    



