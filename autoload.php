<?php

spl_autoload_register(
    function ($class){
        $diretorios = array('./','model/','dao/','relatorios/');
        foreach ($diretorios as $diretorio) {
            if(file_exists($diretorio . $class . ".php")) {
                require_once $diretorio . $class . ".php";
                return;
            }
        }
        
    }        
);



