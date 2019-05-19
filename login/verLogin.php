<?php
session_start();
ob_start();

@$login = $_POST["login"];
@$senha = $_POST["pass"];

if ($login == null || $senha == null) {
    $msg = "Por favor, informe login e senha!";
    //header("location:./?msg=" . $msg);
   
} else {
    include '../app/config/conn.php';   
    $sql = "select 
                * 
            from login 
            where login = '" . $login . "' 
            AND senha = '" . $senha . "'"; 

    $result = mysql_query($sql, $con);
    if (mysql_num_rows($result) == 1) {
        $row = mysql_fetch_array($result);
        $_SESSION["id"] = $row["idlogin"];
        $_SESSION["login"] = $row["login"];
        $_SESSION["senha"] = $row["senha"];
		//$_SESSION["idfuncionario"] = $row["idfuncionario"];
        //$_SESSION["ativo"] = $row["ativo"];
        $_SESSION["tempo"] = time();

        header("location:../app/permissionamento.php");
        //Verifica permissão dos links
    } else {
        $msg = "Login ou Senha inválido(s)";
        header("location:./index?msg=" . $msg);
        
    }
}
