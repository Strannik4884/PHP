// when document ready
$(document).ready(function () {
  // create textarea character counter
  $('input#input_text, textarea#address').characterCounter();

  // form validation
  $("#address_form").validate({
    rules: {
      address: {
        required: true,
        maxlength: 512
      },
    },
    // error messages
    messages: {
      address:{
        required: "Введите адрес",
      }
    },
    // display errors
    errorElement : 'div',
    errorPlacement: function(error, element) {
      const placement = $(element).data('error');
      if (placement) {
        $(placement).append(error)
      } else {
        error.insertAfter(element);
      }
    }
  });

  // address form submit event handler
  $('#address_form').submit(function (event) {
    // get form
    let addressForm = $('#address_form');
    // handle default action
    event.preventDefault();
    addressForm.validate();
    // if address form is valid
    if(addressForm.valid()){
      // use ajax to send form
      $.ajax({
        type: "POST",
        url: "geocoder.php",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function (result) {
          // parse response
          const response = JSON.parse(result);
          // if successful
          if(typeof(response['successful']) != "undefined" && response['successful'] !== null) {
            // clear address form
            document.getElementById("address_form").reset();
            // hide textarea character counter
            $('.character-counter').remove();
            $('input#input_text, textarea#address').characterCounter();
            // clear response objects list
            document.getElementById("geoobjects_list").innerHTML = "";
            // show response objects in list
            for (let item in response['successful']) {
              document.getElementById("geoobjects_list").innerHTML += "" +
                  "<li id=\"geoobjects_list\" class=\"collection-item\">\n" +
                  "                <div class=\"row\">\n" +
                  "                    <div class=\"col s12\">\n" +
                  "                        Структурированный адрес: " + response['successful'][item]['structuredAddress'] +
                  "                    </div>\n" +
                  "                </div>\n" +
                  "                <div class=\"row\">\n" +
                  "                    <div class=\"col s12\">\n" +
                  "                        Координаты: " + response['successful'][item]['coordinates'] +
                  "                    </div>\n" +
                  "                </div>\n" +
                  "                <div class=\"row\">\n" +
                  "                    <div class=\"col s12\">\n" +
                  "                        Ближайшее метро: " + response['successful'][item]['metroName'] +
                  "                    </div>\n" +
                  "                </div>\n" +
                  "                <div class=\"row\">\n" +
                  "                    <div class=\"col s12\">\n" +
                  "                        Координаты ближайшего метро: " + response['successful'][item]['metroCoordinates'] +
                  "                    </div>\n" +
                  "                </div>\n" +
                  "            </li>"
            }
            document.getElementById("geoobjects_list").style.display = "";
          }
          // if error
          else if(typeof(response['error']) != "undefined" && response['error'] !== null){
            alert(response['error']);
          }
        },
        error: function () {
          alert('Ошибка при отправке запроса - попробуйте позже!');
        }
      });
    }
  });
});