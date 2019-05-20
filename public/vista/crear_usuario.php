<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="Archivos/Logine.css">
    
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
    <h2>Ingrese sus datos</h2>
        <div id="contenido">
            
            <form enctype="multipart/form-data" action="../controladores/crear_usuario.php" method="post">
            <fieldset>
                <label for="cedula">Cedula</label>
                <input type="text" name="cedula" id="cedula" required>
   
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" required>
                
                <label for="apellido">Apellido</label>
                <input type="text" name="apellido" id="apellido" required>
                
                <label for="direccion">Direccion</label>
                <input type="text" name="direccion" id="direccion" required>
             
                <label for="telefono">Telefono</label>
                <input type="text" name="telefono" id="telefono" required>
             
                <label for="fechaNac">Fecha de nacimiento</label>
                <input type="date" name="fechaNac" id="fechaNac" required>
               
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
              
                <label for="pass">Contraseña</label>
                <input type="password" name="pass" id="pass" required>
               
                <label for="cpass">Confirmar Contraseña</label>
                <input type="password" name="cpass" id="cpass" required>
                <label for="foto">Foto de perfil</label>
                <div>
                <img src="../../img/fotos/foto.png" alt="">
                <input type="file" name="foto" id="foto">

                </div>
                
                <input type="submit" class="boton_personalizado" value="Confirmar">

                </fieldset>
            </form>

        </div>
    </section>
    <footer >
        
    </footer>
</body>

</html>
</html>