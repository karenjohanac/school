<!DOCTYPE html>
<html>
<head>
    <meta charset= "UTF-8">
	<title>Curso</title>
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
                
                $CodigoCurso = (isset($_POST['txtCodigoCurso']))?$_POST['txtCodigoCurso']:"";
                $Nombre = (isset($_POST['txtNombreCurso']))?$_POST['txtNombreCurso']:"";
                $Creditos = (isset($_POST['txtCreditos']))?$_POST['txtCreditos']:"";
                $Descripcion = (isset($_POST['txtDesCur']))?$_POST['txtDesCur']:"";
                $Temario = (isset($_POST['txtTemarioCur']))?$_POST['txtTemarioCur']:"";
                                       
                
                if(validateCurso($CodigoCurso)){               
                $dbConnection = DBConnection();
  
                    if ($dbConnection !=NULL)
                    {
                        RegistrarCurso($dbConnection, $CodigoCurso ,$Nombre, $Creditos, $Descripcion,$Temario);
                        LimpiaEntrada();
                       echo '<h3>Curso registrado con exito.</h3>';
                        }
                    else {
                        echo '<h3> Algo salio mal registrando en BD, vuelva a intentar. </h3>'; 
                    }
                               
                }else{
                    echo '<h3>El Curso ya existe en la BD.</h3>';
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

        <label for="txtCodigoCurso">Codigo de curso:</label>
        <input type="text" name="txtCodigoCurso" id="txtCodigoCurso" pattern="[A-Za-z0-9][^<->]{1,50}" required placeholder="Codigo Curso">
        <br>
        <br>

        <label for="txtNombreCurso">Nombre:</label>
        <input type="text" name="txtNombreCurso" id="txtNombreCurso" pattern="[A-Za-z0-9][^<->]{1,50}" required placeholder="Nombre del Curso">
        <br>
        <br>

        <label for="txtCreditos">Creditos Curso:</label>
        <input type="text" name="txtCreditos" id="txtCreditos" pattern="[0-9]{1,2}" required placeholder="Creditos Curso">
        <br>
        <br>

        <label for="txtDesCur">Descripcion curso:</label>
        <input type="text" name="txtDesCur" id="txtDesCur" pattern="[A-Za-z0-9][^<->]{1,100}" required placeholder="Ingrese Descripcion Curso">
        <br>
        <br>

        <label for="txtTemarioCur">Temario curso:</label>
        <input type="text" name="txtTemarioCur" id="txtTemarioCur" pattern="[A-Za-z0-9][^<->]{1,500}" required placeholder="Ingrese Temario">
        <br>
        <br>

        <br>
        <div class = "form-group">
		<input type="hidden"  value="<?php echo $anticsrf; ?>" class="form-control" name="anticsrf">
		</div>
        <button type="submit" name="btnRegistrar" value="Registrarse">Ingresar Curso</button>
        <br>    


        <br>
        <br>

    </form>
    </center>

 </body>
