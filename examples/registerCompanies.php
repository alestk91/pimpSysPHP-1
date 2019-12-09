<?php
  require('../php/connect.php');

  if(!isset($_SESSION)) session_start();

  // if(!isset($_SESSION['usr_id'])) header('Location: index.php');
  $sqlCompany = "SELECT _idCompany, companyname FROM tbcompanies";
  $resultCompany = mysqli_query($con, $sqlCompany) or die("Falha ao encontrar companias");

  $sqlLevelSelect = "SELECT _idUserRole, name FROM tbuserroles"; 
  $resultLevelSelect = mysqli_query($con, $sqlLevelSelect) or die("Falha ao encontrar os níveis");

  if(isset($_POST['submit'])){
		$username = $_POST['username'];
        $email = $_POST['email'];
        $company = $_POST['company'];
        $level = $_POST['level'];
		$senha = $_POST['pw'];
		$senha_c = $_POST['c_pw'];

		if(!preg_match("/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/", $email)){
			$_SESSION['cad_error'] = 4;
		} else if(!preg_match("/^[a-zA-Z ]*$/", $username)){
			$_SESSION['cad_error'] = 5;
		} else if(!preg_match("/^[0-9A-Za-z!@#$%]{8,32}$/", $senha)){
			$_SESSION['cad_error'] = 3;
		} else {
			$sqlRegister = "SELECT _iduser FROM tbusers WHERE email = '$email' OR user = '$username';";
			$resultRegister = mysqli_query($con, $sqlRegister) or die("Falha na requisição do banco de dados");
			$resultRegister = mysqli_fetch_array($resultRegister);

			if(isset($resultRegister['_iduser'])) $_SESSION['cad_error'] = 1;
			else {
				$senha = md5($senha);
				$senha_c = md5($senha_c);

				if($senha != $senha_c) $_SESSION['cad_error'] = 2;
				else {
					$sqlUser = "INSERT INTO `tbusers`(`_idcompany`, `user`, `password`, `email`) VALUES('$company', '$username', '$senha', '$email');";
          $resultUser = mysqli_query($con, $sqlUser) or die(mysqli_error($con));
				}		
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
  <title><?= $title = "Registrar";?></title>
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
              $text = 'Email ou username já cadastrado';
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
          title: 'Seu cadastro foi efetuado com sucesso',
          text: 'Um link de confirmação foi enviado para seu email',
          confirmButtonText: 'Fechar',
          onClose: () => {
              window.location.href = 'login.php';
            }
        })
        // $(document).ready(function(){
        //     $('.date').mask('00/00/0000');
        //     $('.time').mask('00:00:00');
        //     $('.date_time').mask('00/00/0000 00:00:00');
        //     $('.cep').mask('00000-000');
        //     $('.phone').mask('0000-0000');
        //     $('.phone_with_ddd').mask('(00) 0000-0000');
        //     $('.phone_us').mask('(000) 000-0000');
        //     $('.mixed').mask('AAA 000-S0S');
        //     $('.cpf').mask('000.000.000-00', {reverse: true});
        //     $('.cnpj').inputmask('00.000.000/0000-00', {reverse: true});
        //     $('.money').mask('000.000.000.000.000,00', {reverse: true});
        //     $('.money2').mask("#.##0,00", {reverse: true});
        //     $('.ip_address').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
        //       translation: {
        //         'Z': {
        //           pattern: /[0-9]/, optional: true
        //         }
        //       }
        //     });
        //     $('.ip_address').mask('099.099.099.099');
        //     $('.percent').mask('##0,00%', {reverse: true});
        //     $('.clear-if-not-match').mask("00/00/0000", {clearIfNotMatch: true});
        //     $('.placeholder').mask("00/00/0000", {placeholder: "__/__/____"});
        //     $('.fallback').mask("00r00r0000", {
        //         translation: {
        //           'r': {
        //             pattern: /[\/]/,
        //             fallback: '/'
        //           },
        //           placeholder: "__/__/____"
        //         }
        //       });
        //     $('.selectonfocus').mask("00/00/0000", {selectOnFocus: true});
        //   });
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
              <div class="text-muted text-center mt-2 mb-4"><small>Dados pessoais</small></div>
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
                    <input name="cnpj" class="form-control" placeholder="CNPJ" type="text">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-alternative mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-mobile-button"></i></span>
                    </div>
                    <input name="telComp" class="form-control" placeholder="Telefone" type="text">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-alternative mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                    </div>
                    <input name="emailComp" class="form-control" placeholder="Email" type="text">
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