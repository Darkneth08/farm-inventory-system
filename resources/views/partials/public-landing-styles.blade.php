:root {
    --landing-radius: 28px;
    --landing-shadow: 0 24px 70px rgba(6, 22, 12, .12);
}

@media (prefers-reduced-motion: no-preference) {
    html { scroll-behavior: smooth; }
}

body.public-landing-active {
    --pl-bg: #0d1711;
    --pl-bg-soft: #142018;
    --pl-panel: rgba(18, 29, 22, .82);
    --pl-panel-strong: rgba(19, 30, 23, .92);
    --pl-card: #122118;
    --pl-card-soft: #183124;
    --pl-line: rgba(207, 227, 213, .10);
    --pl-line-strong: rgba(207, 227, 213, .18);
    --pl-text: #e7efe9;
    --pl-soft: #b8c7bd;
    --pl-muted: #87988d;
    --pl-accent: #7fc347;
    --pl-accent-strong: #6bab3c;
    --pl-accent-soft: rgba(127, 195, 71, .16);
    --pl-surface-glow: rgba(127, 195, 71, .28);
    --pl-dark: #0d1711;
    --pl-footer: #112116;
    color: var(--pl-text);
    background:
        radial-gradient(1000px 700px at -10% 0%, rgba(127, 195, 71, .18), transparent 50%),
        radial-gradient(700px 500px at 100% 14%, rgba(113, 181, 200, .10), transparent 46%),
        linear-gradient(180deg, #0d1711 0%, #101a14 100%);
}

body.public-landing-active.public-theme-light {
    --pl-bg: #f5f4ee;
    --pl-bg-soft: #eef3e9;
    --pl-panel: rgba(255, 255, 255, .86);
    --pl-panel-strong: rgba(255, 255, 255, .96);
    --pl-card: #ffffff;
    --pl-card-soft: #f7f8f2;
    --pl-line: rgba(22, 53, 32, .08);
    --pl-line-strong: rgba(22, 53, 32, .16);
    --pl-text: #294033;
    --pl-soft: #627365;
    --pl-muted: #7b8d7e;
    --pl-accent: #5f9f2f;
    --pl-accent-strong: #4d8923;
    --pl-accent-soft: rgba(95, 159, 47, .12);
    --pl-surface-glow: rgba(95, 159, 47, .18);
    --pl-dark: #163520;
    --pl-footer: #15371f;
    background:
        radial-gradient(1000px 560px at -10% 0%, rgba(171, 205, 116, .18), transparent 50%),
        radial-gradient(760px 520px at 100% 14%, rgba(63, 121, 71, .07), transparent 46%),
        linear-gradient(180deg, #f7f5ef 0%, #eef3e8 100%);
}

#authSection.public-landing {
    display: block;
    max-width: none;
    min-height: 100vh;
    padding: 20px clamp(16px, 2.6vw, 34px) 36px;
    color: var(--pl-text);
}

#authSection.public-landing,
#authSection.public-landing * {
    box-sizing: border-box;
}

#authSection.public-landing a {
    color: inherit;
    text-decoration: none;
}

#authSection.public-landing [id] {
    scroll-margin-top: 112px;
}

#authSection.public-landing button {
    border: none;
    cursor: pointer;
    font: inherit;
}

#authSection.public-landing input,
#authSection.public-landing textarea,
#authSection.public-landing select {
    width: 100%;
    padding: 13px 15px;
    border-radius: 14px;
    border: 1px solid var(--pl-line-strong);
    background: var(--pl-card-soft);
    color: var(--pl-text);
}

#authSection.public-landing input::placeholder,
#authSection.public-landing textarea::placeholder {
    color: var(--pl-muted);
}

#authSection.public-landing input:focus,
#authSection.public-landing textarea:focus,
#authSection.public-landing select:focus {
    outline: none;
    border-color: rgba(95, 159, 47, .36);
    box-shadow: 0 0 0 4px rgba(95, 159, 47, .12);
}

#authSection.public-landing .field {
    display: grid;
    gap: 8px;
}

#authSection.public-landing .field label {
    font-size: 13px;
    font-weight: 700;
}

#authSection.public-landing .field small,
.auth-foot {
    color: var(--pl-muted);
    font-size: 12px;
}

#authSection.public-landing .password-wrap {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 10px;
    align-items: center;
}

.landing-shell {
    width: min(1240px, 100%);
    margin: 0 auto;
    display: grid;
    gap: 24px;
}

.landing-panel {
    position: relative;
    overflow: hidden;
    isolation: isolate;
    border: 1px solid var(--pl-line);
    border-radius: var(--landing-radius);
    background: var(--pl-panel);
    backdrop-filter: blur(18px);
    -webkit-backdrop-filter: blur(18px);
    box-shadow: var(--landing-shadow);
}

.landing-panel::before {
    content: "";
    position: absolute;
    inset: 0;
    pointer-events: none;
    background: linear-gradient(125deg, rgba(255, 255, 255, .18), rgba(255, 255, 255, 0) 26%), radial-gradient(circle at 82% 10%, rgba(141, 213, 99, .10), rgba(141, 213, 99, 0) 34%);
    opacity: .9;
    z-index: -1;
}

.landing-kicker,
.landing-mini-kicker {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    width: fit-content;
    padding: 8px 12px;
    border-radius: 999px;
    border: 1px solid rgba(95, 159, 47, .15);
    background: rgba(95, 159, 47, .10);
    color: var(--pl-accent-strong);
    font-size: 11px;
    font-weight: 800;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.landing-kicker::before,
.landing-mini-kicker::before {
    content: "";
    width: 8px;
    height: 8px;
    border-radius: 999px;
    background: currentColor;
    box-shadow: 0 0 0 6px rgba(95, 159, 47, .12);
}

.landing-mini-kicker {
    font-size: 10px;
    padding: 6px 10px;
}

.landing-nav {
    position: sticky;
    top: 12px;
    z-index: 12;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    padding: 16px 18px;
    background: color-mix(in srgb, var(--pl-panel-strong) 90%, transparent);
    box-shadow: 0 20px 38px rgba(13, 31, 20, .10);
}

.landing-nav::after {
    content: "";
    position: absolute;
    left: 18px;
    right: 18px;
    top: 0;
    height: 1px;
    background: linear-gradient(90deg, rgba(255, 255, 255, 0), rgba(141, 213, 99, .55), rgba(255, 255, 255, 0));
    opacity: .85;
}

.landing-brand {
    display: inline-flex;
    align-items: center;
    gap: 14px;
    min-width: 0;
}

.public-brand-emblem {
    position: relative;
    width: 52px;
    height: 52px;
    display: inline-grid;
    place-items: center;
    flex-shrink: 0;
}

.public-brand-emblem::before,
.public-brand-emblem::after {
    content: "";
    position: absolute;
    inset: -5px;
    border-radius: 18px;
    pointer-events: none;
}

.public-brand-emblem::before {
    border: 1px solid rgba(95, 159, 47, .24);
    opacity: .7;
    animation: logoOrbit 7s linear infinite;
}

.public-brand-emblem::after {
    inset: -10px;
    background: radial-gradient(circle, var(--pl-surface-glow), rgba(95, 159, 47, 0) 72%);
    opacity: .9;
    animation: logoPulse 3.6s ease-in-out infinite;
}

.public-brand-emblem svg {
    position: relative;
    width: 52px;
    height: 52px;
    display: block;
    border-radius: 16px;
    z-index: 1;
}

.landing-brand-copy {
    display: grid;
    gap: 4px;
    min-width: 0;
}

.landing-brand-copy strong {
    font-family: Sora, Manrope, sans-serif;
    font-size: 18px;
    line-height: 1.06;
}

.landing-brand-copy small {
    color: var(--pl-soft);
    font-size: 12px;
    line-height: 1.4;
}

.landing-nav-links,
.landing-nav-actions,
.landing-hero-actions,
.landing-hero-points,
.landing-footer-socials {
    display: flex;
    align-items: center;
    gap: 12px;
}

.landing-nav-links {
    justify-content: center;
    flex: 1 1 auto;
}

.landing-nav-links a {
    position: relative;
    color: var(--pl-soft);
    font-size: 13px;
    font-weight: 600;
    transition: color .18s ease, transform .18s ease;
}

.landing-nav-links a::after {
    content: "";
    position: absolute;
    left: 0;
    right: 0;
    bottom: -8px;
    height: 2px;
    border-radius: 999px;
    background: linear-gradient(90deg, rgba(141, 213, 99, 0), rgba(141, 213, 99, .9), rgba(141, 213, 99, 0));
    transform: scaleX(.35);
    opacity: 0;
    transition: transform .18s ease, opacity .18s ease;
}

.landing-nav-links a:hover {
    color: var(--pl-text);
    transform: translateY(-1px);
}

.landing-nav-links a:hover::after {
    transform: scaleX(1);
    opacity: 1;
}

.landing-theme-toggle,
.landing-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    min-height: 46px;
    border-radius: 14px;
    transition: transform .18s ease, box-shadow .18s ease, background .18s ease;
}

