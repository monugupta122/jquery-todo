<?php
    require 'connection.php';
    //add_task.php
    // print_r($_GET);
    $data = array();
    $query = "DELETE from seo_details WHERE id =".$_GET['id'];
    $result = mysqli_query($conn,$query);
    if($result){
        $data['success'] = True;
        $data['message'] = "Deleted";
        echo json_encode($data);
    }
    else{
        $data['success'] = False;
        $data['message'] = "Failed to delete";
        echo json_encode($data);
    }
?>