<?php
declare(strict_types=1);

require __DIR__ . '/src/bootstrap.php';
?>
<!DOCTYPE html>
<html lang="en" data-mode="light">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#071426">
<meta name="description" content="About CARE Digital Solutions — Connecting Ideas, Empowering Businesses. Learn about our vision, mission, values, and commitment to delivering innovative digital solutions.">
<meta name="keywords" content="about CARE Digital Solutions, digital solutions company, technology company, Tanzania, web development, branding, ICT support">
<meta name="author" content="CARE Digital Solutions">
<meta name="robots" content="index, follow">
<meta property="og:title" content="About Us — CARE Digital Solutions">
<meta property="og:description" content="Learn about CARE Digital Solutions — Connecting Ideas, Empowering Businesses through innovative digital solutions.">
<meta property="og:type" content="website">
<meta property="og:url" content="https://caredigitalsolutions.co.tz/about">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="About Us — CARE Digital Solutions">
<meta name="twitter:description" content="Learn about CARE Digital Solutions — Connecting Ideas, Empowering Businesses through innovative digital solutions.">
<link rel="canonical" href="https://caredigitalsolutions.co.tz/about">
<title>About Us — CARE Digital Solutions</title>
<style>
/* ==========================================================
   CARE Digital Solutions — Premium About Us Page
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

/* About Hero */
.about-hero {
  position:relative;
  min-height:80vh;
  display:flex;
  align-items:center;
  background:linear-gradient(135deg,var(--hero-bg) 0%,var(--hero-bg-deep) 100%);
  overflow:hidden;
  padding:140px 34px 100px;
}

.about-hero-bg {
  position:absolute;
  inset:0;
  overflow:hidden;
  pointer-events:none;
}

.about-hero-grid {
  position:absolute;
  inset:0;
  background-image:
    linear-gradient(rgba(37,99,235,.03) 1px,transparent 1px),
    linear-gradient(90deg,rgba(37,99,235,.03) 1px,transparent 1px);
  background-size:60px 60px;
  mask-image:radial-gradient(ellipse at center,black 30%,transparent 70%);
}

.about-hero-glow {
  position:absolute;
  width:600px;
  height:600px;
  border-radius:50%;
  background:radial-gradient(circle,rgba(37,99,235,.15) 0%,transparent 70%);
  top:-200px;
  right:-200px;
  filter:blur(80px);
}

.about-hero-glow-2 {
  position:absolute;
  width:400px;
  height:400px;
  border-radius:50%;
  background:radial-gradient(circle,rgba(34,211,238,.1) 0%,transparent 70%);
  bottom:-100px;
  left:-100px;
  filter:blur(60px);
}

.about-hero-content {
  position:relative;
  z-index:2;
  max-width:1400px;
  margin:0 auto;
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:80px;
  align-items:center;
}

.about-hero-text {
  color:#fff;
}

.about-hero-eyebrow {
  display:inline-block;
  color:var(--accent-2);
  font-size:.75rem;
  font-weight:700;
  text-transform:uppercase;
  letter-spacing:.2em;
  margin-bottom:24px;
}

.about-hero-title {
  font-size:clamp(2.5rem,5vw,4rem);
  font-weight:900;
  letter-spacing:-.04em;
  line-height:1.1;
  margin-bottom:24px;
}

.about-hero-description {
  font-size:1.1rem;
  line-height:1.7;
  color:rgba(255,255,255,.7);
  margin-bottom:32px;
  max-width:580px;
}

.about-hero-actions {
  display:flex;
  gap:16px;
  flex-wrap:wrap;
  margin-bottom:24px;
}

.about-hero-trust {
  font-size:.85rem;
  color:rgba(255,255,255,.5);
  font-weight:600;
  letter-spacing:.1em;
  text-transform:uppercase;
}

.about-hero-visual {
  position:relative;
  display:flex;
  align-items:center;
  justify-content:center;
}

.about-network {
  position:relative;
  width:450px;
  height:450px;
}

.network-ring {
  position:absolute;
  inset:0;
  border-radius:50%;
  border:1px solid rgba(37,99,235,.2);
  animation:rotate 25s linear infinite;
}

.network-ring-2 {
  position:absolute;
  inset:50px;
  border-radius:50%;
  border:1px solid rgba(34,211,238,.25);
  animation:rotate 20s linear infinite reverse;
}

.network-ring-3 {
  position:absolute;
  inset:100px;
  border-radius:50%;
  border:1px solid rgba(37,99,235,.15);
  animation:rotate 15s linear infinite;
}

.network-core {
  position:absolute;
  inset:150px;
  border-radius:50%;
  background:radial-gradient(circle at 30% 30%,rgba(37,99,235,.3) 0%,rgba(7,20,38,.9) 70%);
  box-shadow:0 0 60px rgba(37,99,235,.25),inset 0 0 60px rgba(34,211,238,.15);
}

.network-node {
  position:absolute;
  width:10px;
  height:10px;
  border-radius:50%;
  background:var(--accent-2);
  box-shadow:0 0 20px var(--accent-2);
}

.network-node:nth-child(1) { top:15%;left:50%;animation:float 4s ease-in-out infinite; }
.network-node:nth-child(2) { top:50%;right:15%;animation:float 4s ease-in-out infinite 1.5s; }
.network-node:nth-child(3) { bottom:15%;left:25%;animation:float 4s ease-in-out infinite 3s; }
.network-node:nth-child(4) { top:30%;left:25%;animation:float 4s ease-in-out infinite 2s; }
.network-node:nth-child(5) { top:60%;left:60%;animation:float 4s ease-in-out infinite 1s; }

@keyframes rotate {
  from { transform:rotate(0deg); }
  to { transform:rotate(360deg); }
}

@keyframes float {
  0%,100% { transform:translateY(0); }
  50% { transform:translateY(-12px); }
}

/* Premium Buttons */
.btn {
  display:inline-flex;
  align-items:center;
  justify-content:center;
  gap:10px;
  padding:14px 28px;
  border-radius:12px;
  font-size:.9rem;
  font-weight:700;
  cursor:pointer;
  transition:all var(--transition);
  white-space:nowrap;
  text-decoration:none;
}

.btn-primary {
  background:linear-gradient(135deg,var(--accent) 0%,var(--accent-2) 100%);
  color:#fff;
  border:none;
  box-shadow:0 8px 24px rgba(37,99,235,.3);
}