.landing-theme-toggle:hover,
.landing-btn:hover {
    transform: translateY(-1px);
}

.landing-theme-toggle {
    position: relative;
    width: 46px;
    min-width: 46px;
    padding: 0;
    border: 1px solid var(--pl-line-strong);
    background: rgba(255, 255, 255, .04);
    color: var(--pl-soft);
}

.landing-theme-toggle svg {
    width: 18px;
    height: 18px;
    stroke: currentColor;
    stroke-width: 1.8;
    fill: none;
}

#publicThemeLabel {
    position: absolute;
    width: 1px;
    height: 1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
}

.landing-btn {
    padding: 12px 18px;
    font-weight: 800;
    border: 1px solid transparent;
}

.landing-btn-primary {
    background: linear-gradient(135deg, var(--pl-accent-strong), var(--pl-accent));
    color: #f9fff6;
    box-shadow: 0 14px 28px rgba(95, 159, 47, .24);
}

body.public-theme-light .landing-btn-primary {
    color: #ffffff;
}

.landing-btn-secondary {
    background: rgba(255, 255, 255, .04);
    border-color: var(--pl-line-strong);
    color: var(--pl-text);
}

body.public-theme-light .landing-btn-secondary,
body.public-theme-light .landing-theme-toggle {
    background: rgba(255, 255, 255, .86);
}

.landing-btn-compact {
    min-height: 44px;
    padding: 10px 16px;
}

.landing-hero {
    display: grid;
    grid-template-columns: minmax(320px, .44fr) minmax(0, .56fr);
    gap: 30px;
    align-items: center;
    padding-top: 12px;
}

.landing-hero-copy,
.landing-section,
.landing-section-head,
.landing-why-card,
.landing-testimonials-card,
.landing-feature-card,
.landing-copyright,
.public-auth-card,
.auth-form {
    display: grid;
}

.landing-hero-copy {
    gap: 18px;
    align-content: center;
}

.landing-hero-copy h1,
.landing-section-head h2,
.landing-why-card h2,
.landing-testimonials-card h2,
.landing-cta-copy h2,
.public-auth-card h2 {
    margin: 0;
    font-family: Sora, Manrope, sans-serif;
    letter-spacing: -.04em;
}

.landing-hero-copy h1 {
    max-width: 11ch;
    font-size: clamp(38px, 4.7vw, 62px);
    line-height: .98;
}

.landing-hero-copy p,
.landing-section-head p,
.landing-feature-card p,
.landing-why-card p,
.landing-security-card p,
.landing-testimonial-card p,
.public-faq-answer,
.landing-cta-copy p,
.landing-footer a,
.landing-footer span,
.landing-footer-brand p,
.auth-head p {
    margin: 0;
    color: var(--pl-soft);
    line-height: 1.66;
}

.landing-hero-copy p {
    max-width: 34rem;
    font-size: 16px;
}

.landing-hero-points {
    flex-wrap: wrap;
    gap: 20px;
}

.landing-hero-points span {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    color: var(--pl-dark);
    font-size: 13px;
    font-weight: 700;
}

body.public-landing-active:not(.public-theme-light) .landing-hero-points span {
    color: var(--pl-text);
}

.landing-hero-points i {
    width: 18px;
    height: 18px;
    border-radius: 999px;
    border: 2px solid var(--pl-accent-strong);
    position: relative;
    display: inline-block;
}

.landing-hero-points i::after {
    content: "";
    position: absolute;
    left: 4px;
    top: 1px;
    width: 5px;
    height: 9px;
    border-right: 2px solid var(--pl-accent-strong);
    border-bottom: 2px solid var(--pl-accent-strong);
    transform: rotate(40deg);
}

.landing-hero-visual {
    --hero-spot-x: 52%;
    --hero-spot-y: 38%;
    --hero-tilt-x: 0deg;
    --hero-tilt-y: 0deg;
    position: relative;
    min-height: 548px;
    perspective: 2200px;
    perspective-origin: 56% 34%;
    transform-style: preserve-3d;
    isolation: isolate;
    overflow: visible;
    transform: rotateX(var(--hero-tilt-y)) rotateY(var(--hero-tilt-x));
    transition: transform .24s ease, filter .24s ease;
}

.landing-hero-visual::before,
.landing-hero-visual::after {
    content: "";
    position: absolute;
    pointer-events: none;
}

.landing-hero-visual::before {
    left: 8%;
    right: 8%;
    bottom: 6px;
    height: 96px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(18, 59, 33, .34), rgba(18, 59, 33, 0) 72%);
    filter: blur(18px);
    transform: translateZ(-120px) rotateX(82deg);
    opacity: .85;
}

.landing-hero-visual::after {
    inset: 9% 14% 16%;
    border-radius: 36px;
    background:
        linear-gradient(120deg, rgba(255, 255, 255, 0) 10%, rgba(255, 255, 255, .18) 28%, rgba(255, 255, 255, 0) 44%),
        radial-gradient(circle at var(--hero-spot-x) var(--hero-spot-y), rgba(152, 221, 108, .18), rgba(152, 221, 108, 0) 42%),
        radial-gradient(circle at 40% 26%, rgba(152, 221, 108, .12), rgba(152, 221, 108, 0) 54%);
    filter: blur(6px);
    opacity: .55;
    animation: stageSweep 8.6s ease-in-out infinite;
}

.landing-visual-glow,
.landing-flow-line {
    position: absolute;
    pointer-events: none;
}

.landing-visual-glow {
    border-radius: 50%;
    filter: blur(18px);
    opacity: .9;
}

.landing-visual-glow-a {
    width: 320px;
    height: 320px;
    right: 14%;
    top: 4%;
    background: radial-gradient(circle, rgba(127, 195, 71, .18), rgba(127, 195, 71, 0) 72%);
}

.landing-visual-glow-b {
    width: 220px;
    height: 220px;
    left: 10%;
    bottom: 2%;
    background: radial-gradient(circle, rgba(70, 121, 172, .12), rgba(70, 121, 172, 0) 72%);
}

.landing-flow-line {
    border: 1px solid rgba(95, 159, 47, .16);
    border-radius: 999px;
    overflow: hidden;
    opacity: .9;
}

.landing-flow-line::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, transparent 0%, rgba(95, 159, 47, .04) 25%, rgba(95, 159, 47, .55) 50%, rgba(95, 159, 47, .04) 75%, transparent 100%);
    background-size: 220px 100%;
    animation: flowTravel 4.8s linear infinite;
}

.landing-flow-line-a {
    width: 180px;
    height: 180px;
    right: 4%;
    top: 7%;
    transform: rotate(-18deg);
}

.landing-flow-line-b {
    width: 240px;
    height: 100px;
    left: 4%;
    bottom: 14%;
    transform: rotate(16deg);
}

.landing-flow-line-c {
    width: 160px;
    height: 160px;
    right: 18%;
    bottom: 4%;
    transform: rotate(8deg);
}

.landing-signal-ping {
    position: absolute;
    display: block;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    border: 1px solid rgba(141, 213, 99, .42);
    background: radial-gradient(circle, rgba(160, 224, 119, .95), rgba(141, 213, 99, .18) 58%, rgba(141, 213, 99, 0) 62%);
    box-shadow: 0 0 0 0 rgba(141, 213, 99, .28);
    animation: signalPulse 3.2s ease-in-out infinite;
    pointer-events: none;
}

.landing-signal-ping::before {
    content: "";
    position: absolute;
    inset: -14px;
    border-radius: 50%;
    border: 1px solid rgba(141, 213, 99, .18);
    animation: signalRing 3.2s ease-out infinite;
}

.landing-signal-ping-a {
    left: 18%;
    top: 22%;
}

.landing-signal-ping-b {
    right: 24%;
    top: 34%;
    animation-delay: .8s;
}

.landing-signal-ping-c {
    left: 42%;
    bottom: 16%;
    animation-delay: 1.4s;
}

[data-tilt] {
    --tilt-x: 50%;
    --tilt-y: 50%;
    position: relative;
    transform-style: preserve-3d;
    will-change: transform;
    transition: transform .24s ease, box-shadow .24s ease, border-color .24s ease;
}

[data-tilt]::after {
    content: "";
    position: absolute;
    inset: 1px;
    border-radius: inherit;
    background: radial-gradient(circle at var(--tilt-x) var(--tilt-y), rgba(145, 215, 92, .18), rgba(145, 215, 92, 0) 34%);
    opacity: 0;
    pointer-events: none;
    transition: opacity .24s ease;
}

