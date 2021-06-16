<!DOCTYPE html>
<html>

<head>
     <title>Laravel Ajax Validation Example</title>
     <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
</head>

<body>


     <div class="container">
          <h2>Bulk Sms </h2>


          <div class="alert alert-danger print-error-msg" style="display:none">
               <ul></ul>
          </div>


          <form class="form">
               {{ csrf_field() }}
               <div class="form-group">
                    <label>Select Screen:</label>

                    <select class="form-control select-screen" id="inputGroupSelect01">
                         <option selected>Choose...</option>
                         <option value="all">All Employees</option>
                         <option value="one">One</option>
                    </select>
               </div>
               <div class="form-group">
                    <label>Select Users:</label>

                    <select class="form-control select-users " multiple>
                         @foreach($users as $user)
                         <option value='{{ $user->email }}'>{{ $user->name }}</option>
                         @endforeach
                    </select>
               </div>

               <div class="form-group">
                    <strong>Title:</strong>
                    <input type="text" name="title" class="form-control" placeholder="Email">
               </div>


               <div class="form-group">
                    <strong>message:</strong>
                    <textarea class="form-control" name="message" placeholder="message"></textarea>
               </div>
               <div class="form-group">
                    <strong>ImageName:</strong>
                    <input type="file" name="image_name" class="form-control" placeholder="Email">
               </div>


               <div class="form-group">
                    <button class="btn btn-success btn-submit">Submit</button>
               </div>
          </form>
     </div>


     <script type="text/javascript">
     $(document).ready(function() {

          var selectedScreen = null;

          $(".select-screen").on("change", function() {

               selectedScreen = $(this).val();
               if (selectedScreen === 'all') {
                    $('.select-users option').attr('selected', 'selected');
               } else if (selectedScreen === 'one') {
                    $('.select-users option').prop("selected", false);
                    $('.select-users option').prop('selected', true);
               }
               console.log($('.select-users option'));
          });
          $(".select-users").on("change", function() {
               console.log(selectedScreen);

               let selectedOption = $(this).val();
               if (selectedScreen === 'one') {
                    // $('.select-users option').prop("selected", false);
                    console.log(selectedOption);
                    $(this).find(`option[value="${selectedOption}"]`).prop("selected", true);
               }
               console.log($('.select-users option'));
          });

          $(".form").on('submit', function(e) {
               e.preventDefault();

               var token = $("input[name='_token']").val();
               let users = [];
               let usersOptions = $('.select-users option');
               usersOptions.each(function() {
                    if ($(this).is(':selected')) {
                         users.push($(this).val());
                    }
               });
               //    console.log(users);

               let formData = new FormData(this);
               users.forEach((item) => {
                    console.log(item);
                    formData.append('users[]', item);
               });
               $.ajax({
                    headers: {
                         'X-CSRF-TOKEN': token
                    },
                    url: `/api/bulk_sms`,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                         if ($.isEmptyObject(data.error)) {
                              alert(data.success);
                         } else {
                              printErrorMsg(data.error);
                         }
                    }
               });


          });


          function printErrorMsg(msg) {
               $(".print-error-msg").find("ul").html('');
               $(".print-error-msg").css('display', 'block');
               $.each(msg, function(key, value) {
                    $(".print-error-msg").find("ul").append('<li>' + value + '</li>');
               });
          }
     });
     </script>


</body>




</html>