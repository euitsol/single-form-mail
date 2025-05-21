<?php
require '../vendor/autoload.php';

if (!isset($_POST['submit'])) {
    header('Location: /');
    exit();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

// Load environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Sanitize inputs
function clean($data)
{
    return htmlspecialchars(trim($data));
}

$name        = clean($_POST['name'] ?? '');
$email       = clean($_POST['email'] ?? '');
$phone       = clean($_POST['phone'] ?? '');
$message     = clean($_POST['message'] ?? '');
$doorbelling = isset($_POST['doorbelling']) ? 'Yes' : 'No';
$hostevent   = isset($_POST['hostevent']) ? 'Yes' : 'No';
$signwaving  = isset($_POST['signwaving']) ? 'Yes' : 'No';
$phonecalls  = isset($_POST['phonecalls']) ? 'Yes' : 'No';

if (empty($name) || empty($email) || empty($message)) {
    exit('Please fill in required fields (Name, Email, Message).');
}

if (empty($doorbelling) && empty($hostevent) && empty($signwaving) && empty($phonecalls)) {
    exit('Please select at least one volunteer preference.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    exit('Please enter a valid email address.');
}

if (empty($_ENV['SMTP_HOST']) || empty($_ENV['SMTP_USERNAME']) || empty($_ENV['SMTP_PASSWORD']) || empty($_ENV['SMTP_PORT'])) {
    exit('Please enter valid SMTP credentials.');
}

$mail = new PHPMailer(true);

try {
    $mail->SMTPDebug = true;
    $mail->isSMTP();
    $mail->Host       = $_ENV['SMTP_HOST'];
    $mail->SMTPAuth   = true;
    $mail->Username   = $_ENV['SMTP_USERNAME'];
    $mail->Password   = $_ENV['SMTP_PASSWORD'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = $_ENV['SMTP_PORT'];

    $mail->setFrom($_ENV['FROM_EMAIL'], $_ENV['FROM_NAME']);
    $mail->addAddress($_ENV['TO_EMAIL']);

    $mail->isHTML(true);
    $mail->Subject = "New Volunteer Submission from $name";
    $mail->Body    = "
        <h2>Contact Form Submission</h2>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Phone:</strong> $phone</p>
        <p><strong>Message:</strong> $message</p>
        <h3>Volunteer Preferences:</h3>
        <ul>
            <li><strong>Door Belling:</strong> $doorbelling</li>
            <li><strong>Host an Event:</strong> $hostevent</li>
            <li><strong>Sign Waving:</strong> $signwaving</li>
            <li><strong>Phone Calls:</strong> $phonecalls</li>
        </ul>
    ";

    $mail->send();
    echo "Thanks, your message has been sent.";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