[data-tilt].is-tilting::after,
[data-tilt]:hover::after {
    opacity: 1;
}
.landing-floating-logo,
.landing-laptop-mock,
.landing-phone-hero {
    position: absolute;
    transform-style: preserve-3d;
}

.landing-floating-logo {
    top: 10px;
    right: 34px;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    border-radius: 18px;
    border: 1px solid rgba(95, 159, 47, .18);
    background: rgba(255, 255, 255, .78);
    box-shadow: 0 18px 34px rgba(17, 53, 32, .10), 0 0 0 1px rgba(255, 255, 255, .38) inset;
    backdrop-filter: blur(18px);
    animation: floatLogo 5.8s ease-in-out infinite;
}

.landing-floating-logo::before {
    content: "";
    position: absolute;
    inset: -10px;
    border-radius: 24px;
    background: radial-gradient(circle, rgba(145, 215, 92, .22), rgba(145, 215, 92, 0) 68%);
    filter: blur(14px);
    z-index: -1;
    animation: logoHalo 4.8s ease-in-out infinite;
}

body.public-landing-active:not(.public-theme-light) .landing-floating-logo {
    background: rgba(19, 30, 23, .92);
}

.landing-floating-logo strong {
    font-size: 13px;
    color: var(--pl-text);
}

.landing-floating-logo small {
    display: block;
    margin-top: 2px;
    font-size: 11px;
    color: var(--pl-soft);
}

.landing-floating-emblem {
    width: 42px;
    height: 42px;
}

.landing-floating-emblem svg {
    width: 42px;
    height: 42px;
    filter: drop-shadow(0 8px 16px rgba(95, 159, 47, .28));
}

.landing-laptop-mock {
    left: 8%;
    right: 16%;
    top: 70px;
    transform-origin: 50% 100%;
    transform: translateZ(12px) rotateX(18deg) rotateY(-21deg) rotateZ(1deg);
    animation: floatDevice 7.1s cubic-bezier(.42, 0, .2, 1) infinite;
    will-change: transform;
}

.landing-laptop-mock::before {
    content: "";
    position: absolute;
    left: 4%;
    right: 0;
    bottom: -26px;
    height: 42px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(8, 24, 13, .42), rgba(8, 24, 13, 0) 72%);
    filter: blur(18px);
    transform: translateZ(-90px) rotateX(83deg);
    z-index: -1;
    pointer-events: none;
}

.landing-laptop-lid {
    position: relative;
    padding: 12px 12px 18px;
    border-radius: 32px 32px 22px 22px;
    background: linear-gradient(145deg, #0a130f, #16211b 54%, #1d2b24 100%);
    box-shadow: 0 38px 76px rgba(17, 53, 32, .24), inset 0 1px 0 rgba(255, 255, 255, .05);
    transform: translateZ(40px);
}

.landing-laptop-lid::before {
    content: "";
    position: absolute;
    inset: 1px;
    border-radius: inherit;
    border: 1px solid rgba(255, 255, 255, .05);
    pointer-events: none;
}

.landing-laptop-camera {
    position: absolute;
    top: 7px;
    left: 50%;
    width: 64px;
    height: 12px;
    border-radius: 999px;
    transform: translateX(-50%);
    background: linear-gradient(180deg, rgba(6, 12, 9, .96), rgba(32, 44, 36, .88));
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .06);
}

.landing-laptop-camera::before {
    content: "";
    position: absolute;
    left: 50%;
    top: 50%;
    width: 7px;
    height: 7px;
    border-radius: 50%;
    transform: translate(-50%, -50%);
    background: radial-gradient(circle at 35% 35%, #8fd06c, #13261a 72%);
    box-shadow: 0 0 8px rgba(143, 208, 108, .28);
}

.landing-laptop-screen {
    position: relative;
    overflow: hidden;
    margin-top: 10px;
    padding: 14px 16px 18px;
    border-radius: 24px 24px 18px 18px;
    border: 1px solid rgba(11, 18, 15, .14);
    background: linear-gradient(180deg, rgba(255, 255, 255, .98), rgba(247, 249, 244, .94));
    box-shadow: 0 26px 46px rgba(0, 0, 0, .18);
    backface-visibility: hidden;
}

.landing-laptop-screen::before {
    content: "";
    position: absolute;
    inset: 0;
    background:
        linear-gradient(118deg, rgba(255, 255, 255, 0) 10%, rgba(255, 255, 255, .42) 28%, rgba(255, 255, 255, .06) 42%, rgba(255, 255, 255, 0) 54%),
        linear-gradient(135deg, rgba(255, 255, 255, .18), transparent 34%, transparent 70%, rgba(95, 159, 47, .08));
    pointer-events: none;
    background-size: 180% 180%, auto;
    animation: screenSheen 7.4s ease-in-out infinite;
}

.landing-laptop-screen::after {
    content: "";
    position: absolute;
    left: 8%;
    right: 8%;
    bottom: 10px;
    height: 2px;
    border-radius: 999px;
    background: linear-gradient(90deg, rgba(255, 255, 255, 0), rgba(138, 212, 97, .36), rgba(255, 255, 255, 0));
    opacity: .7;
    pointer-events: none;
}

.landing-laptop-hinge {
    width: 32%;
    height: 11px;
    margin: -2px auto 0;
    border-radius: 999px;
    background: linear-gradient(180deg, #79807b, #3d4540 48%, #181e1b);
    box-shadow: 0 10px 18px rgba(12, 20, 16, .22);
    transform: translateZ(18px);
}

.landing-laptop-base {
    position: relative;
    display: grid;
    grid-template-columns: 54px 1fr 54px;
    grid-template-rows: 56px 32px;
    align-items: stretch;
    gap: 12px 16px;
    width: 116%;
    min-height: 128px;
    margin: -2px auto 0;
    padding: 18px 24px 18px;
    border-radius: 18px 18px 34px 34px;
    background: linear-gradient(180deg, #d6dad7 0%, #afb4af 28%, #8e938e 72%, #7d817d 100%);
    transform: translateX(-7%) translateZ(-18px) rotateX(76deg);
    box-shadow: 0 24px 44px rgba(18, 35, 25, .26);
    overflow: hidden;
}

.landing-laptop-base::before {
    content: "";
    position: absolute;
    inset: 0;
    background:
        linear-gradient(180deg, rgba(255, 255, 255, .38), rgba(255, 255, 255, 0) 22%),
        radial-gradient(circle at 50% -10%, rgba(255, 255, 255, .24), rgba(255, 255, 255, 0) 54%);
    pointer-events: none;
}

.landing-laptop-base::after {
    content: "";
    position: absolute;
    left: 50%;
    bottom: 8px;
    width: 28%;
    height: 4px;
    border-radius: 999px;
    transform: translateX(-50%);
    background: rgba(73, 78, 74, .42);
}

.landing-laptop-keyboard {
    grid-column: 2;
    grid-row: 1;
    position: relative;
    border-radius: 14px;
    background: linear-gradient(180deg, #535954, #2c312e 100%);
    box-shadow: inset 0 2px 3px rgba(255, 255, 255, .08), inset 0 -2px 4px rgba(0, 0, 0, .24), 0 10px 18px rgba(0, 0, 0, .14);
}

.landing-laptop-keyboard::before {
    content: "";
    position: absolute;
    inset: 10px 10px 8px;
    border-radius: 10px;
    background:
        repeating-linear-gradient(90deg, rgba(225, 231, 226, .2) 0 1px, transparent 1px 15px),
        repeating-linear-gradient(180deg, rgba(225, 231, 226, .16) 0 1px, transparent 1px 12px),
        linear-gradient(180deg, rgba(61, 67, 63, .96), rgba(35, 40, 37, .98));
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .08);
}

.landing-laptop-trackpad {
    grid-column: 2;
    grid-row: 2;
    justify-self: center;
    width: 38%;
    border-radius: 10px;
    background: linear-gradient(180deg, rgba(205, 211, 206, .92), rgba(151, 157, 152, .98));
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .45), inset 0 -2px 3px rgba(0, 0, 0, .10);
}

.landing-laptop-speaker {
    grid-row: 1 / span 2;
    border-radius: 12px;
    background:
        radial-gradient(circle, rgba(56, 60, 58, .65) 0 1px, transparent 1px 7px),
        linear-gradient(180deg, rgba(167, 172, 167, .9), rgba(124, 129, 124, .92));
    background-size: 8px 8px, auto;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .3), inset 0 -1px 2px rgba(0, 0, 0, .12);
}

.landing-laptop-speaker-left {
    grid-column: 1;
}

.landing-laptop-speaker-right {
    grid-column: 3;
}

.landing-device-topbar,
.landing-device-brand,
.landing-phone-brand {
    display: flex;
    align-items: center;
    gap: 8px;
}

.landing-device-topbar {
    justify-content: space-between;
    margin-bottom: 14px;
    padding: 10px 14px;
    border-radius: 14px;
    background: #143a22;
    color: #f7fff6;
}

.landing-device-meta {
    display: flex;
    align-items: center;
    gap: 10px;
}

.landing-live-time {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 74px;
    padding: 6px 10px;
    border-radius: 999px;
    border: 1px solid rgba(255, 255, 255, .16);
    background: rgba(255, 255, 255, .12);
    color: #f7fff6;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: .04em;
    line-height: 1;
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .18);
}

