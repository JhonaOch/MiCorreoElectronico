<?php
session_start();
if (!isset($_SESSION['isLogin'])) {
    header("Location: ../../../public/vista/login.php");
} elseif ($_SESSION['rol'] == 'user') {
    header("Location: ../usuario/index.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../../public/vista/Archivos/indexAd.css">
    <link rel="stylesheet" href="../../../public/vista/Archivos/Tabla2.css">
    <link rel="stylesheet" href="../../../public/vista/Archivos/Tabla.css">
     <title>Modificar Contrasña</title>
</head>

<body>
    <header>
       
    <h1 class="tittle">Gestion de usuarios</h1>
<div class="menu">
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="UsuariosTabla.php">Usuarios</a></li>
            <li><a href="micuenta.php">Mi cuenta</a></li>
            <li><a href="">Cerrar Sesion</a></li>
        </ul>
    </nav>
</div>
<div class="user">
    <div class="userImg">
        <div class="imagen">
            <img src="<?php echo ('../../../img/fotos/' . $_SESSION["codigo"] . '/' . $_SESSION["img"]) ?>" alt="">
        </div>
        <p><span><?php echo ($_SESSION['nombre'] . ' ' . $_SESSION['apellido']) ?></span></p>
    </div>
</div>
    </header>
    <section>
        <div class="contenido2">
            <h2>Cambiar contraseña</h2>
            <form action="../../controladores/admin/CambiarContra.php" method="post">
                <input type="hidden" name="cod" value="<?php echo ($_GET["usu_cod"]); ?>">
                <input type="password" name="epass" id="epass" required placeholder="Contraseña existente">
                <input type="password" name="pass" id="pass" required placeholder="Nueva contraseña">
                <input type="password" name="cpass" id="cpass" required placeholder="Reapetir contraseña">
                <input type="submit" value="Cambiar">
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