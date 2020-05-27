// open/close mobile hamburger menu
(function($){
  $(function(){
    $('.sidenav').sidenav();
  });
})(jQuery);

// when document ready
$(document).ready(function () {
  // create textarea character counter
  $('input#input_text, textarea#person_comment').characterCounter();

  // add regexp method to form validation rules
  $.validator.addMethod(
      "regexp",
      function(value, element, regexp) {
        const re = new RegExp(regexp);
        return this.optional(element) || re.test(value);
      },
      "Regular expression failed"
  );

  // form validation
  $("#feedback_form").validate({
    rules: {
      person_name: {
        required: true,
      },
      person_email: {
        required: true,
        email: true
      },
      person_phone: {
        required: true,
        regexp: '^\\+7\\(\\d{3}\\)\\d{3}-\\d{2}-\\d{2}$'
      },
      person_comment: {
        required: true,
        minlength: 10,
        maxlength: 280
      },
    },
    // error messages
    messages: {
      person_name:{
        required: "Введите ФИО",
      },
      person_email:{
        required: "Введите почту",
        email: "Введите корректную почту"
      },
      person_phone:{
        required: "Введите номер телефона",
        regexp: "Введите номер телефона в международном формате (+7(000)000-00-00)"
      },
      person_comment:{
        required: "Введите комментарий",
        minlength: "Комментарий должен быть не менее 10 символов"
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

  // feedback form submit event handler
  $('#feedback_form').submit(function (event) {
    // get form
    let feedbackForm = $('#feedback_form');
    // handle default action
    event.preventDefault();
    feedbackForm.validate();
    // if feedback form is valid
    if(feedbackForm.valid()){
      $.ajax({
        type: "POST",
        url: "feedback.php",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function (result) {
          // parse response
          const response = JSON.parse(result);
          // if successful
          if(typeof(response['successful']) != "undefined" && response['successful'] !== null){
            // clear and hide feedback form
            document.getElementById("feedback_form").reset();
            $('.character-counter').remove();
            document.getElementById("feedback_form").style.display = "none";
            // show request answer date
            const text = document.createTextNode("С Вами свяжутся после " + response['successful'][4]);
            document.getElementById("response_date").appendChild(text);
            // set request data
            document.getElementById("request_name").value = response['successful'][0];
            document.getElementById("request_email").value = response['successful'][1];
            document.getElementById("request_phone").value = response['successful'][2];
            document.getElementById("request_comment").value = response['successful'][3];
            // show feedback response form
            document.getElementById("feedback_response").style.display = "";
          }
          // if warning
          else if(typeof(response['warning']) != "undefined" && response['warning'] !== null){
            // hide feedback form
            document.getElementById("feedback_form").style.display = "none";
            // set new request date
            const countDownDate = new Date(response['warning']).getTime();
            // update the countdown every 1 second
            let requestCountDown = setInterval(function () {
              // get current date
              let now = new Date().getTime();
              // find the distance between now and the countdown date
              let distance = countDownDate - now;
              // get hours, minutes and seconds
              let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)).toString();
              let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)).toString();
              let seconds = Math.floor((distance % (1000 * 60)) / 1000).toString();
              if (hours.length === 1) {
                hours = '0' + hours;
              }
              if (minutes.length === 1) {
                minutes = '0' + minutes;
              }
              if (seconds.length === 1) {
                seconds = '0' + seconds;
              }
              // update ui element
              document.getElementById("new_request_date").innerHTML = hours + ":" + minutes + ":" + seconds;
              // if the countdown is finished, show feedback form
              if (distance < 0) {
                clearInterval(requestCountDown);
                closeWarningForm();
              }
            }, 1000);
            // show feedback warning form
            document.getElementById("warning_form").style.display = "";
          }
          // if error
          else if(typeof(response['error']) != "undefined" && response['error'] !== null){
            alert(response['error']);
          }
        },
        error: function () {
          alert('Ошибка при отправке формы - попробуйте позже!');
        }
      });
    }
  });

  // response form submit event handler
  $('#feedback_response').submit(function (event) {
    // handle default action
    event.preventDefault();
    // clear and hide response form
    document.getElementById("feedback_response").reset();
    document.getElementById("response_date").innerHTML = "";
    document.getElementById("feedback_response").style.display = "none";
    // show feedback form
    $('input#input_text, textarea#person_comment').characterCounter();
    document.getElementById("feedback_form").style.display = "";
  });

  // close warning and show feedback form
  function closeWarningForm(){
    // clear and hide response form
    document.getElementById("warning_form").reset();
    document.getElementById("new_request_date").innerHTML = "";
    document.getElementById("warning_form").style.display = "none";
    // show feedback form
    document.getElementById("feedback_form").style.display = "";
  }

  // feedback warning form submit event handler
  $('#warning_form').submit(function (event) {
    // handle default action
    event.preventDefault();
    closeWarningForm();
  });
});