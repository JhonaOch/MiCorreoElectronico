# MiCorreoElectronico


 	FORMATO DE INFORME DE PRÁCTICA DE LABORATORIO / TALLERES / CENTROS DE SIMULACIÓN – PARA ESTUDIANTES

CARRERA: Computación 	ASIGNATURA: HIPERMEDIAL
NRO. PRÁCTICA:	1	TÍTULO PRÁCTICA: Resolución de problemas sobre CSS3
OBJETIVO ALCANZADO:
•	Entender y organizar de una mejor manera los sitios de web en Internet.
•	Diseñar adecuadamente elementos gráficos en sitios web en Internet. 
•	Crear sitios web aplicando estándares actuales.
ACTIVIDADES DESARROLLADAS

•	Agregar roles a la tabla usuario. Un usuario puede tener un rol de “admin” o “user” 
•	Los usuarios con rol de “admin” pueden únicamente: modificar, eliminar y cambiar la contraseña de cualquier usuario de la base de datos. 
•	Los usuarios con rol de “user” pueden modificar, eliminar y cambiar la contraseña de su usuario.

•	Tabla con roles Admin y User
 
•	Creación de roles en la base de datos y agregación de rol 
•	METODOS DEL ROL ADMIN 
<?php
            session_start();
            include '../../config/conexionBD.php';
            $email = isset($_POST["email"]) ? trim($_POST["email"]) : null;
            $pass = isset($_POST["pass"]) ? trim($_POST["pass"]) : null;
            $sql = "SELECT * FROM usuario WHERE usu_correo ='$email' AND usu_password = MD5('$pass')";

            $result = $conn->query($sql);
            $user = $result->fetch_assoc();
            if ($result->num_rows > 0) {
                $_SESSION['isLogin'] = true;
                $_SESSION['codigo'] = $user["usu_codigo"];
                $_SESSION['nombre'] = $user["usu_nombres"];
                $_SESSION['apellido'] = $user["usu_apellidos"];
                $_SESSION['img'] = $user["usu_img"];
                $_SESSION['rol'] = $user["usu_rol"];

                if ($_SESSION['rol'] == 'admin') {
                    header("Location:../../admin/vista/admin/index.php");
                } else {
                    header("Location:../../admin/vista/usuario/index.php");
                }
            } else {
                echo "<h2>Datos de inicio incorrecto </h2>";;
                header("Location:../vista/login.php");
            }
            $conn->close();
            ?>

•	CONTROLADORES ADMIN
 


•	BorrarUser

<?php
session_start();
if (!isset($_SESSION['isLogin'])) {
    header("Location: ../../../public/vista/login.php");
} elseif ($_SESSION['rol'] == 'user') {
    header("Location: ../usuario/index.php");
}
?>
<?php
include '../../../config/conexionBD.php';
$cod = isset($_GET["usu_cod"]) ? trim($_GET["usu_cod"]) : null;
$delete = isset($_GET["delete"]) ? trim($_GET["delete"]) : null;
$date = date(date("Y-m-d H:i:s"));

if ($cod != null and $delete == true) {
    $sql = "UPDATE usuario SET usu_eliminado='S', usu_fecha_modificacion='$date' WHERE usu_codigo='$cod';";
    $result = $conn->query($sql);
    header("Location: ../../vista/admin/UsuariosTabla.php");
} elseif ($cod != null and $delete == false) {
    $sql = "UPDATE usuario SET usu_eliminado='N', usu_fecha_modificacion='$date' WHERE usu_codigo='$cod';";
    $result = $conn->query($sql);
    header("Location: ../../vista/admin/UsuariosTabla.php");
} else {
    header("Location: ../../vista/admin/UsuariosTabla.php");
}
$conn->close();
?>

