<?php
declare(strict_types=1);

require __DIR__ . '/src/bootstrap.php';
require __DIR__ . '/src/contact-form.php';

/** Pre-filled WhatsApp message used by every chat button on this page. */
$waMessage = 'Hello CARE Digital Solutions, I would like to inquire about your services.';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_form'])) {
    verify_csrf();
    $result = care_submit_inquiry($_POST);
    flash($result['message'], $result['ok'] ? 'success' : 'error');
    redirect('contact.php#inquiry-form');
}

$feedback = flash();
?>
<!DOCTYPE html>
<html lang="en" data-mode="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#071426">
<meta name="description" content="Contact CARE Digital Solutions — Reach out for web design, software development, branding, and digital solutions. Let's talk about your next big idea.">
<meta name="keywords" content="contact, CARE Digital Solutions, Tanzania, web design, software development, branding, digital communication">
<meta name="author" content="CARE Digital Solutions">
<meta name="robots" content="index, follow">
<meta property="og:title" content="Contact Us — CARE Digital Solutions">
<meta property="og:description" content="Have a project in mind? Get in touch with CARE Digital Solutions for professional digital services.">
<meta property="og:type" content="website">
<meta property="og:url" content="https://caredigitalsolutions.co.tz/contact">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Contact Us — CARE Digital Solutions">
<meta name="twitter:description" content="Professional digital solutions and creative services. Let's discuss your project today.">
<link rel="canonical" href="https://caredigitalsolutions.co.tz/contact">
<title>Contact Us — CARE Digital Solutions</title>
<style>
/* ==========================================================
   CARE Digital Solutions — Premium Contact Page
   Vanilla HTML + CSS + JS | No framework or build step needed
   ========================================================== */
:root {
  color-scheme: light;
  --bg: #F4F7FB;
  --bg-elevated: #ffffff;
  --surface: rgba(255,255,255,.76);
  --surface-solid: #fff;
  --surface-soft: #eef2f8;
  --text: #071426;
  --muted: #64748B;
  --line: rgba(7,20,38,.08);
  --accent: #2563EB;
  --accent-2: #22D3EE;
  --accent-soft: rgba(37,99,235,.08);
  --hero-bg: #071426;
  --hero-bg-deep: #0B1F3A;
  --whatsapp: #25D366;
  --shadow: 0 18px 50px rgba(7,20,38,.12);
  --shadow-sm: 0 8px 24px rgba(7,20,38,.08);
  --header-height: 80px;
  --radius-xl: 24px;
  --radius-lg: 18px;
  --radius-md: 14px;
  --radius-sm: 10px;
  --transition: 280ms cubic-bezier(.2,.8,.2,1);
  --font: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
}
html[data-mode="dark"] {
  color-scheme: dark;
  --bg:#071426;
  --bg-elevated:#0B1F3A;
  --surface:rgba(11,31,58,.78);
  --surface-solid:#0B1F3A;
  --surface-soft:#0d2847;
  --text:#f8fafc;
  --muted:#94a3b8;
  --line:rgba(255,255,255,.08);
  --accent-soft:rgba(37,99,235,.15);
  --shadow:0 18px 50px rgba(0,0,0,.3);
  --shadow-sm:0 8px 24px rgba(0,0,0,.2);
}
* { box-sizing:border-box; }
html { scroll-behavior:smooth; }
body {
  margin:0; min-height:100vh; font-family:var(--font); color:var(--text);
  background:var(--bg);
  line-height:1.6; transition:background-color var(--transition),color var(--transition);
}
button, input, select, textarea { font:inherit; }
button { color:inherit; }
a { color:inherit; text-decoration:none; }
button:focus-visible, a:focus-visible, input:focus-visible { outline:3px solid var(--accent-2); outline-offset:3px; }
.icon { width:20px; height:20px; display:inline-block; flex:none; fill:none; stroke:currentColor; stroke-width:1.8; stroke-linecap:round; stroke-linejoin:round; }
.skip-link { position:fixed; left:12px; top:-60px; z-index:999; padding:10px 14px; border-radius:10px; background:var(--surface-solid); }
.skip-link:focus { top:12px; }

/* Premium Header */
.topbar {
  height:var(--header-height);
  position:fixed;
  top:0;
  left:0;
  right:0;
  z-index:40;
  display:flex;
  align-items:center;
  gap:20px;
  padding:0 34px;
  background:transparent;
  backdrop-filter:blur(20px);
  -webkit-backdrop-filter:blur(20px);
  transition:all var(--transition);
}
.topbar.scrolled {
  background:rgba(255,255,255,.95);
  border-bottom:1px solid var(--line);
  box-shadow:var(--shadow-sm);
}
html[data-mode="dark"] .topbar.scrolled {
  background:rgba(7,20,38,.95);
}

.main-area {
  min-height:100vh;
  display:flex;
  flex-direction:column;
}
main {
  width:100%;
  max-width:100%;
  margin:0 auto;
  flex:1;
}

