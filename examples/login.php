<?php
  require('../php/connect.php');

  if(!isset($_SESSION)) session_start();

  if(isset($_SESSION['usr_id'])){
		header('Location: index.php');
	} else {
		if(isset($_POST['submit'])){
			$username = mysqli_real_escape_string($con, $_POST['username']);
			$senha = mysqli_real_escape_string($con, $_POST['pw']);
			$senha = md5($senha);

			$sqlLogin = "SELECT user, ur.name, u._iduser, u.email, ur._iduserrole 
                  FROM tbusers AS u 
                  INNER JOIN tbastuser_roles AS r ON u._idUser = r._idUser 
                  INNER JOIN tbuserroles AS ur ON ur._idUserRole = r._idUserRole 
                  WHERE user = '$username' AND password = '$senha';";
			$resultLogin = mysqli_query($con, $sqlLogin);
			$linha = mysqli_fetch_array($resultLogin);

			if(isset($linha['_iduser'])){
				$_SESSION['usr_id'] = $linha['_iduser'];
				$_SESSION['sts_cli'] = $linha['_iduserrole'];
				header('Location: index.php');
			} else $_SESSION['login_error'] = 1;
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

  <title><?= $title = "Login" ?></title>

  <?php include("../templates/head.html")?>
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
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link nav-link-icon" href="register.php">
                <i class="ni ni-circle-08"></i>
                <span class="nav-link-inner--text">Register</span>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link nav-link-icon" href="../examples/login.html">
                <i class="ni ni-key-25"></i>
                <span class="nav-link-inner--text">Login</span>
              </a>
            </li> -->
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
              <p class="text-lead text-light">Entre no nosso sistema para blablabla</p>
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
      <div class="row justify-content-center">
        <div class="col-lg-5 col-md-7">
          <div class="card bg-secondary shadow border-0">
            <div class="card-header bg-transparent pb-5">
              <div class="text-muted text-center mt-2 mb-3"><small>Entrar com</small></div>
              <div class="btn-wrapper text-center">
                <a href="#" class="btn btn-neutral btn-icon">
                  <span class="btn-inner--icon"><img src="../assets/img/icons/common/github.svg"></span>
                  <span class="btn-inner--text">Github</span>
                </a>
                <a href="#" class="btn btn-neutral btn-icon">
                  <span class="btn-inner--icon"><img src="../assets/img/icons/common/google.svg"></span>
                  <span class="btn-inner--text">Google</span>
                </a>
              </div>
            </div>
            <div class="card-body px-lg-5 py-lg-5">
              <div class="text-center text-muted mb-4">
                <small>Ou entre com seus dados</small>
              </div>
              <?php
                if(isset($_SESSION['login_error'])) :
                  switch($_SESSION['login_error']){
                    case 1:
                      $text = 'Email e/ou senha incorreta';
                      break;
                    default:
                      $text = "Erro";
                      break;
                  }
              ?>
                <script>
                  $("document").ready(function(){
                    swal({
                      title: '<?= $text ?>',
                      type: 'error',
                      confirmButtonText: 'Fechar'
                    });
                  });
                </script>
              <?php
                endif;

                $_SESSION['login_error'] = NULL;
              ?>
              <form method="POST" action="#">
                <div class="form-group mb-3">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                    </div>
                    <input name="username" class="form-control" placeholder="Username" type="text">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                    </div>
                    <input name="pw" class="form-control" placeholder="Password" type="password">
                  </div>
                </div>
                <div class="custom-control custom-control-alternative custom-checkbox">
                  <input class="custom-control-input" id=" customCheckLogin" type="checkbox">
                  <label class="custom-control-label" for=" customCheckLogin">
                    <span class="text-muted">Lembrar-me</span>
                  </label>
                </div>
                <div class="text-center">
                  <button name="submit" type="submit" class="btn btn-primary my-4">Entrar</button>
                </div>
              </form>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-6">
              <a href="#" class="text-light"><small>Esqueceu sua senha?</small></a>
            </div>
            <div class="col-6 text-right">
              <a href="register.php" class="text-light"><small>Cadastrar</small></a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <footer class="py-5">
      <div class="container">
        <?php include("../templates/footer.html")?>
      </div>
    </footer>
  </div>
  <!--   Core   -->
  <?php include("../templates/loadScripts.html")?>
</body>

</html>