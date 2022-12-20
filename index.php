<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="row" style="margin-top: 100px;">
            <div class="col-md-6">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" style="border: 1px solid rgb(150, 150, 150); padding: 40px; border-radius: 16px;">
                    <div class="form-group">
                      <label for="slug">Slug Name</label>
                      <input type="hidden" name="id" id="id" value="">
                      <input type="text" class="form-control" id="slug" name="slug" required>
                    </div>
                    <div class="form-group">
                      <label for="metaTitle">Meta-Title</label>
                      <input type="text" class="form-control" id="metaTitle" name="metaTitle" required>
                    </div>
                    <div class="form-group">
                      <label for="metaKeyword">Meta-Keyword</label>
                      <input type="text" class="form-control" id="metaKeyword" name="metaKeyword" required>
                    </div>
                    <div class="form-group">
                    <label for="description">Description</label>
                      <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                      <input type="hidden" id="formtype" name="formtype" value="insert"/>
                    </div>
                    <input type="submit" class="btn btn-primary" name="submit" value="Submit" id="submit" />
                    <button type="button" id="cancel" name="cancel" class="btn btn-danger" style="display: none;">Cancel</button>
                  </form>
            </div>
            
        <div class="col-md-6">
            <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Meta-title</th>
                    <th scope="col">Meta-keyword</th>
                    <th scope="col">Description</th>
                    <th scope="col">View</th>
                    <th scope="col">Delete</th>
                  </tr>
                </thead>
                <tbody id="rowData">
                </tbody>
              </table>
        </div>
    </div>
</div>
</body>
<script>
  $( document ).ready(function() {
    viewAllData();
  });

  function viewAllData(){
    $.ajax({
     url:"getData.php",
     method:"GET",
     success:function(data)
     {
      // console.log(data);
      data = JSON.parse(data)
      if(data['success'] == true){
        $('#rowData').empty();
        for (let i = 0; i < data['resultCount']; i++) {
          $('#rowData').append("<tr><th scope='row'>"+data['data'][i]['id']+"</th><td>"+data['data'][i]['slug']+"</td><td>"+data['data'][i]['meta_title']+"</td><td>"+data['data'][i]['meta_keyword']+"</td><td>"+data['data'][i]['description']+"</td><td><button type='button' id='view' name='view"+i+"' class='btn btn-primary' onclick='viewData("+data['data'][i]['id']+")'>View</button></td><td><button type='button' id='delete' name='delete"+i+"' class='btn btn-danger' onclick='deleteData("+data['data'][i]['id']+")'>Danger</button></td></tr>");
        }
      }
      else{
        console.log("No data found.");
        $('#rowData').empty();
        $('#rowData').append("<tr><td colspan='7' style='text-align: center;'>No data availabe.</td></tr>");
      }
     }
    })
  }
  
  $('form').submit(function(event){
    // console.log($('#formtype').val());
   event.preventDefault();
    // $('#submit').attr('disabled', 'disabled');
    $.ajax({
     url:"insert.php",
     method:"POST",
     data:$(this).serialize(),
     success:function(data)
     {
      data = JSON.parse(data)
        console.log(data['message']);
        viewAllData();
     }
    })
  });

  $('#cancel').click(function(event){
    $('#slug').val('');
    $('#metaTitle').val('');
    $('#metaKeyword').val('');
    $('#description').val('');
    $('#id').val('');
    $('#formtype').val('insert');
    $('#cancel').hide();
  });

  function viewData(id){
    // console.log(id);
    event.preventDefault();
    $.ajax({
     url:"getData.php",
     method:"GET",
     data: {
      id: id
     },
     success:function(data)
     {
      data = JSON.parse(data)
      if(data['success'] == true){
          $('#slug').val(data['data'][0]['slug']);
          $('#metaTitle').val(data['data'][0]['meta_title']);
          $('#metaKeyword').val(data['data'][0]['meta_keyword']);
          $('#description').val(data['data'][0]['description']);
          $('#id').val(data['data'][0]['id']);
          $('#formtype').val('update');
          $('#cancel').show();
      }
      else{
        console.log("No data for selected id found.");
      }
     }
    })
  }

  function deleteData(id){
    // console.log(id);
    event.preventDefault();
    $.ajax({
     url:"deleteById.php",
     method:"GET",
     data: {
      id: id
     },
     success:function(data)
     {
      data = JSON.parse(data);
      console.log(data['message']);
      viewAllData();
     }
    })
  }
</script>
</html>