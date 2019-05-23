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
    <link rel="stylesheet" href="../../../public/vista/Archivos/Tabla.css">
    <link rel="stylesheet" href="../../../public/vista/Archivos/imagen.css">
    <link rel="stylesheet" href="../../../public/vista/Archivos/fielsed.css">
    <title>Modificar Contrasña</title>
</head>

<body>
<header>
        <h1>Gestion de usuarios</h1>
        <div>
            <nav>
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="UsuariosTabla.php">Usuarios</a></li>
                    <li><a href="micuenta.php">Mi cuenta</a></li>
                    
                </ul>
                  <div class="user">
                    <div class="userImg">
                        <div class="imagen">
                            <img src="<?php echo ('../../../img/fotos/' . $_SESSION["codigo"] . '/' . $_SESSION["img"]) ?>" alt="">
                        </div>
                        <p><span><?php echo ($_SESSION['nombre'] . ' ' . $_SESSION['apellido']) ?></span></p>
                    </div>
            </nav>
    </header>

    <h2>Cambiar contraseña</h2>
    <section>
        <div id="contenido"> 
            <fieldset>
            <form action="../../controladores/admin/CambiarContra.php" method="post">
                <input type="hidden" name="cod" value="<?php echo ($_GET["usu_cod"]); ?>">
                <label >Contraseña Existente</label>
                <br>
                <input type="password" name="epass" id="epass" required placeholder="Contraseña existente">
                <br>
                <label >Nueva Contraseña </label>
                <br>
                <input type="password" name="pass" id="pass" required placeholder="Nueva contraseña">
                <br>
                <label >Repita su Contraseña </label>
                <br>
                <input type="password" name="cpass" id="cpass" required placeholder="Repetir contraseña">
                <input type="submit" value="Cambiar" class="boton_personalizado">
            </form>
            </fieldset>
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