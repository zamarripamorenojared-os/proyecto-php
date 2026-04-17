<?php
// Obtener la práctica seleccionada del menú
$practica = isset($_GET['practica']) ? (int)$_GET['practica'] : 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Prácticas PHP #21–26</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;700;800&family=DM+Mono:ital,wght@0,400;0,500;1,400&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css" />
</head>
<body>

<div class="layout">

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="sidebar-header">
      <span class="tag">SERVER SIDE</span>
      <h1>Prácticas<br/><em>PHP</em></h1>
      <p class="subtitle">Ejercicios #21 al #26</p>
    </div>

    <nav class="menu">
      <?php
        $practicas = [
          21 => "Operaciones Aritméticas",
          22 => "Fórmula General",
          23 => "IMC",
          24 => "Fechas",
          25 => "Tablas de Multiplicar",
          26 => "Tablas (usuario)",
        ];
        foreach ($practicas as $num => $nombre):
          $activo = ($practica === $num) ? ' active' : '';
      ?>
      <a href="?practica=<?= $num ?>" class="menu-item<?= $activo ?>">
        <span class="num">#<?= $num ?></span>
        <span class="label"><?= $nombre ?></span>
        <span class="arrow">→</span>
      </a>
      <?php endforeach; ?>
    </nav>

    <div class="sidebar-footer">
      <span>PHP <?= phpversion() ?></span>
    </div>
  </aside>

  <!-- MAIN CONTENT -->
  <main class="content">

    <?php if ($practica === 0): ?>
      <!-- PANTALLA DE BIENVENIDA -->
      <div class="welcome">
        <div class="welcome-icon">⚙️</div>
        <h2>Bienvenido</h2>
        <p>Selecciona una práctica del menú lateral para comenzar.<br/>Todas las operaciones se procesan en el <strong>servidor con PHP</strong>.</p>
        <div class="chips">
          <span>Formularios</span><span>Cálculos</span><span>Ciclos</span><span>Fechas</span>
        </div>
      </div>

    <?php elseif ($practica === 21): ?>
      <!-- PRÁCTICA 21: Operaciones Aritméticas -->
      <?php
        $resultado = null;
        $op = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['num1'], $_POST['num2'], $_POST['operacion'])) {
          $a = (float)$_POST['num1'];
          $b = (float)$_POST['num2'];
          $op = $_POST['operacion'];
          switch ($op) {
            case 'suma':        $resultado = $a + $b; $sym = '+'; break;
            case 'resta':       $resultado = $a - $b; $sym = '−'; break;
            case 'multiplicar': $resultado = $a * $b; $sym = '×'; break;
            case 'dividir':
              if ($b == 0) { $resultado = 'Error: División entre cero'; $sym = '÷'; }
              else { $resultado = $a / $b; $sym = '÷'; }
              break;
            case 'modulo':      $resultado = fmod($a, $b); $sym = '%'; break;
            case 'potencia':    $resultado = pow($a, $b); $sym = '^'; break;
          }
        }
      ?>
      <div class="practica-header">
        <span class="practica-num">Práctica #21</span>
        <h2>Operaciones Aritméticas</h2>
        <p>Ingresa dos números y selecciona la operación a realizar.</p>
      </div>

      <form method="POST" class="form-card">
        <div class="form-row">
          <div class="form-group">
            <label>Número A</label>
            <input type="number" name="num1" step="any" placeholder="0"
              value="<?= isset($_POST['num1']) ? htmlspecialchars($_POST['num1']) : '' ?>" required>
          </div>
          <div class="form-group">
            <label>Número B</label>
            <input type="number" name="num2" step="any" placeholder="0"
              value="<?= isset($_POST['num2']) ? htmlspecialchars($_POST['num2']) : '' ?>" required>
          </div>
        </div>
        <div class="btn-group">
          <button type="submit" name="operacion" value="suma"        class="btn btn-op <?= $op==='suma'?'btn-active':'' ?>">+ Suma</button>
          <button type="submit" name="operacion" value="resta"       class="btn btn-op <?= $op==='resta'?'btn-active':'' ?>">− Resta</button>
          <button type="submit" name="operacion" value="multiplicar" class="btn btn-op <?= $op==='multiplicar'?'btn-active':'' ?>">× Multiplicar</button>
          <button type="submit" name="operacion" value="dividir"     class="btn btn-op <?= $op==='dividir'?'btn-active':'' ?>">÷ Dividir</button>
          <button type="submit" name="operacion" value="modulo"      class="btn btn-op <?= $op==='modulo'?'btn-active':'' ?>">% Módulo</button>
          <button type="submit" name="operacion" value="potencia"    class="btn btn-op <?= $op==='potencia'?'btn-active':'' ?>">^ Potencia</button>
        </div>
      </form>

      <?php if ($resultado !== null): ?>
      <div class="result-card">
        <span class="result-label">Resultado</span>
        <div class="result-value">
          <?= htmlspecialchars($_POST['num1']) ?> <?= $sym ?> <?= htmlspecialchars($_POST['num2']) ?> = <strong><?= is_float($resultado) ? round($resultado, 4) : $resultado ?></strong>
        </div>
      </div>
      <?php endif; ?>

    <?php elseif ($practica === 22): ?>
      <!-- PRÁCTICA 22: Fórmula General -->
      <?php
        $x1 = $x2 = $discriminante = null;
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $a = (float)$_POST['a'];
          $b = (float)$_POST['b'];
          $c = (float)$_POST['c'];
          if ($a == 0) {
            $error = 'El valor de "a" no puede ser cero.';
          } else {
            $discriminante = ($b * $b) - (4 * $a * $c);
            if ($discriminante < 0) {
              $error = 'El discriminante es negativo (' . $discriminante . '). No existen raíces reales.';
            } elseif ($discriminante == 0) {
              $x1 = -$b / (2 * $a);
              $x2 = $x1;
            } else {
              $x1 = (-$b + sqrt($discriminante)) / (2 * $a);
              $x2 = (-$b - sqrt($discriminante)) / (2 * $a);
            }
          }
        }
      ?>
      <div class="practica-header">
        <span class="practica-num">Práctica #22</span>
        <h2>Fórmula General (Cuadrática)</h2>
        <p>Calcula las raíces de: <em>ax² + bx + c = 0</em></p>
      </div>

      <form method="POST" class="form-card">
        <div class="formula-display">x = (−b ± √(b²−4ac)) / 2a</div>
        <div class="form-row three-col">
          <div class="form-group">
            <label>Valor de a</label>
            <input type="number" name="a" step="any" placeholder="a" value="<?= isset($_POST['a']) ? htmlspecialchars($_POST['a']) : '' ?>" required>
          </div>
          <div class="form-group">
            <label>Valor de b</label>
            <input type="number" name="b" step="any" placeholder="b" value="<?= isset($_POST['b']) ? htmlspecialchars($_POST['b']) : '' ?>" required>
          </div>
          <div class="form-group">
            <label>Valor de c</label>
            <input type="number" name="c" step="any" placeholder="c" value="<?= isset($_POST['c']) ? htmlspecialchars($_POST['c']) : '' ?>" required>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Calcular raíces</button>
      </form>

      <?php if ($error): ?>
        <div class="result-card error-card"><span>⚠️ <?= htmlspecialchars($error) ?></span></div>
      <?php elseif ($x1 !== null): ?>
        <div class="result-card">
          <span class="result-label">Discriminante: <?= round($discriminante, 4) ?></span>
          <div class="result-grid">
            <div class="result-item"><span>x₁</span><strong><?= round($x1, 4) ?></strong></div>
            <div class="result-item"><span>x₂</span><strong><?= round($x2, 4) ?></strong></div>
          </div>
        </div>
      <?php endif; ?>

    <?php elseif ($practica === 23): ?>
      <!-- PRÁCTICA 23: IMC -->
      <?php
        $imc = null; $grado = ''; $color = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $peso = (float)$_POST['peso'];
          $altura = (float)$_POST['altura'] / 100; // cm a metros
          if ($altura > 0 && $peso > 0) {
            $imc = $peso / ($altura * $altura);
            if ($imc < 18.5)      { $grado = 'Bajo peso';           $color = '#60a5fa'; }
            elseif ($imc < 24.9)  { $grado = 'Peso normal';         $color = '#4ade80'; }
            elseif ($imc < 29.9)  { $grado = 'Sobrepeso';           $color = '#facc15'; }
            elseif ($imc < 34.9)  { $grado = 'Obesidad grado I';    $color = '#fb923c'; }
            elseif ($imc < 39.9)  { $grado = 'Obesidad grado II';   $color = '#f87171'; }
            else                  { $grado = 'Obesidad grado III';   $color = '#dc2626'; }
          }
        }
      ?>
      <div class="practica-header">
        <span class="practica-num">Práctica #23</span>
        <h2>Índice de Masa Corporal (IMC)</h2>
        <p>Fórmula: <em>IMC = Peso (kg) / Altura² (m)</em></p>
      </div>

      <form method="POST" class="form-card">
        <div class="form-row">
          <div class="form-group">
            <label>Peso (kg)</label>
            <input type="number" name="peso" step="0.1" min="1" placeholder="Ej: 65" value="<?= isset($_POST['peso']) ? htmlspecialchars($_POST['peso']) : '' ?>" required>
          </div>
          <div class="form-group">
            <label>Altura (cm)</label>
            <input type="number" name="altura" step="0.1" min="1" placeholder="Ej: 165" value="<?= isset($_POST['altura']) ? htmlspecialchars($_POST['altura']) : '' ?>" required>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Calcular IMC</button>
      </form>

      <?php if ($imc !== null): ?>
      <div class="result-card imc-card">
        <span class="result-label">Tu IMC</span>
        <div class="imc-value" style="color:<?= $color ?>"><?= round($imc, 2) ?></div>
        <div class="imc-grado" style="background:<?= $color ?>20; border:1px solid <?= $color ?>; color:<?= $color ?>"><?= $grado ?></div>
        <div class="imc-tabla">
          <?php
            $rangos = [
              ['< 18.5', 'Bajo peso', '#60a5fa'],
              ['18.5 – 24.9', 'Peso normal', '#4ade80'],
              ['25 – 29.9', 'Sobrepeso', '#facc15'],
              ['30 – 34.9', 'Obesidad I', '#fb923c'],
              ['35 – 39.9', 'Obesidad II', '#f87171'],
              ['≥ 40', 'Obesidad III', '#dc2626'],
            ];
            foreach ($rangos as $r):
              $es = ($grado === $r[1]);
          ?>
          <div class="imc-row <?= $es ? 'imc-row-active' : '' ?>" style="<?= $es ? "border-left:3px solid {$r[2]}" : '' ?>">
            <span style="color:<?= $r[2] ?>"><?= $r[0] ?></span>
            <span><?= $r[1] ?></span>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>

    <?php elseif ($practica === 24): ?>
      <!-- PRÁCTICA 24: Fechas -->
      <?php
        $diasSemana = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
        $meses = ['','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
        $hoy = new DateTime('now', new DateTimeZone('America/Mazatlan'));
        $numDia  = (int)$hoy->format('w'); // 0=dom
        $dia     = (int)$hoy->format('j');
        $numMes  = (int)$hoy->format('n');
        $anio    = $hoy->format('Y');
        $hora    = $hoy->format('H:i:s');
        $nombreDia = $diasSemana[$numDia];
        $nombreMes = $meses[$numMes];
      ?>
      <div class="practica-header">
        <span class="practica-num">Práctica #24</span>
        <h2>Fechas con PHP</h2>
        <p>La fecha actual procesada en el servidor usando <em>switch</em>.</p>
      </div>

      <div class="fecha-card">
        <div class="fecha-main">
          Hoy es <span class="fecha-highlight"><?= $nombreDia ?></span>
          <?= $dia ?> de <span class="fecha-highlight"><?= $nombreMes ?></span>
          del año <span class="fecha-highlight"><?= $anio ?></span>
        </div>
        <div class="fecha-hora">🕐 <?= $hora ?> (Hora local del servidor)</div>

        <div class="fecha-info-grid">
          <div class="fecha-info-item">
            <span>Día de la semana</span>
            <strong><?= $nombreDia ?> (<?= $numDia ?>)</strong>
          </div>
          <div class="fecha-info-item">
            <span>Día del mes</span>
            <strong><?= $dia ?></strong>
          </div>
          <div class="fecha-info-item">
            <span>Mes</span>
            <strong><?= $nombreMes ?> (<?= $numMes ?>)</strong>
          </div>
          <div class="fecha-info-item">
            <span>Año</span>
            <strong><?= $anio ?></strong>
          </div>
          <div class="fecha-info-item">
            <span>Día del año</span>
            <strong><?= $hoy->format('z') + 1 ?></strong>
          </div>
          <div class="fecha-info-item">
            <span>Semana del año</span>
            <strong><?= $hoy->format('W') ?></strong>
          </div>
        </div>

        <div class="codigo-php">
          <span class="code-label">Código PHP usado (switch):</span>
          <pre><code><?php echo htmlspecialchars('<?php
$numDia = (int)date(\'w\'); // 0=Dom, 6=Sáb
switch($numDia) {
  case 0: $dia = "Domingo";   break;
  case 1: $dia = "Lunes";     break;
  case 2: $dia = "Martes";    break;
  case 3: $dia = "Miércoles"; break;
  case 4: $dia = "Jueves";    break;
  case 5: $dia = "Viernes";   break;
  case 6: $dia = "Sábado";    break;
}'); ?></code></pre>
        </div>
      </div>

    <?php elseif ($practica === 25): ?>
      <!-- PRÁCTICA 25: Tablas de multiplicar (1 al 10) -->
      <?php
        $mostrar = isset($_POST['generar']);
      ?>
      <div class="practica-header">
        <span class="practica-num">Práctica #25</span>
        <h2>Tablas de Multiplicar (1–10)</h2>
        <p>Genera las tablas del 1 al 10 usando ciclos <em>for</em> en PHP.</p>
      </div>

      <form method="POST" class="form-card">
        <button type="submit" name="generar" class="btn btn-primary">⚡ Generar Tablas</button>
      </form>

      <?php if ($mostrar): ?>
      <div class="tablas-grid">
        <?php for ($t = 1; $t <= 10; $t++): ?>
        <div class="tabla-card">
          <div class="tabla-title">Tabla del <?= $t ?></div>
          <?php for ($i = 1; $i <= 10; $i++): ?>
          <div class="tabla-row">
            <span><?= $t ?> × <?= $i ?></span>
            <span>=</span>
            <strong><?= $t * $i ?></strong>
          </div>
          <?php endfor; ?>
        </div>
        <?php endfor; ?>
      </div>
      <?php endif; ?>

    <?php elseif ($practica === 26): ?>
      <!-- PRÁCTICA 26: Tablas hasta número del usuario -->
      <?php
        $n = null; $errMsg = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['numero'])) {
          $n = (int)$_POST['numero'];
          if ($n < 1) { $errMsg = 'Por favor ingresa un número entero positivo.'; $n = null; }
        }
      ?>
      <div class="practica-header">
        <span class="practica-num">Práctica #26</span>
        <h2>Tablas de Multiplicar (hasta N)</h2>
        <p>Ingresa un número y se generarán las tablas del 1 hasta ese número.</p>
      </div>

      <form method="POST" class="form-card">
        <div class="form-row">
          <div class="form-group">
            <label>Número positivo entero</label>
            <input type="number" name="numero" min="1" max="50" placeholder="Ej: 5"
              value="<?= $n ?? (isset($_POST['numero']) ? htmlspecialchars($_POST['numero']) : '') ?>" required>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">⚡ Generar Tablas</button>
      </form>

      <?php if ($errMsg): ?>
        <div class="result-card error-card">⚠️ <?= htmlspecialchars($errMsg) ?></div>
      <?php elseif ($n !== null): ?>
      <div class="tablas-grid">
        <?php for ($t = 1; $t <= $n; $t++): ?>
        <div class="tabla-card">
          <div class="tabla-title">Tabla del <?= $t ?></div>
          <?php for ($i = 1; $i <= 10; $i++): ?>
          <div class="tabla-row">
            <span><?= $t ?> × <?= $i ?></span>
            <span>=</span>
            <strong><?= $t * $i ?></strong>
          </div>
          <?php endfor; ?>
        </div>
        <?php endfor; ?>
      </div>
      <?php endif; ?>

    <?php endif; ?>

  </main>
</div>

</body>
</html>
