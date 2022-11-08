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
    <h1 class="nametitle">Buscar docente por el primer apellido</h1>
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
            $Chost = "localhost";
            $Cuser = "root";
            $Cpass = "123456";
            $Cdb = "dbschool";

            $conectar =  mysqli_connect($Chost,$Cuser,$Cpass,$Cdb);

            $busqueda = $_GET['busqueda'];

            $consulta = ("SELECT C.nombre_curso,D.nombre1_doce,D.apellido1_doce,A.nombre1_est,A.apellido1_est
            FROM alumno_x_curso M
            INNER JOIN docentes D ON M.docente = D.id_docente
            INNER JOIN alumnos A ON M.estudent = A.id_alumno
            INNER JOIN cursos C ON M.curso = C.id_curso
            WHERE M.id_alumno_x_curso = 'busqueda'");

            $resultado = mysqli_query($conectar, $consulta);

            // while($row = $consulta->fetch_array()){
                echo 
                '<table class="table">'.
                '<thead class="thead-dark">'.
                    '<tr>'.
                    '<th class="text-center">ID</th>'.
                    '<th class="text-center">CURSO</th>'.
                    '<th class="text-center">DOCENTE NOMBRE</th>'.
                    '<th class="text-center">DOCENTE APELLIDO</th>'.
                    '<th class="text-center">ALUMNO NOMBRE</th>'.
                    '<th class="text-center">ALUMNO APELLIDO</th>'.
                    '</tr>'.
               '</thead>.'.
                '<tbody>'.
                    '<?php while($row = $consulta->fetch_array()) ?>'.
                   '<tr>'.
                    '<td class="text-center"><?php echo $n; ?></td>'.
                   '<td class="text-center"><?php echo $row["nombre_curso"]; ?></td>'.
                    '<td class="text-center"><?php echo $row["nombre1_doce"]; ?></td>'.
                    '<td class="text-center"><?php echo $row["apellido2_doce"]; ?></td>'.
                    '<td class="text-center"><?php echo $row["nombre1_est"]; ?>'.'</td>'.
                    '<td class="text-center"><?php echo $row["apellido1_est"]; ?></td>'.
                    '</tr>';
            }
        // }
    ?>

 </body>
