<?php

    //this might not be the convension but whatever, your convensions are stupid
    if(isset($_POST["Upload"]))             {    header("Location: http://localhost/alumnitalk/Main_Page/Upload/Upload.php");  }
    if(isset($_POST["Edit_Data"]))          {    header("Location: http://localhost/alumnitalk/Main_Page/Edit_Data/Edit_Data.php");    }
    if(isset($_POST["Search_Data"]))        {    header("Location: http://localhost/alumnitalk/Main_Page/Search/Search.php");    }
    if(isset($_POST["Certificate"]))        {    header("Location: http://localhost/alumnitalk/Main_Page/Certificate/Certificate.php");    }
    if(isset($_POST["Change_Password"]))    {    header("Location: http://localhost/alumnitalk/Main_Page/PW_Change/Password_Change.php");  }
    if(isset($_POST["Log_Out"]))            {    header("Location: http://localhost/alumnitalk/index.php"); session_destroy(); }
    
    //check admin
    $sql = "SELECT `status` FROM user WHERE `name` = '$name'";
    $query = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($query);

    if($row['status'] == 'Admin'){
        if(isset($_POST["Users"]))      {   header("Location: http://localhost/alumnitalk/Main_Page/Users/Users.php"); }
        if(isset($_POST["System_Log"])) {   header("Location: http://localhost/alumnitalk/Main_Page/System_Log/System_Log.php");   }
    } else{
        echo "Only admin can access these options";
    }

?>