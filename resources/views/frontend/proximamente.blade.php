<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Pipol — Tu experiencia, vale.</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
<style>
  :root {
    --bg: #0A0B1A;
    --bg-2: #0E0F22;
    --card: rgba(255, 255, 255, 0.03);
    --card-border: rgba(255, 255, 255, 0.08);
    --text: #ffffff;
    --text-muted: #B4B6C7;
    --text-dim: #7C7F94;
    --purple: #A855F7;
    --pink: #EC4899;
    --cyan: #22D3EE;
    --grad: linear-gradient(90deg, #A855F7 0%, #EC4899 50%, #22D3EE 100%);
    --grad-cta: linear-gradient(90deg, #A855F7 0%, #6366F1 50%, #22D3EE 100%);
    --note: #FEF6B8;
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
    top: -200px;
    left: 50%;
    transform: translateX(-50%);
    width: 1200px;
    height: 800px;
    background:
      radial-gradient(ellipse 600px 400px at 30% 30%, rgba(168, 85, 247, 0.18), transparent 60%),
      radial-gradient(ellipse 500px 350px at 70% 40%, rgba(34, 211, 238, 0.12), transparent 60%);
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
    margin-bottom: 60px;
  }

  .logo-wrap .logo {
    font-size: 30px;
    font-weight: 800;
    letter-spacing: -0.02em;
    background: var(--grad);
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

  .pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.08em;
    color: var(--purple);
    background: rgba(168, 85, 247, 0.08);
    border: 1px solid rgba(168, 85, 247, 0.35);
  }

  /* ===== Hero ===== */
  .hero { text-align: center; margin-bottom: 36px; }

  .badge {
    display: inline-block;
    padding: 8px 18px;
    border-radius: 999px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.12em;
    color: #E9D5FF;
    background: rgba(168, 85, 247, 0.12);
    border: 1px solid rgba(168, 85, 247, 0.4);
    margin-bottom: 28px;
  }

  h1 {
    font-size: 74px;
    font-weight: 800;
    letter-spacing: -0.03em;
    line-height: 1.05;
    margin-bottom: 20px;
  }
  h1 .grad {
    background: var(--grad);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
  }

  .hero p {
    color: var(--text-muted);
    font-size: 16px;
    max-width: 520px;
    margin: 0 auto;
  }

  /* ===== Form layout with sticky note ===== */
  .form-row {
    display: grid;
    grid-template-columns: 1fr 0px;
    margin-bottom: 56px;
    align-items: center;
    justify-items: center;
  }

  .form-card {
    position: relative;
    padding: 28px;
    border-radius: 18px;
    background: linear-gradient(180deg, rgba(255,255,255,0.04), rgba(255,255,255,0.015));
    border: 1px solid var(--card-border);
    backdrop-filter: blur(12px);
  }

  .form-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 22px;
  }

  .form-head .left {
    display: flex;
    align-items: center;
    gap: 14px;
  }

  .icon-box {
    width: 48px; height: 48px;
    flex-shrink: 0;
    border-radius: 12px;
    display: grid; place-items: center;
    background: linear-gradient(135deg, rgba(168,85,247,0.18), rgba(34,211,238,0.12));
    border: 1px solid rgba(168, 85, 247, 0.3);
    color: #C4B5FD;
  }

  .form-head h2 {
    font-size: 22px;
    font-weight: 700;
    letter-spacing: -0.01em;
  }

  .form-head .check {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    color: var(--text-muted);
    font-size: 12px;
    max-width: 200px;
    text-align: left;
  }
  .form-head .check svg {
    flex-shrink: 0;
    color: var(--purple);
    margin-top: 2px;
  }

  .field {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.06);
    margin-bottom: 12px;
    transition: border-color .2s, background .2s;
  }
  .field:hover { border-color: rgba(168, 85, 247, 0.25); }
  .field svg { color: var(--text-dim); flex-shrink: 0; }

  .field input {
    flex: 1;
    background: transparent;
    border: none;
    outline: none;
    color: var(--text);
    font-family: inherit;
    font-size: 14px;
  }
  .field input::placeholder { color: var(--text-dim); }

  .field .field-meta {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 2px;
  }
  .field .field-meta .label { font-size: 14px; color: var(--text); }
  .field .field-meta .sub { font-size: 12px; color: var(--text-dim); }

  .field .upload-link {
    color: var(--cyan);
    font-size: 13px;
    text-decoration: underline;
    cursor: pointer;
    white-space: nowrap;
  }

  .cta {
    width: 100%;
    padding: 16px;
    border: none;
    border-radius: 12px;
    background: var(--grad-cta);
    color: white;
    font-family: inherit;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    margin-top: 8px;
    transition: transform .15s ease, box-shadow .2s ease;
    box-shadow: 0 8px 24px -8px rgba(168, 85, 247, 0.5);
  }
  .cta:hover {
    transform: translateY(-1px);
    box-shadow: 0 12px 32px -8px rgba(168, 85, 247, 0.7);
  }

  .secure {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    color: var(--text-dim);
    font-size: 12px;
    margin-top: 14px;
  }

  /* sticky note */
  .note {
    position: relative;
    background: var(--note);
    color: #1f1d11;
    padding: 16px 14px;
    font-size: 12px;
    line-height: 1.45;
    border-radius: 2px;
    transform: rotate(1.5deg);
    box-shadow:
      0 1px 2px rgba(0,0,0,0.2),
      0 8px 24px rgba(0,0,0,0.3);
    margin-top: 12px;
  }
  .note::before {
    content: "";
    position: absolute;
    top: -8px; left: 50%;
    transform: translateX(-50%) rotate(-2deg);
    width: 56px; height: 14px;
    background: rgba(255,255,255,0.45);
    box-shadow: 0 1px 2px rgba(0,0,0,0.1);
  }

  /* ===== Quote ===== */
  .quote {
    display: flex;
    gap: 18px;
    align-items: flex-start;
    margin-bottom: 32px;
    padding: 0 4px;
  }

  .quote-mark {
    font-family: Georgia, "Times New Roman", serif;
    font-weight: 700;
    background: var(--grad);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
  }

  /* Apertura: decorativa, grande, a la izquierda */
  .quote-mark--open {
    font-size: 32px;
    line-height: 0.8;
    flex-shrink: 0;
    margin-top: -6px;   /* la baja un toque para alinear con la 1ra línea */
  }

  .quote p {
    font-size: 28px;
    font-weight: 500;
    letter-spacing: -0.01em;
    line-height: 1.5;
    color: var(--text);
  }

  .quote p .grad {
    background: var(--grad);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
    font-weight: 600;
  }

