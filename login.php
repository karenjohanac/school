<!DOCTYPE html>
<html>
<head>
    <meta charset= "UTF-8">
	<title> Login </title>  
    <style src="/libs/css/styles.css"></style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> 
</head>

<center>
    <body>
    
    <?php

        require_once "./utils.php";
        require_once "./conection.php";

        LimpiaEntrada();
        SafeStart();
        $anticsrf =random_int(501, 9999999);
        $_SESSION['anticsrf'] = $anticsrf;
          
        function doLogin(){

        if(isset($_POST['txtUsuario']) && isset($_POST['txtClave'])){
            unset($_SESSION['loged_user']);
            LimpiaEntrada();
            $user = $_POST['txtUsuario'];
            $password = md5($_POST['txtClave']);

            $dbConnection = DBConnection();

            $_SESSION['login_usuario']=$user;

            $conexion= mysqli_connect('localhost','root','123456','dbschool','3306');
            
            $consulta="SELECT * FROM usuarios where login_usuario='$user' and password_usuario='$password'";
            $resultado= mysqli_query($conexion,$consulta);

            $filas = mysqli_fetch_array($resultado);

            if($dbConnection){

                $_SESSION['loged_user'] = ValidarLoginDB($dbConnection, $user, $password);
                
                if($_SESSION['loged_user'] != ""){
                    if($filas['rol_usuario']=='Administrador'){
                        header('location: administrador/portal.php');
                    }else if($filas['rol_usuario']=='Usuario'){
                        header('location: usuario/usu.php');
                    }
                }else{
                    echo '<h3> Usuario o contraseña incorrectos </h3>';
                }                        
                                
            }else{
                echo '<h3> Error al conectar con BD </h3>';
            }  
        }else{
            echo 'No se pudo validar';
        }
    }          
        if (isset($_POST) && isset($_POST['btnIngresar'])) {
            doLogin();
            LimpiaEntrada();
        }

    ?>


<div id="login">
    <h3 class="text-center text-white pt-5">Login</h3>
    <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div id="login-box" class="col-md-12">
                    <form id="login-form" class="form" action="" method="post" enctype="multipart/form-data">
                        <h3 class="text-center text-info">Login</h3>
                        <div class="form-group">
                            <label for="username" class="text-info">Usuario:</label><br>
                            <input type="text" name="txtUsuario" id="txtUsuario" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password" class="text-info">Clave:</label><br>
                            <input type="password" name="txtClave" id="txtClave" class="form-control">
                        </div>                        
                        <div class = "form-group">
		                <input type="hidden"  value="<?php echo $anticsrf; ?>" class="form-control" name="anticsrf">
		                </div>
                        <div class="mt-4">
                        <div id="register-link" class="text-right my-2">
                            <button type="submit" name="btnIngresar" class="btn-primary">Ingresar</a>
                        </div>
                        <div class="d-flex justify-content-center links">
						No te has registrado?  <a href="register.php" class="ml-2"> Registrarse</a>
					    </div>
                        <br>
                    </form>
                    
				</div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</center>        
</html>
<br>
<footer >
  <!-- Copyright -->
  <div class="text-center p-3">
  <p>ELABORADO POR: ANDREA CAROLINA GÓMEZ Y KAREN JOHANA CORTÉS RINCÓN</p>
    <p>UNIVERSIDAD DE CUNDINAMARCA</p>
    <p>NÚCLEO TEMÁTICO: LINEA DE PROFUNDIZACION 3</p>
  </div>
  <!-- Copyright -->
</footer>







