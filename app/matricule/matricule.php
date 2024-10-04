<?php


function generateMatricule($prefix = 'ER_pr-', $length = 4) {
    // Générer un nombre aléatoire avec le nombre de chiffres spécifié
    $number = str_pad(rand(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
    return $prefix . $number;
}