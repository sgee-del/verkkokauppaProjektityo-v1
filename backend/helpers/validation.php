<?php

/**
 * Puhdistaa syötteen poistamalla ylimääräiset välilyönnit, kenoviivat ja HTML-tagit.
 *
 * @param string $data Puhdistettava data.
 * @return string Puhdistettu data.
 * 
 */
function sanitize_input(string $data): string
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Validoi sähköpostiosoitteen muodon.
 *
 * @param string $email Validoitava sähköposti.
 * @return bool Palauttaa true, jos sähköposti on kelvollinen, muuten false.
 * 
 */
function validate_email(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Tarkistaa, onko syöte tyhjä.
 *
 * @param string $data Tarkistettava data.
 * @return bool Palauttaa true, jos data on tyhjä, muuten false.
 * 
 */
function is_empty(string $data): bool
{
    return empty(trim($data));
}

/**
 * Tarkistaa, että salasanan pituus on vähintään määritelty määrä.
 *
 * @param string $password Tarkistettava salasana.
 * @param int $minLength Salasanan vähimmäispituus.
 * @return bool Palauttaa true, jos salasana on tarpeeksi pitkä, muuten false.
 * 
 */
function validate_password_length(string $password, int $minLength = 8): bool
{
    return strlen($password) >= $minLength;
}