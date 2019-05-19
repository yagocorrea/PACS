<?php
@$con = mysql_connect("localhost", "root", "");
@mysql_select_db("pacs", $con);

@mysql_query("SET NAMES 'utf8'");
@mysql_query('SET character_set_connection=utf8');
@mysql_query('SET character_set_client=utf8');
@mysql_query('SET character_set_results=utf8');




/*
---------------------------
Testar conexão com o banco 
---------------------------
$banco = "pacs";
$usuario = "root";
$senha = "";
$hostname = "localhost";
$conn = mysql_connect($hostname,$usuario,$senha); mysql_select_db($banco) or die( "Não foi possível conectar ao banco MySQL");
if (!$conn) {echo "Não foi possível conectar ao banco MySQL.
"; exit;}
else {echo "Parabéns!! A conexão ao banco de dados ocorreu normalmente!.
";}
mysql_close(); 
*/
?>