.btn-primary:hover {
  transform:translateY(-2px);
  box-shadow:0 12px 32px rgba(37,99,235,.4);
}

.btn-secondary {
  background:rgba(255,255,255,.1);
  color:#fff;
  border:1px solid rgba(255,255,255,.2);
  backdrop-filter:blur(10px);
}

.btn-secondary:hover {
  background:rgba(255,255,255,.15);
  border-color:rgba(255,255,255,.3);
}

/* Section Styling */
.section {
  padding:100px 34px;
  max-width:1400px;
  margin:0 auto;
}

.section-header {
  text-align:center;
  margin-bottom:60px;
}

.section-eyebrow {
  display:inline-block;
  color:var(--accent);
  font-size:.75rem;
  font-weight:700;
  text-transform:uppercase;
  letter-spacing:.2em;
  margin-bottom:16px;
}

.section-title {
  font-size:clamp(2rem,4vw,3rem);
  font-weight:900;
  letter-spacing:-.04em;
  margin-bottom:16px;
  color:var(--text);
}

.section-description {
  color:var(--muted);
  font-size:1.1rem;
  max-width:700px;
  margin:0 auto;
  line-height:1.7;
}

/* Who We Are — Futuristic Upgrade */
.who-we-are {
  padding: 120px 34px;
  background: var(--bg-elevated);
  position: relative;
  overflow: hidden;
}

.who-content {
  display: grid;
  grid-template-columns: minmax(0, 1.1fr) minmax(0, 0.9fr);
  gap: 80px;
  align-items: center;
  max-width: 1400px;
  margin: 0 auto;
}

.who-text {
  position: relative;
  z-index: 2;
}

.who-text h3 {
  font-size: clamp(2rem, 3.5vw, 2.8rem);
  font-weight: 900;
  margin-bottom: 24px;
  letter-spacing: -.04em;
  line-height: 1.15;
  color: var(--text);
}

.who-text p {
  color: var(--muted);
  font-size: clamp(1rem, 1.1vw, 1.12rem);
  line-height: 1.8;
  margin-bottom: 24px;
  max-width: 60ch;
}

.who-highlights {
  display: grid;
  gap: 20px;
  margin-top: 40px;
}

.highlight {
  display: flex;
  align-items: center;
  gap: 16px;
  font-size: 1rem;
  font-weight: 700;
  color: var(--text);
  padding: 12px 20px;
  background: var(--surface-soft);
  border-radius: 14px;
  border: 1px solid var(--line);
  width: fit-content;
  transition: all var(--transition);
}

.highlight:hover {
  transform: translateX(8px);
  border-color: var(--accent);
  background: var(--accent-soft);
}

.highlight::before {
  content: "";
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background: linear-gradient(135deg, var(--accent), var(--accent-2));
  box-shadow: 0 0 10px var(--accent);
  flex: none;
}

.who-visual {
  position: relative;
  min-width: 0;
}

.tech-ecosystem {
  position: relative;
  isolation: isolate;
  width: 100%;
  aspect-ratio: 1;
  border-radius: 32px;
  overflow: hidden;
  background: linear-gradient(150deg, #0B1F3A 0%, #071426 60%, #050c1a 100%);
  border: 1px solid rgba(0, 212, 255, 0.2);
  box-shadow: 
    0 40px 80px -30px rgba(7, 20, 38, 0.8),
    inset 0 1px 0 rgba(255, 255, 255, 0.08);
}

html[data-mode="dark"] .tech-ecosystem {
  border-color: rgba(0, 212, 255, 0.25);
  box-shadow: 0 40px 90px -30px rgba(0, 0, 0, 0.9);
}

.tech-bg-grid {
  position: absolute;
  inset: -5%;
  background-image: 
    linear-gradient(rgba(0, 212, 255, 0.08) 1px, transparent 1px),
    linear-gradient(90deg, rgba(0, 212, 255, 0.08) 1px, transparent 1px);
  background-size: 40px 40px;
  mask-image: radial-gradient(circle at 50% 50%, black 20%, transparent 80%);
  transition: transform 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
}

.tech-glow-spot {
  position: absolute;
  border-radius: 50%;
  filter: blur(60px);
  opacity: 0.6;
  pointer-events: none;
}

.tech-glow-1 {
  top: 10%;
  left: 10%;
  width: 50%;
  aspect-ratio: 1;
  background: radial-gradient(circle, var(--accent) 0%, transparent 70%);
}

.tech-glow-2 {
  bottom: 10%;
  right: 10%;
  width: 40%;
  aspect-ratio: 1;
  background: radial-gradient(circle, var(--accent-2) 0%, transparent 70%);
}

.tech-core-svg {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  z-index: 2;
  transition: transform 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
}

.glass-panel {
  position: absolute;
  padding: 12px 16px;
  background: rgba(255, 255, 255, 0.05);
  backdrop-filter: blur(12px);
  -webkit-backdrop-filter: blur(12px);
  border: 1px solid rgba(255, 255, 255, 0.15);
  border-radius: 16px;
  color: #fff;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
  z-index: 3;
  animation: floatPanel 6s ease-in-out infinite;
}

.panel-website { top: 12%; right: 8%; animation-delay: -1s; }
.panel-ai { top: 40%; left: 5%; animation-delay: -3s; }
.panel-design { bottom: 12%; right: 12%; animation-delay: -5s; }

.panel-header {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 8px;
}

.panel-icon {
  width: 24px;
  height: 24px;
  display: grid;
  place-items: center;
  background: rgba(0, 212, 255, 0.15);
  border-radius: 8px;
  color: var(--accent-2);
}

.panel-title {
  font-size: 0.75rem;
  font-weight: 700;
  letter-spacing: 0.02em;
}

.panel-visual {
  height: 30px;
  background: rgba(255, 255, 255, 0.05);
  border-radius: 6px;
  display: flex;
  align-items: center;
  padding: 0 8px;
  gap: 4px;
}

.mini-bar {
  height: 4px;
  border-radius: 2px;
  background: var(--accent-2);
  opacity: 0.6;
}

.connectivity-line {
  position: absolute;
  background: linear-gradient(90deg, transparent, var(--accent-2), transparent);
  height: 1px;
  opacity: 0.3;
  z-index: 1;
}

@keyframes floatPanel {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(-12px); }
}

