<?php
session_start();
$error = "";
if(isset($_GET['error'])){
    $error = "Credenciales incorrectas";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<link rel="stylesheet" href="../estilos/index.css">
</head>

<body>

    <div class="contenedor">
        <h2>Renault Group</h2>
        <h1>PINTURA</h1>

        <img src="../imagenes/logo_renault_blanco.png" width="60">

        <form action="../controladores/login.php" method="post">
            <label for="username">Usuario</label>
            <input type="text" id="username" name="usuario" required>

            <label for="password">Contraseña</label>
            <input type="password" id="password" name="contrasenia" required>
            <?php if($error): ?>
                <p style="color: red; margin-top: 5px;"><?php echo $error;?></p>
            <?php endif;?>
            <input type="submit" id="boton-entrar" value="Entrar">
        </form>
        <input type="button" id="boton-crear-cuenta" onclick="location.href='crearCuenta.php'" value="Crear cuenta">
    </div>
</body>
</html>