/* Section Common Styles */
.section { padding:100px 34px; position:relative; }
.section-header { max-width:800px; margin-bottom:60px; }
.section-eyebrow {
  display:inline-block; color:var(--accent); font-size:.75rem; font-weight:700;
  text-transform:uppercase; letter-spacing:.2em; margin-bottom:16px;
}
.section-title { font-size:clamp(2rem,4vw,2.8rem); font-weight:900; letter-spacing:-.03em; margin:0 0 20px; line-height:1.1; }
.section-description { color:var(--muted); font-size:1.1rem; max-width:600px; }

/* Contact Hero */
.contact-hero {
  position:relative;
  min-height:85vh;
  display:flex;
  align-items:center;
  background:linear-gradient(135deg,var(--hero-bg) 0%,var(--hero-bg-deep) 100%);
  overflow:hidden;
  padding:140px 34px 100px;
}
.contact-hero-bg { position:absolute; inset:0; overflow:hidden; pointer-events:none; }
.contact-hero-grid {
  position:absolute; inset:0;
  background-image:
    linear-gradient(rgba(37,99,235,.03) 1px,transparent 1px),
    linear-gradient(90deg,rgba(37,99,235,.03) 1px,transparent 1px);
  background-size:60px 60px;
  mask-image:radial-gradient(ellipse at center,black 30%,transparent 70%);
}
.contact-hero-glow {
  position:absolute; width:600px; height:600px; border-radius:50%;
  background:radial-gradient(circle,rgba(37,99,235,.15) 0%,transparent 70%);
  top:-200px; right:-200px; filter:blur(80px);
}
.contact-hero-network { position:absolute; inset:0; width:100%; height:100%; opacity:.75; }
.contact-hero-network line { stroke:rgba(34,211,238,.18); stroke-width:1; }
.contact-hero-network circle { fill:var(--accent-2); opacity:.5; animation:nodePulse 5s ease-in-out infinite; }
@keyframes nodePulse { 0%,100%{opacity:.25;} 50%{opacity:.9;} }

