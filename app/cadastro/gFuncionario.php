<?php
    include_once '../config/conn.php'; //Arquivo de Conexão
    include_once "../config/flash.php"; //função de flash mensagens
    

    if($_SERVER['REQUEST_METHOD'] == 'POST'){ //se tiver feito requisição via post
          
            //verificando se post tá vazio:

            #guardando dentro de um array os names dos posts q n podem ficar em banco
            $post = array(
                "nomecompleto", "login", "senha", "email", "cpf", "funcao", "telefone"
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
                # 1 - n deixar repetir cpf
                
                //NOME COMPLETO
                $nome = filter_var($_POST["nomecompleto"], FILTER_SANITIZE_STRING); //Filtro pra SQL Injection
                $nome = ucwords(strtolower(htmlentities($nome))); //tratamento

                //LOGIN
                $login = filter_var($_POST['login'], FILTER_SANITIZE_STRING);
                
                //SENHA
                $senha = filter_var($_POST['senha'], FILTER_SANITIZE_STRING);
                $password = $senha; //sem criptografia
                //$senha = md5($senha);
               
                //EMAIL
                $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
                
                #CPF --- Chamar Função de Validação em Validate.php
                $cpf = filter_var($_POST["cpf"], FILTER_SANITIZE_STRING); //Filtro pra SQL Injection
                $cpf = str_replace('.', '', $cpf); //tratamento
                $cpf = str_replace('-', '', $cpf); //tratamento
                
                //TELEFONE
                $telefone = filter_var($_POST["telefone"], FILTER_SANITIZE_STRING);//Filtro pra SQL Injection
                $telefone = str_replace('(', '', $telefone); //tratamento
                $telefone = str_replace(')', '', $telefone); //tratamento

                //FUNÇÃO
                $funcao = filter_var($_POST["funcao"], FILTER_SANITIZE_STRING); 

                //VALIDANDO CADASTROS
                $verFuncionario = "SELECT * FROM funcionarios WHERE cpf = '".$cpf."'";
                $queryFuncionario = mysql_query($verFuncionario, $con);
                $rowsFuncionarios = mysql_num_rows($queryFuncionario);
                $verLogin = "SELECT * login WHERE login ='".$login." OR email = '".$email."'";
                $queryLogin = mysql_query($verLogin, $con);
                $rowsLogin = mysql_num_rows($queryLogin);
                if(!$rowsFuncionarios && !$rowsLogin){
                    // realiza o insert do Funcionário
                    $sqlFuncionario = "
                        INSERT INTO funcionarios (
                            nomecompleto, cpf, telefone, email
                        ) VALUES(
                            '" . $nome . "',
                            '" . $cpf . "',
                            '" . $telefone . "',
                            '" . $email . "'
                        )";
                    
                    //realiza insert do login
                    if(mysql_query($sqlFuncionario, $con)){
                        $idfuncionarios = mysql_insert_id();
                            
                            //LOGIN
                            $sqlLogin = "
                                INSERT INTO login (
                                    login, senha, status, idfuncionarios
                                ) VALUES (
                                    '" . $login . "',
                                    '" . $password . "',
                                    'ativo',
                                    '" . $idfuncionarios . "'
                                )";
                            $queryLogin = mysql_query($sqlLogin, $con);
                            
                            //FUNÇÃO
                            $sqlFuncao = "
                                INSERT INTO funcaofuncionario (
                                    nomefuncao, idfuncionarios
                                ) VALUES (
                                    '" . $funcao . "',
                                    '" . $idfuncionarios . "'
                                )";                               
                                
                            $queryFuncao = mysql_query($sqlFuncao, $con);
                            if(!$queryLogin && !$queryFuncao){
                                //erro ao cadastrar login e função
                                $msg = "Erro ao cadastrar login e função do Funcionário. Por favor, entre em contato com o suporte do sistema!";
                                header("location:./inf?msg=" . $msg);
                                
                            } else if(!$queryLogin || !$queryFuncao){
                                if(!$queryLogin){
                                    //erro ao cadastrar login
                                    $msg = "Erro ao cadastrar login do Funcionário. Por favor, entre em contato com o suporte do sistema!";
                                    header("location:./inf?msg=" . $msg);
                                } 
                                
                                if(!$queryFuncao){
                                    //erro ao cadastrar função
                                    //$msg = mysql_error($con);
                                    $msg = "Erro ao cadastrar função do Funcionário. Por favor, entre em contato com o suporte do sistema!";
                                    header("location:./inf?msg=" . $msg);
                                }
                            } else {
                                $msg = "Funcionário cadastrado com sucesso!";
                                header("location:./inf?msg=" . $msg);
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
                  
        
    } else {
        //requisição não é via post
        header("location: ambiente");
    }







