<?php
/**
 * UTIL PHP FUNCTIONS
 */

/**
 * CONVERT STRING ('1234567') TO A PHONE NUMBER
 */
function format_phone($phone)
{
    if (strlen($phone) > 10) {
        return '(' . substr($phone, 0, 2) . ') ' . substr($phone, 2, 5) . '-'
            . substr($phone, 7);
    } else {
        return '(' . substr($phone, 0, 2) . ') ' . substr($phone, 2, 4) . '-'
            . substr($phone, 6);
    }
}
