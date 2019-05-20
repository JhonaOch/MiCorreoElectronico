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
   
    <title>Administrar Usuario</title>
</head>

<body>
    <header>
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
    </header>
    <div id="contenedor">
        <h2>Administrar Usuarios</h2>
        <section>
            <table>
                <thead>
                    <tr>
                        <td>Cedula</td>
                        <td>Nombre</td>
                        <td>Apellido</td>
                        <td>Direccion</td>
                        <td>Email</td>
                        <td>Telefono</td>
                        <td>Fecha Nacimiento</td>
                        <td>Foto</td>
                        <td>Eliminar</td>
                        <td>Modificar</td>
                        <td>Cambiar contraseña</td>
                    </tr>
                </thead>
                <!--
                <tfoot>
                    <tr>
                        <td colspan="10">
                            <div class="links">
                                <a href="#">&laquo;</a>
                                <a class="active" href="#">1</a>
                                <a href="#">2</a>
                                <a href="#">3</a>
                                <a href="#">4</a>
                                <a href="#">&raquo;</a>
                            </div>
                        </td>
                    </tr>
                </tfoot>
                -->
                <tbody>

                    <?php
                    include '../../../config/conexionBD.php';
                    $sql = "SELECT * FROM usuario";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["usu_cedula"] . "</td>";
                            echo "<td>" . $row["usu_nombres"] . "</td>";
                            echo "<td>" . $row["usu_apellidos"] . "</td>";
                            echo "<td>" . $row["usu_direccion"] . "</td>";
                            echo "<td>" . $row["usu_correo"] . "</td>";
                            echo "<td>" . $row["usu_telefono"] . "</td>";
                            echo "<td>" . $row["usu_fecha_nacimiento"] . "</td>";
                            echo '<td><img src="../../../img/fotos/' . $row["usu_codigo"] . '/' . $row["usu_img"] . '" alt=""></td>';
                            if ((string)$row["usu_eliminado"] === 'N') {
                                echo '<td><a href="../../controladores/admin/BorrarUser.php?usu_cod=' . $row["usu_codigo"] . '&delete=' . true . '">Eliminar</a></td>';
                            } else {
                                echo '<td><a href="../../controladores/admin/BorrareUser.php?usu_cod=' . $row["usu_codigo"] . '">Activar</a></td>';
                            }
                            $user = serialize($row);
                            $user = urlencode($user);
                            echo '<td><a href="ModificarUser.php?user=' . $user . '">Modificar</a></td>';
                            echo '<td><a href="CambiarContra.php?usu_cod=' . $row["usu_codigo"] . '">Cambiar contraseña</a></td>';
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr>";
                        echo '<td colspan="10" class="db_null"><p>No existen usuarios registrados en el sistema</p><i class="fas fa-exclamation-circle"></i></td>';
                        echo "</tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
            <?php
            $cod = isset($_GET["delete"]) ? trim($_GET["delete"]) : null;
            if ($cod == true) {
                echo "<p>Usuario eliminado</p>";
            }
            ?>
        </section>
    </div>
    <footer >
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