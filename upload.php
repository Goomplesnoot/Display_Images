<?php

        header("Access-Control-Allow-Origin:  *");
        header("Access-Control-Allow-Headers:  *");

    $conn=mysqli_connect('localhost', 'root', '', 'cruddatabase');

    if(isset($_POST['name'])){
        $files=$_FILES['pictures'];
        $name=mysqli_real_escape_string($conn,$_POST['name']);

        //file properties
    $filename=$files['name'];
    $templocation=$files['tmp_name'];
    $uploaderrors=$files['error'];

    $splitedname=explode('.',$filename);
    $fileextensions=strtolower(end($splitedname));

    $allowed_extentions=['png', 'jpeg', 'jpg'];

if(in_array($fileextensions,$allowed_extentions)){
    if($uploaderrors===0){
        $new_file_name=uniqid().'.'.$fileextensions;
        $file_destination='src/images/'.$new_file_name;
     if(move_uploaded_file($templocation,$file_destination)){
        $connection="INSERT INTO upload_images_in_react(name,picture)VALUES('$name', '$new_file_name')";
        if(mysqli_query($conn,$connection)){
            echo 'success';
        }else{
            echo 'could not insert data into the database';
        }
    }else{
        echo 'could not upload image';
    }
   }else{
       echo 'there was an error in the upload';
   }
}else{
    echo 'files with this extension is not allowed';
}
    }

if(isset($_POST['fetch'])){
    $query='SELECT * FROM upload_images_in_react';
    $resuslt=mysqli_query($conn,$query);
    $upload_images_in_react=mysqli_fetch_all($resuslt,MYSQLI_ASSOC)

    echo json_encode($upload_images_in_react)
}