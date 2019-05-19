<?php
session_start();
if (!isset($_SESSION["login"])) {
    session_destroy();
    $msg = "Usuário sem acesso!";
    header("location:../?msg=" . $msg);
}

define('NOME_EMPRESA', 'PACS - Portal de atendimento ao cliente para salões');
define('TITLE', 'PACS - Portal de atendimento ao cliente para salões');
define('ALT', 'PACS - Portal de atendimento ao cliente para salões');
define('EMAIL_LOGIN', '@Pacs.com.br');
define('BASE_ICO', '//localhost/pacs/assets/img/favicon.ico');
define('URLPADRAO', '//localhost/pacs/app');
define('URLCSSJS', '//localhost/pacs');


ob_start();



