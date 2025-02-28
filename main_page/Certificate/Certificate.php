<?php       
    include ("../sessions.php");
    $output = "";
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Certificate</title>
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
                    <form action="Certificate.php" method="POST">
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

            <!-- generate certificate -->
                <form action="Certificate.php" method="POST">
                    <h1 class="contentheader">Generate Certificate</h1>
                    <label for="Student_ID">Student ID : </label>
                    <input type="text" name="Student_ID">
                    <input type="submit" value="generate" name="generate">
                </form>

                <?php
                    if(isset($_POST["generate"])){
                        $Student_ID = filter_input(INPUT_POST, "Student_ID", FILTER_SANITIZE_SPECIAL_CHARS);

                        $sql = "SELECT * FROM students WHERE Student_ID = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("s", $Student_ID);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $row = $result->fetch_assoc();

                        $Name_Surname = $row['Name_Surname'];

                        //$stmt->close();

                        include("certificate/generate.php");
                        //$pdf->Output();
                    }
                ?>

            <!-- check certificate -->
                <form action="Certificate.php" method="POST">
                    <h1 class="contentheader">Certificate Info</h1>
                    <label for="Certificate_ID">Certificate ID : </label>
                    <input type="text" name="Certificate_ID"><br>
                    <input type="submit" value="check" name="check">
                </form>

                <?php
                    if(isset($_POST["check"])){
                        include("CheckCertificate.php");
                    }
                ?>

            <!-- Display PDF -->
                <form action="Certificate.php" method="POST">
                    <h1 class="contentheader">Display certificate</h1>
                    <label for="Certificate_ID">Enter certificate ID : </label>
                    <input type="text" name="Certificate_ID"><br>
                    <input type="submit" value="display" name="display">
                </form>

                <?php
                    if(isset($_POST["display"])){
                        $Certificate_ID = $_POST["Certificate_ID"];
                        $Year = substr($Certificate_ID,0,2);
                        $Month = substr($Certificate_ID,3,2);
                        $Certificate_Number = substr($Certificate_ID,6,5);

                        if(is_numeric($Year) AND is_numeric($Month) AND is_numeric($Certificate_Number)){
                            $filename = $Year.'-'.$Month.'_'.$Certificate_Number.'.pdf';
                            $filepath = __DIR__."/certificate/upload_certificate/$filename";
                            include("DisplayCertificate.php");
                            
                        }

                    }
                ?>

            </div>

         
            <!-- OUTPUT -->
            <fieldset id="result" class = "SearchData">
                <legend> Result </legend>
                <?php 
                    echo $output; 
                    $conn->close();    
                ?>
            </fieldset>
        </div>        
    </body>
</html>
    



