<?php
$pantalla = isset($_POST['pantalla']) ? $_POST['pantalla'] : '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['limpiar'])) {
        $pantalla = '';
    } elseif (isset($_POST['borrar'])) {
        $pantalla = substr($pantalla, 0, -1);
    } elseif (isset($_POST['btn'])) {
        $pantalla .= $_POST['btn'];
    } elseif (isset($_POST['calcular'])) {
        if (preg_match('/^(-?\d+(?:\.\d+)?)\s*([+\-*\/])\s*(-?\d+(?:\.\d+)?)$/', trim($pantalla), $matches)) {
            $n1 = floatval($matches[1]);
            $op = $matches[2];
            $n2 = floatval($matches[3]);
            $res = 0;

            switch ($op) {
                case '+': $res = $n1 + $n2; break;
                case '-': $res = $n1 - $n2; break;
                case '*': $res = $n1 * $n2; break;
                case '/': 
                    if ($n2 == 0) { $error = 'Error: División por cero'; } 
                    else { $res = $n1 / $n2; }
                    break;
            }

            if ($error === '') {
                $pantalla = (string) round($res, 6);
            }
        } else {
            $error = 'Expresión no válida';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Calculadora</title>
  <link rel="stylesheet" href="estilo.css">
  <style>
    /* Estilos exclusivos para mostrar solo la calculadora limpia */
    body {
      background: transparent !important;
      margin: 0;
      padding: 10px;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: auto !important;
    }
    .calculadora-seccion {
      width: 100%;
      max-width: 360px;
      margin: 0 auto;
      background: white;
      padding: 1.5rem;
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.08);
      border: 1px solid #eaeaea;
    }
  </style>
</head>
<body>

<div class="calculadora-seccion">
  <h2>Calculadora</h2>
  
  <form method="POST" action="">
    <input 
      type="text" 
      name="pantalla" 
      class="screen-input" 
      value="<?php echo htmlspecialchars($pantalla); ?>" 
      readonly
    >
    
    <div class="grid-buttons">
      <button type="submit" name="limpiar" value="1" class="btn btn-action">C</button>
      <button type="submit" name="borrar" value="1" class="btn btn-action">⌫</button>
      <button type="submit" name="btn" value="/" class="btn btn-op">÷</button>
      <button type="submit" name="btn" value="*" class="btn btn-op">×</button>
      
      <button type="submit" name="btn" value="7" class="btn">7</button>
      <button type="submit" name="btn" value="8" class="btn">8</button>
      <button type="submit" name="btn" value="9" class="btn">9</button>
      <button type="submit" name="btn" value="-" class="btn btn-op">-</button>
      
      <button type="submit" name="btn" value="4" class="btn">4</button>
      <button type="submit" name="btn" value="5" class="btn">5</button>
      <button type="submit" name="btn" value="6" class="btn">6</button>
      <button type="submit" name="btn" value="+" class="btn btn-op">+</button>
      
      <button type="submit" name="btn" value="1" class="btn">1</button>
      <button type="submit" name="btn" value="2" class="btn">2</button>
      <button type="submit" name="btn" value="3" class="btn">3</button>
      <button type="submit" name="btn" value="." class="btn">.</button>
      
      <button type="submit" name="btn" value="0" class="btn">0</button>
      <button type="submit" name="calcular" value="1" class="btn btn-equal">=</button>
    </div>
  </form>

  <?php if ($error !== ''): ?>
    <div class="resultado-error">
      <?php echo htmlspecialchars($error); ?>
    </div>
  <?php endif; ?>
</div>

</body>
</html>