•	CambiarContra
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
                    <li><a href="">Cerrar Sesion</a></li>
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
        <div id=contenido>
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
                        
                        echo ' <a  id="enlace" href="../../vista/admin/UsuariosTabla.php">Regresar</a>';
                    } else {
                        echo "<h2>Error al actualizar la contraseña " . mysqli_error($conn) . "</h2>";
                        echo ' <a  id="enlace" href="../../vista/admin/CambiarContra.php?usu_cod=' . $cod . '">Regresar</a>';
                    }
                } else {
                    echo "<h2>Las contraseñas no coinciden</h2><br>";
                    echo '  <a  id="enlace" href="../../vista/admin/CambiarContra.php?usu_cod=' . $cod . '">Regresar</a>';
                }
            } else {
                echo "<h2>La contraseña no existe en el sistema</h2><br>";
                echo ' <a  id="enlace" href="../../vista/admin/CambiarContra.php?usu_cod=' . $cod . '">Regresar</a>';
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

•	eliminarMSJ
<?php
session_start();
if (!isset($_SESSION['isLogin'])) {
    header("Location: ../../../public/vista/login.php");
} elseif ($_SESSION['rol'] == 'user') {
    header("Location: ../usuario/index.php");
}
?>
<?php
include '../../../config/conexionBD.php';
$cod = isset($_GET["usu_cod"]) ? trim($_GET["usu_cod"]) : null;
$sql = "DELETE FROM mensaje WHERE mail_codigo='$cod';";
if ($conn->query($sql) == true) {
    echo "Mensaje Eliminado";
    header("Location: ../../vista/admin/index.php");
}
$conn->close();
?>

•	ModificarUser
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




•	Controlador User
 
•	Buscar
<?php
session_start();
if (!isset($_SESSION['isLogin'])) {
    header("Location: ../../../public/vista/login.php");
} elseif ($_SESSION['rol'] == 'admin') {
    header("Location: ../usuario/index.php");
}
include '../../../config/conexionBD.php';

if ($_GET != '') {

    $sql = "SELECT * FROM usuario usu, mensaje msj WHERE usu.usu_codigo=msj.usu_remitente AND 
    msj.usu_destino=" . $_SESSION['codigo'] . " AND
    usu.usu_correo LIKE '" . $_GET['key'] . "%';";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["mail_fecha"] . "</td>";
            echo "<td>" . $row["usu_correo"] . "</td>";
            echo "<td>" . $row["mail_asunto"] . "</td>";
            echo '<td><a href="#">Leer</a></td>';
        }
    } else {
        echo "<tr>";
        echo '<td colspan="10" ><p>No hay resultados...</p></td>';
        echo "</tr>";
    }
} else {
    $sql = "SELECT * FROM usuario usu, mensaje msj WHERE usu.usu_codigo=msj.usu_remitente AND 
                    msj.usu_destino=" . $_SESSION['codigo'] . ";";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["mail_fecha"] . "</td>";
            echo "<td>" . $row["usu_correo"] . "</td>";
            echo "<td>" . $row["mail_asunto"] . "</td>";
            echo '<td><a href="#">Leer</a></td>';
        }
    } else {
        echo "<tr>";
        echo '<td colspan="10" "><p>No tienes mensajes recibidos</p></td>';
        echo "</tr>";
    }
}
$conn->close();

•	CambiarContra
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
•	Leer
<?php
session_start();
if (!isset($_SESSION['isLogin'])) {
    header("Location: ../../../public/vista/login.php");
} elseif ($_SESSION['rol'] == 'admin') {
    header("Location: ../../vista/admin/index.php");
}
include '../../../config/conexionBD.php';
$sql = "SELECT * FROM usuario usu, mensaje msj WHERE usu.usu_codigo=msj." . $_GET['code'] . " AND
                    msj.mail_codigo =" . $_GET['id'] . ";";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
