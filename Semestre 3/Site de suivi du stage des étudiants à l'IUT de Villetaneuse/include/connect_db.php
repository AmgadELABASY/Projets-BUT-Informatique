<?php  

    try{
        $bd = new PDO('mysql:host=localhost;port=8889;equipe4_database;charset=utf8', 'root', 'root');
    }
    catch(Exception $e){
        die('Erreur : ' . $e->getMessage());
    }

   


?>


 

 