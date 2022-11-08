<!DOCTYPE html>
<html>
<head>
    <meta charset= "UTF-8">
	<title>Estudiante</title>
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
                
                $Nombre1 = (isset($_POST['txtNombre1Est']))?$_POST['txtNombre1Est']:"";
                $Nombre2 = (isset($_POST['txtNombre2Est']))?$_POST['txtNombre2Est']:"";
                $Apellido1 = (isset($_POST['txtApellido1Est']))?$_POST['txtApellido1Est']:"";
                $Apellido2 = (isset($_POST['txtApellido2Est']))?$_POST['txtApellido2Est']:"";
                $idenEst = (isset($_POST['txtIdenEst']))?$_POST['txtIdenEst']:"";
                $Edad = (isset($_POST['txtEdadEst']))?$_POST['txtEdadEst']:"";
                $TipoTelf = (isset($_POST['txtTIpoTelfEst']))?$_POST['txtTIpoTelfEst']:"";
                $Telf = (isset($_POST['txtTelfEst']))?$_POST['txtTelfEst']:"";
                $Direc = (isset($_POST['txtDirecEst']))?$_POST['txtDirecEst']:"";
                $Email = htmlspecialchars(isset($_POST['txtCorreoEst']))?$_POST['txtCorreoEst']:"";
                $Codigo = (isset($_POST['txtIdenEst']))?$_POST['txtIdenEst']:"";
                
                                 
                
                if(validateDoc($idenEst)){               
                $dbConnection = DBConnection();
  
                    if ($dbConnection !=NULL)
                    {
                        RegistrarEstudiante($dbConnection, $Nombre1 ,$Nombre2, $Apellido1, $Apellido2,$idenEst,$Edad, $TipoTelf ,$Telf, $Direc ,$Email, $Codigo);
                        LimpiaEntrada();
                       echo '<h3>Estudiante registrado con exito.</h3>';
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
        <h2> Registrar Alumno </h2>
        <br>

        <label for="txtNombre1Est">Primer Nombre:</label>
        <input type="text" name="txtNombre1Est" id="txtNombre1Est" pattern="[A-Za-z0-9][^<->]{1,50}" required placeholder="Ingrese su Nombre">
        <br>
        <br>

        <label for="txtNombre2Est">Segundo Nombre:</label>
        <input type="text" name="txtNombre2Est" id="txtNombre2Est" pattern="[A-Za-z0-9][^<->]{1,50}" required placeholder="Ingrese su Nombre">
        <br>
        <br>

        <label for="txtApellido1Doc">Primer Apellido:</label>
        <input type="text" name="txtApellido1Est" id="txtApellido1Est" pattern="[A-Za-z0-9][^<->]{1,50}" required placeholder="Ingrese su Apellido">
        <br>
        <br>

        <label for="txtApellido2Doc">Segundo Apellido:</label>
        <input type="text" name="txtApellido2Est" id="txtApellido2Est" pattern="[A-Za-z0-9][^<->]{1,50}" required placeholder="Ingrese su Apellido">
        <br>
        <br>

        <label for="txtIdenEst">Numero de Identificacion:</label>
        <input type="text" name="txtIdenEst" id="txtIdenEst" pattern="[0-9][^<->]{1,10}" required placeholder="Ingrese Identificacion">
        <br>
        <br>

        <label for="txtEdadEst">Edad</label>
        <input type="text" name="txtEdadEst" id="txtItxtEdadEstdenDoc" pattern="[0-9]{1,2}" required placeholder="Ingrese Edad">
        <br>
        <br>


        <label for="txtTIpoTelfEst">Tipo de contacto:</label> 
        <select name="txtTIpoTelfEst" required>
                <option selected value="">Seleccione...</option>
		        <option value="Casa">Casa</option>
		        <option value="Cedular">Celular</option>
        </select>
        <br>
        <br>

        <label for="txtTelfEst">Numero de Contacto:</label>
        <input type="text" name="txtTelfEst" id="txtTelfEst" pattern="[0-9][^<->]{1,30}" required placeholder="Ingrese Contacto">
        <br>
        <br>

        <label for="txtDirecEst">Direccion:</label>
        <input type="text" name="txtDirecEst" id="txtDirecEst" pattern="[A-Za-z0-9][^<->]{1,50}" required placeholder="Ingrese su Direccion">
        <br>
        <br>
        <label for="txtCorreoEst">Correo:</label>
        <input type="text" name="txtCorreoEst" id="txtCorreoEst" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" required placeholder="Ingrese su E-mail">
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
