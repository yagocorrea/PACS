<?php
    include_once '../config/conn.php'; //Arquivo de Conexão
    include_once "../config/flash.php"; //função de flash mensagens
    

    if($_SERVER['REQUEST_METHOD'] == 'POST'){ //se tiver feito requisição via post
          
            //verificando se post tá vazio:

            #guardando dentro de um array os names dos posts q n podem ficar em banco
            $post = array(
                "nomeproduto", "marca", "valorbase", "validade", "tempodeusocliente"
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
                $nome = filter_var($_POST["nomeproduto"], FILTER_SANITIZE_STRING); //Filtro pra SQL Injection
                $nome = ucwords(strtolower(htmlentities($nome))); //tratamento

                //MARCA
                $marca = filter_var($_POST['marca'], FILTER_SANITIZE_STRING);
                
                //VALOR BASE
                $valorbase = filter_var($_POST['valorbase'], FILTER_SANITIZE_STRING);
               
                //VALIDADE
                $validade = filter_var($_POST['validade'], FILTER_VALIDATE_EMAIL);

                //TEMPO DE USO
                $tempodeuso = filter_var($_POST["tempodeusocliente"], FILTER_SANITIZE_STRING); 

                //VALIDANDO CADASTROS
                $verProduto = "SELECT * FROM produtos WHERE nome = '".$nome."'";
                $queryProduto = mysql_query($verProduto, $con);
                $rowsProduto = mysql_num_rows($queryProduto);
                if(!$rowsProduto){
                    // realiza o insert do Produto
                    $sqlProduto = "
                        INSERT INTO produtos (
                            nomeproduto, marca, valorbase, validade, tempodeusocliente
                        ) VALUES(
                            '" . $nomeproduto . "',
                            '" . $marca . "',
                            '" . $valorbase . "',
                            '" . $validade . "',
                            '" . $tempodeuso . "'
                        )";
                    
                    //realiza insert do login
                    if(mysql_query($sqlProduto, $con)){
                        $msg = "Produto cadastrado com sucesso!";
                        header("location:./inf?msg=" . $msg);
                    } else {
                        //erro no cadastro do funcionário
                        //$msg = mysql_error($con);
                        $msg = "Erro ao cadastrar Produto. Por favor, entre em contato com o suporte do sistema!";
                        header("location:./inf?msg=" . $msg);
                    }
                
                } else {
                    //informa que esse cadastro já existe
                    flash("mensagem", "Esse Produto já existe no nosso sistema. Por favor, verifique nos cadastros!", "danger");
                    header("location:cProduto");
                }                        
            } else{
                //mensagem "n deixe nenhum campo em branco"
                flash("mensagem", "Por favor, não deixe nenhum campo em branco", "danger");
                header("location:cProduto");
            }                             
                  
        
    } else {
        //requisição não é via post
        header("location: ambiente");
    }