/* Cierre: inline, acompaña la última palabra */
.quote-mark--close {
  font-size: 32px;
  line-height: 0;
  vertical-align: -0.22em;
  margin-left: 4px;
}

  /* ===== Features ===== */
  .features {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 36px;
  }
  .feature {
    padding: 20px 18px;
    border-radius: 14px;
    background: linear-gradient(180deg, rgba(255,255,255,0.04), rgba(255,255,255,0.015));
    border: 1px solid var(--card-border);
    transition: transform .25s ease, border-color .25s ease;
  }
  .feature:hover {
    transform: translateY(-3px);
    border-color: rgba(168, 85, 247, 0.3);
  }
  .feature .ficon {
    width: 36px; height: 36px;
    border-radius: 10px;
    display: grid; place-items: center;
    background: linear-gradient(135deg, rgba(168,85,247,0.2), rgba(34,211,238,0.12));
    color: #C4B5FD;
    margin-bottom: 14px;
  }
  .feature h3 {
    font-size: 14px;
    font-weight: 700;
    margin-bottom: 6px;
    letter-spacing: -0.01em;
  }
  .feature p {
    font-size: 12px;
    color: var(--text-muted);
    line-height: 1.45;
  }

  /* ===== Empresas CTA ===== */
  .companies {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    padding: 20px 24px;
    border-radius: 14px;
    background: linear-gradient(180deg, rgba(255,255,255,0.04), rgba(255,255,255,0.015));
    border: 1px solid var(--card-border);
    margin-bottom: 40px;
  }
  .companies .left {
    display: flex; align-items: center; gap: 14px;
  }
  .companies .left .icon-box { width: 40px; height: 40px; border-radius: 10px; }
  .companies .text strong {
    display: block;
    font-size: 15px;
    font-weight: 700;
    margin-bottom: 2px;
  }
  .companies .text span { font-size: 13px; color: var(--text-muted); }

  .btn-outline {
    padding: 11px 20px;
    border-radius: 10px;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.15);
    color: var(--text);
    font-family: inherit;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all .2s;
    white-space: nowrap;
  }
  .btn-outline:hover {
    background: rgba(168, 85, 247, 0.15);
    border-color: rgba(168, 85, 247, 0.4);
  }

  /* ===== Footer ===== */
  footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    padding-top: 24px;
    border-top: 1px solid rgba(255,255,255,0.06);
  }
  footer .foot-logo .logo { font-size: 22px; }
  footer .foot-logo .tagline { font-size: 11px; }

  footer nav {
    display: flex; gap: 28px;
    font-size: 13px; color: var(--text-muted);
  }
  footer nav a { color: inherit; text-decoration: none; transition: color .15s; }
  footer nav a:hover { color: var(--text); }

  .socials { display: flex; gap: 14px; color: var(--text-muted); }
  .socials a { color: inherit; transition: color .15s; }
  .socials a:hover { color: var(--purple); }

  .copy {
    text-align: center;
    margin-top: 18px;
    font-size: 11px;
    color: var(--text-dim);
  }

  .made-by {
    position: fixed;
    bottom: 12px;
    right: 16px;
    font-size: 11px;
    color: var(--text-dim);
    opacity: 0.6;
  }

  /* ===== Responsive ===== */
  @media (max-width: 760px) {
    .page { padding: 24px 18px 40px; }
    h1 { font-size: 36px; }
    .form-row { grid-template-columns: 1fr; }
    .note { transform: rotate(0); max-width: 280px; margin: 0 auto; }
    .features { grid-template-columns: repeat(2, 1fr); }
    .form-head { flex-direction: column; align-items: flex-start; }
    .form-head .check { max-width: none; }
    .companies { flex-direction: column; align-items: flex-start; }
    footer { justify-content: center; text-align: center; }
  }

  /* Subtle entrance */
  @keyframes rise {
    from { opacity: 0; transform: translateY(12px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .badge, h1, .hero p, .form-card, .note { animation: rise .8s ease both; }
  h1 { animation-delay: .05s; }
  .hero p { animation-delay: .12s; }
  .form-card { animation-delay: .18s; }
  .note { animation-delay: .25s; }
 
</style>
</head>
<body>
  <div class="page">

    <!-- Header -->
    <header>
      <a href="{{ route('home') }}">
                <img src="{{ asset('/images/logo-v3.png') }}" alt="Pipol" style="width: 100px; height: auto;">
            </a>
      
      <span class="pill">● MUY PRONTO</span>
    </header>

    <!-- Hero -->
    <section class="hero">
      <div class="badge">ALGO GRANDE ESTÁ POR LLEGAR</div>
      <h1>Rompemos el monopolio de <span class="grad">la experiencia.</span></h1>
      <p>Transformá tu experiencia en nuevas oportunidades, ayudando a otros y generando ingresos de forma flexible y segura.</p>
    </section>

    <!-- Form + sticky note -->
    <div class="form-row">
      <form class="form-card" action="{{ route('pre-registration.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-head">
          <div class="left">
            <div class="icon-box">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="4" y="2" width="16" height="20" rx="2"/>
                <path d="M9 22v-4h6v4"/>
                <path d="M8 6h.01M16 6h.01M12 6h.01M8 10h.01M16 10h.01M12 10h.01M8 14h.01M16 14h.01M12 14h.01"/>
              </svg>
            </div>
            <h2>Pre registrate como<br/>profesional Pipol</h2>
          </div>
          <div class="check">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
              <path d="m9 12 2 2 4-4"/>
            </svg>
            <span>Estamos validando los primeros perfiles que formarán parte de la plataforma.</span>
          </div>
        </div>
        @if (session('success'))
            <div style="padding:12px;border-radius:10px;background:rgba(34,211,238,.12);
                        border:1px solid rgba(34,211,238,.4);color:#67E8F9;
                        font-size:13px;margin-bottom:12px;">
                {{ session('success') }}
            </div>
        @endif


        <div class="field">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="2" y="4" width="20" height="16" rx="2"/>
            <path d="m22 7-10 5L2 7"/>
          </svg>
          <input type="email" name="email" placeholder="Tu email"
               value="{{ old('email') }}" required />
        </div>
        @error('email')
            <small style="color:#F87171;font-size:12px;">{{ $message }}</small>
        @enderror

        <div class="field">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21.44 11.05 12.25 20.24a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66L9.41 17.41a2 2 0 0 1-2.83-2.83l8.49-8.48"/>
            </svg>
            <div class="field-meta">
                <span class="label">Adjuntá tu CV</span>
            </div>
            <label class="upload-link">
                Subir archivo
                <input type="file" name="cv" accept=".pdf,.doc,.docx" hidden
                    onchange="this.previousSibling.textContent = this.files[0]?.name || 'Subir archivo'">
            </label>
        </div>
        @error('cv')
            <small style="color:#F87171;font-size:12px;">{{ $message }}</small>
        @enderror

        <div class="field">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                <path d="M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2zM8.34 17H5.67V9.67h2.67V17zM7 8.5a1.55 1.55 0 1 1 0-3.1 1.55 1.55 0 0 1 0 3.1zM18.34 17h-2.67v-3.57c0-.85-.02-1.95-1.19-1.95-1.19 0-1.37.93-1.37 1.89V17h-2.67V9.67h2.56v1h.04c.36-.68 1.23-1.39 2.53-1.39 2.7 0 3.2 1.78 3.2 4.09V17h-.43z"/>
            </svg>
            <div class="field-meta">
                <input type="url" name="linkedin_url"
                    placeholder="Tu perfil de LinkedIn (opcional)"
                    value="{{ old('linkedin_url') }}"
                    style="background:transparent;border:none;outline:none;color:var(--text);font-family:inherit;font-size:14px;width:100%;" />
                <span class="sub">linkedin.com/in/tu-perfil</span>
            </div>
        </div>
        @error('linkedin_url')
            <small style="color:#F87171;font-size:12px;">{{ $message }}</small>
        @enderror

        <button type="submit" class="cta">Quiero pre registrarme</button>

        <div class="secure">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="11" width="18" height="11" rx="2"/>
            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
          </svg>
          No compartimos tu información. 100% seguro.
        </div>
      </form>

      {{-- <div class="note">
        Al registrarse, enviar un correo informando que el pre registro ha sido exitoso y que pronto tendrán mas novedades.
      </div> --}}
    </div>

    <!-- Quote -->
    <div class="quote">
      <p style="text-align: center;">
        <span class="quote-mark quote-mark--open">“</span>
        Somos el primer ecosistema de talento donde la experiencia <br> se transforma en
        <span class="grad">mejores decisiones.</span><span class="quote-mark quote-mark--close">”</span>
      </p>
    </div>

    <!-- Features -->
    <section class="features">
      <div class="feature">
        <div class="ficon">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
          </svg>
        </div>
        <h3>Monetizá tu experiencia</h3>
        <p>Convertí lo que sabés en ingresos reales de manera simple y transparente.</p>
      </div>

      <div class="feature">
        <div class="ficon">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="m13 2-3 14h7l-3 8 13-16h-9l4-6z"/>
          </svg>
        </div>
        <h3>Definí tu disponibilidad</h3>
        <p>Elegí cuándo y cuánto querés participar. Vos tenés el control.</p>
      </div>

      <div class="feature">
        <div class="ficon">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            <path d="m9 12 2 2 4-4"/>
          </svg>
        </div>
        <h3>Cobrá de forma segura</h3>
        <p>Protegemos tu trabajo y garantizamos pagos seguros y a tiempo.</p>
      </div>

      <div class="feature">
        <div class="ficon">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
            <circle cx="9" cy="7" r="4"/>
            <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
            <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
          </svg>
        </div>
        <h3>Generá impacto real</h3>
        <p>Ayudá a profesionales y empresas a resolver desafíos importantes.</p>
      </div>
    </section>

    <!-- Companies CTA -->
    <div class="companies">
      <div class="left">
        <div class="icon-box">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="4" y="2" width="16" height="20" rx="2"/>
            <path d="M9 22v-4h6v4"/>
            <path d="M8 6h.01M16 6h.01M12 6h.01M8 10h.01M16 10h.01M12 10h.01"/>
          </svg>
        </div>
        <div class="text">
          <strong>¿Buscás talento flexible para tu empresa?</strong>
          <span>Escribinos acá y te avisamos cuando lancemos.</span>
        </div>
      </div>
      <a href="mailto:emi@somospipol.com.ar" class="btn-outline">Escribinos acá</a>
    </div>

    <!-- Footer -->
    <footer>
      <div class="foot-logo logo-wrap">
        <img src="{{ asset('/images/logo-v3.png') }}" alt="Pipol"  style="width: 120px; height: auto;">
      </div>
      <nav>
        <a href="#">Sobre Pipol</a>
        <a href="#">Próximamente</a>
      </nav>
      <div class="socials">
        <a href="#" aria-label="LinkedIn">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2zM8.34 17H5.67V9.67h2.67V17zM7 8.5a1.55 1.55 0 1 1 0-3.1 1.55 1.55 0 0 1 0 3.1zM18.34 17h-2.67v-3.57c0-.85-.02-1.95-1.19-1.95-1.19 0-1.37.93-1.37 1.89V17h-2.67V9.67h2.56v1h.04c.36-.68 1.23-1.39 2.53-1.39 2.7 0 3.2 1.78 3.2 4.09V17z"/></svg>
        </a>
        <a href="#" aria-label="Instagram">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
        </a>
        <a href="#" aria-label="Email">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 5L2 7"/></svg>
        </a>
      </div>
    </footer>

    <div class="copy">© {{ date('Y') }} Pipol. Todos los derechos reservados.</div>
  </div>
</body>
</html>