@keyframes pulseNode {
  0%, 100% { transform: scale(1); opacity: 0.6; }
  50% { transform: scale(1.5); opacity: 1; }
}

.node-pulse {
  animation: pulseNode 3s ease-in-out infinite;
}

/* Purpose Cards */
.purpose-section {
  background:linear-gradient(135deg,var(--bg) 0%,var(--bg-elevated) 100%);
}

.purpose-grid {
  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:32px;
}

.purpose-card {
  padding:40px 32px;
  border:1px solid var(--line);
  border-radius:24px;
  background:var(--surface-solid);
  transition:all var(--transition);
  position:relative;
  overflow:hidden;
}

.purpose-card::before {
  content:"";
  position:absolute;
  top:0;
  left:0;
  right:0;
  height:4px;
  background:linear-gradient(90deg,var(--accent),var(--accent-2));
  opacity:0;
  transition:opacity var(--transition);
}

.purpose-card:hover {
  transform:translateY(-8px);
  box-shadow:var(--shadow);
  border-color:var(--accent);
}

.purpose-card:hover::before {
  opacity:1;
}

.purpose-icon {
  width:64px;
  height:64px;
  border-radius:16px;
  background:linear-gradient(135deg,var(--accent-soft),var(--accent));
  color:#fff;
  margin-bottom:24px;
  display:grid;
  place-items:center;
}

.purpose-title {
  font-size:1.3rem;
  font-weight:800;
  margin-bottom:16px;
  letter-spacing:-.02em;
  color:var(--text);
}

.purpose-text {
  color:var(--muted);
  font-size:.95rem;
  line-height:1.7;
  margin:0;
}

/* Core Values */
.values-section {
  background:var(--bg-elevated);
}

.values-grid {
  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:24px;
}

.value-card {
  padding:32px;
  border:1px solid var(--line);
  border-radius:20px;
  background:var(--surface-solid);
  transition:all var(--transition);
}

.value-card:nth-child(even) {
  background:linear-gradient(135deg,var(--accent-soft),var(--surface-solid));
}

.value-card:hover {
  transform:translateY(-4px);
  border-color:var(--accent);
  box-shadow:var(--shadow-sm);
}

.value-icon {
  width:48px;
  height:48px;
  border-radius:12px;
  background:var(--accent-soft);
  color:var(--accent);
  display:grid;
  place-items:center;
  margin-bottom:20px;
}

.value-title {
  font-size:1.1rem;
  font-weight:800;
  margin-bottom:12px;
  color:var(--text);
}

.value-description {
  color:var(--muted);
  font-size:.9rem;
  line-height:1.6;
  margin:0;
}

/* Capabilities */
.capabilities-section {
  background:var(--bg);
}

.capabilities-grid {
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
  gap:24px;
}

.capability-card {
  padding:28px;
  border:1px solid var(--line);
  border-radius:18px;
  background:var(--surface-solid);
  transition:all var(--transition);
}

.capability-card:hover {
  transform:translateY(-4px);
  border-color:var(--accent);
  box-shadow:var(--shadow-sm);
}

.capability-icon {
  width:52px;
  height:52px;
  border-radius:14px;
  background:linear-gradient(135deg,var(--accent-soft),var(--accent));
  color:#fff;
  margin-bottom:20px;
  display:grid;
  place-items:center;
}

.capability-title {
  font-size:1.15rem;
  font-weight:800;
  margin-bottom:12px;
  color:var(--text);
}

.capability-description {
  color:var(--muted);
  font-size:.9rem;
  line-height:1.6;
  margin:0;
}

/* Process Timeline */
.process-section {
  background:linear-gradient(135deg,var(--hero-bg) 0%,var(--hero-bg-deep) 100%);
  position:relative;
  overflow:hidden;
}

.process-bg {
  position:absolute;
  inset:0;
  background-image:radial-gradient(circle at 20% 50%,rgba(37,99,235,.1) 0%,transparent 50%);
}

.process-content {
  position:relative;
  z-index:2;
}

.process-steps {
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:32px;
  position:relative;
}

.process-steps::before {
  content:"";
  position:absolute;
  top:30px;
  left:50px;
  right:50px;
  height:2px;
  background:linear-gradient(90deg,transparent,var(--accent-2),transparent);
  opacity:.3;
}

.process-step {
  text-align:center;
  position:relative;
}

.process-number {
  width:60px;
  height:60px;
  border-radius:16px;
  background:linear-gradient(135deg,var(--accent),var(--accent-2));
  color:#fff;
  display:grid;
  place-items:center;
  margin:0 auto 24px;
  font-size:1.25rem;
  font-weight:900;
  position:relative;
  z-index:2;
}

.process-title {
  font-size:1.1rem;
  font-weight:800;
  margin-bottom:12px;
  color:#fff;
}

.process-description {
  color:rgba(255,255,255,.7);
  font-size:.9rem;
  line-height:1.6;
}

/* Journey Section */
.journey-section {
  background:var(--hero-bg);
  position:relative;
  overflow:hidden;
}

.journey-bg {
  position:absolute;
  inset:0;
  background-image:
    linear-gradient(rgba(37,99,235,.03) 1px,transparent 1px),
    linear-gradient(90deg,rgba(37,99,235,.03) 1px,transparent 1px);
  background-size:40px 40px;
  mask-image:radial-gradient(ellipse at center,black 40%,transparent 70%);
}

.journey-content {
  position:relative;
  z-index:2;
}

.journey-timeline {
  display:grid;
  gap:32px;
  max-width:900px;
  margin:0 auto;
}

.journey-item {
  display:flex;
  gap:24px;
  align-items:flex-start;
}

.journey-marker {
  width:40px;
  height:40px;
  border-radius:50%;
  background:linear-gradient(135deg,var(--accent),var(--accent-2));
  color:#fff;
  display:grid;
  place-items:center;
  font-weight:900;
  flex:none;
  box-shadow:0 0 20px rgba(37,99,235,.3);
}

.journey-content-text {
  flex:1;
}

.journey-title {
  font-size:1.2rem;
  font-weight:800;
  margin-bottom:8px;
  color:#fff;
}

.journey-description {
  color:rgba(255,255,255,.7);
  font-size:.95rem;
  line-height:1.6;
  margin:0;
}

/* Why Choose Section */
.why-section {
  background:linear-gradient(135deg,var(--hero-bg) 0%,var(--hero-bg-deep) 100%);
  position:relative;
  overflow:hidden;
}

