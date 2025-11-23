<?php

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$proteina_gramos = 0;
$carbo_gramos = 0;
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $peso = sanitize_input($_POST["peso"]);
    $grasa_corporal = sanitize_input($_POST["grasa_corporal"]);

    if (!is_numeric($peso) || $peso <= 0) {
        $error = "Por favor, introduzca un peso válido (en kg).";
    } elseif (!is_numeric($grasa_corporal) || $grasa_corporal <= 0 || $grasa_corporal >= 100) {
        $error = "Por favor, introduzca un porcentaje de grasa corporal válido.";
    } else {
        
        $grasa_kg = $peso * ($grasa_corporal / 100);
        $mcm = $peso - $grasa_kg;
        
        $proteina_gramos = round($mcm * 2.2, 1);
        
        $carbo_gramos = round($peso * 5.0, 1);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Requerimientos Nutricionales</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container resultado-page">
        
        <h1>Resultados de Macronutrientes</h1>
        
        <?php if ($error): ?>
            <div class="resultado error">
                <p><?php echo $error; ?></p>
                <a href="index.html" class="boton-volver">Volver al Formulario</a>
            </div>
        <?php else: ?>
            <div class="resultado exito">
                <p>Basado en **<?php echo $peso; ?> kg** y **<?php echo $grasa_corporal; ?>%** de grasa corporal:</p>
                <p class="nota-mcm">Su Masa Corporal Magra (MCM) es de: **<?php echo round($mcm, 1); ?> kg**</p>
                
                <hr class="thin-separator">
                
                <h2>Proteína Diaria (MCM x 2.2 g):</h2>
                <p class="calculo exito-num"><?php echo $proteina_gramos; ?> **gramos**</p>
                
                <h2>Carbohidratos Diarios (Peso x 5.0 g):</h2>
                <p class="calculo exito-num"><?php echo $carbo_gramos; ?> **gramos**</p>
                
                <p class="nota">Estos son objetivos recomendados para el aumento de masa muscular.</p>
                <a href="index.html" class="boton-volver">Volver al Inicio</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>