<?php
function LimpiarCadena($cadena){ 
    $patron = array('/<script>.*<\/script>/', '/..\*/');
    $cadena = preg_replace($patron, '', $cadena);
    $cadena = htmlspecialchars($cadena);
    return $cadena;
}

function LimpiaEntrada()
{
    if(isset($_POST)){
        foreach($_POST as $key => $value){
            $_POST[$key] = LimpiarCadena($value);
        }
    }
}

function ValidarLoginDB($my_Db_Connection, $usuario, $clave){

    try {
        $my_Select_Statement = $my_Db_Connection->prepare("SELECT login_usuario, password_usuario, nombre_usuario, email_usuario 
                                    FROM usuarios WHERE login_usuario = :Usuario AND password_usuario = :Clave");

        $my_Select_Statement->bindParam(":Usuario", $usuario);
        $my_Select_Statement->bindParam(":Clave", $clave);
        $my_Select_Statement->execute();

        $user = $my_Select_Statement -> fetch();	

        if ($user) {
            $userData = [
                'login_sesion' => $user['login_usuario'],
                'password_sesion' => $user['password_usuario'],
                'nombre_sesion' => $user['nombre_usuario'],
                'email_sesion' => $user['email_usuario'],
           ];	

            return $userData;
        }

        return '';
    } catch (Exception $e) {
        echo "Not".$e;
        http_response_code(404);
        exit();
    }
}

function ValidateForm($postData){
    foreach ($postData as $key => $value) {
        
        if($value == NULL || $value == ''){
            return FALSE;
            exit();
        }
               
      }
      return TRUE;
}

/** Activa la presentación de errores */
function MostrarErrores(){
    error_reporting(E_ALL);     // Comentar para noo mostrar errores
    ini_set('display_errors', '1'); // Comentar para noo mostrar errores
}

function SafeStart() {
    // Inicio y control de la sesión
    $secure = false;
    //mejor en config.php Lo ideal sería true para trabajar con https
    $httponly = true;
    // Obliga a la sesión a utilizar solo cookies.
    // Habilitar este ajuste previene ataques que impican pasar el id de sesión en la URL.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        $action = "error";
        $error = "No puedo iniciar una sesion segura (ini_set)";
    }
    // Obtener los parámetros de la cookie de sesión
    $cookieParams = session_get_cookie_params();
    $path = "/";
    //session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
    //Marca la cookie como accesible sólo a través del protocolo HTTP.
    $samesite = 'strict';
    session_set_cookie_params([
        'lifetime' => $cookieParams["lifetime"],
        'path' => $path,
        'domain' => $_SERVER['HTTP_HOST'],
        'secure' => $secure,
        'httponly' => $httponly,
        'samesite' => $samesite
    ]);
    // Inicio y control de la sesión
    session_start();
    session_regenerate_id(true);
}



?>