<head>
    <link rel="stylesheet" href="libs/css/navBarStyle.css">   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>  
</head>

<?php
    $anticsrf =random_int(501, 9999999);
    $_SESSION['anticsrf'] = $anticsrf;
    function loguedUser($userData){
        #Header
        echo '

        <label>Usuario:</label>'.$userData['login_sesion'].'</h3>
        '
        ;        
    
    }
?>

