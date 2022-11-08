<?php
date_default_timezone_set('America/Bogota');

    function DBConnection(){
        $servername = "localhost";
        $database = "dbschool";
        $username = "root";
        $password = "123456";

        $sql = "mysql:host=$servername;dbname=$database;";
        $dsn_Options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
        // Create a new connection to the MySQL database using PDO, $my_Db_Connection is an object
        try { 
            $my_Db_Connection = new PDO($sql, $username, $password, $dsn_Options);
            return $my_Db_Connection;
        } catch (PDOException $error) {
            echo 'Connection error: ' . $error->getMessage();
            echo "Not found";
        }
    }

    function RegistryUserDB($my_Db_Connection, $Nombre, $Correo, $Usuario, $Clave, $Estado,$Rol){
        try {

            $my_Insert_Statement = $my_Db_Connection->prepare("INSERT INTO `usuarios` (`nombre_usuario`, `email_usuario`,`login_usuario`, `password_usuario`,  `estado_registro`, `rol_usuario`) 
            VALUES (:Nombre, :Correo,:Usuario, :Clave, :Estado, :Rol)");
                
            #Reemplazamos los fatos que se van a insertar en el Query   
            $my_Insert_Statement->bindParam(":Nombre", $Nombre);
            $my_Insert_Statement->bindParam(":Correo", $Correo);
            $my_Insert_Statement->bindParam(":Usuario", $Usuario);
            $my_Insert_Statement->bindParam(":Clave", $Clave); 
            $my_Insert_Statement->bindParam(":Estado", $Estado); 
            $my_Insert_Statement->bindParam(":Rol", $Rol); 

            if ($my_Insert_Statement->execute()) {
                #Retorna numero de filas insertadas en BD
                $count = $my_Insert_Statement -> rowCount();

                if ($count>0) {
                    return TRUE;
                }
                
            } 
            return FALSE;

        } catch (Exception $e) {
            echo "Not".$e;
            http_response_code(404);
            exit();
        }
    }

    function RegistrarDocente($my_Db_Connection, $Codigo, $Nombre1 ,$Nombre2, $Apellido1, $Apellido2,$TipoDoc,$NumIden,$TipoTelf ,$Telf, $Direc ,$Email, $Titulo){
        try {

            $my_Insert_Statement = $my_Db_Connection->prepare("INSERT INTO `docentes` (`codigo_docente`, `nombre1_doce`,`nombre2_doce`, `apellido1_doce`,  `apellido2_doce`,  `tipo_doc_doc`,  `iden_doc`,  `tipo_telf_doc`,  `telf_doc`,  `direccion_doc`, `email_doc`,`titulo_doc`) 
            VALUES (:Codigo, :Nombre1,:Nombre2,:Apellido1, :Apellido2, :TipoDocDoc, :DocDoc, :TipoTelfDoc, :TelfDoc, :DirecDoc, :EmailDoc, :Tituilo )");
                
            #Reemplazamos los fatos que se van a insertar en el Query   
            $my_Insert_Statement->bindParam(":Codigo", $Codigo);
            $my_Insert_Statement->bindParam(":Nombre1", $Nombre1);
            $my_Insert_Statement->bindParam(":Nombre2", $Nombre2);
            $my_Insert_Statement->bindParam(":Apellido1", $Apellido1); 
            $my_Insert_Statement->bindParam(":Apellido2", $Apellido2);
            $my_Insert_Statement->bindParam(":TipoDocDoc", $TipoDoc); 
            $my_Insert_Statement->bindParam(":DocDoc", $NumIden); 
            $my_Insert_Statement->bindParam(":TipoTelfDoc", $TipoTelf); 
            $my_Insert_Statement->bindParam(":TelfDoc", $Telf);  
            $my_Insert_Statement->bindParam(":DirecDoc", $Direc); 
            $my_Insert_Statement->bindParam(":EmailDoc", $Email); 
            $my_Insert_Statement->bindParam(":Tituilo", $Titulo); 


            if ($my_Insert_Statement->execute()) {
                #Retorna numero de filas insertadas en BD
                $count = $my_Insert_Statement -> rowCount();

                if ($count>0) {
                    return TRUE;
                }
                
            } 
            return FALSE;

        } catch (Exception $e) {
            echo "Not".$e;
            http_response_code(404);
            exit();
        }
    }

    function RegistrarEstudiante($my_Db_Connection, $Nombre1 ,$Nombre2, $Apellido1, $Apellido2,$IdenEst, $Edad, $TipoTelf ,$Telf, $Direc ,$Email, $Codigo){
        try {

            $my_Insert_Statement = $my_Db_Connection->prepare("INSERT INTO `alumnos` ( `nombre1_est`,`nombre2_est`, `apellido1_est`, `apellido2_est`,  `iden_est`,  `edad_est`, `tipo_telf`,  `telf_est`,  `direccion_est`, `email_est`,`codigo_estudiante`) 
            VALUES (:Nombre1,:Nombre2,:Apellido1, :Apellido2, :IdenEst, :Edad, :TipoTelfEst, :TelfEst, :DirecEst, :EmailEst, :Codigo)");
                
            #Reemplazamos los fatos que se van a insertar en el Query   
            
            $my_Insert_Statement->bindParam(":Nombre1", $Nombre1);
            $my_Insert_Statement->bindParam(":Nombre2", $Nombre2);
            $my_Insert_Statement->bindParam(":Apellido1", $Apellido1); 
            $my_Insert_Statement->bindParam(":Apellido2", $Apellido2);
            $my_Insert_Statement->bindParam(":IdenEst", $IdenEst);
            $my_Insert_Statement->bindParam(":Edad", $Edad); 
            $my_Insert_Statement->bindParam(":TipoTelfEst", $TipoTelf); 
            $my_Insert_Statement->bindParam(":TelfEst", $Telf);  
            $my_Insert_Statement->bindParam(":DirecEst", $Direc); 
            $my_Insert_Statement->bindParam(":EmailEst", $Email); 
            $my_Insert_Statement->bindParam(":Codigo", $Codigo); 


            if ($my_Insert_Statement->execute()) {
                #Retorna numero de filas insertadas en BD
                $count = $my_Insert_Statement -> rowCount();

                if ($count>0) {
                    return TRUE;
                }
                
            } 
            return FALSE;

        } catch (Exception $e) {
            echo "Not".$e;
            http_response_code(404);
            exit();
        }
    }

    function RegistrarCurso($my_Db_Connection, $CodigoCurso ,$Nombre, $Creditos, $Descripcion,$Temario){
        try {

            $my_Insert_Statement = $my_Db_Connection->prepare("INSERT INTO `cursos` ( `codigo_curso`,`nombre_curso`, `creditos_curso`, `descrip_curso`,  `temario_curso`) 
            VALUES (:CodigoCurso,:Nombre,:Creditos, :Descripcion, :Temario)");
                
            #Reemplazamos los fatos que se van a insertar en el Query   
            
            $my_Insert_Statement->bindParam(":CodigoCurso", $CodigoCurso);
            $my_Insert_Statement->bindParam(":Nombre", $Nombre);
            $my_Insert_Statement->bindParam(":Creditos", $Creditos); 
            $my_Insert_Statement->bindParam(":Descripcion", $Descripcion);
            $my_Insert_Statement->bindParam(":Temario", $Temario);

            if ($my_Insert_Statement->execute()) {
                #Retorna numero de filas insertadas en BD
                $count = $my_Insert_Statement -> rowCount();

                if ($count>0) {
                    return TRUE;
                }
                
            } 
            return FALSE;

        } catch (Exception $e) {
            echo "Not".$e;
            http_response_code(404);
            exit();
        }
    }

    function RegistrarMatricula($my_Db_Connection, $Curso, $Docente , $Estudiante){
        try {

            $my_Insert_Statement = $my_Db_Connection->prepare("INSERT INTO `alumno_x_curso`(`curso`, `docente`, `estudent`) 
            VALUES (:Curso,:Docente , :Estudiante)");
                
            #Reemplazamos los fatos que se van a insertar en el Query   
            $my_Insert_Statement->bindParam(":Curso", $Curso);
            $my_Insert_Statement->bindParam(":Docente", $Docente);
            $my_Insert_Statement->bindParam(":Estudiante", $Estudiante);


            if ($my_Insert_Statement->execute()) {
                #Retorna numero de filas insertadas en BD
                $count = $my_Insert_Statement -> rowCount();

                if ($count>0) {
                    return TRUE;
                }
                
            } 
            return FALSE;

        } catch (Exception $e) {
            echo "Not".$e;
            http_response_code(404);
            exit();
        }
    }

    function validateUser($userName){              
        $dbConnection = DBConnection();    
            if($dbConnection != NULL){       
                LimpiaEntrada();              
                return ExistUserInDb($dbConnection, $userName);  
                LimpiaEntrada();  
            }
    
        echo '<h3> No podemos consultar si el usuario ya esta registrado o no. </h3>';
        return FALSE;    
    }

    function validateDoc($Codigo){              
        $dbConnection = DBConnection();    
            if($dbConnection != NULL){       
                LimpiaEntrada();              
                return ExistDocInDb($dbConnection, $Codigo);  
                LimpiaEntrada();  
            }
    
        echo '<h3> No podemos consultar si el usuario ya esta registrado o no. </h3>';
        return FALSE;    
    }

    function validateEst($CodigoEst){              
        $dbConnection = DBConnection();    
            if($dbConnection != NULL){       
                LimpiaEntrada();              
                return ExistEstInDb($dbConnection, $CodigoEst)  ;
                LimpiaEntrada();  
            }
    
        echo '<h3> No podemos consultar si el usuario ya esta registrado o no. </h3>';
        return FALSE;    
    }

    function validateCurso($CodigoCurso){              
        $dbConnection = DBConnection();    
            if($dbConnection != NULL){       
                LimpiaEntrada();              
                return ExistCursoInDb($dbConnection, $CodigoCurso)  ;
                LimpiaEntrada();  
            }
    
        echo '<h3> No podemos consultar si el usuario ya esta registrado o no. </h3>';
        return FALSE;    
    }

    function validateMatricula($Est, $Curso){              
        $dbConnection = DBConnection();    
            if($dbConnection != NULL){       
                LimpiaEntrada();              
                return ExistMatInDb($dbConnection, $Est, $Curso);  
                LimpiaEntrada();  
            }
    
        echo '<h3> No podemos consultar si el usuario ya esta registrado o no. </h3>';
        return FALSE;    
    }

    function ExistUserInDb($my_Db_Connection, $usuario){
		try {
			$my_Select_Statement = 
			$my_Db_Connection->prepare("SELECT count(login_usuario) as numUsers FROM usuarios where login_usuario = :Usuario");

			$my_Select_Statement->bindParam(":Usuario", $usuario);
			$my_Select_Statement->execute();

			$user = $my_Select_Statement -> fetch();	

			if ($user && $user['numUsers'] == 0) {              

				return TRUE;
			}

			return FALSE;
		} catch (Exception $e) {
			echo "Not".$e;
		    http_response_code(404);
		    exit();
		}
	}

    function ExistDocInDb($my_Db_Connection, $NumIden){
		try {
			$my_Select_Statement = 
			$my_Db_Connection->prepare("SELECT count(iden_doc) as numUsers FROM docentes where iden_doc = :IdenDoc");

			$my_Select_Statement->bindParam(":IdenDoc", $NumIden);
			$my_Select_Statement->execute();

			$user = $my_Select_Statement -> fetch();	

			if ($user && $user['numUsers'] == 0) {              

				return TRUE;
			}

			return FALSE;
		} catch (Exception $e) {
			echo "Not".$e;
		    http_response_code(404);
		    exit();
		}
	}

    function ExistEstInDb($my_Db_Connection, $CodigoEst){
		try {
			$my_Select_Statement = 
			$my_Db_Connection->prepare("SELECT count(iden_est) as numUsers FROM alumnos where iden_est = :IdenEst");

			$my_Select_Statement->bindParam(":IdenEst", $CodigoEst);
			$my_Select_Statement->execute();

			$user = $my_Select_Statement -> fetch();	

			if ($user && $user['numUsers'] == 0) {              

				return TRUE;
			}

			return FALSE;
		} catch (Exception $e) {
			echo "Not".$e;
		    http_response_code(404);
		    exit();
		}
	}

    function ExistCursoInDb($my_Db_Connection, $CodigoCurso){
		try {
			$my_Select_Statement = 
			$my_Db_Connection->prepare("SELECT count(codigo_curso) as numUsers FROM cursos where codigo_curso = :IdenCurso");

			$my_Select_Statement->bindParam(":IdenCurso", $CodigoCurso);
			$my_Select_Statement->execute();

			$user = $my_Select_Statement -> fetch();	

			if ($user && $user['numUsers'] == 0) {              

				return TRUE;
			}

			return FALSE;
		} catch (Exception $e) {
			echo "Not".$e;
		    http_response_code(404);
		    exit();
		}
	}

    function ExistMatInDb($my_Db_Connection, $Est,$Curso){
		try {
			$my_Select_Statement = 
			$my_Db_Connection->prepare("SELECT count(estudent) as numUsers FROM alumno_x_curso where estudent = :IdenEst AND  curso = :IdCurso");

			$my_Select_Statement->bindParam(":IdenEst", $Est);
            $my_Select_Statement->bindParam(":IdCurso", $Curso);
			$my_Select_Statement->execute();

			$user = $my_Select_Statement -> fetch();	

			if ($user && $user['numUsers'] == 0) {              

				return TRUE;
			}

			return FALSE;
		} catch (Exception $e) {
			echo "Not".$e;
		    http_response_code(404);
		    exit();
		}
	}

    function UpdateUserKeyDB($my_Db_Connection, $Usuario, $Clave){

        try {

            $my_Insert_Statement = $my_Db_Connection->prepare("UPDATE `usuarios` SET `password_usuario` = :Clave WHERE (`login_usuario` = :Usuario)");

            #Reemplazamos los fatos que se van a insertar en el Query    
            $my_Insert_Statement->bindParam(":Usuario", $Usuario);
            $my_Insert_Statement->bindParam(":Clave", $Clave);

            if ($my_Insert_Statement->execute()) {
                #Retorna numero de filas insertadas en BD
                $count = $my_Insert_Statement -> rowCount();

                if ($count>0) {
                    return TRUE;
                }
                
            } 
            return FALSE;

        } catch (Exception $e) {
            echo "Not".$e;
            http_response_code(404);
            exit();
        }
    }

    function DeleteAlumno($my_Db_Connection, $Alumno){
        try {
            
            $my_Insert_Statement = $my_Db_Connection->prepare("DELETE FROM `alumnos` WHERE  id_alumno = :IdAlumno ");

            $my_Insert_Statement->bindParam(":IdAlumno", $Alumno);

            if ($my_Insert_Statement->execute()) {              

                return TRUE;
                
            } 

            return FALSE;

        } catch (Exception $e) {
            echo "Not".$e;
            http_response_code(404);
            exit();
        }
    }

    function DeleteDocente($my_Db_Connection, $Docente){
        try {
            
            $my_Insert_Statement = $my_Db_Connection->prepare("DELETE FROM `docentes` WHERE  id_docente = :IdDoc ");

            $my_Insert_Statement->bindParam(":IdDoc", $Docente);

            if ($my_Insert_Statement->execute()) {              

                return TRUE;
                
            } 

            return FALSE;

        } catch (Exception $e) {
            echo "Not".$e;
            http_response_code(404);
            exit();
        }
    }

    function DeleteCurso($my_Db_Connection, $Curso){
        try {
            
            $my_Insert_Statement = $my_Db_Connection->prepare("DELETE FROM `cursos` WHERE  id_curso  = :IdCurso ");

            $my_Insert_Statement->bindParam(":IdCurso", $Curso);

            if ($my_Insert_Statement->execute()) {              

                return TRUE;
                
            } 

            return FALSE;

        } catch (Exception $e) {
            echo "Not".$e;
            http_response_code(404);
            exit();
        }
    }
    function DeleteMatricula($my_Db_Connection, $Matricula){
        try {
            
            $my_Insert_Statement = $my_Db_Connection->prepare("DELETE FROM `alumno_x_curso` WHERE  id_alumno_x_curso = :IdMat ");

            $my_Insert_Statement->bindParam(":IdMat", $Matricula);

            if ($my_Insert_Statement->execute()) {              

                return TRUE;
                
            } 

            return FALSE;

        } catch (Exception $e) {
            echo "Not".$e;
            http_response_code(404);
            exit();
        }
    }

    function DeleteUsuario($my_Db_Connection, $Usuario){
        try {
            
            $my_Insert_Statement = $my_Db_Connection->prepare("DELETE FROM `usuarios` WHERE  id_usuario = :IdUsu ");

            $my_Insert_Statement->bindParam(":IdUsu", $Usuario);

            if ($my_Insert_Statement->execute()) {              

                return TRUE;
                
            } 

            return FALSE;

        } catch (Exception $e) {
            echo "Not".$e;
            http_response_code(404);
            exit();
        }
    }
   

?>