    <!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Pipol — Plataforma de talento y mentorías</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
<style>
  :root {
    --bg: #0A0B1A;
    --bg-2: #0E0F22;
    --card: rgba(255, 255, 255, 0.025);
    --card-border: rgba(255, 255, 255, 0.08);
    --text: #ffffff;
    --text-muted: #B4B6C7;
    --text-dim: #7C7F94;
    --purple: #A855F7;
    --purple-light: #C4B5FD;
    --pink: #EC4899;
    --cyan: #22D3EE;
    --teal: #2DD4BF;
    --grad-text: linear-gradient(90deg, #EC4899 0%, #A855F7 50%, #6366F1 100%);
  }

  * { box-sizing: border-box; margin: 0; padding: 0; }

  html, body {
    background: var(--bg);
    color: var(--text);
    font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
    -webkit-font-smoothing: antialiased;
    line-height: 1.5;
    overflow-x: hidden;
  }

  /* Atmospheric background glow */
  body::before {
    content: "";
    position: fixed;
    inset: 0;
    background:
      radial-gradient(ellipse 700px 500px at 50% 5%, rgba(168, 85, 247, 0.14), transparent 60%),
      radial-gradient(ellipse 500px 400px at 20% 50%, rgba(236, 72, 153, 0.06), transparent 60%),
      radial-gradient(ellipse 500px 400px at 80% 70%, rgba(34, 211, 238, 0.06), transparent 60%);
    pointer-events: none;
    z-index: 0;
  }

  .page {
    position: relative;
    z-index: 1;
    max-width: 920px;
    margin: 0 auto;
    padding: 28px 32px 48px;
  }

  /* ===== Header ===== */
  header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 80px;
  }

  .logo-wrap .logo {
    font-size: 36px;
    font-weight: 800;
    letter-spacing: -0.03em;
    background: linear-gradient(90deg, #A855F7 0%, #6366F1 100%);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    line-height: 1;
  }
  .logo-wrap .tagline {
    font-size: 12px;
    color: var(--text-muted);
    margin-top: 4px;
  }

  .menu-btn {
    background: transparent;
    border: none;
    color: var(--text);
    cursor: pointer;
    padding: 8px;
    display: flex;
    flex-direction: column;
    gap: 5px;
    transition: opacity .2s;
  }
  .menu-btn:hover { opacity: .7; }
  .menu-btn span {
    display: block;
    width: 28px;
    height: 2px;
    background: white;
    border-radius: 2px;
  }

  /* ===== Hero ===== */
  .hero {
    text-align: center;
    margin-bottom: 100px;
  }

  .badge {
    display: inline-block;
    padding: 9px 22px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.14em;
    color: #E9D5FF;
    background: rgba(168, 85, 247, 0.08);
    border: 1px solid rgba(168, 85, 247, 0.45);
    margin-bottom: 32px;
  }

  h1 {
    font-size: 64px;
    font-weight: 800;
    letter-spacing: -0.03em;
    line-height: 1.02;
    margin-bottom: 28px;
  }
  h1 .grad {
    background: var(--grad-text);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
  }

  .hero p {
    color: var(--text-muted);
    font-size: 17px;
    max-width: 540px;
    margin: 0 auto;
    line-height: 1.55;
  }

  /* ===== Section labels ===== */
  .section-label {
    display: block;
    text-align: center;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.2em;
    color: var(--purple-light);
    margin-bottom: 20px;
  }

  .section-title {
    text-align: center;
    font-size: 36px;
    font-weight: 800;
    letter-spacing: -0.02em;
    margin-bottom: 56px;
  }

  /* ===== Productos ===== */
  .productos {
    margin-bottom: 100px;
  }

  .productos .section-label { margin-bottom: 24px; }

  .products-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
  }

  .product-card {
    position: relative;
    padding: 28px;
    border-radius: 20px;
    background: linear-gradient(180deg, rgba(255,255,255,0.025), rgba(255,255,255,0.005));
    transition: transform .3s ease;
  }
  .product-card:hover { transform: translateY(-4px); }

  .product-card.purple {
    border: 1.5px solid rgba(168, 85, 247, 0.45);
    box-shadow: 0 0 0 1px rgba(168, 85, 247, 0.1) inset, 0 20px 60px -30px rgba(168, 85, 247, 0.4);
  }
  .product-card.teal {
    border: 1.5px solid rgba(45, 212, 191, 0.45);
    box-shadow: 0 0 0 1px rgba(45, 212, 191, 0.1) inset, 0 20px 60px -30px rgba(45, 212, 191, 0.4);
  }

  .card-head {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 24px;
  }

  .tag {
    display: inline-block;
    padding: 6px 16px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.1em;
    color: white;
  }
  .tag.purple {
    background: linear-gradient(90deg, #A855F7, #6366F1);
  }
  .tag.teal {
    background: linear-gradient(90deg, #2DD4BF, #06B6D4);
  }

  .card-icon {
    width: 56px; height: 56px;
    border-radius: 50%;
    display: grid;
    place-items: center;
    border: 1.5px solid;
  }
  .card-icon.purple {
    border-color: rgba(168, 85, 247, 0.5);
    color: #C4B5FD;
    background: rgba(168, 85, 247, 0.08);
  }
  .card-icon.teal {
    border-color: rgba(45, 212, 191, 0.5);
    color: #5EEAD4;
    background: rgba(45, 212, 191, 0.08);
  }

  .product-card h3 {
    font-size: 26px;
    font-weight: 700;
    letter-spacing: -0.02em;
    line-height: 1.15;
    margin-bottom: 24px;
  }

  .product-list {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 14px;
  }
  .product-list li {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    font-size: 15px;
    color: var(--text);
    font-weight: 500;
  }
  .product-list li svg {
    flex-shrink: 0;
    margin-top: 2px;
  }
  .product-card.purple .product-list li svg { color: #A855F7; }
  .product-card.teal .product-list li svg { color: #2DD4BF; }

  /* ===== Cómo funciona ===== */
  .como-funciona { margin-bottom: 100px; }

  .steps {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 12px;
    position: relative;
  }

  .step {
    text-align: center;
    position: relative;
  }

  .step-num {
    width: 28px; height: 28px;
    border-radius: 50%;
    background: linear-gradient(135deg, #A855F7, #6366F1);
    color: white;
    font-size: 13px;
    font-weight: 700;
    display: grid; place-items: center;
    margin: 0 auto 12px;
    position: relative;
    z-index: 2;
    box-shadow: 0 0 0 4px var(--bg);
  }

  .step-icon {
    width: 80px; height: 80px;
    border-radius: 50%;
    border: 2px solid rgba(168, 85, 247, 0.5);
    background: rgba(168, 85, 247, 0.05);
    color: #C4B5FD;
    display: grid; place-items: center;
    margin: 0 auto 22px;
    position: relative;
  }

  .step h4 {
    font-size: 16px;
    font-weight: 700;
    letter-spacing: -0.01em;
    margin-bottom: 12px;
    line-height: 1.25;
  }

  .step p {
    font-size: 13px;
    color: var(--text-muted);
    line-height: 1.5;
    padding: 0 8px;
  }

  /* dashed connector arrows */
  .step:not(:last-child)::after {
    content: "";
    position: absolute;
    top: 80px;
    left: calc(50% + 50px);
    right: calc(-50% + 50px);
    height: 2px;
    background-image: linear-gradient(to right, rgba(236, 72, 153, 0.6) 50%, transparent 50%);
    background-size: 10px 2px;
    background-repeat: repeat-x;
  }
  .step:not(:last-child)::before {
    content: "";
    position: absolute;
    top: 76px;
    right: calc(-50% + 50px);
    width: 0; height: 0;
    border-left: 7px solid rgba(236, 72, 153, 0.7);
    border-top: 5px solid transparent;
    border-bottom: 5px solid transparent;
    z-index: 1;
  }

  /* ===== Para quién ===== */
  .audiencia { margin-bottom: 80px; }

  .audiencia .section-label {
    font-size: 22px;
    font-weight: 800;
    letter-spacing: -0.02em;
    color: var(--text);
    margin-bottom: 36px;
    text-transform: none;
  }

  .audience-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 14px;
  }

  .audience-card {
    text-align: center;
    padding: 28px 16px;
    border-radius: 16px;
    background: linear-gradient(180deg, rgba(255,255,255,0.03), rgba(255,255,255,0.01));
    border: 1px solid var(--card-border);
    transition: transform .25s ease, border-color .25s ease, background .25s ease;
  }
  .audience-card:hover {
    transform: translateY(-4px);
    border-color: rgba(168, 85, 247, 0.4);
    background: linear-gradient(180deg, rgba(168, 85, 247, 0.08), rgba(255,255,255,0.01));
  }

  .audience-card .aicon {
    color: #C4B5FD;
    margin-bottom: 18px;
  }

  .audience-card h4 {
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 8px;
    letter-spacing: -0.01em;
  }

  .audience-card p {
    font-size: 12px;
    color: var(--text-muted);
    line-height: 1.5;
  }

  /* ===== Footer ===== */
  footer {
    padding-top: 36px;
    border-top: 1px solid rgba(255,255,255,0.06);
  }

  .footer-grid {
    display: grid;
    grid-template-columns: 1.4fr repeat(4, 1fr) auto;
    gap: 32px;
    margin-bottom: 32px;
    align-items: start;
  }

  .footer-col h5 {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.16em;
    color: var(--text);
    margin-bottom: 14px;
  }

  .footer-col ul {
    list-style: none;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }
  .footer-col ul a {
    font-size: 13px;
    color: var(--text-muted);
    text-decoration: none;
    transition: color .15s;
  }
  .footer-col ul a:hover { color: var(--text); }

  .socials {
    display: flex;
    gap: 14px;
    align-items: center;
    align-self: end;
    padding-bottom: 4px;
  }
  .socials a {
    width: 30px; height: 30px;
    display: grid; place-items: center;
    color: var(--text-muted);
    transition: color .15s, transform .15s;
  }
  .socials a:hover {
    color: var(--purple);
    transform: translateY(-2px);
  }

  .copy {
    text-align: center;
    padding-top: 20px;
    border-top: 1px solid rgba(255,255,255,0.04);
    font-size: 12px;
    color: var(--text-dim);
  }

  /* ===== Responsive ===== */
  @media (max-width: 760px) {
    .page { padding: 24px 18px 40px; }
    header { margin-bottom: 50px; }
    .hero { margin-bottom: 70px; }
    h1 { font-size: 40px; }
    .hero p { font-size: 15px; }
    .section-title { font-size: 28px; margin-bottom: 36px; }

    .products-grid { grid-template-columns: 1fr; }
    .product-card h3 { font-size: 22px; }

    .steps { grid-template-columns: 1fr; gap: 28px; }
    .step:not(:last-child)::after,
    .step:not(:last-child)::before { display: none; }

    .audience-grid { grid-template-columns: repeat(2, 1fr); }

    .footer-grid {
      grid-template-columns: 1fr 1fr;
      gap: 24px;
    }
    .footer-grid .footer-col:first-child { grid-column: 1 / -1; }
    .socials { grid-column: 1 / -1; justify-content: center; }
  }

  /* Subtle entrance animation */
  @keyframes rise {
    from { opacity: 0; transform: translateY(14px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .badge, h1, .hero p { animation: rise .8s ease both; }
  h1 { animation-delay: .08s; }
  .hero p { animation-delay: .15s; }
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
     .menu-toggle { display: flex; }
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
            <li><a href="{{ route('home') }}" class="active">Qué es Pipol</a></li>
            <li><a href="{{ route('home.fraccional') }}">Fraccional</a></li>
            <li><a href="{{ route('home.mentoria') }}">Mentoría</a></li>
            <li><a href="{{ route('home.mentors') }}">Quiero ser mentor</a></li>

            <!-- Estos solo se ven en mobile, dentro del menú desplegable -->
            <li class="mobile-only"><a href="{{ route('login') }}">Iniciar sesión</a></li>
            <li class="mobile-only">
                <a href="{{ route('login') }}" class="btn-register-mobile">Registrarme</a>
            </li>
            </ul>

            <div class="nav-actions">
            <button class="menu-toggle" id="menuToggle" aria-label="Menú" aria-expanded="false" aria-controls="navLinks">
                <span></span><span></span><span></span>
            </button>
          </div>
        </nav>
    </div>
  <div class="page">


    <!-- Hero -->
    <section class="hero">
      <div class="badge">PLATAFORMA DE TALENTO Y MENTORÍAS</div>
      <h1>Rompemos el monopolio <span class="grad">de la experiencia</span></h1>
      <p>Pipol es la plataforma donde empresas y personas encuentran el talento y las conversaciones que impulsan decisiones, crecimiento e impacto real.</p>
    </section>

    <!-- Productos -->
    <section class="productos">
      <span class="section-label">NUESTROS PRODUCTOS</span>

      <div class="products-grid">
        <!-- Card 1: Fraccional -->
        <a href="{{ route('home.fraccional') }}" class="product-card purple" style="text-decoration: none;color:#ffffff;">
          <div class="card-head">
            <span class="tag purple">FRACCIONAL</span>
            <div class="card-icon purple">
              <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="18" rx="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
              </svg>
            </div>
          </div>
          <h3>Talento fraccional<br/>para tu empresa</h3>
          <ul class="product-list">
            <li>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
              Profesionales senior en modalidad flexible
            </li>
            <li>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
              Por horas, proyectos u objetivos
            </li>
            <li>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
              Sin compromisos a largo plazo
            </li>
            <li>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
              Contratación ágil y sin permanencia
            </li>
          </ul>
        </a>

        <!-- Card 2: Mentoría -->
        <a href="{{ route('home.mentoria') }}" class="product-card teal" style="text-decoration: none;color:#ffffff;">
          <div class="card-head">
            <span class="tag teal">MENTORÍA</span>
            <div class="card-icon teal">
              <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
              </svg>
            </div>
          </div>
          <h3>Mentorías 1 a 1<br/>para tu crecimiento</h3>
          <ul class="product-list">
            <li>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
              Conversaciones 1 a 1 personalizadas
            </li>
            <li>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
              Profesionales con experiencia real
            </li>
            <li>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
              Elegís a quién querés consultar
            </li>
            <li>
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
              Reservás y hablás. Así de simple.
            </li>
          </ul>
        </a>
      </div>
    </section>

    <!-- Cómo funciona -->
    <section class="como-funciona">
      <span class="section-label">CÓMO FUNCIONA</span>
      <h2 class="section-title">Simple, ágil y efectivo</h2>

      <div class="steps">
        <div class="step">
          <div class="step-num">1</div>
          <div class="step-icon">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <rect x="4" y="3" width="16" height="18" rx="2"/>
              <line x1="8" y1="8" x2="16" y2="8"/>
              <line x1="8" y1="12" x2="16" y2="12"/>
              <line x1="8" y1="16" x2="13" y2="16"/>
            </svg>
          </div>
          <h4>Contanos qué<br/>necesitás</h4>
          <p>Completá un formulario rápido para entender tu desafío u objetivo.</p>
        </div>

        <div class="step">
          <div class="step-num">2</div>
          <div class="step-icon">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
              <circle cx="9" cy="7" r="4"/>
              <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
          </div>
          <h4>Te mostramos<br/>opciones</h4>
          <p>Te presentamos los perfiles más relevantes según tus necesidades.</p>
        </div>

        <div class="step">
          <div class="step-num">3</div>
          <div class="step-icon">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <rect x="3" y="4" width="18" height="18" rx="2"/>
              <line x1="16" y1="2" x2="16" y2="6"/>
              <line x1="8" y1="2" x2="8" y2="6"/>
              <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
          </div>
          <h4>Coordinás y<br/>conectás</h4>
          <p>Agendás una reunión o definís el formato que mejor se adapte a vos.</p>
        </div>

        <div class="step">
          <div class="step-num">4</div>
          <div class="step-icon">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"/>
              <polyline points="9 12 11 14 15 10"/>
            </svg>
          </div>
          <h4>Empezás a lograr<br/>resultados</h4>
          <p>Trabajás con el talento adecuado y avanzás hacia tus objetivos.</p>
        </div>
      </div>
    </section>

    <!-- ¿Para quién es Pipol? -->
    <section class="audiencia">
      <h2 class="section-title">¿PARA QUIÉN ES PIPOL?</h2>

      <div class="audience-grid">
        <div class="audience-card">
          <div class="aicon">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
              <path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/>
              <path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/>
              <path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"/>
              <path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/>
            </svg>
          </div>
          <h4>Startups</h4>
          <p>Escalá tu negocio con expertise senior.</p>
        </div>

        <div class="audience-card">
          <div class="aicon">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
              <rect x="4" y="2" width="16" height="20" rx="2"/>
              <path d="M9 22v-4h6v4"/>
              <path d="M8 6h.01M16 6h.01M12 6h.01M8 10h.01M16 10h.01M12 10h.01M8 14h.01M16 14h.01M12 14h.01"/>
            </svg>
          </div>
          <h4>Empresas</h4>
          <p>Resolvé desafíos clave con talento flexible.</p>
        </div>

        <div class="audience-card">
          <div class="aicon">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
              <circle cx="12" cy="7" r="4"/>
            </svg>
          </div>
          <h4>Profesionales</h4>
          <p>Acelerá tu carrera con mentorías reales.</p>
        </div>

        <div class="audience-card">
          <div class="aicon">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
              <circle cx="9" cy="7" r="4"/>
              <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
              <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
          </div>
          <h4>Equipos</h4>
          <p>Potenciá habilidades y tomá mejores decisiones.</p>
        </div>

        <div class="audience-card">
          <div class="aicon">
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
              <path d="M9 18h6"/>
              <path d="M10 22h4"/>
              <path d="M12 2a7 7 0 0 0-4 12.74V17a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-2.26A7 7 0 0 0 12 2z"/>
            </svg>
          </div>
          <h4>Emprendedores</h4>
          <p>Recibí guía de quienes ya lo hicieron.</p>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer>
      <div class="footer-grid">
        <div class="footer-col">
          <img src="{{ asset('/images/logo-v3.png') }}" alt="Pipol"  style="width: 120px; height: auto;">
        </div>

        <div class="footer-col">
          <h5>PRODUCTOS</h5>
          <ul>
            <li><a href="{{ route('home.fraccional') }}">Fraccional</a></li>
            <li><a href="{{ route('home.mentoria') }}">Mentoría</a></li>
          </ul>
        </div>

        <div class="footer-col">
          <h5>RECURSOS</h5>
          <ul>
            <li><a href="#">Blog</a></li>
            <li><a href="#">Preguntas frecuentes</a></li>
          </ul>
        </div>

        <div class="footer-col">
          <h5>EMPRESA</h5>
          <ul>
            <li><a href="#">Quiénes somos</a></li>
            <li><a href="#">Contacto</a></li>
          </ul>
        </div>

        <div class="footer-col">
          <h5>LEGAL</h5>
          <ul>
            <li><a href="#">Términos y condiciones</a></li>
            <li><a href="#">Política de privacidad</a></li>
          </ul>
        </div>

        <div class="socials">
          <a href="#" aria-label="LinkedIn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2zM8.34 17H5.67V9.67h2.67V17zM7 8.5a1.55 1.55 0 1 1 0-3.1 1.55 1.55 0 0 1 0 3.1zM18.34 17h-2.67v-3.57c0-.85-.02-1.95-1.19-1.95-1.19 0-1.37.93-1.37 1.89V17h-2.67V9.67h2.56v1h.04c.36-.68 1.23-1.39 2.53-1.39 2.7 0 3.2 1.78 3.2 4.09V17z"/></svg>
          </a>
          <a href="#" aria-label="Instagram">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect x="2" y="2" width="20" height="20" rx="5"/>
              <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
              <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
            </svg>
          </a>
          <a href="#" aria-label="X (Twitter)">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
              <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
            </svg>
          </a>
        </div>
      </div>

      <div class="copy">© {{ date('Y') }} Pipol. Todos los derechos reservados.</div>
    </footer>

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