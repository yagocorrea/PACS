<?php include_once '../config/const.php'; ?>
 
<!doctype html>
<html lang="pt-br">

<head>
    <title><?= TITLE ?> - Cadastro de Administradores</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="Admin template that can be used to build dashboards for CRM, CMS, etc." />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- app favicon -->
    <link rel="shortcut icon" href="<?= BASE_ICO ?>">
    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <!-- plugin stylesheets -->
    <link rel="stylesheet" type="text/css" href="//www.reidigital.com.br/pacs/assets/css/vendors.css" />
    <!-- app style -->
    <link rel="stylesheet" type="text/css" href="//www.reidigital.com.br/pacs/assets/css/style.css" />
	<style>
	.left {
		display: flex;
		justify-content: space-between;
	}
	</style>
</head>

<body>
    <!-- begin app -->
    <div class="app">
        <!-- begin app-wrap -->
        <div class="app-wrap">
            <!-- begin pre-loader -->
            <div class="loader">
                <div class="h-100 d-flex justify-content-center">
                    <div class="align-self-center">
                        <img src="//www.reidigital.com.br/pacs/assets/img/loader/loader.svg" alt="loader">
                    </div>
                </div>
            </div>
            <!-- end pre-loader -->
            <!-- begin app-header -->
            <header class="app-header top-bar">
                <!-- begin navbar -->
                <nav class="navbar navbar-expand-md">

                    <!-- begin navbar-header -->
                    <div class="navbar-header d-flex align-items-center">
                        <a href="javascript:void:(0)" class="mobile-toggle"><i class="ti ti-align-right"></i></a>
                        <a class="navbar-brand" href="index.html">
                            <img src="//www.reidigital.com.br/pacs/assets/img/pacs-logo.png" class="img-fluid logo-desktop" alt="logo" />
                            <img src="//www.reidigital.com.br/pacs/assets/img/pacs-logo.png" class="img-fluid logo-mobile" alt="logo" />
                        </a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="ti ti-align-left"></i>
                    </button>
                    <!-- end navbar-header -->
                    <!-- begin navigation -->
                    <?php include_once "../includes/nav-topo.php" ?>
                    <!-- end navigation -->
                </nav>
                <!-- end navbar -->
            </header>
            <!-- end app-header -->
            <!-- begin app-container -->
            <div class="app-container">
                <!-- begin app-nabar -->               
                    <!-- begin sidebar-nav -->
                    <?php include_once "../includes/nav-lateral.php" ?>
                    <!-- end sidebar-nav -->                
                <!-- end app-navbar -->
                <!-- begin app-main -->
                <div class="app-main" id="main">
                    <!-- begin container-fluid -->
                    <div class="container-fluid">
                        <!-- begin row -->
                        <div class="row">
                            <div class="col-md-12 m-b-30">
                                <!-- begin page title -->
                                <div class="d-block d-lg-flex flex-nowrap align-items-center left">
                                    <div class="page-title mr-4 pr-4 border-right">
                                        <h1>Cadastro de Administradores</h1>
                                    </div>
                                    <div class="breadcrumb-bar align-items-center">
                                        <nav>
                                            <ol class="breadcrumb p-0 m-b-0">
                                                <li class="breadcrumb-item">
                                                    <a href="index.html"><i class="ti ti-home"></i></a>
                                                </li>
                                                <li class="breadcrumb-item">
                                                    Dashboard
                                                </li>
                                                <li class="breadcrumb-item active text-primary" aria-current="page">Cadastro de Administradores</li>
                                            </ol>
                                        </nav>
                                    </div>   
                                </div>
                                <!-- end page title -->
                            </div>
                        </div>
						<div class="col-md-12">
                                <div class="card card-statistics">                                   
                                    <div class="card-body">
                                        <form action="gAdministrador.php" method="POST">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label>Nome Completo</label>
                                                    <input type="text" name="nomecompleto" class="form-control" id="nomecompleto" >
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label>Login</label>
                                                    <input type="text" name="login" class="form-control" id="login">
                                                </div>
												<div class="form-group col-md-3">
													<label>Senha</label>
													<input type="password" name="senha" class="form-control" id="senha">
												</div>
												<div class="form-group col-md-6">
                                                    <label>E-mail</label>
                                                    <input type="email" name="email" class="form-control" id="email">
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <label>CPF</label>
                                                    <input type="text" name="cpf" class="form-control" id="cpf">
                                                </div>												
												<div class="form-group col-md-3">
                                                    <label>Telefone</label>
                                                    <input type="text" name="telefone" class="form-control" id="telefone">
                                                </div>
                                            </div>                                                                                      
                                            <button type="submit" class="btn btn-primary">Salvar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        
                        <!-- end row -->
                        
                    </div>
                    <!-- end container-fluid -->
                </div>
                <!-- end app-main -->
            </div>
            <!-- end app-container -->
            <!-- begin footer -->
            <?php include_once "../includes/footer.php" ?>
            <!-- end footer -->
        </div>
        <!-- end app-wrap -->
    </div>
    <!-- end app -->

    <!-- plugins -->
    <script src="//www.reidigital.com.br/pacs/assets/js/vendors.js"></script>

    <!-- custom app -->
    <script src="//www.reidigital.com.br/pacs/assets/js/app.js"></script>
</body>

</html>