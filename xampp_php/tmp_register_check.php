<?php
require 'app/bootstrap.php';

$name = 'Juan';
$lastname = 'Perez';
$email = 'juan.perez@test.com';
$phone = '+54 11 1234 5678';
$document = '12345678';
$birthdate = '1995-05-20';
$password = '123456';
$passwordConfirm = '123456';

$cleanName = clean_text($name);
$cleanLast = clean_text($lastname);
$cleanEmail = clean_email($email);
$cleanPhone = preg_replace('/\s+/', '', (string) $phone);
$cleanDocument = preg_replace('/\D+/', '', (string) $document);
$cleanBirth = (string) $birthdate;
$cleanPassword = (string) $password;
$cleanPasswordConfirm = (string) $passwordConfirm;

$passwordsMatch = $cleanPassword !== '' && $cleanPassword === $cleanPasswordConfirm;

$checks = [
  'name' => valid_name($cleanName),
  'lastname' => valid_name($cleanLast),
  'email' => valid_email($cleanEmail),
  'phone' => valid_phone($cleanPhone),
  'document' => valid_document($cleanDocument),
  'birthdate' => valid_birthdate($cleanBirth),
  'password' => valid_password($cleanPassword),
  'passwordsMatch' => $passwordsMatch,
];

foreach ($checks as $key => $value) {
  echo $key . ': ' . ($value ? 'OK' : 'FAIL') . PHP_EOL;
}

if (!($checks['name'] && $checks['lastname'] && $checks['email'] && $checks['phone'] && $checks['document'] && $checks['birthdate'] && $checks['password'] && $checks['passwordsMatch'])) {
  echo "Overall: FAIL\n";
} else {
  echo "Overall: OK\n";
}
