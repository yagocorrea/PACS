<?php

    /*****************************************************************
     *   Arquivo Responsável por Gerar Nome de Login Dinâmicamente   *
     *****************************************************************/
    
    //conexão
    include_once '../app/config/conn.php';
    
	$nome = $_POST['nome'];

    $nome = str_replace(" ", "", $nome); //removendo espaços
    $nome = strtolower($nome); //minuscula
    
    $sql = "SELECT * FROM login WHERE login = '".$nome."'";
    $query = mysql_query($sql, $con);
    if(!mysql_num_rows($query)){
        $novoLogin = $nome;
    } else {
        $sql = "SELECT * FROM login WHERE login LIKE '".$nome."%'";
        $query = mysql_query($sql, $con);
        $registro = mysql_fetch_assoc($query);
        if(!mysql_num_rows($query)){
            //pode sugerir esse usuario msm 
            $novoLogin = $registro['login'];
        } else {
            $i = 0;
            $novoLogin = $registro['login'];
            //$novoLogin = $nome;
            //foreach ($registro as $value) {
                
                while($novoLogin == $registro['login']){
                    $i++;
                    $novoLogin = $nome.$i;
                }
            //}
        }
    }
    
    //$novoLogin = $registro['login'];
    
	
    echo $novoLogin;
   
    

?>