<?php

    require_once('fpdf/fpdf.php');
    require_once __DIR__.('/../../database.php');

    
//CERTIFICATE DATA

        // $Name_Surname
        // $Student_ID
    
    //CERTIFICATE ID
        // gets the amount of row currently in `certificate`
        $sql = "SELECT COUNT(*) AS 'rows' FROM `certificate`";
        $query = mysqli_query($conn,$sql);
        $report = mysqli_fetch_assoc($query);
        $rows = (int) $report['rows'];
        $time = time();
        $date = gmdate("Y-m-d",$time);
        $Certificate_ID = substr($date,2,2).'/'.substr($date,5,2).' '.str_pad($rows+1,5,'0',STR_PAD_LEFT);        //  yy/mm_xxxxx  (Also Acts as a file name)
    //FILENAME ( '/' in certificate ID)
        $fileName = substr($date,2,2).'-'.substr($date,5,2).'_'.str_pad($rows+1,5,'0',STR_PAD_LEFT);

        
//GENERATE CERTIFICATE

    //DIRECTORIES
        $font = __DIR__.("/Times New Roman Bold.ttf");
        $image_directory = __DIR__ . ('/Template_1.jpg');
        $upload_Directory = __DIR__ . "/upload_certificate";


    //GENERATE

        $font_size_name = 70;
        $font_size_id = 22;

        $im = imagecreatefromjpeg($image_directory);      // enable GD Library, then restart the server.
        $text_color = imagecolorallocate($im, 00, 00, 00);                                  //text color
    
        $image_width = imagesx($im);                                                        //get image width
        $text_box = imagettfbbox($font_size_name,0,$font,$Name_Surname);                    //get bounding box size
        $text_width = $text_box[2]-$text_box[0];                                            //get text width
        $x = ($image_width/2) - ($text_width/2);                                            //calculate coordinates of the text
    
        imagefttext($im,$font_size_name,0,$x,840,$text_color,$font, $Name_Surname);         //Add name    
        imagefttext($im,$font_size_id,0,60,230,$text_color,$font, "Ref.".$Certificate_ID);   //Add certificate ID
        //imagejpeg($im);                                                                   //Output the image generated
        $image = "$upload_Directory/$fileName.jpg";                                         //upload directory
        imagejpeg($im,$image);                                                              //create and upload the jpeg
        imagedestroy($im);                                                                  // destroy gd image
    

    //GENERATE PDF  

        $pdf = new fpdf();
        $pdf->AddPage("L","A5");
        $pdf->Image($image,0,0,210,148);
        //$pdf->Output();
        $pdf->Output('F', "$upload_Directory/$fileName.pdf",);      // send to a folder
        //ob_end_flush();

    //INPUT DATA ONTO `certificate` TABLE
        
        $sql = "INSERT INTO `certificate` (`CERTIFICATE_ID`, `Student_ID`, `ISSUE_DATE`) 
                VALUES ('$Certificate_ID', '$Student_ID', '$date')";
        mysqli_query($conn,$sql);

    //Display Certificate

        $filepath = "$upload_Directory/$fileName.pdf";
        include(__DIR__."/../DisplayCertificate.php");
    

        

?>