<?php
  require('../php/connect.php');

  if(!isset($_SESSION)) session_start();

  if(!isset($_SESSION['usr_id'])) header('Location: index.php');

  if($_SESSION['sts_cli'] != '1') header('Location: index.php');

  if(isset($_POST['submit'])){
		$nomeComp = $_POST['nameComp'];
        $cnpjComp = $_POST['cnpjComp'];
        $telComp = $_POST['telComp'];
        $emailComp = $_POST['emailComp'];

		if(!preg_match("/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/", $emailComp)){
			$_SESSION['cad_error'] = 4;
		} else if(!preg_match("/^[a-zA-Z ]*$/", $nomeComp)){
			$_SESSION['cad_error'] = 5;
		} else {
			$sqlRegisterComp = "SELECT _idCompany 
            FROM tbcompanies 
            WHERE companyName = '$nomeComp' OR cnpj = '$cnpjComp'";
			$resultRegisterComp = mysqli_query($con, $sqlRegisterComp) or die(mysqli_error($con));
			$resultRegisterComp = mysqli_fetch_array($resultRegisterComp);

			if(isset($resultRegisterComp['_idCompany'])) $_SESSION['cad_error'] = 1;
			else {
                $sqlInsertComp = "INSERT INTO `tbcompanies`(`companyName`, `cnpj`, `telephone`, `email`) VALUES('$nomeComp', '$cnpjComp', '$telComp', '$emailComp');";
                $resultInsertComp = mysqli_query($con, $sqlInsertComp) or die(mysqli_error($con));
			}
		}
	}
  
?>

<!--

=========================================================
* Argon Dashboard - v1.1.0
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard
* Copyright 2019 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://github.com/creativetimofficial/argon-dashboard/blob/master/LICENSE.md)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->
<!DOCTYPE html>
<html lang="en">

<head>
  <title><?= $title = "Registro de companias";?></title>
  <?php include("../templates/head.html") ?>
</head>

<body class="bg-default">
  <div class="main-content">
    <!-- Navbar -->
    <nav class="navbar navbar-top navbar-horizontal navbar-expand-md navbar-dark">
    <div class="container px-4">
      <a class="navbar-brand" href="index.php">
        <img src="../assets/img/brand/white.png" />
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse-main" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbar-collapse-main">
        <!-- Collapse header -->
        <div class="navbar-collapse-header d-md-none">
          <div class="row">
            <div class="col-6 collapse-brand">
              <a href="../index.html">
                <img src="../assets/img/brand/blue.png">
              </a>
            </div>
            <div class="col-6 collapse-close">
              <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                <span></span>
                <span></span>
              </button>
            </div>
          </div>
        </div>
        <!-- Navbar items -->
        <?php if(!isset($_SESSION['usr_id'])) : ?>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link nav-link-icon" href="register.php">
                    <i class="ni ni-circle-08"></i>
                    <span class="nav-link-inner--text">Registrar</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-icon" href="login.php">
                    <i class="ni ni-key-25"></i>
                    <span class="nav-link-inner--text">Login</span>
                    </a>
                </li>
            </ul>
        <?php endif ?>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
              <a class="nav-link nav-link-icon" href="index.php">
              <i class="ni ni-world"></i>
              <span class="nav-link-inner--text">Página inicial</span>
              </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
    <!-- Header -->
    <div class="header bg-gradient-primary py-7 py-lg-8">
      <div class="container">
        <div class="header-body text-center mb-7">
          <div class="row justify-content-center">
            <div class="col-lg-5 col-md-6">
              <h1 class="text-white">Bem-vindo!</h1>
              <p class="text-lead text-light">Registro de companias</p>
            </div>
          </div>
        </div>
      </div>
      <div class="separator separator-bottom separator-skew zindex-100">
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1" xmlns="http://www.w3.org/2000/svg">
          <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </div>
    <!-- Page content -->
    <div class="container mt--8 pb-5">
    <?php
        if(isset($_SESSION['cad_error'])) :
          switch($_SESSION['cad_error']){
            case 1:
              $text = 'Nome ou CNPJ já utilizado';
              break;
            case 2:
              $text = 'Senhas não coincidem';
              break;
            case 3:
              $text = "Senha deve conter de 8 a 32 caracteres, podendo ser letras, números ou \"!@#$%\"";
              break;
            case 4:
              $text = "Email inválido";
              break;
            case 5:
              $text = "Nome e sobrenome devem conter apenas letras e espaço em branco";
              break;
            default:
              $text = "Erro";
              break;
          }
      ?>
        <script>
          Swal.fire({
            icon: 'error',
            title: '<?= $text ?>',
            confirmButtonText: 'Fechar'
          })
        </script>
      <?php
        endif;

        if(!isset($_SESSION['cad_error']) && isset($_POST['submit'])) :
      ?>

      <script>
        Swal.fire({
          icon: 'success',
          title: 'Cadastro da empresa feito com sucesso!',
          text: 'Um link para autenticação será enviado para o email cadastrado',
          confirmButtonText: 'Cadastrar funcionários!',
          onClose: () => {
                window.location.href = 'register.php';
            }
        })
      </script>

      <?php
        endif; 
        $_SESSION['cad_error'] = NULL; 
      ?>

      <!-- Table -->
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
          <div class="card bg-secondary shadow border-0">
            <div class="card-header bg-transparent pb-5">
              <div class="text-muted text-center mt-2 mb-4"><small>Dados da empresa</small></div>
              <form action="#" method="POST">
                <div class="form-group">
                  <div class="input-group input-group-alternative mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-circle-08"></i></span>
                    </div>
                    <input name="nameComp" class="form-control" placeholder="Nome da empresa" type="text">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-alternative mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-badge"></i></span>
                    </div>
                    <input name="cnpjComp" id="cnpj" class="form-control" data-mask="00.000.000/0000-00" placeholder="CNPJ" type="text">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-alternative mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-mobile-button"></i></span>
                    </div>
                    <input name="telComp" class="form-control" data-mask="(00) 0 0000-0000" placeholder="Celular" type="text">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-alternative mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                    </div>
                    <input name="emailComp" class="form-control" placeholder="Email" type="email">
                  </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary mt-4" name="submit">Cadastrar empresa</button>
                </div>
                <!-- <div class="text-muted font-italic"><small>password strength: <span class="text-success font-weight-700">strong</span></small></div> -->
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Footer -->
  <footer class="py-5">
    <div class="container">
      <div class="row align-items-center justify-content-xl-between">
        <div class="col-xl-6">
          <div class="copyright text-center text-xl-left text-muted">
            &copy; 2018 <a href="https://www.creative-tim.com" class="font-weight-bold ml-1" target="_blank">Creative Tim</a>
          </div>
        </div>
        <div class="col-xl-6">
          <ul class="nav nav-footer justify-content-center justify-content-xl-end">
            <li class="nav-item">
              <a href="https://www.creative-tim.com" class="nav-link" target="_blank">Creative Tim</a>
            </li>
            <li class="nav-item">
              <a href="https://www.creative-tim.com/presentation" class="nav-link" target="_blank">About Us</a>
            </li>
            <li class="nav-item">
              <a href="http://blog.creative-tim.com" class="nav-link" target="_blank">Blog</a>
            </li>
            <li class="nav-item">
              <a href="https://github.com/creativetimofficial/argon-dashboard/blob/master/LICENSE.md" class="nav-link" target="_blank">MIT License</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
  </div>
  <!--   Core   -->
  <?php include("../templates/loadScripts.html")?>
  
</body>

</html>