.why-bg {
  position:absolute;
  inset:0;
  background-image:radial-gradient(circle at 30% 50%,rgba(37,99,235,.12) 0%,transparent 60%);
}

.why-content {
  position:relative;
  z-index:2;
  display:grid;
  grid-template-columns:1fr 1fr;
  gap:80px;
  align-items:center;
}

.why-text h3 {
  font-size:clamp(1.8rem,4vw,2.5rem);
  font-weight:900;
  letter-spacing:-.04em;
  margin-bottom:24px;
  color:#fff;
}

.why-text p {
  color:rgba(255,255,255,.7);
  font-size:1.05rem;
  line-height:1.7;
  margin-bottom:32px;
}

.why-benefits {
  display:grid;
  gap:20px;
}

.benefit {
  display:flex;
  align-items:center;
  gap:16px;
  color:rgba(255,255,255,.9);
  font-size:.95rem;
}

.benefit::before {
  content:"✓";
  width:24px;
  height:24px;
  border-radius:50%;
  background:var(--accent);
  color:#fff;
  display:grid;
  place-items:center;
  font-size:.75rem;
  font-weight:900;
  flex:none;
}

.why-visual {
  position:relative;
  aspect-ratio:1;
  border-radius:24px;
  background:rgba(255,255,255,.05);
  border:1px solid rgba(255,255,255,.1);
  display:grid;
  place-items:center;
  overflow:hidden;
}

.why-network {
  position:relative;
  width:300px;
  height:300px;
}

.why-node {
  position:absolute;
  width:8px;
  height:8px;
  border-radius:50%;
  background:var(--accent-2);
  box-shadow:0 0 15px var(--accent-2);
}

.why-line {
  position:absolute;
  height:1px;
  background:linear-gradient(90deg,transparent,var(--accent-2),transparent);
  opacity:.4;
}

/* Commitment Section */
.commitment-section {
  background:linear-gradient(135deg,var(--bg-elevated) 0%,var(--bg) 100%);
  position:relative;
  overflow:hidden;
}

.commitment-bg {
  position:absolute;
  top:-50%;
  right:-20%;
  width:600px;
  height:600px;
  border-radius:50%;
  background:radial-gradient(circle,rgba(37,99,235,.08) 0%,transparent 70%);
  pointer-events:none;
}

.commitment-content {
  position:relative;
  z-index:2;
  max-width:900px;
  margin:0 auto;
  text-align:center;
}

.commitment-text {
  font-size:1.4rem;
  font-weight:700;
  line-height:1.7;
  color:var(--text);
  margin-bottom:24px;
}

.commitment-sub {
  font-size:1.1rem;
  color:var(--muted);
  font-style:italic;
}

/* CTA Section */
.cta-section {
  padding:140px 34px;
  background:linear-gradient(135deg,var(--hero-bg) 0%,var(--hero-bg-deep) 100%);
  position:relative;
  overflow:hidden;
}

.cta-bg {
  position:absolute;
  inset:0;
  background-image:radial-gradient(circle at 20% 50%,rgba(37,99,235,.12) 0%,transparent 50%);
}

.cta-network {
  position:absolute;
  inset:0;
  background-image:
    radial-gradient(circle at 20% 30%,rgba(34,211,238,.1) 0%,transparent 40%),
    radial-gradient(circle at 80% 70%,rgba(37,99,235,.1) 0%,transparent 40%);
}

.cta-content {
  position:relative;
  z-index:2;
  max-width:900px;
  margin:0 auto;
  text-align:center;
  color:#fff;
}

.cta-title {
  font-size:clamp(2rem,5vw,3.5rem);
  font-weight:900;
  letter-spacing:-.04em;
  margin-bottom:24px;
}

.cta-description {
  font-size:1.2rem;
  line-height:1.7;
  color:rgba(255,255,255,.7);
  margin-bottom:40px;
  max-width:700px;
  margin-left:auto;
  margin-right:auto;
}

.cta-actions {
  display:flex;
  gap:16px;
  justify-content:center;
  flex-wrap:wrap;
}

/* Footer */
footer {
  background:var(--hero-bg);
  color:#fff;
  padding:60px 34px;
  border-top:1px solid var(--line);
}

.footer-content {
  max-width:1400px;
  margin:0 auto;
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
  gap:40px;
  align-items:start;
}

.footer-brand {
  font-weight:900;
  font-size:1.1rem;
  margin-bottom:16px;
  letter-spacing:-.04em;
}

.footer-tagline {
  color:rgba(255,255,255,.7);
  font-size:.9rem;
  margin:0 0 20px;
  line-height:1.6;
}

.footer-copyright {
  color:rgba(255,255,255,.5);
  font-size:.85rem;
}

.footer-heading {
  font-weight:700;
  font-size:.9rem;
  margin-bottom:16px;
  color:rgba(255,255,255,.9);
}

.footer-links {
  display:flex;
  flex-direction:column;
  gap:10px;
}

.footer-link {
  color:rgba(255,255,255,.7);
  font-size:.85rem;
  text-decoration:none;
}

.footer-link:hover {
  color:var(--accent-2);
}

/* Scroll Reveal */
.reveal {
  opacity:0;
  transform:translateY(12px);
  transition:opacity .55s ease,transform .55s ease;
}

.reveal.visible {
  opacity:1;
  transform:none;
}

/* Responsive */
@media (max-width:1200px) {
  .about-hero-content {
    grid-template-columns:1fr;
    gap: 60px;
  }
  .about-hero-visual {
    display:none;
  }
  .who-content {
    grid-template-columns: 1fr;
    gap: 60px;
  }
  .who-text {
    max-width: 800px;
    margin: 0 auto;
    text-align: center;
  }
  .who-text p {
    margin-inline: auto;
  }
  .who-highlights {
    justify-content: center;
    display: flex;
    flex-wrap: wrap;
  }
  .tech-ecosystem {
    max-width: 560px;
    margin: 0 auto;
  }
  .purpose-grid {
    grid-template-columns:1fr;
  }
  .values-grid {
    grid-template-columns:repeat(2,1fr);
  }
  .process-steps {
    grid-template-columns:repeat(2,1fr);
  }
  .process-steps::before {
    display:none;
  }
  .why-content {
    grid-template-columns:1fr;
  }
  .why-visual {
    display:none;
  }
}

