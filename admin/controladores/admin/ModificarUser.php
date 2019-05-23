<?php
session_start();
if (!isset($_SESSION['isLogin'])) {
    header("Location: ../../../public/vista/login.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<link rel="stylesheet" href="../../../public/vista/Archivos/indexAd.css">
    <link rel="stylesheet" href="../../../public/vista/Archivos/Tabla.css">
    <link rel="stylesheet" href="../../../public/vista/Archivos/imagen.css">
    
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="">
    <title>Modificar Usuario</title>
</head>

<body>
<header>
        <h1>Gestion de usuarios</h1>
        <div>
            <nav>
                <ul>
                    <li><a href="../../vista./usuario/index.php">Inicio</a></li>
                    <li><a href="../../vista./usuario/UsuariosTabla.php">Usuarios</a></li>
                    <li><a href="../../vista./usuario/micuenta.php">Mi cuenta</a></li>
                    
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

    <h2></h2>

    <section>

        <div>
            <?php
            include '../../../config/conexionBD.php';

            $foto = $_FILES['foto']['name'];
            $temp = $_FILES['foto']['tmp_name'];
            $type = $_FILES['foto']['type'];


            move_uploaded_file($temp, "../../../img/fotos/" . $_POST["usu_codigo"] . "/$foto");


            $cedula = isset($_POST["cedula"]) ? trim($_POST["cedula"]) : null;
            $nombre = isset($_POST["nombre"]) ? mb_strtoupper(trim($_POST["nombre"]), 'UTF-8') : null;
            $apellido = isset($_POST["apellido"]) ? mb_strtoupper(trim($_POST["apellido"]), 'UTF-8') : null;
            $direccion = isset($_POST["direccion"]) ? mb_strtoupper(trim($_POST["direccion"]), 'UTF-8') : null;
            $telefono = isset($_POST["telefono"]) ? trim($_POST["telefono"]) : null;
            $email = isset($_POST["email"]) ? trim($_POST["email"]) : null;
            $fechaNac = isset($_POST["fechaNac"]) ? trim($_POST["fechaNac"]) : null;
            $cod = $_POST["usu_codigo"];
            $date = date(date("Y-m-d H:i:s"));

            $sql = "UPDATE usuario SET
                        usu_cedula='" . $cedula . "',
                        usu_nombres='" . $nombre . "',
                        usu_apellidos='" . $apellido . "',
                        usu_direccion='" . $direccion . "',
                        usu_telefono='" . $telefono . "',
                        usu_correo='" . $email . "',
                        usu_fecha_nacimiento='$fechaNac',
                        usu_fecha_modificacion='$date',
                        usu_img='" . $_FILES['foto']['name'] . "'
                        WHERE usu_codigo='$cod'";

            if ($conn->query($sql) == true) {
                echo "<h2>Datos actualizados con exito</h2>";
            } else {
                if ($conn->errno == 1062) {
                    echo "<h2>La cedula $cedula ya existe</h2>";;
                } else {
                    echo "<h2>Error al actualizar losa datos " . mysqli_error($conn) . "</h2>";
                }
            }
            $conn->close();
            ?>
            <br>
            <a href="../../vista/admin/UsuariosTabla.php" id="enlace">Regresar</a>
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