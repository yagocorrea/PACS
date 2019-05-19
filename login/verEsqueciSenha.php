<?php
session_start();
ob_start();

$alterarSenha  = $_POST["email"];
$perfilUsuario = $_POST["acesso"];
echo $perfilUsuario;

if ($alterarSenha == null) {
    $msg = "Por favor, informe o e-mail!";
    header("location:./password?msg=" . $msg);
    
} else {
    include '../app/config/conn.php';
}
if (isset($_POST["email"])) {
    
    $email = mysql_real_escape_string($_POST["email"]);
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = "E-mail inválido";
        header("location:./password?msg=" . $msg);
        return;
    }
    
    
    
    //var_dump($sql);
    //var_dump($con);
    
    
    
    $sql    = "SELECT * FROM funcionario WHERE email = '{$email}' AND statusfuncionario = 's'";
    $result = mysql_query($sql, $con);
    $row    = mysql_fetch_array($result);
    if (mysql_num_rows($result) == 0) {
        
        //echo $erro[] = "O e-mail informado não existe em nossa base";
        $msg = "O e-mail informado não existe em nossa base ou foi desativado.";
        header("location:./password?msg=" . $msg);
        return;
        
    } else {
        $id        = $row[0];
        $funcionario   = $row[1];
        $novaSenha = substr(md5(time()), 0, 6); // Envia e-mail para o úsuario 
        //$novaSenhaBD = md5(md5($novaSenha)); // Muda senha no banco de dados
        
        $sql_code = "UPDATE login SET senha = '$novaSenha' WHERE idfuncionario = '{$id}'";
        if (mysql_query($sql_code, $con)) {
            //guardando dados do login
            $sqlLogin = "SELECT * FROM login WHERE idfuncionario = '{$id}'";
            $result   = mysql_query($sqlLogin, $con);
            $row      = mysql_fetch_array($result);
            $login    = $row[1];
            
            include '../app/PHPMailer/class.phpmailer.php';
            
            
            
            $emailRemetente = "naoresponder@sizeof.com.br";
            
            $nome = "Sarton";
            
            $assunto = utf8_decode("Senha alterada - Sarton");
            
            $corpo = nl2br("
                Olá {$funcionario}, sua senha foi alterada!

                ----------------------------------------------------
                Segue dados de acesso:

                Login: <b>{$login}</b>
                Nova senha: <b>{$novaSenha}</b>    

                Link: <a href='https://sizeof.com.br/desenvolvimento/Sarton/login/' target='_blank'>Acessar minha conta</a>
                ----------------------------------------------------

                <i>
                Obs.: Por razões de segurança, por favor, altere sua senha após o login. 
                Att: Sarton - Monitoramento
                </i>
                <img src='https://sizeof.com.br/desenvolvimento/Sarton/assets/images/login/1.jpg' width='100'>   
                
                <b>e-mail automático. por favor, não o responda!</b>        

                ");
            $corpo = utf8_decode($corpo);
            $PHPMailer = new PHPMailer();
            
            $PHPMailer->IsSMTP();
            
            $PHPMailer->isHTML(true);
            
            $PHPMailer->allow_charset_conversion = true;
            
            $PHPMailer->Charset = 'UTF-8';
            
            $PHPMailer->Host = 'mail.sizeof.com.br';
            
            $PHPMailer->SMTPDebug = 0;
            
            $PHPMailer->Port = 587;
            
            $PHPMailer->Username = $emailRemetente;
            
            $PHPMailer->From = $emailRemetente;
            
            $PHPMailer->FromName = $nome; //$nome;
            
            $PHPMailer->Subject = $assunto;
            
            $mensagem = "

                    <html>

                        <head>

                            <title>Senha alterada</title>

                        </head>

                        <body>

                            {$corpo}            

                        </body>

                    </html>";
            
            $PHPMailer->Body = $mensagem;
            
            $PHPMailer->AltBody = $corpo;
            
            //$email = $email; -> já tem lá em cima
            
            $PHPMailer->AddAddress($email);
            
            
            
            if ($PHPMailer->Send()) {
                
                $msg = "Senha enviada para o email cadastrado!";
                
                header("location:./password?msg=" . $msg);
                
            } else {
                
                //echo 'Erro do PHPMailer: ' . $PHPMailer->ErrorInfo;
                
                $msg = "Encontramos dificuldades em enviar email, por favor, entre em contato com o suporte!";
                
                header("location:./password?msg=" . $msg);
                
            }
         
        }
        
        
    }
}

ob_end_flush();