<?php
session_start();
if (!isset($_SESSION['isLogin'])) {
    header("Location: ../../../public/vista/login.php");
} elseif ($_SESSION['rol'] == 'admin') {
    header("Location: ../usuario/index.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../../public/vista/Archivos/indexAd.css">
    <link rel="stylesheet" href="../../../public/vista/Archivos/contrasena.css">
    
    
   
    <title>Modificar Contrasña</title>
</head>

<body>
<header>
    <div><h1 class="tittle">Gestion de usuarios</h1></div>
<div >
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="nuevoemail.php">Nuevo Mensaje</a></li>
            <li><a href="enviarmensaje.php">Mensajes Enviados</a></li>
            <li><a href="micuenta.php">Mi Cuenta</a></li>
            <li><a href="">Cerrar Sesion</a></li>
        </ul>
    </nav>
</div>
 </header>

 
 <div id ="contenido2">
            <h2>Cambiar contraseña</h2>       
</div>
<div>
<form action="../../controladores/user/CambiarContra.php" method="post">
    <section>
            <fieldset>
            
                <input type="hidden" name="cod" value="<?php echo ($_GET["usu_cod"]); ?>">
                <input type="password" name="epass" id="epass" required placeholder="Contraseña existente">
                <input type="password" name="pass" id="pass" required placeholder="Nueva contraseña">
                <input type="password" name="cpass" id="cpass" required placeholder="Repetir contraseña">
                <input type="submit" value="Cambiar" class="boton_personalizado">
                </fieldset>
            </form>
        </div>
    </section>
    <footer>
    <small><strong>
    &#169; Todos los derechos reservados
    <br>Jonnathan Enrique Ochoa Calderon 
    <br>Universidad Politecnica Salesiana
    <br>08-05-2019
    </strong>
    </small>
       
    </footer>
</body>

</html>