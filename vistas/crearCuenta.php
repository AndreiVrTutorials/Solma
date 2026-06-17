<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear cuenta</title>
    <style>
        body{
            margin:0;
            font-family: Arial;
            background: linear-gradient(135deg, #8cc63f, #5fae2e);
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .formulario{
            background:white;
            padding:30px;
            border-radius:12px;
            width:350px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }

        h2{
            text-align:center;
            margin-bottom:20px;
        }

        label{
            font-weight:bold;
            display:block;
            margin-top:10px;
        }

        input{
            width:100%;
            padding:10px;
            margin-top:5px;
            border-radius:6px;
            border:1px solid #ccc;
        }

        .boton{
            margin-top:20px;
            background: linear-gradient(to bottom, #ffd84d, #e6b800);
            color:white;
            border:none;
            padding:12px;
            border-radius:6px;
            font-weight:bold;
            cursor:pointer;
        }

        .boton:hover{
            background: linear-gradient(to bottom, #ffe066, #cc9900);
        }
        
        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 6px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-size: 14px;
        }

    </style>
</head>
<body>
    <div class="formulario">
        <h2>Crear cuenta</h2>
        <form action="../controladores/guardarUsuario.php" method="post">
            
            <label>Nombre</label>
            <input type="text" name="nombre" required>

            <label>Usuario</label>
            <input type="text" name="usuario" required>

            <label>IPN</label>
            <input type="text" name="ipn" required>

            <label>UET</label>
            <select id="selector-uet" name="uet" required>
                    <option value="selecciona">SELECCIONA</option>
                    <option value="tts-ktl">TTS/KTL</option>
                    <option value="almacenes-albercas">ALMACENES/ALBERCAS</option>
                    <option value="circulating-masticos">CIRCULATING MASTICOS</option>
                    <option value="cisrculating-pintura">CIRCULATING PINTURA</option>
                    <option value="mantenimiento">MANTENIMIENTO</option>
                    <option value="flujos">FLUJOS</option>
                    <option value="bitono">BITONO</option>
                    <option value="retoque">RETOQUE</option>
                    <option value="oficina">OFICINA</option>
                    <option value="mastico">MASTICO</option>
                    <option value="obtuladores">OBTURADORES (STRIPING)</option>
                </select>

            <label>Turno</label>
            <select id="selector-turno" name="turno" required>
                    <option value="a">A</option>
                    <option value="b">B</option>
                    <option value="c">C</option>
                    <option value="otros">Otros</option>
            </select>
            
            <label>Responsable</label>
            <select name="rol">
                <option value="JU">JU</option>
                <option value="JT">JT</option>
                <!-- <option value="auditor">Auditor</option> -->
            </select>

            <input type="submit" class="boton" value="CREAR">

        </form>
    </div>
</body>
</html>