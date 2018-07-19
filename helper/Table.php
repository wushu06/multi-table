<?php
/**
 * Validate an input and return an output for html and cli
 *
 * PHP version 7
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category  Null
 * @package   Null
 * @author    Another Author <nourwushu@gmail.com>
 * @copyright 2018 Noureddine Latreche
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   CVS: 1.0.0
 * @link      Null
 */
declare(strict_types=1);


namespace Helper;

/**
 * This class contains three functions
 * This class is called in index.php and cli.php
 *
 * @category  Null
 * @package   Null
 * @author    Another Author <nourwushu@gmail.com>
 * @copyright 2018 Noureddine Latreche
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   CVS: 1.0.0
 * @link      Null
 */

class Table
{

    /**
     * Validate the $value to check if it is not empty and it is an integer.
     *
     * @param    int $value , string $output cli as default will trigger cli_output_generator()
     *           or can pass html which will trigger html_output_generator()
     * @param    string $output
     * @return   string $msg
     */

    public function validation(int $value, string $output = 'cli') : string
    {

        $msg = '';

        if ($value == '') {
            $msg = 'Field can not be empty';
        } elseif (filter_var($value, FILTER_SANITIZE_NUMBER_INT)) {
            if ($output == 'cli') {
                $this->cliOutputGenerator($value);
            } elseif ($output == 'html') {
                $msg = $this->htmlOutputGenerator($value);
            }
        } else {
            $msg = "$value, must be a number";
        }



        return $msg;
    }

    /**
     * Generate html output.
     *
     *
     * @param int $POST
     * @return string $output which will be a table
     */

    public function htmlOutputGenerator(int $POST) : string
    {


        $num     = $POST;
        $cols    = $num;
        $rows    = $num;


        $output = "<table border=\"1\">";


        for ($row = 1; $row <= $rows; $row++) {
            $output .= ('<tr>');


            for ($col = 0; $col <= $cols; $col++) {
                if ($col == 0 && $row != 0) {
                } elseif ($row != 0) {
                    $output .= ('<td>' . $col * $row . '</td>');
                }
            }
            $output .= ('</tr>');
        }

        $output .= ("</table>");


        return $output;
    }

    /**
     * Generate cli output.
     *
     *
     * @param int $num
     * @return void $output which will be a table
     * @example php cli.php 5
     */

    public function cliOutputGenerator(int $num)
    {

        $cols    = $num;
        $rows    = $num;


        for ($row = 0; $row <= $rows; $row++) {
            printf("\n");

            for ($col = 1; $col <= $cols; $col++) {
                if ($col == 0 && $row != 0) {
                } elseif ($row != 0) {
                    if ($col * $col == 1) {
                        // printf($mask, $col * $row);
                        echo str_pad("\033[31m ".$col * $row, 10).'|';
                    } elseif ($row * $row == 1) {
                        echo str_pad("\033[31m ".$col, 10).'|';
                    } else {
                        echo str_pad("\033[30m ".$col * $row, 10).'|';
                    }
                }
            }
            printf("\n");
        }
        return;
    }
} // end class Table
