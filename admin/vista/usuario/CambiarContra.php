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
    <link rel="stylesheet" href="../../../public/vista/Archivos/Tabla.css">
    <link rel="stylesheet" href="../../../public/vista/Archivos/imagen.css">
    <link rel="stylesheet" href="../../../public/vista/Archivos/fielsed.css">
</head>

<body>
    <header>
        <h1>Gestion de usuarios</h1>
        <div>
            <nav>
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="nuevoemail.php">Nuevo Mensaje</a></li>
                    <li><a href="enviarmensaje.php">Enviados</a></li>
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

            <form action="../../controladores/user/CambiarContra.php" method="post">

                <fieldset>
                    <input type="hidden" name="cod" value="<?php echo ($_GET["usu_cod"]); ?>">
                    <label>Contraseña Existente</label>
                    <br>
                    <input type="password" name="epass" id="epass" required placeholder="Contraseña existente">
                    <label>Nueva Contraseña </label>
                    <br>
                    <input type="password" name="pass" id="pass" required placeholder="Nueva contraseña">
                    <label>Repita su Contraseña </label>
                    <br>
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