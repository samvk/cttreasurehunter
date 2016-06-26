<?php

error_reporting(0);

//Correct serve connection test
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit;
}

require "dbconnection.php";

$name = mysqli_real_escape_string($dbc, trim($_POST["name"]));
$email = mysqli_real_escape_string($dbc, trim($_POST["email"]));
$phone = mysqli_real_escape_string($dbc, trim($_POST["phone"]));
$service = mysqli_real_escape_string($dbc, trim($_POST["service"]));
$message = mysqli_real_escape_string($dbc, trim($_POST["message"]));

//empty fields check (shouldn't be seen if html:required working)
if (empty($name) || empty($email) || empty($service) || empty($message)) {
    echo "<p class='error'>It looks like you left some required fields blank.</p>";
    exit;
}

//Valid email check (shouldn't be seen if html:required working)
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<p class='error'>Invalid email.</p>";
    exit;
}

//Spam bot honeypot
if ($_POST["address"] != "") {
    echo "<p class='error'>Bad form input.</p>";
    exit;
}

// Send copy of message to database
mysqli_query($dbc, "INSERT INTO contact(name, email, phone, service, message) VALUES ('$name', '$email', '$phone', '$service', '$message')");

// Send message directly to crec email
$to = "samvnkauffman@gmail.com";
$email_subject = "New message from $name - \"Read Every Day\"";
$email_body = "You have received a new message from The Treasure Hunter.\n\nHere are the details:\n\nName: $name\n\nEmail: $email_address\n\nPhone Number: $phone\n\nService requested: $service\n\nMessage:\n$message";
$headers = "From: noreply@crec.org/readeveryday\n";
$headers .= "Reply-To: $email_address";	

mail($to,$email_subject,$email_body,$headers);

echo "<p class='success'>Submitted!</p>";