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
    <link href="../libs/css/productos.css" rel="stylesheet">
 </head>
<body>
    <center>
        
    <?php
        require_once "../utils.php";
        require_once "../conection.php";
        require_once "../conection2.php";
        require_once "../userInfoBar.php";
    

        SafeStart();
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
    
        require './navbaradmin.php';

    ?>
<br>
<h4>Buscar un docente por:</h4>

<button type="button" onclick="location.href='./buscardocIden.php'"  class="btn btn-dark">Buscar por Codigo</button>
<button type="button" onclick="location.href='./buscardocNombre.php'"  class="btn btn-warning">Buscar por Nombre</button>
<button type="button" onclick="location.href='./buscardocApe.php'"  class="btn btn-dark">Buscar por Apellido</button>
<!-- <button type="button" onclick="location.href='#'"  class="btn btn-dark">Buscar por apellido</button> -->



 </body>