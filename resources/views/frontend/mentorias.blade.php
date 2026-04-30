<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Pipol — Mentorías 1 a 1</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
<style>
  :root {
    --bg-dark: #0A0B1A;
    --bg-dark-2: #14122A;
    --bg-light: #F5F3F8;
    --text: #ffffff;
    --text-dark: #1A1530;
    --text-muted: #B4B6C7;
    --text-muted-light: #6B6680;
    --text-dim: #7C7F94;
    --purple: #A855F7;
    --purple-light: #C4B5FD;
    --purple-dark: #7C3AED;
    --pink: #EC4899;
    --magenta: #D946EF;
    --grad-text: linear-gradient(90deg, #EC4899 0%, #C026D3 60%, #9333EA 100%);
    --grad-cta: linear-gradient(90deg, #EC4899 0%, #C026D3 50%, #7C3AED 100%);
  }

  * { box-sizing: border-box; margin: 0; padding: 0; }

  html, body {
    background: var(--bg-dark);
    color: var(--text);
    font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
    -webkit-font-smoothing: antialiased;
    line-height: 1.5;
    overflow-x: hidden;
  }

  /* ===== Top Navigation ===== */
  .nav-wrap {
    background: var(--bg-dark);
    border-bottom: 1px solid rgba(255, 255, 255, 0.04);
    position: sticky;
    top: 0;
    z-index: 50;
    backdrop-filter: blur(12px);
    background: rgba(10, 11, 26, 0.85);
  }

  nav.top {
    max-width: 1180px;
    margin: 0 auto;
    padding: 18px 32px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
  }

  .logo-wrap .logo {
    font-size: 30px;
    font-weight: 800;
    letter-spacing: -0.03em;
    background: linear-gradient(90deg, #A855F7 0%, #6366F1 100%);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    line-height: 1;
  }
  .logo-wrap .tagline {
    font-size: 11px;
    color: var(--text-muted);
    margin-top: 3px;
  }

  .nav-links {
    display: flex;
    align-items: center;
    gap: 36px;
    list-style: none;
  }
  .nav-links a {
    color: var(--text);
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: color .15s;
  }
  .nav-links a:hover { color: var(--purple-light); }
  .nav-links a.active { color: var(--purple); font-weight: 600; }

  .nav-actions {
    display: flex;
    align-items: center;
    gap: 24px;
  }
  .nav-actions a.login {
    color: var(--text);
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: color .15s;
  }
  .nav-actions a.login:hover { color: var(--purple-light); }

  .btn-register {
    padding: 11px 26px;
    border-radius: 999px;
    background: linear-gradient(90deg, #A855F7, #7C3AED);
    color: white;
    border: none;
    font-family: inherit;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-block;
    transition: transform .15s, box-shadow .2s;
    box-shadow: 0 4px 16px -4px rgba(168, 85, 247, 0.5);
  }
  .btn-register:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px -4px rgba(168, 85, 247, 0.7);
  }

  .menu-toggle {
    display: none;
    background: transparent;
    border: none;
    color: white;
    cursor: pointer;
    flex-direction: column;
    gap: 5px;
    padding: 8px;
  }
  .menu-toggle span {
    width: 24px; height: 2px;
    background: white;
    border-radius: 2px;
  }

  /* ===== Hero Section ===== */
  .hero-section {
    position: relative;
    padding: 80px 32px 100px;
    text-align: center;
    overflow: hidden;
  }

  .hero-section::before {
    content: "";
    position: absolute;
    inset: 0;
    background:
      radial-gradient(ellipse 800px 500px at 50% 30%, rgba(168, 85, 247, 0.13), transparent 60%),
      radial-gradient(ellipse 600px 400px at 30% 60%, rgba(236, 72, 153, 0.06), transparent 60%);
    pointer-events: none;
  }

  .hero-inner {
    position: relative;
    max-width: 880px;
    margin: 0 auto;
  }

  .badge {
    display: inline-block;
    padding: 9px 22px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.18em;
    color: #E9D5FF;
    background: rgba(168, 85, 247, 0.08);
    border: 1px solid rgba(168, 85, 247, 0.5);
    margin-bottom: 32px;
  }

  h1 {
    font-size: 60px;
    font-weight: 800;
    letter-spacing: -0.025em;
    line-height: 1.08;
    margin-bottom: 28px;
  }
  h1 .grad {
    background: var(--grad-text);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
  }

  .hero-section p.subtitle {
    color: var(--text-muted);
    font-size: 18px;
    max-width: 580px;
    margin: 0 auto 40px;
    line-height: 1.55;
  }

  .hero-buttons {
    display: flex;
    justify-content: center;
    gap: 16px;
    margin-bottom: 64px;
    flex-wrap: wrap;
  }

  .btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 17px 36px;
    border-radius: 999px;
    background: var(--grad-cta);
    color: white;
    border: none;
    font-family: inherit;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: transform .15s, box-shadow .25s;
    box-shadow: 0 10px 32px -8px rgba(217, 70, 239, 0.6),
                0 0 0 1px rgba(255, 255, 255, 0.08) inset;
  }
  .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 40px -8px rgba(217, 70, 239, 0.8),
                0 0 0 1px rgba(255, 255, 255, 0.12) inset;
  }
  .btn-primary .arrow { transition: transform .2s; }
  .btn-primary:hover .arrow { transform: translateX(4px); }

  .btn-outline {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 17px 36px;
    border-radius: 999px;
    background: transparent;
    color: white;
    border: 1.5px solid rgba(255, 255, 255, 0.25);
    font-family: inherit;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    transition: all .2s;
  }
  .btn-outline:hover {
    background: rgba(255, 255, 255, 0.05);
    border-color: rgba(255, 255, 255, 0.5);
  }
  .btn-outline .arrow { transition: transform .2s; }
  .btn-outline:hover .arrow { transform: translateX(4px); }

  /* Hero feature row */
  .hero-features {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0;
    flex-wrap: wrap;
  }

  .hero-feature {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 0 36px;
    text-align: left;
    position: relative;
  }
  .hero-feature:not(:last-child)::after {
    content: "";
    position: absolute;
    right: 0; top: 8px; bottom: 8px;
    width: 1px;
    background: rgba(255, 255, 255, 0.1);
  }

  .hero-feature .ficon {
    width: 36px; height: 36px;
    border-radius: 10px;
    display: grid; place-items: center;
    background: rgba(168, 85, 247, 0.1);
    border: 1px solid rgba(168, 85, 247, 0.3);
    color: var(--purple-light);
    flex-shrink: 0;
  }

  .hero-feature .text strong {
    display: block;
    font-size: 14px;
    font-weight: 700;
    margin-bottom: 2px;
  }
  .hero-feature .text span {
    font-size: 12px;
    color: var(--text-muted);
  }

  /* ===== ¿En qué necesitás ayuda hoy? ===== */
  .help-section {
    background: var(--bg-dark-2);
    padding: 80px 32px;
    position: relative;
  }

  .help-inner {
    max-width: 1180px;
    margin: 0 auto;
  }

  .help-section h2 {
    text-align: center;
    font-size: 36px;
    font-weight: 800;
    letter-spacing: -0.02em;
    margin-bottom: 56px;
  }

  .help-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 16px;
  }

  .help-card {
    text-align: center;
    padding: 36px 18px;
    border-radius: 16px;
    background: rgba(255, 255, 255, 0.025);
    border: 1px solid rgba(255, 255, 255, 0.05);
    transition: transform .25s ease, border-color .25s ease, background .25s ease;
    cursor: pointer;
  }
  .help-card:hover {
    transform: translateY(-4px);
    border-color: rgba(168, 85, 247, 0.3);
    background: rgba(255, 255, 255, 0.04);
  }

  .help-icon {
    width: 60px; height: 60px;
    border-radius: 50%;
    display: grid; place-items: center;
    margin: 0 auto 22px;
    color: white;
  }
  .help-icon.pink { background: linear-gradient(135deg, #EC4899, #DB2777); }
  .help-icon.blue { background: linear-gradient(135deg, #60A5FA, #3B82F6); }
  .help-icon.green { background: linear-gradient(135deg, #34D399, #10B981); }
  .help-icon.orange { background: linear-gradient(135deg, #FB923C, #F97316); }
  .help-icon.purple { background: linear-gradient(135deg, #A78BFA, #7C3AED); }

  .help-card p {
    font-size: 15px;
    font-weight: 600;
    color: var(--text);
    line-height: 1.4;
  }

  /* ===== Cómo funciona (LIGHT) ===== */
  .process-section {
    background: var(--bg-light);
    color: var(--text-dark);
    padding: 90px 32px 100px;
    position: relative;
  }

  .process-inner {
    max-width: 1100px;
    margin: 0 auto;
    text-align: center;
  }

  .process-section .badge {
    color: var(--purple-dark);
    background: rgba(168, 85, 247, 0.06);
    border: 1px solid rgba(168, 85, 247, 0.4);
    margin-bottom: 24px;
  }

  .process-section h2 {
    font-size: 44px;
    font-weight: 800;
    letter-spacing: -0.025em;
    margin-bottom: 64px;
    color: var(--text-dark);
  }

  .process-steps {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 60px;
    position: relative;
  }

  .pstep {
    position: relative;
    text-align: center;
    padding: 0 16px;
  }

  .pstep-icon {
    width: 110px; height: 110px;
    border-radius: 50%;
    border: 2px solid rgba(168, 85, 247, 0.35);
    background: white;
    display: grid; place-items: center;
    margin: 0 auto 16px;
    color: var(--purple-dark);
    box-shadow: 0 4px 20px -8px rgba(168, 85, 247, 0.2);
  }

  .pstep-num {
    font-size: 18px;
    font-weight: 700;
    color: var(--purple-dark);
    margin-bottom: 18px;
  }

  .pstep h4 {
    font-size: 20px;
    font-weight: 700;
    letter-spacing: -0.01em;
    margin-bottom: 14px;
    line-height: 1.25;
    color: var(--text-dark);
  }

  .pstep p {
    font-size: 14px;
    color: var(--text-muted-light);
    line-height: 1.55;
  }

  /* dashed connector arrows on light bg */
  .pstep:not(:last-child)::after {
    content: "";
    position: absolute;
    top: 55px;
    left: calc(50% + 70px);
    right: calc(-50% + 70px);
    height: 2px;
    background-image: linear-gradient(to right, rgba(168, 85, 247, 0.5) 50%, transparent 50%);
    background-size: 10px 2px;
    background-repeat: repeat-x;
  }
  .pstep:not(:last-child)::before {
    content: "";
    position: absolute;
    top: 51px;
    right: calc(-50% + 70px);
    width: 0; height: 0;
    border-left: 8px solid rgba(168, 85, 247, 0.6);
    border-top: 5px solid transparent;
    border-bottom: 5px solid transparent;
    z-index: 1;
  }

  /* Bottom highlight pill */
  .highlight-pill {
    display: inline-flex;
    align-items: center;
    gap: 14px;
    padding: 18px 38px;
    border-radius: 999px;
    background: white;
    border: 1.5px solid rgba(168, 85, 247, 0.3);
    color: var(--purple-dark);
    font-size: 15px;
    font-weight: 600;
    box-shadow: 0 4px 16px -6px rgba(168, 85, 247, 0.2);
  }
  .highlight-pill svg {
    color: var(--purple-dark);
    flex-shrink: 0;
  }

  /* ===== Responsive ===== */
  @media (max-width: 960px) {
    .nav-links, .nav-actions a.login { display: none; }
    .menu-toggle { display: flex; }
    .nav-actions { gap: 12px; }

    h1 { font-size: 40px; }
    .hero-section p.subtitle { font-size: 16px; }
    .hero-section { padding: 50px 20px 70px; }

    .hero-features {
      flex-direction: column;
      align-items: stretch;
      gap: 16px;
    }
    .hero-feature {
      padding: 0;
      justify-content: center;
    }
    .hero-feature:not(:last-child)::after { display: none; }

    .help-section { padding: 60px 20px; }
    .help-section h2 { font-size: 28px; }
    .help-grid {
      grid-template-columns: repeat(2, 1fr);
    }
    .help-grid .help-card:nth-child(5) {
      grid-column: 1 / -1;
      max-width: 50%;
      margin: 0 auto;
      width: 100%;
    }

    .process-section { padding: 60px 20px 70px; }
    .process-section h2 { font-size: 32px; margin-bottom: 48px; }
    .process-steps { grid-template-columns: 1fr; gap: 40px; }
    .pstep:not(:last-child)::after,
    .pstep:not(:last-child)::before { display: none; }

    .highlight-pill {
      padding: 14px 22px;
      font-size: 13px;
      text-align: left;
    }
  }

  /* Subtle entrance animation */
  @keyframes rise {
    from { opacity: 0; transform: translateY(14px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .badge, h1, .hero-section p.subtitle, .hero-buttons { animation: rise .8s ease both; }
  h1 { animation-delay: .08s; }
  .hero-section p.subtitle { animation-delay: .15s; }
  .hero-buttons { animation-delay: .22s; }
     /* Hide mobile-only items by default */
    .mobile-only { display: none; }

    /* Menu toggle hamburger animation */
    .menu-toggle {
    transition: transform .2s;
    }
    .menu-toggle span {
    transition: transform .3s ease, opacity .3s ease;
    transform-origin: center;
    }
    .menu-toggle.is-open span:nth-child(1) {
    transform: translateY(7px) rotate(45deg);
    }
    .menu-toggle.is-open span:nth-child(2) {
    opacity: 0;
    }
    .menu-toggle.is-open span:nth-child(3) {
    transform: translateY(-7px) rotate(-45deg);
    }

    /* Mobile menu overlay */
    @media (max-width: 960px) {
    /* Reposition menu as dropdown panel */
    .nav-links {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        flex-direction: column;
        align-items: stretch;
        gap: 0;
        background: rgba(10, 11, 26, 0.98);
        backdrop-filter: blur(16px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        padding: 12px 24px 24px;
        /* Hidden by default */
        opacity: 0;
        visibility: hidden;
        transform: translateY(-8px);
        transition: opacity .25s ease, transform .25s ease, visibility .25s;
        display: flex !important; /* override the display:none from the mobile breakpoint */
    }

    .nav-links.is-open {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .nav-links li {
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }
    .nav-links li:last-child { border-bottom: none; }

    .nav-links li a {
        display: block;
        padding: 16px 4px;
        font-size: 15px;
        width: 100%;
    }

    .mobile-only { display: block; }
    .mobile-only:first-of-type { margin-top: 8px; padding-top: 8px; border-top: 1px solid rgba(255, 255, 255, 0.1); }

    .btn-register-mobile {
        background: linear-gradient(90deg, #A855F7, #7C3AED);
        color: white !important;
        border-radius: 999px;
        text-align: center;
        margin-top: 8px;
        font-weight: 600;
        box-shadow: 0 4px 16px -4px rgba(168, 85, 247, 0.5);
    }

    /* Lock scroll when menu open */
    body.menu-open {
        overflow: hidden;
    }
    }
</style>
</head>
<body style="height: 100dvh;">

   <!-- Top Navigation -->
    <div class="nav-wrap sticky top-0" style="position: sticky; top: 0;">
        <nav class="top">
            <a href="{{ route('home') }}">
                <img src="{{ asset('/images/logo-v3.png') }}" alt="Pipol" style="width: 100px; height: auto;">
            </a>
            <ul class="nav-links" id="navLinks">
            <li><a href="{{ route('home') }}">Qué es Pipol</a></li>
            <li><a href="{{ route('home.fraccional') }}">Fraccional</a></li>
            <li><a href="{{ route('home.mentoria') }}" class="active">Mentoría</a></li>
            <li><a href="{{ route('home.mentors') }}">Quiero ser mentor</a></li>

            <!-- Estos solo se ven en mobile, dentro del menú desplegable -->
            <li class="mobile-only"><a href="{{ route('login') }}">Iniciar sesión</a></li>
            <li class="mobile-only">
                <a href="{{ route('login') }}" class="btn-register-mobile">Registrarme</a>
            </li>
            </ul>

            <div class="nav-actions">
            <a href="{{ route('login') }}" class="login">Iniciar sesión</a>
            <a href="{{ route('login') }}" class="btn-register">Registrarme</a>
            <button class="menu-toggle" id="menuToggle" aria-label="Menú" aria-expanded="false" aria-controls="navLinks">
                <span></span><span></span><span></span>
            </button>
            </div>
        </nav>
    </div>

  <!-- HERO -->
  <section class="hero-section">
    <div class="hero-inner">
      <div class="badge">MENTORÍAS 1 A 1</div>
      <h1>Resolvé lo que te está pasando, hablando con alguien <span class="grad">que ya pasó por lo mismo.</span></h1>
      <p class="subtitle">Mentorías 1 a 1 con profesionales validados para destrabar decisiones reales de carrera, negocio o liderazgo.</p>

      <div class="hero-buttons">
        <a href="{{ route('mentors.index') }}" class="btn-primary">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
          </svg>
          Encontrar mentor
          <svg class="arrow" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="5" y1="12" x2="19" y2="12"/>
            <polyline points="12 5 19 12 12 19"/>
          </svg>
        </a>
        <a href="{{ route('login', ['is_mentor' => true]) }}" class="btn-outline">
          Quiero ser mentor
          <svg class="arrow" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="5" y1="12" x2="19" y2="12"/>
            <polyline points="12 5 19 12 12 19"/>
          </svg>
        </a>
      </div>

      <div class="hero-features">
        <div class="hero-feature">
          <div class="ficon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="8" r="6"/>
              <path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>
            </svg>
          </div>
          <div class="text">
            <strong>Sesiones 1 a 1</strong>
            <span>100% personalizadas</span>
          </div>
        </div>

        <div class="hero-feature">
          <div class="ficon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
            </svg>
          </div>
          <div class="text">
            <strong>Profesionales validados</strong>
            <span>Experiencia real</span>
          </div>
        </div>

        <div class="hero-feature">
          <div class="ficon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="2" y="5" width="20" height="14" rx="2"/>
              <line x1="2" y1="10" x2="22" y2="10"/>
            </svg>
          </div>
          <div class="text">
            <strong>Pagás solo por sesión</strong>
            <span>Sin suscripciones</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ¿En qué necesitás ayuda hoy? -->
  <section class="help-section">
    <div class="help-inner">
      <h2>¿En qué necesitás ayuda hoy?</h2>

      <div class="help-grid">
        <div class="help-card">
          <div class="help-icon pink">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
              <circle cx="12" cy="7" r="4"/>
            </svg>
          </div>
          <p>No sé cómo<br/>pedir un aumento</p>
        </div>

        <div class="help-card">
          <div class="help-icon blue">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
              <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
            </svg>
          </div>
          <p>Quiero cambiar<br/>de trabajo y no sé<br/>por dónde empezar</p>
        </div>

        <div class="help-card">
          <div class="help-icon green">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
              <circle cx="9" cy="7" r="4"/>
              <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
          </div>
          <p>Me ofrecieron<br/>liderar un equipo<br/>y no estoy preparado</p>
        </div>

        <div class="help-card">
          <div class="help-icon orange">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="3" width="18" height="18" rx="2"/>
              <circle cx="8.5" cy="8.5" r="1.5"/>
              <polyline points="21 15 16 10 5 21"/>
            </svg>
          </div>
          <p>Estoy estancado<br/>en mi carrera</p>
        </div>

        <div class="help-card">
          <div class="help-icon purple">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="6" y1="20" x2="6" y2="12"/>
              <line x1="12" y1="20" x2="12" y2="4"/>
              <line x1="18" y1="20" x2="18" y2="8"/>
            </svg>
          </div>
          <p>Tengo un negocio<br/>y no sé cómo<br/>escalarlo</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Cómo funciona (light) -->
  <section class="process-section">
    <div class="process-inner">
      <div class="badge">CÓMO FUNCIONA</div>
      <h2>Así de simple</h2>

      <div class="process-steps">
        <div class="pstep">
          <div class="pstep-icon">
            <svg width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
              <rect x="4" y="3" width="16" height="18" rx="2"/>
              <line x1="8" y1="8" x2="16" y2="8"/>
              <line x1="8" y1="12" x2="16" y2="12"/>
              <line x1="8" y1="16" x2="13" y2="16"/>
            </svg>
          </div>
          <div class="pstep-num">1</div>
          <h4>Contanos qué te<br/>está pasando</h4>
          <p>Completá un formulario rápido para entender tu contexto y qué necesitás.</p>
        </div>

        <div class="pstep">
          <div class="pstep-icon">
            <svg width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
              <circle cx="9" cy="7" r="4"/>
              <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
          </div>
          <div class="pstep-num">2</div>
          <h4>Te mostramos mentores<br/>relevantes</h4>
          <p>Te sugerimos los mejores perfiles según tu situación y objetivos.</p>
        </div>

        <div class="pstep">
          <div class="pstep-icon">
            <svg width="42" height="42" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="4" width="18" height="18" rx="2"/>
              <line x1="16" y1="2" x2="16" y2="6"/>
              <line x1="8" y1="2" x2="8" y2="6"/>
              <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
          </div>
          <div class="pstep-num">3</div>
          <h4>Reservás una sesión<br/>y hablás 1 a 1</h4>
          <p>Elegís día y hora, pagás solo por la sesión y tenés tu mentoría.</p>
        </div>
      </div>

      <div class="highlight-pill">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
        </svg>
        Conversaciones reales. Decisiones reales. Resultados reales.
      </div>
    </div>
  </section>

  <script>
    (function() {
        const toggle = document.getElementById('menuToggle');
        const menu = document.getElementById('navLinks');
        if (!toggle || !menu) return;

        const closeMenu = () => {
        toggle.classList.remove('is-open');
        menu.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
        document.body.classList.remove('menu-open');
        };

        const openMenu = () => {
        toggle.classList.add('is-open');
        menu.classList.add('is-open');
        toggle.setAttribute('aria-expanded', 'true');
        document.body.classList.add('menu-open');
        };

        // Toggle on button click
        toggle.addEventListener('click', (e) => {
        e.stopPropagation();
        menu.classList.contains('is-open') ? closeMenu() : openMenu();
        });

        // Close when clicking a link inside the menu
        menu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', closeMenu);
        });

        // Close on outside click
        document.addEventListener('click', (e) => {
        if (menu.classList.contains('is-open') && !menu.contains(e.target) && !toggle.contains(e.target)) {
            closeMenu();
        }
        });

        // Close on Escape
        document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && menu.classList.contains('is-open')) closeMenu();
        });

        // Close if window resizes back to desktop
        window.addEventListener('resize', () => {
        if (window.innerWidth > 960 && menu.classList.contains('is-open')) closeMenu();
        });
    })();
    </script>

</body>
</html>