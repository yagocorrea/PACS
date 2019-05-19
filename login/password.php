<?php include './const.php'; ?>
<!doctype html>
<html lang="pt-br">

    <head>
        <title>Sarton - Esqueci minha senha</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	
        <link rel="icon" href="<?= BASE_ICO ?>" type="image/x-icon">
        <!-- VENDOR CSS -->
        <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/vendor/animate-css/animate.min.css">
        <link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.min.css">

        <!-- MAIN CSS -->
        <link rel="stylesheet" href="assets/css/main.css">
		<link rel="stylesheet" href="assets/css/estilo.css">
        <link rel="stylesheet" href="assets/css/color_skins.css">
        <style>
            .checkbox{display: flex; flex-direction: row; justify-content: center; align-items: center; margin-bottom: 10px;}
            .left{margin-right: 70px;}
            .logo{position: relative; top: 17%;}
            .img-fluid{height: auto !important;}
            .auth-box{height: 343px !important;}
            .down{top: 10%}
            .disable{margin-bottom: 0px !important; margin-top: 60px;}
            #email, .btn{display: none;}
        </style>
    </head>

    <body class="theme-blue">
        <!-- WRAPPER -->
        <div id="wrapper">
            <div class="vertical-align-wrap">
                <div class="vertical-align-middle auth-main">
                    <div class="auth-box">

                        <div class="auth-left">
                            <div class="left-top">
                                <span><?= NOME_EMPRESA ?></span>
                            </div>
                            <div class="left-slider">
                                <div class="logo">
                                    <img src="../assets/images/login/1.jpg" class="img-fluid" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="auth-right down">

                            <div class="card">
                                <div class="header">
                                    <p class="lead">Recuperar senha</p>
                                </div>
                                <div class="body">
                                    <p class="troca-texto">Por favor, informe o seu email.</p>
                                    <form class="form-auth-small" method="post" action="verEsqueciSenha.php">
                                        <div class="form-group">
                    
                                            <input type="text" class="form-control" name="email" id="email" placeholder="Informe o seu email:">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-lg btn-block">ALTERAR SENHA</button>
                                        <div class="bottom">
											<span class="helper-text">
                                                <?php
                                                if (!empty($_GET["msg"])) {
                                                    $msg = $_GET["msg"];
                                                    echo "<br><h6 style='color: tomato'>" . $msg . "<br> </h6>";
                                                    
                                                } else {
                                                    echo "
                                                        <i class='fa fa-lock' style='color:#282727'></i>
                                                        Sabe a sua senha?
                                                        <a href='index'> Clique aqui</a>
                                                    ";
                                                }
                                                ?>   
                                            </span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END WRAPPER -->
        <script src="assets/bundles/libscripts.bundle.js"></script>    
        <script src="assets/bundles/vendorscripts.bundle.js"></script>
        <script src="assets/bundles/datatablescripts.bundle.js"></script> 
        <script src="assets/bundles/mainscripts.bundle.js"></script>
        <script src="assets/bundles/morrisscripts.bundle.js"></script>
        <script>
            jQuery(function () {
                    jQuery("#email").show();
                    jQuery(".btn").show();
                    jQuery(".auth-right").removeClass("down");
            });
        </script>
    </body>
</html>

