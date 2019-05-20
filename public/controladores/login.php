<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../login.php">
     <title>Login</title>
</head>

<body>
    <header>
    <div>
            <nav>
                <ul>
                    <li><a href="crear_usuario.php">Crear Usuario</a></li>
                    <li><a href='login.php'>Iniciar Sesion</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <section>
        <div class="formulario crear_usuario">
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
                echo "<h2>Datos de inicio incorrectos....</h2>";
               ;
                header("Location =../vista/login.php");
            }
            $conn->close();
            ?>
        </div>
    </section>
</body>

</html>
