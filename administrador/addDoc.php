<!DOCTYPE html>
<html>
<head>
    <meta charset= "UTF-8">
	<title>Docente</title>
    <link rel="stylesheet" href="./css/style.css">   
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/footers/">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/carousel/">
 </head>
<body>
    <center>
        
    <?php
        require_once "../utils.php";
        require_once "../conection.php";
        require_once "../conection2.php";
        require_once "../userInfoBar.php";

        SafeStart();
        LimpiaEntrada();
        $anticsrf =random_int(501, 9999999);
        $_SESSION['anticsrf'] = $anticsrf;
               
        if(isset($_SESSION['loged_user'])){
            loguedUser($_SESSION['loged_user']);
        }else{
            header('location: login.php');
        }
        
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
                    header("Location:../login.php");
        
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
                $Codigo = (isset($_POST['txtIdenDoc']))?$_POST['txtIdenDoc']:"";
                $Nombre1 = (isset($_POST['txtNombre1Doc']))?$_POST['txtNombre1Doc']:"";
                $Nombre2 = (isset($_POST['txtNombre2Doc']))?$_POST['txtNombre2Doc']:"";
                $Apellido1 = (isset($_POST['txtApellido1Doc']))?$_POST['txtApellido1Doc']:"";
                $Apellido2 = (isset($_POST['txtApellido2Doc']))?$_POST['txtApellido2Doc']:"";
                $TipoDoc = (isset($_POST['txtTIpoIdenDoc']))?$_POST['txtTIpoIdenDoc']:"";
                $NumIden = (isset($_POST['txtIdenDoc']))?$_POST['txtIdenDoc']:"";
                $TipoTelf = (isset($_POST['txtTIpoTelfDoc']))?$_POST['txtTIpoTelfDoc']:"";
                $Telf = (isset($_POST['txtTelfDoc']))?$_POST['txtTelfDoc']:"";
                $Direc = (isset($_POST['txtDirecDoc']))?$_POST['txtDirecDoc']:"";
                $Email = htmlspecialchars(isset($_POST['txtCorreoDoc']))?$_POST['txtCorreoDoc']:"";
                $Titulo = (isset($_POST['txtTitulo']))?$_POST['txtTitulo']:"";
                
                                 
                
                if(validateDoc($NumIden)){               
                $dbConnection = DBConnection();
  
                    if ($dbConnection !=NULL)
                    {
                        RegistrarDocente($dbConnection, $Codigo, $Nombre1 ,$Nombre2, $Apellido1, $Apellido2,$TipoDoc,$NumIden,$TipoTelf ,$Telf, $Direc ,$Email, $Titulo);
                        LimpiaEntrada();
                       echo '<h3>Docente registrado con exito.</h3>';
                        }
                    else {
                        echo '<h3> Algo salio mal registrando en BD, vuelva a intentar. </h3>'; 
                    }
                               
                }else{
                    echo '<h3>El Docente ya existe en la BD.</h3>';
                }       
            }else{
               echo '<h3> Complete todos los datos del registro. </h3>';
        } 
    }            
    require './navbaradmin.php';
     
    ?>
  

    <form action="" method="POST" enctype="multipart/form-data" class="formRegistro" required>
<br>
        <h2> Registrar Docente </h2>
        <br>

        <label for="txtNombre1Doc">Primer Nombre:</label>
        <input type="text" name="txtNombre1Doc" id="txtNombre1Doc" pattern="[A-Za-z0-9][^<->]{1,50}" required placeholder="Ingrese su Nombre">
        <br>
        <br>

        <label for="txtNombre2Doc">Segundo Nombre:</label>
        <input type="text" name="txtNombre2Doc" id="txtNombre2Doc" pattern="[A-Za-z0-9][^<->]{1,50}" required placeholder="Ingrese su Nombre">
        <br>
        <br>

        <label for="txtApellido1Doc">Primer Apellido:</label>
        <input type="text" name="txtApellido1Doc" id="txtApellido1Doc" pattern="[A-Za-z0-9][^<->]{1,50}" required placeholder="Ingrese su Apellido">
        <br>
        <br>

        <label for="txtApellido2Doc">Segundo Apellido:</label>
        <input type="text" name="txtApellido2Doc" id="txtApellido2Doc" pattern="[A-Za-z0-9][^<->]{1,50}" required placeholder="Ingrese su Apellido">
        <br>
        <br>

        <label for="txtTIpoIdenDoc">Tipo de Documento:</label> 
        <select name="txtTIpoIdenDoc" required>
                <option selected value="">Seleccione...</option>
		        <option value="Cedula de Cuidadania">Cedula de Cuidadania</option>
		        <option value="Cedula de Extranjeria">Cedula de Extranjeria</option>
                <option value="Pasaporte">Pasaporte</option>
                <option value="Permiso Especial">Permiso Especial</option>
        </select>
        <br>
        <br>

        <label for="txtIdenDoc">Numero de Identificacion:</label>
        <input type="text" name="txtIdenDoc" id="txtIdenDoc" pattern="[0-9][^<->]{1,10}" required placeholder="Ingrese Identificacion">
        <br>
        <br>


        <label for="txtTIpoTelfDoc">Tipo de contacto:</label> 
        <select name="txtTIpoTelfDoc" required>
                <option selected value="">Seleccione...</option>
		        <option value="Casa">Casa</option>
		        <option value="Cedular">Celular</option>
        </select>
        <br>
        <br>

        <label for="txtTelf1Doc">Numero de Contacto:</label>
        <input type="text" name="txtTelfDoc" id="txtTelfDoc" pattern="[0-9][^<->]{1,30}" required placeholder="Ingrese Contacto">
        <br>
        <br>

        <label for="txtDirecDoc">Direccion:</label>
        <input type="text" name="txtDirecDoc" id="txtDirecDoc" pattern="[A-Za-z0-9][^<->]{1,50}" required placeholder="Ingrese su Direccion">
        <br>
        <br>
        <label for="txtCorreoDoc">Correo:</label>
        <input type="text" name="txtCorreoDoc" id="txtCorreoDoc" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" required placeholder="Ingrese su E-mail">
        <br>
        <br>

        <label for="txtTitulo">Titulo:</label>
        <input type="text" name="txtTitulo" id="txtTitulo" pattern="[A-Za-z0-9][^<->]{1,20}" required placeholder="Ingrese su Titulo">
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
