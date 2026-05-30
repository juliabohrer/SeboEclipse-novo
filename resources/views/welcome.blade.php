<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eclipse Sebo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Crimson+Pro:ital,wght@0,300;0,400;1,300&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --void:      #0d0d14;
            --deep:      #12111f;
            --surface:   #1a1830;
            --overlay:   #221f3a;
            --border:    rgba(180,160,255,.15);
            --purple:    #a78bfa;
            --purple-lt: #c4b5fd;
            --purple-dk: #7c3aed;
            --gold:      #e2b85a;
            --gold-lt:   #f0d08a;
            --muted:     #7c7a9e;
            --text:      #e8e6f5;
            --text-dim:  #b0adc8;
        }

        html, body { height: 100%; }

        body {
            font-family: 'Crimson Pro', Georgia, serif;
            background: var(--void);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
        }

        /* ── STARFIELD ── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                radial-gradient(1px 1px at 15% 20%, rgba(167,139,250,.6) 0%, transparent 100%),
                radial-gradient(1px 1px at 40% 10%, rgba(196,181,253,.4) 0%, transparent 100%),
                radial-gradient(1.5px 1.5px at 70% 30%, rgba(226,184,90,.5) 0%, transparent 100%),
                radial-gradient(1px 1px at 85% 15%, rgba(167,139,250,.3) 0%, transparent 100%),
                radial-gradient(1px 1px at 25% 75%, rgba(196,181,253,.3) 0%, transparent 100%),
                radial-gradient(1.5px 1.5px at 55% 85%, rgba(226,184,90,.4) 0%, transparent 100%),
                radial-gradient(1px 1px at 90% 70%, rgba(167,139,250,.5) 0%, transparent 100%),
                radial-gradient(1px 1px at 10% 50%, rgba(196,181,253,.2) 0%, transparent 100%),
                radial-gradient(1px 1px at 60% 55%, rgba(226,184,90,.3) 0%, transparent 100%),
                radial-gradient(1px 1px at 78% 88%, rgba(167,139,250,.4) 0%, transparent 100%),
                radial-gradient(1px 1px at 33% 40%, rgba(255,255,255,.15) 0%, transparent 100%),
                radial-gradient(1px 1px at 47% 65%, rgba(255,255,255,.1) 0%, transparent 100%);
            pointer-events: none;
            z-index: 0;
        }

        /* ── ECLIPSE GLOW ── */
        body::after {
            content: '';
            position: fixed;
            top: -30vh;
            left: 50%;
            transform: translateX(-50%);
            width: 600px;
            height: 600px;
            background: radial-gradient(ellipse, rgba(124,58,237,.18) 0%, rgba(124,58,237,.06) 40%, transparent 70%);
            pointer-events: none;
            z-index: 0;
        }

        /* ── MAIN ── */
        main {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 3rem 2rem;
            width: 100%;
            max-width: 700px;
        }

        /* ── ECLIPSE LOGO MARK ── */
        .eclipse-mark {
            position: relative;
            width: 96px;
            height: 96px;
            margin-bottom: 2rem;
            flex-shrink: 0;
        }

        .eclipse-mark .ring {
            position: absolute;
            inset: 0;
            border-radius: 50%;
            border: 1.5px solid rgba(167,139,250,.4);
        }

        .eclipse-mark .ring-outer {
            border-color: rgba(226,184,90,.25);
            animation: pulse-ring 4s ease-in-out infinite;
        }

        .eclipse-mark .moon {
            position: absolute;
            inset: 12px;
            border-radius: 50%;
            background: var(--deep);
            border: 1.5px solid rgba(167,139,250,.5);
        }

        .eclipse-mark .corona {
            position: absolute;
            inset: -8px;
            border-radius: 50%;
            background: radial-gradient(ellipse at 30% 30%, rgba(226,184,90,.15) 0%, transparent 60%);
        }

        .eclipse-mark .book-icon {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @keyframes pulse-ring {
            0%, 100% { transform: scale(1); opacity: .4; }
            50%       { transform: scale(1.06); opacity: .7; }
        }

        /* ── TITLE ── */
        .site-title {
            font-family: 'Cinzel', serif;
            font-size: clamp(2.2rem, 6vw, 3.4rem);
            font-weight: 700;
            letter-spacing: .08em;
            line-height: 1.1;
            background: linear-gradient(135deg, var(--purple-lt) 0%, var(--gold) 60%, var(--purple) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: .4rem;
        }

        .site-subtitle {
            font-family: 'Crimson Pro', serif;
            font-style: italic;
            font-size: 1.05rem;
            font-weight: 300;
            color: var(--muted);
            letter-spacing: .06em;
            margin-bottom: 3rem;
        }

        /* ── DIVIDER ── */
        .divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            width: 100%;
            max-width: 400px;
            margin-bottom: 2.5rem;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(167,139,250,.4), transparent);
        }

        .divider-gem {
            width: 6px;
            height: 6px;
            background: var(--gold);
            transform: rotate(45deg);
            flex-shrink: 0;
            opacity: .7;
        }

        /* ── NAV GRID ── */
        .nav-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: .9rem;
            width: 100%;
            max-width: 620px;
        }

        .nav-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: .55rem;
            padding: 1.3rem 1rem;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 8px;
            text-decoration: none;
            color: var(--text-dim);
            font-family: 'Cinzel', serif;
            font-size: .72rem;
            letter-spacing: .12em;
            text-transform: uppercase;
            transition: all .25s ease;
            position: relative;
            overflow: hidden;
        }

        .nav-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(167,139,250,.06) 0%, transparent 60%);
            opacity: 0;
            transition: opacity .25s;
        }

        .nav-btn:hover {
            border-color: rgba(167,139,250,.5);
            color: var(--purple-lt);
            transform: translateY(-3px);
            box-shadow: 0 8px 32px rgba(124,58,237,.2);
        }

        .nav-btn:hover::before { opacity: 1; }

        .nav-btn svg {
            width: 26px;
            height: 26px;
            stroke: var(--gold);
            fill: none;
            stroke-width: 1.5;
            stroke-linecap: round;
            stroke-linejoin: round;
            transition: stroke .25s, transform .25s;
            flex-shrink: 0;
        }

        .nav-btn:hover svg {
            stroke: var(--gold-lt);
            transform: scale(1.12);
        }

        /* ── FOOTER ── */
        footer {
            position: relative;
            z-index: 1;
            margin-top: 3rem;
            font-family: 'Crimson Pro', serif;
            font-style: italic;
            font-size: .85rem;
            color: rgba(124,122,158,.5);
            letter-spacing: .04em;
        }
    </style>
