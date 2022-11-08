<!DOCTYPE html>
<html>
<head>
    <meta charset= "UTF-8">
	<title>Index</title>
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
    
        require './narbarusu.php';

    ?>
<br>
    <h1 class="nametitle">Buscar curso por codigo</h1>
    <BR></BR>

    <form action="" method="get">
        <label for="">Ingrese el codigo:</label>
        <input type="text" name="busqueda">
        <br>
        <br>
        <input type="submit" name="enviar" value="Buscar">
        <br>
        <br>
    </form>

    <?php
        if(isset($_GET['enviar'])){

            $busqueda = $_GET['busqueda'];

            $consulta = $con->query("SELECT * FROM cursos WHERE nombre_curso LIKE '%$busqueda%'");

            while($row = $consulta->fetch_array()){
                echo '<b>SE HA ENCONTRADO:</b>'.'<br>'.
                     'CODIGO:'.$row['codigo_curso'].'<br>'.
                     'NOMBRE:'.$row['nombre_curso'].'<br>'.
                     'CREDITOS:'.$row['creditos_curso'].'<br>'.
                     'DESCRIPCION:'.$row['descrip_curso'].'<br>'.
                     'TEMARIO:'.$row['temario_curso'].'<br>'
                     .'<br>'
                     .'<br>';
            }
        }
    ?>

 </body>
