$(document).ready(function() {
  $('.select2').select2({
      placeholder: "Select",
  });

  $(".select2").on('change', function() {
      let request = {
          'data': {},
          'column': {},
          'all_option': {}
      };

      if (jQuery(this).val().length > 0) {
          request['column'] = jQuery(this).data('column');
      }

      jQuery('.select2').each(function() {
          if (jQuery(this).val().length > 0) {
              request['data'][jQuery(this).data('column')] = jQuery(this).val();
          }
      });

      if (Object.keys(request['data']).length === 0) {
          request['all_option'] = "true"
      } 
      
      ajax_call(request);
  });

  function ajax_call(request) {
      $.ajax({
          type: 'POST',
          url: 'ajax.php',
          data: {
              request
          },
          success: function(response) {
              // console.log("response", response);
              if (response.trim() !== "") {
                  const columns = JSON.parse(response);

                  for (const column in columns) {
                      const data = columns[column];
                      const options = data['html'];
                      const selected = data['selected'];
                      // console.log(`select#${column}`, selected);

                      jQuery(`select#${column}`).html(options);

                      if (data['selected'] !== "") {
                          jQuery(`select#${column}`).val(selected);
                      }

                      jQuery(`select#${column}`).select2('destroy');
                      jQuery(`select#${column}`).select2();
                  }
              } else {
                  console.log("Empty or null response received");
              }
          },
          error: function(xhr, status, error) {
              // console.log(xhr.responseText);
          }
      });
  }
  
});