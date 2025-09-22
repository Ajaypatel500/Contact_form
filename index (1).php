<?php
// contact.php
// Simple contact form with server-side validation and success message

$error = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email   = trim($_POST['Email']    ?? '');
    $subject = trim($_POST['Subject']  ?? '');
    $message = trim($_POST['textarea'] ?? '');

    // validation
    if ($email === '') {
        $error .= "<li>Email is required</li>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error .= "<li>Email is not valid</li>";
    }

    if ($subject === '') {
        $error .= "<li>Subject is required</li>";
    }

    if ($message === '') {
        $error .= "<li>Message is required</li>";
    }

    if ($error !== '') {
        $error = '<div class="alert alert-danger" role="alert"><ul class="mb-0">' . $error . '</ul></div>';
    } else {
        // ✅ All fields are filled correctly
        $successMessage = '<div class="alert alert-success" role="alert">
                              ✅ Your mail was sent successfully!
                           </div>';
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact Form</title>

    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous">
  </head>
  <body>
    <div class="container mt-5">
      <h2>Get in touch!</h2>

      <!-- Messages -->
      <div id="messages">
        <?php
          if (!empty($error)) echo $error;
          if (!empty($successMessage)) echo $successMessage;
        ?>
      </div>

      <form method="post" novalidate>
        <div class="mb-3">
          <label for="Email" class="form-label">Email address</label>
          <input type="email" class="form-control" id="Email" name="Email">
        </div>

        <div class="mb-3">
          <label for="Subject" class="form-label">Subject</label>
          <input type="text" class="form-control" id="Subject" name="Subject">
        </div>

        <div class="mb-3">
          <label for="Textarea" class="form-label">Message</label>
          <textarea class="form-control" id="Textarea" name="textarea" rows="4"></textarea>
        </div>

        <button type="submit" class="btn btn-primary" id="Submit">Submit</button>
      </form>
    </div>

    <!-- jQuery for client-side validation -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(function () {
      $('form').on('submit', function (e) {
        var errors = '';
        var email   = $('#Email').val().trim();
        var subject = $('#Subject').val().trim();
        var message = $('#Textarea').val().trim();

        if (email === '') {
          errors += '<li>Please fill email field</li>';
        } else {
          var re = /^[^@\s]+@[^@\s]+\.[^@\s]+$/;
          if (!re.test(email)) {
            errors += '<li>Please enter a valid email</li>';
          }
        }

        if (subject === '') {
          errors += '<li>Please fill subject field</li>';
        }

        if (message === '') {
          errors += '<li>Please fill message field</li>';
        }

        if (errors !== '') {
          e.preventDefault();
          $('#messages').html('<div class="alert alert-danger"><ul class="mb-0">' + errors + '</ul></div>');
        }
      });
    });
    </script>
  </body>
</html>
