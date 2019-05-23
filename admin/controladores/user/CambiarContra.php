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
            $epass = isset($_POST["epass"]) ? trim($_POST["epass"]) : null;
            $pass = isset($_POST["pass"]) ? trim($_POST["pass"]) : null;
            $cpass = isset($_POST["cpass"]) ? trim($_POST["cpass"]) : null;
            $cod = isset($_POST["cod"]) ? trim($_POST["cod"]) : null;
            $sql = "SELECT usu_password FROM usuario WHERE usu_codigo='$cod';";
            $result = $conn->query($sql);
            $result = $result->fetch_assoc();
            $date = date(date("Y-m-d H:i:s"));

            if (MD5($epass) === $result["usu_password"]) {
                if ($pass === $cpass) {
                    $sql = "UPDATE usuario SET usu_password = MD5('$pass'), usu_fecha_modificacion='$date' WHERE usu_codigo='$cod'";
                    if ($conn->query($sql) == true) {
                        echo "<h2>Contraseña actualizada con exito</h2><br>";
                        echo '<a id="enlace" href="../../vista/usuario/index.php">Regresar</a>';
                    } else {
                        echo "<h2>Error al actualizar la contraseña " . mysqli_error($conn) . "</h2><br>";
                        echo '<a id="enlace" href="../../vista/usuario/CambiarContra.php?usu_cod=' . $cod . '">Regresar</a>';
                    }
                } else {
                    echo "<h2>Las contraseñas no coinciden</h2><br>";
                    echo '<a id="enlace" href="../../vista/usuario/CambiarContra.php?usu_cod=' . $cod . '">Regresar</a>';
                }
            } else {
                echo "<h2>La contraseña no existe en el sistema</h2><br>";
                echo '<a  id="enlace" href="../../vista/usuario/CambiarContra.php?usu_cod=' . $cod . '">Regresar</a>';
            }
            $conn->close();

            ?>


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