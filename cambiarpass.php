<!DOCTYPE html>
<html>
<head>
    <meta charset= "UTF-8">
	<title>Cambiar Password</title>
 </head>
<body>

    <center>
       
        <?php
            require_once "./utils.php";
            require_once "./conection.php";
            require_once "./userInfoBar.php";

            SafeStart();
            $anticsrf =random_int(501, 9999999);
            $_SESSION['anticsrf'] = $anticsrf;

            if(isset($_POST['btnActualizar'])){
                
        
                if(ValidateForm($_POST)){
                    validateNewPassword($_POST['txtAnterior'], 
                    $_POST['txtNueva'], 
                    $_POST['txtRepetir']);
                LimpiaEntrada();
                }else{
                    echo '<h3>Hay campos en blanco, por favor, completelos.</h3><br>';
                }       
            }

            function validateNewPassword($currentPass, $newPass, $newPassConf){

                #Validar si la contraseña actual es correcta
                if($newPass == $newPassConf){
                    $dbConnection = DBConnection();
                    if($dbConnection){
            
                        $dataUser = ValidarLoginDB($dbConnection, $_SESSION['loged_user']['login_sesion'], md5($currentPass));
            
                        if($dataUser != ""){
                            changePassword($newPass, $_SESSION['loged_user']['login_sesion']);
                            LimpiaEntrada();
                        }else{
                            echo '<h3>La contraseña actual no coincide.</h3><br>';                       
                        }
                        
                                        
                    }else{
                        echo '<h3>Error al conectar con BD</h3><br>';
                    }
                }else{
                    echo '<h3>La confirmación de la contraseña no coincide con la nueva, vuelva a intentar.</h3><br>';
                }          
        
            }

            function changePassword($newPass, $user){

                $dbConnection = DBConnection();
                if($dbConnection){
                    $isUpdated = UpdateUserKeyDB($dbConnection, $user, md5($newPass));
                    LimpiaEntrada();
                    if($isUpdated){                    
                        header("Location:login.php");
                    } else{
                        echo '<h3>No se pudo cambiar la contraseña, intente nuevamente.</h3><br>';   
                    }   
                }else{
                    echo '<h3>Error al conectar con BD</h3><br>';
                }
                
            }
            require './navbar1.php';

        ?>
<br>

            <form method="post" enctype="multipart/form-data">
                <h2>Cambio Clave</h2>
                <br>                  
            
                <label for="txtAnterior">Clave Actual</label>
                <input type="password" name="txtAnterior" id="txtAnterior">
                <br>
                <br>
            
                <label for="txtNueva">Nueva Clave</label>
                <input type="password" name="txtNueva" id="txtNueva">
                <br>
                <br>

                <label for="txtRepetir">Confirmar Nueva Clave</label>
                <input type="password" name="txtRepetir" id="txtRepetir">
                <br>
                <br>
                <div class = "form-group">
		        <input type="hidden"  value="<?php echo $anticsrf; ?>" class="form-control" name="anticsrf">
		        </div>
                    <button type="submit" name="btnActualizar" value="Actualizar">Actualizar</button>
                </div>
                    
                <br>
                
            </form>
      

    </center>
</body>
