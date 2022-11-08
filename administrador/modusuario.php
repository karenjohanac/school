<!DOCTYPE html>
<html>
<head>
    <meta charset= "UTF-8">
	<title> Perfil </title>
    <link rel="stylesheet" href="libs/css/estilo.css">   
 </head>
<body>
    <center>
    <?php
        require_once "userInfoBar.php";
        require_once "libs/php/utils.php";
        require_once "libs/php/connect.php";

        SafeStart();
        $anticsrf =random_int(501, 9999999);
        $_SESSION['anticsrf'] = $anticsrf;

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
                    header("Location:login.php");
        
                    exit();
                }
          } else {
            //Activamos sesion tiempo.
            $_SESSION['tiempo'] = time();
        }

        if(isset($_SESSION['loged_user'])){
            loguedUser($_SESSION['loged_user']);
        }else{
            header('location: login.php');
        }

        if(isset($_POST['btnCambio'])){
            header('location: cambioclave.php');
        }

        if(isset($_POST['btnActualizar'])){

            
    
            $user = [                
                'Nombre_sess' => $_POST['txtNombre'],
                'Apellido_sess' => $_POST['txtApellido'],
                'Correo_sess' => $_POST['txtCorreo'],
                'Direccion_sess' => $_POST['txtDir'],
                'Childs_sess' => $_POST['txtNumHij'],
                'Estado_civil_sess' => $_POST['txtEstCivil'],
                'Foto_sess' => uploadPhoto(),
                'User_sess' => $_SESSION['loged_user']['User_sess'],
            ];
    
            updateDataUser($user, $_SESSION['loged_user']);  
            $_POST = LimpiaEntrada(); 
    
        }

        function updateDataUser($userToUpdate, $usersData){

            $userToUpdate = ValidateUpdateData($usersData, $userToUpdate);
            
            if($userToUpdate['User_sess'] == $usersData['User_sess']){
                $dbConnection = DBConnection();
                if($dbConnection){
                    $updateStatus = UpdateUserDB($dbConnection, $userToUpdate['Nombre_sess'], $userToUpdate['Apellido_sess'], $userToUpdate['Correo_sess'],
                                    $userToUpdate['Direccion_sess'], $userToUpdate['Childs_sess'], $userToUpdate['Estado_civil_sess'], $userToUpdate['Foto_sess'], $usersData['User_sess']);
                                    $_POST = LimpiaEntrada();
                    if($updateStatus){
                        $_SESSION['loged_user'] = $userToUpdate;
                        echo '<h3>Datos del usuario actualizados</h3>';
                    }else{
                        echo '<h3>No hay cambios para realizar.</h3>';
                    }
                }else{
                    echo '<h3>Algo salio mal conectando con la BD</h3>';
                }
    
            }else{
                echo '<h3>No Puede actualizar los datos de este usuario</h3>';
            }
    
        }

        function ValidateUpdateData($UserData, $UserDataToUpdate){
            foreach ($UserDataToUpdate as $key => $value) {
                
                if($value == NULL || $value == ''){
                    $UserDataToUpdate[$key] = $UserData[$key];
                }
                       
              }
              return $UserDataToUpdate;
        }

        function uploadPhoto(){
            $validExtensions = array("jpg", "JPG", "png", "PNG", "jpeg", "JPEG", "gif", "GIF", "tiff", "TIFF", "svg", "SVG");
            $txtFoto = '';
            if (isset($_FILES['fulFoto'])) {
                $fileTmpPath = $_FILES['fulFoto']['tmp_name'];//conversor para bds
                $fileName = $_FILES['fulFoto']['name']; //nombre
                #$fileSize = $_FILES['upPhoto']['size'];//tamaño
                #$fileType = $_FILES['upPhoto']['type'];//tipo imagen
                $fileNameCmps = explode(".", $fileName); //extension
                $fileExtension = strtolower(end($fileNameCmps));//extension

                if ($fileName != '' && in_array($fileExtension, $validExtensions)) { 
                    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;		//carga la imagen en bds			
                    // directory in which the uploaded file will be moved
                    $uploadFileDir = './images/'; //donde se gusrda la imagen
                    $dest_path = $uploadFileDir . $newFileName; 
                    if(move_uploaded_file($fileTmpPath, $dest_path)) //funcion para asegurar que subio la imagen
                    {
                        $message ='Archivo subido.';
                    }
                    $txtFoto = $dest_path; //asegurar que este cargando en el el txtfoto 
                }
            }  
            if($txtFoto == '') {
                $txtFoto = $_SESSION['loged_user']['Foto_sess'];
            }     
            
            return $txtFoto;    
        }
        
    ?>
<div align="left">
    <button type="button" onclick="location.href='login.php'"  class="btn btn-info">Volver</button>
    </div>
    

    <form action="" method="POST" enctype="multipart/form-data" class="formRegistro" required>

        <h2> Registro </h2>
        <label for="txtNombre">Nombre:</label>
        <input type="text" name="txtNombre" id="txtNombre" pattern="[A-Za-z0-9][^<->]{1,20}" required placeholder="Ingrese su Nombre">
        <br>
        <br>

        <label for="txtCorreo">Correo:</label>
        <input type="text" name="txtCorreo" id="txtCorreo" pattern="[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*@[a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{1,5}" required placeholder="Ingrese su E-mail">
        <br>
        <br>

        <label for="txtUsuario">Usuario:</label> 
        <input type="text" name="txtUsuario" id="txtUsuario" pattern="[A-Za-z]{1-20}" required placeholder="Ingrese su Username">
        <br>
        <br>

        <label for="txtClave">Password:</label> 
        <input type="password" name="txtClave" id="txtClave"pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*_=+-]).{5,28}$" required placeholder="Ingrese su contraseña">
        <br>
        <br>

        <label for="txtEstado">Estado del registro:</label> 
        <select name="txtEstado" required>
                <option selected value="">Seleccione...</option>
		        <option value="Activo">Activo</option>
		        <option value="Inactivo">Inactivo</option>
        </select>
        <br>
        <br>

        <label for="txtRol">Rol:</label> 
        <select name="txtRol" required>
                <option selected value="">Seleccione...</option>
		        <option value="Usuario">Usuario</option>
		        <option value="Administrador">Administrador</option>
        </select>
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
