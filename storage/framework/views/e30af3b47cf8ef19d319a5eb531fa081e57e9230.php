<!DOCTYPE html>
<html>
<head>
    <title>AJAX</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 offset-2">
                <table class="table table-hover">
                    <thead>
                        <tr class="table-primary">
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Roll#</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody class="dataShow">
                    </tbody>
                </table> 
            </div>
        </div>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#CreateModal">
      Register New Student
    </button>
    </div>

    <!-- create Modal -->
    <div class="modal fade" id="CreateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/create" method="post" id="CreateForm" enctype="multipart/form-data">
                   <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="createName" class="form-control" name="name" placeholder="Enter Your Name">
                        </div>
                        <div class="form-group">
                            <label for="rollNumber">Roll Number</label>
                            <input type="text" id="createRollno" class="form-control" name="roll_no" placeholder="Enter Your Roll Number">
                        </div>
                        <div class="form-group">
                            <label for="image" class="d-block">Upload your image</label>
                            <input type="file" id="createImg" name="image">
                        </div>
                   </div>
                   <div class="modal-footer">
                       <button type="submit" id="CreateSubmit" class="btn btn-primary" data-dismiss="modal">Submit</button>
                   </div> 
                </form>
            </div>
        </div>
    </div>

    <!-- update Modal -->
    <div class="modal fade" id="UpdateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Student Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/update" method="post" id="UpdateForm" enctype="multipart/form-data">
                    <input type="hidden" id="user_id">
                    <?php echo e(method_field('PUT')); ?>

                   <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="updateName" class="form-control" name="name">
                        </div>
                        <div class="form-group">
                            <label for="rollNumber">Roll Number</label>
                            <input type="text" id="updateRollno" class="form-control" name="roll_no">
                        </div>
                        <div class="form-group">
                            <label for="image" class="d-block">Upload your image</label>
                            <input type="file" id="updateImg" name="image">
                        </div>
                   </div>
                   <div class="modal-footer">
                       <button type="submit" id="UpdateSubmit" class="btn btn-primary" data-dismiss="modal">Submit</button>
                   </div> 
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
    crossorigin="anonymous"></script><!--jquerycdn -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script><!--poopercdn -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script><!--bscdnjs -->
    <script type="text/javascript">
        //show
        function displaydata(){
            $('.dataShow').empty();
            $.ajax({
                url: '/show',
                type: 'GET',
                dataType: 'JSON',
                success: function(response){
                    $.each(response, function(index, val) {
                        var count = index+1;
                        var data = 
                        '<tr>'+
                            '<td>'+count+'</td>'+
                            '<td><a href="/profile/'+val.id+'">'+val.name+'</a></td>'+
                            '<td>'+val.roll_no+'</td>'+
                            '<td>'+
                                '<button class="btn btn-info mr-1" onclick="findForUpdate('+val.id+')" data-toggle="modal" data-target="#UpdateModal">Update</button>'+
                                '<button class="btn btn-danger" onclick="deleteData('+val.id+')">Delete</button>'+
                            '</td>'+    
                        '</tr>';
                        $('.dataShow').append(data);
                    });
                }
            })
        }
        // create
        $('#CreateSubmit').click(function(event) {
            event.preventDefault();
            var form = $('#CreateForm')[0];
            var form_data = new FormData(form);
            var url = $('#CreateForm').attr('action');
            var type = $('#CreateForm').attr('method');
            var enctype = $('#CreateForm').attr('enctype');
            $.ajax({
                url: url,
                type: type,
                dataType: 'JSON',
                enctype: enctype,
                processData: false,
                contentType: false,
                cache: false,
                data: form_data,
                success: function(response){
                    console.log(response);
                    $('#createName').val('');
                    $('#createRollno').val('');
                    $('#createImg').val('');
                    displaydata();
                },
                error: function(response){
                    console.log(response);
                }
            })
        });

         //delete
        function deleteData(id){
            $.ajax({
                url: '/delete/'+id,
                type: 'POST',
                data: {_method: 'delete'},
                success: function(response){
                    displaydata();
                },
                error: function(response){
                    console.log(response);
                }
            })
        }
        function findForUpdate(id){
            $.ajax({
                url: '/find-student/'+id,
                type: 'POST',
                success: function(response){
                    $('#updateName').val(response.name);
                    $('#updateRollno').val(response.roll_no);
                    $('#user_id').val(response.id);
                }
            })
        }
        $('#UpdateSubmit').click(function(event) {
            event.preventDefault();
            var form = $('#UpdateForm')[0];
            var form_data = new FormData(form);
            var url = $('#UpdateForm').attr('action');
            var type = $('#UpdateForm').attr('method');
            var enctype = $('#UpdateForm').attr('enctype');
            var id = $('#user_id').val();
            $.ajax({
                url: url+'/'+id,
                type: type,
                dataType: 'JSON',
                enctype: enctype,
                processData: false,
                contentType: false,
                cache: false,
                data: form_data,
                success: function(response){
                    console.log(response);
                    displaydata();
                },
                error: function(response){
                    console.log(response);
                }
            })
            
        });
        $(document).ready(function() {
            displaydata();
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            })
        });
    </script>
</body>
</html>