<?php
 require 'connection.php';
//add_task.php
// print_r($_POST);
    if($_POST['formtype'] == 'insert'){
        $query = "INSERT into seo_details(slug, meta_title, meta_keyword, description) VALUES('".$_POST['slug']."','".$_POST['metaTitle']."','".$_POST['metaKeyword']."','".$_POST['description']."')";
        $result = mysqli_query($conn,$query);
        if($result){
            $data['success'] = True;
            $data['message'] = "Inserted";
            echo json_encode($data);
        }
        else{
            $data['success'] = False;
            $data['message'] = "Failed to insert";
            echo json_encode($data);
        }
    }

    if($_POST['formtype'] == 'update'){
        $query = "UPDATE seo_details SET slug = '".$_POST['slug']."', meta_title = '".$_POST['metaTitle']."', meta_keyword = '".$_POST['metaKeyword']."', description = '".$_POST['description']."' where id = '".$_POST['id']."'";
        $result = mysqli_query($conn,$query);
        if($result){
            $data['success'] = True;
            $data['message'] = "Updated";
            echo json_encode($data);
        }
        else{
            $data['success'] = False;
            $data['message'] = "Failed to update";
            echo json_encode($data);
        }
    }
?>