echo ('<div class="formulario window">
    <p><span>' . $_GET['dest'] . '  </span>' . $row["usu_correo"] . '</p>
    <p><span>Asunto: </span>' . $row["mail_asunto"] . '</p>
    <p class="msj">' . $row["mail_mensaje"] . '</p>
    <input  type="button" value="Cerrar" onclick="cluseWindow()">
</div>');
•	ModificarUser
<?php
session_start();
if (!isset($_SESSION['isLogin'])) {
    header("Location: ../../../public/vista/login.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
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

    <h2>Editar Datos</h2>
    <section>
        <div id="contenido">
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
                echo "<h2>Datos actualizados con exito</h2><br>";
            } else {
                if ($conn->errno == 1062) {
                    echo "<h2>La cedula $cedula ya existe</h2><br>";
                } else {
                    echo "<h2>Error al actualizar los datos " . mysqli_error($conn) . "</h2> <br>";
                }
            }
            $conn->close();
            ?>
            <a  id="enlace" href="../../vista/usuario/index.php">Regresar</a>
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
•	Nuevo email
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

•	Vista Admin
 

•	CambiarContra
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

•	Index
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

    <h2>Mensajes Electronicos</h2>

    <div id="contenido">
        <section>
            <br>
            <br>
            <br>
            
                
                <table>
                    <thead>
                        <tr>
                            <td>Fecha</td>
                            <td>Remitente</td>
                            <td>Destino</td>
                            <td>Asunto</td>
                            <td></td>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        include '../../../config/conexionBD.php';

                        $sql = "SELECT * FROM mensaje INNER JOIN usuario ON mensaje.usu_destino = usuario.usu_codigo ORDER BY 1;";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["mail_fecha"] . "</td>";
                                $sqlRemitente = "SELECT usu_correo FROM usuario WHERE usu_codigo=" . $row["usu_remitente"] . ";";
                                $resultRemitente = $conn->query($sqlRemitente);
                                $rowRemitente = $resultRemitente->fetch_assoc();
                                echo "<td>" . $rowRemitente["usu_correo"] . "</td>";
                                $sqlDestino = "SELECT usu_correo FROM usuario WHERE usu_codigo=" . $row["usu_destino"] . ";";
                                $sqlDestino = $conn->query($sqlDestino);
                                $rowDestino = $sqlDestino->fetch_assoc();
                                echo "<td>" . $rowDestino["usu_correo"] . "</td>";
                                echo "<td>" . $row["mail_asunto"] . "</td>";
                                echo '<td><a href="../../controladores/admin/eliminarMSJ.php?usu_cod=' . $row["mail_codigo"] . '">Eliminar</a></td>';
                            }
                        } else {
                            echo "<tr>";
                            echo '<td colspan="10" ><p>No tienes mensajes recibidos</p></td>';
                            echo "</tr>";
                        }
                        $conn->close();
                        ?>

                    </tbody>
                </table>
           

        </section>
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

