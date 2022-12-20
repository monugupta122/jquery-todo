<?php
    // $response = checktoken();
    // $response = getSlug();

    function getSlug(){
        $conn = connect();
        $token = 'testtoken';
        $slug = 'melbourne';
        $query = "select token from auth_tokens  where token='".$token."'";
        $result = mysqli_query($conn,$query);

        $data = array();
        if (mysqli_num_rows($result) > 0) {
            $data['auth'] = 'Success';
            $query = "SELECT * FROM seo_details WHERE slug='".$slug."'";

            $seoDetails = mysqli_query($conn,$query);
            // echo mysqli_num_rows($result);exit;
            // $data['resultCount'] = mysqli_num_rows($seoDetails);
            if (mysqli_num_rows($seoDetails) > 0) {
                $i = 0;
                while($row = mysqli_fetch_assoc($seoDetails)) {
                    $data['data']['slug']=$row['slug'];
                    $data['data']['meta_title']=$row['meta_title'];
                    $data['data']['meta_keyword']=$row['meta_keyword'];
                    $data['data']['description']=$row['description'];
                    $i++;
                }
                $data['statusCode'] = 200;
                return json_encode($data);
                exit;
            }
            else{
                $data['statusCode'] = 201;
                $data['msg'] = 'No details available';
                return json_encode($data);
                exit;
            }
        } else {
            $data['statusCode'] = 201;
            $data['token'] = $token;
            $data['msg'] = 'Invalid token id';
            return json_encode($data);
            exit;
        }
    }


    function getAllJobs(){
        $conn = connect();
        $token = 'testtoken';
        $query = "select token from auth_tokens  where token='".$token."'";
        $result = mysqli_query($conn,$query);

        $data = array();
        if (mysqli_num_rows($result) > 0) {
            $data['auth'] = 'Success';
            $jobs = "SELECT jobs.id as jobId, jobs.title as jobTitile, jobs.slug as role, companies.name as campanyName, categories.id as categoryId, categories.name as categoryName, locations.name as location, jobs.created_at as datePosted, jobs.salary_min as salary, jobs.salary_max as maxSalary, jobs.salary_type as base
            FROM bc_jobs as jobs
            INNER JOIN bc_companies as companies
            ON jobs.company_id = companies.id
            INNER JOIN bc_categories as categories
            ON jobs.category_id = categories.id
            INNER JOIN bc_locations as locations
            ON jobs.location_id = locations.id;";

            $jobResult = mysqli_query($conn,$jobs);
            // return mysqli_num_rows($result);exit;
            $data['totalJobCount'] = mysqli_num_rows($jobResult);
            if (mysqli_num_rows($jobResult) > 0) {
                $i = 0;
                while($row = mysqli_fetch_assoc($jobResult)) {
                    $data['jobs'][$i]['job_Id']=$row['jobId'];
                    $data['jobs'][$i]['job_Title']=$row['jobTitile'];
                    $data['jobs'][$i]['role']=$row['role'];
                    $data['jobs'][$i]['company']=$row['campanyName'];
                    $data['jobs'][$i]['category_Id']=$row['categoryId'];
                    $data['jobs'][$i]['category_Name']=$row['categoryName'];
                    $data['jobs'][$i]['sub_Category']=null;
                    $data['jobs'][$i]['location']=$row['location'];
                    $data['jobs'][$i]['posted_Date']=$row['datePosted'];
                    $data['jobs'][$i]['salary']=$row['salary'];
                    $data['jobs'][$i]['max_Salary']=$row['maxSalary'];
                    $data['jobs'][$i]['base']=$row['base'];
                    $i++;
                }
                $data['statusCode'] = 200;
                return json_encode($data);
                exit;
            }
        } else {
            $data['statusCode'] = 201;
            $data['token'] = $token;
            $data['msg'] = 'Invalid token id';
            return json_encode($data);
            exit;
        }
    }


    function connect(){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = 'applycart';
        
        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        // Check connection
        if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
        }
        // echo "Connection sucess";
        return $conn;
    }
?>