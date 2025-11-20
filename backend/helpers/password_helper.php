<?php

/**
 * Luo salasanasta hashin.
 *
 * Funktio käyttää PHP:n sisäänrakennettua password_hash-funktiota,
 * joka hoitaa automaattisesti salauksen ja käyttää (BCRYPT).
 *
 * @param string $password Salasana, joka halutaan hashata.
 * @return string Palauttaa salasanan hashn.
 */
function hash_password(string $password): string
{
    return password_hash($password, PASSWORD_DEFAULT);
}

/**
 * Varmistaa, että annettu salasana vastaa annettua tiivistettä.
 *
 * @param string $password Käyttäjän syöttämä salasana.
 * @param string $hash Tietokantaan tallennettu tiiviste.
 * @return bool Palauttaa true, jos salasana on oikea, muuten false.
 */
function verify_password(string $password, string $hash): bool
{
    return password_verify($password, $hash);
}