.landing-device-brand span,
.landing-phone-brand span {
    width: 18px;
    height: 18px;
    border-radius: 6px;
    background: linear-gradient(135deg, #81c145, #4d8923);
    box-shadow: 0 0 0 4px rgba(129, 193, 69, .18);
}

.landing-device-brand strong,
.landing-phone-brand strong {
    font-size: 12px;
}

.landing-device-user span {
    width: 18px;
    height: 18px;
    border-radius: 999px;
    border: 2px solid rgba(255, 255, 255, .84);
    position: relative;
    display: block;
}

.landing-device-user span::before {
    content: "";
    position: absolute;
    left: 50%;
    top: 3px;
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: rgba(255, 255, 255, .84);
    transform: translateX(-50%);
}

.landing-device-user span::after {
    content: "";
    position: absolute;
    left: 50%;
    bottom: 2px;
    width: 10px;
    height: 5px;
    border-radius: 8px 8px 4px 4px;
    border: 2px solid rgba(255, 255, 255, .84);
    border-top: none;
    transform: translateX(-50%);
}

.landing-device-greeting {
    display: grid;
    gap: 4px;
    margin-bottom: 16px;
}

.landing-device-greeting strong {
    font-size: 28px;
    color: #183120;
}

.landing-device-greeting small {
    color: #6d7d71;
    font-size: 13px;
}

.landing-device-grid {
    position: relative;
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 12px;
}

.landing-device-grid::before,
.landing-device-grid::after {
    content: "";
    position: absolute;
    inset: 18% 12%;
    border: 1px dashed rgba(95, 159, 47, .20);
    border-radius: 22px;
    pointer-events: none;
}

.landing-device-grid::after {
    inset: 32% 22%;
    animation: orbitPulse 3.8s ease-in-out infinite;
}

.landing-device-tile {
    display: grid;
    justify-items: center;
    gap: 10px;
    min-height: 132px;
    padding: 18px 12px;
    border-radius: 18px;
    border: 1px solid rgba(22, 53, 32, .10);
    background: rgba(255, 255, 255, .96);
    text-align: center;
    box-shadow: 0 16px 28px rgba(21, 53, 32, .08);
    transform: translateZ(24px);
    animation: tileBreath 5.8s ease-in-out infinite;
}

.landing-device-tile:nth-child(2n) {
    transform: translateZ(32px) translateY(-2px);
    animation-delay: -.9s;
}

.landing-device-tile:nth-child(3n) {
    animation-delay: -1.6s;
}

.landing-device-tile strong {
    font-size: 15px;
    color: #163520;
}

.landing-device-tile small {
    color: #6d7d71;
    font-size: 12px;
    line-height: 1.45;
}

.landing-device-icon,
.landing-feature-icon {
    position: relative;
    width: 56px;
    height: 56px;
    display: inline-grid;
    place-items: center;
    border-radius: 16px;
    background: linear-gradient(180deg, rgba(230, 241, 218, .98), rgba(216, 234, 199, .92));
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .85), 0 10px 18px rgba(95, 159, 47, .10);
}

.landing-device-icon::before,
.landing-device-icon::after,
.landing-feature-icon::before,
.landing-feature-icon::after {
    content: "";
    position: absolute;
}

.landing-icon-box::before,
.landing-icon-box::after {
    width: 22px;
    height: 16px;
    border: 2px solid #587635;
    border-radius: 4px;
}

.landing-icon-box::before {
    top: 20px;
    left: 17px;
}

.landing-icon-box::after {
    width: 18px;
    height: 8px;
    left: 19px;
    top: 14px;
    transform: skew(-12deg);
    background: rgba(88, 118, 53, .16);
}

.landing-icon-clipboard::before {
    width: 22px;
    height: 28px;
    left: 17px;
    top: 14px;
    border: 2px solid #587635;
    border-radius: 5px;
}

.landing-icon-clipboard::after {
    width: 12px;
    height: 6px;
    left: 22px;
    top: 10px;
    border: 2px solid #587635;
    border-bottom: none;
    border-radius: 8px 8px 0 0;
}

.landing-icon-bell::before {
    width: 22px;
    height: 20px;
    left: 17px;
    top: 16px;
    border: 2px solid #587635;
    border-radius: 12px 12px 8px 8px;
}

.landing-icon-bell::after {
    width: 8px;
    height: 8px;
    left: 24px;
    bottom: 12px;
    border-radius: 50%;
    background: #587635;
}

.landing-icon-users::before {
    width: 10px;
    height: 10px;
    left: 17px;
    top: 16px;
    border-radius: 50%;
    background: #587635;
    box-shadow: 16px 0 0 #587635;
}

.landing-icon-users::after {
    width: 30px;
    height: 12px;
    left: 13px;
    top: 30px;
    border-radius: 12px 12px 8px 8px;
    background: rgba(88, 118, 53, .24);
    border: 2px solid #587635;
}

.landing-icon-branch::before {
    left: 15px;
    top: 18px;
    width: 26px;
    height: 18px;
    border: 2px solid #587635;
    border-top: none;
    border-radius: 0 0 4px 4px;
}

.landing-icon-branch::after {
    left: 13px;
    top: 12px;
    width: 30px;
    height: 16px;
    clip-path: polygon(50% 0, 100% 100%, 0 100%);
    background: rgba(88, 118, 53, .28);
    border-top: 2px solid #587635;
}

.landing-icon-report::before {
    width: 22px;
    height: 28px;
    left: 18px;
    top: 14px;
    border: 2px solid #587635;
    border-radius: 4px;
}

.landing-icon-report::after {
    width: 10px;
    height: 10px;
    right: 16px;
    top: 14px;
    clip-path: polygon(0 0, 100% 0, 100% 100%);
    background: rgba(88, 118, 53, .28);
}

.landing-phone-hero {
    right: 1%;
    bottom: 58px;
    width: 176px;
    padding: 10px;
    border-radius: 26px;
    background: linear-gradient(180deg, #0d1411, #1a241d);
    box-shadow: 0 26px 56px rgba(16, 39, 22, .30), 0 0 0 1px rgba(255, 255, 255, .06) inset;
    transform-origin: 50% 100%;
    transform: translateZ(88px) rotateX(6deg) rotateY(-28deg) rotateZ(6deg);
    animation: floatPhone 6.4s cubic-bezier(.42, 0, .2, 1) infinite;
    will-change: transform;
}

.landing-phone-hero::before {
    content: "";
    position: absolute;
    left: 8%;
    right: 8%;
    bottom: -18px;
    height: 28px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(8, 24, 13, .34), rgba(8, 24, 13, 0) 70%);
    filter: blur(16px);
    transform: translateZ(-70px) rotateX(84deg);
    z-index: -1;
    pointer-events: none;
}

.landing-phone-hero::after {
    content: "";
    position: absolute;
    inset: 8px;
    border-radius: 20px;
    background: linear-gradient(120deg, rgba(255, 255, 255, 0) 10%, rgba(255, 255, 255, .24) 34%, rgba(255, 255, 255, 0) 54%);
    opacity: .55;
    mix-blend-mode: screen;
    pointer-events: none;
    animation: phoneShine 6.8s ease-in-out infinite;
}

.landing-phone-notch {
    position: absolute;
    top: 8px;
    left: 50%;
    width: 74px;
    height: 8px;
    border-radius: 999px;
    background: rgba(255, 255, 255, .14);
    transform: translateX(-50%);
}

.landing-phone-screen {
    position: relative;
    overflow: hidden;
    padding: 18px 12px 14px;
    border-radius: 20px;
    background: linear-gradient(180deg, #fdfefd, #f4f7f1);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .92);
}

.landing-phone-screen::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(140deg, rgba(255, 255, 255, .24), rgba(255, 255, 255, 0) 34%);
    pointer-events: none;
}

.landing-phone-brand {
    justify-content: space-between;
    margin-bottom: 14px;
    color: #183120;
    font-size: 11px;
}

.landing-phone-brand strong {
    flex: 1;
}

.landing-live-time-phone {
    min-width: 0;
    padding: 5px 8px;
    border-color: rgba(88, 118, 53, .14);
    background: rgba(129, 193, 69, .12);
    color: #30511c;
    font-size: 10px;
}

