<?php
    include_once '../config/conn.php'; //Arquivo de Conexão
    include_once "../config/flash.php"; //função de flash mensagens
    

    if($_SERVER['REQUEST_METHOD'] == 'POST'){ //se tiver feito requisição via post
          
            //verificando se post tá vazio:

            #guardando dentro de um array os names dos posts q n podem ficar em banco
            $post = array(
                "nomecompleto", "login", "senha", "email", "cpf", "telefone", "cep", "logradouro", "numero",
                "complemento", "bairro", "municipio", "estado"
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
                # 1 - n deixar repetir rg, cpf
                
                //NOME COMPLETO
                $nome = filter_var($_POST["nomecompleto"], FILTER_SANITIZE_STRING); //Filtro pra SQL Injection
                $nome = ucwords(strtolower(htmlentities($nome))); //tratamento

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
                
                //TELEFONE
                $telefone = filter_var($_POST["telefone"], FILTER_SANITIZE_STRING);//Filtro pra SQL Injection
                $telefone = str_replace('(', '', $telefone); //tratamento
                $telefone = str_replace(')', '', $telefone); //tratamento

                //ENDEREÇO
                $logradouro = filter_var($_POST["logradouro"], FILTER_SANITIZE_STRING); 
                $cep = filter_var($_POST["cep"], FILTER_SANITIZE_STRING);
                $cep = str_replace("-","", $cep);
                $numero = filter_var($_POST["numero"], FILTER_SANITIZE_NUMBER_INT);
                $complemento = filter_var($_POST["complemento"], FILTER_SANITIZE_STRING);
                $bairro = filter_var($_POST["bairro"], FILTER_SANITIZE_STRING);
                $municipio = filter_var($_POST["municipio"], FILTER_SANITIZE_STRING);
                $estado = filter_var($_POST["estado"], FILTER_SANITIZE_STRING);

                //VALIDANDO CADASTROS
                $verCliente = "SELECT * FROM clientes WHERE cpf = '".$cpf."'";
                $queryCliente = mysql_query($verCliente, $con);
                $rowsCliente = mysql_num_rows($queryCliente);
                $verLogin = "SELECT * login WHERE login ='".$login." OR email = '".$email."'";
                $queryLogin = mysql_query($verLogin, $con);
                $rowsLogin = mysql_num_rows($queryLogin);
                if(!$rowsCliente && !$rowsLogin){
                    // realiza o insert do Cliente
                    $sqlCliente = "
                        INSERT INTO clientes (
                            nomecompleto, cpf, telefone, email
                        ) VALUES(
                            '" . $nome . "',
                            '" . $cpf . "',
                            '" . $telefone . "',
                            '" . $email . "'
                        )";
                    
                    //realiza insert do login
                    if(mysql_query($sqlCliente, $con)){
                        $idclientes = mysql_insert_id();
                        
                        //VALIDANDO ENDEREÇO
                        $verEnd = "SELECT * FROM endereco WHERE idclientes = '".$idclientes."'";                       
                        $end = mysql_query($verEnd, $con);
                        if(!mysql_num_rows($end)){
                            //pode cadastrar o endereço e login
                            //pode inserir login
                            $sqlLogin = "
                                INSERT INTO login (
                                    login, senha, status, idclientes
                                ) VALUES (
                                    '" . $login . "',
                                    '" . $senha . "',
                                    'ativo',
                                    '" . $idclientes . "'
                                )";
                            $queryLogin = mysql_query($sqlLogin, $con);
                            //ENDEREÇO
                            $sqlEnd = "
                                INSERT INTO endereco (
                                    cep, logradouro, bairro, municipio, estado, numerocasa, complemento, idclientes
                                ) VALUES (
                                    '" . $cep . "',
                                    '" . $logradouro . "',
                                    '" . $bairro . "',
                                    '" . $municipio . "',
                                    '" . $estado . "',
                                    '" . $numero . "',
                                    '" . $complemento . "',
                                    '" . $idclientes . "'
                                )";                               
                                
                            $queryEnd = mysql_query($sqlEnd, $con);
                            if(!$queryLogin && !$queryEnd){
                                //erro ao cadastrar login e endereço
                                $msg = "Erro ao cadastrar login e endereço do Cliente. Por favor, entre em contato com o suporte do sistema!";
                                header("location:./inf?msg=" . $msg);
                                
                            } else if(!$queryLogin || !$queryEnd){
                                if(!$queryLogin){
                                    //erro ao cadastrar login
                                    $msg = "Erro ao cadastrar login do Cliente. Por favor, entre em contato com o suporte do sistema!";
                                    header("location:./inf?msg=" . $msg);
                                } 
                                
                                if(!$queryEnd){
                                    //erro ao cadastrar endereço
                                    //$msg = mysql_error($con);
                                    $msg = "Erro ao cadastrar endereço do Cliente. Por favor, entre em contato com o suporte do sistema!";
                                    header("location:./inf?msg=" . $msg);
                                }
                            } else {
                                $msg = "Cliente cadastrado com sucesso!";
                                header("location:./inf?msg=" . $msg);
                            }
                        } else {
                            //esse endereço já existe
                            //informa que esse cadastro já existe
                            flash("mensagem", "Esse endereço já existe no nosso sistema. Por favor, verifique nos cadastros!", "danger");
                            header("location:cCliente");
                        }
                    } else {
                        //erro no cadastro do Cliente
                        //$msg = mysql_error($con);
                        $msg = "Erro ao cadastrar Cliente. Por favor, entre em contato com o suporte do sistema!";
                        header("location:./inf?msg=" . $msg);
                    }
                
                } else {
                    //informa que esse cadastro já existe
                    flash("mensagem", "Esse cadastro já existe no nosso sistema. Por favor, verifique nos cadastros!", "danger");
                    header("location:cCliente");
                }                        
            } else{
                //mensagem "n deixe nenhum campo em branco"
                flash("mensagem", "Por favor, não deixe nenhum campo em branco", "danger");
                header("location:cCliente");
            }                             
                  
        
    } else {
        //requisição não é via post
        header("location: ambiente");
    }







