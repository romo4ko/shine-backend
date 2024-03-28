<?php

declare(strict_types=1);

/**
 * Обёртка над функцией print_r
 *
 * @param mixed $var
 * @param bool $in_file
 */
function d($var = false, $in_file = false)
{
    if ($in_file) {
        $file = fopen(public_path('/d.log'), 'ab');
        if (! $file) {
            echo '';
        } else {
            fwrite($file, print_r($var, true));
            fwrite($file, "\r\n");
            fclose($file);
        }
    }
    if (! $in_file || $in_file === 2) {
        ?>
        <pre><?php print_r($var); ?></pre><?php
    }
}