.landing-phone-greeting {
    display: grid;
    gap: 3px;
    margin-bottom: 12px;
}

.landing-phone-greeting strong {
    color: #183120;
    font-size: 16px;
}

.landing-phone-greeting small {
    color: #6d7d71;
    font-size: 11px;
}

.landing-phone-menu {
    display: grid;
    gap: 8px;
}

.landing-phone-menu div {
    display: grid;
    grid-template-columns: 24px 1fr;
    align-items: center;
    gap: 8px;
    padding: 8px 10px;
    border-radius: 12px;
    background: #ffffff;
    border: 1px solid rgba(22, 53, 32, .10);
    color: #183120;
    font-size: 11px;
    font-weight: 700;
}

.landing-phone-menu span {
    width: 24px;
    height: 24px;
    border-radius: 8px;
    background: linear-gradient(180deg, rgba(230, 241, 218, .98), rgba(216, 234, 199, .92));
}

.landing-trust-row,
.landing-logo-strip,
.landing-feature-grid,
.landing-showcase,
.landing-faq-grid,
.landing-footer {
    display: grid;
}

.landing-trust-row {
    gap: 18px;
    padding: 8px 0 2px;
}

.landing-trust-label {
    justify-self: center;
    color: var(--pl-muted);
    font-size: 12px;
    font-weight: 800;
    letter-spacing: .09em;
    text-transform: uppercase;
}

.landing-logo-strip {
    grid-template-columns: repeat(5, minmax(0, 1fr));
    gap: 16px;
}

.landing-logo-item {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 12px 10px;
    color: var(--pl-muted);
    font-weight: 800;
    text-transform: uppercase;
    transition: transform .2s ease, color .2s ease;
    letter-spacing: .02em;
}

.landing-logo-item:hover {
    color: var(--pl-text);
    transform: translateY(-2px);
}

.landing-logo-item span {
    display: inline-grid;
    place-items: center;
    width: 32px;
    height: 32px;
    border-radius: 10px;
    border: 1px solid var(--pl-line-strong);
    background: rgba(255, 255, 255, .04);
    font-size: 11px;
}

.landing-section {
    gap: 18px;
}

.landing-section-head {
    gap: 10px;
}

.landing-section-head-center {
    justify-items: center;
    text-align: center;
}

.landing-section-head h2,
.landing-why-card h2,
.landing-testimonials-card h2,
.landing-cta-copy h2 {
    font-size: clamp(34px, 3.8vw, 48px);
    line-height: 1.02;
}

.landing-section-head p {
    max-width: 38rem;
}

.landing-feature-grid {
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 16px;
}

.landing-feature-card,
.landing-testimonial-card,
.public-faq-item {
    gap: 16px;
    padding: 20px;
    border-radius: 20px;
    border: 1px solid var(--pl-line-strong);
    background: var(--pl-card);
}

.landing-feature-card {
    grid-template-columns: 56px 1fr;
    align-items: start;
}

.landing-feature-card h3 {
    margin: 0 0 6px;
    font-size: 22px;
    line-height: 1.08;
    font-family: Sora, Manrope, sans-serif;
}
.landing-showcase {
    grid-template-columns: minmax(0, .95fr) minmax(0, 1.05fr) minmax(0, .95fr);
    gap: 18px;
    align-items: start;
}

.landing-why-card,
.landing-testimonials-card,
.landing-scene-card {
    gap: 18px;
    padding: 22px;
    background: var(--pl-panel-strong);
}

.landing-check-list {
    list-style: none;
    display: grid;
    gap: 12px;
    padding: 0;
    margin: 0;
}

.landing-check-list li {
    position: relative;
    padding-left: 28px;
    color: var(--pl-dark);
    font-size: 15px;
    font-weight: 600;
}

body.public-landing-active:not(.public-theme-light) .landing-check-list li {
    color: var(--pl-text);
}

.landing-check-list li::before {
    content: "";
    position: absolute;
    left: 0;
    top: 4px;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--pl-accent-strong), var(--pl-accent));
    box-shadow: 0 0 0 6px rgba(95, 159, 47, .10);
}

.landing-check-list li::after {
    content: "";
    position: absolute;
    left: 6px;
    top: 7px;
    width: 5px;
    height: 9px;
    border-right: 2px solid #ffffff;
    border-bottom: 2px solid #ffffff;
    transform: rotate(40deg);
}

.landing-security-card {
    display: grid;
    grid-template-columns: 56px 1fr;
    gap: 14px;
    padding: 16px;
    border-radius: 18px;
    border: 1px solid var(--pl-line-strong);
    background: var(--pl-card);
}

.landing-security-icon {
    position: relative;
    width: 56px;
    height: 56px;
    border-radius: 16px;
    background: linear-gradient(180deg, rgba(230, 241, 218, .98), rgba(216, 234, 199, .92));
}

.landing-security-icon::before {
    content: "";
    position: absolute;
    left: 15px;
    top: 12px;
    width: 26px;
    height: 30px;
    clip-path: polygon(50% 0%, 100% 18%, 100% 58%, 50% 100%, 0% 58%, 0% 18%);
    background: #587635;
}

.landing-security-card strong {
    font-size: 16px;
    color: var(--pl-text);
}

.landing-scene-card {
    position: relative;
    overflow: hidden;
    border-radius: 26px;
}

.landing-scene-stage {
    position: relative;
    min-height: 328px;
    overflow: hidden;
    border-radius: 22px;
    background: linear-gradient(180deg, #e5efd2 0%, #e9f2d9 34%, #d8e7b7 100%);
}

.landing-scene-stage > span {
    position: absolute;
    display: block;
}

.landing-scene-orbit {
    border: 1px solid rgba(95, 159, 47, .18);
    border-radius: 50%;
}

.landing-scene-orbit-a {
    width: 280px;
    height: 280px;
    right: -30px;
    top: -30px;
    animation: orbitSpin 14s linear infinite;
}

.landing-scene-orbit-b {
    width: 240px;
    height: 120px;
    left: -24px;
    bottom: 26px;
    transform: rotate(-12deg);
}

.landing-scene-cloud {
    background: rgba(255, 255, 255, .68);
    border-radius: 999px;
}

.landing-scene-cloud-a { width: 82px; height: 26px; left: 32px; top: 36px; }
.landing-scene-cloud-b { width: 64px; height: 22px; right: 52px; top: 58px; }
.landing-scene-sun {
    width: 58px;
    height: 58px;
    right: 76px;
    top: 36px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(246, 226, 132, .92), rgba(246, 226, 132, .25) 68%, rgba(246, 226, 132, 0) 72%);
}

.landing-scene-hill-back {
    left: -10%;
    right: 34%;
    bottom: 86px;
    height: 110px;
    border-radius: 999px 999px 0 0;
    background: #97b66a;
}

.landing-scene-hill-front {
    left: 22%;
    right: -12%;
    bottom: 70px;
    height: 126px;
    border-radius: 999px 999px 0 0;
    background: #789a49;
}

.landing-field-line {
    height: 2px;
    left: 0;
    right: 0;
    background: linear-gradient(90deg, rgba(126, 160, 82, .10), rgba(86, 117, 47, .46), rgba(126, 160, 82, .10));
    animation: fieldGlow 5.2s ease-in-out infinite;
}

.landing-field-line-a { bottom: 86px; transform: skewY(-10deg); }
.landing-field-line-b { bottom: 68px; transform: skewY(-8deg); animation-delay: .6s; }
.landing-field-line-c { bottom: 50px; transform: skewY(-6deg); animation-delay: 1.2s; }

