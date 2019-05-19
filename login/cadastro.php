<?php include_once 'const.php'; ?>
<!doctype html>
<html lang="en">

    <head>
        <title><?= TITLE ?></title>
        <meta charset="utf-8">
        <link rel="icon" href="<?= BASE_ICO ?>" type="image/x-icon">        
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

        <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/vendor/animate-css/animate.min.css">
        <link rel="stylesheet" href="../assets/vendor/font-awesome/css/font-awesome.min.css">

        <link rel="stylesheet" href="assets/css/estilo.css">
		<link rel="stylesheet" href="assets/css/main.css">
        <link rel="stylesheet" href="assets/css/color_skins.css">

        <script type="text/javascript">
            window.onload = function () {
                document.getElementById("login").onkeyup = function () {
                    this.value = this.value.replace(/[^\w\.]|\d/g, '');
                };
            }
        </script>
        <style>
            .checkbox{display: flex; flex-direction: row; justify-content: center; align-items: center; margin-bottom: 10px;}
            .logo{position: relative; top: 150px;}
            .img-fluid{height: auto !important;}
            .auth-box{height: 500px !important;}
            .auth-right{top: 10%;}
            .left-slider{margin: auto; padding-left: 25%;}
        </style>                       
    </head>
<body class="theme-blue">
        <!-- WRAPPER -->
        <div id="wrapper">
            <div class="vertical-align-wrap">
                <div class="vertical-align-middle auth-main">
                    <div class="auth-box">
                        <div class="mobile-logo">
                            <a href="<?= INDEX ?>">
                                <div style="color: #fff; font-size: 20px">
                                    <span><?= NOME_EMPRESA ?></span>
                                </div>
                            </a>
                        </div>
                        <div class="auth-left">
                           
                            <div class="left-slider">
                                <div class="logo">
                                    <img src="../assets/images/login/1.jpg" class="img-fluid" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="auth-right">
                            <div class="card">
                                <div class="header">
                                    <p class="lead display-3">Olá, vamos começar o cadastro</p>
                                    <br>
                                </div>
                            <div class="body">
                                <form class="form-auth-small">
                                    <div class="form-group">
                                        <label for="nome" class="control-label sr-only">Nome Completo</label>
                                        <input type="text" name="nome" class="form-control" id="nome" placeholder="*Nome Completo" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="control-label sr-only">Email</label>
                                        <input type="text" class="form-control envelope-o" name="email" placeholder="*Email" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="login" class="control-label sr-only">Login</label>
                                        <input type="text" name="login" class="form-control" id="login" placeholder="*Login" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="senha" class="control-label sr-only">Senha</label>
                                        <input type="senha"  name="senha" class="form-control" placeholder="*Senha" required >
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-lg btn-block">CADASTRE-SE</button>
                                    <div class="bottom">
                                        <span class="helper-text">
                                            <?php
                                            if (!empty($_GET["msg"])) {
                                                $msg = $_GET["msg"];
                                                echo "<br><h6 style='color: tomato'>" . $msg . "<br> </h6>";
                                            }
                                            ?> 
                                            Já é cadastrado? <a href="index">Clique aqui</a>
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
     <!-- Javascript -->
     <script src="<?= URLPADRAO ?>/assets/bundles/libscripts.bundle.js"></script>    
        <script src="<?= URLPADRAO ?>/assets/bundles/vendorscripts.bundle.js"></script>
        <script src="<?= URLCSSJS ?>/assets/vendor/jquery-validation/jquery.validate.js"></script> 
		<!-- Jquery Validation Plugin Css -->
        <script src="<?= URLCSSJS ?>/assets/vendor/jquery-steps/jquery.steps.js"></script> 
		<!-- JQuery Steps Plugin Js -->
        <script src="<?= URLCSSJS ?>/assets/vendor/jquery.maskedinput/jquery.mask.js"></script>
        <script src="<?= URLPADRAO ?>/assets/bundles/mainscripts.bundle.js"></script>
        <script src="<?= URLPADRAO ?>/assets/js/pages/forms/form-wizard.js"></script>
		
		<script src="<?= URLCSSJS ?>/assets/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script> 
		<!-- Bootstrap Colorpicker Js --> 
		<!--<script src="<?= URLCSSJS ?>/assets/vendor/jquery-inputmask/jquery.inputmask.bundle.js"></script> -->
		<!-- Input Mask Plugin Js --> 
		<script src="<?= URLPADRAO ?>/assets/js/pages/forms/advanced-form-elements.js"></script> <!-- Mask --> 
		<script src="<?= URLCSSJS ?>/assets/vendor/multi-select/js/jquery.multi-select.js"></script> 
		<!-- Multi Select Plugin Js -->
		<script src="<?= URLCSSJS ?>/assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
		<script src="<?= URLCSSJS ?>/assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
		<script src="<?= URLCSSJS ?>/assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script> 
		<!-- Bootstrap Tags Input Plugin Js --> 
		<script src="<?= URLCSSJS ?>/assets/vendor/nouislider/nouislider.js"></script> 
		<!-- noUISlider Plugin Js --> 
		<script src="<?= URLPADRAO ?>/assets/bundles/morrisscripts.bundle.js"></script>
    <script>
        jQuery(function () {
            // Script que gera os nomes de login
			jQuery('input[name="nome"]').change(function(){
                $.ajax({
                    url:"gGerarLogin.php ",
                    type:"POST",
                    data: {nome: $("#nome").val()}, //Como não está enviando nenhuma informação, pode deixar vazio
                    success:function(resposta){
                        $('#login').val(resposta);
                    }

                });
            });	
        });			
    </script>
</body>
</html>
