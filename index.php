<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>portfolio [REDACTED]</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Mono:ital,wght@0,300;0,400;0,500;1,300&family=Familjen+Grotesk:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/lucide@latest"></script>
  <style>
    :root {
      --bg: #080808;
      --bg2: #0f0f0f;
      --card: #141414;
      --card-hover: #1c1c1c;
      --border: rgba(255,255,255,0.07);
      --border2: rgba(255,255,255,0.15);
      --text: #f0f0f0;
      --muted: rgba(255,255,255,0.38);
      --amber: #ffffff;
      --amber-dim: rgba(255,255,255,0.08);
      --amber-dim2: rgba(255,255,255,0.16);
      --radius: 10px;
      --mono: 'DM Mono', monospace;
      --sans: 'Familjen Grotesk', sans-serif;
      --section-pad: 52px;
      --project-ratio: 0.56;
      --media-fit: cover;
      --motion-scale: 1;
    }

    html, body { height: 100%; background: var(--bg); color: var(--text); font-family: var(--sans); -webkit-font-smoothing: antialiased; overflow: hidden; }

    /* NOISE */
    body::after {
      content: '';
      position: fixed; inset: 0;
      pointer-events: none; z-index: 999;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='1'/%3E%3C/svg%3E");
      opacity: 0.07;
      mix-blend-mode: overlay;
    }
    body::before {
      content: '';
      position: fixed; inset: 0;
      pointer-events: none; z-index: 998;
      background: radial-gradient(ellipse at center, transparent 55%, rgba(0,0,0,0.65) 100%);
    }

    /* ─── REDACTION UTILITY ─── */
    .redacted {
      background: #fff !important;
      color: transparent !important;
      border-color: #fff !important;
      box-shadow: none !important;
      filter: none !important;
      position: relative;
      user-select: none;
      border-radius: 2px;
    }
    .redacted * { visibility: hidden !important; }
    .redacted img { opacity: 0 !important; }

    /* redaction stamp label */
    .redacted-label {
      display: inline-block;
      background: #fff;
      color: transparent;
      border-radius: 2px;
      padding: 0 6px;
      position: relative;
    }

    /* image placeholder that looks redacted */
    .redact-img {
      background: #000 !important;
      display: block;
      width: 100%;
      height: 100%;
      position: relative;
    }
    .redact-img::after {
      content: '';
      position: absolute;
      inset: 0;
      background: #fff;
    }

    /* profile avatar redacted */
    .avatar-redacted {
      width: 80px; height: 80px;
      background: #fff;
      border-radius: 10px;
      border: 4px solid var(--card);
      outline: 1px solid var(--border2);
      display: block;
      flex-shrink: 0;
    }

    /* name/text redaction bar */
    .text-redacted {
      display: inline-block;
      background: #fff;
      color: transparent;
      border-radius: 2px;
      min-width: 120px;
      height: 1.1em;
      vertical-align: middle;
    }

    /* ─── LAYOUT ─── */
    .shell { display: grid; grid-template-columns: 200px 1fr; height: 100vh; position: relative; z-index: 1; }

    .sidebar { border-right: 1px solid var(--border); display: flex; flex-direction: column; padding: 28px 0; background: var(--bg2); }
    .logo { padding: 0 22px 26px; border-bottom: 1px solid var(--border); margin-bottom: 16px; }
    .logo-name { font-family: var(--mono); font-size: 13px; font-weight: 500; color: var(--amber); letter-spacing: 0.02em; }
    .logo-sub  { font-family: var(--mono); font-size: 10px; color: var(--muted); margin-top: 2px; font-style: italic; }

    .nav-items { display: flex; flex-direction: column; gap: 2px; padding: 0 12px; flex: 1; }
    .nav-link {
      display: flex; align-items: center; gap: 10px;
      padding: 9px 12px; border-radius: 8px;
      background: transparent; border: none;
      color: var(--muted); cursor: pointer;
      font-family: var(--sans); font-size: 13.5px; font-weight: 500;
      transition: all 0.18s; outline: none;
      text-align: left; width: 100%; position: relative;
    }
    .nav-link svg { width: 15px; height: 15px; stroke-width: 1.75; flex-shrink: 0; }
    .nav-link:hover { background: rgba(255,255,255,0.04); color: var(--text); }
    .nav-link.active { background: var(--amber-dim); color: var(--amber); }
    .nav-link.active::before {
      content: ''; position: absolute; left: 0; top: 50%;
      transform: translateY(-50%);
      width: 2px; height: 60%;
      background: var(--amber); border-radius: 0 2px 2px 0;
    }
    .sidebar-bottom { padding: 16px 22px 0; border-top: 1px solid var(--border); margin-top: auto; }

    .main { overflow-y: auto; overflow-x: clip; height: 100vh; background: var(--bg); }
    .main::-webkit-scrollbar { width: 3px; }
    .main::-webkit-scrollbar-thumb { background: var(--border2); border-radius: 2px; }

    .tab { display: none; min-height: 100vh; padding: var(--section-pad); }
    .tab.active { animation: fadeIn 0.3s ease forwards; display: block; }
    #home.active { display: flex; }
    #home { flex-direction: column; justify-content: center; }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(8px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* ─── HOME ─── */
    .home-eyebrow {
      font-family: var(--mono); font-size: 11px; color: var(--amber);
      letter-spacing: 0.15em; text-transform: uppercase;
      margin-bottom: 18px; display: flex; align-items: center; gap: 10px;
    }
    .home-eyebrow::before { content: ''; display: inline-block; width: 24px; height: 1px; background: var(--amber); }

    .home-title { font-family: var(--sans); font-size: clamp(4rem, 9vw, 8rem); font-weight: 700; line-height: 0.95; letter-spacing: -0.04em; color: var(--text); margin-bottom: 24px; }
    .home-title .name-bar { display: inline-block; background: #fff; color: transparent; border-radius: 3px; font-style: italic; padding: 0 8px; }

    .home-desc { font-family: var(--mono); font-size: 13px; color: var(--muted); max-width: 360px; line-height: 1.7; margin-bottom: 40px; }

    .home-actions { display: flex; gap: 12px; align-items: center; }
    .btn-amber {
      padding: 11px 26px; background: var(--amber); color: #080808;
      font-family: var(--mono); font-size: 12px; font-weight: 500;
      letter-spacing: 0.04em; border: none; border-radius: 6px; cursor: pointer;
      text-decoration: none; display: inline-flex; align-items: center; gap: 8px;
      transition: opacity 0.18s;
    }
    .btn-amber:hover { opacity: 0.82; }
    .btn-amber svg { width: 14px; height: 14px; }
    .btn-ghost {
      padding: 11px 22px; background: transparent; color: var(--muted);
      font-family: var(--mono); font-size: 12px;
      border: 1px solid var(--border2); border-radius: 6px; cursor: pointer;
      text-decoration: none; transition: all 0.18s;
    }
    .btn-ghost:hover { color: var(--text); border-color: rgba(255,255,255,0.28); }

    .home-counter { margin-top: 64px; display: flex; gap: 40px; }
    .counter-num   { font-family: var(--mono); font-size: 28px; font-weight: 500; color: var(--text); line-height: 1; }
    .counter-label { font-size: 11px; color: var(--muted); margin-top: 4px; font-family: var(--mono); }

    /* ─── SECTIONS ─── */
    .section-tag {
      font-family: var(--mono); font-size: 10px; color: var(--amber);
      letter-spacing: 0.12em; text-transform: uppercase;
      border: 1px solid var(--amber-dim2); background: var(--amber-dim);
      padding: 3px 9px; border-radius: 4px; margin-bottom: 8px; display: inline-block;
    }
    .section-title { font-family: var(--sans); font-size: 30px; font-weight: 700; letter-spacing: -0.03em; color: var(--text); margin-bottom: 28px; }

    /* ─── ABOUT ─── */
    .about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; position: relative; z-index: 1; }

    .profile-card {
      grid-column: 1 / -1;
      background: var(--card); border: 1px solid var(--border);
      border-radius: var(--radius); overflow: hidden; position: relative;
    }

    .profile-banner-wrap { position: relative; width: 100%; height: 300px; overflow: hidden; background: #000; }
    .profile-banner-wrap::after {
      content: ''; position: absolute; inset: 0;
      background: linear-gradient(to bottom, transparent 55%, var(--card) 100%);
      pointer-events: none; z-index: 2;
    }

    .profile-bottom { display: flex; align-items: flex-end; gap: 16px; padding: 0 22px 20px; }
    .avatar-wrap { position: relative; flex-shrink: 0; width: 80px; height: 80px; margin-top: -40px; z-index: 5; }

    .profile-meta { flex: 1; padding-top: 6px; }
    .profile-name-row { display: flex; align-items: center; gap: 7px; flex-wrap: wrap; margin-bottom: 6px; }
    .profile-badges { display: flex; align-items: center; gap: 6px; flex-wrap: wrap; }
    .badge {
      font-family: var(--mono); font-size: 10.5px;
      padding: 3px 9px; border-radius: 4px;
      background: var(--amber-dim); border: 1px solid var(--amber-dim2); color: var(--amber);
    }

    .card-label {
      font-family: var(--mono); font-size: 9.5px; letter-spacing: 0.12em;
      text-transform: uppercase; color: var(--amber); margin-bottom: 14px;
      display: flex; align-items: center; gap: 8px;
    }
    .card-label::after { content: ''; flex: 1; height: 1px; background: var(--border); }

    .about-text-card {
      background: var(--card); border: 1px solid var(--border); border-radius: var(--radius); padding: 20px 22px;
    }
    .about-text-card .card-label {
      background: rgba(255,255,255,0.03);
      border: 1px solid var(--border);
      border-radius: 6px;
      padding: 8px 10px;
      margin: -6px -8px 16px;
    }
    .social-card { background: var(--card); border: 1px solid var(--border); border-radius: var(--radius); padding: 20px 22px; }
    .social-list { display: flex; flex-direction: column; gap: 4px; margin-top: 2px; }
    .social-item {
      display: flex; align-items: center; gap: 12px; padding: 10px 12px;
      border-radius: 7px; background: transparent; border: 1px solid transparent;
      text-decoration: none; color: var(--muted); transition: all 0.18s;
    }
    .social-item:hover { background: rgba(255,255,255,0.04); border-color: var(--border); color: var(--text); }
    .social-item svg { width: 15px; height: 15px; flex-shrink: 0; }
    .social-item-name   { font-size: 13.5px; font-weight: 500; color: var(--text); }
    .social-item-handle { font-family: var(--mono); font-size: 11px; color: var(--muted); }
    .social-arrow { margin-left: auto; color: var(--muted); }
    .social-arrow svg { width: 13px; height: 13px; opacity: 0.3; }

    /* ─── PROJECTS ─── */
    .projects-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 14px; margin-top: 4px; }
    .project-card {
      background: var(--card); border: 1px solid var(--border);
      border-radius: 14px; overflow: hidden; cursor: pointer;
      transition: border-color 0.2s, transform 0.2s, box-shadow 0.2s;
      display: flex; flex-direction: column; position: relative;
    }
    .project-card:hover { border-color: var(--border2); transform: translateY(-2px); box-shadow: 0 8px 22px rgba(0,0,0,0.35); }
    .project-card-featured { border-color: var(--border2); }
    .pcard-preview { width: 100%; aspect-ratio: 16/9; background: #000; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; flex-shrink: 0; }
    .pcard-body { padding: 12px 14px 14px; display: flex; flex-direction: column; gap: 4px; }
    .pcard-title { font-size: 13.5px; font-weight: 700; color: var(--text); letter-spacing: -0.01em; }
    .pcard-sub   { font-family: var(--mono); font-size: 9.5px; color: var(--muted); letter-spacing: 0.06em; }
    .pcard-footer { margin-top: 8px; display: flex; gap: 6px; flex-wrap: wrap; }
    .lang-tag { font-family: var(--mono); font-size: 10.5px; padding: 3px 9px; border-radius: 4px; background: var(--amber-dim); border: 1px solid var(--amber-dim2); color: var(--amber); white-space: nowrap; }
    .lang-tag--blue   { background: rgba(59,130,246,0.12); border-color: rgba(59,130,246,0.3); color: #60a5fa; }
    .lang-tag--orange { background: rgba(249,115,22,0.12); border-color: rgba(249,115,22,0.3); color: #fb923c; }
    .lang-tag--violet { background: rgba(139,92,246,0.12); border-color: rgba(139,92,246,0.3); color: #a78bfa; }
    .lang-tag--green  { background: rgba(34,197,94,0.12); border-color: rgba(34,197,94,0.3); color: #4ade80; }
    .wip-badge { display: inline-block; font-family: var(--mono); font-size: 9px; color: #ff6b6b; background: rgba(255,107,107,0.1); border: 1px solid rgba(255,107,107,0.25); padding: 3px 8px; border-radius: 3px; font-weight: 600; letter-spacing: 0.05em; }
    .done-badge { display: inline-block; font-family: var(--mono); font-size: 9px; color: #b9e3c6; background: rgba(185,227,198,0.1); border: 1px solid rgba(185,227,198,0.25); padding: 3px 8px; border-radius: 3px; font-weight: 600; letter-spacing: 0.05em; }

    /* ─── ASSO ─── */
    .asso-layout { display: grid; grid-template-columns: minmax(0, 1.35fr) minmax(280px, 0.75fr); gap: 14px; align-items: start; }
    .asso-cinema-card, .asso-note-card { background: var(--card); border: 1px solid var(--border); border-radius: 14px; }
    .asso-cinema-card { overflow: hidden; }
    .asso-cinema-screen { position: relative; min-height: 380px; overflow: hidden; background: #000; }
    .asso-cinema-copy { position: relative; z-index: 3; min-height: 380px; display: flex; flex-direction: column; justify-content: flex-end; gap: 12px; padding: 32px; }
    .asso-kicker { font-family: var(--mono); font-size: 10px; color: var(--amber); letter-spacing: 0.18em; text-transform: uppercase; }
    .asso-cinema-copy h3 { max-width: 12ch; font-size: clamp(2rem, 4vw, 3.25rem); line-height: 0.98; letter-spacing: -0.05em; }
    .asso-cinema-copy p { max-width: 38ch; font-family: var(--mono); font-size: 12px; line-height: 1.8; color: rgba(255,255,255,0.72); }
    .asso-cinema-meta { display: flex; flex-wrap: wrap; gap: 8px; padding: 18px 20px 20px; border-top: 1px solid var(--border); background: rgba(255,255,255,0.02); }
    .asso-cinema-meta span { font-family: var(--mono); font-size: 10px; color: var(--amber); letter-spacing: 0.08em; text-transform: uppercase; padding: 5px 10px; border-radius: 999px; border: 1px solid var(--amber-dim2); background: var(--amber-dim); }
    .asso-note-card { padding: 22px; }
    .asso-note-list { list-style: none; display: grid; gap: 10px; }
    .asso-note-list li { position: relative; padding-left: 18px; font-family: var(--mono); font-size: 11.5px; line-height: 1.7; color: var(--muted); }
    .asso-note-list li::before { content: ''; position: absolute; left: 0; top: 8px; width: 8px; height: 1px; background: var(--amber); }
    .asso-text-card { background: var(--card); border: 1px solid var(--border); border-radius: var(--radius); padding: 20px 22px; }
    .asso-text-body { font-family: var(--mono); font-size: 12.5px; line-height: 1.75; color: var(--muted); }

    /* ─── SKILLS ─── */
    .section-intro { max-width: 680px; font-size: 13px; line-height: 1.75; color: var(--muted); margin: -10px 0 22px; }
    .skills-layout { display: grid; grid-template-columns: minmax(0, 1.25fr) minmax(0, 1fr); gap: 14px; align-items: start; }
    .skills-card { background: var(--card); border: 1px solid var(--border); border-radius: var(--radius); padding: 24px; }
    .skills-sidecard { background: linear-gradient(180deg, rgba(255,255,255,0.03), rgba(255,255,255,0.01)); border: 1px solid var(--border); border-radius: var(--radius); padding: 22px; }
    .skills-side-title { font-size: 18px; font-weight: 700; color: var(--text); margin-bottom: 10px; }
    .roles-list { display: grid; gap: 10px; margin-top: 14px; }
    .role-item { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 8px; border: 1px solid var(--border); background: rgba(255,255,255,0.03); font-family: var(--mono); font-size: 11.5px; color: var(--text); }
    .role-emoji { width: 22px; text-align: center; flex-shrink: 0; font-size: 14px; }
    .skills-section-label { font-family: var(--mono); font-size: 10px; color: var(--amber); letter-spacing: 0.12em; text-transform: lowercase; margin-bottom: 12px; padding-bottom: 8px; border-bottom: 1px solid var(--border); }
    .skills-list { display: flex; flex-direction: column; gap: 10px; }
    .skill-row { display: flex; flex-direction: column; gap: 5px; }
    .skill-row-top { display: flex; align-items: center; gap: 8px; }
    .skill-icon { color: var(--muted); display: flex; align-items: center; flex-shrink: 0; }
    .skill-name { font-family: var(--mono); font-size: 11.5px; color: var(--text); flex: 1; }
    .skill-pct  { font-family: var(--mono); font-size: 10px; color: var(--amber); flex-shrink: 0; min-width: 32px; text-align: right; }
    .skill-bar-bg   { height: 4px; background: var(--amber-dim); border-radius: 999px; overflow: hidden; }
    .skill-bar-fill { height: 100%; background: var(--amber); border-radius: 999px; }

    /* ─── MODAL ─── */
    .modal { position: fixed; inset: 0; background: rgba(0,0,0,0.8); backdrop-filter: blur(10px); display: flex; align-items: center; justify-content: center; z-index: 9999; opacity: 0; pointer-events: none; transition: opacity 0.2s; }
    .modal.open { opacity: 1; pointer-events: auto; }
    .pmodal-shell { display: grid; grid-template-columns: 1fr 1fr; width: 100%; max-width: 900px; max-height: 90vh; background: var(--bg2); border: 1px solid var(--border2); border-radius: 14px; overflow: hidden; transform: scale(0.95) translateY(12px); transition: transform 0.35s cubic-bezier(0.22,1,0.36,1); }
    .modal.open .pmodal-shell { transform: scale(1) translateY(0); }
    .pmodal-gallery-col { position: relative; display: grid; grid-template-rows: minmax(0, 1fr) auto; min-height: 0; background: #000; border-right: 1px solid var(--border); overflow: hidden; }
    .pmodal-gallery-main { position: relative; overflow: hidden; min-height: 0; display: flex; align-items: center; justify-content: center; padding: 14px; background: #000; }
    .pmodal-gallery-thumbs { display: grid; grid-auto-flow: column; grid-auto-columns: minmax(86px, 1fr); gap: 6px; padding: 8px; background: var(--bg2); border-top: 1px solid var(--border); overflow-x: auto; }
    .pmodal-thumb { width: 100%; aspect-ratio: 16/9; border-radius: 5px; border: 1.5px solid transparent; cursor: pointer; opacity: 0.45; background: #111; display: flex; align-items: center; justify-content: center; }
    .pmodal-thumb.active { opacity: 1; border-color: var(--amber); }
    .pmodal-info-col { display: flex; flex-direction: column; padding: 22px 26px; overflow-y: auto; max-height: 90vh; }
    .pmodal-top-bar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
    .pmodal-eyebrow { font-family: var(--mono); font-size: 10px; color: var(--amber); letter-spacing: 0.1em; background: var(--amber-dim); border: 1px solid var(--amber-dim2); padding: 3px 9px; border-radius: 4px; }
    .pmodal-close-btn { background: transparent; border: 1px solid var(--border); color: var(--muted); border-radius: 7px; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.18s; }
    .pmodal-close-btn:hover { border-color: var(--amber); color: var(--amber); }
    .pmodal-close-btn svg { width: 14px; height: 14px; stroke-width: 2; }
    .pmodal-title    { font-family: var(--sans); font-size: 22px; font-weight: 700; color: var(--text); letter-spacing: -0.02em; line-height: 1.2; margin-bottom: 7px; }
    .pmodal-subtitle { font-family: var(--mono); font-size: 12px; color: var(--muted); line-height: 1.6; margin: 0; }
    .pmodal-divider  { height: 1px; background: var(--border); margin: 14px 0; }
    .pmodal-desc     { font-family: var(--mono); font-size: 12.5px; color: var(--muted); line-height: 1.7; }
    .pmodal-roadmap-label { font-family: var(--mono); font-size: 10px; color: var(--amber); letter-spacing: 0.1em; margin-bottom: 10px; }
    .pmodal-details-card { display: flex; flex-direction: column; gap: 10px; }
    .pmodal-detail-row { display: flex; align-items: flex-start; gap: 10px; padding: 10px 12px; border-radius: 8px; background: var(--card); border: 1px solid var(--border); }
    .pmodal-detail-icon { font-size: 14px; flex-shrink: 0; margin-top: 1px; }
    .pmodal-detail-label { font-family: var(--mono); font-size: 9px; color: var(--amber); letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 3px; }
    .pmodal-detail-val { font-family: var(--mono); font-size: 11.5px; color: var(--text); line-height: 1.5; }
    .pmodal-status-done { display: inline-block; font-family: var(--mono); font-size: 9px; font-weight: 700; letter-spacing: 0.06em; padding: 2px 8px; border-radius: 3px; background: rgba(200,200,200,0.1); border: 1px solid rgba(200,200,200,0.25); color: #c8c8c8; }
    .pmodal-status-wip  { display: inline-block; font-family: var(--mono); font-size: 9px; font-weight: 700; letter-spacing: 0.06em; padding: 2px 8px; border-radius: 3px; background: rgba(255,107,107,0.1); border: 1px solid rgba(255,107,107,0.25); color: #ff6b6b; }
    .pmodal-roadmap-panel { animation: fadeIn 0.22s ease; }

    /* gallery redacted placeholder */
    .gallery-redacted {
      width: 100%; height: 300px;
      background: #000;
      display: flex; align-items: center; justify-content: center;
    }
    .gallery-redacted-text {
      font-family: var(--mono); font-size: 9px; letter-spacing: 0.15em;
      color: rgba(255,255,255,0.12); text-transform: uppercase;
    }

    /* mobile header */
    .mobile-header { display: none; align-items: center; justify-content: space-between; padding: 12px 16px; background: rgba(8,8,8,0.9); backdrop-filter: blur(16px); border-bottom: 1px solid var(--border); position: sticky; top: 0; z-index: 50; flex-shrink: 0; }
    .mobile-header-left { display: flex; align-items: center; gap: 10px; }
    .mobile-avatar-small { width: 30px; height: 30px; border-radius: 6px; background: #000; border: 1.5px solid var(--border2); display: flex; align-items: center; justify-content: center; font-family: var(--mono); font-size: 10px; color: var(--muted); flex-shrink: 0; overflow: hidden; }
    .mobile-header-logo { font-family: var(--mono); font-size: 12.5px; font-weight: 500; color: var(--amber); }
    .mobile-header-sub  { font-family: var(--mono); font-size: 9px; color: var(--muted); font-style: italic; margin-top: 2px; }
    .mobile-settings-btn { background: none; border: 1px solid var(--border); color: var(--muted); border-radius: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; cursor: pointer; }
    .mobile-settings-btn svg { width: 14px; height: 14px; }

    .mobile-nav { display: none; position: fixed; bottom: 0; left: 0; right: 0; z-index: 200; padding: 10px 12px; padding-bottom: calc(10px + env(safe-area-inset-bottom)); background: transparent; pointer-events: none; }
    .mobile-nav-inner { display: flex; align-items: center; justify-content: center; gap: 4px; width: min(100%, 720px); background: rgba(12,12,12,0.9); backdrop-filter: blur(20px); border: 1px solid var(--border2); border-radius: 999px; padding: 6px; pointer-events: auto; }
    .mobile-nav-btn { display: flex; flex: 1 1 0; flex-direction: column; align-items: center; justify-content: center; gap: 3px; min-width: 0; background: none; border: none; color: var(--muted); cursor: pointer; border-radius: 999px; padding: 8px 12px; transition: all 0.2s ease; font-family: var(--mono); font-size: 9px; white-space: nowrap; }
    .mobile-nav-btn svg { width: 16px; height: 16px; stroke-width: 1.75; }
    .mobile-nav-btn.active { background: var(--amber-dim); color: var(--amber); }

    @media (max-width: 768px) {
      .shell { grid-template-columns: 1fr; height: 100dvh; }
      .sidebar { display: none; }
      .mobile-header { display: flex; }
      .mobile-nav { display: flex; }
      .main { height: auto; overflow-y: auto; padding-bottom: 80px; }
      .tab { padding: 22px 16px 24px; min-height: auto; }
      .home-title { font-size: clamp(2.8rem, 13vw, 4.5rem); }
      .about-grid { grid-template-columns: 1fr; }
      .asso-layout { grid-template-columns: 1fr; }
      .skills-layout { grid-template-columns: 1fr; }
      .profile-banner-wrap { height: 140px; }
      .avatar-wrap { width: 64px; height: 64px; margin-top: -32px; }
      .avatar-redacted { width: 64px; height: 64px; border-width: 3px; border-radius: 9px; }
      .pmodal-shell { grid-template-columns: 1fr; width: 100%; max-width: 100%; max-height: 92dvh; border-radius: 18px 18px 0 0; overflow-y: auto; }
      #projectModal { align-items: flex-end; padding: 0; }
      .pmodal-gallery-col { border-right: none; border-bottom: 1px solid var(--border); }
      .pmodal-gallery-main { height: 240px; }
      .pmodal-info-col { padding: 18px 18px 32px; max-height: none; }
      .home-counter { gap: 20px; margin-top: 36px; }
    }
    @media (min-width: 1280px) {
      .tab { padding: 60px 72px 80px; }
    }
  </style>
</head>
<body>

<!-- MOBILE HEADER -->
<header class="mobile-header">
  <div class="mobile-header-left">
    <div class="mobile-avatar-small" style="background:#fff;"></div>
    <div>
      <div class="mobile-header-logo">portfolio [REDACTED]</div>
      <div class="mobile-header-sub">// cinéaste</div>
    </div>
  </div>
</header>

<!-- MOBILE NAV -->
<nav class="mobile-nav">
  <div class="mobile-nav-inner">
    <button class="mobile-nav-btn active" id="mnav-home" onclick="switchTab('home')">
      <i data-lucide="clapperboard"></i><span>accueil</span>
    </button>
    <button class="mobile-nav-btn" id="mnav-about" onclick="switchTab('about')">
      <i data-lucide="user-circle"></i><span>profil</span>
    </button>
    <button class="mobile-nav-btn" id="mnav-projects" onclick="switchTab('projects')">
      <i data-lucide="film"></i><span>projets</span>
    </button>
    <button class="mobile-nav-btn" id="mnav-asso" onclick="switchTab('asso')">
      <i data-lucide="users"></i><span>mon asso</span>
    </button>
    <button class="mobile-nav-btn" id="mnav-skills" onclick="switchTab('skills')">
      <i data-lucide="scan-face"></i><span>competences</span>
    </button>
  </div>
</nav>

<div class="shell">
  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="logo">
      <div class="logo-name">portfolio [REDACTED]</div>
      <div class="logo-sub">// cinéaste</div>
    </div>
    <nav class="nav-items">
      <button onclick="switchTab('home')"     class="nav-link active" id="nav-home"><i data-lucide="clapperboard"></i> accueil</button>
      <button onclick="switchTab('about')"    class="nav-link"        id="nav-about"><i data-lucide="user-circle"></i> profil</button>
      <button onclick="switchTab('projects')" class="nav-link"        id="nav-projects"><i data-lucide="film"></i> projets</button>
      <button onclick="switchTab('asso')"     class="nav-link"        id="nav-asso"><i data-lucide="users"></i> mon asso</button>
      <button onclick="switchTab('skills')"   class="nav-link"        id="nav-skills"><i data-lucide="scan-face"></i> compétences</button>
    </nav>
  </aside>

  <main class="main">

    <!-- HOME -->
    <div id="home" class="tab active">
      <div class="home-eyebrow">bienvenue</div>
      <h1 class="home-title">Salut,<br>je suis <span class="name-bar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>.</h1>
      <p class="home-desc">Jeune réalisateur, je souhaite faire vibrer le cœur des gens et leur donner de l'espoir.</p>
      <div class="home-actions">
        <a href="#" onclick="switchTab('projects'); return false;" class="btn-amber"><i data-lucide="arrow-right"></i> voir mes projets</a>
        <a href="#" onclick="switchTab('about'); return false;" class="btn-ghost">qui suis-je ?</a>
      </div>
      <div class="home-counter">
        <div class="counter-item">
          <div class="counter-num">[REDACTED]</div>
          <div class="counter-label">// projets</div>
        </div>
        <div class="counter-item">
          <div class="counter-num">[REDACTED]</div>
          <div class="counter-label">// premier film</div>
        </div>
        <div class="counter-item">
          <div class="counter-num">∞</div>
          <div class="counter-label">// idées</div>
        </div>
      </div>
    </div>

    <!-- ABOUT -->
    <div id="about" class="tab">
      <div class="section-tag">// profil</div>
      <h2 class="section-title">Qui suis-je ?</h2>
      <div class="about-grid">
        <div class="profile-card">
          <!-- BANNER REDACTED -->
          <div class="profile-banner-wrap">
            <div style="width:100%;height:100%;background:#000;"></div>
          </div>
          <div class="profile-bottom">
            <div class="avatar-wrap">
              <!-- AVATAR REDACTED -->
              <div class="avatar-redacted"></div>
            </div>
            <div class="profile-meta">
              <div class="profile-name-row">
                <!-- NAME REDACTED -->
                <span class="text-redacted" style="width:110px;height:1.1em;">&nbsp;</span>
              </div>
              <div class="profile-badges">
                <span class="badge">🍿 passionné de cinéma</span>
                <span class="badge">🎥 réalisateur</span>
                <span class="badge">✒️ scénariste</span>
              </div>
            </div>
          </div>
        </div>

        <div class="about-text-card">
          <div class="card-label">about.md</div>
          <p style="font-family:var(--mono);font-size:12.5px;line-height:1.75;color:var(--muted);">
            J'aime <span style="color:var(--amber);font-weight:700;font-style:italic;">le cinéma</span>
          </p>
          <p style="font-family:var(--mono);font-size:12.5px;line-height:1.75;color:var(--muted);margin-top:10px;">
            J'm'appelle <span class="text-redacted" style="width:80px;">&nbsp;</span> et j'aime écrire et écouter des histoires depuis mon plus jeune âge. Mon rêve, c'est de devenir réalisateur, et j'ai déjà pu réaliser [REDACTED] projets ces derniers temps. Voici un petit aperçu.
          </p>
          <br>
          <p style="font-family:var(--mono);font-size:12.5px;line-height:1.75;color:var(--muted);">
            J'aime l'art en général mais surtout le travail en équipe et je souhaite véhiculer des messages profonds et remplis d'espoir au travers de mes projets&nbsp;!
          </p>
        </div>

        <div class="social-card">
          <div class="card-label">find me</div>
          <div class="social-list">
            <!-- INSTAGRAM REDACTED -->
            <div class="social-item">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24" style="flex-shrink:0;stroke:none;"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
              <div>
                <div class="social-item-name">Instagram</div>
                <div class="social-item-handle"><span class="text-redacted" style="width:90px;">&nbsp;</span></div>
              </div>
              <span class="social-arrow"><i data-lucide="arrow-up-right"></i></span>
            </div>
            <!-- EMAIL REDACTED -->
            <div class="social-item">
              <i data-lucide="mail"></i>
              <div>
                <div class="social-item-name">Email</div>
                <div class="social-item-handle"><span class="text-redacted" style="width:140px;">&nbsp;</span></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- PROJECTS -->
    <div id="projects" class="tab">
      <div class="section-tag">// projets</div>
      <h2 class="section-title">Ce que j'ai construit</h2>
      <div class="projects-grid">

        <!-- UMAMI -->
        <div class="project-card project-card-featured" onclick="openProjectModal('[REDACTED]')">
          <div class="pcard-preview" style="background:#fff;"></div>
          <div class="pcard-body">
            <div class="pcard-title">[REDACTED]</div>
            <div class="pcard-sub">// drame musical · 20 min</div>
            <div class="pcard-footer">
              <span class="wip-badge">TRAVAUX EN COURS</span>
              <span class="lang-tag lang-tag--orange">COURT MÉTRAGE</span>
              <span class="lang-tag lang-tag--blue">20 MIN</span>
              <span class="lang-tag lang-tag--violet">MUSIQUE</span>
            </div>
          </div>
        </div>

        <!-- VERSATILE -->
        <div class="project-card" onclick="openProjectModal('[REDACTED]')">
          <div class="pcard-preview" style="background:#fff;"></div>
          <div class="pcard-body">
            <div class="pcard-title">[REDACTED]</div>
            <div class="pcard-sub">// série musicale · saison 1</div>
            <div class="pcard-footer">
              <span class="done-badge">TERMINÉ</span>
              <span class="lang-tag lang-tag--orange">SÉRIE MUSICALE</span>
              <span class="lang-tag lang-tag--violet">MUSIQUE</span>
            </div>
          </div>
        </div>

        <!-- لا تنسى -->
        <div class="project-card" onclick="openProjectModal('[REDACTED]')">
          <div class="pcard-preview" style="background:#fff;"></div>
          <div class="pcard-body">
            <div class="pcard-title">[REDACTED]</div>
            <div class="pcard-sub">// drame · mémoire & origines</div>
            <div class="pcard-footer">
              <span class="wip-badge">TRAVAUX EN COURS</span>
              <span class="lang-tag lang-tag--violet">ORIGINES</span>
              <span class="lang-tag lang-tag--blue">15 MIN</span>
            </div>
          </div>
        </div>

        <!-- LOIN DES FRONTIÈRES -->
        <div class="project-card" onclick="openProjectModal('[REDACTED]')">
          <div class="pcard-preview" style="background:#fff;"></div>
          <div class="pcard-body">
            <div class="pcard-title">[REDACTED]</div>
            <div class="pcard-sub">// drame social · 10 min</div>
            <div class="pcard-footer">
              <span class="wip-badge">TRAVAUX EN COURS</span>
              <span class="lang-tag lang-tag--orange">COURT MÉTRAGE</span>
              <span class="lang-tag lang-tag--blue">10 MIN</span>
            </div>
          </div>
        </div>

      </div>
    </div>

    <!-- ASSO -->
    <div id="asso" class="tab">
      <div class="section-tag">// mon asso</div>
      <h2 class="section-title">Mon Association : [REDACTED]</h2>
      <p class="section-intro" style="font-size:17px;font-weight:600;color:var(--text);margin-bottom:20px;"><span class="text-redacted" style="width:160px;">&nbsp;</span></p>
      <div class="asso-layout">
        <article class="asso-cinema-card">
          <div class="asso-cinema-screen">
            <!-- BG IMAGE REDACTED -->
            <div style="width:100%;height:100%;background:#000;position:absolute;inset:0;"></div>
            <div class="asso-cinema-copy">
              <p class="asso-kicker">un lieu créatif</p>
              <h3>[REDACTED]</h3>
              <p>Association indépendante dans le [REDACTED]</p>
            </div>
          </div>
          <div class="asso-cinema-meta">
            <span>mission</span><span>collectif</span><span>tournages</span><span>rencontres</span>
          </div>
          <div class="social-list" style="padding:14px 16px;border-top:1px solid var(--border);display:flex;flex-direction:column;gap:8px;">
            <div class="social-item">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24" style="flex-shrink:0;stroke:none;"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
              <div><div class="social-item-name">Instagram</div><div class="social-item-handle"><span class="text-redacted" style="width:100px;">&nbsp;</span></div></div>
              <span class="social-arrow"><i data-lucide="arrow-up-right"></i></span>
            </div>
            <div class="social-item">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24" style="flex-shrink:0;stroke:none;"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
              <div><div class="social-item-name">YouTube</div><div class="social-item-handle"><span class="text-redacted" style="width:100px;">&nbsp;</span></div></div>
              <span class="social-arrow"><i data-lucide="arrow-up-right"></i></span>
            </div>
          </div>
        </article>

        <article class="asso-text-card">
          <div class="card-label">about.md</div>
          <p class="asso-text-body">Cette association nous permet de développer des projets personnels afin d'apprendre les métiers de l'audiovisuel et d'enrichir nos connaissances personnelles tout en rencontrant des gens en or.<br><br>Je suis membre actif de cette association depuis bientôt [REDACTED] ans et j'ai eu la chance de développer mon propre projet individuel et de participer à un grand nombre de projets, ce qui m'a permis d'apprendre la pratique et la théorie du monde de l'audiovisuel.</p>
        </article>

        <article class="asso-note-card" style="background:linear-gradient(180deg,rgba(255,255,255,0.04),rgba(255,255,255,0.015));">
          <div class="card-label">roadmap.log</div>
          <ul class="asso-note-list">
            <li>membres dans l'association : [REDACTED] membres</li>
            <li>association active depuis [REDACTED]</li>
            <li>association à but non lucratif</li>
            <li>localisation : [REDACTED]</li>
          </ul>
        </article>
      </div>
    </div>

    <!-- SKILLS -->
    <div id="skills" class="tab">
      <div class="section-tag">// competences</div>
      <h2 class="section-title">Mes compétences</h2>
      <p class="section-intro">Un onglet dédié pour montrer ce que je maîtrise déjà et ce que je continue à développer au fil de mes projets.</p>
      <div class="skills-layout">
        <div class="skills-card">
          <div class="card-label">competence.js</div>
          <div class="skills-section-label">compétences cinématographiques</div>
          <div class="skills-list" id="skillsList"></div>
        </div>
        <div class="skills-sidecard">
          <div class="card-label">roles.log</div>
          <div class="skills-side-title">Les rôles que j'ai pu remplir</div>
          <div class="roles-list">
            <div class="role-item"><span class="role-emoji">🎬</span><span>réalisateur</span></div>
            <div class="role-item"><span class="role-emoji">🧭</span><span>assistant réalisateur</span></div>
            <div class="role-item"><span class="role-emoji">✍️</span><span>scénariste</span></div>
            <div class="role-item"><span class="role-emoji">🎙️</span><span>assistant ingé-son</span></div>
            <div class="role-item"><span class="role-emoji">💡</span><span>assistant électro</span></div>
            <div class="role-item"><span class="role-emoji">🎨</span><span>assistant décorateur</span></div>
            <div class="role-item"><span class="role-emoji">👥</span><span>directeur de la figuration</span></div>
            <div class="role-item"><span class="role-emoji">📷</span><span>assistant cam</span></div>
            <div class="role-item"><span class="role-emoji">📸</span><span>photographe d'événement</span></div>
          </div>
        </div>
      </div>
    </div>

  </main>
</div>

<!-- PROJECT MODAL -->
<div id="projectModal" class="modal">
  <div class="pmodal-shell">
    <div class="pmodal-gallery-col">
      <div class="pmodal-gallery-main" style="background:#fff;height:300px;">
        <!-- image redacted -->
        <div style="width:100%;height:100%;background:#000;display:flex;align-items:center;justify-content:center;">
          <span style="font-family:var(--mono);font-size:9px;letter-spacing:0.15em;color:rgba(255,255,255,0.12);text-transform:uppercase;">[ IMAGE REDACTED ]</span>
        </div>
      </div>
      <div class="pmodal-gallery-thumbs" id="pModalThumbs"></div>
    </div>
    <div class="pmodal-info-col">
      <div class="pmodal-top-bar">
        <span class="pmodal-eyebrow" id="pModalLang">// film</span>
        <button class="pmodal-close-btn" onclick="closeProjectModal()"><i data-lucide="x"></i></button>
      </div>
      <h2 class="pmodal-title" id="pModalTitle"></h2>
      <p class="pmodal-subtitle" id="pModalIntro"></p>
      <div class="pmodal-divider"></div>
      <p class="pmodal-desc" id="pModalDescription"></p>
      <div class="pmodal-divider"></div>
      <div class="pmodal-roadmap-label">// details</div>
      <div class="pmodal-roadmap-content" id="pModalRoadmapContent"></div>
    </div>
  </div>
</div>

<script>
function switchTab(id) {
  document.querySelectorAll(".tab").forEach(t => t.classList.remove("active"));
  document.querySelectorAll(".nav-link").forEach(b => b.classList.remove("active"));
  document.querySelectorAll(".mobile-nav-btn").forEach(b => b.classList.remove("active"));
  const panel = document.getElementById(id);
  if (panel) panel.classList.add("active");
  const btn  = document.getElementById("nav-" + id);
  const mBtn = document.getElementById("mnav-" + id);
  if (btn)  btn.classList.add("active");
  if (mBtn) mBtn.classList.add("active");
  const main = document.querySelector(".main");
  if (main) main.scrollTop = 0;
  lucide.createIcons();
}

// Skills data
const skills = [
  {name:"écriture",pct:80},{name:"ingé son",pct:30},{name:"montage",pct:30},
  {name:"gestion décors / accessoires",pct:70},{name:"casting",pct:70},
  {name:"acteur",pct:70},{name:"costumes",pct:70},{name:"réalisation",pct:70},
  {name:"photographie",pct:50}
];
const sl = document.getElementById('skillsList');
skills.forEach(s => {
  sl.innerHTML += `<div class="skill-row">
    <div class="skill-row-top">
      <span class="skill-icon"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg></span>
      <span class="skill-name">${s.name}</span>
      <span class="skill-pct">${s.pct}%</span>
    </div>
    <div class="skill-bar-bg"><div class="skill-bar-fill" style="width:${s.pct}%"></div></div>
  </div>`;
});

// Project data
const projectData = {
  "[REDACTED]": {
    lang:"// drame musical · 20 min",
    intro:"Mon tout premier court-métrage, et mon premier vrai pas dans la réalisation.",
    description:"Marqué par la trahison de son ancien ami, [REDACTED], un jeune beatmaker se donne pour mission de révolutionner la musique en inventant un nouveau style : l'Umami. Pour faire exister sa vision, il est prêt à tout, quitte à se heurter aux critiques des plus grands de son milieu.\n\nC'est un Projet très personnel, porté par un message profond et essentiel à mes yeux.",
    details:{sortie:"[REDACTED]",tournage:"[REDACTED]",duree:"[REDACTED]",acteurs:"[REDACTED]",role:"réalisateur",lieu:"[REDACTED]",status:"wip"}
  },
  "[REDACTED]":{
    lang:"// série musicale · saison 1",
    intro:"Une première immersion concrète dans l'audiovisuel à travers un grand Projet musical.",
    description:"Dans cette première saison de Versatile Musique, [REDACTED] artistes français de la région parisienne se réunissent pour faire vibrer les cœurs et lever les bras du public.\n\nCe Projet important pour mon association m'a permis de faire mes premiers pas dans l'audiovisuel et de rencontrer des personnes incroyables.",
    details:{sortie:"[REDACTED]",tournage:"[REDACTED]",duree:"[REDACTED]",acteurs:"[REDACTED]",role:"photographe d'événements, assistant cam",lieu:"[REDACTED]",status:"done"}
  },
  "[REDACTED]":{
    lang:"// drame · mémoire & origines · 15 min",
    intro:"Un récit sensible sur la mémoire, les origines et ce qu'on choisit de transmettre.",
    description:"Parce qu'il est essentiel de savoir d'où l'on vient pour comprendre où l'on va, une jeune femme décide d'aider de tout son cœur son voisin, déterminé à rejeter ses origines, son histoire et son passé.\n\nCette histoire profonde et touchante m'a offert un tournage riche en apprentissages et a nourri ma vision du cinéma et de la réalisation.",
    details:{sortie:"[REDACTED]",tournage:"[REDACTED]",duree:"[REDACTED]",acteurs:"[REDACTED]",role:"script, assistant électro",lieu:"[REDACTED]",status:"wip"}
  },
  "[REDACTED]":{
    lang:"// drame social · 10 min",
    intro:"Un court-métrage porté par un message de paix et d'espoir pour la jeunesse.",
    description:"[REDACTED] ayant fui son pays à cause de la guerre, rejoint un collège en France. Ne maîtrisant pas encore bien la langue, il devient la cible des autres élèves. À travers lui, ce court-métrage défend un message de paix, de solidarité et d'espoir pour les jeunes du monde entier.\n\nJ'ai eu la chance d'y participer comme assistant réalisateur, une expérience qui m'a permis d'affiner ma compréhension du rôle de réalisateur à travers le regard d'un autre cinéaste.",
    details:{sortie:"[REDACTED]",tournage:"[REDACTED]",duree:"[REDACTED]",acteurs:"[REDACTED]",role:"Technicien responsable du clap, assistant électro, assistant cam, assistant réalisateur, directeur de la figuration",lieu:"[REDACTED]",status:"wip"}
  }
};

function openProjectModal(name) {
  const data = projectData[name] || {};
  document.getElementById("pModalLang").textContent  = data.lang || "// film";
  document.getElementById("pModalTitle").textContent = name;
  document.getElementById("pModalIntro").textContent = data.intro || "";
  document.getElementById("pModalDescription").innerHTML = (data.description || "").replace(/\n\n/g,"<br><br>").replace(/\n/g,"<br>");

  // Thumbnails — show redacted placeholders equal to image count
  const thumbCounts = {"[REDACTED]":9};
  const count = thumbCounts[name] || 1;
  const thumbsWrap = document.getElementById("pModalThumbs");
  thumbsWrap.innerHTML = "";
  for(let i=0;i<count;i++){
    const t = document.createElement("div");
    t.className = "pmodal-thumb" + (i===0?" active":"");
    t.style.background="#000";
    t.style.display="flex";t.style.alignItems="center";t.style.justifyContent="center";
    thumbsWrap.appendChild(t);
  }

  const details = data.details;
  const rc = document.getElementById("pModalRoadmapContent");
  rc.innerHTML = "";
  if (details) {
    const sc = details.status==="done"?"pmodal-status-done":"pmodal-status-wip";
    const st = details.status==="done"?"terminé":"en cours";
    rc.innerHTML = `<div class="pmodal-details-card">
      <div class="pmodal-detail-row"><span class="pmodal-detail-icon">📅</span><div><div class="pmodal-detail-label">date de sortie</div><div class="pmodal-detail-val">${details.sortie}</div></div></div>
      <div class="pmodal-detail-row"><span class="pmodal-detail-icon">🎬</span><div><div class="pmodal-detail-label">jours de tournage</div><div class="pmodal-detail-val">${details.tournage}</div></div></div>
      <div class="pmodal-detail-row"><span class="pmodal-detail-icon">⏱️</span><div><div class="pmodal-detail-label">depuis combien de temps</div><div class="pmodal-detail-val">${details.duree}</div></div></div>
      <div class="pmodal-detail-row"><span class="pmodal-detail-icon">👥</span><div><div class="pmodal-detail-label">nombre d'acteurs/artistes</div><div class="pmodal-detail-val">${details.acteurs}</div></div></div>
      <div class="pmodal-detail-row"><span class="pmodal-detail-icon">🎭</span><div><div class="pmodal-detail-label">mon rôle</div><div class="pmodal-detail-val">${details.role}</div></div></div>
      <div class="pmodal-detail-row"><span class="pmodal-detail-icon">📍</span><div><div class="pmodal-detail-label">lieu de sortie finale</div><div class="pmodal-detail-val">${details.lieu}</div></div></div>
      <div style="margin-top:10px;"><span class="${sc}">${st}</span></div>
    </div>`;
  }

  document.getElementById("projectModal").classList.add("open");
  lucide.createIcons();
}

function closeProjectModal() {
  document.getElementById("projectModal").classList.remove("open");
}
document.getElementById("projectModal").addEventListener("click", e => {
  if (e.target.id === "projectModal") closeProjectModal();
});

window.addEventListener("load", () => { lucide.createIcons(); });
</script>
</body>
</html>