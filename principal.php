<?php
// principal.php - Versión adaptada con menú de usuario integrado y botones mejorados.
// Inicia sesión PHP al inicio para manejar el estado del usuario.
// Mejoras en botones: Iconos Unicode, transiciones suaves, dropdown con toggle JS (mejor para móviles), estados active, y mayor responsividad.

session_start(); // Inicia la sesión si no está iniciada
$userLoggedIn = isset($_SESSION['user']); // Verifica si hay usuario logueado (ejemplo: $_SESSION['user'] = 'nombre_usuario')
$currentUser   = $userLoggedIn ? $_SESSION['user'] : null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Socogames catalogo de juegos</title>
  <style>
    body {
      margin: 0;
      font-family: "Trebuchet MS", sans-serif;
      background: linear-gradient(180deg, #000814, #001d3d, #003566);
      color: #e0e0e0;
      overflow-x: hidden;
    }
    header {
      text-align: center;
      padding: 25px 10px;
      background: rgba(0, 0, 30, 0.8);
      border-bottom: 2px solid #00b4d8;
      box-shadow: 0 4px 12px rgba(0,0,0,0.6);
      position: relative;
      z-index: 10;
    }
    header h1 {
      margin: 0;
      font-size: 28px;
      color: #00b4d8;
      text-shadow: 0 0 8px #00b4d8, 0 0 15px #0096c7;
    }
    header p {
      margin: 8px 0 15px;
      color: #90e0ef;
      font-size: 14px;
    }

    nav {
      display: flex;
      justify-content: center;
      gap: 15px;
      flex-wrap: wrap;
      margin-top: 10px;
    }
    nav button {
      background: rgba(0, 0, 50, 0.9);
      border: 1px solid #00b4d8;
      color: #caf0f8;
      padding: 10px 18px;
      border-radius: 8px;
      font-size: 14px;
      cursor: pointer;
      text-transform: uppercase;
      letter-spacing: 1px;
      transition: all 0.3s ease; /* Mejora: Transición más suave */
      box-shadow: 0 0 6px rgba(0,183,255,0.4);
      position: relative;
      overflow: hidden;
    }
    nav button::before { /* Mejora: Efecto ripple sutil en hover */
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      background: rgba(255,255,255,0.2);
      border-radius: 50%;
      transform: translate(-50%, -50%);
      transition: width 0.6s, height 0.6s;
    }
    nav button:hover {
      background: #00b4d8;
      color: #001d3d;
      box-shadow: 0 0 12px #00b4d8, 0 0 20px #0096c7;
      transform: scale(1.05) translateY(-2px); /* Mejora: Elevación sutil */
    }
    nav button:hover::before {
      width: 300px;
      height: 300px;
    }
    nav button:active {
      transform: scale(0.98); /* Mejora: Feedback táctil */
    }

    .container {
      width: 90%;
      max-width: 1000px;
      margin: 20px auto;
      position: relative;
    }

    .game-card {
      background: rgba(0, 0, 40, 0.85);
      border: 1px solid #0077b6;
      border-radius: 12px;
      margin: 18px 0;
      padding: 15px;
      display: flex;
      flex-direction: row;
      align-items: center;
      gap: 15px;
      box-shadow: 0 0 10px rgba(0,183,255,0.3);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: pointer;
      overflow: hidden;
      position: relative;
      z-index: 1;
    }
    .game-card img {
      width: 130px;
      height: 130px;
      object-fit: cover;
      border-radius: 8px;
      border: 2px solid #00b4d8;
    }

    .info h2 {
      margin: 0;
      color: #caf0f8;
      text-shadow: 0 0 6px #00b4d8;
    }
    .info p {
      margin: 5px 0;
    }

    /* Overlay expandido */
    .game-card.expanded {
      position: absolute;
      top: 0;
      left: 50%;
      transform: translateX(-50%) scale(1.05);
      width: 95%;
      z-index: 100;
      align-items: flex-start;
      background: rgba(0,0,50,0.95);
      box-shadow: 0 0 30px rgba(0,183,255,0.8);
    }
    .expanded img {
      width: 180px;
      height: 180px;
    }
    .long-story {
      display: none;
      flex: 1;
      padding-left: 20px;
      font-size: 15px;
      line-height: 1.5;
      color: #f1f1f1;
    }
    .game-card.expanded .long-story {
      display: block;
    }

    footer {
      text-align: center;
      padding: 15px;
      background: rgba(0, 0, 30, 0.8);
      color: #90e0ef;
      font-size: 12px;
      border-top: 1px solid #00b4d8;
      position: relative;
      z-index: 10;
    }

    /* CSS mejorado para el menú de usuario - Integra con el estilo existente */
    .user-section {
      position: absolute;
      top: 20px;
      right: 20px;
      display: flex;
      align-items: center;
      gap: 10px;
      z-index: 11;
    }
    .user-info {
      color: #90e0ef;
      font-size: 14px;
      text-shadow: 0 0 4px #00b4d8;
      white-space: nowrap; /* Mejora: Evita quiebre de línea */
    }
    .user-menu {
      display: flex;
      gap: 5px;
      flex-wrap: wrap;
    }
    .user-menu button {
      background: rgba(0, 0, 50, 0.9);
      border: 1px solid #00b4d8;
      color: #caf0f8;
      padding: 8px 12px;
      border-radius: 6px;
      font-size: 12px;
      cursor: pointer;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      transition: all 0.3s ease; /* Mejora: Transición más suave */
      box-shadow: 0 0 4px rgba(0,183,255,0.4);
      font-family: "Trebuchet MS", sans-serif;
      position: relative;
      overflow: hidden;
      display: flex;
      align-items: center;
      gap: 4px; /* Espacio para iconos */
      min-width: 100px; /* Mejora: Tamaño consistente */
    }
    .user-menu button::before { /* Mejora: Efecto ripple similar a nav */
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      background: rgba(255,255,255,0.2);
      border-radius: 50%;
      transform: translate(-50%, -50%);
      transition: width 0.6s, height 0.6s;
    }
    .user-menu button:hover {
      background: #00b4d8;
      color: #001d3d;
      box-shadow: 0 0 8px #00b4d8, 0 0 12px #0096c7;
      transform: scale(1.03) translateY(-1px); /* Mejora: Elevación sutil */
    }
    .user-menu button:hover::before {
      width: 200px;
      height: 200px;
    }
    .user-menu button:active {
      transform: scale(0.97); /* Mejora: Feedback táctil */
    }
    .login-register {
      display: flex;
      gap: 5px;
    }
    .dropdown {
      position: relative;
      display: inline-block;
    }
    .dropdown-btn {
      background: rgba(0, 0, 50, 0.9) !important; /* Mejora: Estilo específico para botón dropdown */
      border: 1px solid #00b4d8 !important;
      padding: 8px 12px !important;
      min-width: auto !important;
    }
    .dropdown-content {
      display: none;
      position: absolute;
      right: 0;
      background: rgba(0, 0, 50, 0.95);
      min-width: 140px; /* Mejora: Ancho ligeramente mayor para iconos */
      box-shadow: 0 8px 16px rgba(0,0,0,0.4);
      border: 1px solid #00b4d8;
      border-radius: 6px;
      z-index: 12;
      top: 100%;
      margin-top: 5px;
      opacity: 0;
      transform: translateY(-10px);
      transition: opacity 0.3s ease, transform 0.3s ease; /* Mejora: Animación suave de entrada */
    }
    .dropdown-content.show {
      display: block;
      opacity: 1;
      transform: translateY(0);
    }
    .dropdown-content button {
      color: #caf0f8;
      padding: 12px 15px; /* Mejora: Más padding para mejor toque */
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 8px; /* Espacio para iconos */
      width: 100%;
      border: none;
      background: none;
      text-align: left;
      cursor: pointer;
      transition: background 0.2s ease, padding-left 0.2s ease;
      font-family: "Trebuchet MS", sans-serif;
      font-size: 12px;
      border-bottom: 1px solid rgba(0, 180, 216, 0.1); /* Mejora: Separadores sutiles */
    }
    .dropdown-content button:last-child {
      border-bottom: none;
    }
    .dropdown-content button:hover {
      background: rgba(0, 180, 216, 0.3); /* Mejora: Hover más visible */
      color: #00b4d8;
      padding-left: 20px; /* Mejora: Efecto slide-in */
    }
    /* Iconos Unicode para botones (mejora visual sin dependencias externas) */
    .icon-user { content: '👤'; } /* Para bienvenido o perfil */
    .icon-menu { content: '☰'; } /* Para botón menú */
    .icon-profile { content: '👤'; }
    .icon-settings { content: '⚙️'; }
    .icon-logout { content: '🚪'; }
    .icon-login { content: '🔑'; }
    .icon-register { content: '📝'; }
    /* Agregar iconos vía ::before en botones específicos */
    .dropdown-btn::before { content: '☰ '; } /* Icono menú */
    .login-btn::before { content: '🔑 '; }
    .register-btn::before { content: '📝 '; }
    .profile-btn::before { content: '👤 '; }
    .settings-btn::before { content: '⚙️ '; }
    .logout-btn::before { content: '🚪 '; }
    @media (max-width: 768px) {
      .user-section {
        top: 10px;
        right: 10px;
        flex-direction: column;
        align-items: flex-end;
        gap: 8px;
      }
      .user-menu {
        justify-content: center;
        width: 100%;
      }
      .user-menu button {
        min-width: 120px; /* Mejora: Botones más anchos en móvil para toque fácil */
        padding: 10px 14px;
      }
      .dropdown-content {
        min-width: 160px;
        right: -20px; /* Ajuste para no salirse de pantalla */
      }
      nav {
        margin-top: 60px; /* Mejora: Más espacio para menú en móviles */
      }
    }
  </style>
</head>
<body>
  <header>
    <h1>Catálogo de Juegos - PS2</h1>
    <p></p>

    <!-- Menú de usuario agregado aquí - Posicionado en la esquina superior derecha -->
    <div class="user-section">
      <?php if ($userLoggedIn): ?>
        <span class="user-info">Bienvenido, <?php echo htmlspecialchars($currentUser ); ?>! 👤</span>
        <div class="dropdown" id="userDropdown">
          <button class="user-menu-btn dropdown-btn" onclick="toggleDropdown()">Menú</button>
          <div class="dropdown-content">
            <button class="profile-btn" onclick="window.location.href='perfil.php'">Perfil</button>
            <button class="settings-btn" onclick="window.location.href='configuracion.php'">Configuración</button>
            <button class="logout-btn" onclick="logout()">Cerrar Sesión</button>
          </div>
        </div>
      <?php else: ?>
        <div class="login-register user-menu">
          <button class="user-menu-btn login-btn" onclick="window.location.href='login.php'">Iniciar Sesión</button>
          <button class="user-menu-btn register-btn" onclick="window.location.href='register.php'">Registrarse</button>
        </div>
      <?php endif; ?>
    </div>
    
    <nav>
      <button onclick="filtrar('all')">Todos</button>
      <button onclick="filtrar('accion')">Acción</button>
      <button onclick="filtrar('aventura')">Aventura</button>
      <button onclick="filtrar('rpg')">RPG</button>
      <button onclick="filtrar('deportes')">Deportes</button>
      <button onclick="filtrar('carreras')">Carreras</button>
    </nav>
  </header>

  <div class="container">
    <!-- Acción -->
    <div class="game-card" data-categoria="accion" onclick="expandir(this)">
      <img src="7ff691c1d31d0943c555d6826059cfa4.jpg" alt="GTA SA">
      <div class="info">
        <h2>Grand Theft Auto: San Andreas</h2>
        <p><strong>Género:</strong> Acción / Mundo abierto</p>
        <p><strong>Empresa:</strong> Rockstar Games</p>
        <p><strong>Año:</strong> 2004</p>
        <p><strong>Consola:</strong> PS2</p>
      </div>
      <div class="long-story">
        CJ regresa a Los Santos tras la muerte de su madre, y se ve envuelto en guerras de pandillas, corrupción policial y traiciones. 
        El juego ofrece un enorme mundo abierto con misiones variadas, personalización de personajes, vehículos y territorios.
      </div>
      
    </div>

    <!-- Aventura -->
    <div class="game-card" data-categoria="aventura" onclick="expandir(this)">
      <img src="Shadows.webp" alt="Shadow of the Colossus">
      <div class="info">
        <h2>Shadow of the Colossus</h2>
        <p><strong>Género:</strong> Aventura / Acción</p>
        <p><strong>Empresa:</strong> Team ICO</p>
        <p><strong>Año:</strong> 2005</p>
        <p><strong>Consola:</strong> PS2</p>
        
      </div>
      <div class="long-story">
        Wander debe derrotar a 16 colosos para traer de vuelta a la vida a una joven. 
        El juego es famoso por su atmósfera épica, mundo misterioso y batallas únicas contra gigantescas criaturas.
      </div>
    </div>

    <!-- RPG -->
    <div class="game-card" data-categoria="rpg" onclick="expandir(this)">
      <img src="final.jpeg" alt="Final Fantasy X">
      <div class="info">
        <h2>Final Fantasy X</h2>
        <p><strong>Género:</strong> RPG</p>
        <p><strong>Empresa:</strong> Square Enix</p>
        <p><strong>Año:</strong> 2001</p>
        <p><strong>Consola:</strong> PS2</p>
      </div>
      <div class="long-story">
        Tidus, un joven jugador de blitzball, se une a Yuna en un viaje para derrotar a "Sin", una criatura que aterroriza al mundo. 
        Con un sistema de batalla por turnos y una emotiva historia, FFX es uno de los RPG más recordados de la saga.
      </div>
    </div>

    <!-- Deportes -->
    <div class="game-card" data-categoria="deportes" onclick="expandir(this)">
      <img src="PES.jpeg" alt="PES 6">
      <div class="info">
        <h2>Pro Evolution Soccer 6</h2>
        <p><strong>Género:</strong> Deportes / Fútbol</p>
        <p><strong>Empresa:</strong> Konami</p>
        <p