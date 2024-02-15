<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
        integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">


    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">
    </script>
    <!-- select2 dropdown -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!--    custom css file -->
    <link rel="stylesheet" href="./assets/custom.css">
    <title>Filter Form</title>
</head>
<?php 
  include_once("config.php");
  include_once("function.php");
?>

<body>
    <div class="container-fluid">
        <form action="" class="program-form">
            <?php
              $rows = array_chunk($fields,4, true);
              foreach($rows as $row):
                  include("_row.php");
              endforeach;
            ?>
            <div class="row hide">
                <!-- date  select-->
                <div class="col-md-3 hide">
                    <div class="form-group">
                        <label class="control-label">Date Created (From/To)</label>
                        <div class="input-group input-daterange">
                            <input type="date" class="form-control" id="DateCreatedSearchFromControl"
                                name="DateCreatedSearchFrom" value="">
                            <input type="date" class="form-control" s="" id="DateCreatedSearchToControl"
                                name="DateCreatedSearchTo" value="">
                        </div>
                    </div>
                </div>
                <!-- columns to show select-->
                <div class="col-md-6 hide">
                    <div class="form-group">
                        <label class="control-label">Solumns to Show</label>
                        <select class="program form-control" name="programs[]" multiple="multiple">
                            <option value="AL">Alabama</option>
                            <option value="WY">Wyoming</option>
                        </select>
                    </div>
                </div>
            </div>


            <div class="row hide">
                <div class="col-md-3">
                    <input type="button" value="Search" class="btn btn-primary" asp-route-isprint="false"
                        onclick="search()">
                    <input type="button" value="Reset" class="btn btn-dark" onclick="ResetSearchControls()">
                </div>

                <div class="col-md-6">
                    <div class="sutdant-name">
                        <label class="control-label">Student Name</label> &nbsp;&nbsp;<input type="text"
                            class="form-control" style="width:50%" id="StudentName" name="StudentName" value="">
                    </div>
                </div>
                <div class="col-md-3 ">
                    <div id="edit-check" class="form-check form-switch edit-check">
                        <label class="form-check-label" for="flexSwitchCheckDefault">Edit</label>
                        <input class="form-check-input" class="mt-0" type="checkbox" role="switch"
                            id="flexSwitchCheckDefault">
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
<script>
  function renderSelect2() {
      $('.select2').select2({
          placeholder: "Select",
          allowClear: true,
          multiple: true,
      });
  }
  $(document).ready(function() {
      renderSelect2();
      $(".select2").on('change', function() { // 2nd way
          const request = {'data': {}, 'column': jQuery(this).data('column')}
          jQuery('.select2').each(function() {
              if (jQuery(this).val().length > 0) {
                request['data'][jQuery(this).data('column')] = jQuery(this).val();
              }
          })
          ajax_call(request);
          console.log(request);
      });
  });
  function ajax_call(request){
    $.ajax({
        type: 'POST',
        url: 'ajax.php',
        data: {
          request
        },
        success: function(response) {
          const columns = JSON.parse(response);
          for(const column in columns) {
            const options = columns[column]['html'];
            const selected = columns[column]['selected'];
            jQuery(`select#${column}`).html(options);
            
            jQuery(`select#${column}`).select2('destroy');
            jQuery(`select#${column}`).select2();
          }
        },
        error: function(xhr, status, error) {
          console.log(xhr.responseText);
        }
      });
  }
</script>

</html>