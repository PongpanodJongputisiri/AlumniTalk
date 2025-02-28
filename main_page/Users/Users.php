<?php       
    include ("../sessions.php");
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Users</title>
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
                    <form action="Users.php" method="POST">
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
                    <?php
                        $sql = "SELECT * FROM user ";
                        $result = mysqli_query($conn, $sql);

                        echo "<table border='1' >";
                        echo "<tr><th>Username</th><th>Name</th><th>Email</th><th>Status</th></tr>";

                        while($row = mysqli_fetch_assoc($result)){
                        
                        $username = $row['username'];
                        $name = $row['name'];
                        $mail = $row['SIIT_Mail'];
                        $status = $row['Status'];

                        echo "<tr>";
                        echo "<td> $username </td><td> $name </td><td> $mail </td><td> $status </td>";
                        }

                        echo "</table><br><br>";
                    ?>
                    <form action="Users.php" method="POST">
                        <label for="user">DELETE USER : </label>
                        <input type="text" name="user"></input>
                        <input type="submit" name="delete" value="DELETE"></input>
                    </form>
                    
                    <?php
                        if(isset($_POST['delete'])){
                        
                            $user = filter_input(INPUT_POST, "user", FILTER_SANITIZE_SPECIAL_CHARS);
                        
                            $sql = "SELECT * FROM user WHERE username = ?";
                            $stmt = $conn->prepare($sql);
                            $stmt->bind_param("s",$user);
                            
                            if($stmt->execute()){
                                $result = $stmt->get_result();
                                $row = $result->fetch_assoc();

                                if($result->num_rows == 0){
                                    die("No user found");
                                }

                                if(strtolower($row['Status']) == "admin"){
                                    die("Cannot delete Admin");
                                }


                                $sql = "DELETE FROM user WHERE username = ?";
                                $stmt = $conn->prepare($sql);
                                $stmt->bind_param("s",$user);

                                if($stmt->execute()){
                                    echo "User $user sucessfully deleted";
                                } else {
                                    echo "Error: " . $stmt->error;
                                }
                                
                            } else {
                                echo "Error: " . $stmt->error;
                            }
                        }
                    ?>
                    
                </p>
            </div>
        </div>        
    </body>
</html>
    
<?php

?>

