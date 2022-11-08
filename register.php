<!DOCTYPE html>
<html>
<head>
    <meta charset= "UTF-8">
	<title> Registro </title>
    <link rel="stylesheet" href="libs/css/registro.css">   
 </head>

<body>
    <center>
    <?php
        require_once "./utils.php";
        require_once "./conection.php";

        SafeStart();
        LimpiaEntrada();
        $anticsrf =random_int(501, 9999999);
        $_SESSION['anticsrf'] = $anticsrf;
               

        if(isset($_SESSION['tiempo']) ) {

            //Tiempo en segundos para dar vida a la sesión.
            $inactivo = 300;//5min en este caso.
        
            //Calculamos tiempo de vida inactivo.
            $vida_session = time() - $_SESSION['tiempo'];
        
                //Compraración para redirigir página, si la vida de sesión sea mayor a el tiempo insertado en inactivo.
                if($vida_session > $inactivo)
                {
                    //Removemos sesión.
                    session_unset();
                    //Destruimos sesión.
                    session_destroy();              
                    //Redirigimos pagina.
                    header("Location:login.php");
        
                    exit();
                }
          } else {
            //Activamos sesion tiempo.
            $_SESSION['tiempo'] = time();
        }

        LimpiaEntrada();
        if (isset($_POST['btnRegistrar']) ) {        
    
            #limpiamos cada uno de los datos de entrada del POST
            LimpiaEntrada();
    
            $isValidData = ValidateForm($_POST);        
            #Validamos que ningun campo este vacio
            if($isValidData){
                #Validamos si ya existe el usuario 
                $Nombre = (isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
                $Correo = htmlspecialchars(isset($_POST['txtCorreo']))?$_POST['txtCorreo']:"";
                $Usuario = (isset($_POST['txtUsuario']))?$_POST['txtUsuario']:"";
                $Clave =md5($_POST['txtClave']);   
                $Estado = (isset($_POST['txtEstado']))?$_POST['txtEstado']:"";
                $Rol = (isset($_POST['txtRol']))?$_POST['txtRol']:"";
                                 
                
                if(validateUser($Usuario)){               
                $dbConnection = DBConnection();
  
                    if ($dbConnection !=NULL)
                    {
                        RegistryUserDB($dbConnection, $Nombre, $Correo, $Usuario, $Clave, $Estado,$Rol);
                        LimpiaEntrada();
                       echo '<h3>Usuario registrado con exito.</h3>';
                        }
                    else {
                        echo '<h3> Algo salio mal registrando en BD, vuelva a intentar. </h3>'; 
                    }
                               
                }else{
                    echo '<h3>El usuario ya existe en la BD, pruebe con otro nombre de usuario.</h3>';
                }       
            }else{
               echo '<h3> Complete todos los datos del registro. </h3>';
        } 
    }            
            

        
    ?>
    <div align="left">
    <button type="button" onclick="location.href='login.php'"  class="btn btn-info">Volver</button>
    </div>
    

    <form action="" method="POST" enctype="multipart/form-data" class="formRegistro" required>

        <h2> Registro </h2>
        <label for="txtNombre">Nombre:</label>
        <input type="text" name="txtNombre" id="txtNombre" pattern="[A-Za-z0-9][^<->]{1,20}" required placeholder="Ingrese su Nombre">
        <br>
        <br>

        <label for="txtCorreo">Correo:</label>
        <input type="text" name="txtCorreo" id="txtCorreo" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" required placeholder="Ingrese su E-mail">
        <br>
        <br>

        <label for="txtUsuario">Usuario:</label> 
        <input type="text" name="txtUsuario" id="txtUsuario" pattern="[A-Za-z]{1-20}" required placeholder="Ingrese su Username">
        <br>
        <br>

        <label for="txtClave">Password:</label> 
        <input type="password" name="txtClave" id="txtClave"pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{5,28}$" required placeholder="Ingrese su contraseña">
        <br>
        <br>

        <label for="txtEstado">Estado del registro:</label> 
        <select name="txtEstado" required>
                <option selected value="">Seleccione...</option>
		        <option value="Activo">Activo</option>
		        <option value="Inactivo">Inactivo</option>
        </select>
        <br>
        <br>

        <label for="txtRol">Rol:</label> 
        <select name="txtRol" required>
                <option selected value="">Seleccione...</option>
		        <option value="Usuario">Usuario</option>
		        <option value="Administrador">Administrador</option>
        </select>
        <br>
        <br>

        <br>
        <div class = "form-group">
		<input type="hidden"  value="<?php echo $anticsrf; ?>" class="form-control" name="anticsrf">
		</div>
        <button type="submit" name="btnRegistrar" value="Registrarse">Registrarse</button>
        <br>
             


        <br>
        <br>

    </form>
    </center>
</body>

</html>

