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
    <h1 class="nametitle">Buscar alumno por el primer apellido</h1>
    <BR></BR>

    <form action="" method="get">
        <label for="">Ingrese el Primer Apellido del alumno:</label>
        <input type="text" name="busqueda">
        <br>
        <br>
        <input type="submit" name="enviar" value="Buscar">
        <br>
        <br>
    </form>
<h3>RESULTADO DE LA BÚSQUEDA:</h3>
    <br>

    <?php
        if(isset($_GET['enviar'])){

            $busqueda = $_GET['busqueda'];

            $consulta = $con->query("SELECT * FROM docentes WHERE nombre1_doce LIKE '%$busqueda%'");

            while($row = $consulta->fetch_array()){
                echo 
                     '<section class="secciones flex text-center">'.
                     '<div class="columna">'.
                     '<b>PRIMER NOMBRE: </b>'.$row['nombre1_doce'].'<br>'.
                     '<b>PRIMER APELLIDO: </b>'.$row['apellido1_doce'].'<br>'.
                     '<b>TIPO DE DOCUMENTO: </b>'.$row['tipo_doc_doc'].'<br>'.
                     '<b>IDENTIFICACION: </b>'.$row['iden_doc'].'<br>'.
                     '<b>TIPO DE TELEFONO: </b>'.$row['tipo_telf_doc'].'<br>'.
                     '<b>TELEFONO: </b>'.$row['telf_doc'].'<br>'.
                     '<b>DIRECCION: </b>'.$row['direccion_doc'].'<br>'.
                     '<b>EMAIL: </b>'.$row['email_doc'].'<br>'.
                     '<b>TITULO: </b>'.$row['titulo_doc'].'<br>'.                 
                     '</div>'.
                     '</section>'.
                     '<br>'.
                     '<br>';
            }
        }
    ?>

 </body>
