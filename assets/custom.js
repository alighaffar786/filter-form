$(document).ready(function() {
    $('#').click(function() {
      $.ajax({
        type: 'POST',
        url: 'your-php-script.php',
        data: {
          method: 'myMethod' // Pass the method name as data
        },
        success: function(response) {
          // Handle success response
          console.log(response);
        },
        error: function(xhr, status, error) {
          // Handle error response
          console.log(xhr.responseText);
        }
      });
    });
  });