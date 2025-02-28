<?php       
    include ("../sessions.php");
    $output = "";
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Data</title>
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
                    <form action="Edit_Data.php" method="POST">
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

            <!-- student -->
                <form action="Edit_Data.php" method="POST">
                    <h1 class="contentheader">Student</h1>
                    <label for="Student_ID">student ID : </label>
                    <input type="text" name="Student_ID" required><br>

                    <label for="name_surname">new name : </label>
                    <input type="text" name="Name_Surname">
                    <input type="submit" value="change name" name="change_name"><br>

                    <label for="Student_Status">new student Status:</label>
                    <select name="Student_Status" id="Student_Status">
                        <option value="active">active</option>
                        <option value="inactive">inactive</option>
                    </select>
                    <input type="submit" name="reassignStatus" value="Reassign student status">
                </form>

                <?php

                    if(isset($_POST["change_name"])){
                        include("students/RenameStudent.php");
                    }

                    if(isset($_POST["reassignStatus"])){
                        include("students/ReassignStatus.php");
                    }
                
                ?>
            <!-- alumni -->
                <form action="Edit_Data.php" method="POST">
                    <h1 class="contentheader">Alumni Talk Profile</h1>
                    <label for="Seminar_ID">ATalk ID : </label>
                    <input type="text" name="Seminar_ID" required><br>

                    <label for="New_Event_Name">new event name : </label>
                    <input type="text" name="New_Event_Name">
                    <input type="submit" value="change name" name="change_event_name"><br>

                    <label for="New_Speaker_Name">new host name : </label>
                    <input type="text" name="New_Speaker_Name">
                    <input type="submit" value="change name" name="change_host"><br>

                    <label for="New_Date">Enter new date:</label>
                    <input type="date" name="New_Date"><br>
                    <label for="New_Start_Time">Enter new start time:</label>
                    <input type="time" name="New_Start_Time"><br>
                    <label for="New_End_Time">Enter new end time:</label>
                    <input type="time" name="New_End_Time">
                    <input type="submit" name="reschedule" value="Reschedule Event">
                </form>

                <?php

                    if(isset($_POST["change_event_name"])){
                        include("AlumniTalkProfile/RenameEvent.php");
                    }

                    if(isset($_POST["change_host"])){
                        include("students/RenameSpeaker.php");
                    }

                    if(isset($_POST["reschedule"])){
                        include("AlumniTalkProfile/RescheduleEvent.php");
                    }
                
                ?>

            <!-- Update as a batch -->
            <form action="Edit_Data.php" method="POST" enctype="multipart/form-data">
                <h1 class="contentheader">Batch update (Students)</h1>
                <label for="file">Select File : </label>
                <input type="file" name="file_csv" accept=".csv" required>
                <br><label for="column">Select Column : </label>
                <select name="column">
                    <option value="Name_Surname">name</option>
                    <option value="Student_Status">status</option>
                </select><br>
                <input type="submit" name="batch_update" value="update">
            </form>
            
            <?php
                if(isset($_POST['batch_update'])){
                    include("students/BatchProcessing.php");
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
    