•	Mi cuenta
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
    <h2>Mi Cuenta</h2>
    <div id=contenido>
        <section>
            <br>
            <br>
            <br>
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
                <tbody>
                    <?php
                    include '../../../config/conexionBD.php';
                    $sql = "SELECT * FROM usuario WHERE usu_codigo=" . $_SESSION['codigo'] . ";";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
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
                            echo '<td><a href="../../controladores/admin/BorrarUser.php?usu_cod=' . $row["usu_codigo"] . '">Activar</a></td>';
                        }
                        $user = serialize($row);
                        $user = urlencode($user);
                        echo '<td><a href="ModificarUser.php?user=' . $user . '">Modificar</a></td>';
                        echo '<td><a href="CambiarContra.php?usu_cod=' . $row["usu_codigo"] . '">Cambiar contraseña</a></td>';
                        echo "</tr>";
                    } else {
                        echo "<tr>";
                        echo '<td colspan="10" ><p>No existen usuarios registrados en el sistema</p></td>';
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

•	ModificarUser
<?php
session_start();
if (!isset($_SESSION['isLogin'])) {
    header("Location: ../../../public/vista/login.php");
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
    <h2>Editar Datos</h2>
    <section>
        <div id=contenido>
            <?php
            $data = $_GET["user"];
            $datos = stripslashes($data);
            $datos = urldecode($datos);
            $datos = unserialize($datos);
            ?>
            <form enctype="multipart/form-data" action="../../controladores/admin/ModificarUser.php" method="post">
                <fieldset>
                    <input type="hidden" name="usu_codigo" value="<?php echo ($datos["usu_codigo"]); ?>">
                    <label for="cedula">Cedula</label>
                    <input type="text" name="cedula" id="cedula" value="<?php echo ($datos["usu_cedula"]); ?>" required>
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" value="<?php echo ($datos["usu_nombres"]); ?>" required>
                    <label for="apellido">Apellido</label>
                    <input type="text" name="apellido" id="apellido" value="<?php echo ($datos["usu_apellidos"]); ?>" required>
                    <label for="direccion">Direccion</label>
                    <input type="text" name="direccion" id="direccion" value="<?php echo ($datos["usu_direccion"]); ?>" required>
                    <label for="telefono">Telefono</label>
                    <input type="text" name="telefono" id="telefono" value="<?php echo ($datos["usu_telefono"]); ?>" required>
                    <label for="fechaNac">Fecha de nacimiento</label>
                    <input type="date" name="fechaNac" id="fechaNac" value="<?php echo ($datos["usu_fecha_nacimiento"]); ?>" required>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo ($datos["usu_correo"]); ?>" required>
                    <label for="foto">Foto de perfil</label>
                    <img src="../../../img/fotos/<?php echo ($datos["usu_codigo"] . '/');
                                                    echo ($datos["usu_img"]); ?>" alt="">
                    <input type="file" name="foto" id="foto">

                    <input type="submit" value="Actualizar" class="boton_personalizado">
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

•	UsuariosTabla
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
                <div class="user">
                    <div class="userImg">
                        <div class="imagen">
                            <img src="<?php echo ('../../../img/fotos/' . $_SESSION["codigo"] . '/' . $_SESSION["img"]) ?>" alt="">
                        </div>
                        <p><span><?php echo ($_SESSION['nombre'] . ' ' . $_SESSION['apellido']) ?></span></p>
                    </div>
            </nav>
    </header>
    <h2>Tabla Usuario</h2>
    <div id=contenido>
        <section>
            <br>
            <br>
            <br>
        
            <table>
                
                <thead>
                    <tr>
                        <td>Cedula</td>
                        <td>Nombre</td>
                        <td>Apellido</td>
                        <td>Imagen</td>
                        <td>Direccion</td>
                        <td>Email</td>
                        <td>Telefono</td>
                        <td>Fecha Nacimiento</td>
                        <td>Eliminar</td>
                        <td>Modificar</td>
                        <td>Cambiar contraseña</td>
                    </tr>
                </thead>

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
                            echo '<td><img src="../../../img/fotos/' . $row["usu_codigo"] . '/' . $row["usu_img"] . '" alt=""></td>';
                            echo "<td>" . $row["usu_direccion"] . "</td>";
                            echo "<td>" . $row["usu_correo"] . "</td>";
                            echo "<td>" . $row["usu_telefono"] . "</td>";
                            echo "<td>" . $row["usu_fecha_nacimiento"] . "</td>";

                            if ((string)$row["usu_eliminado"] === 'N') {
                                echo '<td><a href="../../controladores/admin/BorrarUser.php?usu_cod=' . $row["usu_codigo"] . '&delete=' . true . '">Eliminar</a></td>';
                            } else {
                                echo '<td><a href="../../controladores/admin/BorrarUser.php?usu_cod=' . $row["usu_codigo"] . '">Activar</a></td>';
                            }
                            $user = serialize($row);
                            $user = urlencode($user);
                            echo '<td><a href="ModificarUser.php?user=' . $user . '">Modificar</a></td>';
                            echo '<td><a href="CambiarContra.php?usu_cod=' . $row["usu_codigo"] . '">Cambiar contraseña</a></td>';
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr>";
                        echo '<td colspan="10"<p>No existen usuarios registrados en el sistema</p>';
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






•	Vista Usuarios
 
•	CambiarContra
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

•	Enviar Mensaje
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
  
    <script src="js/buscar.js"></script>
    <title>Mensajes enviados</title>
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

    <h2>Mensajes Enviados</h2>
    <div id="contenido">
        <section>
            <table>
                <thead>
                    <tr>
                        <td>Fecha</td>
                        <td>Destino</td>
                        <td>Asunto</td>
                        <td></td>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    include '../../../config/conexionBD.php';
                    $sql = "SELECT * FROM usuario usu, mensaje msj WHERE usu.usu_codigo=msj.usu_destino AND 
                    msj.usu_remitente=" . $_SESSION['codigo'] . ";";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["mail_fecha"] . "</td>";
                            echo "<td>" . $row["usu_correo"] . "</td>";
                            echo "<td>" . $row["mail_asunto"] . "</td>";
                            echo ('<div id="floatWindow" class="floatWindow"></div>');
                            echo '<td><a onclick="openWindow(' . $row["mail_codigo"] . ',\'De:\',\'usu_remitente\')">Leer</a></td>';
                        }
                    } else {
                        echo "<tr>";
                        echo '<td colspan="10" ><p>No tienes mensajes recibidos</p></td>';
                        echo "</tr>";
                    }
                    $conn->close();
                    ?>

                </tbody>
            </table>

        </section>
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

