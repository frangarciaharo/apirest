<?php
function dd(){
    foreach(func_get_args() as $arg){
        echo'<prev>';
        var_dump($arg);
        echo'</prev>';
    }
    die();
}