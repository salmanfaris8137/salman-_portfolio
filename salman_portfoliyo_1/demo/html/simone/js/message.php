<?php
header('Content-Type: application/json');

// Initialize response array
$response = array('response' => 'error', 'Message' => '');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

    // Validate form data
    if (empty($name) || empty($email) || empty($message)) {
        $response['Message'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">Please fill in all fields.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response['Message'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">Please enter a valid email address.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    } else {
        // Prepare email
        $to = "salmanfarisots@gmail.com"; // Replace with your actual email address
        $subject = "New Contact Form Submission";
        $email_content = "Name: $name\n";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Message:\n$message\n";

        // Send email
        $headers = "From: $name <$email>";

        if (mail($to, $subject, $email_content, $headers)) {
            $response['response'] = 'success';
            $response['Message'] = '<div class="alert alert-success alert-dismissible fade show" role="alert">Thank you for your message. We will get back to you soon!<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        } else {
            $response['Message'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">Oops! Something went wrong and we couldn\'t send your message.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        }
    }
} else {
    $response['Message'] = '<div class="alert alert-danger alert-dismissible fade show" role="alert">Invalid request method.<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
}

echo json_encode($response);
?>