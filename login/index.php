<?php include './const.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title><?= TITLE ?></title>
    <!-- app favicon -->
    <link rel="shortcut icon" href="<?= BASE_ICO ?>">
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <!-- plugin stylesheets -->
    <link rel="stylesheet" type="text/css" href="<?= URLCSSJS ?>/assets/css/vendors.css" />
    <!-- app style -->
    <link rel="stylesheet" type="text/css" href="<?= URLCSSJS ?>/assets/css/style.css" />
</head>

<body class="bg-white">
    <!-- begin app -->
    <div class="app">
        <!-- begin app-wrap -->
        <div class="app-wrap">
            <!-- begin pre-loader -->
            <div class="loader">
                <div class="h-100 d-flex justify-content-center">
                    <div class="align-self-center">
                        <img src="<?= URLCSSJS ?>/assets/img/loader/loader.svg" alt="loader">
                    </div>
                </div>
            </div>
            <!-- end pre-loader -->

            <!--start login contant-->
            <div class="app-contant">
                <div class="bg-white">
                    <div class="container-fluid p-0">
                        <div class="row no-gutters">
                            <div class="col-sm-6 col-lg-5 col-xxl-3  align-self-center order-2 order-sm-1">
                                <div class="d-flex align-items-center h-100-vh">
                                    <div class="login p-50">
                                        <div class="logo">
											<img src="../assets/img/pacs-logo.png" class="img-fluid" alt="">
										</div>
                                        <form method="post" action="verLogin.php" class="mt-3 mt-sm-5">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Login*</label>
                                                        <input type="text" name="login" class="form-control" />
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Senha*</label>
                                                        <input type="password" name="pass" class="form-control" />
                                                    </div>
                                                </div>                                              
                                                <div class="col-12 mt-3">
													<button type="submit" class="btn btn-primary text-uppercase">Acessar</button>
													 <div class="col-12 mt-3">
														<?php
															if (!empty($_GET["msg"])) {
																$msg = $_GET["msg"];
																echo "<br><h6 style='color: tomato'>" . $msg . "<br> </h6>";
															}
														?>
													</div>
												</div>
                                                <div class="col-12 mt-3">
													<div class="d-block d-sm-flex  align-items-center">
														<p>Não tem uma conta?<a href="cadastro.php"> Inscreva-se</a></p>
                                                        <a href="javascript:void(0);" class="ml-auto">Esqueceu sua senha?</a>
                                                    </div>                                    
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xxl-9 col-lg-7 bg-gradient o-hidden order-1 order-sm-2">
                                <div class="row align-items-center h-100">
                                    <div class="col-7 mx-auto ">
                                        <img class="img-fluid" src="<?= URLCSSJS ?>/assets/img/bg/login.svg" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end login contant-->
        </div>
        <!-- end app-wrap -->
    </div>
    <!-- end app -->



    <!-- plugins -->
    <script src="<?= URLCSSJS ?>/assets/js/vendors.js"></script>

    <!-- custom app -->
    <script src="<?= URLCSSJS ?>/assets/js/app.js"></script>
</body>



</html>