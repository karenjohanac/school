<!DOCTYPE html>
<html>
<head>
    <meta charset= "UTF-8">
	<title>Matricula</title>
    <link rel="stylesheet" href="../css/style.css">   
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/footers/">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/carousel/">
 </head>
<body>
    <center>
        
    <?php
        require_once "../utils.php";
        require_once "../conection.php";
        require_once "../conection2.php";
        require_once "../conection3.php";
        require_once "../userInfoBar.php";

        SafeStart();
        LimpiaEntrada();
        $anticsrf =random_int(501, 9999999);
        $_SESSION['anticsrf'] = $anticsrf;
               
        if(isset($_SESSION['loged_user'])){
            loguedUser($_SESSION['loged_user']);
        }else{
            header("Location:../login.php");
        }
        
        if(isset($_SESSION['tiempo']) ) {

            //Tiempo en segundos para dar vida a la sesión.
            $inactivo = 1000;//5min en este caso.
        
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
                $Curso = (isset($_POST['curso']))?$_POST['curso']:"";
                $Docente = (isset($_POST['docente']))?$_POST['docente']:"";
                $Estudiante = (isset($_POST['alumno']))?$_POST['alumno']:"";
                          
                
                if(validateMatricula($Estudiante,$Curso)){               
                $dbConnection = DBConnection();
  
                    if ($dbConnection !=NULL)
                    {
                        RegistrarMatricula($dbConnection, $Curso, $Docente,$Estudiante);
                        LimpiaEntrada();
                       echo '<h3>Matricula registrada con exito.</h3>';
                        }
                    else {
                        echo '<h3> Algo salio mal registrando en BD, vuelva a intentar. </h3>'; 
                    }                               
                }else{
                    echo '<h3>El estudiante ya está matriculado en ese curso.</h3>';
                }       
            }else{
               echo '<h3> Complete todos los datos del registro. </h3>';
        } 
    }            
    require './navbaradmin.php';
     
    ?>
  

    <form action="" method="POST" enctype="multipart/form-data" class="formRegistro" required>
<br>
        <h2> Matricular alumno:</h2>
        <br>
        <label for="">Seleccione un curso:</label>
        <select name="curso" id="">
            <?php

            $con = conexion();

            $sql = 'SELECT id_curso, nombre_curso FROM cursos';
            $query = mysqli_query($con,$sql);

            while($row=mysqli_fetch_array($query)){
                $idCursoList = $row['id_curso'];
                $NombreCurso = $row['nombre_curso'];
                ?>
                    <option value="<?php echo $idCursoList ?>"><?php echo $NombreCurso ?></option>
                <?php       
                }
            ?>      
            <br>
        <br>      
        </select>
    
        </select>
        <br>
        <br>  
               
        <label for="">Seleccione un profesor:</label>
        <select name="docente" id="">
            <?php

            $con = conexion();

            $sql = 'SELECT id_docente,codigo_docente, nombre1_doce , apellido1_doce FROM  docentes';
            $query = mysqli_query($con,$sql);

            while($row=mysqli_fetch_array($query)){
                $idDocenteList = $row['id_docente'];
                $CodigDocente = $row['codigo_docente'];
                $NombreDoc = $row['nombre1_doce'];
                $ApellidoDoc = $row[' apellido1_doce'];

                ?>
                    <option value="<?php echo $idDocenteList ?>"><?php echo $CodigDocente.'-'.$NombreDoc.''.$ApellidoDoc ?></option>
                <?php       
                }
            ?>            
        </select>
        <br>
        <br> 
        <label for="">Seleccione un estudidante:</label>
        <select name="alumno" id="">
            <?php

            $con = conexion();

            $sql = 'SELECT id_alumno, codigo_estudiante ,nombre1_est , apellido1_est FROM  alumnos';
            $query = mysqli_query($con,$sql);

            while($row=mysqli_fetch_array($query)){
                $idAlumnoList = $row['id_alumno'];
                $CodigoAlumno = $row['codigo_estudiante'];
                $NombreEst = $row['nombre1_est'];
                $ApellidoEst = $row[' apellido1_est'];

                ?>
                    <option value="<?php echo $idAlumnoList ?>"><?php echo $CodigoAlumno.'-'.$NombreEst.''.$ApellidoEst ?></option>
                <?php       
                }
            ?>            
        </select>

        <br>
        <br>
        <div class = "form-group">
		<input type="hidden"  value="<?php echo $anticsrf; ?>" class="form-control" name="anticsrf">
		</div>
        <button type="submit" name="btnRegistrar" value="Matricular">Matricular</button>
        <br>

    </form>
    </center>

 </body>