@media (max-width:768px) {
  .about-hero {
    padding:100px 20px 80px;
  }
  .topbar {
    padding:0 20px;
  }
  .topbar nav {
    display:none;
  }
  .section {
    padding:60px 20px;
  }
  .who-we-are {
    padding: 80px 20px;
  }
  .tech-ecosystem {
    max-width: 440px;
  }
  .glass-panel {
    padding: 8px 12px;
  }
  .values-grid {
    grid-template-columns:1fr;
  }
  .process-steps {
    grid-template-columns:1fr;
  }
  .journey-item {
    flex-direction:column;
    align-items:center;
    text-align:center;
  }
  .capability-card {
    padding:24px;
  }
}

@media (max-width:480px) {
  .about-hero-title {
    font-size:2rem;
  }
  .about-hero-actions {
    flex-direction:column;
  }
  .about-hero-actions .btn {
    width:100%;
  }
  .tech-ecosystem {
    max-width: 320px;
    border-radius: 24px;
  }
  .panel-ai {
    display: none;
  }
  .cta-actions {
    flex-direction:column;
  }
  .cta-actions .btn {
    width:100%;
  }
}

@media (prefers-reduced-motion: reduce) {
  *,*::before,*::after {
    scroll-behavior:auto!important;
    animation-duration:.01ms!important;
    animation-iteration-count:1!important;
    transition-duration:.01ms!important;
  }
  .reveal {
    opacity:1;
    transform:none;
  }
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
    <a href="about.php" style="color:inherit;text-decoration:none;font-weight:700;font-size:.9rem;color:var(--accent)">About</a>
    <a href="portfolio.php" style="color:inherit;text-decoration:none;font-weight:600;font-size:.9rem;color:var(--muted)">Portfolio</a>
    <a href="contact.php" style="color:inherit;text-decoration:none;font-weight:600;font-size:.9rem;color:var(--muted)">Contact</a>
  </nav>
  <a href="contact.php" class="btn btn-primary" style="padding:10px 20px;font-size:.85rem">Start a Project</a>
  <button id="themeToggle" style="background:transparent;border:none;cursor:pointer;padding:8px;border-radius:8px" aria-label="Toggle theme">
    <svg class="icon" viewBox="0 0 24 24"><path d="M20.5 15.2A8.5 8.5 0 0 1 8.8 3.5 8.6 8.6 0 1 0 20.5 15.2Z"/></svg>
  </button>
</header>

<div class="main-area">
  <main id="main-content">
    <!-- About Hero -->
    <section class="about-hero" aria-labelledby="about-hero-title">
      <div class="about-hero-bg">
        <div class="about-hero-grid"></div>
        <div class="about-hero-glow"></div>
        <div class="about-hero-glow-2"></div>
      </div>
      <div class="about-hero-content">
        <div class="about-hero-text reveal">
          <div class="about-hero-eyebrow">About CARE Digital Solutions</div>
          <h1 id="about-hero-title" class="about-hero-title">Technology. Creativity. Solutions That Move Businesses Forward.</h1>
          <p class="about-hero-description">CARE Digital Solutions is a technology-driven and creative digital solutions brand focused on helping businesses and organizations strengthen their digital presence, improve operations, and communicate their value through innovative technology and creative services.</p>
          <div class="about-hero-actions">
            <a href="#who-we-are" class="btn btn-primary">Discover Our Story <svg class="icon" viewBox="0 0 24 24"><path d="M7 17 17 7M7 7h10v10"/></svg></a>
            <a href="services.php" class="btn btn-secondary">Explore Our Services <svg class="icon" viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
          </div>
          <div class="about-hero-trust">Digital Innovation • Creative Excellence • Business Growth</div>
        </div>
        <div class="about-hero-visual reveal">
          <div class="about-network">
            <div class="network-ring"></div>
            <div class="network-ring-2"></div>
            <div class="network-ring-3"></div>
            <div class="network-core"></div>
            <div class="network-node"></div>
            <div class="network-node"></div>
            <div class="network-node"></div>
            <div class="network-node"></div>
            <div class="network-node"></div>
          </div>
        </div>
      </div>
    </section>

    <!-- Who We Are — Premium Technology Showcase -->
    <section id="who-we-are" class="who-we-are" aria-labelledby="who-title">
      <div class="who-content">
        <div class="who-text reveal">
          <div class="section-eyebrow">Who We Are</div>
          <h3 id="who-title">Connecting Ideas with Meaningful Digital Solutions</h3>
          <p>CARE Digital Solutions brings technology, creativity, and business thinking together to help organizations establish a stronger digital presence and serve their customers more effectively.</p>
          <p>Our approach combines modern web technologies, software and AI solutions, graphic design, branding, printing, multimedia, and practical ICT services. We focus on understanding each client's needs and delivering solutions that are useful, professional, and designed to support long-term growth.</p>
          
          <div class="who-highlights">
            <div class="highlight">Technology-driven thinking</div>
            <div class="highlight">Creative and practical solutions</div>
            <div class="highlight">Client-focused delivery</div>
          </div>
        </div>

        <div class="who-visual reveal">
          <div class="tech-ecosystem">
            <div class="tech-bg-grid" data-depth="6"></div>
            <div class="tech-glow-spot tech-glow-1"></div>
            <div class="tech-glow-spot tech-glow-2"></div>
            
            <!-- Central Digital Core -->
            <svg class="tech-core-svg" data-depth="15" viewBox="0 0 500 500" aria-hidden="true" focusable="false">
              <defs>
                <radialGradient id="coreGlow" cx="50%" cy="50%" r="50%">
                  <stop offset="0%" stop-color="#00D4FF" stop-opacity="0.4"/>
                  <stop offset="60%" stop-color="#2563EB" stop-opacity="0.1"/>
                  <stop offset="100%" stop-color="#2563EB" stop-opacity="0"/>
                </radialGradient>
                <filter id="softBlur" x="-20%" y="-20%" width="140%" height="140%">
                  <feGaussianBlur stdDeviation="6"/>
                </filter>
              </defs>
              
              <!-- Connection Lines -->
              <g stroke="#00D4FF" stroke-width="0.8" stroke-opacity="0.2">
                <line x1="250" y1="250" x2="400" y2="100" />
                <line x1="250" y1="250" x2="100" y2="220" />
                <line x1="250" y1="250" x2="380" y2="400" />
              </g>
              
              <!-- Orbital Rings -->
              <circle cx="250" cy="250" r="140" fill="none" stroke="#2563EB" stroke-width="1" stroke-opacity="0.2" stroke-dasharray="4 8"/>
              <circle cx="250" cy="250" r="170" fill="none" stroke="#00D4FF" stroke-width="1" stroke-opacity="0.15" stroke-dasharray="2 12"/>
              
              <!-- Core Structure -->
              <circle cx="250" cy="250" r="100" fill="url(#coreGlow)"/>
              <circle cx="250" cy="250" r="70" fill="none" stroke="#00D4FF" stroke-width="1.5" stroke-opacity="0.4"/>
              
              <!-- Nodes -->
              <g fill="#00D4FF">
                <circle cx="250" cy="250" r="6" class="node-pulse"/>
                <circle cx="340" cy="180" r="4"/>
                <circle cx="160" cy="320" r="4" class="node-pulse" style="animation-delay:-1.5s"/>
                <circle cx="400" cy="100" r="3"/>
                <circle cx="100" cy="220" r="3"/>
                <circle cx="380" cy="400" r="3"/>
              </g>
            </svg>

            <!-- Surrounding Panels -->
            <div class="glass-panel panel-website" data-depth="10">
              <div class="panel-header">
                <span class="panel-icon"><svg class="icon" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="15" rx="2"/><path d="M8 22h8M12 19v3"/></svg></span>
                <span class="panel-title">Digital Experiences</span>
              </div>
              <div class="panel-visual">
                <span class="mini-bar" style="width:30%"></span>
                <span class="mini-bar" style="width:20%"></span>
                <span class="mini-bar" style="width:40%"></span>
              </div>
            </div>

            <div class="glass-panel panel-ai" data-depth="12">
              <div class="panel-header">
                <span class="panel-icon"><svg class="icon" viewBox="0 0 24 24"><path d="M12 2v20M2 12h20"/><circle cx="12" cy="12" r="9"/></svg></span>
                <span class="panel-title">Intelligent Solutions</span>
              </div>
              <div class="panel-visual">
                <svg width="60" height="20" viewBox="0 0 60 20">
                  <path d="M5 15 Q 15 5, 25 15 T 45 5" fill="none" stroke="var(--accent-2)" stroke-width="2" stroke-opacity="0.6"/>
                </svg>
              </div>
            </div>

            <div class="glass-panel panel-design" data-depth="8">
              <div class="panel-header">
                <span class="panel-icon"><svg class="icon" viewBox="0 0 24 24"><path d="M12 19l7-7 3 3-7 7-3-3z"/><path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"/><path d="m2 2 5 5"/></svg></span>
                <span class="panel-title">Creative Innovation</span>
              </div>
              <div class="panel-visual">
                <div style="display:flex;gap:4px">
                  <div style="width:12px;height:12px;border-radius:3px;background:var(--accent)"></div>
                  <div style="width:12px;height:12px;border-radius:3px;background:var(--accent-2)"></div>
                  <div style="width:12px;height:12px;border-radius:3px;background:var(--bg)"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Our Purpose -->
    <section class="section purpose-section" aria-labelledby="purpose-title">
      <div class="section-header">
        <div class="section-eyebrow">What Drives Us</div>
        <h2 id="purpose-title" class="section-title">Our Purpose</h2>
        <p class="section-description">The vision, mission, and purpose that guide everything we do.</p>
      </div>
      <div class="purpose-grid">
        <div class="purpose-card reveal">
          <div class="purpose-icon">
            <svg class="icon" viewBox="0 0 24 24" style="width:32px;height:32px"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2Z"/></svg>
          </div>
          <h3 class="purpose-title">Our Vision</h3>
          <p class="purpose-text">To become a trusted digital solutions partner empowering businesses and organizations through technology, creativity, and innovation.</p>
        </div>
        <div class="purpose-card reveal">
          <div class="purpose-icon">
            <svg class="icon" viewBox="0 0 24 24" style="width:32px;height:32px"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2Z"/></svg>
          </div>
          <h3 class="purpose-title">Our Mission</h3>
          <p class="purpose-text">To deliver accessible, reliable, and innovative digital and creative solutions that help our clients strengthen their brands, improve their operations, and achieve their goals.</p>
        </div>
        <div class="purpose-card reveal">
          <div class="purpose-icon">
            <svg class="icon" viewBox="0 0 24 24" style="width:32px;height:32px"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2Z"/></svg>
          </div>
          <h3 class="purpose-title">Our Purpose</h3>
          <p class="purpose-text">To connect ideas with practical solutions that create value, simplify work, and open new opportunities for growth.</p>
        </div>
      </div>
    </section>

    <!-- Core Values -->
    <section class="section values-section" aria-labelledby="values-title">
      <div class="section-header">
        <div class="section-eyebrow">Our Values</div>
        <h2 id="values-title" class="section-title">The Values Behind Every Solution</h2>
        <p class="section-description">The principles that guide our work and relationships.</p>
      </div>
      <div class="values-grid">
        <div class="value-card reveal">
          <div class="value-icon">
            <svg class="icon" viewBox="0 0 24 24" style="width:24px;height:24px"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2Z"/></svg>
          </div>
          <h3 class="value-title">Innovation</h3>
          <p class="value-description">We embrace new ideas and modern technologies to create meaningful solutions.</p>
        </div>
        <div class="value-card reveal">
          <div class="value-icon">
            <svg class="icon" viewBox="0 0 24 24" style="width:24px;height:24px"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2Z"/></svg>
          </div>
          <h3 class="value-title">Integrity</h3>
          <p class="value-description">We value honesty, responsibility, and transparency in our work.</p>
        </div>
        <div class="value-card reveal">
          <div class="value-icon">
            <svg class="icon" viewBox="0 0 24 24" style="width:24px;height:24px"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2Z"/></svg>
          </div>
          <h3 class="value-title">Quality</h3>
          <p class="value-description">We aim for thoughtful design, reliable functionality, and professional delivery.</p>
        </div>
        <div class="value-card reveal">
          <div class="value-icon">
            <svg class="icon" viewBox="0 0 24 24" style="width:24px;height:24px"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2Z"/></svg>
          </div>
          <h3 class="value-title">Customer Focus</h3>
          <p class="value-description">We listen carefully and work to understand each client's needs.</p>
        </div>
        <div class="value-card reveal">
          <div class="value-icon">
            <svg class="icon" viewBox="0 0 24 24" style="width:24px;height:24px"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2Z"/></svg>
          </div>
          <h3 class="value-title">Creativity</h3>
          <p class="value-description">We combine imagination and technical thinking to solve problems effectively.</p>
        </div>
        <div class="value-card reveal">
          <div class="value-icon">
            <svg class="icon" viewBox="0 0 24 24" style="width:24px;height:24px"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2Z"/></svg>
          </div>
          <h3 class="value-title">Continuous Improvement</h3>
          <p class="value-description">We keep learning, adapting, and refining our approach as technology evolves.</p>
        </div>
      </div>
    </section>

    <!-- Capabilities -->
    <section class="section capabilities-section" aria-labelledby="capabilities-title">
      <div class="section-header">
        <div class="section-eyebrow">Our Capabilities</div>
        <h2 id="capabilities-title" class="section-title">Where Technology Meets Creativity</h2>
        <p class="section-description">The main areas in which CARE Digital Solutions operates.</p>
      </div>
      <div class="capabilities-grid">
        <div class="capability-card reveal">
          <div class="capability-icon">
            <svg class="icon" viewBox="0 0 24 24" style="width:26px;height:26px"><rect x="3" y="4" width="18" height="15" rx="2"/><path d="M8 22h8M12 19v3M7 9h10M7 13h6"/></svg>
          </div>
          <h3 class="capability-title">Web Design and Development</h3>
          <p class="capability-description">Professional, responsive websites and digital experiences.</p>
        </div>
        <div class="capability-card reveal">
          <div class="capability-icon">
            <svg class="icon" viewBox="0 0 24 24" style="width:26px;height:26px"><path d="M12 20V10M18 20V4M6 20v-4"/></svg>
          </div>
          <h3 class="capability-title">Software Development and AI</h3>
          <p class="capability-description">Business-focused software, automation, and AI-enabled solutions.</p>
        </div>
        <div class="capability-card reveal">
          <div class="capability-icon">
            <svg class="icon" viewBox="0 0 24 24" style="width:26px;height:26px"><path d="M12 3v18M3 12h18"/><circle cx="12" cy="12" r="8"/><path d="m8 8 8 8m0-8-8 8"/></svg>
          </div>
          <h3 class="capability-title">Graphic Design and Branding</h3>
          <p class="capability-description">Visual identities and creative materials that help brands stand out.</p>
        </div>
        <div class="capability-card reveal">
          <div class="capability-icon">
            <svg class="icon" viewBox="0 0 24 24" style="width:26px;height:26px"><path d="M6 9V2h12V9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><path d="M6 14h12v8H6z"/></svg>
          </div>
          <h3 class="capability-title">Printing and Brand Production</h3>
          <p class="capability-description">Professional print materials and branded products.</p>
        </div>
        <div class="capability-card reveal">
          <div class="capability-icon">
            <svg class="icon" viewBox="0 0 24 24" style="width:26px;height:26px"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/></svg>
          </div>
          <h3 class="capability-title">Stationery and Business Essentials</h3>
          <p class="capability-description">Practical stationery and essential business supplies.</p>
        </div>
        <div class="capability-card reveal">
          <div class="capability-icon">
            <svg class="icon" viewBox="0 0 24 24" style="width:26px;height:26px"><path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"/></svg>
          </div>
          <h3 class="capability-title">ICT Support and Digital Services</h3>
          <p class="capability-description">Technology assistance and digital solutions for everyday business needs.</p>
        </div>
        <div class="capability-card reveal">
          <div class="capability-icon">
            <svg class="icon" viewBox="0 0 24 24" style="width:26px;height:26px"><rect x="2" y="2" width="20" height="20" rx="2.18" ry="2.18"/><line x1="7" y1="2" x2="7" y2="22"/><line x1="17" y1="2" x2="17" y2="22"/><line x1="2" y1="12" x2="22" y2="12"/><line x1="2" y1="7" x2="7" y2="7"/><line x1="2" y1="17" x2="7" y2="17"/><line x1="17" y1="17" x2="22" y2="17"/><line x1="17" y1="7" x2="22" y2="7"/></svg>
          </div>
          <h3 class="capability-title">Multimedia and Video Editing</h3>
          <p class="capability-description">Creative visual content for communication, marketing, and promotion.</p>
        </div>
      </div>
    </section>

    <!-- Our Approach -->
    <section class="section process-section" aria-labelledby="approach-title">
      <div class="process-bg"></div>
      <div class="process-content">
        <div class="section-header">
          <div class="section-eyebrow" style="color:var(--accent-2)">Our Approach</div>
          <h2 id="approach-title" class="section-title" style="color:#fff">How We Turn Ideas into Solutions</h2>
          <p class="section-description" style="color:rgba(255,255,255,.7)">A structured approach to delivering meaningful digital solutions.</p>
        </div>
        <div class="process-steps">
          <div class="process-step reveal">
            <div class="process-number">01</div>
            <h3 class="process-title">Understand</h3>
            <p class="process-description">We learn about the client's goals, challenges, and requirements.</p>
          </div>
          <div class="process-step reveal">
            <div class="process-number">02</div>
            <h3 class="process-title">Plan</h3>
            <p class="process-description">We define a practical direction and select suitable solutions.</p>
          </div>
          <div class="process-step reveal">
            <div class="process-number">03</div>
            <h3 class="process-title">Create</h3>
            <p class="process-description">We develop, design, or prepare the agreed solution with attention to quality.</p>
          </div>
          <div class="process-step reveal">
            <div class="process-number">04</div>
            <h3 class="process-title">Improve</h3>
            <p class="process-description">We review the result and identify opportunities for refinement and ongoing improvement.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Our Journey -->
    <section class="section journey-section" aria-labelledby="journey-title">
      <div class="journey-bg"></div>
      <div class="journey-content">
        <div class="section-header">
          <div class="section-eyebrow" style="color:var(--accent-2)">Our Direction</div>
          <h2 id="journey-title" class="section-title" style="color:#fff">Building Towards a Digital Future</h2>
          <p class="section-description" style="color:rgba(255,255,255,.7)">Strategic priorities shaping our growth and service development.</p>
        </div>
        <div class="journey-timeline">
          <div class="journey-item reveal">
            <div class="journey-marker">→</div>
            <div class="journey-content-text">
              <h3 class="journey-title">Building a Strong Digital Solutions Brand</h3>
              <p class="journey-description">Establishing CARE Digital Solutions as a recognized provider of technology and creative services.</p>
            </div>
          </div>
          <div class="journey-item reveal">
            <div class="journey-marker">→</div>
            <div class="journey-content-text">
              <h3 class="journey-title">Expanding Web and Software Development Capabilities</h3>
              <p class="journey-description">Strengthening our ability to deliver sophisticated digital applications and business systems.</p>
            </div>
          </div>
          <div class="journey-item reveal">
            <div class="journey-marker">→</div>
            <div class="journey-content-text">
              <h3 class="journey-title">Strengthening Creative Design and Branding Services</h3>
              <p class="journey-description">Enhancing our visual communication and brand identity offerings for businesses.</p>
            </div>
          </div>
          <div class="journey-item reveal">
            <div class="journey-marker">→</div>
            <div class="journey-content-text">
              <h3 class="journey-title">Supporting More Businesses with Practical Digital Tools</h3>
              <p class="journey-description">Extending our reach to help more organizations leverage technology effectively.</p>
            </div>
          </div>
          <div class="journey-item reveal">
            <div class="journey-marker">→</div>
            <div class="journey-content-text">
              <h3 class="journey-title">Exploring Responsible AI and Business Automation Opportunities</h3>
              <p class="journey-description">Investigating how emerging technologies can create practical value for our clients.</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Why Choose Us -->
    <section class="section why-section" aria-labelledby="why-title">
      <div class="why-bg"></div>
      <div class="why-content">
        <div class="why-text reveal">
          <div class="section-eyebrow" style="color:var(--accent-2)">Why Choose Us</div>
          <h3 id="why-title">A Practical Partner for Your Digital Growth</h3>
          <p>We bring together technology, creativity, and business thinking to help organizations navigate digital transformation with confidence.</p>
          <div class="why-benefits">
            <div class="benefit">Integrated Capabilities — Technology, creative design, branding, and business-focused services in one place.</div>
            <div class="benefit">Solutions Built Around Your Needs — An approach that starts with understanding the client's objectives.</div>
            <div class="benefit">Professional Presentation — Attention to detail, consistency, usability, and clear communication.</div>
            <div class="benefit">Forward-Thinking Mindset — A commitment to exploring useful technologies and improving the way businesses work.</div>
          </div>
        </div>
        <div class="why-visual reveal">
          <div class="why-network">
            <div class="why-node" style="top:20%;left:50%"></div>
            <div class="why-node" style="top:50%;right:20%"></div>
            <div class="why-node" style="bottom:20%;left:30%"></div>
            <div class="why-node" style="top:30%;left:30%"></div>
            <div class="why-node" style="top:60%;left:60%"></div>
            <div class="why-line" style="top:20%;left:50%;width:80px;transform:rotate(30deg)"></div>
            <div class="why-line" style="top:50%;right:20%;width:60px;transform:rotate(-45deg)"></div>
            <div class="why-line" style="bottom:20%;left:30%;width:100px;transform:rotate(15deg)"></div>
          </div>
        </div>
      </div>
    </section>

    <!-- Our Commitment -->
    <section class="section commitment-section" aria-labelledby="commitment-title">
      <div class="commitment-bg"></div>
      <div class="commitment-content reveal">
        <div class="section-eyebrow">Our Commitment</div>
        <h2 id="commitment-title" class="section-title">More Than Digital Services — A Commitment to Progress</h2>
        <p class="commitment-text">We believe meaningful digital solutions begin with understanding people and their goals. Our commitment is to combine thoughtful creativity, practical technology, and professional service to help our clients move forward with confidence.</p>
        <p class="commitment-sub">Every idea deserves a thoughtful approach. Every solution should serve a purpose.</p>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
      <div class="cta-bg"></div>
      <div class="cta-network"></div>
      <div class="cta-content">
        <h2 class="cta-title">Let's Build Something Meaningful Together.</h2>
        <p class="cta-description">Have an idea, a business challenge, or a digital project in mind? Let's explore how CARE Digital Solutions can help turn your goals into practical solutions.</p>
        <div class="cta-actions">
          <a href="contact.php" class="btn btn-primary">Start a Conversation <svg class="icon" viewBox="0 0 24 24"><path d="M7 17 17 7M7 7h10v10"/></svg></a>
          <a href="services.php" class="btn btn-secondary">Explore Our Services <svg class="icon" viewBox="0 0 24 24"><path d="M5 12h14M13 6l6 6-6 6"/></svg></a>
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
          <span class="footer-link" style="color:rgba(255,255,255,.7)">Tanzania</span>
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
  let lastScroll = 0;
  window.addEventListener("scroll", () => {
    const topbar = document.querySelector(".topbar");
    const currentScroll = window.pageYOffset;
    if (currentScroll > 50) {
      topbar.classList.add("scrolled");
    } else {
      topbar.classList.remove("scrolled");
    }
    lastScroll = currentScroll;
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

    // Who We Are — Subtle Parallax
    const whoSection = document.querySelector(".who-we-are");
    const whoVisual = document.querySelector(".who-visual");
    if (whoSection && whoVisual && window.matchMedia("(hover:hover) and (pointer:fine)").matches) {
      const parallaxLayers = whoVisual.querySelectorAll("[data-depth]");
      const reduceMotion = window.matchMedia("(prefers-reduced-motion: reduce)");
      let parallaxFrame = null;

      whoSection.addEventListener("mousemove", (event) => {
        if (reduceMotion.matches || parallaxFrame) return;
        parallaxFrame = window.requestAnimationFrame(() => {
          parallaxFrame = null;
          const rect = whoSection.getBoundingClientRect();
          const offsetX = (event.clientX - rect.left) / rect.width - 0.5;
          const offsetY = (event.clientY - rect.top) / rect.height - 0.5;
          
          parallaxLayers.forEach((layer) => {
            const depth = parseFloat(layer.dataset.depth) || 0;
            const x = -(offsetX * depth);
            const y = -(offsetY * depth);
            layer.style.transform = `translate3d(${x.toFixed(2)}px, ${y.toFixed(2)}px, 0)`;
          });
        });
      }, { passive: true });

      whoSection.addEventListener("mouseleave", () => {
        parallaxLayers.forEach((layer) => {
          layer.style.transform = "";
        });
      });
    }
  })();
</script>
</body>
</html>