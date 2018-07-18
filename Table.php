<?php
/**
 * Created by Noureddine.
 * Date: 17/07/18
 * Table class for generating multiplication table for both html and cli
 * 
 */

class Table
{
    /*
     * Validtion function
     * two arguments
     */
    public function validation($value, $output = 'cli')
    {

        $msg = '';
        if( $value == '' ) {
            $msg = 'Field can not be empty';
        }elseif ( filter_var($value, FILTER_SANITIZE_NUMBER_INT)) {
            //function
            if($output == 'cli' ) {
                $this->cli_output_generator($value);
            }elseif($output == 'html' ){
                $msg = $this->html_output_generator($value);
            }
        } else {
            $msg = "$value, must be a number";
        }



        return $msg;

    }

    public function html_output_generator(int $POST)
    {


            $num = $POST;
            $cols = $num;
            $rows = $num;
            $number = 1;
            $number2 = 0;

            $output =  "<table border=\"1\">";


            for ($r = 0; $r < $rows; $r++){

                $output .= ('<tr>');
                if ($r == 0) {
                    for ($i = 0; $i < $rows; $i++) {
                        $output .= ('<td style="background-color: #ccc; padding: 15px;">' .$number2++.'</td>');
                    }
                }

                for ($c = 0; $c < $cols; $c++){
                    if ($c == 0 && $r != 0) {
                        $output .= ('<td style="background-color: #ccc; padding: 15px;">' .$number++.'</td>');
                    } else if ($r != 0) {
                        $output .= ( '<td style="padding: 15px;">' .$c*$r.'</td>');
                    }
                }
                $output .= ('</tr>');
            }

            $output .= ("</table>");


       return $output;

    }

    public function cli_output_generator( $num )
    {

        $cols = $num;
        $rows = $num;
        $number = 1;
        $number2 = 0;

        $mask = "|%5.5s ";


        for ($r = 0; $r < $rows; $r++){
            printf("\n");

            if ($r == 0) {
                for ($i = 0; $i < $rows; $i++) {

                    printf($mask, $number2++);

                }

            }

            for ($c = 0; $c < $cols; $c++){

                if ($c == 0 && $r != 0) {

                    printf($mask, $number++);
                } else if ($r != 0) {

                    printf($mask, $c*$r);
                }

            }
            printf("\n");

        }


    }
    

}