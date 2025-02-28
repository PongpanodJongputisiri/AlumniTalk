<?php

    // fetch number of rows
    $sql = "SELECT * FROM students";
    $query = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($query);

    for($i = 0; $i < $count ; $i++){        
        // fetch data
        $sql = "SELECT * FROM students LIMIT 1 OFFSET $i";
        $table = mysqli_fetch_assoc(mysqli_query($conn,$sql));
        $Student_ID = $table['Student_ID'];
        $Sessions_Joined = $table['Sessions_Joined'];
        $Tier = $table['Tier'];
        $Name_Surname = $table['Name_Surname'];


        // Granting Certifications when 5 sessions are joined
        if (floor($Sessions_Joined / 5) > ($Tier)){

        //update student's tier
            $sql = "UPDATE students SET Tier = Tier + 1 WHERE Student_ID = (SELECT Student_ID FROM students ORDER BY Student_ID LIMIT 1 OFFSET $i);";
            mysqli_query($conn, $sql);
            
            if(($Sessions_Joined % 5) == 0){        
                //generate the certificate
                include ('../Certificate/certificate/generate.php');
                //sending the cerf
                //include('../Certificate/sendmail/SendingEmail.php');

                //$result = $result . "Mail successfully sent to " . $Student_ID . "<br>"; 
            }
        }

    }


        


?>