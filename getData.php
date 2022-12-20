<?php
    require 'connection.php';
    //add_task.php
    // print_r($_POST);
    $data = array();
    $whereclause = " 1";
    if(isset($_REQUEST['id'])){
        $whereclause = " id = ".$_REQUEST['id'];
    }
    $query = "SELECT * from seo_details WHERE".$whereclause;
    $result = mysqli_query($conn,$query);
    if(mysqli_num_rows($result) > 0){
        $data['success'] = True;
        $data['resultCount'] = mysqli_num_rows($result);
        $i = 0;
        while($row = mysqli_fetch_assoc($result)) {
            $data['data'][$i]['id']=$row['id'];
            $data['data'][$i]['slug']=$row['slug'];
            $data['data'][$i]['meta_title']=$row['meta_title'];
            $data['data'][$i]['meta_keyword']=$row['meta_keyword'];
            $data['data'][$i]['description']=$row['description'];
            $i++;
        }
        echo json_encode($data);
    }
    else{
        $data['success'] = False;
        echo json_encode($data);
    }
?>