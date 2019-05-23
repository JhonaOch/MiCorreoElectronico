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

    <h2>Estado</h2>
    <section>

        <div id="contenido">

            <?php
            include '../../../config/conexionBD.php';
            $codigoRemitente = isset($_POST["codigoRemitente"]) ? trim($_POST["codigoRemitente"]) : null;
            $emailDestino = isset($_POST["emailDestino"]) ? trim($_POST["emailDestino"]) : null;
            $asunto = isset($_POST["asunto"]) ? trim($_POST["asunto"]) : null;
            $mensaje = isset($_POST["mensaje"]) ? trim($_POST["mensaje"]) : null;
            $sql = "SELECT usu_codigo FROM usuario WHERE usu_correo ='$emailDestino';";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $codigoDestino = $row["usu_codigo"];
            $sqlInsert = "INSERT INTO mensaje VALUES (
                0, 
                null, 
                '$asunto', 
                '$mensaje', 
                '$codigoRemitente', 
                '$codigoDestino'  
            )";
            if ($conn->query($sqlInsert) == true) {
                echo "<h2>Mensaje enviado</h2><br>";
                echo '<a id="enlace" href="../../vista/usuario/enviarmensaje.php">Regresar</a>';
            } else {
                echo "<h2>Error al enviar el mensaje: " . mysqli_error($conn) . "</h2><br>";
                echo '<a id="enlace" href="../../vista/usuario/nuevoemail.php">Regresar</a>';
            }
            $conn->close();
            ?>

        </div>
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