.contact-hero-content {
  position:relative; z-index:2; max-width:1400px; margin:0 auto;
  display:grid; grid-template-columns:1.2fr 1fr; gap:80px; align-items:center;
}
.contact-hero-text { color:#fff; }
.contact-hero-title { font-size:clamp(2.5rem,5vw,4.5rem); font-weight:900; letter-spacing:-.04em; line-height:1.05; margin-bottom:24px; }
.contact-hero-description { font-size:1.2rem; line-height:1.7; color:rgba(255,255,255,.75); margin-bottom:40px; max-width:620px; }
.contact-hero-actions { display:flex; gap:20px; flex-wrap:wrap; margin-bottom:32px; }

.btn {
  display:inline-flex; align-items:center; justify-content:center; gap:10px;
  padding:18px 36px; border-radius:var(--radius-md); font-weight:700; font-size:1rem;
  transition:all var(--transition); cursor:pointer; border:none;
}
.btn-primary { background:var(--accent); color:#fff; box-shadow:0 10px 25px rgba(37,99,235,.25); }
.btn-primary:hover { transform:translateY(-3px); box-shadow:0 15px 30px rgba(37,99,235,.35); background:#1d4ed8; }
.btn-secondary { background:rgba(255,255,255,.08); color:#fff; backdrop-filter:blur(10px); border:1px solid rgba(255,255,255,.14); }
.btn-secondary:hover { background:rgba(255,255,255,.14); transform:translateY(-3px); }
.btn-whatsapp { background:var(--whatsapp); color:#fff; box-shadow:0 10px 25px rgba(37,211,102,.25); }
.btn-whatsapp:hover { transform:translateY(-3px); box-shadow:0 15px 30px rgba(37,211,102,.35); opacity:.9; }

/* Hero Visual Illustration */
.contact-hero-visual { position:relative; display:flex; align-items:center; justify-content:center; }
.comm-illustration { position:relative; width:100%; max-width:500px; aspect-ratio:1; }
.comm-orb {
  position:absolute; inset:10%; border-radius:50%;
  background:radial-gradient(circle at 50% 50%,rgba(37,99,235,.2) 0%,transparent 70%);
  animation:float 8s ease-in-out infinite;
}
.comm-card {
  position:absolute; padding:20px; border-radius:var(--radius-lg);
  background:rgba(255,255,255,.05); border:1px solid rgba(255,255,255,.1);
  backdrop-filter:blur(12px); box-shadow:0 20px 50px rgba(0,0,0,.3);
  display:flex; align-items:center; gap:16px; color:#fff;
  animation:float 6s ease-in-out infinite;
}
.comm-card.c1 { top:10%; left:5%; animation-delay:0s; }
.comm-card.c2 { top:45%; right:0; animation-delay:1.5s; }
.comm-card.c3 { bottom:15%; left:15%; animation-delay:3s; }
.comm-card .icon-box {
  width:44px; height:44px; border-radius:12px; display:grid; place-items:center;
  background:var(--accent-soft); color:var(--accent-2);
}
.comm-card b { font-size:.9rem; display:block; }
.comm-card span { font-size:.75rem; color:rgba(255,255,255,.6); }

@keyframes float { 0%,100%{transform:translateY(0);} 50%{transform:translateY(-20px);} }

/* Contact Cards */
.info-section { background:var(--bg-elevated); }
.info-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(320px,1fr)); gap:32px; }
.info-card {
  padding:48px; border-radius:var(--radius-xl); background:var(--surface-solid);
  border:1px solid var(--line); transition:all var(--transition);
  display:flex; flex-direction:column; gap:24px;
}
.info-card:hover { transform:translateY(-8px); border-color:var(--accent); box-shadow:var(--shadow); }
.info-icon {
  width:64px; height:64px; border-radius:20px; display:grid; place-items:center;
  background:var(--accent-soft); color:var(--accent);
}
.info-card h3 { font-size:1.5rem; font-weight:800; margin:0; }
.info-card p { color:var(--muted); margin:0; font-size:.95rem; line-height:1.6; }
.info-links { display:flex; flex-direction:column; gap:16px; }
.info-link {
  display:flex; align-items:center; gap:12px; font-weight:700; font-size:1.1rem;
  color:var(--text); transition:color var(--transition);
}
.info-link:hover { color:var(--accent); }
.social-links { display:flex; gap:16px; }
.social-btn {
  width:48px; height:48px; border-radius:12px; display:grid; place-items:center;
  background:var(--surface-soft); color:var(--text); transition:all var(--transition);
}
.social-btn:hover { background:var(--accent); color:#fff; transform:translateY(-3px); }

/* Contact Form */
.form-section { background:linear-gradient(135deg,var(--bg) 0%,var(--bg-elevated) 100%); }
.form-container {
  max-width:1000px; margin:0 auto; padding:60px; border-radius:var(--radius-xl);
  background:var(--surface-solid); border:1px solid var(--line); box-shadow:var(--shadow-sm);
}
.contact-form { display:grid; grid-template-columns:1fr 1fr; gap:32px; }
.form-group { display:flex; flex-direction:column; gap:10px; }
.form-group.full { grid-column:span 2; }
.form-group label { font-size:.9rem; font-weight:700; color:var(--text); }
.form-group input, .form-group select, .form-group textarea {
  padding:16px 20px; border-radius:var(--radius-md); border:1px solid var(--line);
  background:var(--bg); color:var(--text); transition:all var(--transition);
}
.form-group input:focus, .form-group select:focus, .form-group textarea:focus {
  outline:none; border-color:var(--accent); box-shadow:0 0 0 4px var(--accent-soft);
}
.form-privacy { font-size:.85rem; color:var(--muted); margin-top:20px; }

/* Quick WhatsApp Section */
.whatsapp-section { background:var(--hero-bg-deep); color:#fff; text-align:center; }
.whatsapp-grid { display:flex; justify-content:center; gap:40px; flex-wrap:wrap; margin-top:48px; }
.whatsapp-box {
  padding:40px; border-radius:var(--radius-xl); background:rgba(255,255,255,.04);
  border:1px solid rgba(255,255,255,.1); max-width:380px; width:100%;
}
.whatsapp-box h4 { font-size:1.4rem; margin:0 0 8px; }
.whatsapp-box .num { font-size:1.1rem; color:var(--accent-2); font-weight:700; margin-bottom:24px; display:block; }

/* Services Shortcut */
.services-section { background:var(--bg-elevated); }
.services-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(280px,1fr)); gap:24px; }
.service-item {
  padding:32px; border-radius:var(--radius-lg); background:var(--bg);
  border:1px solid var(--line); transition:all var(--transition);
}
.service-item:hover { background:var(--surface-solid); border-color:var(--accent); transform:translateY(-4px); }
.service-item .icon { color:var(--accent); margin-bottom:16px; }
.service-item h4 { font-size:1.1rem; font-weight:800; margin:0 0 10px; }
.service-item p { font-size:.85rem; color:var(--muted); margin:0 0 16px; line-height:1.6; }
.service-item .link { font-size:.85rem; font-weight:700; color:var(--accent); display:flex; align-items:center; gap:6px; }

/* Final CTA */
.final-cta {
  background:linear-gradient(135deg,var(--hero-bg) 0%,var(--accent) 100%);
  padding:120px 34px; text-align:center; color:#fff; overflow:hidden;
}
.cta-title { font-size:clamp(2.2rem,5vw,3.5rem); font-weight:900; margin-bottom:24px; letter-spacing:-.04em; }
.cta-desc { font-size:1.2rem; color:rgba(255,255,255,.8); max-width:700px; margin:0 auto 40px; }

/* Footer */
footer { background:var(--hero-bg); color:#fff; padding:60px 34px; border-top:1px solid var(--line); }
.footer-content {
  max-width:1400px; margin:0 auto; display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:48px;
}
.footer-brand { font-weight:900; font-size:1.4rem; letter-spacing:-.04em; margin-bottom:16px; }
.footer-tagline { color:rgba(255,255,255,.6); font-size:.9rem; margin-bottom:24px; }
.footer-heading { font-weight:700; font-size:1rem; margin-bottom:24px; color:#fff; text-transform:uppercase; letter-spacing:.1em; }
.footer-links { display:flex; flex-direction:column; gap:12px; }
.footer-link { color:rgba(255,255,255,.65); font-size:.9rem; transition:color var(--transition); }
.footer-link:hover { color:var(--accent-2); }
.footer-copyright { margin-top:32px; padding-top:32px; border-top:1px solid rgba(255,255,255,.05); font-size:.85rem; color:rgba(255,255,255,.4); }

/* Reveal Animation */
.reveal { opacity:0; transform:translateY(20px); transition:all .6s cubic-bezier(.2,.8,.2,1); }
.reveal.visible { opacity:1; transform:none; }

/* Responsive */
@media (max-width:1024px) {
  .contact-hero-content { grid-template-columns:1fr; text-align:center; gap:60px; }
  .contact-hero-description { margin-left:auto; margin-right:auto; }
  .contact-hero-actions { justify-content:center; }
  .contact-form { grid-template-columns:1fr; }
  .form-group.full { grid-column:span 1; }
  .form-container { padding:40px 24px; }
}
@media (max-width:768px) {
  .section { padding:80px 20px; }
  .topbar { padding:0 20px; }
  .topbar nav { display:none; }
  .info-card { padding:32px 24px; }
}

@media (prefers-reduced-motion: reduce) {
  *, *::before, *::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; scroll-behavior: auto !important; }
  .reveal { opacity: 1; transform: none; }
}

/* Back to Top Button */
.back-to-top {
  position: fixed;
  bottom: 28px;
  right: 28px;
  z-index: 90;
  width: 48px;
  height: 48px;
  padding: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  border: none;
  border-radius: 50%;
  color: #fff;
  cursor: pointer;
  background: linear-gradient(135deg, var(--accent) 0%, #00D4FF 100%);
  box-shadow: 0 10px 26px rgba(37,99,235,.32), inset 0 0 0 1px rgba(255,255,255,.16);
  opacity: 0;
  visibility: hidden;
  transform: translateY(16px) scale(.92);
  transition: opacity .35s cubic-bezier(.2,.8,.2,1), transform .35s cubic-bezier(.2,.8,.2,1), box-shadow .35s ease, visibility .35s;
  -webkit-tap-highlight-color: transparent;
}
.back-to-top.visible {
  opacity: 1;
  visibility: visible;
  transform: translateY(0) scale(1);
}
.back-to-top:hover {
  transform: translateY(-4px) scale(1.06);
  background: linear-gradient(135deg, var(--accent) 0%, #22D3EE 100%);
  box-shadow: 0 16px 36px rgba(37,99,235,.45), 0 0 22px rgba(0,212,255,.65);
}
.back-to-top:active {
  transform: translateY(-1px) scale(1);
}
.back-to-top svg {
  width: 22px;
  height: 22px;
  transition: transform var(--transition);
}
.back-to-top:hover svg {
  transform: translateY(-2px);
}
html[data-mode="dark"] .back-to-top {
  box-shadow: 0 10px 26px rgba(0,0,0,.5), 0 0 16px rgba(0,212,255,.35);
}
html[data-mode="dark"] .back-to-top:hover {
  box-shadow: 0 16px 36px rgba(0,0,0,.55), 0 0 26px rgba(0,212,255,.6);
}
@media (max-width: 768px) {
  .back-to-top {
    bottom: 20px;
    right: 20px;
    width: 44px;
    height: 44px;
  }
  .back-to-top svg {
    width: 20px;
    height: 20px;
  }
}
@media (prefers-reduced-motion: reduce) {
  .back-to-top {
    transform: none;
    transition: opacity .01ms linear, visibility .01ms linear;
  }
  .back-to-top.visible,
  .back-to-top:hover,
  .back-to-top:active {
    transform: none;
  }
}
</style>
</head>
<body>
<a class="skip-link" href="#main-content">Skip to content</a>

<header class="topbar">
  <a href="index.php" style="font-weight:900;font-size:1.2rem;letter-spacing:-.04em;color:var(--text)">CARE<span style="color:var(--accent)">.</span></a>
  <div style="flex:1"></div>
  <nav style="display:flex;gap:24px;align-items:center">
    <a href="index.php" style="color:inherit;text-decoration:none;font-weight:600;font-size:.9rem;color:var(--muted)">Home</a>
    <a href="services.php" style="color:inherit;text-decoration:none;font-weight:600;font-size:.9rem;color:var(--muted)">Services</a>
    <a href="about.php" style="color:inherit;text-decoration:none;font-weight:600;font-size:.9rem;color:var(--muted)">About</a>
    <a href="portfolio.php" style="color:inherit;text-decoration:none;font-weight:600;font-size:.9rem;color:var(--muted)">Portfolio</a>
    <a href="contact.php" style="color:inherit;text-decoration:none;font-weight:700;font-size:.9rem;color:var(--accent)">Contact</a>
    <button id="themeToggle" style="background:none;border:none;cursor:pointer;padding:8px;color:var(--text)" aria-label="Toggle theme">
      <svg class="icon" viewBox="0 0 24 24"><path d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m11.314 11.314l.707.707M12 5a7 7 0 100 14 7 7 0 000-14z"/></svg>
    </button>
  </nav>
  <a href="contact.php" class="btn btn-primary" style="padding:10px 20px;font-size:.85rem">Start a Project</a>
</header>

<div class="main-area">
  <main id="main-content">
    <!-- Hero Section -->
    <section class="contact-hero">
      <div class="contact-hero-bg">
        <div class="contact-hero-grid"></div>
        <div class="contact-hero-glow"></div>
        <svg class="contact-hero-network" viewBox="0 0 1440 800" preserveAspectRatio="xMidYMid slice">
          <line x1="100" y1="100" x2="300" y2="250" />
          <line x1="300" y1="250" x2="600" y2="150" />
          <line x1="600" y1="150" x2="900" y2="300" />
          <line x1="900" y1="300" x2="1200" y2="200" />
          <circle cx="100" cy="100" r="3" />
          <circle cx="300" cy="250" r="4" />
          <circle cx="600" cy="150" r="3" />
          <circle cx="900" cy="300" r="4" />
          <circle cx="1200" cy="200" r="3" />
        </svg>
      </div>
      <div class="contact-hero-content">
        <div class="contact-hero-text reveal">
          <span class="section-eyebrow" style="color:var(--accent-2)">Let's Connect</span>
          <h1 class="contact-hero-title">Let's Talk About Your Next Big Idea.</h1>
          <p class="contact-hero-description">Have a project in mind, need a digital solution, or want to strengthen your brand? Get in touch with CARE Digital Solutions. We're ready to hear your ideas and discuss how we can help.</p>
          <div class="contact-hero-actions">
            <a href="<?= e(whatsapp_link(setting('whatsapp_1'), $waMessage)) ?>" class="btn btn-whatsapp">
              <svg class="icon" viewBox="0 0 24 24" style="fill:currentColor;stroke:none"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
              Chat on WhatsApp
            </a>
            <a href="#inquiry-form" class="btn btn-secondary">Send an Inquiry</a>
          </div>
          <p class="contact-hero-trust">Web Development • Software & AI • Branding • Printing • Creative Digital Solutions</p>
        </div>
        <div class="contact-hero-visual reveal">
          <div class="comm-illustration">
            <div class="comm-orb"></div>
            <div class="comm-card c1">
              <div class="icon-box"><svg class="icon" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg></div>
              <div><b>Direct Message</b><span>Quick response</span></div>
            </div>
            <div class="comm-card c2">
              <div class="icon-box"><svg class="icon" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg></div>
              <div><b>Voice Call</b><span>Discuss details</span></div>
            </div>
            <div class="comm-card c3">
              <div class="icon-box"><svg class="icon" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><path d="M22 6l-10 7L2 6"/></svg></div>
              <div><b>Project Inquiry</b><span>Start planning</span></div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Info Section -->
    <section class="section info-section">
      <div class="section-header reveal">
        <span class="section-eyebrow">We're Here to Connect</span>
        <h2 class="section-title">Reach Out the Way You Prefer</h2>
        <p class="section-description">Choose the contact method that works best for you. Reach us directly by phone or WhatsApp, or send us an inquiry using the form below.</p>
      </div>
      <div class="info-grid">
        <!-- Call Us -->
        <div class="info-card reveal">
          <div class="info-icon"><svg class="icon" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg></div>
          <h3>Call Us</h3>
          <p>Prefer to speak with us directly? Give us a call on one of our official numbers.</p>
          <div class="info-links">
            <a href="tel:+<?= e(preg_replace('/\D+/', '', setting('whatsapp_1'))) ?>" class="info-link"><?= e(phone_display(setting('site_phone_1'))) ?></a>
            <a href="tel:+<?= e(preg_replace('/\D+/', '', setting('whatsapp_2'))) ?>" class="info-link"><?= e(phone_display(setting('site_phone_2'))) ?></a>
          </div>
        </div>
        <!-- WhatsApp -->
        <div class="info-card reveal">
          <div class="info-icon"><svg class="icon" viewBox="0 0 24 24" style="fill:currentColor;stroke:none"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg></div>
          <h3>Chat on WhatsApp</h3>
          <p>Have a quick question or want to discuss a project? Send us a message directly on WhatsApp.</p>
          <div class="info-links">
            <a href="<?= e(whatsapp_link(setting('whatsapp_1'), $waMessage)) ?>" class="btn btn-whatsapp" style="padding:12px 24px;font-size:.9rem">Message <?= e(phone_display(setting('site_phone_1'))) ?></a>
            <a href="<?= e(whatsapp_link(setting('whatsapp_2'), $waMessage)) ?>" class="btn btn-whatsapp" style="padding:12px 24px;font-size:.9rem">Message <?= e(phone_display(setting('site_phone_2'))) ?></a>
          </div>
        </div>
        <!-- Social Media -->
        <div class="info-card reveal">
          <div class="info-icon"><svg class="icon" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg></div>
          <h3>Follow Our Journey</h3>
          <p>Stay connected with CARE Digital Solutions for creative work, updates, and digital innovation.</p>
          <div class="social-links">
            <a href="#" class="social-btn" aria-label="Facebook"><svg class="icon" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg></a>
            <a href="#" class="social-btn" aria-label="Instagram"><svg class="icon" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg></a>
            <a href="#" class="social-btn" aria-label="TikTok"><svg class="icon" viewBox="0 0 24 24"><path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"/></svg></a>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Form Section -->
    <section id="inquiry-form" class="section form-section">
      <div class="section-header reveal" style="margin-left:auto;margin-right:auto;text-align:center">
        <span class="section-eyebrow">Project Inquiry</span>
        <h2 class="section-title">Tell Us About Your Project</h2>
        <p class="section-description" style="margin-left:auto;margin-right:auto">Share a few details about what you need. We'll use your inquiry to understand your goals and identify the next steps.</p>
      </div>
      <div class="form-container reveal">
        <form class="contact-form" id="contactForm" method="post" action="contact.php#inquiry-form">
          <div style="display:none">
            <?= csrf_field() ?>
            <input type="hidden" name="contact_form" value="1">
          </div>
          <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your full name" required>
          </div>
          <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
          </div>
          <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="Enter your email address" required>
          </div>
          <div class="form-group">
            <label for="company">Company or Organization (Optional)</label>
            <input type="text" id="company" name="company" placeholder="Enter your company name">
          </div>
          <div class="form-group">
            <label for="service">Service Required</label>
            <select id="service" name="service" required>
              <option value="" disabled selected>Select a service</option>
              <option value="Website Design & Development">Website Design & Development</option>
              <option value="Software Development">Software Development</option>
              <option value="AI & Automation">AI & Automation</option>
              <option value="Graphic Design & Branding">Graphic Design & Branding</option>
              <option value="Printing & Branded Materials">Printing & Branded Materials</option>
              <option value="Stationery Services">Stationery Services</option>
              <option value="Multimedia & Video Editing">Multimedia & Video Editing</option>
              <option value="ICT Support">ICT Support</option>
              <option value="Other / Not Sure Yet">Other / Not Sure Yet</option>
            </select>
          </div>
          <div class="form-group">
            <label for="budget">Project Budget (Optional)</label>
            <select id="budget" name="budget">
              <option value="undecided">Not Yet Decided</option>
              <option value="below-100k">Below TZS 100,000</option>
              <option value="100k-500k">TZS 100,000–500,000</option>
              <option value="500k-1m">TZS 500,000–1,000,000</option>
              <option value="above-1m">Above TZS 1,000,000</option>
            </select>
          </div>
          <div class="form-group full">
            <label for="message">Message / Project Details</label>
            <textarea id="message" name="message" rows="5" placeholder="Tell us more about your project goals..." required></textarea>
          </div>
          <div class="form-group full" style="text-align:center;margin-top:20px">
            <?php if ($feedback): ?>
              <p role="status" style="padding:14px 16px;border-radius:12px;font-weight:600;font-size:.9rem;margin-bottom:16px;background:<?= $feedback['type'] === 'success' ? 'rgba(22,132,91,.1)' : 'rgba(220,38,38,.1)' ?>;color:<?= $feedback['type'] === 'success' ? '#16845b' : '#dc2626' ?>"><?= e($feedback['message']) ?></p>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary" style="width:100%;max-width:300px">Send Project Inquiry</button>
            <p class="form-privacy">Your information should only be used to respond to your inquiry.</p>
          </div>
        </form>
      </div>
    </section>

    <!-- Quick WhatsApp Inquiry Section -->
    <section class="section whatsapp-section">
      <div class="section-header reveal" style="margin-left:auto;margin-right:auto;text-align:center">
        <span class="section-eyebrow" style="color:var(--accent-2)">Quick Contact</span>
        <h2 class="section-title" style="color:#fff">Prefer a Quick Conversation?</h2>
        <p class="section-description" style="color:rgba(255,255,255,.7);margin-left:auto;margin-right:auto">Skip the long forms. Contact CARE Digital Solutions directly on WhatsApp to ask a question, discuss a service, or start a conversation about your next project.</p>
      </div>
      <div class="whatsapp-grid">
        <div class="whatsapp-box reveal">
          <h4>WhatsApp 1</h4>
          <span class="num"><?= e(phone_display(setting('site_phone_1'))) ?></span>
          <a href="<?= e(whatsapp_link(setting('whatsapp_1'), $waMessage)) ?>" class="btn btn-whatsapp">Start WhatsApp Chat</a>
        </div>
        <div class="whatsapp-box reveal" style="animation-delay:.2s">
          <h4>WhatsApp 2</h4>
          <span class="num"><?= e(phone_display(setting('site_phone_2'))) ?></span>
          <a href="<?= e(whatsapp_link(setting('whatsapp_2'), $waMessage)) ?>" class="btn btn-whatsapp">Start WhatsApp Chat</a>
        </div>
      </div>
    </section>

    <!-- Social Media Section -->
    <section class="section social-section">
      <div class="section-header reveal">
        <span class="section-eyebrow">Connect With Us Online</span>
        <h2 class="section-title">Follow Our Journey</h2>
        <p class="section-description">Follow CARE Digital Solutions to explore our creative work, discover our services, and stay connected with our latest updates.</p>
      </div>
      <div class="info-grid">
        <a href="#" class="info-card reveal">
          <div class="info-icon"><svg class="icon" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg></div>
          <h3>Facebook</h3>
          <p>Connect with us on Facebook for community updates and news.</p>
          <span class="info-link" style="font-size:.9rem;color:var(--accent)">Follow Us <svg class="icon" viewBox="0 0 24 24" style="width:16px;height:16px"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
        </a>
        <a href="#" class="info-card reveal">
          <div class="info-icon"><svg class="icon" viewBox="0 0 24 24"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg></div>
          <h3>Instagram</h3>
          <p>Explore our creative work and behind-the-scenes design inspiration.</p>
          <span class="info-link" style="font-size:.9rem;color:var(--accent)">Follow Us <svg class="icon" viewBox="0 0 24 24" style="width:16px;height:16px"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
        </a>
        <a href="#" class="info-card reveal">
          <div class="info-icon"><svg class="icon" viewBox="0 0 24 24"><path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"/></svg></div>
          <h3>TikTok</h3>
          <p>Discover our visual content and creative video projects.</p>
          <span class="info-link" style="font-size:.9rem;color:var(--accent)">Follow Us <svg class="icon" viewBox="0 0 24 24" style="width:16px;height:16px"><path d="M5 12h14M13 6l6 6-6 6"/></svg></span>
        </a>
      </div>
    </section>

    <!-- Services Grid -->
    <section class="section services-section">
      <div class="section-header reveal">
        <span class="section-eyebrow">What Can We Help You With?</span>
        <h2 class="section-title">Let's Find the Right Solution</h2>
        <p class="section-description">We offer a wide range of digital services tailored to your specific business goals.</p>
      </div>
      <div class="services-grid">
        <div class="service-item reveal">
          <svg class="icon" viewBox="0 0 24 24" style="width:32px;height:32px"><rect x="3" y="4" width="18" height="15" rx="2"/><path d="M8 22h8M12 19v3M7 9h10M7 13h6"/></svg>
          <h4>Websites & Digital Experiences</h4>
          <p>Responsive websites and digital interfaces built for modern users.</p>
          <a href="services.php" class="link">Learn More <svg class="icon" viewBox="0 0 24 24" style="width:14px;height:14px"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
        </div>
        <div class="service-item reveal">
          <svg class="icon" viewBox="0 0 24 24" style="width:32px;height:32px"><path d="M12 20V10M18 20V4M6 20v-4"/></svg>
          <h4>Software & AI Solutions</h4>
          <p>Custom software and automation tools to streamline your business.</p>
          <a href="services.php" class="link">Learn More <svg class="icon" viewBox="0 0 24 24" style="width:14px;height:14px"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
        </div>
        <div class="service-item reveal">
          <svg class="icon" viewBox="0 0 24 24" style="width:32px;height:32px"><path d="M12 3v18M3 12h18"/><circle cx="12" cy="12" r="8"/><path d="m8 8 8 8m0-8-8 8"/></svg>
          <h4>Graphic Design & Branding</h4>
          <p>Strong visual identities and creative designs that make an impact.</p>
          <a href="services.php" class="link">Learn More <svg class="icon" viewBox="0 0 24 24" style="width:14px;height:14px"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
        </div>
        <div class="service-item reveal">
          <svg class="icon" viewBox="0 0 24 24" style="width:32px;height:32px"><path d="M6 9V2h12V9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><path d="M6 14h12v8H6z"/></svg>
          <h4>Printing & Branded Materials</h4>
          <p>High-quality print services for all your business branding needs.</p>
          <a href="services.php" class="link">Learn More <svg class="icon" viewBox="0 0 24 24" style="width:14px;height:14px"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
        </div>
        <div class="service-item reveal">
          <svg class="icon" viewBox="0 0 24 24" style="width:32px;height:32px"><rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"/><line x1="7" y1="2" x2="7" y2="22"/><line x1="17" y1="2" x2="17" y2="22"/><line x1="2" y1="12" x2="22" y2="12"/></svg>
          <h4>Multimedia & Video</h4>
          <p>Professional video editing and multimedia content production.</p>
          <a href="services.php" class="link">Learn More <svg class="icon" viewBox="0 0 24 24" style="width:14px;height:14px"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
        </div>
        <div class="service-item reveal">
          <svg class="icon" viewBox="0 0 24 24" style="width:32px;height:32px"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2Z"/></svg>
          <h4>ICT Support & Services</h4>
          <p>Reliable technical support and ICT consulting for businesses.</p>
          <a href="services.php" class="link">Learn More <svg class="icon" viewBox="0 0 24 24" style="width:14px;height:14px"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
        </div>
      </div>
    </section>

    <!-- Final CTA -->
    <section class="final-cta">
      <div class="reveal">
        <h2 class="cta-title">Your Next Idea Starts With a Conversation.</h2>
        <p class="cta-desc">Whether you need a website, a software solution, professional branding, or creative digital services, CARE Digital Solutions is ready to discuss your goals.</p>
        <div class="contact-hero-actions" style="justify-content:center">
          <a href="<?= e(whatsapp_link(setting('whatsapp_1'), $waMessage)) ?>" class="btn btn-whatsapp">Chat on WhatsApp</a>
          <a href="tel:+<?= e(preg_replace('/\D+/', '', setting('whatsapp_1'))) ?>" class="btn btn-secondary">Call Us Directly</a>
        </div>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer>
    <div class="footer-content">
      <div>
        <div class="footer-brand">CARE Digital Solutions</div>
        <p class="footer-tagline">Connecting Ideas, Empowering Businesses.</p>
        <div class="footer-copyright">© <span class="year"></span> All rights reserved.</div>
      </div>
      <div>
        <div class="footer-heading">Quick Links</div>
        <div class="footer-links">
          <a href="index.php" class="footer-link">Home</a>
          <a href="services.php" class="footer-link">Services</a>
          <a href="about.php" class="footer-link">About</a>
          <a href="portfolio.php" class="footer-link">Portfolio</a>
          <a href="contact.php" class="footer-link">Contact</a>
        </div>
      </div>
      <div>
        <div class="footer-heading">Services</div>
        <div class="footer-links">
          <a href="services.php" class="footer-link">Website Design</a>
          <a href="services.php" class="footer-link">Software Development</a>
          <a href="services.php" class="footer-link">Branding & Design</a>
          <a href="services.php" class="footer-link">ICT Support</a>
        </div>
      </div>
      <div>
        <div class="footer-heading">Contact</div>
        <div class="footer-links">
          <a href="mailto:<?= e(setting('site_email')) ?>" class="footer-link" style="color:var(--accent-2);font-weight:600"><?= e(setting('site_email')) ?></a>
          <a href="<?= e(whatsapp_link(setting('whatsapp_1'))) ?>" class="footer-link">WhatsApp: <?= e(phone_display(setting('site_phone_1'))) ?></a>
          <a href="<?= e(whatsapp_link(setting('whatsapp_2'))) ?>" class="footer-link">WhatsApp: <?= e(phone_display(setting('site_phone_2'))) ?></a>
          <span class="footer-link" style="color:rgba(255,255,255,.4)">Tanzania</span>
        </div>
      </div>
    </div>
  </footer>
</div>

<button class="back-to-top" id="backToTop" type="button" aria-label="Back to top" title="Back to top">
  <svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
</button>

<script>
(() => {
  "use strict";
  const root = document.documentElement;
  const themeToggle = document.getElementById("themeToggle");
  
  // Theme toggle
  themeToggle.addEventListener("click", () => {
    const currentMode = root.dataset.mode;
    const newMode = currentMode === "dark" ? "light" : "dark";
    root.dataset.mode = newMode;
    localStorage.setItem("care-theme", newMode);
  });
  
  // Load saved theme
  const savedTheme = localStorage.getItem("care-theme");
  if (savedTheme && (savedTheme === "light" || savedTheme === "dark")) {
    root.dataset.mode = savedTheme;
  }
  
  // Sticky header
  window.addEventListener("scroll", () => {
    const topbar = document.querySelector(".topbar");
    if (window.pageYOffset > 50) {
      topbar.classList.add("scrolled");
    } else {
      topbar.classList.remove("scrolled");
    }
  }, { passive: true });
  
  // Scroll reveal
  if ("IntersectionObserver" in window) {
    const observer = new IntersectionObserver(entries => entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add("visible");
        observer.unobserve(entry.target);
      }
    }), { threshold: 0.1 });
    document.querySelectorAll(".reveal").forEach(el => observer.observe(el));
  } else {
    document.querySelectorAll(".reveal").forEach(el => el.classList.add("visible"));
  }
  
  // Dynamic year
  document.querySelectorAll(".year").forEach(el => {
    el.textContent = new Date().getFullYear();
  });

  // Back to Top functionality
  const backToTop = document.getElementById("backToTop");
  if (backToTop) {
    const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)");

    const toggleBackToTop = () => {
      backToTop.classList.toggle("visible", window.scrollY > 300);
    };

    window.addEventListener("scroll", toggleBackToTop, { passive: true });
    toggleBackToTop();

    backToTop.addEventListener("click", () => {
      window.scrollTo({ top: 0, behavior: reduceMotion.matches ? "auto" : "smooth" });
    });
  }
})();
</script>
</body>
</html>
