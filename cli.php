<?php
/**
 * Output the cli table
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
use Helper\Table;

require_once 'helper/Table.php';

/*
 * Initialize the Table class
 * pass $argv[1] retrived from cli to be validated
 *
 */
$table = new Table();
if (isset($argv[1])) :
    echo $table->validation($argv[1]);
endif;