.landing-scene-silo {
    bottom: 110px;
    width: 38px;
    border-radius: 18px 18px 8px 8px;
    background: linear-gradient(180deg, #d3dfcc, #afc19d);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .7);
}

.landing-scene-silo-a { left: 48px; height: 94px; }
.landing-scene-silo-b { left: 92px; height: 118px; }

.landing-scene-barn {
    left: 110px;
    right: 82px;
    bottom: 88px;
    height: 112px;
    border-radius: 10px;
    background: linear-gradient(180deg, #607d60, #405c48);
    box-shadow: inset 0 2px 0 rgba(255, 255, 255, .18), 0 16px 30px rgba(43, 73, 47, .16);
}

.landing-scene-barn::before {
    content: "";
    position: absolute;
    left: -18px;
    right: -18px;
    top: -52px;
    height: 62px;
    clip-path: polygon(50% 0, 100% 100%, 0 100%);
    background: linear-gradient(180deg, #7b9480, #576e5d);
}

.landing-scene-door {
    left: 208px;
    bottom: 88px;
    width: 72px;
    height: 82px;
    border-radius: 8px 8px 0 0;
    background: linear-gradient(180deg, #314d39, #263c2d);
}

.landing-scene-sign {
    left: 248px;
    bottom: 166px;
    width: 64px;
    height: 24px;
    border-radius: 6px;
    background: linear-gradient(180deg, #e9deb0, #d3c37c);
    box-shadow: 0 8px 16px rgba(24, 53, 32, .12);
}

.landing-scene-sign::after {
    content: "Farm Supply";
    position: absolute;
    inset: 0;
    display: grid;
    place-items: center;
    color: #36532f;
    font-size: 8px;
    font-weight: 800;
    letter-spacing: .08em;
    text-transform: uppercase;
}

.landing-scene-tree {
    bottom: 108px;
    width: 26px;
    border-radius: 18px 18px 10px 10px;
    background: linear-gradient(180deg, #7fb64a, #5d8c34);
}

.landing-scene-tree-a { right: 52px; height: 88px; }
.landing-scene-tree-b { right: 20px; height: 58px; }

.landing-scene-metrics {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 12px;
}

.landing-scene-metrics article {
    padding: 14px 12px;
    border-radius: 18px;
    background: var(--pl-card);
    border: 1px solid var(--pl-line-strong);
}

.landing-scene-metrics strong {
    display: block;
    font-family: Sora, Manrope, sans-serif;
    font-size: 34px;
    line-height: 1;
    color: var(--pl-accent-strong);
}

.landing-scene-metrics span {
    display: block;
    margin-top: 8px;
    color: var(--pl-soft);
    font-size: 13px;
    line-height: 1.45;
}

.landing-testimonials-card {
    gap: 16px;
}

.landing-testimonial-grid {
    display: grid;
    gap: 12px;
}

.landing-stars {
    color: #f5b01b;
    letter-spacing: .15em;
    font-size: 16px;
}

.landing-testimonial-meta {
    display: grid;
    gap: 3px;
}

.landing-testimonial-meta strong,
.landing-footer strong,
.landing-cta-copy h2,
.public-auth-card h2,
.landing-security-card strong {
    color: var(--pl-text);
}

.landing-testimonial-meta small {
    color: var(--pl-muted);
    font-size: 12px;
}

.landing-faq-section {
    gap: 16px;
}

.landing-faq-grid {
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 14px;
}

.public-faq-item {
    padding: 0;
    overflow: hidden;
}

.public-faq-question {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 18px 20px;
    background: transparent;
    color: var(--pl-text);
    font-family: Sora, Manrope, sans-serif;
    font-size: 17px;
    font-weight: 600;
    text-align: left;
}

.public-faq-icon {
    display: inline-grid;
    place-items: center;
    width: 34px;
    height: 34px;
    border-radius: 10px;
    background: rgba(95, 159, 47, .10);
    color: var(--pl-accent-strong);
    font-size: 16px;
    font-weight: 800;
}

.public-faq-answer {
    padding: 0 20px 20px;
    font-size: 14px;
}

.landing-cta {
    position: relative;
    display: grid;
    grid-template-columns: 260px minmax(0, 1fr) auto;
    align-items: center;
    gap: 24px;
    padding: 22px 24px;
    background: linear-gradient(135deg, #174221, #0f2f18);
    color: #f6fcf5;
    overflow: hidden;
}

.landing-cta-art {
    position: relative;
    min-height: 120px;
    border-radius: 20px;
    background: linear-gradient(180deg, rgba(255, 255, 255, .08), rgba(255, 255, 255, .03));
    overflow: hidden;
}

.landing-cta-art > span { position: absolute; display: block; }

.landing-cta-warehouse {
    left: 18px;
    bottom: 20px;
    width: 138px;
    height: 76px;
    border-radius: 8px;
    background: linear-gradient(180deg, #d8dfc2, #b6c69b);
}

.landing-cta-warehouse::before {
    content: "";
    position: absolute;
    left: -10px;
    right: -10px;
    top: -40px;
    height: 48px;
    clip-path: polygon(50% 0, 100% 100%, 0 100%);
    background: linear-gradient(180deg, #dce5c4, #b9cca0);
}

.landing-cta-warehouse::after {
    content: "Farm Supply";
    position: absolute;
    top: -18px;
    left: 34px;
    width: 72px;
    height: 22px;
    display: grid;
    place-items: center;
    border-radius: 6px;
    background: #204e2a;
    color: #f4fbf2;
    font-size: 8px;
    font-weight: 800;
    letter-spacing: .06em;
    text-transform: uppercase;
}

.landing-cta-tractor {
    right: 26px;
    bottom: 22px;
    width: 88px;
    height: 48px;
    border-radius: 16px 16px 8px 8px;
    background: linear-gradient(180deg, #82ba4d, #5f8f34);
    box-shadow: 0 16px 24px rgba(0, 0, 0, .16);
}

.landing-cta-tractor::before,
.landing-cta-tractor::after {
    content: "";
    position: absolute;
    bottom: -12px;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: #122116;
    border: 5px solid #eff5ee;
}

.landing-cta-tractor::before { left: 10px; }
.landing-cta-tractor::after { right: 10px; }

.landing-cta-soil {
    left: 0;
    right: 0;
    bottom: 0;
    height: 28px;
    background: linear-gradient(180deg, rgba(117, 169, 67, .12), rgba(117, 169, 67, .35));
}

.landing-cta-beam {
    inset: 12px;
    border-radius: 22px;
    border: 1px solid rgba(129, 193, 69, .18);
}

.landing-cta-beam::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, transparent, rgba(129, 193, 69, .34), transparent);
    background-size: 220px 100%;
    animation: flowTravel 5.4s linear infinite;
}

.landing-cta-copy p {
    max-width: 33rem;
    color: rgba(244, 251, 242, .78);
}

.landing-cta-action {
    display: flex;
    justify-content: flex-end;
}

.landing-footer {
    grid-template-columns: 1.4fr repeat(3, minmax(0, 1fr));
    gap: 18px;
    padding: 26px 24px 22px;
    background: var(--pl-footer);
    color: #f4fbf2;
}

.landing-footer > div {
    display: grid;
    gap: 10px;
}

.landing-brand-footer .landing-brand-copy small,
.landing-footer-brand p,
.landing-footer a,
.landing-footer button,
.landing-footer span {
    color: rgba(244, 251, 242, .76);
}

.landing-footer button {
    padding: 0;
    border: 0;
    background: transparent;
    text-align: left;
    cursor: pointer;
}

.landing-footer-socials {
    gap: 10px;
    margin-top: 8px;
}

.landing-footer-socials span {
    width: 34px;
    height: 34px;
    display: inline-grid;
    place-items: center;
    border-radius: 50%;
    background: rgba(255, 255, 255, .10);
    color: #ffffff;
    font-size: 13px;
    font-weight: 700;
}

.landing-copyright {
    justify-items: center;
    color: var(--pl-muted);
    font-size: 12px;
}

body.public-auth-open {
    overflow: hidden;
}

.public-auth-modal {
    position: fixed;
    inset: 0;
    z-index: 50;
}

.public-auth-modal.hidden {
    display: none;
}

.public-auth-backdrop {
    position: absolute;
    inset: 0;
    background: rgba(6, 18, 10, .58);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}

.public-auth-shell {
    position: relative;
    display: grid;
    place-items: center;
    min-height: 100vh;
    padding: 20px;
}

.public-auth-card {
    width: min(480px, 100%);
    gap: 18px;
    padding: 24px;
    background: var(--pl-panel-strong);
}

.public-auth-top,
.tabs {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
}

.auth-head {
    display: grid;
    gap: 8px;
}

.landing-kicker-modal {
    margin-bottom: 4px;
}

.public-auth-close {
    width: 38px;
    height: 38px;
    border-radius: 12px;
    background: rgba(255, 255, 255, .06);
    color: var(--pl-text);
    font-size: 20px;
    line-height: 1;
    transform: rotate(45deg);
}

.tabs {
    padding: 6px;
    border-radius: 16px;
    background: rgba(255, 255, 255, .04);
    border: 1px solid var(--pl-line);
}

.tabs button {
    flex: 1 1 0;
    min-height: 42px;
    border-radius: 12px;
    background: transparent;
    color: var(--pl-soft);
    font-weight: 700;
}

.tabs button.active {
    background: rgba(95, 159, 47, .14);
    color: var(--pl-text);
}

.auth-form {
    gap: 14px;
}

.pwd-toggle,
.auth-submit {
    min-height: 44px;
    padding: 0 14px;
    border-radius: 12px;
    font-weight: 800;
}

.pwd-toggle {
    background: rgba(255, 255, 255, .04);
    color: var(--pl-soft);
    border: 1px solid var(--pl-line);
}

.auth-submit {
    background: linear-gradient(135deg, var(--pl-accent-strong), var(--pl-accent));
    color: #ffffff;
}

#authNotice {
    min-height: 20px;
    font-size: 13px;
}
@keyframes floatDevice {
    0%, 100% { transform: translate3d(0, 0, 12px) rotateX(18deg) rotateY(-21deg) rotateZ(1deg); }
    25% { transform: translate3d(0, -6px, 26px) rotateX(19deg) rotateY(-18deg) rotateZ(.4deg); }
    50% { transform: translate3d(0, -14px, 36px) rotateX(16deg) rotateY(-24deg) rotateZ(-.8deg); }
    75% { transform: translate3d(0, -8px, 22px) rotateX(20deg) rotateY(-19deg) rotateZ(1.3deg); }
}

@keyframes floatPhone {
    0%, 100% { transform: translate3d(0, 0, 88px) rotateX(6deg) rotateY(-28deg) rotateZ(6deg); }
    30% { transform: translate3d(-2px, -9px, 108px) rotateX(8deg) rotateY(-24deg) rotateZ(4deg); }
    55% { transform: translate3d(0, -14px, 124px) rotateX(5deg) rotateY(-31deg) rotateZ(7deg); }
    80% { transform: translate3d(2px, -7px, 98px) rotateX(7deg) rotateY(-26deg) rotateZ(5deg); }
}

@keyframes floatLogo {
    0%, 100% { transform: translate3d(0, 0, 24px) rotateZ(0deg); }
    50% { transform: translate3d(0, -8px, 34px) rotateZ(-1.5deg); }
}

@keyframes logoHalo {
    0%, 100% { opacity: .6; transform: scale(.96); }
    50% { opacity: 1; transform: scale(1.08); }
}

@keyframes screenSheen {
    0%, 100% { background-position: 120% 0, 0 0; }
    50% { background-position: -10% 0, 0 0; }
}

@keyframes phoneShine {
    0%, 100% { opacity: .2; transform: translateX(-14%); }
    50% { opacity: .65; transform: translateX(14%); }
}

@keyframes tileBreath {
    0%, 100% { box-shadow: 0 16px 28px rgba(21, 53, 32, .08); }
    50% { box-shadow: 0 22px 36px rgba(21, 53, 32, .12); }
}

@keyframes stageSweep {
    0%, 100% { opacity: .28; transform: translate3d(0, 0, -20px); }
    50% { opacity: .7; transform: translate3d(0, -4px, 18px); }
}

@keyframes logoOrbit {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

@keyframes logoPulse {
    0%, 100% { opacity: .75; transform: scale(1); }
    50% { opacity: 1; transform: scale(1.05); }
}

@keyframes flowTravel {
    from { background-position: -220px 0; }
    to { background-position: 220px 0; }
}

@keyframes orbitSpin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

@keyframes orbitPulse {
    0%, 100% { opacity: .35; transform: scale(1); }
    50% { opacity: .7; transform: scale(1.03); }
}

@keyframes fieldGlow {
    0%, 100% { opacity: .35; }
    50% { opacity: .75; }
}

@media (max-width: 1180px) {
    .landing-hero,
    .landing-showcase,
    .landing-cta,
    .landing-footer {
        grid-template-columns: 1fr;
    }

    .landing-feature-grid,
    .landing-logo-strip,
    .landing-faq-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .landing-hero-visual {
        min-height: 516px;
    }

    .landing-laptop-mock {
        left: 4%;
        right: 14%;
        top: 74px;
    }

    .landing-cta-action {
        justify-content: flex-start;
    }
}

@media (max-width: 920px) {
    .landing-nav {
        flex-wrap: wrap;
        justify-content: center;
    }

    .landing-nav-links {
        order: 3;
        width: 100%;
        flex-wrap: wrap;
    }

    .landing-hero-copy h1 {
        max-width: none;
    }

    .landing-phone-hero {
        width: 148px;
        right: -2px;
        bottom: 28px;
    }

    .landing-logo-strip,
    .landing-feature-grid,
    .landing-faq-grid {
        grid-template-columns: 1fr;
    }

    .landing-scene-metrics {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 640px) {
    #authSection.public-landing {
        padding: 10px 10px 26px;
    }

    .landing-shell {
        gap: 16px;
    }

    .landing-nav {
        position: relative;
        top: 0;
        justify-content: space-between;
        padding: 12px 14px;
    }

    .landing-nav-links {
        display: none;
    }

    .landing-nav-actions {
        gap: 8px;
    }

    .landing-btn,
    .landing-btn-compact,
    .landing-theme-toggle {
        min-height: 40px;
        min-width: 40px;
        padding: 10px 12px;
        font-size: 12px;
    }

    .landing-brand-copy strong {
        font-size: 14px;
    }

    .landing-brand-copy small {
        font-size: 10px;
    }

    .landing-hero {
        gap: 16px;
    }

    .landing-hero-copy {
        gap: 16px;
    }

    .landing-hero-copy h1 {
        font-size: clamp(30px, 10vw, 40px);
    }

    .landing-hero-copy p {
        font-size: 14px;
    }

    .landing-hero-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        width: 100%;
    }

    .landing-hero-points {
        display: grid;
        gap: 10px;
        justify-items: start;
    }

    .landing-hero-visual {
        min-height: 430px;
    }

    .landing-floating-logo {
        top: 6px;
        right: 10px;
        transform: scale(.92);
    }

    .landing-laptop-mock {
        left: 0;
        right: 0;
        top: 54px;
        transform: none;
        animation: none;
    }

    .landing-laptop-screen {
        padding: 12px 12px 16px;
        border-width: 5px;
        border-radius: 22px 22px 16px 16px;
    }

    .landing-device-greeting strong {
        font-size: 20px;
    }

    .landing-device-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }

    .landing-device-tile {
        min-height: 114px;
        padding: 14px 10px;
    }

    .landing-device-tile strong {
        font-size: 13px;
    }

    .landing-phone-hero {
        display: none;
    }

    .landing-showcase {
        gap: 16px;
    }

    .landing-footer {
        padding: 22px 18px;
    }

    .public-auth-card {
        padding: 20px;
    }
}












/* Farm scene live 3D refinement */
.landing-scene-stage {
    --scene-tilt-x: 0deg;
    --scene-tilt-y: 0deg;
    --scene-pan-x: 0px;
    --scene-pan-y: 0px;
    --scene-light-x: 72%;
    --scene-light-y: 24%;
    transform-style: preserve-3d;
    will-change: transform;
    transform: perspective(1400px) rotateX(var(--scene-tilt-y)) rotateY(var(--scene-tilt-x));
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .58), 0 28px 60px rgba(56, 89, 39, .18);
    transition: transform .32s ease, box-shadow .32s ease;
}
.landing-scene-stage::before,
.landing-scene-stage::after {
    content: "";
    position: absolute;
    pointer-events: none;
}
.landing-scene-stage::before {
    inset: -10%;
    background:
        radial-gradient(circle at var(--scene-light-x) var(--scene-light-y), rgba(255, 244, 189, .42), rgba(255, 244, 189, 0) 34%),
        linear-gradient(180deg, rgba(255, 255, 255, .18), transparent 40%);
    transform: translateZ(18px);
}
.landing-scene-stage::after {
    left: 16%;
    right: 16%;
    bottom: 10px;
    height: 44px;
    border-radius: 50%;
    background: radial-gradient(ellipse at center, rgba(33, 59, 34, .18), transparent 72%);
    filter: blur(10px);
    transform: translateZ(8px);
}
.landing-scene-stage > span {
    transition: transform .32s ease, opacity .32s ease, box-shadow .32s ease, filter .32s ease;
    will-change: transform;
}
.landing-scene-glow {
    inset: 34px 70px 90px 72px;
    border-radius: 50%;
    background: radial-gradient(circle, rgba(255, 241, 180, .30), rgba(196, 226, 126, .18) 46%, transparent 72%);
    filter: blur(26px);
    opacity: .75;
    transform: translate3d(calc(var(--scene-pan-x) * -.12), calc(var(--scene-pan-y) * -.16), 24px);
    animation: sceneCardGlowPulse 5.8s ease-in-out infinite;
}
.landing-scene-ground-shadow {
    left: 130px;
    right: 86px;
    bottom: 74px;
    height: 34px;
    border-radius: 50%;
    background: radial-gradient(ellipse at center, rgba(26, 49, 31, .28), rgba(26, 49, 31, .08) 60%, transparent 76%);
    filter: blur(9px);
    opacity: .88;
    transform: translate3d(calc(var(--scene-pan-x) * .08), calc(var(--scene-pan-y) * .08), 12px);
}
.landing-scene-path {
    left: 170px;
    width: 112px;
    bottom: 64px;
    height: 84px;
    clip-path: polygon(22% 0, 78% 0, 100% 100%, 0 100%);
    background: linear-gradient(180deg, rgba(217, 225, 181, .10), rgba(226, 236, 197, .78));
    opacity: .72;
    transform: translate3d(calc(var(--scene-pan-x) * .12), calc(var(--scene-pan-y) * .12), 40px);
}
.landing-scene-cloud {
    box-shadow: 0 16px 24px rgba(124, 155, 84, .10);
}
.landing-scene-cloud-a {
    animation: sceneCloudFloatA 8.2s ease-in-out infinite;
}
.landing-scene-cloud-b {
    animation: sceneCloudFloatB 9.2s ease-in-out infinite;
}
.landing-scene-sun {
    box-shadow: 0 0 0 16px rgba(246, 226, 132, .16), 0 0 44px rgba(246, 226, 132, .24);
    transform: translate3d(calc(var(--scene-pan-x) * -.08), calc(var(--scene-pan-y) * -.12), 78px);
    animation: sceneSunPulse 4.6s ease-in-out infinite;
}
.landing-scene-hill-back {
    transform: translate3d(calc(var(--scene-pan-x) * -.04), calc(var(--scene-pan-y) * .03), 18px);
    box-shadow: inset 0 18px 24px rgba(255, 255, 255, .08);
}
.landing-scene-hill-front {
    transform: translate3d(calc(var(--scene-pan-x) * .06), calc(var(--scene-pan-y) * .06), 32px);
    box-shadow: inset 0 18px 28px rgba(255, 255, 255, .06);
}
.landing-field-line {
    opacity: .84;
    filter: drop-shadow(0 0 8px rgba(122, 160, 77, .18));
}
.landing-scene-silo-a {
    transform: translate3d(calc(var(--scene-pan-x) * -.08), calc(var(--scene-pan-y) * .06), 58px);
}
.landing-scene-silo-b {
    transform: translate3d(calc(var(--scene-pan-x) * -.04), calc(var(--scene-pan-y) * .07), 64px);
}
.landing-scene-silo {
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .7), 0 16px 28px rgba(63, 94, 56, .12);
}
.landing-scene-barn {
    overflow: visible;
    border: 1px solid rgba(54, 82, 59, .14);
    transform-style: preserve-3d;
    transform: translate3d(calc(var(--scene-pan-x) * .14), calc(var(--scene-pan-y) * .10), 82px);
    box-shadow: inset 0 2px 0 rgba(255, 255, 255, .16), 0 22px 38px rgba(43, 73, 47, .24);
}
.landing-scene-barn::after {
    content: "";
    position: absolute;
    top: 10px;
    right: -18px;
    bottom: 0;
    width: 20px;
    border-radius: 0 10px 8px 0;
    clip-path: polygon(0 0, 100% 8%, 100% 100%, 0 100%);
    background: linear-gradient(180deg, #2f4b3a, #22372a);
    opacity: .94;
}
.landing-scene-door {
    transform: translate3d(calc(var(--scene-pan-x) * .18), calc(var(--scene-pan-y) * .12), 104px);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .06), 0 14px 24px rgba(23, 43, 29, .18);
}
.landing-scene-sign {
    transform-origin: bottom left;
    transform: translate3d(calc(var(--scene-pan-x) * .20), calc(var(--scene-pan-y) * .08), 126px) rotate(-3deg);
    animation: sceneSignSway 6.4s ease-in-out infinite;
}
.landing-scene-sign::before {
    content: "";
    position: absolute;
    left: 11px;
    bottom: -18px;
    width: 4px;
    height: 18px;
    border-radius: 999px;
    background: #7d6a35;
    box-shadow: 36px 0 0 #7d6a35;
}
.landing-scene-tree {
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .22), 0 16px 28px rgba(54, 98, 41, .20);
}
.landing-scene-tree-a {
    transform: translate3d(calc(var(--scene-pan-x) * .16), calc(var(--scene-pan-y) * .08), 78px);
}
.landing-scene-tree-b {
    transform: translate3d(calc(var(--scene-pan-x) * .22), calc(var(--scene-pan-y) * .10), 66px);
}
.landing-scene-card.is-tilting .landing-scene-stage {
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .6), 0 34px 72px rgba(48, 82, 46, .24);
}

@keyframes sceneCardGlowPulse {
    0%, 100% { opacity: .62; filter: blur(24px); }
    50% { opacity: .88; filter: blur(30px); }
}
@keyframes sceneCloudFloatA {
    0%, 100% { transform: translate3d(0, 0, 56px); }
    50% { transform: translate3d(12px, -8px, 66px); }
}
@keyframes sceneCloudFloatB {
    0%, 100% { transform: translate3d(0, 0, 48px); }
    50% { transform: translate3d(-10px, -6px, 58px); }
}
@keyframes sceneSunPulse {
    0%, 100% { transform: translate3d(calc(var(--scene-pan-x) * -.08), calc(var(--scene-pan-y) * -.12), 78px) scale(1); }
    50% { transform: translate3d(calc(var(--scene-pan-x) * -.10), calc(var(--scene-pan-y) * -.14), 82px) scale(1.08); }
}
@keyframes sceneSignSway {
    0%, 100% { transform: translate3d(calc(var(--scene-pan-x) * .20), calc(var(--scene-pan-y) * .08), 126px) rotate(-3deg); }
    50% { transform: translate3d(calc(var(--scene-pan-x) * .22), calc(var(--scene-pan-y) * .06), 130px) rotate(-1deg); }
}

@media (max-width: 760px) {
    .landing-scene-stage {
        min-height: 304px;
    }
    .landing-scene-ground-shadow {
        left: 104px;
        right: 68px;
    }
    .landing-scene-path {
        left: 146px;
        width: 92px;
        height: 74px;
    }
    .landing-scene-barn {
        left: 92px;
        right: 66px;
    }
    .landing-scene-door {
        left: 172px;
        width: 66px;
    }
    .landing-scene-sign {
        left: 212px;
    }
}

/* Final hero laptop composition fix */
.landing-hero-visual {
    min-height: 620px;
}

.landing-laptop-mock {
    left: auto;
    right: 42px;
    top: 92px;
    width: min(620px, 78%);
    transform-origin: 50% 92%;
    transform: translate3d(0, 0, 18px) rotateX(14deg) rotateY(-14deg) rotateZ(.5deg);
}

.landing-laptop-lid {
    padding: 10px 10px 16px;
    border-radius: 30px 30px 20px 20px;
}

.landing-laptop-screen {
    min-height: 364px;
    padding: 16px 18px 20px;
    border-radius: 22px 22px 16px 16px;
}

.landing-laptop-hinge {
    width: 30%;
    margin-top: 2px;
}

.landing-laptop-base {
    width: 108%;
    min-height: 116px;
    transform: translateX(-4%) translateZ(-12px) rotateX(78deg);
}

.landing-laptop-keyboard {
    border-radius: 12px;
}

.landing-laptop-trackpad {
    width: 34%;
}

.landing-phone-hero {
    right: -6px;
    bottom: 82px;
    width: 160px;
    transform: translateZ(100px) rotateX(4deg) rotateY(-18deg) rotateZ(5deg);
}

@media (max-width: 1180px) {
    .landing-hero-visual {
        min-height: 580px;
    }

    .landing-laptop-mock {
        right: 20px;
        top: 88px;
        width: min(560px, 78%);
        transform: translate3d(0, 0, 14px) rotateX(11deg) rotateY(-11deg) rotateZ(.35deg);
    }

    .landing-laptop-screen {
        min-height: 332px;
    }

    .landing-laptop-base {
        min-height: 106px;
    }

    .landing-phone-hero {
        width: 148px;
        right: -4px;
        bottom: 72px;
    }
}

@media (max-width: 920px) {
    .landing-hero-visual {
        min-height: 520px;
    }

    .landing-laptop-mock {
        left: 50%;
        right: auto;
        top: 72px;
        width: min(520px, 94%);
        transform: translateX(-50%) translate3d(0, 0, 8px) rotateX(8deg) rotateY(-7deg) rotateZ(.2deg);
    }

    .landing-laptop-screen {
        min-height: 300px;
    }

    .landing-laptop-base {
        width: 104%;
        min-height: 96px;
        transform: translateX(-2%) translateZ(-8px) rotateX(79deg);
    }

    .landing-phone-hero {
        width: 138px;
        right: 4px;
        bottom: 32px;
        transform: translateZ(72px) rotateX(3deg) rotateY(-12deg) rotateZ(4deg);
    }
}

@media (max-width: 640px) {
    .landing-hero-visual {
        min-height: 430px;
    }

    .landing-laptop-mock {
        top: 54px;
        width: 100%;
        transform: none;
    }

    .landing-laptop-screen {
        min-height: 250px;
    }

    .landing-laptop-base {
        width: 102%;
        min-height: 82px;
        transform: translateX(-1%) translateZ(-6px) rotateX(80deg);
    }
}
