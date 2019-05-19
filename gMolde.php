<?php
    include_once '../config/conn.php'; //Arquivo de Conexão
    include_once "../config/flash.php"; //função de flash mensagens
    date_default_timezone_set('EAST/BRAZIL');
    

    if($_SERVER['REQUEST_METHOD'] == 'POST'){ //se tiver feito requisição via post
        //se o usuário decidir desativar/ativar o usuário na página bFuncionário
        if(isset($_POST['btn-status'])){
            $id = filter_var($_POST['idfuncionario'], FILTER_SANITIZE_NUMBER_INT);
            $status  = filter_var($_POST["status"], FILTER_SANITIZE_STRING);
            $dtstatus = date("Y-m-d");
            if($status != 's'){
                $statusFunc = 'n';
            } else {
                $statusFunc = 's';
            }
            //STATUS EM FUNCIONARIO
            $sqlF = "UPDATE funcionario SET status = '".$statusFunc."' WHERE idfuncionario = '".$id."'";
            $queryF = mysql_query($sqlF, $con);
            //STATUS EM LOGIN
            $sqlL = "UPDATE login SET status = '".$status."', dtstatus = '".$dtstatus."' WHERE idfuncionario = '".$id."'";
            $queryL = mysql_query($sqlL, $con);
            //realiza insert do login;
            if(!$queryF || !$queryL){
                flash("mensagem", "ERRO AO ALTERAR O STATUS DO FUNCIONÁRIO. POR FAVOR, ENTRE EM CONTATO COM O SUPORTE DO SISTEMA!", "danger");
                header("location:bFuncionarioPendente");
            } else {
                flash("mensagem", "O STATUS DO FUNCIONÁRIO FOI ALTERADO COM SUCESSO!", "success");
                header("location:bFuncionarioPendente");
            }

        }


        if(isset($_POST['cadastrar'])){ //se tiver setado o botão de cadastrar           
            //verificando se post tá vazio:

            #guardando dentro de um array os names dos posts q n podem ficar em banco
            $post = array(
                "nome" , "nomeescala", "cpf", "dtnasc", "telefone", "idativextra", "idpostograduacao", "idsetorfuncao", "rg", "estadocivil",  
                "sexo", "nomemae", "email", "login", "senha", "cep", "endereco", "bairro", "complemento", "numero", "cidade", "estado"
            );
            //percorrendo array pra ver se está vazio
            foreach ($post as $key) { 
                if(empty($_POST[$key]) || !isset($_POST[$key])){ // ta vazio -- Lembrando que pode estar retornando null, por isso as duas verificações    
                    $empty = true;
                } else { //n ta vazio:
                    $empty = false;
                }
            }
            if(!$empty){ //n ta vazio:
                #capturando dados do form de cadastro e protegendo contra SQL Injection
                # 1 - n deixar repetir rg, cpf, cnh -- vê com will se tem mais algum campo q n pode repetir
                
                //NOME COMPLETO
                $nomee = filter_var($_POST["nome"], FILTER_SANITIZE_STRING); //Filtro pra SQL Injection
                $nomee = ucwords(strtolower(htmlentities($nomee))); //tratamento
                //LOGIN
                $login = filter_var($_POST['login'], FILTER_SANITIZE_STRING);
                //SENHA
                $senha = filter_var($_POST['senha'], FILTER_SANITIZE_STRING);
                $password = $senha; //sem criptografia
                $senha = md5($senha);
                //EMAIL
                $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
                #CPF --- Chamar Função de Validação em Validate.php
                $cpf = filter_var($_POST["cpf"], FILTER_SANITIZE_STRING); //Filtro pra SQL Injection
                $cpf = str_replace('.', '', $cpf); //tratamento
                $cpf = str_replace('-', '', $cpf); //tratamento
                //DATA DE NASCIMENTO
                $dtnasc = filter_var($_POST["dtnasc"], FILTER_SANITIZE_STRING);//Filtro pra SQL Injection
                //TELEFONE
                $telefone = filter_var($_POST["telefone"], FILTER_SANITIZE_STRING);//Filtro pra SQL Injection
                $telefone = str_replace('(', '', $telefone); //tratamento
                $telefone = str_replace(')', '', $telefone); //tratamento
                //RG
                $rg = filter_var($_POST["rg"], FILTER_SANITIZE_STRING);//Filtro pra SQL Injection
                $rg = str_replace('.', '', $rg); //tratamento
                $rg = str_replace('-', '', $rg); //tratamento
                $rg = str_replace(' ', '', $rg); //tratamento
                //ESTADO CIVIL
                $estadocivil = filter_var($_POST["estadocivil"], FILTER_SANITIZE_STRING);//Filtro pra SQL Injection
                //SEXO
                $sexo = filter_var($_POST["sexo"], FILTER_SANITIZE_STRING);//Filtro pra SQL Injection
                //DEPENDENTES
                $numerodepe = filter_var($_POST["numerodepe"], FILTER_SANITIZE_STRING);//Filtro pra SQL Injection
                //NOME ESCALA
                $nomeescala = filter_var($_POST["nomeescala"], FILTER_SANITIZE_STRING);//Filtro pra SQL Injection
                //PORTE DE ARMA
                $portearma = filter_var($_POST["portearma"], FILTER_SANITIZE_STRING);//Filtro pra SQL Injection
                //FUMANTE
                $fumante = filter_var($_POST["fumante"], FILTER_SANITIZE_STRING);//Filtro pra SQL Injection
                //INDICAÇÃO
                $indicacao = filter_var($_POST["indicacao"], FILTER_SANITIZE_STRING);//Filtro pra SQL Injection
                //QUEM INDICOU
                $nomeindicacao = filter_var($_POST['indicacao_sim'], FILTER_SANITIZE_STRING);
                //NOME DA MÃE
                $nomemae = filter_var($_POST["nomemae"], FILTER_SANITIZE_STRING);//Filtro pra SQL Injection
                //ATIVIDADE EXTRA
                $idativextra = filter_var($_POST["idatvextra"], FILTER_SANITIZE_STRING);//Filtro pra SQL Injection
                //MATRICULA
                $matricula = filter_var($_POST["matricula"], FILTER_SANITIZE_STRING);//Filtro pra SQL Injection
                //POSTO
                $idpostograduacao = filter_var($_POST["idpostograduacao"], FILTER_SANITIZE_STRING);//Filtro pra SQL Injection
                //SETOR
                $idsetorfuncao = filter_var($_POST["idsetorfuncao"], FILTER_SANITIZE_STRING);//Filtro pra SQL Injection
                //CARTÃO BENEFICIO
                $idcartaobeneficio = filter_var($_POST["idcartaobeneficio"], FILTER_SANITIZE_STRING);//Filtro pra SQL Injection
                //DATA DE CADASTRO
                $dt = date('Y-m-d H:i:s');

                //EDEREÇO DO FUNCINÁRIO
                $endereco = filter_var($_POST["endereco"], FILTER_SANITIZE_STRING); 
                $cep = filter_var($_POST["cep"], FILTER_SANITIZE_STRING);
                $cep = str_replace("-","", $cep);
                $numero = filter_var($_POST["numero"], FILTER_SANITIZE_NUMBER_INT);
                $complemento = filter_var($_POST["complemento"], FILTER_SANITIZE_STRING);
                $bairro = filter_var($_POST["bairro"], FILTER_SANITIZE_STRING);
                $cidade = filter_var($_POST["cidade"], FILTER_SANITIZE_STRING);
                $estado = filter_var($_POST["estado"], FILTER_SANITIZE_STRING);

                //VALIDANDO CADASTROS
                $verFunc = "SELECT * FROM funcionario WHERE cpf = '".$cpf."' OR rg = '".$rg."' OR matricula = '".$matricula."'";
                $queryFunc = mysql_query($verFunc, $con);
                $rowsFunc = mysql_num_rows($queryFunc);
                $verLogin = "SELECT * login WHERE login ='".$login." OR email = '".$email."'";
                $queryLogin = mysql_query($verLogin, $con);
                $rowsLogin = mysql_num_rows($queryLogin);
                if(!$rowsFunc && !$rowsLogin){
                    // realiza o insert do funcionário -- falta add nomeindicacao, idcartaobeneficio
                    $sqlFunc = "
                        INSERT INTO funcionario (
                            nome, cpf, rg, dtnasc, estadocivil, sexo, telefone, email, statusfuncionario, nomeescala,
                            numerodepe, portearma, nomemae, fumante, indicacao, nomeindicacao, matricula, datacadastro, idativextra,
                            idpostograduacao, idsetorfuncao, idcartaobeneficio
                        ) VALUES(
                            '" . $nomee . "',
                            '" . $cpf . "',
                            '" . $rg . "',
                            '" . $dtnasc . "',
                            '" . $estadocivil . "',
                            '" . $sexo . "',
                            '" . $telefone . "',
                            '" . $email . "',
                            '       s       ',
                            '" . $nomeescala . "',
                            '" . $numerodepe . "',
                            '" . $portearma . "',
                            '" . $nomemae . "',
                            '" . $fumante . "',
                            '" . $indicacao . "',
                            '" . $nomeindicacao . "',
                            '" . $matricula . "',
                            '" . $dt . "',
                            '" . $idativextra . "',
                            '" . $idpostograduacao . "',
                            '" . $idsetorfuncao . "',
                            '" . $idcartaobeneficio . "'
                        )";
                    
                    //realiza insert do login
                    if(mysql_query($sqlFunc, $con)){
                        $idfuncionario = mysql_insert_id();
                        
                        //VALIDANDO ENDEREÇO
                        $verEnd = "SELECT * FROM enderecofuncionario WHERE idfuncionario = '".$idfuncionario."'";                       
                        $end = mysql_query($verEnd, $con);
                        if(!mysql_num_rows($end)){
                            //pode cadastrar o endereço e login
                            //pode inserir login
                            $sqlLogin = "
                                INSERT INTO login (
                                    login, senha, idfuncionario, ativo
                                ) VALUES (
                                    '" . $login . "',
                                    '" . $senha . "',
                                    '" . $idfuncionario . "',
                                    '           s           '
                                )";
                            $queryLogin = mysql_query($sqlLogin, $con);
                            //ENDEREÇO
                            $sqlEnd = "
                                INSERT INTO enderecofuncionario (
                                    cep, logradouro, bairro, municipio, estado, numerocasa, complemento, idfuncionario
                                ) VALUES (
                                    '" . $cep . "',
                                    '" . $endereco . "',
                                    '" . $bairro . "',
                                    '" . $cidade . "',
                                    '" . $estado . "',
                                    '" . $numero . "',
                                    '" . $complemento . "',
                                    '" . $idfuncionario . "'
                                )";                               
                                
                            $queryEnd = mysql_query($sqlEnd, $con);
                            if(!$queryLogin && !$queryEnd){
                                //erro ao cadastrar login e endereço
                                $msg = "Erro ao cadastrar login e endereço do funcionário. Por favor, entre em contato com o suporte do sistema!";
                                header("location:./inf?msg=" . $msg);
                                
                            } else if(!$queryLogin || !$queryEnd){
                                if(!$queryLogin){
                                    //erro ao cadastrar login
                                    $msg = "Erro ao cadastrar login do funcionário. Por favor, entre em contato com o suporte do sistema!";
                                    header("location:./inf?msg=" . $msg);
                                } 
                                
                                if(!$queryEnd){
                                    //erro ao cadastrar endereço
                                    //$msg = mysql_error($con);
                                    $msg = "Erro ao cadastrar endereço do funcionário. Por favor, entre em contato com o suporte do sistema!";
                                    header("location:./inf?msg=" . $msg);
                                }
                            } else {
                                include '../PHPMailer/class.phpmailer.php';         
                                $emailRemetente = "naoresponder@sizeof.com.br";
                                $nome = "Sarton";
                                $assunto = utf8_decode("Primeiro Acesso - Sarton");
                                $corpo = nl2br("
                                    Olá {$nomee}, seu cadastro foi efetuado na Sarton!

                                    ----------------------------------------------------
                                    Segue dados de acesso:

                                    Login: <b>{$login}</b>
                                    senha: <b>{$password}</b>    

                                    Link: <a href='https://sizeoff.com.br/clientes/Sarton/login/' target='_blank'>Acessar minha conta</a>
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
                                                <meta charset='utf-8'>
                                                <title>Senha alterada</title>
                                            </head>
                                            <body>
                                                {$corpo}            
                                            </body>
                                        </html>";
                                $PHPMailer->MsgHTML(utf8_decode($mensagem));
                                $PHPMailer->Body = $mensagem;
                                $PHPMailer->AltBody = $corpo;
                                //$email = $email; -> já tem lá em cima
                                $PHPMailer->AddAddress($email);
                                if ($PHPMailer->Send()) {
                                    //Funcionário Cadastrado com sucesso
                                    $msg = "Funcionário cadastrado com sucesso!";
                                    header("location:./inf?msg=" . $msg);
                                } else {
                                    //echo 'Erro do PHPMailer: ' . $PHPMailer->ErrorInfo;
                                    $msg = "Funcionário cadastrado com sucesso! Porém, ocorreu um erro ao enviar email com os dados de acesso!";
                                    header("location:./inf?msg=" . $msg);
                                }
                                
                            }
                        } else {
                            //esse endereço já existe
                            //informa que esse cadastro já existe
                            flash("mensagem", "Esse endereço já existe no nosso sistema. Por favor, verifique nos cadastros!", "danger");
                            header("location:cFuncionario");
                        }
                    } else {
                        //erro no cadastro do funcionário
                        //$msg = mysql_error($con);
                        $msg = "Erro ao cadastrar Funcionário. Por favor, entre em contato com o suporte do sistema!";
                        header("location:./inf?msg=" . $msg);
                    }
                
                } else {
                    //informa que esse cadastro já existe
                    flash("mensagem", "Esse cadastro já existe no nosso sistema. Por favor, verifique nos cadastros!", "danger");
                    header("location:cFuncionario");
                }                        
            } else{
                //mensagem "n deixe nenhum campo em branco"
                flash("mensagem", "Por favor, não deixe nenhum campo em branco", "danger");
                header("location:cFuncionario");
            }                             
                
        //editando vFuncionario    
        } else if(isset($_POST['editar'])){
            //verificando se post tá vazio:

            #guardando dentro de um array os names dos posts q n podem ficar em banco
            $post = array(
                "nome" , "nomeescala", "cpf", "dtnasc", "telefone", "idativextra", "idpostograduacao", "idsetorfuncao", "rg", "estadocivil",  
                "sexo", "nomemae", "email", "login", "senha", "cep", "endereco", "bairro", "complemento", "numero", "cidade", "estado"
            );

            //percorrendo array pra ver se está vazio
            foreach ($post as $key) { 
                if(empty($_POST[$key]) || !isset($_POST[$key])){ // ta vazio -- Lembrando que pode estar retornando null, por isso as duas verificações    
                    $empty = true;
                } else { //n ta vazio:
                    $empty = false;
                }
            }


            if(!$empty){ //n ta vazio:
                #capturando dados do form de cadastro e protegendo contra SQL Injection
                # 1 - n deixar repetir rg, cpf, cnh -- vê com will se tem mais algum campo q n pode repetir
                
                //NOME COMPLETO
                $nomee = filter_var($_POST["nome"], FILTER_SANITIZE_STRING); //Filtro pra SQL Injection
                $nomee = ucwords(strtolower(htmlentities($nomee))); //tratamento
                //LOGIN
                $login = filter_var($_POST['login'], FILTER_SANITIZE_STRING);
                //SENHA
                $senha = filter_var($_POST['senha'], FILTER_SANITIZE_STRING);
                $password = $senha; //sem criptografia
                $senha = md5($senha);
                //EMAIL
                $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
                #CPF --- Chamar Função de Validação em Validate.php
                $cpf = filter_var($_POST["cpf"], FILTER_SANITIZE_STRING); //Filtro pra SQL Injection
                $cpf = str_replace('.', '', $cpf); //tratamento
                $cpf = str_replace('-', '', $cpf); //tratamento
                //DATA DE NASCIMENTO
                $dtnasc = filter_var($_POST["dtnasc"], FILTER_SANITIZE_STRING);//Filtro pra SQL Injection
                //TELEFONE
                $telefone = filter_var($_POST["telefone"], FILTER_SANITIZE_STRING);//Filtro pra SQL Injection
                $telefone = str_replace('(', '', $telefone); //tratamento
                $telefone = str_replace(')', '', $telefone); //tratamento
                //RG
                $rg = filter_var($_POST["rg"], FILTER_SANITIZE_STRING);//Filtro pra SQL Injection
                $rg = str_replace('.', '', $rg); //tratamento
                $rg = str_replace('-', '', $rg); //tratamento
                $rg = str_replace(' ', '', $rg); //tratamento
                //ESTADO CIVIL
                $estadocivil = filter_var($_POST["estadocivil"], FILTER_SANITIZE_STRING);//Filtro pra SQL Injection
                //SEXO
                $sexo = filter_var($_POST["sexo"], FILTER_SANITIZE_STRING);//Filtro pra SQL Injection
                //DEPENDENTES
                $numerodepe = filter_var($_POST["numerodepe"], FILTER_SANITIZE_STRING);//Filtro pra SQL Injection
                //NOME ESCALA
                $nomeescala = filter_var($_POST["nomeescala"], FILTER_SANITIZE_STRING);//Filtro pra SQL Injection
                //PORTE DE ARMA
                $portearma = filter_var($_POST["portearma"], FILTER_SANITIZE_STRING);//Filtro pra SQL Injection
                //FUMANTE
                $fumante = filter_var($_POST["fumante"], FILTER_SANITIZE_STRING);//Filtro pra SQL Injection
                //INDICAÇÃO
                $indicacao = filter_var($_POST["indicacao"], FILTER_SANITIZE_STRING);//Filtro pra SQL Injection
                //QUEM INDICOU
                $nomeindicacao = filter_var($_POST['indicacao_sim'], FILTER_SANITIZE_STRING); 
                //NOME DA MÃE
                $nomemae = filter_var($_POST["nomemae"], FILTER_SANITIZE_STRING);//Filtro pra SQL Injection
                //ATIVIDADE EXTRA
                $idativextra = filter_var($_POST["idatvextra"], FILTER_SANITIZE_STRING);//Filtro pra SQL Injection
                //MATRICULA
                $matricula = filter_var($_POST["matricula"], FILTER_SANITIZE_STRING);//Filtro pra SQL Injection
                //POSTO
                $idpostograduacao = filter_var($_POST["idpostograduacao"], FILTER_SANITIZE_STRING);//Filtro pra SQL Injection
                //SETOR
                $idsetorfuncao = filter_var($_POST["idsetorfuncao"], FILTER_SANITIZE_STRING);//Filtro pra SQL Injection
                //CARTÃO BENEFICIO
                $idcartaobeneficio = filter_var($_POST["idcartaobeneficio"], FILTER_SANITIZE_STRING);//Filtro pra SQL Injection
                //DATA DE CADASTRO
                $dt = date('Y-m-d H:i:s');
                $ativo = filter_var($_POST['ativo'], FILTER_SANITIZE_STRING);
                //EDEREÇO DO FUNCINÁRIO
                $endereco = filter_var($_POST["endereco"], FILTER_SANITIZE_STRING); 
                $cep = filter_var($_POST["cep"], FILTER_SANITIZE_STRING);
                $cep = str_replace("-","", $cep);
                $numero = filter_var($_POST["numero"], FILTER_SANITIZE_NUMBER_INT);
                $complemento = filter_var($_POST["complemento"], FILTER_SANITIZE_STRING);
                $bairro = filter_var($_POST["bairro"], FILTER_SANITIZE_STRING);
                $cidade = filter_var($_POST["cidade"], FILTER_SANITIZE_STRING);
                $estado = filter_var($_POST["estado"], FILTER_SANITIZE_STRING);
                $idfuncionario = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
                //VALIDANDO CADASTROS
                $verFunc = "SELECT * FROM funcionario WHERE (cpf = '".$cpf."' OR rg = '".$rg."' OR matricula = '".$matricula."') AND idfuncionario != '".$idfuncionario."'";
                $queryFunc = mysql_query($verFunc, $con);
                $rowsFunc = mysql_num_rows($queryFunc);
                $verLogin = "SELECT * FROM login WHERE (login = '".$login."' OR email = '".$email."') AND idfuncionario != '".$idfuncionario."'";
                $queryLogin = mysql_query($verLogin, $con);
                $rowsLogin = mysql_num_rows($queryLogin);
                if(!$rowsFunc && !$rowsLogin){
                    // realiza o insert do funcionário -- falta add nomeindicacao, idcartaobeneficio
                    $sqlFunc = "
                        UPDATE funcionario SET
                            nome = '" . $nomee . "', cpf = '" . $cpf . "', rg = '" . $rg . "', dtnasc = '" . $dtnasc . "', estadocivil = '" . $estadocivil . "', 
                            sexo = '" . $sexo . "', telefone = '" . $telefone . "', email = '" . $email . "', statusfuncionario = '" . $ativo . "', nomeescala = '" . $nomeescala . "', 
                            numerodepe = '" . $numerodepe . "', portearma = '" . $portearma . "', nomemae =  '" . $nomemae . "', fumante = '" . $fumante . "', 
                            indicacao = '" . $indicacao . "', nomeindicacao =  '" . $nomeindicacao . "', matricula = '" . $matricula . "', datacadastro = '" . $dt . "', idativextra = '" . $idativextra . "',
                            idpostograduacao = '" . $idpostograduacao . "', idsetorfuncao = '" . $idsetorfuncao . "', idcartaobeneficio = '" . $idcartaobeneficio . "'
                            WHERE idfuncionario = '".$idfuncionario."'
                            ";
                    
                    //pode cadastrar o endereço e login
                    if(mysql_query($sqlFunc, $con)){
                        $idfuncionario = mysql_insert_id();
                        //LOGIN
                        $sqlLogin = "UPDATE login SET login = '" . $login . "', senha = '" . $senha . "', idfuncionario = '" . $idfuncionario . "', ativo = 's' WHERE idfuncionario = '".$idfuncionario."'";
                        $queryLogin = mysql_query($sqlLogin, $con);
                        //ENDEREÇO
                        $sqlEnd = "
                            UPDATE enderecofuncionario SET 
                                cep = '" . $cep . "', logradouro = '" . $endereco . "', bairro ='" . $bairro . "', municipio = '" . $cidade . "', 
                                estado = '" . $estado . "', numerocasa = '" . $numero . "', complemento = '" . $complemento . "', idfuncionario = '" . $idfuncionario . "'
                                WHERE idfuncionario = '".$idfuncionario."'
                                ";                                  
                        $queryEnd = mysql_query($sqlEnd, $con);
                        if(!$queryLogin && !$queryEnd){
                            //erro ao cadastrar login e endereço
                            $msg = "Erro ao editar login e endereço do funcionário. Por favor, entre em contato com o suporte do sistema!";
                            header("location:./inf?msg=" . $msg);    
                        } else if(!$queryLogin || !$queryEnd){
                            if(!$queryLogin){
                                //erro ao cadastrar login
                                $msg = "Erro ao editar login do funcionário. Por favor, entre em contato com o suporte do sistema!";
                                header("location:./inf?msg=" . $msg);
                            } 
                                
                            if(!$queryEnd){
                                //erro ao cadastrar endereço
                                //$msg = mysql_error($con);
                                $msg = "Erro ao editar endereço do funcionário. Por favor, entre em contato com o suporte do sistema!";
                                header("location:./inf?msg=" . $msg);
                            }
                        } else {
                            include '../PHPMailer/class.phpmailer.php';           
                            $emailRemetente = "naoresponder@sizeof.com.br";
                            $nome = "Sarton";
                            $assunto = utf8_decode("Edição de Cadastro - Sarton");
                            $corpo = nl2br("

                                Olá {$nomee}, informamos que seu cadastro foi editado na Sarton!

                                ----------------------------------------------------
                                Segue seus dados de acesso:

                                Login: <b>{$login}</b>
                                senha: <b>{$password}</b>    

                                Link: <a href='https://sizeoff.com.br/clientes/Sarton/login/' target='_blank'>Acessar minha conta</a>
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
                                            <title>Cadastro Editado</title>
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
                                //Funcionário Cadastrado com sucesso
                                $msg = "Funcionário editado com sucesso!";
                                header("location:./inf?msg=" . $msg);
                            } else {
                                //echo 'Erro do PHPMailer: ' . $PHPMailer->ErrorInfo;
                                $msg = "Funcionário editado com sucesso! Porém, ocorreu um erro ao enviar email com os dados de acesso!";
                                header("location:./inf?msg=" . $msg);
                            }
                        }
                   
                    } else {
                        //erro no cadastro do funcionário
                        //$msg = mysql_error($con);
                        $msg = "Erro ao cadastrar Funcionário. Por favor, entre em contato com o suporte do sistema!";
                        header("location:./inf?msg=" . $msg);
                    }
                
                } else {
                    //informa que esse cadastro já existe
                    flash("mensagem", "Esse cadastro já existe no nosso sistema. Por favor, verifique nos cadastros!", "danger");
                    header("location:bFuncionario");
                }                      
            } else{
                //mensagem "n deixe nenhum campo em branco"
                flash("mensagem", "Por favor, não deixe nenhum campo em branco", "danger");
                header("location:bFuncionario");
            }
        }
    } else {
        //requisição não é via post
        header("location: ambiente");
    }







