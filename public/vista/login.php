<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="Archivos/CrearUsuario.css">
    
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
    <h2>Iniciar Sesion</h2>
        <div id="contenido">
           
            <form action="../controladores/login.php" method="post">
            <fieldset>
            <label for="email">Correo</label>
                <input type="email" name="email" id="email" required placeholder="Correo">
                <label for="email">Contrasena</label>
                <input type="password" name="pass" id="pass" required placeholder="Contraseña">
                <br>
                <input type="submit" class="boton_personalizado" value="Ingresar">
            </fieldset>
            </form>
        </div>
    </section>
    <footer>
        
    </footer>
</body>
