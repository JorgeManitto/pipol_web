<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Pipol — Talento Fraccional</title>
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
  .nav-links a.active {
    background: var(--grad-text);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    font-weight: 600;
  }

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
    padding: 80px 32px 90px;
    text-align: center;
    overflow: hidden;
  }

  .hero-section::before {
    content: "";
    position: absolute;
    inset: 0;
    background:
      radial-gradient(ellipse 800px 500px at 50% 20%, rgba(168, 85, 247, 0.13), transparent 60%),
      radial-gradient(ellipse 600px 400px at 80% 60%, rgba(236, 72, 153, 0.06), transparent 60%);
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
    font-size: 17px;
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

  /* Hero feature row (4 items here) */
  .hero-features {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0;
    flex-wrap: wrap;
    max-width: 980px;
    margin: 0 auto;
  }

  .hero-feature {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 0 26px;
    text-align: left;
    position: relative;
    flex: 1;
    min-width: 0;
  }
  .hero-feature:not(:last-child)::after {
    content: "";
    position: absolute;
    right: 0; top: 8px; bottom: 8px;
    width: 1px;
    background: rgba(255, 255, 255, 0.1);
  }

  .hero-feature .ficon {
    width: 40px; height: 40px;
    border-radius: 50%;
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
    margin-bottom: 3px;
  }
  .hero-feature .text span {
    font-size: 12px;
    color: var(--text-muted);
    line-height: 1.4;
  }

  /* ===== Para empresas (5 cards) ===== */
  .companies-section {
    background: var(--bg-dark-2);
    padding: 80px 32px;
    position: relative;
  }

  .companies-inner {
    max-width: 1180px;
    margin: 0 auto;
  }

  .companies-section h2 {
    text-align: center;
    font-size: 34px;
    font-weight: 800;
    letter-spacing: -0.02em;
    margin-bottom: 56px;
  }

  .companies-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 16px;
  }

  .company-card {
    text-align: center;
    padding: 36px 18px 32px;
    border-radius: 16px;
    background: rgba(255, 255, 255, 0.025);
    border: 1px solid rgba(255, 255, 255, 0.05);
    transition: transform .25s ease, border-color .25s ease, background .25s ease;
  }
  .company-card:hover {
    transform: translateY(-4px);
    border-color: rgba(168, 85, 247, 0.35);
    background: rgba(168, 85, 247, 0.05);
  }

  .company-card .cicon {
    color: var(--purple-light);
    margin-bottom: 24px;
    display: inline-flex;
  }

  .company-card h4 {
    font-size: 17px;
    font-weight: 700;
    margin-bottom: 14px;
    letter-spacing: -0.01em;
  }

  .company-card p {
    font-size: 13px;
    color: var(--text-muted);
    line-height: 1.55;
  }

  /* ===== Cómo funciona (LIGHT) ===== */
  .process-section {
    background: var(--bg-light);
    color: var(--text-dark);
    padding: 90px 32px 60px;
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
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 60px;
    position: relative;
  }

  .pstep {
    position: relative;
    text-align: center;
    padding: 0 12px;
  }

  .pstep-icon {
    width: 100px; height: 100px;
    border-radius: 50%;
    border: 2px solid rgba(168, 85, 247, 0.35);
    background: white;
    display: grid; place-items: center;
    margin: 0 auto 14px;
    color: var(--purple-dark);
    box-shadow: 0 4px 20px -8px rgba(168, 85, 247, 0.2);
  }

  .pstep-num {
    font-size: 17px;
    font-weight: 700;
    color: var(--purple-dark);
    margin-bottom: 18px;
  }

  .pstep h4 {
    font-size: 18px;
    font-weight: 700;
    letter-spacing: -0.01em;
    margin-bottom: 14px;
    line-height: 1.25;
    color: var(--text-dark);
  }

  .pstep p {
    font-size: 13px;
    color: var(--text-muted-light);
    line-height: 1.55;
  }

  /* dashed connector arrows on light bg */
  .pstep:not(:last-child)::after {
    content: "";
    position: absolute;
    top: 50px;
    left: calc(50% + 60px);
    right: calc(-50% + 60px);
    height: 2px;
    background-image: linear-gradient(to right, rgba(168, 85, 247, 0.5) 50%, transparent 50%);
    background-size: 10px 2px;
    background-repeat: repeat-x;
  }
  .pstep:not(:last-child)::before {
    content: "";
    position: absolute;
    top: 46px;
    right: calc(-50% + 60px);
    width: 0; height: 0;
    border-left: 8px solid rgba(168, 85, 247, 0.6);
    border-top: 5px solid transparent;
    border-bottom: 5px solid transparent;
    z-index: 1;
  }

  /* ===== Stats / Trust banner ===== */
  .trust-banner-wrap {
    background: var(--bg-light);
    padding: 0 32px 80px;
  }

  .trust-banner {
    max-width: 1100px;
    margin: 0 auto;
    background: linear-gradient(135deg, #1A1A35 0%, #14122A 100%);
    border-radius: 20px;
    padding: 32px 40px;
    display: grid;
    grid-template-columns: 1fr auto auto;
    gap: 40px;
    align-items: center;
    border: 1px solid rgba(168, 85, 247, 0.15);
    position: relative;
    overflow: hidden;
  }
  .trust-banner::before {
    content: "";
    position: absolute;
    top: -100px; right: -100px;
    width: 300px; height: 300px;
    background: radial-gradient(circle, rgba(168, 85, 247, 0.15), transparent 70%);
    pointer-events: none;
  }

  .trust-text {
    display: flex;
    align-items: center;
    gap: 20px;
    position: relative;
  }

  .trust-icon {
    width: 48px; height: 48px;
    border-radius: 12px;
    background: linear-gradient(135deg, rgba(168, 85, 247, 0.25), rgba(168, 85, 247, 0.1));
    border: 1px solid rgba(168, 85, 247, 0.4);
    display: grid; place-items: center;
    color: var(--purple-light);
    flex-shrink: 0;
  }

  .trust-text strong {
    display: block;
    font-size: 17px;
    font-weight: 700;
    color: white;
    margin-bottom: 4px;
    letter-spacing: -0.01em;
  }
  .trust-text span {
    font-size: 13px;
    color: var(--text-muted);
    line-height: 1.5;
    max-width: 480px;
    display: block;
  }

  .stat {
    text-align: left;
    display: flex;
    /* align-items: baseline; */
    gap: 12px;
    position: relative;
  }
  .stat .num {
    font-size: 38px;
    font-weight: 800;
    background: linear-gradient(135deg, #A855F7, #C084FC);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    letter-spacing: -0.03em;
    line-height: 1;
  }
  .stat .label {
    font-size: 12px;
    color: var(--text-muted);
    line-height: 1.35;
    max-width: 110px;
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

    .companies-section { padding: 60px 20px; }
    .companies-section h2 { font-size: 26px; }
    .companies-grid { grid-template-columns: repeat(2, 1fr); }
    .companies-grid .company-card:nth-child(5) {
      grid-column: 1 / -1;
      max-width: 50%;
      margin: 0 auto;
      width: 100%;
    }

    .process-section { padding: 60px 20px 50px; }
    .process-section h2 { font-size: 32px; margin-bottom: 48px; }
    .process-steps { grid-template-columns: repeat(2, 1fr); gap: 40px 16px; }
    .pstep:nth-child(2):not(:last-child)::after,
    .pstep:nth-child(2):not(:last-child)::before { display: none; }

    .trust-banner-wrap { padding: 0 20px 60px; }
    .trust-banner {
      grid-template-columns: 1fr;
      gap: 24px;
      padding: 28px 24px;
    }
    .trust-text { flex-direction: column; align-items: flex-start; text-align: left; }
    .stat { justify-content: flex-start; }
  }

  @media (max-width: 480px) {
    .process-steps { grid-template-columns: 1fr; }
    .pstep:not(:last-child)::after,
    .pstep:not(:last-child)::before { display: none; }
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
<body style="height: 100vh;">

    <!-- Top Navigation -->
    <div class="nav-wrap sticky top-0" style="position: sticky; top: 0;">
        <nav class="top">
            <a href="{{ route('home') }}">
                <img src="{{ asset('/images/logo-v3.png') }}" alt="Pipol" style="width: 100px; height: auto;">
            </a>

            <ul class="nav-links" id="navLinks">
            <li><a href="{{ route('home') }}">Qué es Pipol</a></li>
            <li><a href="{{ route('home.fraccional') }}" class="active">Fraccional</a></li>
            <li><a href="{{ route('home.mentoria') }}">Mentoría</a></li>
            <li><a href="{{ route('home.mentors') }}">Quiero ser mentor</a></li>

            <!-- Estos solo se ven en mobile, dentro del menú desplegable -->
            <li class="mobile-only"><a href="{{ route('fraccional.auth.show') }}">Iniciar sesión</a></li>
            <li class="mobile-only">
                <a href="{{ route('fraccional.auth.show') }}" class="btn-register-mobile">Registrarme</a>
            </li>
            </ul>

            <div class="nav-actions">
            <a href="{{ route('fraccional.auth.show') }}" class="login">Iniciar sesión</a>
            <a href="{{ route('fraccional.auth.show') }}" class="btn-register">Registrarme</a>
            <button class="menu-toggle" id="menuToggle" aria-label="Menú" aria-expanded="false" aria-controls="navLinks">
                <span></span><span></span><span></span>
            </button>
            </div>
        </nav>
    </div>

  <!-- HERO -->
  <section class="hero-section">
    <div class="hero-inner">
      <div class="badge">TALENTO FRACCIONAL</div>
      <h1>Líderes senior, por el tiempo<br/>que <span class="grad">tu negocio</span> necesita.</h1>
      <p class="subtitle">Contratá profesionales de alto nivel en modalidad fraccional.<br/>Más impacto, menos costo. Sin compromisos a largo plazo.</p>

      <div class="hero-buttons">
        <a href="{{ route('fraccional.index') }}" class="btn-primary">
          Encontrar talento fraccional
          <svg class="arrow" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="5" y1="12" x2="19" y2="12"/>
            <polyline points="12 5 19 12 12 19"/>
          </svg>
        </a>
        <a href="{{ route('fraccional.auth.show') }}" class="btn-outline">
          Quiero ser talento fraccional
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
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
              <circle cx="9" cy="7" r="4"/>
              <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
          </div>
          <div class="text">
            <strong>Talento senior</strong>
            <span>Profesionales validados con experiencia real.</span>
          </div>
        </div>

        <div class="hero-feature">
          <div class="ficon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"/>
              <polyline points="12 6 12 12 16 14"/>
            </svg>
          </div>
          <div class="text">
            <strong>Flexibilidad total</strong>
            <span>Por horas o proyectos, según lo que necesites.</span>
          </div>
        </div>

        <div class="hero-feature">
          <div class="ficon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <line x1="12" y1="1" x2="12" y2="23"/>
              <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
            </svg>
          </div>
          <div class="text">
            <strong>Más eficiencia</strong>
            <span>Menos costo fijo, más impacto.</span>
          </div>
        </div>

        <div class="hero-feature">
          <div class="ficon">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
              <path d="m9 12 2 2 4-4"/>
            </svg>
          </div>
          <div class="text">
            <strong>Sin compromisos</strong>
            <span>Contrataciones ágiles y sin permanencia.</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Para empresas -->
  <section class="companies-section">
    <div class="companies-inner">
      <h2>Para empresas que quieren moverse más rápido.</h2>

      <div class="companies-grid">
        <div class="company-card">
          <div class="cicon">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
              <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/>
              <path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/>
              <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"/>
              <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/>
            </svg>
          </div>
          <h4>Startups</h4>
          <p>Acelerá tu crecimiento con líderes que ya escalaron antes.</p>
        </div>

        <div class="company-card">
          <div class="cicon">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
              <path d="M3 3v18h18"/>
              <path d="m7 14 4-4 4 4 5-5"/>
              <polyline points="14 5 19 5 19 10"/>
            </svg>
          </div>
          <h4>Pymes en crecimiento</h4>
          <p>Sumá expertise senior sin sumar estructura innecesaria.</p>
        </div>

        <div class="company-card">
          <div class="cicon">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
              <path d="M19.439 7.85c-.049.322.059.648.289.878l1.568 1.568c.47.47.706 1.087.706 1.704s-.235 1.233-.706 1.704l-1.611 1.611a.98.98 0 0 1-.837.276c-.47-.07-.802-.48-.968-.925a2.501 2.501 0 1 0-3.214 3.214c.446.166.855.497.925.968a.98.98 0 0 1-.276.837l-1.61 1.61a2.404 2.404 0 0 1-1.705.707 2.402 2.402 0 0 1-1.704-.706l-1.568-1.568a1.026 1.026 0 0 0-.877-.29c-.493.074-.84.504-1.02.968a2.5 2.5 0 1 1-3.237-3.237c.464-.18.894-.527.967-1.02a1.026 1.026 0 0 0-.289-.877l-1.568-1.568A2.402 2.402 0 0 1 1.998 12c0-.617.236-1.234.706-1.704L4.23 8.77c.24-.24.581-.353.917-.303.515.077.877.528 1.073 1.01a2.5 2.5 0 1 0 3.259-3.259c-.482-.196-.933-.558-1.01-1.073-.05-.336.062-.676.303-.917l1.525-1.525A2.402 2.402 0 0 1 12 1.998c.617 0 1.234.236 1.704.706l1.568 1.568c.23.23.556.338.877.29.493-.074.84-.504 1.02-.968a2.5 2.5 0 1 1 3.237 3.237c-.464.18-.894.527-.967 1.02"/>
            </svg>
          </div>
          <h4>Proyectos específicos</h4>
          <p>Resolvemos desafíos puntuales con foco y experiencia.</p>
        </div>

        <div class="company-card">
          <div class="cicon">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="23 4 23 10 17 10"/>
              <polyline points="1 20 1 14 7 14"/>
              <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/>
            </svg>
          </div>
          <h4>Transformaciones</h4>
          <p>Liderá cambios importantes con el talento adecuado en el momento justo.</p>
        </div>

        <div class="company-card">
          <div class="cicon">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
              <rect x="4" y="2" width="16" height="20" rx="2"/>
              <path d="M9 22v-4h6v4"/>
              <path d="M8 6h.01M16 6h.01M12 6h.01M8 10h.01M16 10h.01M12 10h.01M8 14h.01M16 14h.01M12 14h.01"/>
            </svg>
          </div>
          <h4>Empresas consolidadas</h4>
          <p>Complementá tu equipo con especialistas de primer nivel.</p>
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
            <svg width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
              <rect x="4" y="3" width="16" height="18" rx="2"/>
              <line x1="8" y1="8" x2="16" y2="8"/>
              <line x1="8" y1="12" x2="16" y2="12"/>
              <line x1="8" y1="16" x2="13" y2="16"/>
            </svg>
          </div>
          <div class="pstep-num">1</div>
          <h4>Contanos qué necesitás</h4>
          <p>Contanos el desafío, el rol y la dedicación que buscás.</p>
        </div>

        <div class="pstep">
          <div class="pstep-icon">
            <svg width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
              <circle cx="9" cy="7" r="4"/>
              <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
          </div>
          <div class="pstep-num">2</div>
          <h4>Te mostramos opciones</h4>
          <p>Te presentamos perfiles senior validados y disponibles.</p>
        </div>

        <div class="pstep">
          <div class="pstep-icon">
            <svg width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="4" width="18" height="18" rx="2"/>
              <line x1="16" y1="2" x2="16" y2="6"/>
              <line x1="8" y1="2" x2="8" y2="6"/>
              <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
          </div>
          <div class="pstep-num">3</div>
          <h4>Coordinás una charla</h4>
          <p>Conocé al profesional y definí si es la persona indicada.</p>
        </div>

        <div class="pstep">
          <div class="pstep-icon">
            <svg width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"/>
              <polyline points="9 12 11 14 15 10"/>
            </svg>
          </div>
          <div class="pstep-num">4</div>
          <h4>Empezás a trabajar</h4>
          <p>De forma ágil, flexible y sin complicaciones.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Trust banner -->
  <div class="trust-banner-wrap">
    <div class="trust-banner">
      <div class="trust-text">
        <div class="trust-icon">
          <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
          </svg>
        </div>
        <div>
          <strong>Calidad y confianza en cada conexión.</strong>
          <span>Todos los talentos son validados por Pipol para garantizar experiencia, resultados y profesionalismo.</span>
        </div>
      </div>

      <div class="stat">
        <div class="num">+120</div>
        <div class="label">talentos fraccionales disponibles</div>
      </div>

      <div class="stat">
        <div class="num">98%</div>
        <div class="label">empresas satisfechas con nuestros matches</div>
      </div>
    </div>
  </div>

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