•	Index
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
    <script src="js/buscar.js"></script>
    <title>Inicio</title>
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
    <h2>Mensajes Recibidos</h2>
    <div id="contenido">
        
        <section>
            <div id="buscar">
                <input type="search" id="buscarRemitente" placeholder="Buscar por remitente" onkeyup="buscar(this)">
            </div>
            <table>
                <thead>
                    <tr>
                        <td>Fecha</td>
                        <td>Remitente</td>
                        <td>Asunto</td>
                        <td></td>
                    </tr>
                </thead>
              

                <tbody id="data">
                    <?php
                    include '../../../config/conexionBD.php';
                    $sql = "SELECT * FROM usuario usu, mensaje msj WHERE usu.usu_codigo=msj.usu_remitente AND 
                    msj.usu_destino=" . $_SESSION['codigo'] . " ORDER BY msj.mail_codigo DESC;";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["mail_fecha"] . "</td>";
                            echo "<td>" . $row["usu_correo"] . "</td>";
                            echo "<td>" . $row["mail_asunto"] . "</td>";
                            echo ('<div id="floatWindow" class="floatWindow"></div>');
                            echo '<td><a onclick="openWindow(' . $row["mail_codigo"] . ',\'De:\',\'usu_remitente\')">Leer</a></td>';
                        }
                    } else {
                        echo "<tr>";
                        echo '<td colspan="10"><p>No tienes mensajes recibidos</p></td>';
                        echo "</tr>";
                    }
                    $conn->close();
                    ?>

                </tbody>
            </table>

        </section>
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

•	Micuenta
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
  
    <title>Mi cuenta</title>
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

    <h2>Mi Cuenta</h2>

    <div id="contenido">
        
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
                <tbody>
                    <?php
                    include '../../../config/conexionBD.php';
                    $sql = "SELECT * FROM usuario WHERE usu_codigo=" . $_SESSION['codigo'] . ";";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
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
                            echo '<td><a href="../../controladores/admin/BorrarUser.php?usu_cod=' . $row["usu_codigo"] . '">Activar</a></td>';
                        }
                        $user = serialize($row);
                        $user = urlencode($user);
                        echo '<td><a href="ModificarUser.php?user=' . $user . '">Modificar</a></td>';
                        echo '<td><a href="CambiarContra.php?usu_cod=' . $row["usu_codigo"] . '">Cambiar contraseña</a></td>';
                        echo "</tr>";
                    } else {
                        echo "<tr>";
                        echo '<td colspan="10"><p>No existen usuarios registrados en el sistema</p></td>';
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

•	ModificarUser
<?php
session_start();
if (!isset($_SESSION['isLogin'])) {
    header("Location: ../../../public/vista/login.php");
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

    <h2>Editar Datos</h2>

    </header>

    <section>
        <div id=contenido>

            <?php
            $data = $_GET["user"];
            $datos = stripslashes($data);
            $datos = urldecode($datos);
            $datos = unserialize($datos);
            ?>

            <form enctype="multipart/form-data" action="../../controladores/user/ModificarUser.php" method="post">

                <fieldset>
                    <input type="hidden" name="usu_codigo" value="<?php echo ($datos["usu_codigo"]); ?>">
                    <label for="cedula">Cedula</label>
                    <input type="text" name="cedula" id="cedula" value="<?php echo ($datos["usu_cedula"]); ?>" required>
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" value="<?php echo ($datos["usu_nombres"]); ?>" required>
                    <label for="apellido">Apellido</label>
                    <input type="text" name="apellido" id="apellido" value="<?php echo ($datos["usu_apellidos"]); ?>" required>
                    <label for="direccion">Direccion</label>
                    <input type="text" name="direccion" id="direccion" value="<?php echo ($datos["usu_direccion"]); ?>" required>
                    <label for="telefono">Telefono</label>
                    <input type="text" name="telefono" id="telefono" value="<?php echo ($datos["usu_telefono"]); ?>" required>
                    <label for="fechaNac">Fecha de nacimiento</label>
                    <input type="date" name="fechaNac" id="fechaNac" value="<?php echo ($datos["usu_fecha_nacimiento"]); ?>" required>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo ($datos["usu_correo"]); ?>" required>
                    <label for="foto">Foto de perfil</label>
                    <img src="../../../img/fotos/<?php echo ($datos["usu_codigo"] . '/');
                                                    echo ($datos["usu_img"]); ?>" alt="">
                    <input type="file" name="foto" id="foto">


                    <input type="submit" value="Actualizar" class="boton_personalizado">

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

•	Nuevo Email
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

Usuario con rol de user:
•	Visualizar en su pagina principal (index.php) el listado de todos los mensajes electrónicos recibidos, ordenados por los más recientes.
 
•	Enviar mensajes electrónicos a otros usuarios de la aplicación web.
 
•	g) Buscar todos los mensajes electrónicos recibidos. La búsqueda se realizará por el correo del usuario remitente y se deberá aplicar Ajax para la búsqueda.

Código Ajax
 
function buscar(input) {
    let text = input.value.trim()
    //console.log(text)
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest()
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP")
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("data").innerHTML = this.responseText
        }
    };
    xmlhttp.open("GET", "../../controladores/user/buscar.php?key=" + text, true)
    xmlhttp.send()
}
function openWindow(id, txt, code) {
    console.log(code)

    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest()
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP")
    }
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("floatWindow").innerHTML = this.responseText
        }
    };
    xmlhttp.open("GET", "../../controladores/user/Leer.php?id=" + id + "&dest=" + txt + "&code=" + code, true)
    xmlhttp.send()

    let windowFloat = document.getElementById("floatWindow")
    windowFloat.style.display = "block"

}

