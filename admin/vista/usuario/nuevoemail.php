<?php
session_start();
if (!isset($_SESSION['isLogin'])) {
    header("Location: ../../../public/vista/login.php");
} elseif ($_SESSION['rol'] == 'admin') {
    header("Location: ../admin/index.php");
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

    <h2>Nuevo Mensaje</h2>

    </header>
    <section>
        <div id=contenido>
            <form action="../../controladores/user/nuevoemail.php" method="POST">
                <fieldset>
                    <input type="hidden" name="codigoRemitente" value="<?php echo ($_SESSION['codigo']) ?>">
                    <label>Correo</label>
                    <input type="mail" name="emailDestino" id="emailDestino" required placeholder="Correo de destino" required>
                    <label>Asunto</label>
                    <input type="text" name="asunto" id="asunto" placeholder="Asunto" required>
                    <label>Mensaje</label>
                    <textarea name="mensaje" id="mensaje" cols="50" rows="20" placeholder="Escriba su texto..." required></textarea>
                    <input type="submit" value="Enviar" class="boton_personalizado">
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