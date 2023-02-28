<?php
/**
 * Grundeinstellungen für die Vereinsverwaltung
 */

/**
 * Datenbank-Parameter
 */
define( 'DB_NAME', '' );
define( 'DB_USER', '' );
define( 'DB_PASSWORD', '' );
define( 'DB_HOST', '' );

/**
 * Email-Parameter
 */
define( 'SMTP_SERVER', '' );
define( 'BOT_EMAIL', '' );
define( 'BOT_PASSWORT', '' );

/**
 * Passwort-Hash
 * 1. Ein sicheres Passwort erstellen 
 * 2. den Hash mit Bcrypt hier hinterlegen
 *    Dafür die PHP-Funktion password_hash(...) mit dem bcrypt-Algorithmus nutzen.
 *    Das geht online bswp. hier: https://phppasswordhash.com/
 */
define('ADMIN_PASSWORD_HASH', '' );

/**
 * Vereinseinstellungen
 * die Nuliga-ID kann man aus dem Parameter club in der URL entnehmen, 
 *   Bsp. für den Turnerkreis Nippes:
 *   https://hvmittelrhein-handball.liga.nu/cgi-bin/WebObjects/nuLigaHBDE.woa/wa/clubInfoDisplay?club=74851
 *   >>74851<< is die nuLiga-ID
 */
define( 'VEREIN_NAME', '' );
define( 'VEREIN_NULIGA_ID', '' );
?>