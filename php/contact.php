<?php

error_reporting(0);

//Correct serve connection test
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit;
}

require "dbconnection.php";

$name = trim($_POST["name"]);
$email = trim($_POST["email"]);
$phone = trim($_POST["phone"]);
$service = trim($_POST["service"]);
$message = trim($_POST["message"]);

//empty fields check (shouldn't be seen unless falsey value passed on purpose)
if (empty($name) || empty($email) || empty($service) || empty($message)) {
    echo "<p class='error'>It looks like you left some required fields blank.</p>";
    exit;
}

//Valid email check (shouldn't be seen unless falsey value passed on purpose)
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<p class='error'>Invalid email.</p>";
    exit;
}

//Spam bot honeypot
if ($_POST["address"] !== "") {
    echo "<p class='error'>Bad form input.</p>";
    exit;
}

// Send message to database
$stmt = $db->prepare("INSERT INTO contact(name, email, phone, message) VALUES (:name, :email, :phone, :message)");
$stmt->execute(array(':name' => $name, ':email' => $email, ':phone' => $phone, ':message' => $message));

// Send message to email
$to = "mail@samvk.com";
$email_subject = "New message from $name - The Treasure Hunter";
$email_body = "You have received a new message from The Treasure Hunter. Here are the details...\n\nName: $name\n\nEmail: $email_address\n\nPhone Number: $phone\n\nService requested: $service\n\nMessage:\n$message";
$headers = "From: noreply@cttreasurehunter.com\r\n";
$headers .= "Reply-To: $email_address";	

mail($to, $email_subject, $email_body, $headers);

echo "<p class='success'>Submitted!</p>";