<?php

    $banco = new mysqli("127.0.0.1", "root", "", "world");

    if ($banco->connect_errno){
        print "Parece que houve algum problema interno, por favor tente novamente mais tarde.";
        die();
    }