</head>
<body>

<main>
    {{-- Eclipse mark --}}
    <div class="eclipse-mark" aria-hidden="true">
        <div class="corona"></div>
        <div class="ring ring-outer"></div>
        <div class="ring"></div>
        <div class="moon"></div>
        <div class="book-icon">
            <svg viewBox="0 0 24 24" style="width:28px;height:28px;stroke:var(--gold);fill:none;stroke-width:1.5;stroke-linecap:round;stroke-linejoin:round" aria-hidden="true">
                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
            </svg>
        </div>
    </div>

    <h1 class="site-title">Eclipse Sebo</h1>
    <p class="site-subtitle">Sistema de Gestão · Livraria &amp; Sebo</p>

    <div class="divider" aria-hidden="true">
        <div class="divider-gem"></div>
    </div>

    {{-- Navigation --}}
    <nav class="nav-grid" aria-label="Menu principal">

        <a href="{{ route('livros.index') }}" class="nav-btn">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
            </svg>
            Livros
        </a>

        <a href="/usuarios" class="nav-btn">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
            Usuários
        </a>

        <a href="/troca-livros" class="nav-btn">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M7 16V4m0 0L3 8m4-4 4 4"/>
                <path d="M17 8v12m0 0 4-4m-4 4-4-4"/>
            </svg>
            Trocas
        </a>

        <a href="/vendas" class="nav-btn">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/>
                <line x1="3" y1="6" x2="21" y2="6"/>
                <path d="M16 10a4 4 0 0 1-8 0"/>
            </svg>
            Vendas
        </a>

        <a href="/compras" class="nav-btn">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
            </svg>
            Compras
        </a>

        <a href="/eventos" class="nav-btn">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                <line x1="16" y1="2" x2="16" y2="6"/>
                <line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            Eventos
        </a>

        <a href="/pagamentos" class="nav-btn">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                <line x1="1" y1="10" x2="23" y2="10"/>
            </svg>
            Pagamentos
        </a>

    </nav>
</main>

<footer>© {{ date('Y') }} Eclipse Sebo — todos os direitos reservados</footer>

</body>
</html>
