<?php
function validEmail($string)
{
    return (bool) (preg_match("/^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/", $string));
}
function containsUppercase($string)
{
    return (bool) (preg_match("/[A-Z]/", $string));
}
function containsNumber($string)
{
    return (bool) (preg_match("/[0-9]/", $string));
}
function containsSymbol($string)
{
    return (bool) (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $string));
}
function clean_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function validPhoneNumber($string)
{
    return (bool) (preg_match("/^[0-9\-\(\)\/\+\s]*$/", $string));
}
