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
    <link rel="stylesheet" href="../../../css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700" rel="stylesheet">
    <title>Modificar Usuario</title>
</head>

<body>
    <header>
        <header>
        <h1 class="tittle">Gestion de usuarios</h1>
<div class="menu">
    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="nuevoemail.php">Nuevo Mensaje</a></li>
            <li><a href="enviarmensaje.php">Mensajes Enviados</a></li>
            <li><a href="micuenta.php">Mi Cuenta</a></li>
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
    <!-- <a href='../../../public/vista/login.php'>Iniciar Sesion</a>"-->

</div>
        </header>
    </header>
    <section>
        <div class="formulario registro">
            <h2>Editar Datos</h2>
            <?php
            $data = $_GET["user"];
            $datos = stripslashes($data);
            $datos = urldecode($datos);
            $datos = unserialize($datos);
            ?>
            <form enctype="multipart/form-data" action="../../controladores/user/ModificarUser.php" method="post">
                <input type="hidden" name="usu_codigo" value="<?php echo ($datos["usu_codigo"]); ?>">
                <label for="cedula">Cedula</label>
                <input type="text" name="cedula" id="cedula" value="<?php echo ($datos["usu_cedula"]); ?>" required>
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" value="<?php echo ($datos["usu_nombres"]); ?>" required>
                <label for="apellido">Apellido</label>
                <input type="text" name="apellido" id="apellido" value="<?php echo ($datos["usu_apellidos"]); ?>"
                    required>
                <label for="direccion">Direccion</label>
                <input type="text" name="direccion" id="direccion" value="<?php echo ($datos["usu_direccion"]); ?>"
                    required>
                <label for="telefono">Telefono</label>
                <input type="text" name="telefono" id="telefono" value="<?php echo ($datos["usu_telefono"]); ?>"
                    required>
                <label for="fechaNac">Fecha de nacimiento</label>
                <input type="date" name="fechaNac" id="fechaNac" value="<?php echo ($datos["usu_fecha_nacimiento"]); ?>"
                    required>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?php echo ($datos["usu_correo"]); ?>" required>
                <div class="userFoto">
                    <img src="../../../img/fotos/<?php echo ($datos["usu_codigo"] . '/');
                                                    echo ($datos["usu_img"]); ?>" alt="">
                    <input type="file" name="foto" id="foto">
                    <label for="foto">Foto de perfil</label>
                </div>
                <input type="submit" value="Actualizar">
            </form>
        </div>
    </section>
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