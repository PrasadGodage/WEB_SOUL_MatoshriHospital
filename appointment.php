<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        # FIX: Replace this email with recipient email
        $mail_to = "amolvpawar200@gmail.com";
        
        # Sender Data
        // $subject = trim($_POST["subject"]);
        $name = str_replace(array("\r","\n"),array(" "," ") , strip_tags(trim($_POST["patient_name"])));
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $contact = trim($_POST["contact"]);
        $visit = trim($_POST["visit"]);
        $date = trim($_POST["date"]);
        $time = trim($_POST["time"]);
        if ( empty($name) OR !filter_var($email, FILTER_VALIDATE_EMAIL) OR empty($contact)) {
            # Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Please complete the form and try again.";
            exit;
        }
        
        # Mail Content
        $content = "patient name: $name\n";
        // $content .= "email: $email\n\n";
        $content .= "contact: $contact\n";
        $content .= "visit: $visit\n";
        $content .= "date: $date\n";
        $content .= "time: $time\n";
        $subject = "Appoitmnet form | New Enquirey added";


        # email headers.
        $headers = $content;

        # Send the email.
        $success = mail($mail_to, $subject, $headers);
        if ($success) {
            # Set a 200 (okay) response code.
            http_response_code(200);
            echo "Thank You! Your message has been sent.";
        } else {
            # Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Something went wrong, we couldn't send your message.";
        }

    } else {
        # Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }
?>