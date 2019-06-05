<?php
    include_once '../config/conn.php'; //Arquivo de Conexão
    include_once "../config/flash.php"; //função de flash mensagens
    

    if($_SERVER['REQUEST_METHOD'] == 'POST'){ //se tiver feito requisição via post
          
            //verificando se post tá vazio:

            #guardando dentro de um array os names dos posts q n podem ficar em banco
            $post = array(
                "nomeservico", "valor"
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
                
                //NOME COMPLETO
                $nome = filter_var($_POST["nomeservico"], FILTER_SANITIZE_STRING); //Filtro pra SQL Injection
                $nome = ucwords(strtolower(htmlentities($nome))); //tratamento

                //VALOR
                $valor = filter_var($_POST['valor'], FILTER_SANITIZE_STRING);

                //VALIDANDO CADASTROS
                $verServicos = "SELECT * FROM servicos WHERE nome = '".$nome."'";
                $queryServicos = mysql_query($verServicos, $con);
                $rowsServicos = mysql_num_rows($queryServicos);
                if(!$rowsServicos){
                    // realiza o insert do Servico
                    $sqlServicos = "
                        INSERT INTO servicos (
                            nomeservico, valor
                        ) VALUES(
                            '" . $nome . "',
                            '" . $valor . "'
                        )";

                    if(mysql_query($sqlServicos, $con)){
                        $msg = "Serviço cadastrado com sucesso!";
                        header("location:./inf?msg=" . $msg);
                    } else {
                        //erro no cadastro do funcionário
                        //$msg = mysql_error($con);
                        $msg = "Erro ao cadastrar Serviço. Por favor, entre em contato com o suporte do sistema!";
                        header("location:./inf?msg=" . $msg);
                    }
                
                } else {
                    //informa que esse cadastro já existe
                    flash("mensagem", "Esse Serviço já existe no nosso sistema. Por favor, verifique nos cadastros!", "danger");
                    header("location:cServico");
                }    
                                    
            } else{
                //mensagem "n deixe nenhum campo em branco"
                flash("mensagem", "Por favor, não deixe nenhum campo em branco", "danger");
                header("location:cServico");
            }                             
                  
    } else {
        //requisição não é via post
        header("location: ambiente");
    }







