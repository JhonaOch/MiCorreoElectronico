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
    <link rel="stylesheet" href="../../../css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css"
        integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <title>Modificar Usuario</title>
</head>

<body>
    <header>
        <h1 class="tittle">Gestion de usuarios</h1>
        <div class="menu">
            <nav>
                <ul>
                    <li><a href="../../vista/usuario/index.php">Inicio</a></li>
                    <li><a href="../../vista/usuario/UsuariosTabla.php">Usuarios</a></li>
                    <li><a href="../../vista/usuario/micuenta.php">Mi cuenta</a></li>
                    <li><a href="../../../config/sessionEnd.php">Cerrar Sesion</a></li>
                </ul>
            </nav>
        </div>
        <div class="user">
            <div class="userImg">
                <div class="imagen">
                    <img src="<?php echo ('../../../img/fotos/' . $_SESSION["codigo"] . '/' . $_SESSION["img"]) ?>"
                        alt="">
                </div>
                <p><span><?php echo ($_SESSION['nombre'] . ' ' . $_SESSION['apellido']) ?></span></p>
            </div>
        </div>
    </header>
    <section>
        <div class="formulario crear_usuario">
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
                        noerro();
                    } else {
                        echo "<h2>Error al actualizar la contraseña " . mysqli_error($conn) . "</h2>";
                        error($cod);
                    }
                } else {
                    echo "<h2>Las contraseñas no coinciden</h2>";
                    error($cod);
                }
            } else {
                echo "<h2>La contraseña no existe en el sistema</h2>";
                error($cod);
            }
            $conn->close();
            function noerro()
            {
                echo "<h2>Contraseña actualizada con exito</h2>";
                echo '<i class="far fa-check-circle"></i>';
                echo '<a href="../../vista/admin/UsuariosTabla">Regresar</a>';
            }
            function error($cod)
            {
                echo '<i class="fas fa-exclamation-circle"></i>';
                echo '<a href="../../vista/admin/CambiarContra.php?usu_cod=' . $cod . '">Regresar</a>';
            }
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