function cluseWindow() {
    let windowFloat = document.getElementById("floatWindow")
    windowFloat.style.display = "none"
}


•	Buscar todos los mensajes electrónicos enviados. La búsqueda se realizará por el correo del usuario destinatario y se deberá aplicar Ajax para la búsqueda.
 
 

•	 Modificar los datos del usuario.
 
Modificar Usuario
 

•	Cambiar la contraseña del usuario.
 
•	Agregar un avatar (fotografía) a la cuenta del usuario
 
Usuario con rol de admin:
•	Visualizar en su pagina principal (index.php) el listado usuario.
•	Eliminar, modificar y cambiar contraseña de los usuarios con rol “user”.
 
•	Pagina Admin
 
 
 
•	Pagina Usuario
 
 
 
 














•	 El diagrama E-R de la solución propuesta.
 
•	Nombre de la base de datos
Base Global hipermedial
Base del mensaje mensaje
Base del usuario usuario
 
•	Sentencias SQL de la estructura de la base de datos
CREATE TABLE usuario(
  usu_codigo int(11) NOT NULL AUTO_INCREMENT,
  usu_cedula varchar(10) NOT NULL,
  usu_nombres varchar(50) NOT NULL,
  usu_apellidos varchar(50) NOT NULL,
  usu_direccion varchar(75) NOT NULL,
  usu_telefono varchar(20) NOT NULL,
  usu_correo varchar(20) NOT NULL,
  usu_password varchar(255) NOT NULL,
  usu_fecha_nacimiento date NOT NULL,
  usu_eliminado varchar(1) NOT NULL DEFAULT 'N',
  usu_fecha_creacion timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  usu_fecha_modificacion timestamp NULL DEFAULT NULL,
  PRIMARY KEY (usu_codigo),
  UNIQUE KEY usu_cedula(usu_cedula)
  )ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


CREATE TABLE mensaje (
   mail_codigo int(11) NOT NULL AUTO_INCREMENT,
   mail_fecha timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
   mail_asunto varchar(100) NOT NULL,
   mail_mensaje varchar(255) NOT NULL,
   usu_remitente int(11) NOT NULL,
   usu_destino int(11) NOT NULL,
   PRIMARY KEY (mail_codigo),
   CONSTRAINT FK_UsuMensajeRemitente FOREIGN KEY (usu_remitente) REFERENCES usuario(usu_codigo),
  CONSTRAINT FK_UsuMensajeDestino FOREIGN KEY (usu_destino) REFERENCES usuario(usu_codigo)  
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


•	La evidencia del correcto diseño de las páginas HTML usando CSS. Para lo cuál, se puede generar fotografías instantáneas (pantallazos).
 
 

•	USUARIO
UPSJhona
https://github.com/UPSJhona/MiCorreoElectronico


CONCLUSIONES:
•	Los archivos css nos permiten como usuarios poder personalizar nuestras paginas web ya que al crear solo archivos HTML necesitamos personalizar tanto imágenes como textos fondos entre demás cosas por eso se establece que HTML siempre conllevo de la mano con css y los dos son importantes para el desarrollo de la web.

•	Eficaz, precisó y fácil de utilizar gracias a su nueva estructura y nuevos elementos. 

•	Autoaprendizaje para modificar paginas web a gran abundancia. Con autoría del usuario que lo usa.

•	El manejo de la base de datos nos ayuda para el funcionamiento del sistema.

•	El manejo de Javascript nos ayuda con soluciones a los problemas de funcionamiento como son busquedas de usuario,correo entre otros.

Nombre del estudiante: Jonnathan Ochoa
Firma del estudiante jefe de grupo: 
 
