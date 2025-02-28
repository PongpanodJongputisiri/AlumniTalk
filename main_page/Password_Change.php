<?php       
    include ("../sessions.php");
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Change Password</title>
        <link rel="stylesheet" href="../../style.css" type="text/css">    
        <!-- Fucken "StyleSheet" will mess up the html -->
        <link rel="SHORTCUT ICON" href="../../favicon.ico">
    </head>
    <body>
        <!--  Headings  -->
        <div style="margin-bottom:5px; background-image:url(../../siit.png); background-repeat:no-repeat; height:70px; padding-left:90px; color:#8800aa; text-align:left; width:min-content; width: 700px;">
            <p style="margin:0px; padding:0px;">Sirindhorn International Institute of Technology, Thammasat University<br>
            <span style="font-size:26px; font-weight:bold;">Alumni Talk Database System</span><br>
            by Student Affairs and Alumni Relations Division</p>
        </div>
        
        <!-- Page Content -->
        <div id="wrapper">
            <!-- connection test -->
            <div id="connection"> 
                <b>database connection</b> : <?php include __DIR__.('/../database.php'); echo $connection; ?>
            </div>

            <!-- Menu -->
            <div id="leftmenu">
                    <form action="Password_Change.php" method="POST">
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

                    <?php   include("../leftmenu.php");  ?>
            </div>	

            <!-- main content -->
            <div id="content">
                <p style="font-size: 25px;">
                    <h1 id="contentheader">Change Password</h1>
                    <form action="Password_Change.php" method ="POST">
                        <label> Enter old password : </label>
                        <input type="password" name="old_password" required>
                        <br><label> Enter new password : </label>
                        <input type="password" name="New_password_1" required>
                        <br><label> Confirm new password : </label>
                        <input type="password" name="New_password_2" required>
                        <br><input type="submit" name="change_password" value="change password">
                    </form>
                    
                    <?php
                    
                    if (isset($_POST["change_password"])) {
                    
                        $oldPassword = filter_input(INPUT_POST, "old_password", FILTER_SANITIZE_SPECIAL_CHARS);
                        $newPassword1 = filter_input(INPUT_POST, "New_password_1", FILTER_SANITIZE_SPECIAL_CHARS);
                        $newPassword2 = filter_input(INPUT_POST, "New_password_2", FILTER_SANITIZE_SPECIAL_CHARS);
                    
                    
                        // Fetch the stored hashed password from the database
                        $sql = "SELECT `password` FROM user WHERE `name` = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("s", $name);
                        $stmt->execute();
                        $stmt->bind_result($storedHash);
                        $stmt->fetch();
                        $stmt->close();
                    
                        if (!$storedHash) {
                            die("User not found.");
                        }
                    
                        // Verify old password
                        if (!password_verify($oldPassword, $storedHash)) {
                            die("Incorrect password!");
                        }
                    
                        // Verify new passwords match
                        if ($newPassword1 !== $newPassword2) {
                            die("Passwords do not match!");
                        }
                    
                        // Hash the new password
                        $newHash = password_hash($newPassword1, PASSWORD_BCRYPT);
                    
                        // Update password in the database
                        $sql = "UPDATE user SET `password` = ? WHERE `name` = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("ss", $newHash, $name);
                    
                        if ($stmt->execute()) {
                            echo "Password successfully changed";
                        } else {
                            echo "Error: " . $stmt->error;
                        }
                    
                        $stmt->close();
                        $conn->close();
                    }

                    ?>

                </p>
            </div>
        </div>        
    </body>
</html>
    



