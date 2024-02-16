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
      console.log("request",request)
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
             
              if (response.length > 0) {
                  const columns = JSON.parse(response);
                  console.log("response", columns);
                  for (const column in columns) {
                      const data = columns[column];
                      
                      const options = data['html']!==false ? data['html']: "";
                      
                      jQuery(`select#${column}`).html(options);
                      if (data['selected'].length > 0) {
                        const selected = data['selected'];
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