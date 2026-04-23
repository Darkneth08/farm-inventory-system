<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml" href="/farm-supply-favicon.svg">
    <link rel="shortcut icon" href="/farm-supply-favicon.svg">
    <title>Farm Supply Inventory</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Sora:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-base: #09131a;
            --bg-accent: #0e2738;
            --bg-soft: #103145;
            --glow-a: rgba(26, 162, 126, 0.24);
            --glow-b: rgba(43, 143, 208, 0.2);
            --glow-c: rgba(16, 213, 184, 0.12);
            --fx-x: 50%;
            --fx-y: 50%;
            --panel: rgba(11, 35, 50, 0.72);
            --panel-strong: rgba(12, 42, 61, 0.85);
            --ink: #eaf3f7;
            --ink-soft: #b8cbd6;
            --line: rgba(255, 255, 255, 0.28);
            --line-soft: rgba(255, 255, 255, 0.08);
            --primary: #0f8d67;
            --primary-2: #1f80b8;
            --danger: #b7444d;
            --ui-font-size: 14px;
            --ui-line-height: 1.45;
            --sidebar-width: 268px;
            --space-shell: 14px;
            --space-main-gap: 12px;
            --space-section: 12px;
            --space-card-pad: 20px;
            --auth-pad: 24px;
            --hero-pad: 42px;
            --space-control-y: 11px;
            --space-control-x: 12px;
            --radius-card: 20px;
            --radius-control: 11px;
            --fs-top-title: 24px;
            --fs-section-title: 16px;
            --fs-muted: 13px;
            --fs-table: 13px;
            --fs-table-head: 11px;
            --fs-kpi: clamp(22px, 2vw, 30px);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Manrope, "Segoe UI", sans-serif;
            font-size: var(--ui-font-size);
            line-height: var(--ui-line-height);
            color: var(--ink);
            background:
                radial-gradient(1400px 700px at 8% -12%, var(--glow-a), transparent 68%),
                radial-gradient(1150px 560px at 100% 0%, var(--glow-b), transparent 70%),
                radial-gradient(900px 500px at 48% 100%, var(--glow-c), transparent 72%),
                linear-gradient(160deg, var(--bg-base), var(--bg-accent) 48%, var(--bg-soft));
            background-size: 180% 180%;
            animation: bgShift 22s ease-in-out infinite;
            min-height: 100vh;
            overflow-x: hidden;
        }

        @keyframes bgShift {
            0%, 100% { background-position: 0% 50%, 100% 0%, 50% 100%, 0% 50%; }
            50% { background-position: 10% 42%, 88% 8%, 55% 92%, 100% 50%; }
        }

        body::before,
        body::after {
            content: "";
            position: fixed;
            pointer-events: none;
            border-radius: 50%;
            filter: blur(42px);
            opacity: .4;
            z-index: -2;
            animation: drift 13s ease-in-out infinite;
        }

        body::before {
            width: 280px;
            height: 280px;
            top: 10%;
            left: -80px;
            background: rgba(31, 156, 119, .5);
        }

        body::after {
            width: 320px;
            height: 320px;
            right: -80px;
            top: 54%;
            background: rgba(36, 130, 185, .45);
            animation-duration: 15s;
            animation-delay: .5s;
        }

        @keyframes drift {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-18px) scale(1.06); }
        }

        .live-bg {
            position: fixed;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
            z-index: -3;
        }

        .live-bg::before {
            content: "";
            position: absolute;
            inset: -20%;
            background:
                repeating-linear-gradient(
                    110deg,
                    rgba(255, 255, 255, 0.035) 0 1px,
                    transparent 1px 52px
                );
            opacity: .36;
            transform: translate3d(0, 0, 0);
            animation: gridShift 28s linear infinite;
        }

        .live-bg::after {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 20% 20%, rgba(50, 182, 139, 0.18), transparent 38%),
                radial-gradient(circle at 80% 72%, rgba(57, 151, 208, 0.18), transparent 42%);
            filter: blur(10px);
            animation: pulseAura 10s ease-in-out infinite;
        }

        .live-bg span {
            position: absolute;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(202, 247, 255, .3);
            box-shadow: 0 0 18px rgba(120, 220, 255, .44);
            animation: floatDot linear infinite;
            opacity: .68;
        }

        .live-bg span:nth-of-type(1) { left: 10%; top: 84%; animation-duration: 14s; animation-delay: -2s; }
        .live-bg span:nth-of-type(2) { left: 20%; top: 92%; animation-duration: 18s; animation-delay: -5s; }
        .live-bg span:nth-of-type(3) { left: 33%; top: 88%; animation-duration: 16s; animation-delay: -1s; }
        .live-bg span:nth-of-type(4) { left: 48%; top: 96%; animation-duration: 19s; animation-delay: -7s; }
        .live-bg span:nth-of-type(5) { left: 61%; top: 90%; animation-duration: 15s; animation-delay: -3s; }
        .live-bg span:nth-of-type(6) { left: 74%; top: 95%; animation-duration: 18s; animation-delay: -6s; }
        .live-bg span:nth-of-type(7) { left: 86%; top: 89%; animation-duration: 13s; animation-delay: -4s; }
        .live-bg span:nth-of-type(8) { left: 92%; top: 94%; animation-duration: 17s; animation-delay: -8s; }
        .live-bg .pointer-aura {
            position: absolute;
            left: var(--fx-x);
            top: var(--fx-y);
            width: clamp(260px, 42vw, 620px);
            height: clamp(260px, 42vw, 620px);
            transform: translate(-50%, -50%);
            border-radius: 50%;
            pointer-events: none;
            opacity: .42;
            background:
                radial-gradient(circle at 48% 48%, rgba(86, 214, 180, .32), rgba(63, 164, 223, .22) 40%, rgba(8, 25, 40, 0) 72%);
            filter: blur(10px);
            transition: left .18s linear, top .18s linear, opacity .24s ease;
            mix-blend-mode: screen;
        }

        @keyframes gridShift {
            0% { transform: translate3d(0, 0, 0); }
            100% { transform: translate3d(-90px, -60px, 0); }
        }

        @keyframes pulseAura {
            0%, 100% { opacity: .52; transform: scale(1); }
            50% { opacity: .8; transform: scale(1.05); }
        }

        @keyframes floatDot {
            0% { transform: translateY(0) scale(.92); opacity: 0; }
            10% { opacity: .5; }
            70% { opacity: .8; }
            100% { transform: translateY(-115vh) scale(1.25); opacity: 0; }
        }

        .hidden { display: none !important; }

        .auth {
            min-height: 100vh;
            max-width: 1220px;
            margin: 0 auto;
            padding: var(--auth-pad);
            display: grid;
            gap: 20px;
            grid-template-columns: 1.1fr .9fr;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .hero {
            position: relative;
            overflow: hidden;
            border-radius: 28px;
            padding: var(--hero-pad);
            border: 1px solid rgba(255, 255, 255, .18);
            background:
                linear-gradient(130deg, rgba(6, 56, 42, .86), rgba(4, 35, 57, .92)),
                url('https://images.unsplash.com/photo-1500937386664-56d1dfef3854?auto=format&fit=crop&w=1400&q=80') center/cover;
            box-shadow: 0 26px 52px rgba(2, 13, 20, .38);
            animation: reveal .5s ease-out;
        }

        .hero::before {
            content: "";
            position: absolute;
            width: 340px;
            height: 340px;
            right: -140px;
            top: -120px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, .35), rgba(255, 255, 255, 0) 70%);
        }

        .hero h1 {
            margin: 0 0 12px;
            font-family: Sora, Manrope, sans-serif;
            font-size: clamp(32px, 4vw, 50px);
            letter-spacing: -.02em;
            line-height: 1.04;
        }

        .hero p {
            margin: 0;
            line-height: 1.66;
            color: #dcefed;
            max-width: 620px;
            font-size: 17px;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
            padding: 7px 12px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, .24);
            background: rgba(255, 255, 255, .14);
            text-transform: uppercase;
            letter-spacing: .12em;
            font-weight: 800;
            font-size: 11px;
        }

        .card {
            border-radius: var(--radius-card);
            border: 1px solid var(--line);
            background: var(--panel);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            padding: var(--space-card-pad);
            box-shadow: 0 20px 36px rgba(4, 15, 22, .22);
            animation: reveal .45s ease-out;
            min-width: 0;
            position: relative;
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
        }
        .card::before {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: inherit;
            pointer-events: none;
            background:
                radial-gradient(420px 120px at -8% -10%, rgba(54, 208, 165, .16), transparent 62%),
                radial-gradient(360px 130px at 108% 112%, rgba(76, 163, 218, .16), transparent 66%);
            opacity: .75;
            animation: cardAura 11s ease-in-out infinite;
        }
        .card::after {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: inherit;
            pointer-events: none;
            z-index: 0;
            opacity: 0;
            background:
                radial-gradient(220px circle at var(--card-glow-x, 50%) var(--card-glow-y, 50%),
                    rgba(146, 234, 210, .24),
                    rgba(88, 179, 234, .16) 42%,
                    rgba(7, 24, 36, 0) 72%);
            transition: opacity .22s ease;
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 24px 42px rgba(3, 12, 20, .34);
            border-color: rgba(183, 236, 222, .34);
        }
        .card:hover::after {
            opacity: .95;
        }
        .card > * {
            position: relative;
            z-index: 1;
        }
        @keyframes cardAura {
            0%, 100% { opacity: .6; transform: translateY(0); }
            50% { opacity: .92; transform: translateY(-2px); }
        }

        @keyframes reveal {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .auth-card { padding: calc(var(--space-card-pad) + 4px); background: var(--panel-strong); }
        .auth-head h2 {
            margin: 6px 0 5px;
            font-family: Sora, Manrope, sans-serif;
            font-size: 28px;
            letter-spacing: -.02em;
            color: #f2f8fd;
        }
        .auth-head p { margin: 0; color: #c6d8e4; font-size: 14px; }
        .auth-label {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            border: 1px solid var(--line);
            background: rgba(255, 255, 255, .08);
            color: #d7e8f4;
            text-transform: uppercase;
            letter-spacing: .08em;
            font-size: 11px;
            font-weight: 800;
        }

        .tabs {
            display: flex;
            gap: 8px;
            margin: 16px 0 14px;
            padding: 4px;
            border-radius: 12px;
            border: 1px solid var(--line);
            background: rgba(255, 255, 255, .07);
        }

        .tabs button {
            border: 1px solid transparent;
            background: transparent;
            color: #c5d7e4;
            border-radius: 9px;
            padding: 9px 12px;
            font-weight: 800;
            cursor: pointer;
        }

        .tabs button.active {
            color: #fff;
            background: linear-gradient(135deg, var(--primary), var(--primary-2));
            box-shadow: 0 10px 18px rgba(13, 89, 68, .34);
        }

        form { display: grid; gap: 10px; }
        .auth-form { gap: 12px; }
        .grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .grid3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px; }
        .field { display: grid; gap: 6px; }
        .field label { font-size: calc(var(--ui-font-size) - 1px); color: #e8f4fc; font-weight: 700; }
        .field small { color: #d2e3ef; font-size: 12px; }
        .password-wrap { display: flex; align-items: center; gap: 8px; }
        .password-wrap input { flex: 1; }

        input,
        select,
        textarea,
        button {
            width: 100%;
            border-radius: var(--radius-control);
            border: 1px solid var(--line);
            background: rgba(255, 255, 255, .14);
            color: #f4fbff;
            padding: var(--space-control-y) var(--space-control-x);
            font: inherit;
        }

        input::placeholder,
        textarea::placeholder { color: #d6e5ef; opacity: .95; }

        select option {
            color: #eaf6ff;
            background: #23455b;
        }

        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: rgba(78, 191, 151, .86);
            box-shadow: 0 0 0 3px rgba(78, 191, 151, .2);
            background: rgba(255, 255, 255, .12);
        }

        button {
            border: 1px solid transparent;
            font-weight: 800;
            cursor: pointer;
            background: linear-gradient(135deg, var(--primary), var(--primary-2));
            transition: transform .18s ease, box-shadow .18s ease, filter .18s ease;
            color: #f8fdff;
            text-shadow: 0 1px 0 rgba(0, 0, 0, .28);
            position: relative;
            overflow: hidden;
            isolation: isolate;
            transform-origin: center;
            background-size: 140% 140%;
            background-position: 50% 50%;
        }
        button::before {
            content: "";
            position: absolute;
            inset: -120% -30%;
            pointer-events: none;
            z-index: -1;
            background:
                linear-gradient(115deg,
                    transparent 28%,
                    rgba(255, 255, 255, .2) 45%,
                    rgba(255, 255, 255, .05) 58%,
                    transparent 74%),
                radial-gradient(circle at var(--btn-fx-x, 50%) var(--btn-fx-y, 50%),
                    rgba(255, 255, 255, .3),
                    rgba(255, 255, 255, .08) 48%,
                    rgba(255, 255, 255, 0) 75%);
            transform: translateX(-56%) rotate(5deg);
            opacity: 0;
            transition: opacity .25s ease, transform .45s ease;
        }
        button::after {
            content: "";
            position: absolute;
            left: var(--ripple-x, 50%);
            top: var(--ripple-y, 50%);
            width: 10px;
            height: 10px;
            border-radius: 999px;
            pointer-events: none;
            z-index: 0;
            transform: translate(-50%, -50%) scale(0);
            opacity: 0;
            background: rgba(255, 255, 255, .55);
        }
        button:hover::before {
            opacity: .95;
            transform: translateX(2%) rotate(5deg);
        }
        button.btn-ripple::after {
            animation: btnRipple .62s ease-out;
        }
        @keyframes btnRipple {
            0% {
                transform: translate(-50%, -50%) scale(0);
                opacity: .52;
            }
            100% {
                transform: translate(-50%, -50%) scale(26);
                opacity: 0;
            }
        }
        @keyframes buttonBreath {
            0%, 100% {
                box-shadow: 0 12px 22px rgba(9, 58, 45, .24);
                background-position: 48% 52%;
            }
            50% {
                box-shadow: 0 16px 28px rgba(14, 77, 58, .34);
                background-position: 52% 48%;
            }
        }
        button:not(.menu-btn):not(.pwd-toggle):not(.btn-inline):not(:disabled) {
            animation: buttonBreath 3.8s ease-in-out infinite;
        }

        button:hover { transform: translateY(-1px); box-shadow: 0 12px 22px rgba(9, 58, 45, .3); filter: brightness(1.03); }
        button:active { transform: translateY(0) scale(.992); }
        button:disabled { opacity: .65; cursor: not-allowed; transform: none; box-shadow: none; }
        button:disabled::before,
        button:disabled::after { display: none; }

        button.secondary {
            border-color: var(--line);
            background: rgba(255, 255, 255, .12);
            color: #d7e9f4;
        }

        button.danger {
            border-color: rgba(232, 144, 154, .4);
            background: linear-gradient(135deg, #8f2a33, var(--danger));
        }

        .pwd-toggle {
            width: auto;
            min-width: 64px;
            border-color: var(--line);
            background: rgba(255, 255, 255, .12);
            color: #d8e7f1;
            font-size: 12px;
            font-weight: 800;
        }

        button.btn-inline {
            width: auto;
            min-width: 74px;
            padding: 7px 10px;
            font-size: 12px;
            border-radius: 8px;
        }

        .auth-submit { margin-top: 2px; }
        .auth-foot { margin-top: 6px; font-size: 12px; color: #9fb6c2; text-align: center; }

        .notice {
            border-radius: 10px;
            margin-top: 10px;
            padding: 10px 12px;
            border: 1px solid var(--line);
            background: rgba(255, 255, 255, .1);
            color: #ccdde7;
            font-size: 14px;
        }

        .notice.ok {
            border-color: rgba(121, 212, 180, .56);
            background: rgba(17, 106, 72, .26);
            color: #c5f0df;
        }

        .notice.err {
            border-color: rgba(235, 156, 166, .56);
            background: rgba(135, 44, 53, .24);
            color: #ffd8dc;
        }

        .shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: var(--sidebar-width) 1fr;
            gap: var(--space-main-gap);
            padding: var(--space-shell);
            position: relative;
            z-index: 2;
            width: min(100%, 1780px);
            margin: 0 auto;
        }
        .shell::before {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: 24px;
            pointer-events: none;
            z-index: 0;
            background:
                radial-gradient(500px circle at var(--fx-x) var(--fx-y), rgba(90, 215, 179, .16), rgba(21, 92, 144, .09) 44%, transparent 70%);
        }
        .shell > * {
            position: relative;
            z-index: 1;
        }

        .sidebar {
            position: sticky;
            top: var(--space-shell);
            height: calc(100vh - (var(--space-shell) * 2));
            padding: 22px 14px;
            border-radius: 20px;
            border: 1px solid var(--line);
            background: linear-gradient(180deg, rgba(8, 35, 52, .84), rgba(5, 24, 36, .92));
            backdrop-filter: blur(14px);
            box-shadow: 0 18px 30px rgba(2, 14, 20, .28);
        }

        .brand {
            padding: 0 10px 14px;
            border-bottom: 1px solid var(--line-soft);
            margin-bottom: 14px;
        }

        .brand h3 {
            margin: 0;
            color: #f5fbff;
            font-family: Sora, Manrope, sans-serif;
            letter-spacing: -.01em;
        }

        .brand p { margin: 8px 0 0; font-size: 12px; color: #c4dae9; }
        .menu { display: grid; gap: 7px; }
        .menu button {
            background: transparent;
            border: 1px solid transparent;
            color: #c7deea;
            text-align: left;
            padding: var(--space-control-y) var(--space-control-x);
            border-radius: var(--radius-control);
            font-size: var(--ui-font-size);
        }

        .menu button.active,
        .menu button:hover {
            background: rgba(255, 255, 255, .1);
            border-color: var(--line);
            color: #f0f9ff;
        }

        .main {
            padding: 4px;
            display: flex;
            flex-direction: column;
            gap: var(--space-main-gap);
            min-width: 0;
        }

        .top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: calc(var(--space-card-pad) - 4px);
            border-radius: calc(var(--radius-card) - 4px);
            border: 1px solid var(--line);
            background: rgba(255, 255, 255, .08);
            backdrop-filter: blur(10px);
        }

        .top h2 {
            margin: 0;
            font-family: Sora, Manrope, sans-serif;
            font-size: var(--fs-top-title);
            letter-spacing: -.02em;
        }

        .top p { margin: 6px 0 0; color: var(--ink-soft); font-size: var(--ui-font-size); font-weight: 600; }
        .actions { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
        .inline-actions { display: flex; gap: 6px; flex-wrap: wrap; }

        .userbox {
            border: 1px solid var(--line);
            background: rgba(255, 255, 255, .08);
            border-radius: 10px;
            padding: 8px 10px;
            font-size: 12px;
            color: #dbecf7;
        }

        .views .view { display: none; }
        .views .view.active { display: block; animation: fadeUp .24s ease-out; }
        .views { min-width: 0; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(7px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(min(220px, 100%), 1fr));
            gap: var(--space-main-gap);
        }

        .kpi h4 {
            margin: 0;
            color: #d7e8f3;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .06em;
            font-weight: 800;
        }

        .kpi .value {
            margin: 7px 0 0;
            font-family: Sora, Manrope, sans-serif;
            font-size: var(--fs-kpi);
            font-weight: 800;
            letter-spacing: -.02em;
            line-height: 1.12;
            overflow-wrap: anywhere;
            word-break: break-word;
            font-variant-numeric: tabular-nums;
            min-width: 0;
        }
        .kpi .value.kpi-money {
            font-size: clamp(15px, 1.2vw, 22px);
            line-height: 1.18;
        }

        .layout2 { display: grid; grid-template-columns: 1.1fr .9fr; gap: var(--space-main-gap); margin-top: var(--space-section); }
        .layout3 { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: var(--space-main-gap); margin-top: var(--space-section); }
        .pos-shell { display: grid; gap: var(--space-main-gap); margin-top: var(--space-section); }
        .pos-hero {
            display: grid;
            grid-template-columns: minmax(0, 1.08fr) minmax(320px, .92fr);
            gap: 16px;
            align-items: start;
        }
        .pos-hero-copy { display: grid; gap: 12px; }
        .pos-eyebrow { width: fit-content; margin-bottom: 0; }
        .pos-warehouse-line {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
            color: #d6e9f5;
        }
        .pos-warehouse-line strong {
            font-family: Sora, Manrope, sans-serif;
            font-size: 19px;
            letter-spacing: -.02em;
        }
        .pos-hero-metrics { grid-template-columns: repeat(4, minmax(0, 1fr)); margin-top: 0; }
        .pos-layout { display: grid; grid-template-columns: minmax(0, 1.12fr) minmax(360px, .88fr); gap: var(--space-main-gap); }
        .pos-side { display: grid; gap: var(--space-main-gap); }
        .pos-filter-grid { display: grid; grid-template-columns: minmax(0, 1.15fr) minmax(220px, .85fr); gap: 10px; }
        .pos-section-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
        }
        .pos-section-head .title { margin-bottom: 4px; }
        .pos-catalog-status { margin-top: 12px; font-size: 12px; color: #d1e4ef; }
        .pos-step-strip { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 10px; }
        .pos-step-card {
            display: grid;
            gap: 4px;
            padding: 14px;
            border-radius: 16px;
            border: 1px solid var(--line-soft);
            background: rgba(255, 255, 255, .06);
            min-width: 0;
        }
        .pos-step-card strong { font-family: Sora, Manrope, sans-serif; font-size: 18px; color: #f6fcff; }
        .pos-step-card span { font-size: 13px; font-weight: 800; color: #f0f9ff; }
        .pos-step-card small { font-size: 12px; color: #c4dceb; }
        .pos-catalog-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 12px; margin-top: 14px; }
        .pos-product-card {
            display: grid;
            gap: 12px;
            padding: 16px;
            border-radius: 18px;
            border: 1px solid var(--line);
            background: linear-gradient(180deg, rgba(10, 36, 51, .92), rgba(8, 28, 40, .84));
            box-shadow: 0 18px 28px rgba(3, 15, 24, .16);
            min-width: 0;
        }
        .pos-product-top { display: flex; justify-content: space-between; align-items: flex-start; gap: 10px; }
        .pos-product-cell { display: grid; gap: 4px; min-width: 0; }
        .pos-product-cell strong { font-size: 15px; }
        .pos-product-meta { font-size: 12px; color: #d1e4ef; }
        .pos-meta-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 8px; }
        .pos-meta-card {
            display: grid;
            gap: 4px;
            padding: 10px 12px;
            border-radius: 14px;
            border: 1px solid var(--line-soft);
            background: rgba(255, 255, 255, .05);
            min-width: 0;
        }
        .pos-meta-card span { font-size: 11px; letter-spacing: .08em; text-transform: uppercase; color: #bbd4e0; font-weight: 800; }
        .pos-meta-card strong { font-size: 13px; color: #f5fbff; }
        .pos-card-actions { display: grid; grid-template-columns: 92px minmax(0, 1fr); gap: 10px; align-items: end; }
        .pos-card-actions button { min-width: 0; }
        .pos-qty-field { display: grid; gap: 6px; }
        .pos-qty-field label { font-size: 11px; letter-spacing: .08em; text-transform: uppercase; color: #bfd7e4; font-weight: 800; }
        .pos-qty-field input { text-align: center; font-weight: 800; }
        .pos-cart-head { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px; margin-top: 12px; }
        .pos-cart-list { display: grid; gap: 12px; margin-top: 12px; }
        .pos-cart-line {
            display: grid;
            grid-template-columns: minmax(0, 1.2fr) minmax(132px, .55fr) minmax(120px, .45fr) auto;
            gap: 10px;
            align-items: center;
            padding: 14px;
            border-radius: 16px;
            border: 1px solid var(--line);
            background: rgba(255, 255, 255, .06);
            min-width: 0;
        }
        .pos-cart-line-main { display: grid; gap: 4px; min-width: 0; }
        .pos-cart-line-main strong { font-size: 14px; color: #f6fcff; }
        .pos-cart-line-note { font-size: 12px; color: #d1e4ef; }
        .pos-cart-qty { display: grid; gap: 6px; }
        .pos-cart-qty label { font-size: 11px; letter-spacing: .08em; text-transform: uppercase; color: #bfd7e4; font-weight: 800; }
        .pos-cart-qty input { text-align: center; font-weight: 800; }
        .pos-line-total { display: grid; gap: 4px; justify-items: end; text-align: right; }
        .pos-line-total span { font-size: 11px; letter-spacing: .08em; text-transform: uppercase; color: #bfd7e4; font-weight: 800; }
        .pos-line-total strong { font-family: Sora, Manrope, sans-serif; font-size: 16px; color: #f8fdff; }
        .pos-cart-empty {
            display: grid;
            gap: 4px;
            padding: 16px;
            border-radius: 16px;
            border: 1px dashed rgba(255, 255, 255, .16);
            background: rgba(255, 255, 255, .04);
            color: #d7e8f4;
        }
        .pos-cart-empty strong { color: #f4fbff; }
        .pos-summary-grid { grid-template-columns: repeat(4, minmax(0, 1fr)); margin-top: 12px; }
        .pos-summary-grid .chip { min-height: 78px; }
        .pos-success-card {
            display: grid;
            gap: 12px;
            margin-top: 10px;
            padding: 16px;
            border-radius: 18px;
            border: 1px solid rgba(121, 212, 180, .28);
            background: linear-gradient(135deg, rgba(10, 51, 39, .92), rgba(7, 34, 51, .9));
        }
        .pos-success-card.pos-success-empty { border-color: var(--line); background: rgba(255, 255, 255, .05); }
        .pos-success-header { display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 12px; }
        .pos-success-copy { display: grid; gap: 4px; }
        .pos-success-copy strong { font-size: 16px; color: #f6fdff; }
        .pos-success-copy span { font-size: 13px; color: #d4e7f1; }
        .pos-success-copy small { font-size: 12px; color: #bfd6e2; }
        .pos-success-metrics { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 10px; }
        .pos-success-lines { display: grid; gap: 8px; }
        .pos-success-line { display: flex; justify-content: space-between; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 14px; border: 1px solid rgba(255, 255, 255, .1); background: rgba(255, 255, 255, .06); }
        .pos-success-line div { display: grid; gap: 2px; }
        .pos-success-line strong { font-size: 13px; color: #f6fdff; }
        .pos-success-line span,
        .pos-success-line small { font-size: 12px; color: #d0e4ef; }
        #posNotice .notice { margin-top: 0; }        .inventory-toolbar { display: grid; gap: 10px; }
        .inventory-stack { display: grid; gap: 10px; }
        .inventory-subtle { font-size: 12px; color: #d1e4ef; }
        .op-layout-nav {
            margin-top: 0;
            padding: 14px;
        }
        .op-layout-nav .title {
            margin-bottom: 2px;
        }
        .op-layout-tabs {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding-bottom: 2px;
            scrollbar-width: thin;
            margin-top: 10px;
        }
        .op-layout-tabs button {
            width: auto;
            min-width: max-content;
            border: 1px solid var(--line);
            background: rgba(255, 255, 255, .12);
            color: #d7e9f4;
            padding: 8px 12px;
        }
        .op-layout-tabs button.active {
            border-color: transparent;
            background: linear-gradient(135deg, var(--primary), var(--primary-2));
            color: #f8fdff;
            animation: tabPulse 2.7s ease-in-out infinite;
        }
        @keyframes tabPulse {
            0%, 100% { box-shadow: 0 0 0 0 rgba(80, 197, 157, .35); }
            50% { box-shadow: 0 0 0 5px rgba(80, 197, 157, 0); }
        }
        .op-layout-tabs button:disabled {
            opacity: .42;
            cursor: not-allowed;
        }
        .section-hidden { display: none !important; }
        #operationsView .op-layout-tabs { flex-wrap: wrap; }
        #operationsView .layout2,
        #operationsView .layout3,
        #operationsView .operations-stack {
            grid-template-columns: minmax(0, 1fr);
        }
        #operationsView .operations-stack {
            display: grid;
            gap: 12px;
        }
        #operationsView .grid2,
        #operationsView .grid3 {
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        }
        #operationsView .card,
        #superAdminView .card {
            min-width: 0;
        }
        #operationsView .op-layout-tabs button {
            min-width: 136px;
        }
        .customer-layout-nav {
            margin-top: var(--space-section);
            display: grid;
            gap: 14px;
        }
        .customer-home-shell {
            display: grid;
            gap: 16px;
        }
        .customer-home-hero {
            display: grid;
            gap: 18px;
            background:
                linear-gradient(140deg, rgba(8, 58, 50, .82), rgba(10, 34, 56, .84)),
                radial-gradient(circle at top right, rgba(78, 191, 151, .16), transparent 42%);
        }
        .customer-home-nav,
        .customer-home-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .customer-home-actions button,
        .customer-home-nav button {
            width: auto;
            min-width: 118px;
        }
        .customer-home-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.15fr) minmax(300px, .85fr);
            gap: 18px;
            align-items: start;
        }
        .customer-home-copy {
            display: grid;
            gap: 14px;
        }
        .customer-home-copy h3 {
            margin: 0;
            font-family: Sora, Manrope, sans-serif;
            font-size: clamp(28px, 3.1vw, 42px);
            letter-spacing: -.03em;
            line-height: 1.02;
        }
        .customer-home-copy p {
            margin: 0;
            max-width: 560px;
            color: #dcebf3;
            font-size: 15px;
        }
        .customer-home-metrics {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
        .customer-home-profile,
        .customer-home-panel {
            display: grid;
            gap: 14px;
        }
        .customer-home-profile {
            padding: 18px;
            border-radius: 18px;
            border: 1px solid var(--line);
            background: rgba(255, 255, 255, .08);
        }
        .customer-home-detail,
        .customer-home-mini-item {
            display: grid;
            gap: 5px;
            padding: 13px 14px;
            border-radius: 14px;
            border: 1px solid var(--line-soft);
            background: rgba(255, 255, 255, .05);
        }
        .customer-home-detail span,
        .customer-home-tag,
        .customer-home-mini-item span {
            color: #cae0ed;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
        }
        .customer-home-detail strong,
        .customer-home-mini-item strong {
            color: #f5fbff;
            font-size: 14px;
            line-height: 1.45;
        }
        .customer-home-tag {
            display: inline-flex;
            align-items: center;
            width: fit-content;
            padding: 6px 10px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, .18);
            background: rgba(255, 255, 255, .08);
        }
        .customer-home-panels {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
        }
        .customer-home-mini-list {
            display: grid;
            gap: 10px;
        }
        .customer-kpi-strip {
            grid-template-columns: repeat(4, minmax(0, 1fr));
            min-width: min(100%, 620px);
            margin-top: 0;
        }
        .customer-section-group {
            display: grid;
            gap: var(--space-main-gap);
            margin-top: var(--space-section);
        }
        .customer-shop-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.12fr) minmax(320px, .88fr);
            gap: var(--space-main-gap);
            align-items: start;
        }
        .customer-side-grid,
        .customer-orders-layout,
        .customer-saved-grid,
        .customer-account-grid {
            display: grid;
            gap: var(--space-main-gap);
        }
        .customer-orders-layout,
        .customer-saved-grid,
        .customer-account-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            align-items: start;
        }
        .customer-filter-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.2fr) minmax(180px, .75fr) minmax(210px, .85fr);
            gap: 10px;
        }
        .customer-catalog-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 12px;
            margin-top: 14px;
        }
        .customer-product-card {
            position: relative;
            display: grid;
            gap: 12px;
            padding: 14px;
            border-radius: 18px;
            border: 1px solid var(--line);
            background: linear-gradient(180deg, rgba(9, 35, 52, .9), rgba(8, 30, 45, .82));
            box-shadow: 0 18px 28px rgba(3, 15, 24, .16);
            overflow: hidden;
            transition: transform .2s ease, border-color .2s ease, box-shadow .2s ease;
        }
        .customer-product-card::before {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top right, rgba(255, 255, 255, .12), transparent 46%);
            pointer-events: none;
        }
        .customer-product-card.active {
            border-color: rgba(126, 222, 196, .52);
            box-shadow: 0 22px 34px rgba(8, 27, 39, .24);
            transform: translateY(-2px);
        }
        .customer-product-cover {
            position: relative;
            min-height: 112px;
            border-radius: 16px;
            padding: 14px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background: linear-gradient(135deg, #1a445c, #1c8f8c);
            color: #f8fdff;
            overflow: hidden;
        }
        .customer-product-cover::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(5, 16, 26, .08), rgba(5, 23, 35, .74));
            pointer-events: none;
        }
        .customer-product-cover img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .customer-product-cover-content {
            position: relative;
            z-index: 1;
            display: flex;
            flex: 1;
            flex-direction: column;
            justify-content: space-between;
            gap: 10px;
        }
        .customer-product-cover span {
            font-family: Sora, Manrope, sans-serif;
            font-size: 34px;
            font-weight: 800;
            letter-spacing: -.03em;
            line-height: 1;
            display: block;
            max-width: 12ch;
            text-wrap: balance;
        }
        .customer-product-cover small {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .08em;
            font-weight: 800;
            opacity: .9;
        }
        .customer-spotlight-media {
            min-height: 176px;
        }
        .customer-spotlight-media span {
            font-size: 26px;
            line-height: 1.08;
        }
        .customer-product-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
        }
        .customer-product-name {
            margin: 0;
            font-family: Sora, Manrope, sans-serif;
            font-size: 16px;
            color: #f4fbff;
            letter-spacing: -.02em;
        }
        .customer-product-meta,
        .customer-product-copy {
            color: #d4e7f2;
            font-size: 12px;
            line-height: 1.5;
        }
        .customer-product-copy {
            min-height: 36px;
            margin: 0;
        }
        .customer-product-price-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 12px;
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .1);
            color: #dcecf6;
            font-size: 12px;
            font-weight: 700;
        }
        .customer-product-price-row strong {
            font-family: Sora, Manrope, sans-serif;
            font-size: 18px;
            letter-spacing: -.02em;
            color: #ffffff;
        }
        .customer-product-actions,
        .customer-row-actions,
        .customer-qty-controls {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            align-items: center;
        }
        .customer-product-actions button,
        .customer-row-actions button,
        .customer-qty-controls button {
            width: auto;
            min-width: 0;
        }
        .customer-spotlight,
        .customer-cart-list,
        .customer-review-stack {
            display: grid;
            gap: 12px;
        }
        .customer-spotlight-hero {
            display: grid;
            gap: 12px;
            padding: 18px;
            border-radius: 18px;
            border: 1px solid rgba(255, 255, 255, .12);
            background: linear-gradient(135deg, rgba(18, 62, 85, .94), rgba(17, 117, 113, .74));
            color: #f7fcff;
        }
        .customer-spotlight-title {
            margin: 0;
            font-family: Sora, Manrope, sans-serif;
            font-size: 22px;
            line-height: 1.1;
            letter-spacing: -.03em;
        }
        .customer-spotlight-copy {
            margin: 0;
            color: rgba(245, 252, 255, .9);
            line-height: 1.6;
        }
        .customer-meta-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }
        .customer-meta-card,
        .customer-address-box,
        .customer-review-item,
        .customer-empty-state {
            border-radius: 14px;
            border: 1px solid var(--line);
            background: rgba(255, 255, 255, .08);
            padding: 12px;
        }
        .customer-meta-card strong,
        .customer-address-box strong {
            display: block;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #d3e7f4;
            margin-bottom: 5px;
        }
        .customer-meta-card span,
        .customer-address-box span {
            color: #f0f8ff;
            font-weight: 700;
            line-height: 1.5;
        }
        .customer-empty-state {
            text-align: center;
            color: #d6e7f3;
        }
        .customer-empty-state strong {
            display: block;
            margin-bottom: 6px;
            color: #f6fcff;
            font-family: Sora, Manrope, sans-serif;
            font-size: 16px;
        }
        .customer-cart-item {
            display: grid;
            gap: 10px;
            padding: 12px;
            border-radius: 14px;
            border: 1px solid var(--line);
            background: rgba(255, 255, 255, .08);
        }
        .customer-cart-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
        }
        .customer-cart-line-title {
            font-weight: 800;
            color: #f5fbff;
            font-size: 14px;
        }
        .customer-cart-line-price {
            font-family: Sora, Manrope, sans-serif;
            font-size: 18px;
            color: #ffffff;
            letter-spacing: -.02em;
        }
        .customer-qty-value {
            min-width: 28px;
            text-align: center;
            font-weight: 800;
            color: #f8fdff;
        }
        .customer-checkout-form {
            display: grid;
            gap: 10px;
            margin-top: 12px;
        }
        .customer-tracking-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 12px;
            margin-top: 12px;
        }
        .customer-tracking-card {
            display: grid;
            gap: 10px;
            padding: 14px;
            border-radius: 16px;
            border: 1px solid var(--line);
            background: linear-gradient(180deg, rgba(8, 31, 47, .88), rgba(9, 27, 39, .8));
        }
        .customer-tracking-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
            flex-wrap: wrap;
        }
        .customer-tracking-meta {
            color: #d7e7f2;
            font-size: 12px;
            line-height: 1.55;
        }
        .customer-tracking-items {
            color: #eef8ff;
            font-weight: 700;
            line-height: 1.6;
        }
        .customer-tracking-steps {
            display: grid;
            gap: 8px;
        }
        .customer-track-step {
            position: relative;
            padding-left: 20px;
            color: #c7dce8;
            font-size: 12px;
            font-weight: 700;
        }
        .customer-track-step::before {
            content: "";
            position: absolute;
            left: 0;
            top: 6px;
            width: 9px;
            height: 9px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, .22);
            background: rgba(255, 255, 255, .18);
        }
        .customer-track-step.done {
            color: #e8fbf5;
        }
        .customer-track-step.done::before {
            background: #56c39a;
            border-color: rgba(86, 195, 154, .6);
        }
        .customer-track-step.active {
            color: #fff6d8;
        }
        .customer-track-step.active::before {
            background: #ffd166;
            border-color: rgba(255, 209, 102, .72);
            box-shadow: 0 0 0 5px rgba(255, 209, 102, .14);
        }
        .customer-track-step.cancelled {
            color: #ffd7dc;
        }
        .customer-track-step.cancelled::before {
            background: #d95c63;
            border-color: rgba(217, 92, 99, .72);
        }
        .customer-mobile-cart-fab {
            position: fixed;
            right: 18px;
            bottom: 18px;
            z-index: 65;
            display: none;
            width: auto;
            min-width: 0;
            padding: 12px 14px;
            border-radius: 16px;
            border: 1px solid rgba(135, 209, 186, .36);
            background: linear-gradient(135deg, rgba(12, 78, 64, .96), rgba(22, 108, 159, .94));
            color: #f8fdff;
            box-shadow: 0 20px 32px rgba(2, 15, 24, .34);
        }
        .customer-mobile-cart-fab strong,
        .customer-mobile-cart-fab small {
            display: block;
            text-align: left;
        }
        .customer-mobile-cart-fab strong {
            font-size: 13px;
            letter-spacing: .04em;
            text-transform: uppercase;
        }
        .customer-mobile-cart-fab small {
            margin-top: 2px;
            color: rgba(246, 252, 255, .88);
            font-size: 12px;
            font-weight: 700;
        }
        .customer-cart-drawer {
            position: fixed;
            inset: 0;
            z-index: 74;
            pointer-events: none;
            opacity: 0;
            transition: opacity .2s ease;
        }
        .customer-cart-drawer.open {
            opacity: 1;
            pointer-events: auto;
        }
        .customer-cart-drawer-backdrop {
            position: absolute;
            inset: 0;
            background: rgba(4, 13, 20, .56);
            backdrop-filter: blur(6px);
        }
        .customer-cart-drawer-panel {
            position: absolute;
            left: 12px;
            right: 12px;
            bottom: 12px;
            max-height: min(82vh, 720px);
            display: grid;
            gap: 12px;
            padding: 18px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, .16);
            background: linear-gradient(180deg, rgba(8, 31, 47, .97), rgba(7, 24, 37, .96));
            box-shadow: 0 24px 40px rgba(1, 10, 16, .4);
            overflow: auto;
            transform: translateY(20px);
            transition: transform .24s ease;
        }
        .customer-cart-drawer.open .customer-cart-drawer-panel {
            transform: translateY(0);
        }
        .customer-drawer-cart-list {
            display: grid;
            gap: 10px;
            max-height: 42vh;
            overflow: auto;
            padding-right: 4px;
        }
        .customer-inline-note {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 10px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .12);
            color: #e0eff8;
            font-size: 12px;
            font-weight: 700;
        }
        .app-confirm {
            position: fixed;
            inset: 0;
            z-index: 82;
            display: grid;
            place-items: center;
            padding: 20px;
        }
        .app-confirm-backdrop {
            position: absolute;
            inset: 0;
            background: rgba(4, 13, 20, .6);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }
        .app-confirm-dialog {
            position: relative;
            z-index: 1;
            width: min(100%, 460px);
            display: grid;
            gap: 18px;
            padding: 22px;
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, .18);
            background:
                radial-gradient(260px 120px at 0% 0%, rgba(191, 93, 105, .16), transparent 70%),
                linear-gradient(180deg, rgba(10, 33, 50, .98), rgba(7, 23, 35, .96));
            box-shadow: 0 26px 48px rgba(1, 10, 16, .44);
        }
        .app-confirm-head {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 14px;
            align-items: start;
        }
        .app-confirm-icon {
            display: grid;
            place-items: center;
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: linear-gradient(135deg, rgba(191, 93, 105, .34), rgba(143, 42, 51, .92));
            border: 1px solid rgba(255, 201, 208, .18);
            box-shadow: 0 16px 28px rgba(143, 42, 51, .26);
            color: #fff7f8;
            font-family: Sora, Manrope, sans-serif;
            font-size: 24px;
            font-weight: 800;
        }
        .app-confirm-copy {
            display: grid;
            gap: 8px;
        }
        .app-confirm-copy h3 {
            margin: 0;
            font-family: Sora, Manrope, sans-serif;
            font-size: 28px;
            line-height: 1.06;
            letter-spacing: -.03em;
            color: #f4fbff;
        }
        .app-confirm-copy p {
            margin: 0;
            color: #c9dbe6;
            line-height: 1.65;
        }
        .app-confirm-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        .app-confirm-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .08);
            border: 1px solid rgba(255, 255, 255, .12);
            color: #dbe8f1;
            font-size: 12px;
            font-weight: 700;
        }
        .app-confirm-chip::before {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: #ef8f9c;
            box-shadow: 0 0 0 5px rgba(239, 143, 156, .14);
        }
        .app-confirm-actions {
            justify-content: flex-end;
        }
        .app-confirm-actions button {
            width: auto;
            min-width: 138px;
        }
        body.confirm-open {
            overflow: hidden;
        }
        @media (max-width: 640px) {
            .app-confirm {
                padding: 14px;
            }
            .app-confirm-dialog {
                padding: 18px;
                gap: 16px;
            }
            .app-confirm-head {
                grid-template-columns: 1fr;
            }
            .app-confirm-actions {
                display: grid;
                grid-template-columns: 1fr;
            }
            .app-confirm-actions button {
                width: 100%;
            }
        }        .customer-review-item .head {
            margin-bottom: 8px;
        }
        .customer-review-rating {
            color: #ffe19a;
            letter-spacing: .08em;
        }
        .customer-block {
            margin-top: var(--space-section);
            padding-top: var(--space-section);
            border-top: 1px solid var(--line-soft);
        }
        .customer-block:first-child {
            margin-top: 0;
            padding-top: 0;
            border-top: 0;
        }
        .customer-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            flex-wrap: wrap;
        }
        .stack { display: grid; gap: 10px; }
        .panel-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding-bottom: 8px;
            margin-bottom: 8px;
            border-bottom: 1px solid var(--line-soft);
        }
        .panel-head .title { margin: 0; }
        .panel-toggle {
            width: auto;
            min-width: 92px;
            padding: 7px 10px;
            font-size: 12px;
        }
        .panel-body { display: block; }
        .card.panel-collapsed .panel-body { display: none; }
        .card.panel-collapsed {
            border-color: rgba(255, 255, 255, .2);
            background: rgba(11, 35, 50, 0.6);
        }

        .title {
            margin: 0 0 6px;
            font-family: Sora, Manrope, sans-serif;
            font-size: var(--fs-section-title);
            letter-spacing: -.01em;
            color: #e5f0f5;
        }

        .muted { color: var(--ink-soft); font-size: var(--fs-muted); font-weight: 500; }
        .list { display: grid; gap: 8px; margin-top: 10px; }

        .list-item {
            border: 1px solid var(--line);
            border-radius: 10px;
            background: rgba(255, 255, 255, .1);
            padding: 9px 10px;
            font-size: 13px;
            color: #d9e8ef;
        }

        .head {
            display: flex;
            justify-content: space-between;
            gap: 8px;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .table {
            overflow-x: auto;
            border-radius: 12px;
            border: 1px solid var(--line);
            margin-top: calc(var(--space-main-gap) - 2px);
            background: rgba(255, 255, 255, .1);
            width: 100%;
        }

        table {
            width: 100%;
            min-width: 640px;
            border-collapse: collapse;
            background: transparent;
        }

        th,
        td {
            border-bottom: 1px solid rgba(255, 255, 255, .12);
            text-align: left;
            padding: 11px;
            font-size: var(--fs-table);
            vertical-align: top;
        }

        th {
            background: rgba(255, 255, 255, .14);
            font-size: var(--fs-table-head);
            text-transform: uppercase;
            letter-spacing: .08em;
            color: #cfdee7;
            font-weight: 800;
        }

        td { color: #d7e6ee; font-weight: 600; }

        .badge {
            display: inline-block;
            border-radius: 999px;
            padding: 5px 8px;
            font-size: 11px;
            text-transform: uppercase;
            font-weight: 800;
            letter-spacing: .04em;
        }

        .ok { color: #c9f5df; background: rgba(16, 113, 77, .32); border: 1px solid rgba(136, 219, 186, .38); }
        .low { color: #ffe8bd; background: rgba(129, 92, 23, .32); border: 1px solid rgba(237, 194, 112, .42); }
        .out { color: #ffd2d7; background: rgba(133, 39, 47, .32); border: 1px solid rgba(232, 146, 156, .42); }
        .role { color: #d8eeff; background: rgba(33, 104, 162, .33); border: 1px solid rgba(133, 188, 234, .42); }

        .chip-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
            gap: 8px;
            margin-top: 10px;
        }

        .chip {
            border: 1px solid var(--line);
            border-radius: 11px;
            padding: 10px;
            background: rgba(255, 255, 255, .12);
            font-size: 12px;
            color: #e1f0fa;
        }

        .chip strong { display: block; color: #f0f8ff; font-size: 20px; font-family: Sora, Manrope, sans-serif; }

        .multi-select { min-height: 128px; color: #f4fbff; }
        .multi-select option {
            color: #ebf7ff;
            background: #274f65;
            padding: 4px 6px;
        }
        .multi-select option:checked {
            color: #ffffff;
            background: #2e8ab8;
        }

        .footer-note {
            margin-top: 8px;
            font-size: 12px;
            color: #d0e2ef;
            font-weight: 600;
        }

        @media (min-width: 1536px) {
            :root {
                --ui-font-size: 15px;
                --sidebar-width: 290px;
                --space-shell: 18px;
                --space-main-gap: 14px;
                --space-section: 14px;
                --space-card-pad: 22px;
                --auth-pad: 28px;
                --hero-pad: 48px;
                --space-control-y: 12px;
                --space-control-x: 13px;
                --radius-card: 22px;
                --fs-top-title: 26px;
                --fs-section-title: 17px;
                --fs-muted: 14px;
                --fs-table: 13.5px;
                --fs-table-head: 11px;
                --fs-kpi: clamp(24px, 1.9vw, 32px);
            }
            .auth { max-width: 1360px; }
            .cards { grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)); }
        }

        @media (max-width: 1440px) {
            :root {
                --ui-font-size: 14px;
                --sidebar-width: 260px;
                --space-shell: 14px;
                --space-main-gap: 12px;
                --space-section: 12px;
                --space-card-pad: 19px;
                --auth-pad: 22px;
                --hero-pad: 36px;
                --space-control-y: 10px;
                --space-control-x: 12px;
                --radius-card: 19px;
                --fs-top-title: 24px;
                --fs-section-title: 16px;
                --fs-muted: 13px;
                --fs-table: 13px;
                --fs-table-head: 11px;
            }
            .customer-home-grid { grid-template-columns: minmax(0, 1.05fr) minmax(280px, .95fr); }
            .customer-home-panels { grid-template-columns: repeat(3, minmax(0, 1fr)); }
            .customer-shop-grid { grid-template-columns: minmax(0, 1.05fr) minmax(300px, .95fr); }
            .customer-orders-layout,
            .customer-saved-grid,
            .customer-account-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 1200px) {
            :root {
                --ui-font-size: 13.5px;
                --space-shell: 12px;
                --space-main-gap: 10px;
                --space-section: 10px;
                --space-card-pad: 16px;
                --auth-pad: 18px;
                --hero-pad: 30px;
                --space-control-y: 9px;
                --space-control-x: 10px;
                --radius-card: 16px;
                --fs-top-title: 22px;
                --fs-section-title: 15px;
                --fs-muted: 12px;
                --fs-table: 12.5px;
                --fs-table-head: 10px;
                --fs-kpi: clamp(22px, 3.2vw, 28px);
            }
            .layout3 { grid-template-columns: 1fr 1fr; }
            .customer-home-grid,
            .customer-home-panels,
            .customer-shop-grid,
            .customer-orders-layout,
            .customer-saved-grid,
            .customer-account-grid { grid-template-columns: 1fr; }
            .customer-home-metrics,
            .customer-kpi-strip,
            .pos-step-strip,
            .pos-summary-grid,
            .pos-success-metrics { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .customer-filter-grid,
            .customer-meta-grid,
            .pos-hero,
            .pos-layout { grid-template-columns: 1fr; }
            .customer-mobile-cart-fab { display: block; }
        }

        @media (max-width: 1080px) {
            :root {
                --sidebar-width: 100%;
                --space-shell: 11px;
                --space-main-gap: 10px;
                --space-section: 10px;
                --space-card-pad: 15px;
                --auth-pad: 16px;
                --hero-pad: 26px;
                --fs-top-title: 21px;
                --fs-section-title: 15px;
                --fs-muted: 12px;
                --fs-table: 12px;
                --fs-table-head: 10px;
            }
            .auth { grid-template-columns: 1fr; }
            .shell {
                grid-template-columns: 1fr;
                gap: 10px;
            }
            .sidebar {
                position: relative;
                top: auto;
                height: auto;
                padding: var(--space-card-pad);
            }
            .menu {
                display: flex;
                gap: 8px;
                overflow-x: auto;
                padding-bottom: 2px;
                scrollbar-width: thin;
            }
            .menu button {
                width: auto;
                white-space: nowrap;
                min-width: max-content;
            }
            .layout2 { grid-template-columns: 1fr; }
            .pos-hero-metrics { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 900px) {
            :root {
                --ui-font-size: 13px;
                --space-shell: 10px;
                --space-main-gap: 9px;
                --space-section: 9px;
                --space-card-pad: 14px;
                --auth-pad: 14px;
                --hero-pad: 24px;
                --space-control-y: 9px;
                --space-control-x: 10px;
                --radius-card: 14px;
                --fs-top-title: 20px;
                --fs-section-title: 14px;
                --fs-muted: 11.5px;
                --fs-table: 12px;
                --fs-table-head: 10px;
            }
            .top { flex-direction: column; align-items: flex-start; }
            .top .actions {
                width: 100%;
                justify-content: flex-start;
            }
            .top .actions > button {
                width: auto;
                min-width: 120px;
            }
            .userbox { width: 100%; }
            table { min-width: 560px; }
        }

        @media (max-width: 760px) {
            :root {
                --ui-font-size: 12.5px;
                --space-shell: 8px;
                --space-main-gap: 8px;
                --space-section: 8px;
                --space-card-pad: 13px;
                --auth-pad: 12px;
                --hero-pad: 22px;
                --space-control-y: 8px;
                --space-control-x: 9px;
                --radius-card: 13px;
                --fs-top-title: 19px;
                --fs-section-title: 14px;
                --fs-muted: 11px;
                --fs-table: 11.5px;
                --fs-table-head: 10px;
                --fs-kpi: clamp(20px, 5.6vw, 24px);
            }
            .grid2,
            .grid3 { grid-template-columns: 1fr; }
            .pos-filter-grid,
            .pos-hero-metrics,
            .pos-step-strip,
            .pos-summary-grid,
            .pos-success-metrics,
            .pos-card-actions,
            .pos-meta-grid { grid-template-columns: 1fr; }
            .pos-cart-line { grid-template-columns: 1fr; }
            .pos-line-total { justify-items: start; text-align: left; }
            .main { padding: 0; }
            table { min-width: 500px; }
            th, td { padding: 9px; }
        }

        @media (max-width: 480px) {
            :root {
                --ui-font-size: 12px;
                --space-shell: 7px;
                --space-main-gap: 7px;
                --space-section: 7px;
                --space-card-pad: 12px;
                --auth-pad: 10px;
                --hero-pad: 18px;
                --space-control-y: 8px;
                --space-control-x: 8px;
                --radius-card: 12px;
                --fs-top-title: 18px;
                --fs-section-title: 13.5px;
                --fs-muted: 10.5px;
                --fs-table: 11px;
                --fs-table-head: 10px;
            }
            .top h2 { font-size: var(--fs-top-title); }
            .top p { font-size: var(--ui-font-size); }
            .menu button { padding: var(--space-control-y) var(--space-control-x); font-size: var(--ui-font-size); }
            table { min-width: 440px; }
            .btn-inline { min-width: 68px; }
        }

        @media (max-width: 640px) {
            .table {
                border: 0;
                background: transparent;
                overflow: visible;
                margin-top: 8px;
            }

            .table table {
                min-width: 0;
                border-collapse: separate;
                border-spacing: 0 8px;
            }

            .table thead {
                display: none;
            }

            .table tbody,
            .table tr,
            .table td {
                display: block;
                width: 100%;
            }

            .table tr {
                background: rgba(255, 255, 255, .12);
                border: 1px solid var(--line);
                border-radius: 12px;
                padding: 8px 10px;
            }

            .table td {
                border: 0;
                border-bottom: 1px dashed rgba(255, 255, 255, .14);
                margin: 0;
                padding: 7px 2px;
                font-size: 12px;
                display: grid;
                grid-template-columns: minmax(110px, 42%) minmax(0, 58%);
                align-items: start;
                gap: 8px;
            }

            .table td::before {
                content: attr(data-label);
                color: #c5ddec;
                font-size: 10px;
                letter-spacing: .06em;
                text-transform: uppercase;
                font-weight: 800;
            }

            .table td:last-child {
                border-bottom: 0;
            }

            .table td[colspan] {
                display: block;
                padding: 8px 2px;
            }

            .table td[colspan]::before {
                content: none;
            }

            .table td .inline-actions {
                justify-content: flex-start;
            }

            .table td select,
            .table td button {
                max-width: 100%;
            }
        }
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
                scroll-behavior: auto !important;
            }
        }
        @include('partials.public-landing-styles')
        @include('partials.customer-portal-styles')
        @include('partials.staff-portal-styles')

        .workspace-guide-panel {
            display: grid;
            gap: 12px;
            margin-bottom: 12px;
        }

        .workspace-guide-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            flex-wrap: wrap;
        }

        .workspace-guide-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .workspace-guide-actions button {
            min-width: 0;
        }

        .workspace-guide-helper {
            padding: 12px 14px;
            border-radius: 18px;
            border: 1px solid rgba(255, 255, 255, .16);
            background: rgba(255, 255, 255, .08);
            color: #eef8f0;
            font-size: 13px;
            line-height: 1.5;
        }

        .workspace-guide-strip {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 10px;
        }

        .workspace-guide-card {
            display: grid;
            gap: 4px;
            padding: 12px 14px;
            border-radius: 18px;
            border: 1px solid rgba(255, 255, 255, .12);
            background: rgba(255, 255, 255, .06);
            color: #dff1e4;
        }

        .workspace-guide-card strong {
            color: #ffffff;
            font-size: 14px;
        }

        .workspace-guide-card span {
            color: rgba(238, 248, 240, .82);
            font-size: 12px;
            line-height: 1.45;
        }

        .workspace-guide-card.active {
            background: rgba(255, 255, 255, .18);
            border-color: rgba(255, 255, 255, .24);
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .08);
        }

        @media (max-width: 640px) {
            .workspace-guide-top {
                align-items: stretch;
            }

            .workspace-guide-actions {
                width: 100%;
            }
        }
        /* Clean admin and super admin polish */
        #dashboardView .card,
        #operationsView .card,
        #reportsView .card,
        #usersView .card,
        #superAdminView .card {
            padding: 16px;
        }

        #dashboardView .title,
        #operationsView .title,
        #reportsView .title,
        #usersView .title,
        #superAdminView .title {
            margin-bottom: 4px;
        }

        #dashboardView .muted,
        #operationsView .muted,
        #reportsView .muted,
        #usersView .muted,
        #superAdminView .muted,
        #dashboardView .footer-note,
        #operationsView .footer-note,
        #reportsView .footer-note,
        #usersView .footer-note,
        #superAdminView .footer-note {
            max-width: 34rem;
            font-size: 12px;
            line-height: 1.5;
            color: #b5c8d3;
        }

        .top,
        #operationsView .op-layout-nav,
        #reportsView .op-layout-nav,
        #usersView .op-layout-nav,
        #superAdminView .op-layout-nav {
            padding: 14px 16px;
        }

        .top h2 {
            font-size: clamp(20px, 1.8vw, 24px);
        }

        .top p {
            max-width: 32rem;
        }

        .menu button {
            font-weight: 700;
        }

        .userbox {
            min-width: 122px;
            display: grid;
            gap: 2px;
        }

        #dashboardView .cards,
        #superAdminOverviewGroup .cards {
            grid-template-columns: repeat(auto-fit, minmax(min(180px, 100%), 1fr));
        }

        #dashboardView .kpi h4,
        #superAdminView .kpi h4 {
            font-size: 11px;
            letter-spacing: .08em;
        }

        #operationsView .op-layout-tabs button,
        #reportsView .op-layout-tabs button,
        #usersView .op-layout-tabs button,
        #superAdminView .op-layout-tabs button {
            padding: 7px 11px;
            font-size: 13px;
        }

        #dashboardView .table,
        #operationsView .table,
        #reportsView .table,
        #usersView .table,
        #superAdminView .table {
            margin-top: 10px;
        }

        #reportsView .layout2,
        #usersView .layout2,
        #superAdminView .layout2 {
            gap: 10px;
        }

        
        #superAdminView .super-admin-tabs {
            flex-wrap: wrap;
        }

        #superAdminView .super-admin-feature-grid,
        #superAdminView .super-admin-detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(min(260px, 100%), 1fr));
            gap: 12px;
        }

        #superAdminView .sa-feature-card {
            display: grid;
            gap: 12px;
            align-content: start;
            min-height: 100%;
        }

        #superAdminView .sa-feature-card-wide {
            grid-column: span 2;
        }

        #superAdminView .sa-feature-tag {
            display: inline-flex;
            align-items: center;
            width: fit-content;
            padding: 6px 10px;
            border-radius: 999px;
            border: 1px solid rgba(171, 227, 198, .2);
            background: rgba(120, 221, 161, .09);
            color: #b7f39a;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        #superAdminView .sa-feature-metric {
            display: grid;
            gap: 4px;
        }

        #superAdminView .sa-feature-metric strong {
            font-size: clamp(22px, 2vw, 28px);
            line-height: 1;
            color: #f4fbff;
        }

        #superAdminView .sa-feature-metric span,
        #superAdminView .sa-feature-stats span,
        #superAdminView .sa-feature-list span {
            color: #c4d7e3;
            font-size: 12px;
        }

        #superAdminView .sa-feature-stats {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        #superAdminView .sa-feature-stats > div,
        #superAdminView .sa-feature-list > div {
            padding: 10px 12px;
            border-radius: 14px;
            border: 1px solid rgba(171, 227, 198, .14);
            background: rgba(255, 255, 255, .04);
            display: grid;
            gap: 4px;
        }

        #superAdminView .sa-feature-stats strong,
        #superAdminView .sa-feature-list strong {
            font-size: 17px;
            color: #f4fbff;
        }

        #superAdminView .sa-feature-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        #superAdminView .sa-feature-actions.stacked {
            display: grid;
            grid-template-columns: 1fr;
        }

        #superAdminView .sa-feature-list {
            display: grid;
            gap: 8px;
        }

        #superAdminView .sa-feature-actions button,
        #superAdminView .sa-feature-actions button {
            min-width: 0;
        }

        @media (max-width: 920px) {
            #superAdminView .sa-feature-card-wide {
                grid-column: span 1;
            }
        }
        /* Final POS cart overlap fix */
        #posCartRows .pos-cart-line {
            display: grid !important;
            grid-template-columns: minmax(0, 1fr) !important;
            gap: 12px;
            align-items: stretch;
        }
        #posCartRows .pos-cart-line-main {
            min-width: 0;
            display: grid;
            gap: 8px;
        }
        #posCartRows .pos-cart-line-main strong {
            font-size: 15px;
            line-height: 1.2;
        }
        #posCartRows .pos-cart-line-note {
            display: flex;
            flex-wrap: wrap;
            gap: 6px 8px;
            line-height: 1.4;
        }
        #posCartRows .pos-cart-line-note span {
            display: inline-flex;
            align-items: center;
            padding: 4px 8px;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, .08);
            background: rgba(255, 255, 255, .06);
            white-space: nowrap;
        }
        #posCartRows .pos-cart-line-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px 12px;
            align-items: end;
        }
        #posCartRows .pos-cart-qty {
            min-width: 126px;
            flex: 1 1 148px;
            max-width: 172px;
        }
        #posCartRows .pos-cart-qty label,
        #posCartRows .pos-line-total span {
            white-space: nowrap;
        }
        #posCartRows .pos-cart-qty input {
            width: 100%;
            height: 44px;
            text-align: center;
            font-weight: 800;
        }
        #posCartRows .pos-line-total {
            min-width: 124px;
            flex: 1 1 132px;
            display: grid;
            gap: 4px;
            justify-items: start;
            text-align: left;
        }
        #posCartRows .pos-line-total strong {
            white-space: nowrap;
        }
        #posCartRows .pos-cart-line .pos-remove-btn,
        #posCartRows .pos-cart-line .danger {
            margin-left: auto;
            min-width: 96px;
            align-self: end;
        }
        @media (max-width: 480px) {
            #posCartRows .pos-cart-line-actions {
                align-items: stretch;
            }
            #posCartRows .pos-cart-qty,
            #posCartRows .pos-line-total,
            #posCartRows .pos-cart-line .pos-remove-btn,
            #posCartRows .pos-cart-line .danger {
                flex: 1 1 100%;
                max-width: none;
                min-width: 0;
                margin-left: 0;
            }
            #posCartRows .pos-cart-line .pos-remove-btn,
            #posCartRows .pos-cart-line .danger {
                width: 100%;
            }
        }
    </style>
</head>
<body>
<div class="live-bg" aria-hidden="true">
    <div class="pointer-aura"></div>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
</div>
@include('partials.public-landing')

<section id="appSection" class="shell hidden">
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-lockup">
                <span class="brand-emblem" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64">
                      <defs>
                        <linearGradient id="customerBrandBg" x1="0" y1="0" x2="1" y2="1">
                          <stop offset="0" stop-color="#0D3D53"/>
                          <stop offset="1" stop-color="#0B2635"/>
                        </linearGradient>
                        <linearGradient id="customerBrandCrate" x1="0" y1="0" x2="0" y2="1">
                          <stop offset="0" stop-color="#E8B65D"/>
                          <stop offset="1" stop-color="#C58C35"/>
                        </linearGradient>
                      </defs>
                      <rect width="64" height="64" rx="14" fill="url(#customerBrandBg)"/>
                      <circle cx="32" cy="32" r="22" fill="#1C6A4D" fill-opacity="0.35"/>
                      <path d="M32 13c8.2 0 14 5.8 14 14-6.9 0-11.8-2.5-14-7.1-2.2 4.6-7.1 7.1-14 7.1 0-8.2 5.8-14 14-14z" fill="#6DE29A"/>
                      <rect x="31" y="24" width="2" height="8" rx="1" fill="#D7FFE8"/>
                      <rect x="16" y="34" width="32" height="18" rx="4" fill="url(#customerBrandCrate)"/>
                      <path d="M20 40h24M20 45h24M24 34v18M32 34v18M40 34v18" stroke="#8B5D1E" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </span>
                <div class="brand-copy">
                    <h3 id="brandTitle">Farm Supply Inventory</h3>
                    <p id="brandSubtitle">Daily inventory workspace</p>
                </div>
            </div>
            <span id="brandModePill" class="brand-mode-pill">Control Center</span>
        </div>
        <nav class="menu">
            <button id="dashboardMenu" class="menu-btn active" data-view="dashboardView" type="button">Dashboard</button>
            <button id="staffHomeMenu" class="menu-btn hidden" data-view="staffHomeView" type="button">Staff Desk</button>
            <button id="customerHomeMenu" class="menu-btn hidden" data-view="customerLandingView" type="button">Home</button>
            <button id="customerMenu" class="menu-btn hidden" data-view="customerView" data-customer-section="shop" type="button">Shop</button>
            <button id="customerOrdersMenu" class="menu-btn hidden" data-view="customerView" data-customer-section="orders" type="button">My Orders</button>
            <button id="customerSavedMenu" class="menu-btn hidden" data-view="customerView" data-customer-section="saved" type="button">Favorites</button>
            <button id="customerProfileMenu" class="menu-btn hidden" data-view="customerView" data-customer-section="account" type="button">Profile</button>
            <button id="posMenu" class="menu-btn hidden" data-view="posView" type="button">POS</button>
            <button id="operationsMenu" class="menu-btn" data-view="operationsView" type="button">Operations</button>
            <button id="reportsMenu" class="menu-btn" data-view="reportsView" type="button">Reports</button>
            <button id="usersMenu" class="menu-btn hidden" data-view="usersView" type="button">Users</button>
            <button id="superAdminMenu" class="menu-btn hidden" data-view="superAdminView" type="button">Super Admin</button>
        </nav>
    </aside>
    <main class="main">
        <header class="top">
            <div>
                <h2 id="viewTitle">Dashboard</h2>
                <p id="viewSubtitle">See stock, sales, and alerts at a glance.</p>
            </div>
            <div class="actions">
                <div class="userbox">
                    <strong id="whoName">-</strong><br>
                    <span id="whoRole">-</span>
                </div>
                <button id="refreshBtn" class="secondary" type="button">Refresh</button>
                <button id="logoutBtn" class="danger" type="button">Logout</button>
            </div>
        </header>

        <div class="views">
            <section id="staffHomeView" class="view hidden">
                <div class="staff-home-shell">
                    <article class="card staff-home-hero">
                        <div class="staff-home-copy">
                            <span class="hero-eyebrow pos-eyebrow">Staff Operations Hub</span>
                            <h3>Start the shift in one clear workspace.</h3>
                            <p>Use checkout, stock checks, and receiving without extra admin clutter.</p>
                            <div class="staff-home-primary">
                                <button id="staffHomePosBtn" type="button">Open POS</button>
                                <p class="staff-home-note">Use the menu for stock, receiving, or reports.</p>
                            </div>
                            <div class="staff-home-alerts">
                                <span>Stock watch</span>
                                <span>Receiving ready</span>
                                <span>Shift snapshot</span>
                            </div>
                        </div>
                        <div class="staff-home-focus">
                            <article class="staff-home-panel">
                                <span class="customer-home-tag">Shift Snapshot</span>
                                <h4>Today's snapshot</h4>
                                <p>Key numbers for stock, sales, and suppliers.</p>
                                <div class="chip-grid">
                                    <div class="chip"><strong id="staffFocusCatalog">0</strong><span>Catalog Ready</span></div>
                                    <div class="chip"><strong id="staffFocusSales">0</strong><span>Recent Sales</span></div>
                                    <div class="chip"><strong id="staffFocusSuppliers">0</strong><span>Suppliers</span></div>
                                    <div class="chip"><strong id="staffFocusValue">PHP 0.00</strong><span>Inventory Value</span></div>
                                </div>
                            </article>
                            <article class="staff-home-panel">
                                <span class="customer-home-tag">Staff Flow</span>
                                <h4>Next steps</h4>
                                <div class="staff-home-flow">
                                    <div class="staff-home-flow-item">
                                        <strong>1. Open the counter</strong>
                                        <span>Start checkout for walk-in and regular customers.</span>
                                    </div>
                                    <div class="staff-home-flow-item">
                                        <strong>2. Review stock alerts</strong>
                                        <span>Review items that need action.</span>
                                    </div>
                                    <div class="staff-home-flow-item">
                                        <strong>3. Receive supplier deliveries</strong>
                                        <span>Post supplier stock-in when deliveries arrive.</span>
                                    </div>
                                </div>
                            </article>
                        </div>
                    </article>

                    <div class="staff-home-metrics">
                        <article class="staff-home-metric">
                            <span>Active products</span>
                            <strong id="staffMetricActive">0</strong>
                            <small>Items ready for today's work.</small>
                        </article>
                        <article class="staff-home-metric">
                            <span>Low-stock alerts</span>
                            <strong id="staffMetricLow">0</strong>
                            <small>Items that need attention.</small>
                        </article>
                        <article class="staff-home-metric">
                            <span>Today sales</span>
                            <strong id="staffMetricToday">PHP 0.00</strong>
                            <small>Sales total from today's shift.</small>
                        </article>
                        <article class="staff-home-metric">
                            <span>Branches</span>
                            <strong id="staffMetricBranches">0</strong>
                            <small>Locations in this workspace.</small>
                        </article>
                    </div>

                    <div class="staff-home-grid">
                        <div class="staff-home-stack">
                            <article class="card staff-home-panel">
                                <span class="customer-home-tag">Low-Stock Watch</span>
                                <h4>Items to review next</h4>
                                <p>Restock, transfer, or receive next.</p>
                                <div id="staffLowList" class="staff-home-list"></div>
                            </article>
                            <article class="card staff-home-panel">
                                <span class="customer-home-tag">Recent Movement</span>
                                <h4>Latest stock activity</h4>
                                <p>Latest stock-in, stock-out, and adjustments.</p>
                                <div id="staffRecentList" class="staff-home-list"></div>
                            </article>
                        </div>

                        <article class="card staff-home-panel staff-home-mini-table">
                            <span class="customer-home-tag">POS Snapshot</span>
                            <h4>Latest counter sales</h4>
                            <p>Recent counter sales at a glance.</p>
                            <div class="table">
                                <table>
                                    <thead>
                                        <tr><th>Sale #</th><th>Cashier</th><th>Items</th><th>Total</th></tr>
                                    </thead>
                                    <tbody id="staffPosSalesRows"></tbody>
                                </table>
                            </div>
                        </article>
                    </div>
                </div>
            </section>
            <section id="customerLandingView" class="view hidden">
                <div class="customer-home-shell">
                    <article id="customerHomeHero" class="card customer-home-hero">
                        <div class="customer-home-nav" aria-label="Customer landing sections">
                            <button type="button" class="secondary btn-inline" data-home-target="customerHomeHero">Overview</button>
                            <button type="button" class="secondary btn-inline" data-home-target="customerAboutSection">Steps</button>
                            <button type="button" class="secondary btn-inline" data-home-target="customerServicesSection">Quick Tools</button>
                            <button type="button" class="secondary btn-inline" data-home-target="customerContactSection">Delivery</button>
                        </div>
                        <div class="customer-home-grid">
                            <div class="customer-home-copy">
                                <span class="hero-eyebrow pos-eyebrow">Welcome Back</span>
                                <h3>Order farm supplies in one clear workspace.</h3>
                                <p>Browse products, check your cart, place orders, and track updates without extra clutter.</p>
                                <div class="chip-grid customer-home-metrics">
                                    <div class="chip"><strong id="customerHomeProductCount">0</strong><span>Products</span></div>
                                    <div class="chip"><strong id="customerHomeCartCount">0</strong><span>Cart</span></div>
                                    <div class="chip"><strong id="customerHomeOrderCount">0</strong><span>Active Orders</span></div>
                                    <div class="chip"><strong id="customerHomeSavedCount">0</strong><span>Favorites</span></div>
                                </div>
                                <div class="customer-home-actions">
                                    <button id="customerHomeShopBtn" type="button" class="btn-inline">Browse Products</button>
                                    <button id="customerHomeOrdersBtn" type="button" class="secondary btn-inline">Track Orders</button>
                                    <button id="customerHomeProfileBtn" type="button" class="secondary btn-inline">Edit Profile</button>
                                </div>
                            </div>
                            <div class="customer-home-profile">
                                <div class="customer-actions">
                                    <div>
                                        <span class="customer-home-tag">Delivery Profile</span>
                                        <h3 id="customerHomeProfileName" class="title">-</h3>
                                    </div>
                                    <span class="customer-inline-note">Check details</span>
                                </div>
                                <div class="customer-home-detail">
                                    <span>Email</span>
                                    <strong id="customerHomeProfileEmail">-</strong>
                                </div>
                                <div class="customer-home-detail">
                                    <span>Phone</span>
                                    <strong id="customerHomeProfilePhone">Add a phone number</strong>
                                </div>
                                <div class="customer-home-detail">
                                    <span>Address</span>
                                    <strong id="customerHomeProfileAddress">Add a delivery address</strong>
                                </div>
                                <div class="chip-grid">
                                    <div class="chip"><strong id="customerHomeUnreadCount">0</strong><span>Unread</span></div>
                                    <div class="chip"><strong id="customerHomeLatestOrder">No orders yet</strong><span>Latest Order</span></div>
                                </div>
                            </div>
                        </div>
                    </article>

                    <div class="customer-home-panels">
                        <article id="customerAboutSection" class="card customer-home-panel">
                            <span class="customer-home-tag">Start Here</span>
                            <h3 class="title">Use the same simple flow each time.</h3>
                            <div class="customer-home-step-list"><div class="customer-home-step"><strong>1. Browse</strong><span>Find the item you need.</span></div><div class="customer-home-step"><strong>2. Review</strong><span>Check stock, price, and details.</span></div><div class="customer-home-step"><strong>3. Checkout</strong><span>Place the order and track it later.</span></div></div>
                        </article>

                        <article id="customerServicesSection" class="card customer-home-panel">
                            <span class="customer-home-tag">Quick Tools</span>
                            <h3 class="title">Main customer tools</h3>
                            <div class="customer-home-mini-list">
                                <div class="customer-home-mini-item">
                                    <strong>Browse products</strong>
                                    <span>Find what you need fast.</span>
                                </div>
                                <div class="customer-home-mini-item">
                                    <strong>Checkout</strong>
                                    <span>Choose COD, cash, or online.</span>
                                </div>
                                <div class="customer-home-mini-item">
                                    <strong>Track orders</strong>
                                    <span>See status in one place.</span>
                                </div>
                            </div>
                        </article>

                        <article id="customerContactSection" class="card customer-home-panel">
                            <span class="customer-home-tag">Delivery Details</span>
                            <h3 class="title">Keep checkout ready.</h3>
                            <div class="customer-home-mini-list">
                                <div class="customer-home-mini-item">
                                    <strong id="customerContactEmail">-</strong>
                                    <span>Email</span>
                                </div>
                                <div class="customer-home-mini-item">
                                    <strong id="customerContactPhone">Add a phone number</strong>
                                    <span>Phone</span>
                                </div>
                                <div class="customer-home-mini-item">
                                    <strong id="customerContactAddress">Add a delivery address</strong>
                                    <span>Address</span>
                                </div>
                            </div>
                            <div class="customer-home-actions">
                                <button id="customerHomeContactProfileBtn" type="button" class="secondary btn-inline">Edit Profile</button>
                            </div>
                        </article>
                    </div>
                </div>
            </section>

            <section id="dashboardView" class="view active">
                <article class="card workspace-guide-panel">
                    <div class="workspace-guide-top">
                        <div>
                            <span class="hero-eyebrow pos-eyebrow">Admin overview</span>
                            <h3 class="title">Check today's priorities first.</h3>
                            <p class="muted">Review stock risk first, then open operations or reports as needed.</p>
                        </div>
                        <div class="workspace-guide-actions">
                            <button type="button" class="secondary btn-inline" data-nav-view="operationsView" data-nav-section="setup" data-nav-card="opMasterDataCard">Open Stock Tasks</button>
                            <button type="button" class="secondary btn-inline" data-nav-view="reportsView" data-nav-section="inventory" data-nav-card="reportMovementCard">Open Reports</button>
                        </div>
                    </div>
                    <div class="workspace-guide-strip" aria-label="Admin workflow">
                        <div class="workspace-guide-card active">
                            <strong>1. Watch</strong>
                            <span>Low stock and recent movement.</span>
                        </div>
                        <div class="workspace-guide-card">
                            <strong>2. Update</strong>
                            <span>Catalog, stock, and receiving.</span>
                        </div>
                        <div class="workspace-guide-card">
                            <strong>3. Review</strong>
                            <span>Sales, value, and logs.</span>
                        </div>
                    </div>
                </article>
                <div class="cards">
                    <article class="card kpi"><h4>Products</h4><div id="kpiProducts" class="value">0</div></article>
                    <article class="card kpi"><h4>Active Products</h4><div id="kpiActive" class="value">0</div></article>
                    <article class="card kpi"><h4>Low Stock</h4><div id="kpiLow" class="value">0</div></article>
                    <article class="card kpi"><h4>Out Of Stock</h4><div id="kpiOut" class="value">0</div></article>
                    <article class="card kpi"><h4>Inventory Value</h4><div id="kpiValue" class="value kpi-money">&#8369;0.00</div></article>
                    <article class="card kpi"><h4>Today Sales</h4><div id="kpiToday" class="value kpi-money">&#8369;0.00</div></article>
                    <article class="card kpi"><h4>Month Sales</h4><div id="kpiMonth" class="value kpi-money">&#8369;0.00</div></article>
                    <article class="card kpi"><h4>Total Suppliers</h4><div id="kpiSuppliers" class="value">0</div></article>
                    <article class="card kpi"><h4>Total Branches</h4><div id="kpiBranches" class="value">0</div></article>
                </div>
                <div class="layout2">
                    <article class="card">
                        <h3 class="title">Low-Stock Watch</h3>
                        <p class="muted">Below reorder point.</p>
                        <div class="table">
                            <table>
                                <thead><tr><th>Product</th><th>Stock</th><th>Reorder</th><th>Status</th></tr></thead>
                                <tbody id="lowRows"></tbody>
                            </table>
                        </div>
                    </article>
                    <article class="card">
                        <h3 class="title">Recent Activity</h3>
                        <p class="muted">Latest stock movement.</p>
                        <div id="recentList" class="list"></div>
                    </article>
                </div>
                <div class="layout3">
                    <article class="card">
                        <h3 class="title">Top Movers</h3>
                        <p class="muted">Highest movement volume.</p>
                        <div class="table">
                            <table>
                                <thead><tr><th>Product</th><th>Moved Qty</th></tr></thead>
                                <tbody id="topRows"></tbody>
                            </table>
                        </div>
                    </article>
                    <article class="card">
                        <h3 class="title">Stock by Category</h3>
                        <p class="muted">Current stock by category.</p>
                        <div class="table">
                            <table>
                                <thead><tr><th>Category</th><th>Stock</th></tr></thead>
                                <tbody id="catRows"></tbody>
                            </table>
                        </div>
                    </article>
                    <article class="card">
                        <h3 class="title">Monthly Sales</h3>
                        <p class="muted">Recent monthly totals.</p>
                        <div class="table">
                            <table>
                                <thead><tr><th>Month</th><th>Total</th></tr></thead>
                                <tbody id="trendRows"></tbody>
                            </table>
                        </div>
                    </article>
                </div>
            </section>

            <section id="customerView" class="view hidden">
                <article class="card customer-layout-nav">
                    <div class="customer-actions">
                        <div>
                            <span class="hero-eyebrow pos-eyebrow">Customer Portal</span>
                            <h3 class="title">Customer workspace</h3>
                            <p class="muted">Browse, checkout, and track orders in one place.</p>
                        </div>
                        <div class="chip-grid customer-kpi-strip">
                            <div class="chip"><strong id="customerHeroProductCount">0</strong><span>Products</span></div>
                            <div class="chip"><strong id="customerHeroCartCount">0</strong><span>Cart</span></div>
                            <div class="chip"><strong id="customerHeroOrderCount">0</strong><span>Open orders</span></div>
                            <div class="chip"><strong id="customerHeroSavedCount">0</strong><span>Favorites</span></div>
                        </div>
                    </div>
                    <div id="customerNotice"></div>
                    <div id="customerGuideHelper" class="customer-guide-helper">Start with Browse, then review and checkout.</div>
                    <div id="customerSectionTabs" class="op-layout-tabs" role="tablist" aria-label="Customer hub sections">
                        <button type="button" class="active" data-customer-section="shop">Browse</button>
                        <button type="button" data-customer-section="orders">Orders</button>
                        <button type="button" data-customer-section="saved">Favorites</button>
                        <button type="button" data-customer-section="account">Profile</button>
                    </div>
                </article>

                <div id="customerShopGroup" class="customer-section-group">
                    <div class="customer-shop-grid">
                        <article id="customerCatalogCard" class="card">
                            <div class="customer-actions">
                                <div>
                                    <h3 class="title">1. Browse products</h3>
                                    <p class="muted">Search, filter, and open any item.</p>
                                </div>
                                <span class="customer-inline-note">Catalog</span>
                            </div>
                            <form id="customerCatalogFilter">
                                <div class="customer-filter-grid">
                                    <input id="customerSearchInput" name="search" placeholder="Search product, SKU, or barcode">
                                    <select id="customerStockFilter" name="stock_status">
                                        <option value="">All stock statuses</option>
                                        <option value="in">In stock</option>
                                        <option value="low">Low stock</option>
                                        <option value="out">Out of stock</option>
                                    </select>
                                    <select id="customerSortFilter" name="sort">
                                        <option value="name_asc">Name A-Z</option>
                                        <option value="price_asc">Price low to high</option>
                                        <option value="price_desc">Price high to low</option>
                                        <option value="stock_desc">Most stock available</option>
                                        <option value="latest">Newest products</option>
                                    </select>
                                </div>
                                <div class="actions" style="margin-top:10px;">
                                    <button type="submit" class="secondary">Apply</button>
                                    <button id="customerFilterResetBtn" type="button" class="secondary">Reset</button>
                                </div>
                            </form>
                            <div id="customerCatalogGrid" class="customer-catalog-grid"></div>
                        </article>

                        <div class="customer-side-grid">
                            <article id="customerSpotlightCard" class="card">
                                <div class="customer-actions">
                                    <div>
                                        <h3 class="title">2. Review product</h3>
                                        <p class="muted">Check stock, price, and details before adding it.</p>
                                    </div>
                                    <span class="customer-inline-note">Product</span>
                                </div>
                                <div id="customerSelectedProductCard" class="customer-spotlight"></div>
                            </article>

                            <article id="customerCartCard" class="card">
                                <div class="customer-actions">
                                    <div>
                                        <h3 class="title">3. Checkout</h3>
                                        <p class="muted">Review items and place the order here.</p>
                                    </div>
                                    <span id="customerCartSummaryText" class="customer-inline-note">0 items ready</span>
                                </div>
                                <div id="customerCartRows" class="customer-cart-list"></div>
                                <div class="chip-grid">
                                    <div class="chip"><strong id="customerCartItems">&#48;</strong><span>Total items</span></div>
                                    <div class="chip"><strong id="customerCartSubtotal">&#8369;0.00</strong><span>Subtotal</span></div>
                                    <div class="chip"><strong id="customerCartGrandTotal">&#8369;0.00</strong><span>Estimated total</span></div>
                                    <div class="chip"><strong id="customerCartPaymentLabel">COD</strong><span>Checkout mode</span></div>
                                </div>
                                <div class="customer-address-box">
                                    <strong>Delivery profile</strong>
                                    <span id="customerDeliveryAddressText">Add your delivery address in Profile before checkout.</span>
                                </div>
                                <form id="customerCheckoutForm" class="customer-checkout-form">
                                    <div class="grid2">
                                        <select id="customerCheckoutPayment" name="payment_method" required>
                                            <option value="cod">Cash on Delivery (COD)</option>
                                            <option value="cash">Cash</option>
                                            <option value="online_payment">Online Payment</option>
                                        </select>
                                        <input name="promotion_code" placeholder="Promotion code (optional)">
                                    </div>
                                    <textarea name="notes" rows="3" placeholder="Landmark or delivery notes"></textarea>
                                    <div id="customerCheckoutPaymentHelp" class="footer-note">Pay when the order arrives. We use your saved delivery details for the order.</div>
                                    <button id="customerCheckoutBtn" type="submit">Place COD order</button>
                                </form>
                            </article>
                        </div>
                    </div>
                </div>

                <div id="customerOrdersGroup" class="customer-orders-layout hidden">
                    <article id="customerOrdersCard" class="card">
                        <h3 class="title">Track orders</h3>
                        <p class="muted">See status and reorder quickly.</p>
                        <div id="customerOrderTrackingSummary" class="chip-grid"></div>
                        <div id="customerTrackingCards" class="customer-tracking-grid"></div>
                        <div class="table">
                            <table>
                                <thead><tr><th>Order #</th><th>Items</th><th>Payment</th><th>Status</th><th>Total</th><th>Date</th><th>Action</th></tr></thead>
                                <tbody id="customerOrderRows"></tbody>
                            </table>
                        </div>
                    </article>

                    <article id="customerRequestsCard" class="card">
                        <h3 class="title">Need something else?</h3>
                        <p class="muted">Send a request if an item is not ready to order yet.</p>
                        <form id="customerRequestForm">
                            <div class="grid2">
                                <select id="customerProductSelect" name="product_id" required></select>
                                <input type="number" min="1" name="requested_quantity" required placeholder="Requested quantity">
                            </div>
                            <textarea name="notes" rows="3" placeholder="Request notes (optional)"></textarea>
                            <button type="submit">Submit Request</button>
                        </form>

                        <div class="customer-block">
                            <h3 class="title">Requests</h3>
                            <div class="table">
                                <table>
                                    <thead><tr><th>Product</th><th>Qty</th><th>Status</th><th>Date</th><th>Action</th></tr></thead>
                                    <tbody id="customerRequestRows"></tbody>
                                </table>
                            </div>
                        </div>
                    </article>
                </div>

                <div id="customerSavedGroup" class="customer-saved-grid hidden">
                    <article id="customerFavoritesCard" class="card">
                        <h3 class="title">Saved for later</h3>
                        <p class="muted">Keep common products ready for faster reorder.</p>
                        <form id="customerFavoriteForm" class="grid2">
                            <select id="customerFavoriteProductSelect" name="product_id"></select>
                            <button type="submit" class="secondary">Save Favorite</button>
                        </form>
                        <div class="table">
                            <table>
                                <thead><tr><th>Product</th><th>SKU</th><th>Stock</th><th>Action</th></tr></thead>
                                <tbody id="customerFavoriteRows"></tbody>
                            </table>
                        </div>
                    </article>

                    <article id="customerAlertsCard" class="card">
                        <h3 class="title">Low-stock alerts</h3>
                        <p class="muted">See when your saved products are running low.</p>
                        <div class="table">
                            <table>
                                <thead><tr><th>Product</th><th>SKU</th><th>Stock</th><th>Reorder</th></tr></thead>
                                <tbody id="customerFavoriteAlertRows"></tbody>
                            </table>
                        </div>
                    </article>

                    <article id="customerNotificationsCard" class="card">
                        <div class="customer-actions">
                            <h3 class="title">Updates</h3>
                            <button id="customerMarkReadBtn" type="button" class="secondary btn-inline">Mark all read</button>
                        </div>
                        <p class="muted">Order updates and important alerts.</p>
                        <div class="table">
                            <table>
                                <thead><tr><th>Title</th><th>Message</th><th>Status</th><th>Date</th></tr></thead>
                                <tbody id="customerNotificationRows"></tbody>
                            </table>
                        </div>
                    </article>

                    <article id="customerSeasonCard" class="card">
                        <div class="customer-actions">
                            <h3 class="title">Seasonal picks</h3>
                            <button id="customerSeasonRefreshBtn" type="button" class="secondary btn-inline">Refresh</button>
                        </div>
                        <p id="customerSeasonInfo" class="muted">Suggestions based on season and recent demand.</p>
                        <form id="customerSeasonForm">
                            <div class="grid2">
                                <select id="customerSeasonMonth" name="month">
                                    <option value="1">January</option>
                                    <option value="2">February</option>
                                    <option value="3">March</option>
                                    <option value="4">April</option>
                                    <option value="5">May</option>
                                    <option value="6">June</option>
                                    <option value="7">July</option>
                                    <option value="8">August</option>
                                    <option value="9">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                                <input id="customerSeasonLimit" type="number" min="1" max="50" name="limit" value="12" placeholder="Max products">
                            </div>
                            <button type="submit" class="secondary">Load Suggestions</button>
                        </form>
                        <div class="table">
                            <table>
                                <thead><tr><th>Product</th><th>Category</th><th>Stock</th><th>Season Score</th></tr></thead>
                                <tbody id="customerSeasonRows"></tbody>
                            </table>
                        </div>
                    </article>
                </div>

                <div id="customerAccountGroup" class="customer-account-grid hidden">
                    <article id="customerProfileCard" class="card">
                        <h3 class="title">Profile</h3>
                        <p class="muted">Keep contact details and address ready for checkout.</p>
                        <form id="customerProfileForm">
                            <div class="grid2">
                                <input id="customerProfileName" name="name" required placeholder="Full name">
                                <input id="customerProfileEmail" type="email" name="email" required placeholder="Email">
                                <input id="customerProfilePhone" name="phone" placeholder="Phone">
                                <input id="customerProfileAddress" name="address" placeholder="Address">
                            </div>
                            <button type="submit">Save Profile</button>
                        </form>

                        <div class="customer-block">
                            <h3 class="title">Password</h3>
                            <form id="customerPasswordForm">
                                <div class="grid2">
                                    <input type="password" name="current_password" required placeholder="Current password">
                                    <input type="password" name="password" minlength="8" required placeholder="New password">
                                    <input type="password" name="password_confirmation" minlength="8" required placeholder="Confirm new password">
                                    <div></div>
                                </div>
                                <button type="submit" class="secondary">Update Password</button>
                            </form>
                        </div>
                    </article>

                    <article id="customerReviewCard" class="card">
                        <h3 class="title">Leave a review</h3>
                        <p class="muted">Share product feedback after ordering to help future customers.</p>
                        <form id="customerReviewForm">
                            <div class="grid2">
                                <select id="customerReviewProductSelect" name="product_id" required></select>
                                <select name="rating" required>
                                    <option value="5">5 - Excellent</option>
                                    <option value="4">4 - Very Good</option>
                                    <option value="3">3 - Good</option>
                                    <option value="2">2 - Fair</option>
                                    <option value="1">1 - Poor</option>
                                </select>
                            </div>
                            <textarea name="review" rows="3" placeholder="Write your product feedback..."></textarea>
                            <button type="submit" class="secondary">Submit Review</button>
                        </form>
                    </article>
                </div>

                <button id="customerMobileCartFab" class="customer-mobile-cart-fab" type="button">
                    <strong>Cart</strong>
                    <small id="customerMobileCartFabMeta">0 items | &#8369;0.00</small>
                </button>
                <div id="customerCartDrawer" class="customer-cart-drawer" aria-hidden="true">
                    <div id="customerCartDrawerBackdrop" class="customer-cart-drawer-backdrop"></div>
                    <aside class="customer-cart-drawer-panel" role="dialog" aria-label="Mobile customer cart">
                        <div class="customer-actions">
                            <div>
                                <h3 class="title">Quick cart</h3>
                                <p class="muted">Review items quickly and jump back to checkout.</p>
                            </div>
                            <button id="customerDrawerCloseBtn" type="button" class="secondary btn-inline">Close</button>
                        </div>
                        <div id="customerDrawerCartRows" class="customer-drawer-cart-list"></div>
                        <div class="chip-grid">
                            <div class="chip"><strong id="customerDrawerCartCount">0</strong><span>Items</span></div>
                            <div class="chip"><strong id="customerDrawerCartTotal">&#8369;0.00</strong><span>Total</span></div>
                        </div>
                        <button id="customerDrawerCheckoutBtn" type="button">Go to Checkout</button>
                    </aside>
                </div>
            </section>

            <section id="posView" class="view hidden">
                <div class="pos-shell">
                    <article class="card pos-hero">
                        <div class="pos-hero-copy">
                            <span class="hero-eyebrow pos-eyebrow">POS Workspace</span>
                            <h3 class="title">Fast counter checkout</h3>
                            <p class="muted">Pick a warehouse, add products, review payment, and finish the sale in one clear flow.</p>
                            <div class="pos-warehouse-line">
                                <strong id="posWarehouseLabel">No warehouse selected</strong>
                                <span id="posWarehouseStatus" class="muted">Choose a warehouse to load the live catalog.</span>
                            </div>
                            <div class="pos-step-strip">
                                <div class="pos-step-card">
                                    <strong>1</strong>
                                    <span>Select warehouse</span>
                                    <small>Load the live stock source first.</small>
                                </div>
                                <div class="pos-step-card">
                                    <strong>2</strong>
                                    <span>Add products</span>
                                    <small>Type the quantity you need, then add to sale.</small>
                                </div>
                                <div class="pos-step-card">
                                    <strong>3</strong>
                                    <span>Complete payment</span>
                                    <small>Review totals and finish checkout.</small>
                                </div>
                            </div>
                        </div>
                        <div class="chip-grid pos-hero-metrics">
                            <div class="chip"><strong id="posCatalogCount">0</strong><span>Catalog items</span></div>
                            <div class="chip"><strong id="posAvailableCount">0</strong><span>Available units</span></div>
                            <div class="chip"><strong id="posHeaderCartItems">0</strong><span>Cart items</span></div>
                            <div class="chip"><strong id="posHeaderTotal">&#8369;0.00</strong><span>Grand total</span></div>
                        </div>
                    </article>

                    <div class="pos-layout">
                        <article class="card pos-catalog-card">
                            <div class="pos-section-head">
                                <div>
                                    <h3 class="title">1. Pick products</h3>
                                    <p class="muted">Search the live catalog, set the quantity, and add items to the sale.</p>
                                </div>
                            </div>
                            <form id="posFilterForm">
                                <div class="pos-filter-grid">
                                    <select id="posWarehouseSelect" name="warehouse_id" required></select>
                                    <input id="posSearchInput" name="search" placeholder="Search product, SKU, or category">
                                </div>
                                <div class="actions" style="margin-top:10px;">
                                    <button type="submit" class="secondary">Apply Filter</button>
                                    <button id="posFilterResetBtn" type="button" class="secondary">Clear Search</button>
                                </div>
                            </form>
                            <div id="posCatalogStatus" class="pos-catalog-status">Select a warehouse to load the live POS catalog.</div>
                            <div id="posProductRows" class="pos-catalog-grid"></div>
                        </article>

                        <div class="pos-side">
                            <article class="card pos-checkout-card">
                                <div class="pos-section-head">
                                    <div>
                                        <h3 class="title">2. Review and pay</h3>
                                        <p class="muted">Check the cart, enter payment details, and complete the sale.</p>
                                    </div>
                                </div>
                                <form id="posCheckoutForm">
                                    <div class="grid2">
                                        <input name="customer_name" placeholder="Customer name (optional)">
                                        <select id="posPaymentMethod" name="payment_method">
                                            <option value="cash">Cash</option>
                                            <option value="gcash">GCash</option>
                                        </select>
                                        <select id="posDiscountType" name="discount_type">
                                            <option value="none">No discount</option>
                                            <option value="senior">Senior (20%)</option>
                                            <option value="pwd">PWD (20%)</option>
                                        </select>
                                        <input id="posDiscountInput" type="number" min="0" step="0.01" name="discount" value="0" placeholder="Discount (PHP)">
                                        <div id="posDiscountIdNumberWrap" class="field hidden">
                                            <label for="posDiscountIdNumberInput">Senior/PWD ID Number</label>
                                            <input id="posDiscountIdNumberInput" name="discount_id_number" placeholder="Enter valid ID number">
                                        </div>
                                        <div id="posDiscountIdImageWrap" class="field hidden">
                                            <label for="posDiscountIdImageInput">Senior/PWD ID Proof</label>
                                            <input id="posDiscountIdImageInput" type="file" name="discount_id_image" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
                                            <small>Upload ID image for discount confirmation (max 5MB).</small>
                                        </div>
                                        <div id="posCashReceivedWrap" class="field">
                                            <label for="posCashReceivedInput">Amount Tendered (PHP)</label>
                                            <input id="posCashReceivedInput" type="number" min="0" step="0.01" name="cash_received" placeholder="Enter amount tendered">
                                            <div id="posCashQuickActions" class="inline-actions" style="margin-top:6px;">
                                                <button type="button" class="secondary btn-inline pos-cash-quick-btn" data-mode="exact">Exact</button>
                                                <button type="button" class="secondary btn-inline pos-cash-quick-btn" data-add="100">+100</button>
                                                <button type="button" class="secondary btn-inline pos-cash-quick-btn" data-add="500">+500</button>
                                                <button type="button" class="secondary btn-inline pos-cash-quick-btn" data-add="1000">+1000</button>
                                            </div>
                                        </div>
                                        <div id="posGcashReferenceWrap" class="field hidden">
                                            <label for="posGcashReferenceInput">GCash Reference Number</label>
                                            <input id="posGcashReferenceInput" name="gcash_reference_number" placeholder="GCash reference number">
                                        </div>
                                        <div id="posGcashReceiptWrap" class="field hidden">
                                            <label for="posGcashReceiptInput">GCash Receipt Upload</label>
                                            <input id="posGcashReceiptInput" type="file" name="gcash_receipt" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
                                            <small>Upload JPG, PNG, or WEBP (max 5MB).</small>
                                        </div>
                                    </div>
                                    <textarea name="notes" rows="2" placeholder="POS notes (optional)"></textarea>
                                    <div class="pos-cart-head">
                                        <strong>Sale cart</strong>
                                        <span class="muted">Type the quantity directly. Remove any line you do not need.</span>
                                    </div>
                                    <div id="posCartRows" class="pos-cart-list"></div>
                                    <div class="chip-grid pos-summary-grid">
                                        <div class="chip"><strong id="posItemsTotal">0</strong><span>Items</span></div>
                                        <div class="chip"><strong id="posSubtotal">&#8369;0.00</strong><span>Subtotal</span></div>
                                        <div class="chip"><strong id="posDiscountAmount">&#8369;0.00</strong><span>Discount</span></div>
                                        <div class="chip"><strong id="posGrandTotal">&#8369;0.00</strong><span>Grand total</span></div>
                                        <div class="chip"><strong id="posAmountTendered">&#8369;0.00</strong><span>Amount tendered</span></div>
                                        <div class="chip"><strong id="posBalanceDue">&#8369;0.00</strong><span>Balance due</span></div>
                                        <div class="chip"><strong id="posChange">&#8369;0.00</strong><span>Change</span></div>
                                        <div class="chip"><strong id="posPaymentStatus">Ready</strong><span>Payment status</span></div>
                                    </div>
                                    <button id="posCheckoutBtn" type="submit" style="margin-top:10px;">Complete Sale</button>
                                </form>
                            </article>

                            <article class="card pos-activity-card">
                                <div class="pos-section-head">
                                    <div>
                                        <h3 class="title">3. Sale result</h3>
                                        <p class="muted">A clear success summary appears here right after checkout.</p>
                                    </div>
                                </div>
                                <div id="posNotice"></div>
                                <div id="posSuccessCard" class="pos-success-card pos-success-empty">
                                    <strong>No completed sale yet.</strong>
                                    <span>Finish a checkout to show the receipt summary here.</span>
                                </div>
                                <div class="actions" style="margin-top:10px;">
                                    <button id="posPrintReceiptBtn" type="button" class="secondary" disabled>Print Last Receipt</button>
                                </div>

                                <h3 class="title" style="margin-top:12px;">Recent POS Sales</h3>
                                <div class="table">
                                    <table>
                                        <thead><tr><th>Sale #</th><th>Cashier</th><th>Items</th><th>Total</th><th>Payment</th><th>GCash Ref</th><th>Date</th></tr></thead>
                                        <tbody id="posSalesRows"></tbody>
                                    </table>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </section>

            <section id="operationsView" class="view">
                <div class="card op-layout-nav">
                    <h3 class="title">Operations</h3>
                    <p class="muted">Pick one workflow at a time.</p>
                    <div id="opSectionTabs" class="op-layout-tabs">
                        <button type="button" class="active" data-op-section="setup">Setup</button>
                        <button type="button" data-op-section="catalog">Product Catalog</button>
                        <button type="button" data-op-section="adjustments">Stock Adjustment</button>
                        <button type="button" data-op-section="inventory">Inventory Summary</button>
                        <button type="button" data-op-section="batch">Batch Health</button>
                        <button type="button" data-op-section="deliveries">Receiving</button>
                        <button type="button" data-op-section="commerce">Orders</button>
                        <button type="button" data-op-section="smart">Branches</button>
                    </div>
                    <div id="opNotice" style="margin-top:10px;"></div>
                    <div id="opGuideHelper" class="workspace-guide-helper">Start with Setup, then open the task you need.</div>
                </div>

                <div id="opSetupGroup" class="layout2">
                    <article id="opMasterDataCard" class="card">
                        <h3 class="title">Setup</h3>
                        <p class="muted">Categories, suppliers, and warehouses.</p>
                        <div class="grid2">
                            <form id="categoryForm">
                                <input name="name" required placeholder="Category name">
                                <textarea name="description" rows="2" placeholder="Description"></textarea>
                                <button type="submit">Save Category</button>
                            </form>
                            <form id="supplierForm">
                                <input name="name" required placeholder="Supplier name">
                                <input name="contact_person" placeholder="Contact person">
                                <input type="email" name="email" placeholder="Email">
                                <input name="phone" placeholder="Phone">
                                <button type="submit">Save Supplier</button>
                            </form>
                        </div>
                        <form id="warehouseForm" style="margin-top:10px;">
                            <div class="grid2">
                                <input name="name" required placeholder="Warehouse name">
                                <input name="code" required placeholder="Code">
                                <select id="warehouseBranchSelect" name="branch_id"></select>
                                <input name="location" required placeholder="Location">
                                <input name="manager_name" placeholder="Manager name">
                            </div>
                            <button type="submit">Save Warehouse</button>
                        </form>
                    </article>

                    <article id="opProductTxCard" class="card">
                        <h3 class="title">Product Catalog</h3>
                        <p class="muted">Add products, review stock targets, and post quick stock updates.</p>
                        <form id="productForm">
                            <input id="productIdField" type="hidden" name="product_id">
                            <div class="grid2">
                                <input id="productNameInput" name="name" required placeholder="Product name">
                                <input id="productSkuInput" name="sku" required placeholder="SKU">
                                <select id="categorySelect" name="category_id" required></select>
                                <select id="supplierSelect" name="supplier_id"></select>
                                <input name="unit_of_measure" required placeholder="Unit">
                                <input type="number" step="0.01" min="0" name="unit_price" required placeholder="Unit price">
                                <input type="number" min="0" name="min_stock_level" required placeholder="Min stock">
                                <input type="number" min="0" name="reorder_point" required placeholder="Reorder point">
                                <input type="file" name="image_file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
                            </div>
                            <div class="actions" style="margin-top:10px;">
                                <button id="productSubmitBtn" type="submit">Save Product</button>
                                <button id="productCancelEditBtn" type="button" class="secondary hidden">Cancel Edit</button>
                            </div>
                            <div id="productFormHint" class="footer-note">Enter the product details and type the SKU you want to use.</div>
                        </form>
                        <div class="operations-stack" style="margin-top:10px;">
                            <div>
                                <h3 class="title">Catalog List</h3>
                                <p class="muted">Review products, stock targets, and catalog status.</p>
                                <div class="table">
                                    <table>
                                        <thead><tr><th>Name</th><th>SKU</th><th>Category</th><th>Price</th><th>Stock</th><th>Min stock</th><th>Reorder</th><th>Status</th><th>Action</th></tr></thead>
                                        <tbody id="opProductRows"></tbody>
                                    </table>
                                </div>
                            </div>
                            <div>
                                <h3 class="title">Quick Stock In / Out</h3>
                                <p class="muted">Post a quick stock in or stock out from this card.</p>
                                <form id="txForm">
                                    <div class="grid2">
                                        <select id="txProductSelect" name="product_id" required></select>
                                        <select id="txWarehouseSelect" name="warehouse_id" required></select>
                                        <select name="transaction_type" required>
                                            <option value="in">Stock In</option>
                                            <option value="out">Stock Out</option>
                                        </select>
                                        <input type="number" min="1" name="quantity" required placeholder="Quantity">
                                        <input id="txUnitPriceInput" type="number" min="0" step="0.01" name="unit_price" required placeholder="Unit price">
                                        <input name="reference_number" placeholder="Reference number">
                                    </div>
                                    <textarea name="notes" rows="2" placeholder="Notes"></textarea>
                                    <div id="txProductMeta" class="footer-note">Choose a product to fill in the price and view stock targets.</div>
                                    <button type="submit">Post Transaction</button>
                                </form>
                            </div>
                        </div>
                    </article>
                </div>
                <div id="opAdjustmentsGroup" class="layout2 section-hidden" style="margin-top:12px;">
                    <article id="opAdjustmentCard" class="card">
                        <h3 class="title">Stock Adjustment</h3>
                        <p class="muted">Add one or more stock changes, then post them together.</p>
                        <div class="adjustment-presets">
                            <button type="button" class="secondary op-adjust-preset" data-adjust-type="decrease" data-adjust-reason="damaged">Damage Deduct</button>
                            <button type="button" class="secondary op-adjust-preset" data-adjust-type="decrease" data-adjust-reason="expired">Expired Deduct</button>
                            <button type="button" class="secondary op-adjust-preset" data-adjust-type="increase" data-adjust-reason="correction">Correction Add</button>
                        </div>
                        <div class="operations-summary-grid">
                            <div class="chip"><strong id="adjustmentDraftCount">0</strong><span>Draft lines</span></div>
                            <div class="chip"><strong id="adjustmentDecreaseCount">0</strong><span>Deduct lines</span></div>
                            <div class="chip"><strong id="adjustmentIncreaseCount">0</strong><span>Add lines</span></div>
                        </div>
                        <form id="adjustmentForm" style="margin-top:10px;">
                            <div class="grid3">
                                <select id="adjustProductSelect" name="product_id" required></select>
                                <select id="adjustWarehouseSelect" name="warehouse_id" required></select>
                                <select id="adjustInventorySelect" name="inventory_id"></select>
                                <select id="adjustTypeSelect" name="adjustment_type" required>
                                    <option value="decrease">Deduct (-)</option>
                                    <option value="increase">Add (+)</option>
                                </select>
                                <select id="adjustReasonSelect" name="adjustment_reason" required>
                                    <option value="damaged">Damaged</option>
                                    <option value="expired">Expired</option>
                                    <option value="correction">Correction</option>
                                    <option value="other">Other</option>
                                </select>
                                <input type="number" min="1" name="quantity" required placeholder="Adjustment qty">
                                <input type="number" min="0" step="0.01" name="unit_price" placeholder="Unit cost (auto-filled when possible)">
                                <input name="reference_number" placeholder="Reference # (optional)">
                                <textarea name="notes" rows="2" placeholder="Adjustment note (optional)"></textarea>
                            </div>
                            <div class="adjustment-draft-actions">
                                <button id="adjustmentAddDraftBtn" type="submit">Add to Draft</button>
                                <button id="adjustmentFormResetBtn" type="button" class="secondary">Clear Form</button>
                            </div>
                            <div class="footer-note">Tip: Use Deduct + Damaged for broken stock, Deduct + Expired for unsellable items, and Correction when recounting inventory.</div>
                        </form>
                        <div class="table" style="margin-top:10px;">
                            <table>
                                <thead><tr><th>Product</th><th>Warehouse</th><th>Batch</th><th>Direction</th><th>Reason</th><th>Qty</th><th>Unit Cost</th><th>Notes</th><th>Action</th></tr></thead>
                                <tbody id="adjustmentDraftRows"></tbody>
                            </table>
                        </div>
                        <div class="adjustment-draft-actions">
                            <button id="adjustmentSubmitAllBtn" type="button">Post All Adjustments</button>
                            <button id="adjustmentClearDraftBtn" type="button" class="secondary">Clear Draft</button>
                        </div>
                        <div class="table" style="margin-top:10px;">
                            <table>
                                <thead><tr><th>Date</th><th>Product</th><th>Warehouse</th><th>Batch</th><th>Qty</th><th>Direction</th><th>Reason</th><th>Notes</th></tr></thead>
                                <tbody id="adjustmentRows"></tbody>
                            </table>
                        </div>
                    </article>
                </div>

                <div id="opInventoryGroup" class="layout2" style="margin-top:12px;">
                    <article id="opInventorySummaryCard" class="card">
                        <h3 class="title">Inventory Summary</h3>
                        <p class="muted">Live stock, batches, and value.</p>
                        <div class="chip-grid">
                            <div class="chip"><strong id="invSummaryBatches">0</strong><span>Total batches</span></div>
                            <div class="chip"><strong id="invSummaryProducts">0</strong><span>Active products</span></div>
                            <div class="chip"><strong id="invSummaryUnits">0</strong><span>Total units</span></div>
                            <div class="chip"><strong id="invSummaryValue">&#8369;0.00</strong><span>Inventory value</span></div>
                            <div class="chip"><strong id="invSummaryRetail">&#8369;0.00</strong><span>Retail value</span></div>
                            <div class="chip"><strong id="invSummaryLowProducts">0</strong><span>Low stock products</span></div>
                            <div class="chip"><strong id="invSummaryExpiring">0</strong><span>Expiring batches</span></div>
                            <div class="chip"><strong id="invSummaryZeroStock">0</strong><span>Zero stock batches</span></div>
                        </div>
                        <div id="inventoryStatusBreakdown" class="chip-grid"></div>
                        <div class="table" style="margin-top:10px;">
                            <table>
                                <thead><tr><th>Warehouse</th><th>Products</th><th>Batches</th><th>Units</th><th>Available</th><th>Value</th><th>Expiring</th></tr></thead>
                                <tbody id="inventoryWarehouseRows"></tbody>
                            </table>
                        </div>
                    </article>

                    <article id="opInventoryBatchCard" class="card">
                        <h3 class="title">Batch Health</h3>
                        <p class="muted">Filter batches and update status.</p>
                        <div class="inventory-toolbar">
                            <form id="inventoryFilterForm">
                                <div class="grid2">
                                    <select id="inventoryWarehouseFilter" name="warehouse_id"></select>
                                    <select id="inventoryStatusFilter" name="status">
                                        <option value="">All statuses</option>
                                        <option value="available">available</option>
                                        <option value="reserved">reserved</option>
                                        <option value="damaged">damaged</option>
                                        <option value="expired">expired</option>
                                        <option value="quarantine">quarantine</option>
                                    </select>
                                    <input id="inventorySearchInput" name="search" placeholder="Search product, SKU, batch, warehouse, or supplier">
                                    <input id="inventoryAgingThresholdInput" type="number" min="31" max="3650" name="threshold_days" value="90" placeholder="Aging threshold (days)">
                                </div>
                                <div class="actions" style="margin-top:10px;">
                                    <button type="submit" class="secondary">Load Inventory</button>
                                    <button id="inventoryFilterResetBtn" type="button" class="secondary">Reset</button>
                                </div>
                            </form>

                            <form id="inventoryStatusForm" class="inventory-stack">
                                <div class="grid2">
                                    <select id="inventoryStatusInventorySelect" name="inventory_id" required></select>
                                    <select id="inventoryStatusSelect" name="status" required>
                                        <option value="available">available</option>
                                        <option value="reserved">reserved</option>
                                        <option value="damaged">damaged</option>
                                        <option value="expired">expired</option>
                                        <option value="quarantine">quarantine</option>
                                    </select>
                                    <input id="inventoryLocationInput" name="location_in_warehouse" placeholder="Location in warehouse (optional)">
                                    <input id="inventoryStatusNotes" name="notes" placeholder="Status note (optional)">
                                </div>
                                <button type="submit">Update Batch Status</button>
                            </form>
                        </div>

                        <div class="chip-grid" style="margin-top:10px;">
                            <div class="chip"><strong id="inventoryAgingAverage">0</strong><span>Average age (days)</span></div>
                            <div class="chip"><strong id="inventoryAgingFresh">0</strong><span>Fresh batches</span></div>
                            <div class="chip"><strong id="inventoryAgingMonitor">0</strong><span>Monitor batches</span></div>
                            <div class="chip"><strong id="inventoryAgingFlagged">0</strong><span>Aging batches</span></div>
                        </div>

                        <div class="table" style="margin-top:10px;">
                            <table>
                                <thead><tr><th>Batch</th><th>Warehouse</th><th>Qty</th><th>Status</th><th>Health</th><th>Expiry</th><th>Value</th></tr></thead>
                                <tbody id="inventoryBatchRows"></tbody>
                            </table>
                        </div>

                        <div class="table" style="margin-top:10px;">
                            <table>
                                <thead><tr><th>Batch</th><th>Age</th><th>Threshold</th><th>Days to Expiry</th><th>Location</th></tr></thead>
                                <tbody id="inventoryAgingRows"></tbody>
                            </table>
                        </div>
                    </article>
                </div>

                <div id="opCommerceGroup" class="layout2" style="margin-top:12px;">
                    <article id="opOrdersCard" class="card">
                        <h3 class="title">Order Management</h3>
                        <p class="muted">Review and update customer orders.</p>
                        <form id="opOrderFilterForm">
                            <div class="grid2">
                                <input id="opOrderSearchInput" name="search" placeholder="Search order number, customer name, or email">
                                <select id="opOrderStatusFilter" name="status">
                                    <option value="">All statuses</option>
                                    <option value="pending">pending</option>
                                    <option value="processing">processing</option>
                                    <option value="completed">completed</option>
                                    <option value="cancelled">cancelled</option>
                                </select>
                            </div>
                            <div class="actions" style="margin-top:10px;">
                                <button type="submit" class="secondary">Apply Filters</button>
                                <button id="opOrderFilterResetBtn" type="button" class="secondary">Reset</button>
                            </div>
                        </form>
                        <div class="table">
                            <table>
                                <thead><tr><th>Order #</th><th>Customer</th><th>Status</th><th>Payment</th><th>Total</th><th>Date</th><th>Action</th></tr></thead>
                                <tbody id="opOrderRows"></tbody>
                            </table>
                        </div>
                    </article>

                    <article id="opPromotionsCard" class="card">
                        <h3 class="title">Promotions</h3>
                        <p class="muted">Create promo discounts.</p>
                        <form id="promotionForm">
                            <input id="promotionIdField" type="hidden" name="promotion_id">
                            <div class="grid2">
                                <input name="title" required placeholder="Promotion title">
                                <input name="code" placeholder="Promo code (optional)">
                                <select name="discount_type" required>
                                    <option value="percent">percent</option>
                                    <option value="fixed">fixed</option>
                                </select>
                                <input type="number" min="0" step="0.01" name="discount_value" required placeholder="Discount value">
                                <input type="datetime-local" name="starts_at">
                                <input type="datetime-local" name="ends_at">
                            </div>
                            <textarea name="description" rows="2" placeholder="Description"></textarea>
                            <label class="inline-actions" style="margin-top:8px;">
                                <input type="checkbox" name="is_active" value="1" checked>
                                <span>Promotion is active</span>
                            </label>
                            <div class="actions" style="margin-top:10px;">
                                <button id="promotionSubmitBtn" type="submit">Save Promotion</button>
                                <button id="promotionCancelEditBtn" type="button" class="secondary hidden">Cancel Edit</button>
                            </div>
                        </form>
                        <div class="table" style="margin-top:10px;">
                            <table>
                                <thead><tr><th>Title</th><th>Code</th><th>Discount</th><th>Schedule</th><th>Status</th><th>Action</th></tr></thead>
                                <tbody id="promotionRows"></tbody>
                            </table>
                        </div>
                    </article>
                </div>

                <div id="opDeliveryGroup" class="layout2" style="margin-top:12px;">
                    <article id="opReceiptsCard" class="card">
                        <h3 class="title">Supply Deliveries</h3>
                        <p class="muted">Record supplier deliveries and restock inventory.</p>
                        <form id="stockReceiptForm">
                            <div class="grid2">
                                <select id="receiptSupplierSelect" name="supplier_id" required></select>
                                <select id="receiptWarehouseSelect" name="warehouse_id" required></select>
                                <input name="reference_no" placeholder="Reference number (optional)">
                                <input name="notes" placeholder="Notes (optional)">
                            </div>
                        </form>

                        <form id="stockReceiptItemForm" style="margin-top:10px;">
                            <div class="grid2">
                                <select id="receiptProductSelect" name="product_id" required></select>
                                <input type="number" min="1" name="quantity" required placeholder="Quantity">
                                <input type="number" min="0" step="0.01" name="unit_cost" required placeholder="Unit cost (PHP)">
                                <input name="batch_number" placeholder="Batch number (optional)">
                                <input type="date" name="manufacturing_date" placeholder="Manufacturing date (optional)">
                                <input type="date" name="expiry_date" placeholder="Expiry date (optional)">
                                <button type="submit" class="secondary">Add Delivery Item</button>
                            </div>
                        </form>

                        <div class="table" style="margin-top:10px;">
                            <table>
                                <thead><tr><th>Product</th><th>Batch</th><th>MFG Date</th><th>Expiry Date</th><th>Qty</th><th>Unit Cost</th><th>Line Total</th><th>Action</th></tr></thead>
                                <tbody id="stockReceiptDraftRows"></tbody>
                            </table>
                        </div>
                        <div class="list-item" style="margin-top:8px;">Draft total: <strong id="stockReceiptDraftTotal">&#8369;0.00</strong></div>

                        <button form="stockReceiptForm" id="stockReceiptSubmitBtn" type="submit" style="margin-top:10px;">Record Delivery</button>
                    </article>

                    <article id="opReceiptsListCard" class="card">
                        <h3 class="title">Recent Stock Receipts</h3>
                        <p class="muted">Latest supply deliveries from suppliers.</p>
                        <div class="table">
                            <table>
                                <thead><tr><th>Reference</th><th>Supplier</th><th>Received By</th><th>Items</th><th>Date</th></tr></thead>
                                <tbody id="stockReceiptRows"></tbody>
                            </table>
                        </div>
                    </article>
                </div>

                <div id="opForecastGroup" class="layout2" style="margin-top:12px;">
                    <article id="opForecastCard" class="card">
                        <h3 class="title">Smart Forecasting</h3>
                        <p class="muted">Predict product demand and suggested restocking quantities.</p>
                        <form id="opForecastForm">
                            <div class="grid2">
                                <select id="opForecastBranchSelect" name="branch_id"></select>
                                <input type="number" min="7" max="365" name="lookback_days" value="60" placeholder="Lookback days">
                                <input type="number" min="7" max="180" name="forecast_days" value="30" placeholder="Forecast days">
                                <input type="number" min="1" max="200" name="limit" value="20" placeholder="Max products">
                            </div>
                            <button type="submit" class="secondary">Run Forecast</button>
                        </form>
                        <div class="table">
                            <table>
                                <thead><tr><th>Product</th><th>Current Stock</th><th>Predicted Demand</th><th>Suggested Restock</th></tr></thead>
                                <tbody id="opForecastRows"></tbody>
                            </table>
                        </div>
                    </article>

                </div>

                <div id="opBranchGroup" class="layout2" style="margin-top:12px;">
                    <article id="opBranchManageCard" class="card">
                        <h3 class="title">Multi-Branch Management</h3>
                        <p id="opBranchFormHint" class="muted">Manage multiple farm supply store branches.</p>
                        <form id="opBranchForm">
                            <input id="opBranchIdField" type="hidden" name="branch_id">
                            <div class="grid2">
                                <input name="name" required placeholder="Branch name">
                                <input name="code" required placeholder="Branch code">
                                <input name="location" placeholder="Location">
                                <input name="contact_person" placeholder="Contact person">
                                <input name="phone" placeholder="Phone">
                                <select name="is_active">
                                    <option value="1">active</option>
                                    <option value="0">inactive</option>
                                </select>
                            </div>
                            <div class="actions" style="margin-top:10px;">
                                <button id="opBranchSubmitBtn" type="submit">Save Branch</button>
                                <button id="opBranchCancelBtn" type="button" class="secondary hidden">Cancel Edit</button>
                            </div>
                        </form>
                        <div class="table">
                            <table>
                                <thead><tr><th>Code</th><th>Name</th><th>Location</th><th>Status</th><th>Warehouses</th><th>Action</th></tr></thead>
                                <tbody id="opBranchRows"></tbody>
                            </table>
                        </div>
                    </article>

                    <article id="opBranchOverviewCard" class="card">
                        <div class="customer-actions">
                            <h3 class="title">Branch Inventory Overview</h3>
                            <button id="opBranchOverviewRefreshBtn" type="button" class="secondary btn-inline">Refresh</button>
                        </div>
                        <p class="muted">Stock distribution and inventory value by branch.</p>
                        <div class="table">
                            <table>
                                <thead><tr><th>Branch</th><th>Warehouses</th><th>Products</th><th>Total Units</th><th>Inventory Value</th></tr></thead>
                                <tbody id="opBranchOverviewRows"></tbody>
                            </table>
                        </div>
                        <h3 class="title" style="margin-top:10px;">Unassigned Warehouses</h3>
                        <div id="opUnassignedWarehouseList" class="list"></div>
                    </article>
                </div>
            </section>

            <section id="reportsView" class="view">
                <div class="card op-layout-nav">
                    <h3 class="title">Reports</h3>
                    <p class="muted">Pick one report group.</p>
                    <div id="reportsSectionTabs" class="op-layout-tabs">
                        <button type="button" class="active" data-reports-section="inventory">Inventory</button>
                        <button type="button" data-reports-section="business">Sales</button>
                        <button type="button" data-reports-section="governance">Access Logs</button>
                        <button type="button" data-reports-section="settings">Settings</button>
                    </div>
                    <div id="reportsNotice" style="margin-top:10px;"></div>
                    <div id="reportsGuideHelper" class="workspace-guide-helper">Start with Inventory, then open Sales or Logs as needed.</div>
                </div>

                <div id="reportsInventoryGroup" class="layout2">
                    <article id="reportMovementCard" class="card">
                        <h3 class="title">Movement Summary</h3>
                        <p class="muted">Totals by type.</p>
                        <div class="table">
                            <table>
                                <thead><tr><th>Type</th><th>Total Qty</th><th>Total Amount</th></tr></thead>
                                <tbody id="moveRows"></tbody>
                            </table>
                        </div>
                    </article>
                    <article id="reportExpiringCard" class="card">
                        <h3 class="title">Expiring Stock</h3>
                        <p class="muted">Within 45 days.</p>
                        <div class="table">
                            <table>
                                <thead><tr><th>Product</th><th>Warehouse</th><th>Batch</th><th>MFG</th><th>Qty</th><th>Expiry</th></tr></thead>
                                <tbody id="expRows"></tbody>
                            </table>
                        </div>
                    </article>
                </div>

                <div id="reportsBusinessGroup" class="layout2" style="margin-top:12px;">
                    <article id="reportSalesDailyCard" class="card">
                        <h3 class="title">Sales Report</h3>
                        <p class="muted">Daily orders and revenue.</p>
                        <div class="table">
                            <table>
                                <thead><tr><th>Date</th><th>Orders</th><th>Revenue</th></tr></thead>
                                <tbody id="reportSalesRows"></tbody>
                            </table>
                        </div>
                    </article>
                    <article id="reportTopSellingCard" class="card">
                        <h3 class="title">Top Selling Products</h3>
                        <p class="muted">Best sellers in range.</p>
                        <div class="table">
                            <table>
                                <thead><tr><th>Product</th><th>Quantity Sold</th><th>Revenue</th></tr></thead>
                                <tbody id="reportTopSellingRows"></tbody>
                            </table>
                        </div>
                    </article>
                </div>
                <div id="reportsBusinessSummaryGroup" class="layout2" style="margin-top:12px;">
                    <article id="reportInventoryValueCard" class="card">
                        <h3 class="title">Inventory Value</h3>
                        <p class="muted">Current stock value.</p>
                        <div class="list-item">Total Inventory Value: <strong id="reportInventoryValue">&#8369;0.00</strong></div>
                        <div class="table" style="margin-top:10px;">
                            <table>
                                <thead><tr><th>Status</th><th>Count</th></tr></thead>
                                <tbody id="reportInventoryStatusRows"></tbody>
                            </table>
                        </div>
                    </article>
                    <article id="reportLowStockBusinessCard" class="card">
                        <h3 class="title">Low Stock Report</h3>
                        <p class="muted">At reorder point.</p>
                        <div class="table">
                            <table>
                                <thead><tr><th>Product</th><th>Remaining</th><th>Reorder Point</th></tr></thead>
                                <tbody id="reportLowStockRows"></tbody>
                            </table>
                        </div>
                    </article>
                </div>

                <div id="reportsGovernanceGroup" class="layout2" style="margin-top:12px;">
                    <article id="reportsLoginCard" class="card">
                        <h3 class="title">Login Activities</h3>
                        <p class="muted">Success, failure, and logout.</p>
                        <form id="saLoginFilter" class="grid2">
                            <select name="action">
                                <option value="">All actions</option>
                                <option value="login_success">login_success</option>
                                <option value="login_failed">login_failed</option>
                                <option value="logout">logout</option>
                            </select>
                            <select id="saLoginUserId" name="user_id"></select>
                            <input type="date" name="from">
                            <input type="date" name="to">
                        </form>
                        <div class="actions" style="margin-top:10px;">
                            <button form="saLoginFilter" type="submit">Load Activity</button>
                            <button id="saLoginFilterResetBtn" type="button" class="secondary">Reset</button>
                        </div>
                        <div class="table" style="margin-top:10px;">
                            <table>
                                <thead><tr><th>User</th><th>Email</th><th>Action</th><th>IP</th><th>Date</th></tr></thead>
                                <tbody id="saLoginRows"></tbody>
                            </table>
                        </div>
                    </article>

                    <article id="reportsAuditCard" class="card">
                        <h3 class="title">Audit Logs</h3>
                        <p class="muted">Critical actions.</p>
                        <form id="saAuditFilter" class="grid2">
                            <input name="action" placeholder="Filter action (optional)">
                            <select id="saAuditUserId" name="user_id"></select>
                            <input type="date" name="from">
                            <input type="date" name="to">
                        </form>
                        <div class="actions" style="margin-top:10px;">
                            <button form="saAuditFilter" type="submit">Load Logs</button>
                            <button id="saAuditFilterResetBtn" type="button" class="secondary">Reset</button>
                        </div>
                        <div class="table" style="margin-top:10px;">
                            <table>
                                <thead><tr><th>Action</th><th>Entity</th><th>User</th><th>Date</th></tr></thead>
                                <tbody id="saAuditRows"></tbody>
                            </table>
                        </div>
                    </article>
                </div>

                <div id="reportsSettingsGroup" class="layout2" style="margin-top:12px;">
                    <article id="reportsSettingsCard" class="card">
                        <h3 class="title">Settings & Backup</h3>
                        <p class="muted">Runtime values and backup export.</p>
                        <form id="saSettingForm">
                            <div class="grid2">
                                <input name="key" required placeholder="Setting key">
                                <input name="description" placeholder="Description (optional)">
                            </div>
                            <textarea name="value" rows="3" placeholder="Setting value"></textarea>
                            <div class="actions" style="margin-top:10px;">
                                <button type="submit">Save Setting</button>
                                <button id="saBackupExportBtn" type="button" class="secondary">Export Backup</button>
                            </div>
                        </form>

                        <div class="table" style="margin-top:10px;">
                            <table>
                                <thead><tr><th>Key</th><th>Value</th><th>Description</th><th>Updated By</th><th>Updated At</th></tr></thead>
                                <tbody id="saSettingRows"></tbody>
                            </table>
                        </div>
                    </article>

                    <article id="reportsSafeguardsCard" class="card">
                        <h3 class="title">Safeguards</h3>
                        <p class="muted">Status and access overrides.</p>
                        <form id="saUserStatusForm">
                            <h4 class="title">User Status</h4>
                            <div class="grid2">
                                <select id="saStatusUserId" name="user_id" required></select>
                                <select name="status" required>
                                    <option value="active">active</option>
                                    <option value="suspended">suspended</option>
                                </select>
                            </div>
                            <label class="inline-actions" style="margin-top:8px;">
                                <input type="checkbox" name="revoke_tokens" value="1">
                                <span>Revoke tokens after update</span>
                            </label>
                            <button type="submit" style="margin-top:8px;">Update Status</button>
                        </form>

                        <form id="saPermissionForm" style="margin-top:10px;">
                            <h4 class="title">Access Overrides</h4>
                            <select id="saPermissionUserId" name="user_id" required></select>
                            <textarea id="saPermissionJsonInput" name="permissions_json" rows="4" placeholder='{"manage_reports":true,"use_pos":false}'></textarea>
                            <button type="submit">Save Overrides</button>
                        </form>
                    </article>
                </div>
            </section>

            <section id="usersView" class="view">
                <div class="card op-layout-nav">
                    <h3 class="title">Users</h3>
                    <p class="muted">Search, filter, and update accounts.</p>
                    <div id="usersSectionTabs" class="op-layout-tabs">
                        <button type="button" class="active" data-users-section="directory">Team Directory</button>
                        <button type="button" data-users-section="editor">Editor</button>
                    </div>
                    <div id="userNotice" style="margin-top:10px;"></div>
                    <div id="usersGuideHelper" class="workspace-guide-helper">Open Directory to find a user, then use Editor to update.</div>
                </div>

                <div id="usersEditorGroup" class="layout2">
                    <article id="usersEditorCard" class="card">
                        <h3 id="userFormTitle" class="title">Create Account</h3>
                        <p id="userFormSubtitle" class="muted">Admins only.</p>
                        <form id="userForm">
                            <input id="userIdField" type="hidden" name="user_id">
                            <div class="grid2">
                                <input id="userNameInput" name="name" required placeholder="Full name">
                                <input id="userEmailInput" type="email" name="email" required placeholder="Email">
                                <input id="userPasswordInput" type="password" minlength="8" name="password" required placeholder="Password">
                                <select id="userRoleSelect" name="role" required>
                                    <option value="customer">customer</option>
                                    <option value="staff">staff</option>
                                    <option value="manager">manager</option>
                                    <option value="admin">admin</option>
                                    <option value="super_admin">super_admin</option>
                                </select>
                            </div>
                            <div class="actions" style="margin-top:10px;">
                                <button id="userSubmitBtn" type="submit">Create User</button>
                                <button id="userCancelEditBtn" type="button" class="secondary hidden">Cancel Edit</button>
                            </div>
                        </form>
                    </article>
                </div>

                <div id="usersDirectoryGroup" class="layout2" style="margin-top:12px;">
                    <article id="usersDirectoryCard" class="card">
                        <h3 class="title">Accounts</h3>
                        <p class="muted">Roles and access.</p>
                        <form id="userFilterForm">
                            <div class="grid2">
                                <input id="userSearchInput" type="text" name="search" placeholder="Search name or email">
                                <select id="userRoleFilter" name="role">
                                    <option value="">All roles</option>
                                    <option value="customer">customer</option>
                                    <option value="staff">staff</option>
                                    <option value="manager">manager</option>
                                    <option value="admin">admin</option>
                                    <option value="super_admin">super_admin</option>
                                </select>
                            </div>
                            <div class="actions" style="margin-top:10px;">
                                <button type="submit" class="secondary">Apply Filters</button>
                                <button id="userFilterResetBtn" type="button" class="secondary">Reset</button>
                            </div>
                        </form>
                        <div class="table">
                            <table>
                                <thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Joined</th><th>Actions</th></tr></thead>
                                <tbody id="userRows"></tbody>
                            </table>
                        </div>
                    </article>
                </div>
            </section>

            <section id="superAdminView" class="view">
                <div class="card op-layout-nav">
                    <h3 class="title">Super Admin</h3>
                    <p class="muted">Open one control area at a time.</p>
                    <div id="superAdminSectionTabs" class="op-layout-tabs super-admin-tabs">
                        <button type="button" class="active" data-super-section="overview">Overview</button>
                        <button type="button" data-super-section="setup">Setup</button>
                        <button type="button" data-super-section="products">Product Catalog</button>
                        <button type="button" data-super-section="stock">Stock Flow</button>
                        <button type="button" data-super-section="inventory">Inventory Summary</button>
                        <button type="button" data-super-section="users">User Accounts</button>
                        <button type="button" data-super-section="security">Security</button>
                        <button type="button" data-super-section="activity">Logs</button>
                    </div>
                    <div id="saNotice" style="margin-top:10px;"></div>
                    <div id="superGuideHelper" class="workspace-guide-helper">Start with Overview, then open the control area you need.</div>
                </div>

                <div id="superAdminOverviewGroup">
                    <div class="cards">
                        <article class="card kpi"><h4>Total Users</h4><div id="saTotalUsers" class="value">0</div></article>
                        <article class="card kpi"><h4>Super Admins</h4><div id="saSuperAdmins" class="value">0</div></article>
                        <article class="card kpi"><h4>Active Tokens</h4><div id="saTokens" class="value">0</div></article>
                        <article class="card kpi"><h4>Tx Today</h4><div id="saTxToday" class="value">0</div></article>
                        <article class="card kpi"><h4>Tx Month</h4><div id="saTxMonth" class="value">0</div></article>
                        <article class="card kpi"><h4>New Users 30d</h4><div id="saNewUsers" class="value">0</div></article>
                    </div>

                    <div class="super-admin-feature-grid" style="margin-top:12px;">
                        <article id="saOverviewJumpCard" class="card sa-feature-card sa-feature-card-wide">
                            <span class="sa-feature-tag">Workspace</span>
                            <h3 class="title">Choose a control area</h3>
                            <p class="muted">Use the top tabs to open the area you need.</p>
                        </article>

                        <article id="saOverviewStatusCard" class="card sa-feature-card">
                            <span class="sa-feature-tag">Snapshot</span>
                            <h3 class="title">Quick counts</h3>
                            <p class="muted">See the main totals first.</p>
                            <div class="sa-feature-stats compact">
                                <div><strong id="saOverviewSetupCount">0</strong><span>setup</span></div>
                                <div><strong id="saOverviewProductsCount">0</strong><span>products</span></div>
                                <div><strong id="saOverviewInventoryCount">0</strong><span>batches</span></div>
                                <div><strong id="saOverviewLowCount">0</strong><span>low stock</span></div>
                            </div>
                        </article>
                    </div>

                    <div class="super-admin-detail-grid" style="margin-top:12px;">
                        <article id="saRoleDistributionCard" class="card">
                            <h3 class="title">Role Distribution</h3>
                            <p class="muted">Users by role.</p>
                            <div id="roleChips" class="chip-grid"></div>
                            <div class="table">
                                <table>
                                    <thead><tr><th>Role</th><th>Users</th><th>Percent</th></tr></thead>
                                    <tbody id="saRoleRows"></tbody>
                                </table>
                            </div>
                        </article>

                        <article id="saOverviewPathsCard" class="card sa-feature-card">
                            <span class="sa-feature-tag">Shortcuts</span>
                            <h3 class="title">Quick links</h3>
                            <p class="muted">Go straight to the right screen.</p>
                            <div class="sa-feature-list">
                                <div><strong>Users</strong><span>Accounts, roles, and directory</span></div>
                                <div><strong>Reports</strong><span>Login logs, audit logs, and settings</span></div>
                                <div><strong>Operations</strong><span>Products, stock flow, and branches</span></div>
                            </div>
                            <div class="sa-feature-actions stacked">
                                <button type="button" class="secondary" data-nav-view="usersView" data-nav-section="directory" data-nav-card="usersDirectoryCard">Open User Directory</button>
                                <button type="button" class="secondary" data-nav-view="reportsView" data-nav-section="governance" data-nav-card="reportsLoginCard">Open Login Logs</button>
                                <button type="button" class="secondary" data-nav-view="operationsView" data-nav-section="smart" data-nav-card="opBranchOverviewCard">Open Branch View</button>
                            </div>
                        </article>
                    </div>
                </div>

                <div id="superAdminSetupGroup" class="super-admin-feature-grid hidden" style="margin-top:12px;">
                    <article id="saSetupCategoriesCard" class="card sa-feature-card">
                        <span class="sa-feature-tag">Setup</span>
                        <h3 class="title">Categories</h3>
                        <p class="muted">Create and organize product groups.</p>
                        <div class="sa-feature-metric"><strong id="saSetupCategoriesCount">0</strong><span>categories</span></div>
                        <div class="sa-feature-actions"><button type="button" class="secondary" data-nav-view="operationsView" data-nav-section="setup" data-nav-card="opMasterDataCard">Open Setup</button></div>
                    </article>
                    <article id="saSetupSuppliersCard" class="card sa-feature-card">
                        <span class="sa-feature-tag">Setup</span>
                        <h3 class="title">Suppliers</h3>
                        <p class="muted">Maintain supplier records in one place.</p>
                        <div class="sa-feature-metric"><strong id="saSetupSuppliersCount">0</strong><span>suppliers</span></div>
                        <div class="sa-feature-actions"><button type="button" class="secondary" data-nav-view="operationsView" data-nav-section="setup" data-nav-card="opMasterDataCard">Open Suppliers</button></div>
                    </article>
                    <article id="saSetupWarehousesCard" class="card sa-feature-card">
                        <span class="sa-feature-tag">Setup</span>
                        <h3 class="title">Warehouses</h3>
                        <p class="muted">Manage warehouse list and branch links.</p>
                        <div class="sa-feature-metric"><strong id="saSetupWarehousesCount">0</strong><span>warehouses</span></div>
                        <div class="sa-feature-actions"><button type="button" class="secondary" data-nav-view="operationsView" data-nav-section="setup" data-nav-card="opMasterDataCard">Open Warehouses</button></div>
                    </article>
                    <article id="saSetupBranchesCard" class="card sa-feature-card">
                        <span class="sa-feature-tag">Setup</span>
                        <h3 class="title">Branches</h3>
                        <p class="muted">Review branch list and warehouse coverage.</p>
                        <div class="sa-feature-metric"><strong id="saSetupBranchesCount">0</strong><span>branches</span></div>
                        <div class="sa-feature-actions"><button type="button" class="secondary" data-nav-view="operationsView" data-nav-section="smart" data-nav-card="opBranchManageCard">Open Branches</button></div>
                    </article>
                </div>

                <div id="superAdminProductsGroup" class="super-admin-feature-grid hidden" style="margin-top:12px;">
                    <article id="saProductFormCard" class="card sa-feature-card">
                        <span class="sa-feature-tag">Products</span>
                        <h3 class="title">Product form</h3>
                        <p class="muted">Add or edit product details.</p>
                        <div class="sa-feature-metric"><strong id="saProductsTotalCount">0</strong><span>products</span></div>
                        <div class="sa-feature-actions"><button type="button" class="secondary" data-nav-view="operationsView" data-nav-section="setup" data-nav-card="opProductTxCard">Open Product Form</button></div>
                    </article>
                    <article id="saProductCatalogCard" class="card sa-feature-card">
                        <span class="sa-feature-tag">Products</span>
                        <h3 class="title">Product catalog</h3>
                        <p class="muted">Review active, inactive, and stock-ready items.</p>
                        <div class="sa-feature-metric"><strong id="saProductsActiveCount">0</strong><span>active products</span></div>
                        <div class="sa-feature-actions"><button type="button" class="secondary" data-nav-view="operationsView" data-nav-section="setup" data-nav-card="opProductTxCard">Open Catalog</button></div>
                    </article>
                    <article id="saProductPromotionsCard" class="card sa-feature-card">
                        <span class="sa-feature-tag">Products</span>
                        <h3 class="title">Promotions and pricing</h3>
                        <p class="muted">Manage promo discounts and pricing support.</p>
                        <div class="sa-feature-metric"><strong id="saProductsCategoryCount">0</strong><span>categories</span></div>
                        <div class="sa-feature-actions"><button type="button" class="secondary" data-nav-view="operationsView" data-nav-section="commerce" data-nav-card="opPromotionsCard">Open Promotions</button></div>
                    </article>
                </div>

                <div id="superAdminStockGroup" class="super-admin-feature-grid hidden" style="margin-top:12px;">
                    <article id="saStockInCard" class="card sa-feature-card">
                        <span class="sa-feature-tag">Stock</span>
                        <h3 class="title">Stock in and deliveries</h3>
                        <p class="muted">Receive deliveries and record incoming stock.</p>
                        <div class="sa-feature-metric"><strong id="saStockWarehousesCount">0</strong><span>warehouses ready</span></div>
                        <div class="sa-feature-actions"><button type="button" class="secondary" data-nav-view="operationsView" data-nav-section="deliveries" data-nav-card="opReceiptsCard">Open Stock In</button></div>
                    </article>
                    <article id="saStockOutCard" class="card sa-feature-card">
                        <span class="sa-feature-tag">Stock</span>
                        <h3 class="title">Stock out and movement</h3>
                        <p class="muted">Post stock out and track movement.</p>
                        <div class="sa-feature-metric"><strong id="saStockMovementCount">0</strong><span>products ready</span></div>
                        <div class="sa-feature-actions"><button type="button" class="secondary" data-nav-view="operationsView" data-nav-section="setup" data-nav-card="opProductTxCard">Open Stock Out</button></div>
                    </article>
                    <article id="saStockAdjustmentsCard" class="card sa-feature-card">
                        <span class="sa-feature-tag">Stock</span>
                        <h3 class="title">Stock adjustments</h3>
                        <p class="muted">Correct damaged, expired, or missing stock.</p>
                        <div class="sa-feature-metric"><strong id="saStockAdjustmentsCount">0</strong><span>low-stock items</span></div>
                        <div class="sa-feature-actions"><button type="button" class="secondary" data-nav-view="operationsView" data-nav-section="setup" data-nav-card="opProductTxCard">Open Adjustments</button></div>
                    </article>
                    <article id="saStockOrdersCard" class="card sa-feature-card">
                        <span class="sa-feature-tag">Stock</span>
                        <h3 class="title">Purchase orders</h3>
                        <p class="muted">Review open orders and supplier flow.</p>
                        <div class="sa-feature-metric"><strong id="saStockSuppliersCount">0</strong><span>suppliers</span></div>
                        <div class="sa-feature-actions"><button type="button" class="secondary" data-nav-view="operationsView" data-nav-section="commerce" data-nav-card="opOrdersCard">Open Orders</button></div>
                    </article>
                </div>

                <div id="superAdminInventoryGroup" class="super-admin-feature-grid hidden" style="margin-top:12px;">
                    <article id="saInventorySummaryFeatureCard" class="card sa-feature-card">
                        <span class="sa-feature-tag">Inventory</span>
                        <h3 class="title">Inventory summary</h3>
                        <p class="muted">See total batches, value, and stock health.</p>
                        <div class="sa-feature-metric"><strong id="saInventoryBatchesCount">0</strong><span>batches</span></div>
                        <div class="sa-feature-actions"><button type="button" class="secondary" data-nav-view="operationsView" data-nav-section="setup" data-nav-card="opInventorySummaryCard">Open Summary</button></div>
                    </article>
                    <article id="saInventoryBatchFeatureCard" class="card sa-feature-card">
                        <span class="sa-feature-tag">Inventory</span>
                        <h3 class="title">Batch health</h3>
                        <p class="muted">Review batch aging, expiry, and status.</p>
                        <div class="sa-feature-metric"><strong id="saInventoryProductsCount">0</strong><span>active products</span></div>
                        <div class="sa-feature-actions"><button type="button" class="secondary" data-nav-view="operationsView" data-nav-section="setup" data-nav-card="opInventoryBatchCard">Open Batch Health</button></div>
                    </article>
                    <article id="saInventoryAlertsFeatureCard" class="card sa-feature-card">
                        <span class="sa-feature-tag">Inventory</span>
                        <h3 class="title">Low-stock report</h3>
                        <p class="muted">Jump to stock alerts and reorder reports.</p>
                        <div class="sa-feature-metric"><strong id="saInventoryValueCount">PHP 0.00</strong><span>inventory value</span></div>
                        <div class="sa-feature-actions"><button type="button" class="secondary" data-nav-view="reportsView" data-nav-section="business" data-nav-card="reportLowStockBusinessCard">Open Low Stock</button></div>
                    </article>
                </div>

                <div id="superAdminUsersGroup" class="super-admin-detail-grid hidden" style="margin-top:12px;">
                    <article id="saCreateAccountCard" class="card">
                        <h3 class="title">Create account</h3>
                        <p class="muted">Add staff, admin, or super admin users.</p>

                        <form id="saCreateUserForm">
                            <div class="grid2">
                                <input name="name" required placeholder="Full name">
                                <input type="email" name="email" required placeholder="Email">
                                <input type="password" minlength="8" name="password" required placeholder="Password">
                                <select id="saCreateRoleSelect" name="role" required>
                                    <option value="customer">customer</option>
                                    <option value="staff">staff</option>
                                    <option value="manager">manager</option>
                                    <option value="admin">admin</option>
                                    <option value="super_admin">super_admin</option>
                                </select>
                            </div>
                            <button type="submit">Create User</button>
                        </form>
                    </article>

                    <article id="saBulkRolesCard" class="card">
                        <h3 class="title">Roles and export</h3>
                        <p class="muted">Update roles in bulk or export users.</p>

                        <form id="saBulkRoleForm">
                            <select id="saBulkUsers" class="multi-select" multiple required></select>
                            <div class="grid2">
                                <select id="saBulkRoleSelect" name="role" required>
                                    <option value="customer">customer</option>
                                    <option value="staff">staff</option>
                                    <option value="manager">manager</option>
                                    <option value="admin">admin</option>
                                    <option value="super_admin">super_admin</option>
                                </select>
                                <button type="submit">Apply Role</button>
                            </div>
                        </form>

                        <button id="saExportUsersBtn" type="button" class="secondary" style="margin-top:10px;">Export Users CSV</button>
                        <div class="footer-note">Ctrl/Cmd click selects multiple users.</div>
                    </article>

                    <article id="saUsersJumpCard" class="card sa-feature-card">
                        <span class="sa-feature-tag">Users</span>
                        <h3 class="title">User tools</h3>
                        <p class="muted">Open the exact account screen you need.</p>
                        <div class="sa-feature-metric"><strong id="saUsersTotalCount">0</strong><span>total users</span></div>
                        <div class="sa-feature-actions stacked">
                            <button type="button" class="secondary" data-nav-view="usersView" data-nav-section="directory" data-nav-card="usersDirectoryCard">Open Directory</button>
                            <button type="button" class="secondary" data-nav-view="usersView" data-nav-section="editor" data-nav-card="usersEditorCard">Open Editor</button>
                            <button type="button" class="secondary" data-nav-view="reportsView" data-nav-section="settings" data-nav-card="reportsSafeguardsCard">Open Safeguards</button>
                        </div>
                    </article>
                </div>

                <div id="superAdminSecurityGroup" class="super-admin-detail-grid hidden" style="margin-top:12px;">
                    <article id="saPasswordControlCard" class="card">
                        <h3 class="title">Password and tokens</h3>
                        <p class="muted">Reset credentials or revoke access tokens.</p>

                        <form id="saResetPasswordForm">
                            <div class="grid2">
                                <select id="saResetUserId" name="user_id" required></select>
                                <input type="password" minlength="8" name="password" required placeholder="New password">
                            </div>
                            <button type="submit">Reset Password</button>
                        </form>

                        <form id="saRevokeTokensForm" style="margin-top:10px;">
                            <div class="grid2">
                                <select id="saRevokeUserId" name="user_id" required></select>
                                <button type="submit" class="danger">Revoke Tokens</button>
                            </div>
                        </form>
                    </article>

                    <article id="saSecurityCard" class="card">
                        <h3 class="title">Security</h3>
                        <p class="muted">Tokens and stale accounts.</p>
                        <div id="saSecurityList" class="list"></div>

                        <form id="saStaleFilter" class="grid2" style="margin-top:10px;">
                            <input type="number" min="1" max="365" name="days" value="45" placeholder="Days without activity">
                            <button type="submit">Load Accounts</button>
                        </form>

                        <div class="table">
                            <table>
                                <thead><tr><th>User</th><th>Role</th><th>Email</th><th>Last Activity</th><th>Total Tx</th></tr></thead>
                                <tbody id="saStaleRows"></tbody>
                            </table>
                        </div>
                    </article>
                </div>

                <div id="superAdminActivityGroup" class="super-admin-detail-grid hidden" style="margin-top:12px;">
                    <article id="saActivityInsightsCard" class="card">
                        <h3 class="title">Activity</h3>
                        <p class="muted">Transaction activity by user.</p>
                        <form id="saActivityFilter" class="grid3">
                            <input type="date" name="from">
                            <input type="date" name="to">
                            <button type="submit">Refresh</button>
                        </form>
                        <div class="table">
                            <table>
                                <thead><tr><th>User</th><th>Role</th><th>Tx</th><th>Qty</th><th>Amount</th><th>Last Activity</th></tr></thead>
                                <tbody id="saActivityRows"></tbody>
                            </table>
                        </div>
                    </article>

                    <article id="saActivityShortcutsCard" class="card sa-feature-card">
                        <span class="sa-feature-tag">Activity</span>
                        <h3 class="title">Logs and settings</h3>
                        <p class="muted">Open login logs, audit logs, settings, or safeguards.</p>
                        <div class="sa-feature-actions stacked">
                            <button type="button" class="secondary" data-nav-view="reportsView" data-nav-section="governance" data-nav-card="reportsLoginCard">Login Activities</button>
                            <button type="button" class="secondary" data-nav-view="reportsView" data-nav-section="governance" data-nav-card="reportsAuditCard">Audit Logs</button>
                            <button type="button" class="secondary" data-nav-view="reportsView" data-nav-section="settings" data-nav-card="reportsSettingsCard">System Settings</button>
                            <button type="button" class="secondary" data-nav-view="reportsView" data-nav-section="settings" data-nav-card="reportsSafeguardsCard">Safeguards</button>
                        </div>
                    </article>
                </div>
            </section>
        </div>
    </main>
</section>
<div id="logoutConfirmModal" class="app-confirm hidden" aria-hidden="true">
    <div class="app-confirm-backdrop" data-logout-confirm-close></div>
    <div class="app-confirm-dialog" role="dialog" aria-modal="true" aria-labelledby="logoutConfirmTitle" aria-describedby="logoutConfirmText">
        <div class="app-confirm-head">
            <div class="app-confirm-icon" aria-hidden="true">!</div>
            <div class="app-confirm-copy">
                <span class="auth-label">Session Warning</span>
                <h3 id="logoutConfirmTitle">Log out of this workspace?</h3>
                <p id="logoutConfirmText">You will be signed out of the current session and need to log in again to continue using the system.</p>
            </div>
        </div>
        <div class="app-confirm-meta" aria-hidden="true">
            <span class="app-confirm-chip">Secure sign-out</span>
            <span class="app-confirm-chip">Current session will end</span>
        </div>
        <div class="actions app-confirm-actions">
            <button id="logoutConfirmCancelBtn" type="button" class="secondary">Stay Signed In</button>
            <button id="logoutConfirmApproveBtn" type="button" class="danger">Log Out</button>
        </div>
    </div>
</div>
<script>
function safeJsonParse(raw, fallback = null) {
    if (!raw) return fallback;
    try {
        return JSON.parse(raw);
    } catch (_) {
        return fallback;
    }
}
const state = {
    token: localStorage.getItem('farm_token') || '',
    user: safeJsonParse(localStorage.getItem('farm_user'), null),
    permissions: {},
    categories: [],
    suppliers: [],
    warehouses: [],
    products: [],
    users: [],
    userFilters: {
        search: '',
        role: '',
    },
    customer: {
        activeSection: 'shop',
        products: [],
        requests: [],
        orders: [],
        favorites: [],
        favoriteAlerts: [],
        notifications: [],
        seasonalSuggestions: [],
        seasonalMeta: {
            month: null,
            season: '',
        },
        profile: null,
        cart: [],
        selectedProductId: null,
        selectedProductDetail: null,
        selectedProductReviews: [],
        selectedProductRating: 0,
        filters: {
            search: '',
            stock_status: '',
            sort: 'name_asc',
        },
        seasonalFilters: {
            month: String(new Date().getMonth() + 1),
            limit: '12',
        },
    },
    pos: {
        search: '',
        cart: [],
        sales: [],
        products: [],
        warehouses: [],
        warehouseId: '',
        warehouse: null,
        lastSale: null,
    },
    operations: {
        activeSection: 'setup',
        orderFilters: {
            status: '',
            search: '',
        },
        forecastFilters: {
            branch_id: '',
            lookback_days: '60',
            forecast_days: '30',
            limit: '20',
        },
        orders: [],
        branches: [],
        branchOverview: [],
        unassignedWarehouses: [],
        forecast: [],
        forecastMeta: {
            lookback_days: 60,
            forecast_days: 30,
            branch_id: null,
        },
        inventoryFilters: {
            warehouse_id: '',
            status: '',
            search: '',
            threshold_days: '90',
        },
        inventorySummary: null,
        inventoryWarehouseSummary: [],
        inventoryBatches: [],
        inventoryAging: [],
        inventoryAgingMeta: {
            threshold_days: 90,
            average_age_days: 0,
            buckets: {
                fresh: 0,
                monitor: 0,
                aging: 0,
            },
        },
        promotions: [],
        receipts: [],
        receiptDraftItems: [],
        adjustments: [],
        adjustmentDraft: [],
        editingProductId: null,
        editingPromotionId: null,
        editingBranchId: null,
    },
    reports: {
        activeSection: 'inventory',
        business: null,
    },
    userManagement: {
        activeSection: 'directory',
    },
    dashboard: null,
    superAdmin: {
        activeSection: 'overview',
        overview: null,
        roles: null,
        activity: null,
        stale: null,
        security: null,
        loginActivities: null,
        auditLogs: null,
        settings: null,
        loginFilters: {
            action: '',
            user_id: '',
            from: '',
            to: '',
        },
        auditFilters: {
            action: '',
            user_id: '',
            from: '',
            to: '',
        },
    },
};
const viewMeta = {
    dashboardView: ['Dashboard', 'See stock, sales, and alerts at a glance.'],
    staffHomeView: ['Staff Desk', 'Run checkout, stock checks, and receiving from one workspace.'],
    customerLandingView: ['Customer Home', 'Start shopping, check orders, and keep delivery details ready.'],
    customerView: ['Customer Workspace', 'Browse, checkout, and track orders in one place.'],
    posView: ['Point of Sale', 'Process sales and review recent counter activity.'],
    operationsView: ['Operations', 'Open setup, catalog, stock, and order tasks from one workspace.'],
    reportsView: ['Reports', 'Check inventory, sales, and access logs.'],
    usersView: ['Users', 'Manage accounts and roles.'],
    superAdminView: ['Super Admin', 'Open one control area at a time for setup, stock, users, and security.'],
};

function money(v) { return new Intl.NumberFormat('en-PH', { style: 'currency', currency: 'PHP' }).format(Number(v || 0)); }
function num(v) { return new Intl.NumberFormat('en-PH').format(Number(v || 0)); }
function defaultViewId() {
    const preferred = isCustomer()
        ? 'customerLandingView'
        : (isStaffUser() ? 'staffHomeView' : 'dashboardView');
    const preferredView = document.getElementById(preferred);
    if (preferredView && !preferredView.classList.contains('hidden')) return preferred;

    const fallbackViews = ['staffHomeView', 'dashboardView', 'customerLandingView', 'customerView', 'operationsView', 'reportsView', 'posView', 'usersView', 'superAdminView'];
    return fallbackViews.find((id) => {
        const view = document.getElementById(id);
        return !!view && !view.classList.contains('hidden');
    }) || 'dashboardView';
}
function dateFmt(v) {
    if (!v) return '-';
    try { return new Date(v).toLocaleDateString('en-PH', { year: 'numeric', month: 'short', day: 'numeric' }); }
    catch (_) { return String(v); }
}
function dateTimeLocalValue(v) {
    if (!v) return '';
    const d = new Date(v);
    if (Number.isNaN(d.getTime())) return '';
    const pad = (n) => String(n).padStart(2, '0');
    return `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}T${pad(d.getHours())}:${pad(d.getMinutes())}`;
}
function notice(el, message, kind = 'ok') {
    if (!el) return;
    el.innerHTML = `<div class="notice ${kind}">${message}</div>`;
}
let logoutConfirmResolver = null;
function setLogoutConfirmOpen(open) {
    const modal = document.getElementById('logoutConfirmModal');
    if (!modal) return;
    modal.classList.toggle('hidden', !open);
    modal.setAttribute('aria-hidden', open ? 'false' : 'true');
    document.body.classList.toggle('confirm-open', open);
    if (open) {
        document.getElementById('logoutConfirmCancelBtn')?.focus();
    }
}
function resolveLogoutConfirm(result) {
    const resolver = logoutConfirmResolver;
    logoutConfirmResolver = null;
    setLogoutConfirmOpen(false);
    if (resolver) resolver(result);
}
function requestLogoutConfirm() {
    return new Promise((resolve) => {
        logoutConfirmResolver = resolve;
        setLogoutConfirmOpen(true);
    });
}
function errMessage(data) {
    if (data?.errors) {
        const key = Object.keys(data.errors)[0];
        if (key && data.errors[key]?.length) return data.errors[key][0];
    }
    return data?.message || 'Request failed';
}

async function api(path, options = {}) {
    const headers = { Accept: 'application/json', ...(options.headers || {}) };
    if (options.body && !(options.body instanceof FormData)) headers['Content-Type'] = 'application/json';
    if (state.token) headers.Authorization = `Bearer ${state.token}`;
    const response = await fetch(`/api${path}`, { ...options, headers });
    const data = await response.json().catch(() => ({}));
    if (!response.ok) throw new Error(errMessage(data));
    return data;
}

function recoverInterfaceIfHidden(forceAuth = false) {
    const authSection = document.getElementById('authSection');
    const appSection = document.getElementById('appSection');
    if (!authSection || !appSection) return;

    const authHidden = authSection.classList.contains('hidden');
    const appHidden = appSection.classList.contains('hidden');
    if (forceAuth || (authHidden && appHidden)) {
        authSection.classList.remove('hidden');
        appSection.classList.add('hidden');
    }

    if (!appSection.classList.contains('hidden') && !document.querySelector('.view.active')) {
        switchView(defaultViewId());
    }
}
function setAuth(loggedIn) {
    const authSection = document.getElementById('authSection');
    const appSection = document.getElementById('appSection');
    if (!authSection || !appSection) return;
    authSection.classList.toggle('hidden', !!loggedIn);
    appSection.classList.toggle('hidden', !loggedIn);
    recoverInterfaceIfHidden(false);
}
function isSuperAdmin() {
    return state.user?.role === 'super_admin' || !!state.permissions.manage_super_admin;
}
function isCustomer() {
    return state.user?.role === 'customer';
}
function isStaffUser() {
    return state.user?.role === 'staff';
}
function canUsePos() {
    if (isCustomer()) return false;
    return state.user?.role === 'super_admin'
        || !!state.permissions.use_pos
        || !!state.permissions.manage_transactions;
}
function canManageOrders() {
    return !!state.permissions.manage_orders;
}
function canManagePromotions() {
    return !!state.permissions.manage_promotions;
}
function canManageProducts() {
    return !!state.permissions.manage_products
        || state.user?.role === 'manager'
        || state.user?.role === 'admin'
        || state.user?.role === 'super_admin';
}
function canRecordStockReceipts() {
    return !!state.permissions.manage_transactions || !!state.permissions.manage_inventory;
}
function canManageBranches() {
    return !!state.permissions.manage_branches;
}
function canViewSmartFeatures() {
    return !!state.permissions.view_smart_features;
}
function syncRolePresentation() {
    const brandTitle = document.getElementById('brandTitle');
    const brandSubtitle = document.getElementById('brandSubtitle');
    const brandModePill = document.getElementById('brandModePill');
    const posMenu = document.getElementById('posMenu');
    const operationsMenu = document.getElementById('operationsMenu');
    const reportsMenu = document.getElementById('reportsMenu');
    const dashboardMenu = document.getElementById('dashboardMenu');
    const opNavTitle = document.querySelector('#operationsView .op-layout-nav .title');
    const opNavSubtitle = document.querySelector('#operationsView .op-layout-nav .muted');
    const setupTab = document.querySelector('#opSectionTabs button[data-op-section="setup"]');
    const catalogTab = document.querySelector('#opSectionTabs button[data-op-section="catalog"]');
    const adjustmentsTab = document.querySelector('#opSectionTabs button[data-op-section="adjustments"]');
    const inventoryTab = document.querySelector('#opSectionTabs button[data-op-section="inventory"]');
    const batchTab = document.querySelector('#opSectionTabs button[data-op-section="batch"]');
    const deliveriesTab = document.querySelector('#opSectionTabs button[data-op-section="deliveries"]');
    const commerceTab = document.querySelector('#opSectionTabs button[data-op-section="commerce"]');
    const smartTab = document.querySelector('#opSectionTabs button[data-op-section="smart"]');
    const productCardTitle = document.querySelector('#opProductTxCard > .title');
    const productCardSubtitle = document.querySelector('#opProductTxCard > p.muted');

    if (brandTitle) brandTitle.textContent = 'Farm Supply Inventory';

    if (isCustomer()) {
        if (brandSubtitle) brandSubtitle.textContent = 'Simple ordering portal';
        if (brandModePill) brandModePill.textContent = 'Customer Portal';
    } else if (isStaffUser()) {
        if (brandSubtitle) brandSubtitle.textContent = 'Simple sales and stock desk';
        if (brandModePill) brandModePill.textContent = 'Staff Workspace';
    } else if (isSuperAdmin()) {
        if (brandSubtitle) brandSubtitle.textContent = 'System controls and oversight';
        if (brandModePill) brandModePill.textContent = 'Super Admin';
    } else {
        if (brandSubtitle) brandSubtitle.textContent = 'Daily inventory workspace';
        if (brandModePill) brandModePill.textContent = 'Control Center';
    }

    if (dashboardMenu) dashboardMenu.textContent = 'Dashboard';
    if (posMenu) posMenu.textContent = isStaffUser() ? 'POS Counter' : 'POS';
    if (operationsMenu) operationsMenu.textContent = isStaffUser() ? 'Inventory Desk' : 'Operations';
    if (reportsMenu) reportsMenu.textContent = isStaffUser() ? 'Shift Reports' : 'Reports';

    if (opNavTitle) opNavTitle.textContent = isStaffUser() ? 'Inventory Desk' : 'Operations';
    if (opNavSubtitle) opNavSubtitle.textContent = isStaffUser()
        ? 'Open the exact task you need for stock, receiving, orders, or visibility.'
        : 'Open the task you need for setup, catalog, stock, orders, or branches.';
    if (setupTab) setupTab.textContent = 'Setup';
    if (catalogTab) catalogTab.textContent = isStaffUser() ? 'Catalog' : 'Product Catalog';
    if (adjustmentsTab) adjustmentsTab.textContent = isStaffUser() ? 'Adjustments' : 'Stock Adjustment';
    if (inventoryTab) inventoryTab.textContent = 'Inventory Summary';
    if (batchTab) batchTab.textContent = 'Batch Health';
    if (deliveriesTab) deliveriesTab.textContent = 'Receiving';
    if (commerceTab) commerceTab.textContent = 'Orders';
    if (smartTab) smartTab.textContent = isStaffUser() ? 'Visibility' : 'Branches';
    if (productCardTitle) productCardTitle.textContent = isStaffUser() ? 'Catalog Desk' : 'Product Catalog';
    if (productCardSubtitle) productCardSubtitle.textContent = isStaffUser()
        ? 'Review the catalog and post simple stock movement.'
        : 'Add products, review stock targets, and post quick stock updates.';
}
function syncShellMode() {
    const appSection = document.getElementById('appSection');
    const customerMode = isCustomer();
    const staffMode = isStaffUser();
    document.body.classList.toggle('customer-shell-active', customerMode);
    document.body.classList.toggle('staff-shell-active', staffMode);
    appSection?.classList.toggle('customer-shell', customerMode);
    appSection?.classList.toggle('staff-shell', staffMode);
    syncRolePresentation();
}
const operationsLayoutConfig = {
    setup: {
        groupIds: ['opSetupGroup'],
        cardIds: ['opMasterDataCard'],
    },
    catalog: {
        groupIds: ['opSetupGroup'],
        cardIds: ['opProductTxCard'],
    },
    adjustments: {
        groupIds: ['opAdjustmentsGroup'],
        cardIds: ['opAdjustmentCard'],
    },
    inventory: {
        groupIds: ['opInventoryGroup'],
        cardIds: ['opInventorySummaryCard'],
    },
    batch: {
        groupIds: ['opInventoryGroup'],
        cardIds: ['opInventoryBatchCard'],
    },
    commerce: {
        groupIds: ['opCommerceGroup'],
        cardIds: ['opOrdersCard', 'opPromotionsCard'],
    },
    deliveries: {
        groupIds: ['opDeliveryGroup'],
        cardIds: ['opReceiptsCard', 'opReceiptsListCard'],
    },
    smart: {
        groupIds: ['opForecastGroup', 'opBranchGroup'],
        cardIds: ['opForecastCard', 'opBranchManageCard', 'opBranchOverviewCard'],
    },
};
function sectionHasVisibleCards(sectionKey) {
    const section = operationsLayoutConfig[sectionKey];
    if (!section) return false;
    return section.cardIds.some((id) => {
        const card = document.getElementById(id);
        return !!card && !card.classList.contains('hidden');
    });
}
function firstAvailableOperationsSection() {
    return Object.keys(operationsLayoutConfig).find((key) => sectionHasVisibleCards(key)) || null;
}
function renderOperationsSectionTabs(activeSection) {
    const tabsRoot = document.getElementById('opSectionTabs');
    if (!tabsRoot) return;

    tabsRoot.querySelectorAll('button[data-op-section]').forEach((button) => {
        const key = String(button.dataset.opSection || '');
        const enabled = sectionHasVisibleCards(key);
        button.disabled = !enabled;
        button.classList.toggle('active', enabled && key === activeSection);
        button.setAttribute('aria-selected', enabled && key === activeSection ? 'true' : 'false');
    });
}
function setOperationsSection(sectionKey = 'setup') {
    const available = firstAvailableOperationsSection();
    const allGroups = [...new Set(Object.values(operationsLayoutConfig).flatMap((section) => section.groupIds || []))];
    const allCards = [...new Set(Object.values(operationsLayoutConfig).flatMap((section) => section.cardIds || []))];

    if (!available) {
        allGroups.forEach((groupId) => {
            document.getElementById(groupId)?.classList.add('section-hidden');
        });
        allCards.forEach((cardId) => {
            document.getElementById(cardId)?.classList.add('section-hidden');
        });
        renderOperationsSectionTabs(null);
        return;
    }

    const nextSection = sectionHasVisibleCards(sectionKey) ? sectionKey : available;
    state.operations.activeSection = nextSection;

    allGroups.forEach((groupId) => {
        document.getElementById(groupId)?.classList.add('section-hidden');
    });
    allCards.forEach((cardId) => {
        document.getElementById(cardId)?.classList.add('section-hidden');
    });

    const activeSection = operationsLayoutConfig[nextSection];
    (activeSection.groupIds || []).forEach((groupId) => {
        document.getElementById(groupId)?.classList.remove('section-hidden');
    });
    (activeSection.cardIds || []).forEach((cardId) => {
        document.getElementById(cardId)?.classList.remove('section-hidden');
    });

    (activeSection.groupIds || []).forEach((groupId) => {
        const group = document.getElementById(groupId);
        if (!group) return;
        const hasVisibleCards = Array.from(group.querySelectorAll('.card')).some((card) => !card.classList.contains('hidden') && !card.classList.contains('section-hidden'));
        group.classList.toggle('section-hidden', !hasVisibleCards);
    });

    renderOperationsSectionTabs(nextSection);
    const helper = document.getElementById('opGuideHelper');
    if (helper) helper.textContent = operationsSectionMeta[nextSection] || operationsSectionMeta.setup;
    syncActiveViewSubtitle('operationsView', operationsSectionMeta[nextSection] || operationsSectionMeta.setup);
}
const reportsLayoutConfig = {
    inventory: {
        groupIds: ['reportsInventoryGroup'],
        cardIds: ['reportMovementCard', 'reportExpiringCard'],
    },
    business: {
        groupIds: ['reportsBusinessGroup', 'reportsBusinessSummaryGroup'],
        cardIds: ['reportSalesDailyCard', 'reportTopSellingCard', 'reportInventoryValueCard', 'reportLowStockBusinessCard'],
    },
    governance: {
        groupIds: ['reportsGovernanceGroup'],
        cardIds: ['reportsLoginCard', 'reportsAuditCard'],
    },
    settings: {
        groupIds: ['reportsSettingsGroup'],
        cardIds: ['reportsSettingsCard', 'reportsSafeguardsCard'],
    },
};
const customerLayoutConfig = {
    shop: {
        groupIds: ['customerShopGroup'],
        cardIds: ['customerCatalogCard', 'customerSpotlightCard', 'customerCartCard'],
    },
    orders: {
        groupIds: ['customerOrdersGroup'],
        cardIds: ['customerOrdersCard', 'customerRequestsCard'],
    },
    saved: {
        groupIds: ['customerSavedGroup'],
        cardIds: ['customerFavoritesCard', 'customerAlertsCard', 'customerNotificationsCard', 'customerSeasonCard'],
    },
    account: {
        groupIds: ['customerAccountGroup'],
        cardIds: ['customerProfileCard', 'customerReviewCard'],
    },
};
const customerSectionMeta = {
    shop: 'Start with Browse, then review and checkout.',
    orders: 'Use Orders to track status and reorder quickly.',
    saved: 'Use Favorites to keep saved items and alerts together.',
    account: 'Use Profile to keep delivery details and password ready.',
};
const operationsSectionMeta = {
    setup: 'Start with Setup, then open the task you need.',
    catalog: 'Use Catalog to add products and review stock targets.',
    adjustments: 'Use Adjustments for damage, expiry, recounts, and stock fixes.',
    inventory: 'Use Inventory to review stock, value, and warehouse health.',
    batch: 'Use Batch Health to watch batch status, aging, and expiry risk.',
    deliveries: 'Use Receiving to record supplier deliveries and stock-in history.',
    commerce: 'Use Orders to review customer orders and promotions.',
    smart: 'Use Branches to review branch setup and shared stock status.',
};
const reportsSectionMeta = {
    inventory: 'Start with Inventory to review movement, expiry, and stock risk.',
    business: 'Use Sales to review revenue, best sellers, and inventory value.',
    governance: 'Use Access Logs to review login activity and audit history.',
    settings: 'Use Settings for backups, safeguards, and access controls.',
};
const usersSectionMeta = {
    directory: 'Open Directory to find a user and review the role.',
    editor: 'Use Editor to create an account or update the selected user.',
};
const superAdminSectionMeta = {
    overview: 'Start with Overview before opening a control area.',
    setup: 'Use Setup to monitor categories, suppliers, warehouses, and branches.',
    products: 'Use Products to manage catalog quality and promotions.',
    stock: 'Use Stock to review in, out, adjustments, and orders.',
    inventory: 'Use Inventory to monitor batches, low stock, and alerts.',
    users: 'Use Users to create accounts, update roles, and manage the directory.',
    security: 'Use Security to review tokens, passwords, and safeguard actions.',
    activity: 'Use Logs to review insights, shortcuts, and audit trails.',
};
const usersLayoutConfig = {
    directory: {
        groupIds: ['usersDirectoryGroup'],
        cardIds: ['usersDirectoryCard'],
    },
    editor: {
        groupIds: ['usersEditorGroup'],
        cardIds: ['usersEditorCard'],
    },
};
const superAdminLayoutConfig = {
    overview: {
        groupIds: ['superAdminOverviewGroup'],
        cardIds: ['saRoleDistributionCard', 'saOverviewJumpCard', 'saOverviewStatusCard', 'saOverviewPathsCard'],
    },
    setup: {
        groupIds: ['superAdminSetupGroup'],
        cardIds: ['saSetupCategoriesCard', 'saSetupSuppliersCard', 'saSetupWarehousesCard', 'saSetupBranchesCard'],
    },
    products: {
        groupIds: ['superAdminProductsGroup'],
        cardIds: ['saProductFormCard', 'saProductCatalogCard', 'saProductPromotionsCard'],
    },
    stock: {
        groupIds: ['superAdminStockGroup'],
        cardIds: ['saStockInCard', 'saStockOutCard', 'saStockAdjustmentsCard', 'saStockOrdersCard'],
    },
    inventory: {
        groupIds: ['superAdminInventoryGroup'],
        cardIds: ['saInventorySummaryFeatureCard', 'saInventoryBatchFeatureCard', 'saInventoryAlertsFeatureCard'],
    },
    users: {
        groupIds: ['superAdminUsersGroup'],
        cardIds: ['saCreateAccountCard', 'saBulkRolesCard', 'saUsersJumpCard'],
    },
    security: {
        groupIds: ['superAdminSecurityGroup'],
        cardIds: ['saPasswordControlCard', 'saSecurityCard'],
    },
    activity: {
        groupIds: ['superAdminActivityGroup'],
        cardIds: ['saActivityInsightsCard', 'saActivityShortcutsCard'],
    },
};
function layoutSectionHasVisibleCards(config, sectionKey) {
    const section = config[sectionKey];
    if (!section) return false;
    return (section.cardIds || []).some((id) => {
        const card = document.getElementById(id);
        return !!card && !card.classList.contains('hidden');
    });
}
function layoutFirstAvailableSection(config) {
    return Object.keys(config).find((key) => layoutSectionHasVisibleCards(config, key)) || null;
}
function renderLayoutSectionTabs(tabsRootId, dataAttr, config, activeSection) {
    const tabsRoot = document.getElementById(tabsRootId);
    if (!tabsRoot) return;

    tabsRoot.querySelectorAll(`button[${dataAttr}]`).forEach((button) => {
        const key = String(button.getAttribute(dataAttr) || '');
        const enabled = layoutSectionHasVisibleCards(config, key);
        button.disabled = !enabled;
        button.classList.toggle('active', enabled && key === activeSection);
        button.setAttribute('aria-selected', enabled && key === activeSection ? 'true' : 'false');
    });
}
function applyLayoutSection(config, tabsRootId, dataAttr, sectionKey) {
    const available = layoutFirstAvailableSection(config);
    if (!available) {
        Object.values(config).forEach((section) => {
            (section.groupIds || []).forEach((groupId) => {
                document.getElementById(groupId)?.classList.add('hidden');
            });
        });
        renderLayoutSectionTabs(tabsRootId, dataAttr, config, null);
        return null;
    }

    const nextSection = layoutSectionHasVisibleCards(config, sectionKey) ? sectionKey : available;
    Object.entries(config).forEach(([key, section]) => {
        const isActive = key === nextSection;
        (section.groupIds || []).forEach((groupId) => {
            const group = document.getElementById(groupId);
            if (!group) return;
            group.classList.toggle('hidden', !isActive);
        });
    });
    renderLayoutSectionTabs(tabsRootId, dataAttr, config, nextSection);
    return nextSection;
}
function syncActiveViewSubtitle(viewId, text) {
    if (document.querySelector('.view.active')?.id !== viewId) return;
    const subtitle = document.getElementById('viewSubtitle');
    if (subtitle && text) subtitle.textContent = text;
}
function setCustomerSection(sectionKey = 'shop') {
    const resolved = applyLayoutSection(customerLayoutConfig, 'customerSectionTabs', 'data-customer-section', sectionKey);
    if (resolved) {
        state.customer.activeSection = resolved;
        const helper = document.getElementById('customerGuideHelper');
        if (helper) helper.textContent = customerSectionMeta[resolved] || customerSectionMeta.shop;
        syncActiveViewSubtitle('customerView', customerSectionMeta[resolved] || customerSectionMeta.shop);
        if (document.querySelector('.view.active')?.id === 'customerView') {
            document.querySelectorAll('.menu-btn[data-view="customerView"]').forEach((button) => {
                button.classList.toggle('active', String(button.dataset.customerSection || 'shop') === resolved);
            });
        }
    }
}
function openCustomerSection(sectionKey = 'shop') {
    const nextSection = String(sectionKey || 'shop');
    state.customer.activeSection = nextSection;
    switchView('customerView', { customerSection: nextSection });
}
function openOperationsSection(sectionKey = 'setup') {
    state.operations.activeSection = String(sectionKey || 'setup');
    switchView('operationsView');
}
function setReportsSection(sectionKey = 'inventory') {
    const resolved = applyLayoutSection(reportsLayoutConfig, 'reportsSectionTabs', 'data-reports-section', sectionKey);
    if (resolved) {
        state.reports.activeSection = resolved;
        const helper = document.getElementById('reportsGuideHelper');
        if (helper) helper.textContent = reportsSectionMeta[resolved] || reportsSectionMeta.inventory;
        syncActiveViewSubtitle('reportsView', reportsSectionMeta[resolved] || reportsSectionMeta.inventory);
    }
}
function setReportsFeatureVisibility() {
    const canViewReports = !!state.permissions.view_reports;
    const canViewGovernance = canViewReports && isSuperAdmin();

    ['reportMovementCard', 'reportExpiringCard', 'reportSalesDailyCard', 'reportTopSellingCard', 'reportInventoryValueCard', 'reportLowStockBusinessCard'].forEach((id) => {
        document.getElementById(id)?.classList.toggle('hidden', !canViewReports);
    });
    ['reportsLoginCard', 'reportsAuditCard', 'reportsSettingsCard', 'reportsSafeguardsCard'].forEach((id) => {
        document.getElementById(id)?.classList.toggle('hidden', !canViewGovernance);
    });

    setReportsSection(state.reports.activeSection || 'inventory');
}
function setUserManagementSection(sectionKey = 'directory') {
    const resolved = applyLayoutSection(usersLayoutConfig, 'usersSectionTabs', 'data-users-section', sectionKey);
    if (resolved) {
        state.userManagement.activeSection = resolved;
        const helper = document.getElementById('usersGuideHelper');
        if (helper) helper.textContent = usersSectionMeta[resolved] || usersSectionMeta.directory;
        syncActiveViewSubtitle('usersView', usersSectionMeta[resolved] || usersSectionMeta.directory);
    }
}
function setSuperAdminSection(sectionKey = 'overview') {
    const resolved = applyLayoutSection(superAdminLayoutConfig, 'superAdminSectionTabs', 'data-super-section', sectionKey);
    if (resolved) {
        state.superAdmin.activeSection = resolved;
        const helper = document.getElementById('superGuideHelper');
        if (helper) helper.textContent = superAdminSectionMeta[resolved] || superAdminSectionMeta.overview;
        syncActiveViewSubtitle('superAdminView', superAdminSectionMeta[resolved] || superAdminSectionMeta.overview);
    }
}
function setOperationsFeatureVisibility() {
    const canViewOrders = canManageOrders() || !!state.permissions.view_orders;
    const canViewPromotions = canManagePromotions();
    const canViewReceipts = canRecordStockReceipts();
    const canViewSmart = canViewSmartFeatures();
    const canViewBranchManagement = canViewSmart || canManageBranches();
    const staffMode = isStaffUser();

    document.getElementById('opMasterDataCard')?.classList.toggle('hidden', staffMode);
    document.getElementById('productForm')?.classList.toggle('hidden', staffMode);
    document.getElementById('opOrdersCard')?.classList.toggle('hidden', !canViewOrders);
    document.getElementById('opPromotionsCard')?.classList.toggle('hidden', !canViewPromotions);
    document.getElementById('opReceiptsCard')?.classList.toggle('hidden', !canViewReceipts);
    document.getElementById('opReceiptsListCard')?.classList.toggle('hidden', !canViewReceipts);
    document.getElementById('opForecastCard')?.classList.toggle('hidden', !canViewSmart);
    document.getElementById('opBranchManageCard')?.classList.toggle('hidden', !canViewBranchManagement);
    document.getElementById('opBranchOverviewCard')?.classList.toggle('hidden', !canViewSmart);
    document.getElementById('customerSeasonCard')?.classList.toggle('hidden', !isCustomer() || !canViewSmartFeatures());
    setProductFormAccess();
    setBranchFormAccess();
    setOperationsSection(state.operations.activeSection || 'setup');
}
function setMenuByRole() {
    const canCustomerHub = isCustomer();
    const canStaffDesk = isStaffUser();
    syncShellMode();
    const canPos = canUsePos();
    const canOperations = !!state.permissions.view_operations;
    const canReports = !!state.permissions.view_reports;
    const canUsers = !!state.permissions.manage_users;
    const canSuperAdmin = isSuperAdmin();

    document.getElementById('dashboardMenu').classList.toggle('hidden', canCustomerHub || canStaffDesk);
    document.getElementById('staffHomeMenu').classList.toggle('hidden', !canStaffDesk);
    document.getElementById('customerHomeMenu').classList.toggle('hidden', !canCustomerHub);
    document.getElementById('customerMenu').classList.toggle('hidden', !canCustomerHub);
    document.getElementById('customerOrdersMenu').classList.toggle('hidden', !canCustomerHub);
    document.getElementById('customerSavedMenu').classList.toggle('hidden', !canCustomerHub);
    document.getElementById('customerProfileMenu').classList.toggle('hidden', !canCustomerHub);
    document.getElementById('posMenu').classList.toggle('hidden', !canPos);
    document.getElementById('operationsMenu').classList.toggle('hidden', !canOperations);
    document.getElementById('reportsMenu').classList.toggle('hidden', !canReports);
    document.getElementById('usersMenu').classList.toggle('hidden', !canUsers);
    document.getElementById('superAdminMenu').classList.toggle('hidden', !canSuperAdmin);

    document.getElementById('dashboardView').classList.toggle('hidden', canCustomerHub || canStaffDesk);
    document.getElementById('staffHomeView').classList.toggle('hidden', !canStaffDesk);
    document.getElementById('customerLandingView').classList.toggle('hidden', !canCustomerHub);
    document.getElementById('customerView').classList.toggle('hidden', !canCustomerHub);
    document.getElementById('posView').classList.toggle('hidden', !canPos);
    document.getElementById('operationsView').classList.toggle('hidden', !canOperations);
    document.getElementById('reportsView').classList.toggle('hidden', !canReports);
    document.getElementById('usersView').classList.toggle('hidden', !canUsers);
    document.getElementById('superAdminView').classList.toggle('hidden', !canSuperAdmin);

    document.getElementById('staffHomePosBtn')?.classList.toggle('hidden', !canPos);
    document.getElementById('staffHomeInventoryBtn')?.classList.toggle('hidden', !canOperations);
    document.getElementById('staffHomeDeliveriesBtn')?.classList.toggle('hidden', !canOperations || !canRecordStockReceipts());
    document.getElementById('staffHomeReportsBtn')?.classList.toggle('hidden', !canReports);
    document.getElementById('staffHomeLowStockBtn')?.classList.toggle('hidden', !canOperations);
    document.getElementById('staffHomeActivityBtn')?.classList.toggle('hidden', !canReports);
    document.getElementById('staffHomePosSalesBtn')?.classList.toggle('hidden', !canPos);

    const activeViewId = document.querySelector('.view.active')?.id;
    if (!activeViewId || document.getElementById(activeViewId)?.classList.contains('hidden')) {
        switchView(defaultViewId());
    }
    setOperationsFeatureVisibility();
    setReportsFeatureVisibility();
    if (canCustomerHub) setCustomerSection(state.customer.activeSection || 'shop');
    setUserManagementSection(state.userManagement.activeSection || 'directory');
    setSuperAdminSection(state.superAdmin.activeSection || 'overview');
    renderSuperAdminFeatureSummary();
    renderStaffHome();
}
function getRoleAwareViewMeta(viewId) {
    if (isStaffUser()) {
        const staffMeta = {
            staffHomeView: ['Staff Desk', 'Run checkout, stock checks, and receiving from one workspace.'],
            posView: ['POS Counter', 'Process sales quickly and keep the counter moving.'],
            operationsView: ['Inventory Desk', 'Open stock, receiving, and branch tasks from one clear workspace.'],
            reportsView: ['Shift Reports', 'Check stock alerts, sales movement, and daily reports.'],
        };
        if (staffMeta[viewId]) return staffMeta[viewId];
    }
    return viewMeta[viewId] || viewMeta[defaultViewId()] || viewMeta.dashboardView;
}
function switchView(viewId, options = {}) {
    const targetView = document.getElementById(viewId);
    if (!targetView || targetView.classList.contains('hidden')) {
        viewId = defaultViewId();
    }
    const customerSection = viewId === 'customerView'
        ? String(options.customerSection || state.customer.activeSection || 'shop')
        : '';

    document.querySelectorAll('.view').forEach((v) => v.classList.remove('active'));
    document.querySelectorAll('.menu-btn').forEach((button) => {
        const matchesView = button.dataset.view === viewId;
        const targetSection = String(button.dataset.customerSection || '');
        const matchesSection = !targetSection || targetSection === customerSection;
        button.classList.toggle('active', matchesView && matchesSection);
    });
    document.getElementById(viewId).classList.add('active');
    const meta = getRoleAwareViewMeta(viewId);
    document.getElementById('viewTitle').textContent = meta[0];
    document.getElementById('viewSubtitle').textContent = meta[1];
    if (viewId === 'customerView') {
        setCustomerSection(customerSection);
    } else if (viewId === 'operationsView') {
        setOperationsSection(state.operations.activeSection || 'setup');
    } else if (viewId === 'reportsView') {
        setReportsSection(state.reports.activeSection || 'inventory');
    } else if (viewId === 'usersView') {
        setUserManagementSection(state.userManagement.activeSection || 'directory');
    } else if (viewId === 'superAdminView') {
        setSuperAdminSection(state.superAdmin.activeSection || 'overview');
    }
}
function openWorkspaceFeature(viewId, sectionKey = '', cardId = '') {
    switchView(viewId);

    if (viewId === 'customerView' && sectionKey) {
        setCustomerSection(sectionKey);
    } else if (viewId === 'operationsView' && sectionKey) {
        setOperationsSection(sectionKey);
    } else if (viewId === 'reportsView' && sectionKey) {
        setReportsSection(sectionKey);
    } else if (viewId === 'usersView' && sectionKey) {
        setUserManagementSection(sectionKey);
    } else if (viewId === 'superAdminView' && sectionKey) {
        setSuperAdminSection(sectionKey);
    }

    if (cardId) {
        window.setTimeout(() => {
            document.getElementById(cardId)?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }, 80);
    }
}
function badge(type, text) { return `<span class="badge ${type}">${text}</span>`; }
function stockBadge(item) {
    if (Number(item.current_stock) <= 0) return badge('out', 'out of stock');
    if (Number(item.current_stock) <= Number(item.reorder_point)) return badge('low', 'low stock');
    return badge('ok', 'in stock');
}
function fillSelect(id, items, label, valueKey = 'id', placeholder = null) {
    const el = document.getElementById(id);
    if (!el) return;
    const currentValue = String(el.value || '');
    const rows = [];
    if (placeholder !== null) rows.push(`<option value="">${placeholder}</option>`);
    for (const item of items) rows.push(`<option value="${item[valueKey]}">${label(item)}</option>`);
    el.innerHTML = rows.join('') || '<option value="">No data</option>';
    if (currentValue && Array.from(el.options).some((option) => option.value === currentValue)) {
        el.value = currentValue;
    }
}
function fillBranchSelects(branches) {
    const list = branches || [];
    fillSelect('warehouseBranchSelect', list, (branch) => `${branch.name} (${branch.code})`, 'id', 'No branch (optional)');
    fillSelect('opForecastBranchSelect', list, (branch) => `${branch.name} (${branch.code})`, 'id', 'All branches');
}
function applyResponsiveTableLabels(root = document) {
    root.querySelectorAll('.table table').forEach((table) => {
        const headers = Array.from(table.querySelectorAll('thead th')).map((th) => String(th.textContent || '').trim());
        if (!headers.length) return;

        table.querySelectorAll('tbody tr').forEach((row) => {
            const cells = Array.from(row.children).filter((cell) => cell.tagName === 'TD');
            cells.forEach((cell, index) => {
                if (cell.hasAttribute('colspan')) {
                    cell.removeAttribute('data-label');
                    return;
                }
                cell.setAttribute('data-label', headers[Math.min(index, headers.length - 1)] || 'Value');
            });
        });
    });
}
let responsiveTableObserver = null;
function setupResponsiveTableLabels() {
    applyResponsiveTableLabels(document);

    if (responsiveTableObserver) return;
    const target = document.querySelector('.views');
    if (!target) return;

    responsiveTableObserver = new MutationObserver((mutations) => {
        if (!mutations.some((m) => m.type === 'childList' && (m.addedNodes.length || m.removedNodes.length))) {
            return;
        }
        applyResponsiveTableLabels(document);
    });

    responsiveTableObserver.observe(target, { childList: true, subtree: true });
}
let liveEffectsReady = false;
function setupLiveVisualEffects() {
    if (liveEffectsReady) return;
    liveEffectsReady = true;

    const root = document.documentElement;
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const clampPercent = (value) => Math.max(0, Math.min(100, value));
    const setGlobalFx = (clientX, clientY) => {
        const width = Math.max(window.innerWidth, 1);
        const height = Math.max(window.innerHeight, 1);
        const x = clampPercent((clientX / width) * 100);
        const y = clampPercent((clientY / height) * 100);
        root.style.setProperty('--fx-x', `${x.toFixed(2)}%`);
        root.style.setProperty('--fx-y', `${y.toFixed(2)}%`);
    };

    let pendingPoint = null;
    let rafPending = false;
    window.addEventListener('pointermove', (event) => {
        if (reduceMotion) return;
        pendingPoint = { x: event.clientX, y: event.clientY };
        if (rafPending) return;
        rafPending = true;
        window.requestAnimationFrame(() => {
            rafPending = false;
            if (!pendingPoint) return;
            setGlobalFx(pendingPoint.x, pendingPoint.y);
            pendingPoint = null;
        });
    }, { passive: true });
    setGlobalFx(window.innerWidth * 0.5, window.innerHeight * 0.42);

    document.addEventListener('pointermove', (event) => {
        if (!(event.target instanceof Element)) return;
        const button = event.target.closest('button');
        if (button && !button.disabled) {
            const rect = button.getBoundingClientRect();
            const x = event.clientX - rect.left;
            const y = event.clientY - rect.top;
            if (x >= 0 && y >= 0 && x <= rect.width && y <= rect.height) {
                button.style.setProperty('--btn-fx-x', `${clampPercent((x / Math.max(rect.width, 1)) * 100).toFixed(2)}%`);
                button.style.setProperty('--btn-fx-y', `${clampPercent((y / Math.max(rect.height, 1)) * 100).toFixed(2)}%`);
            }
        }

        if (reduceMotion) return;
        const card = event.target.closest('.card');
        if (!card) return;
        const rect = card.getBoundingClientRect();
        const x = event.clientX - rect.left;
        const y = event.clientY - rect.top;
        card.style.setProperty('--card-glow-x', `${clampPercent((x / Math.max(rect.width, 1)) * 100).toFixed(2)}%`);
        card.style.setProperty('--card-glow-y', `${clampPercent((y / Math.max(rect.height, 1)) * 100).toFixed(2)}%`);
    }, { passive: true });

    document.addEventListener('pointerdown', (event) => {
        if (event.button !== 0) return;
        if (!(event.target instanceof Element)) return;
        const button = event.target.closest('button');
        if (!button || button.disabled) return;
        const rect = button.getBoundingClientRect();
        const x = event.clientX - rect.left;
        const y = event.clientY - rect.top;
        button.style.setProperty('--ripple-x', `${x}px`);
        button.style.setProperty('--ripple-y', `${y}px`);
        button.classList.remove('btn-ripple');
        void button.offsetWidth;
        button.classList.add('btn-ripple');
        window.setTimeout(() => button.classList.remove('btn-ripple'), 700);
    }, { passive: true });
}
let uiRecoveryHandlersReady = false;
function setupUiRecoveryHandlers() {
    if (uiRecoveryHandlersReady) return;
    uiRecoveryHandlersReady = true;
    window.addEventListener('error', () => recoverInterfaceIfHidden(false));
    window.addEventListener('unhandledrejection', () => recoverInterfaceIfHidden(false));
}
const superAdminPanelStorageKey = 'farm_super_admin_panels';
function readSuperAdminPanelState() {
    try {
        const raw = localStorage.getItem(superAdminPanelStorageKey);
        const parsed = raw ? JSON.parse(raw) : {};
        return parsed && typeof parsed === 'object' && !Array.isArray(parsed) ? parsed : {};
    } catch (_) {
        return {};
    }
}
function saveSuperAdminPanelState(stateMap) {
    localStorage.setItem(superAdminPanelStorageKey, JSON.stringify(stateMap || {}));
}
function applySuperAdminPanelCollapsed(card, toggleButton, collapsed) {
    card.classList.toggle('panel-collapsed', !!collapsed);
    toggleButton.textContent = collapsed ? 'Expand' : 'Minimize';
    toggleButton.setAttribute('aria-expanded', collapsed ? 'false' : 'true');
}
function setupSuperAdminPanels() {
    const root = document.getElementById('superAdminView');
    if (!root) return;

    const storedState = readSuperAdminPanelState();
    const cards = Array.from(root.querySelectorAll('.layout2 > .card'));
    cards.forEach((card, index) => {
        if (card.dataset.panelReady === '1') return;

        const originalTitle = card.querySelector(':scope > .title');
        if (!originalTitle) return;

        const panelId = card.id || `sa-panel-${index + 1}`;
        card.dataset.panelReady = '1';
        card.dataset.panelId = panelId;

        const panelHead = document.createElement('div');
        panelHead.className = 'panel-head';

        const title = document.createElement('h3');
        title.className = 'title';
        title.textContent = originalTitle.textContent || 'Panel';

        const toggleButton = document.createElement('button');
        toggleButton.type = 'button';
        toggleButton.className = 'secondary panel-toggle';

        panelHead.appendChild(title);
        panelHead.appendChild(toggleButton);

        originalTitle.remove();

        const panelBody = document.createElement('div');
        panelBody.className = 'panel-body';
        while (card.firstChild) {
            panelBody.appendChild(card.firstChild);
        }

        card.appendChild(panelHead);
        card.appendChild(panelBody);

        const collapsed = Object.prototype.hasOwnProperty.call(storedState, panelId)
            ? !!storedState[panelId]
            : index >= 2;
        applySuperAdminPanelCollapsed(card, toggleButton, collapsed);

        toggleButton.addEventListener('click', () => {
            const nextCollapsed = !card.classList.contains('panel-collapsed');
            applySuperAdminPanelCollapsed(card, toggleButton, nextCollapsed);
            const nextState = readSuperAdminPanelState();
            nextState[panelId] = nextCollapsed;
            saveSuperAdminPanelState(nextState);
        });
    });
}
function updateUserBar() {
    document.getElementById('whoName').textContent = state.user?.name || '-';
    document.getElementById('whoRole').textContent = state.user?.role || '-';
}
function toggleRoleOption(selectId, roleValue, enabled) {
    const select = document.getElementById(selectId);
    if (!select) return;
    const option = select.querySelector(`option[value="${roleValue}"]`);
    if (!option) return;
    option.hidden = !enabled;
    option.disabled = !enabled;
    if (!enabled && select.value === roleValue) {
        select.value = 'staff';
    }
}
function configureRoleSelects() {
    const canAssignSuperAdmin = isSuperAdmin();
    toggleRoleOption('userRoleSelect', 'super_admin', canAssignSuperAdmin);
    toggleRoleOption('saCreateRoleSelect', 'super_admin', canAssignSuperAdmin);
    toggleRoleOption('saBulkRoleSelect', 'super_admin', canAssignSuperAdmin);
}
function resetUserForm() {
    const form = document.getElementById('userForm');
    form.reset();
    document.getElementById('userIdField').value = '';
    document.getElementById('userFormTitle').textContent = 'Create Account';
    document.getElementById('userFormSubtitle').textContent = 'Admins only.';
    document.getElementById('userPasswordInput').required = true;
    document.getElementById('userPasswordInput').placeholder = 'Password';
    document.getElementById('userSubmitBtn').textContent = 'Create User';
    document.getElementById('userCancelEditBtn').classList.add('hidden');
}
function setUserEditMode(user) {
    document.getElementById('userIdField').value = String(user.id);
    document.getElementById('userNameInput').value = user.name || '';
    document.getElementById('userEmailInput').value = user.email || '';
    document.getElementById('userRoleSelect').value = user.role || 'staff';
    document.getElementById('userPasswordInput').value = '';
    document.getElementById('userPasswordInput').required = false;
    document.getElementById('userPasswordInput').placeholder = 'Leave blank to keep current password';
    document.getElementById('userFormTitle').textContent = 'Edit Account';
    document.getElementById('userFormSubtitle').textContent = `Editing ${user.name}`;
    document.getElementById('userSubmitBtn').textContent = 'Update User';
    document.getElementById('userCancelEditBtn').classList.remove('hidden');
}
function findUserById(userId) {
    const numericId = Number(userId);
    return state.users.find((item) => Number(item.id) === numericId) || null;
}
function findProductById(productId) {
    const numericId = Number(productId);
    return (state.products || []).find((item) => Number(item.id) === numericId) || null;
}
function upsertProductState(product) {
    if (!product || !product.id) return;
    const productId = Number(product.id);
    const rows = Array.isArray(state.products) ? [...state.products] : [];
    const index = rows.findIndex((item) => Number(item.id) === productId);
    if (index >= 0) {
        rows[index] = { ...rows[index], ...product };
    } else {
        rows.push(product);
    }
    rows.sort((left, right) => String(left?.name || '').localeCompare(String(right?.name || '')));
    state.products = rows;
}
function syncQuickStockProductMeta() {
    const product = findProductById(document.getElementById('txProductSelect')?.value || 0);
    const unitPriceInput = document.getElementById('txUnitPriceInput');
    const meta = document.getElementById('txProductMeta');

    if (unitPriceInput) {
        unitPriceInput.value = product ? Number(product.unit_price || 0) : '';
    }

    if (meta) {
        meta.textContent = product
            ? `SKU: ${product.sku || '-'} | Unit: ${product.unit_of_measure || '-'} | Default price: ${money(product.unit_price || 0)} | Min stock: ${num(product.min_stock_level || 0)} | Reorder point: ${num(product.reorder_point || 0)}`
            : 'Choose a product to fill in the price and view stock targets.';
    }
}
function refreshOperationsProductUi(selectedProductId = '') {
    fillSelect('txProductSelect', state.products, (p) => `${p.name} (${p.sku})`);
    fillSelect('adjustProductSelect', state.products, (p) => `${p.name} (${p.sku})`);
    renderOperationsProducts();

    const selectedValue = String(selectedProductId || '');
    if (selectedValue && document.getElementById('txProductSelect')) {
        document.getElementById('txProductSelect').value = selectedValue;
    }
    syncQuickStockProductMeta();
    syncAdjustmentInventoryOptions(false);
}
function setProductFormAccess() {
    const form = document.getElementById('productForm');
    const hint = document.getElementById('productFormHint');
    if (!form || !hint) return;

    const canManage = canManageProducts();
    Array.from(form.elements || []).forEach((element) => {
        const field = element;
        if (!field) return;
        if (field.name === 'product_id') return;
        if (field.id === 'productCancelEditBtn') return;
        field.disabled = !canManage;
    });

    document.getElementById('productSubmitBtn').disabled = !canManage;
    const cancelBtn = document.getElementById('productCancelEditBtn');
    if (cancelBtn) cancelBtn.disabled = !canManage;
    hint.textContent = canManage
        ? 'Manage product catalog records for operations.'
        : 'Read-only view. Ask a manager, admin, or super admin to manage products.';
}
function resetProductForm() {
    const form = document.getElementById('productForm');
    if (!form) return;

    form.reset();
    state.operations.editingProductId = null;
    document.getElementById('productIdField').value = '';
    document.getElementById('productSubmitBtn').textContent = 'Add Product';
    document.getElementById('productCancelEditBtn').classList.add('hidden');
    setProductFormAccess();
}
function setProductEditMode(product) {
    const form = document.getElementById('productForm');
    if (!form || !product) return;

    state.operations.editingProductId = Number(product.id || 0);
    document.getElementById('productIdField').value = String(product.id || '');
    form.elements.name.value = product.name || '';
    form.elements.sku.value = product.sku || '';
    form.elements.category_id.value = String(product.category_id || '');
    form.elements.supplier_id.value = product.supplier_id ? String(product.supplier_id) : '';
    form.elements.unit_of_measure.value = product.unit_of_measure || '';
    form.elements.unit_price.value = Number(product.unit_price || 0);
    form.elements.min_stock_level.value = Number(product.min_stock_level || 0);
    form.elements.reorder_point.value = Number(product.reorder_point || 0);
    form.elements.image_file.value = '';
    document.getElementById('productSubmitBtn').textContent = 'Update Product';
    document.getElementById('productCancelEditBtn').classList.remove('hidden');
    setProductFormAccess();
}
function renderOperationsProducts() {
    const rows = state.products || [];
    const canManage = canManageProducts();

    document.getElementById('opProductRows').innerHTML = rows.length
        ? rows.map((product) => {
            const isActive = !!product.is_active;
            const actionLabel = isActive ? 'Remove' : 'Restore';
            const nextStatus = isActive ? '0' : '1';

            return `<tr>
                <td>${product.name || '-'}</td>
                <td>${product.sku || '-'}</td>
                <td>${product.category?.name || '-'}</td>
                <td>${money(product.unit_price || 0)}</td>
                <td>${num(product.current_stock || 0)}</td>
                <td>${num(product.min_stock_level || 0)}</td>
                <td>${num(product.reorder_point || 0)}</td>
                <td>${isActive ? badge('ok', 'active') : badge('out', 'inactive')}</td>
                <td>
                    <div class="inline-actions">
                        <button type="button" class="btn-inline secondary op-product-edit-btn" data-product-id="${product.id}" ${canManage ? '' : 'disabled'}>Edit</button>
                        <button type="button" class="btn-inline secondary op-product-toggle-btn" data-product-id="${product.id}" data-next-active="${nextStatus}" ${canManage ? '' : 'disabled'}>${actionLabel}</button>
                        <button type="button" class="btn-inline danger op-product-delete-btn" data-product-id="${product.id}" ${canManage ? '' : 'disabled'}>Delete</button>
                    </div>
                </td>
            </tr>`;
        }).join('')
        : '<tr><td colspan="9">No products available.</td></tr>';
}
function renderStaffHome() {
    const d = state.dashboard || {};
    const k = d.kpis || {};
    const sales = state.pos.sales || [];
    const catalog = (state.pos.products || []).filter((item) => item && item.is_active !== false);
    const low = d.lowStockItems || [];
    const tx = d.recent_transactions || [];
    const setText = (id, value) => {
        const el = document.getElementById(id);
        if (el) el.textContent = value;
    };

    setText('staffMetricActive', num(k.active_products || catalog.length || 0));
    setText('staffMetricLow', num(k.low_stock_products || low.length || 0));
    setText('staffMetricToday', money(k.today_sales || 0));
    setText('staffMetricBranches', num(d.overview?.branches || 0));
    setText('staffFocusCatalog', num(catalog.length || k.active_products || 0));
    setText('staffFocusSales', num(sales.length || 0));
    setText('staffFocusSuppliers', num(d.overview?.suppliers || 0));
    setText('staffFocusValue', money(k.inventory_value || 0));

    const lowList = document.getElementById('staffLowList');
    if (lowList) {
        lowList.innerHTML = low.length
            ? low.slice(0, 4).map((item) => `<div class="staff-home-list-item"><strong>${item.name || '-'}</strong><small>${num(item.current_stock || 0)} left • Reorder at ${num(item.reorder_point || 0)}</small></div>`).join('')
            : '<div class="staff-home-empty">No low-stock alerts right now.</div>';
    }

    const recentList = document.getElementById('staffRecentList');
    if (recentList) {
        recentList.innerHTML = tx.length
            ? tx.slice(0, 4).map((item) => `<div class="staff-home-list-item"><strong>${item.transaction_number || item.transaction_type || 'Inventory update'}</strong><small>${item.product?.name || 'Product update'} • Qty ${num(item.quantity || 0)} • ${dateFmt(item.created_at)}</small></div>`).join('')
            : '<div class="staff-home-empty">No recent stock movement yet.</div>';
    }

    const posRows = document.getElementById('staffPosSalesRows');
    if (posRows) {
        posRows.innerHTML = sales.length
            ? sales.slice(0, 4).map((sale) => `<tr><td>${sale.sale_number || '-'}</td><td>${sale.cashier_name || '-'}</td><td>${num(sale.total_items || 0)}</td><td>${money(sale.total_amount || 0)}</td></tr>`).join('')
            : '<tr><td colspan="4">No recent POS sales.</td></tr>';
    }

    applyResponsiveTableLabels(document.getElementById('staffHomeView'));
}
function renderDashboard() {
    const d = state.dashboard || {};
    const k = d.kpis || {};
    document.getElementById('kpiProducts').textContent = num(k.total_products || 0);
    document.getElementById('kpiActive').textContent = num(k.active_products || 0);
    document.getElementById('kpiLow').textContent = num(k.low_stock_products || 0);
    document.getElementById('kpiOut').textContent = num(k.out_of_stock_products || 0);
    document.getElementById('kpiValue').textContent = money(k.inventory_value || 0);
    document.getElementById('kpiToday').textContent = money(k.today_sales || 0);
    document.getElementById('kpiMonth').textContent = money(k.month_sales || 0);
    document.getElementById('kpiSuppliers').textContent = num(d.overview?.suppliers || 0);
    document.getElementById('kpiBranches').textContent = num(d.overview?.branches || 0);

    const lowRows = document.getElementById('lowRows');
    const low = d.lowStockItems || [];
    lowRows.innerHTML = low.length ? low.map((i) => `<tr><td>${i.name}</td><td>${i.current_stock}</td><td>${i.reorder_point}</td><td>${stockBadge(i)}</td></tr>`).join('') : '<tr><td colspan="4">No low-stock items.</td></tr>';

    const recentList = document.getElementById('recentList');
    const tx = d.recent_transactions || [];
    recentList.innerHTML = tx.length ? tx.map((t) => `<div class="list-item"><div class="head"><span>${t.transaction_number || '-'}</span><span>${t.transaction_type}</span></div><div>${t.product?.name || '-'} | Qty: ${t.quantity} | ${dateFmt(t.created_at)}</div></div>`).join('') : '<div class="list-item">No transactions.</div>';

    const topRows = d.top_products || [];
    document.getElementById('topRows').innerHTML = topRows.length
        ? topRows.map((p) => `<tr><td>${p.name || '-'}</td><td>${num(p.moved_qty || 0)}</td></tr>`).join('')
        : '<tr><td colspan="2">No movement data.</td></tr>';

    const catRows = d.stock_by_category || [];
    document.getElementById('catRows').innerHTML = catRows.length
        ? catRows.map((c) => `<tr><td>${c.category_name || '-'}</td><td>${num(c.stock || 0)}</td></tr>`).join('')
        : '<tr><td colspan="2">No category stock data.</td></tr>';

    const trendRows = d.monthly_sales_trend || [];
    document.getElementById('trendRows').innerHTML = trendRows.length
        ? trendRows.map((m) => `<tr><td>${m.month || '-'}</td><td>${money(m.total || 0)}</td></tr>`).join('')
        : '<tr><td colspan="2">No monthly sales trend.</td></tr>';

    renderSuperAdminFeatureSummary();
    renderStaffHome();
}
function renderMovement(data) {
    const rows = data?.summary || [];
    document.getElementById('moveRows').innerHTML = rows.length ? rows.map((r) => `<tr><td>${r.transaction_type}</td><td>${r.total_qty}</td><td>${money(r.total_amount)}</td></tr>`).join('') : '<tr><td colspan="3">No movement data.</td></tr>';
}
function renderExpiring(data) {
    const rows = data?.items || [];
    document.getElementById('expRows').innerHTML = rows.length ? rows.map((i) => `<tr><td>${i.product?.name || '-'}</td><td>${i.warehouse?.name || '-'}</td><td>${i.batch_number || '-'}</td><td>${dateFmt(i.manufacturing_date)}</td><td>${i.quantity}</td><td>${dateFmt(i.expiry_date)}</td></tr>`).join('') : '<tr><td colspan="6">No expiring stock.</td></tr>';
}
function renderBusinessReports(data) {
    const daily = data?.daily_sales || [];
    document.getElementById('reportSalesRows').innerHTML = daily.length
        ? daily.map((row) => `<tr><td>${dateFmt(row.date)}</td><td>${num(row.orders || 0)}</td><td>${money(row.revenue || 0)}</td></tr>`).join('')
        : '<tr><td colspan="3">No sales data.</td></tr>';

    const topSelling = data?.top_selling_products || [];
    document.getElementById('reportTopSellingRows').innerHTML = topSelling.length
        ? topSelling.map((row) => `<tr><td>${row.product_name || '-'}</td><td>${num(row.quantity_sold || 0)}</td><td>${money(row.revenue || 0)}</td></tr>`).join('')
        : '<tr><td colspan="3">No top selling product data.</td></tr>';

    const inventoryStatus = data?.inventory_status || {};
    document.getElementById('reportInventoryValue').textContent = money(data?.totals?.inventory_value || 0);
    document.getElementById('reportInventoryStatusRows').innerHTML = [
        `<tr><td>In Stock</td><td>${num(inventoryStatus.in_stock || 0)}</td></tr>`,
        `<tr><td>Low Stock</td><td>${num(inventoryStatus.low_stock || 0)}</td></tr>`,
        `<tr><td>Out Of Stock</td><td>${num(inventoryStatus.out_of_stock || 0)}</td></tr>`,
    ].join('');

    const lowStock = data?.low_stock_report || [];
    document.getElementById('reportLowStockRows').innerHTML = lowStock.length
        ? lowStock.map((row) => `<tr><td>${row.name || '-'}</td><td>${num(row.current_stock || 0)}</td><td>${num(row.reorder_point || 0)}</td></tr>`).join('')
        : '<tr><td colspan="3">No low stock products.</td></tr>';
}
function adjustmentDirectionLabel(type) {
    return String(type || 'adjustment').replace(/_/g, ' ');
}
function adjustmentReasonLabel(reason) {
    return String(reason || '-').replace(/_/g, ' ');
}
function findProductRecord(productId) {
    return (state.products || []).find((item) => Number(item.id) === Number(productId)) || null;
}
function findWarehouseRecord(warehouseId) {
    return (state.warehouses || []).find((item) => Number(item.id) === Number(warehouseId)) || null;
}
function getAdjustmentInventoryMatches(productId, warehouseId) {
    return (state.operations.inventoryBatches || []).filter((item) => {
        const itemProductId = Number(item.product_id || item.product?.id || 0);
        const itemWarehouseId = Number(item.warehouse_id || item.warehouse?.id || 0);
        if (productId && itemProductId !== Number(productId)) return false;
        if (warehouseId && itemWarehouseId !== Number(warehouseId)) return false;
        return true;
    });
}
function syncAdjustmentInventoryOptions(preserveValue = true) {
    const select = document.getElementById('adjustInventorySelect');
    const productSelect = document.getElementById('adjustProductSelect');
    const warehouseSelect = document.getElementById('adjustWarehouseSelect');
    if (!select || !productSelect || !warehouseSelect) return;

    const currentValue = preserveValue ? String(select.value || '') : '';
    const matches = getAdjustmentInventoryMatches(productSelect.value, warehouseSelect.value);
    fillSelect('adjustInventorySelect', matches, inventoryBatchLabel, 'id', matches.length ? 'Select exact batch (optional)' : 'No matching batch yet');
    if (currentValue && matches.some((item) => String(item.id) === currentValue)) {
        select.value = currentValue;
    }
    if (!select.value && matches.length === 1) {
        select.value = String(matches[0].id);
    }

    const selectedBatch = matches.find((item) => String(item.id) === String(select.value || ''));
    const unitCostInput = document.querySelector('#adjustmentForm input[name="unit_price"]');
    if (unitCostInput && selectedBatch && !String(unitCostInput.value || '').trim()) {
        unitCostInput.value = Number(selectedBatch.unit_cost || 0).toFixed(2);
    }
}
function renderAdjustmentDraft() {
    const rows = state.operations.adjustmentDraft || [];
    const draftBody = document.getElementById('adjustmentDraftRows');
    if (!draftBody) return;

    const decreases = rows.filter((item) => item.adjustment_type === 'decrease').length;
    const increases = rows.filter((item) => item.adjustment_type === 'increase').length;
    document.getElementById('adjustmentDraftCount').textContent = num(rows.length);
    document.getElementById('adjustmentDecreaseCount').textContent = num(decreases);
    document.getElementById('adjustmentIncreaseCount').textContent = num(increases);

    draftBody.innerHTML = rows.length
        ? rows.map((row) => `<tr>
            <td>${row.product_name}</td>
            <td>${row.warehouse_name}</td>
            <td>${row.batch_label || 'Auto-select first batch'}</td>
            <td>${adjustmentDirectionLabel(row.adjustment_type)}</td>
            <td>${adjustmentReasonLabel(row.adjustment_reason)}</td>
            <td>${num(row.quantity || 0)}</td>
            <td>${money(row.unit_price || 0)}</td>
            <td>${row.notes || row.reference_number || '-'}</td>
            <td><button type="button" class="secondary btn-inline adjustment-draft-remove" data-draft-id="${row.id}">Remove</button></td>
        </tr>`).join('')
        : '<tr><td colspan="9">No draft adjustments yet.</td></tr>';
}
function renderOperationsAdjustments() {
    const rows = state.operations.adjustments || [];
    document.getElementById('adjustmentRows').innerHTML = rows.length
        ? rows.map((row) => {
            const notes = String(row.notes || '');
            const direction = notes.includes('Adjustment (increase)') ? 'increase' : (notes.includes('Adjustment (decrease)') ? 'decrease' : 'adjustment');
            const reasonMatch = notes.match(/Reason:\s*([a-z_]+)/i);
            const reason = reasonMatch ? reasonMatch[1] : '-';
            const batchNumber = row.inventory?.batch_number || '-';
            return `<tr>
                <td>${dateFmt(row.created_at)}</td>
                <td>${row.product?.name || '-'}</td>
                <td>${row.warehouse?.name || '-'}</td>
                <td>${batchNumber}</td>
                <td>${num(row.quantity || 0)}</td>
                <td>${adjustmentDirectionLabel(direction)}</td>
                <td>${adjustmentReasonLabel(reason)}</td>
                <td>${row.notes || '-'}</td>
            </tr>`;
        }).join('')
        : '<tr><td colspan="8">No stock adjustments found.</td></tr>';
}
function printPosReceipt(sale) {
    if (!sale) return;
    const lines = Array.isArray(sale.lines) ? sale.lines : [];
    const lineHtml = lines.length
        ? lines.map((line) => `
            <tr>
                <td>${line.product_name || '-'}</td>
                <td style="text-align:right;">${num(line.quantity || 0)}</td>
                <td style="text-align:right;">${money(line.unit_price || 0)}</td>
                <td style="text-align:right;">${money(line.line_total || 0)}</td>
            </tr>
        `).join('')
        : '<tr><td colspan="4">No items</td></tr>';

    const receiptHtml = `
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>POS Receipt - ${sale.sale_number || ''}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 18px; color: #111; }
        h2 { margin: 0 0 6px; }
        .meta { margin: 2px 0; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; font-size: 13px; }
        th, td { border-bottom: 1px solid #ddd; padding: 6px 4px; text-align: left; }
        .totals { margin-top: 12px; }
        .totals div { display: flex; justify-content: space-between; margin: 3px 0; }
        .grand { font-weight: 700; }
        @media print { body { margin: 0; } }
            </style>
</head>
<body>
    <h2>Farm Supply Store</h2>
    <div class="meta">Receipt #: ${sale.sale_number || '-'}</div>
    <div class="meta">Date: ${dateFmt(new Date())}</div>
    <div class="meta">Payment: ${String(sale.payment_method || '-').toUpperCase()}</div>
    ${sale.customer_name ? `<div class="meta">Customer: ${sale.customer_name}</div>` : ''}
    ${sale.gcash_reference_number ? `<div class="meta">GCash Ref: ${sale.gcash_reference_number}</div>` : ''}
    <table>
        <thead><tr><th>Item</th><th style="text-align:right;">Qty</th><th style="text-align:right;">Price</th><th style="text-align:right;">Total</th></tr></thead>
        <tbody>${lineHtml}</tbody>
    </table>
    <div class="totals">
        <div><span>Subtotal</span><span>${money(sale.subtotal || 0)}</span></div>
        <div><span>Discount</span><span>${money(sale.discount || 0)}</span></div>
        <div class="grand"><span>Total</span><span>${money(sale.total_amount || sale.total || 0)}</span></div>
        <div><span>Amount Paid</span><span>${money(sale.cash_received || sale.amount_paid || 0)}</span></div>
        <div><span>Change</span><span>${money(sale.change_due || 0)}</span></div>
    </div>
</body>
</html>`;

    const printWindow = window.open('', '_blank', 'width=420,height=760');
    if (!printWindow) return;
    printWindow.document.open();
    printWindow.document.write(receiptHtml);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
}
function renderUsers(users) {
    const rows = users?.data || [];
    const isCurrentUser = (userId) => Number(userId) === Number(state.user?.id || 0);
    const canManageSuperAdmins = isSuperAdmin();

    document.getElementById('userRows').innerHTML = rows.length
        ? rows.map((u) => {
            const cannotManageRole = !canManageSuperAdmins && u.role === 'super_admin';
            const disableEdit = cannotManageRole ? 'disabled' : '';
            const disableDelete = isCurrentUser(u.id) || cannotManageRole ? 'disabled' : '';

            return `<tr>
                <td>${u.name}</td>
                <td>${u.email}</td>
                <td>${badge('role', u.role)}</td>
                <td>${dateFmt(u.created_at)}</td>
                <td>
                    <div class="inline-actions">
                        <button type="button" class="btn-inline secondary user-edit-btn" data-user-id="${u.id}" ${disableEdit}>Edit</button>
                        <button type="button" class="btn-inline danger user-delete-btn" data-user-id="${u.id}" ${disableDelete}>Delete</button>
                    </div>
                </td>
            </tr>`;
        }).join('')
        : '<tr><td colspan="5">No users.</td></tr>';
}
function esc(value) {
    return String(value ?? '').replace(/[&<>"']/g, (char) => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#39;',
    }[char] || char));
}
function formatCustomerPaymentMethod(method) {
    const normalized = String(method || '').toLowerCase();
    if (normalized === 'cod') return 'Cash on Delivery';
    if (normalized === 'cash') return 'Cash';
    if (normalized === 'online_payment') return 'Online Payment';
    if (!normalized) return '-';
    return normalized.replace(/_/g, ' ').replace(/\b\w/g, (letter) => letter.toUpperCase());
}
function productImageUrl(imagePath) {
    const raw = String(imagePath || '').trim();
    if (!raw) return '';
    if (/^https?:\/\//i.test(raw)) return raw;
    if (raw.startsWith('/')) return raw;
    return `/storage/${raw.replace(/^\/+/, '')}`;
}
function customerProductAccent(product) {
    const palettes = [
        ['#173e58', '#26a69a'],
        ['#27445d', '#3ca9d3'],
        ['#214d43', '#52b788'],
        ['#4d3a5f', '#2f8fb5'],
    ];
    const seed = Number(product?.id || 0) + String(product?.category?.name || '').length;
    const palette = palettes[Math.abs(seed) % palettes.length];
    return `linear-gradient(135deg, ${palette[0]}, ${palette[1]})`;
}
function customerProductMediaMarkup(product, variant = 'card') {
    const imageUrl = productImageUrl(product?.image);
    const variantClass = variant === 'spotlight' ? 'customer-spotlight-media' : '';
    const label = esc(product?.category?.name || 'Farm Supply');
    const coverText = variant === 'spotlight'
        ? esc(product?.name || 'Product')
        : esc(String(product?.name || 'F').slice(0, 1).toUpperCase());

    return `<div class="customer-product-cover ${variantClass}" style="background:${customerProductAccent(product)};">
        ${imageUrl ? `<img src="${imageUrl}" alt="${esc(product?.name || 'Product')}">` : ''}
        <div class="customer-product-cover-content">
            <small>${label}</small>
            <span>${coverText}</span>
        </div>
    </div>`;
}
function findCustomerProduct(productId) {
    const targetId = Number(productId || 0);
    if (!targetId) return null;

    return (state.customer.products || []).find((item) => Number(item.id) === targetId)
        || ((state.customer.selectedProductDetail && Number(state.customer.selectedProductDetail.id) === targetId) ? state.customer.selectedProductDetail : null)
        || (state.customer.favorites || []).find((item) => Number(item.id) === targetId)
        || null;
}
function customerCartTotals() {
    const cart = state.customer.cart || [];
    const totalItems = cart.reduce((sum, line) => sum + Number(line.quantity || 0), 0);
    const subtotal = cart.reduce((sum, line) => sum + (Number(line.quantity || 0) * Number(line.unit_price || 0)), 0);
    return {
        totalItems,
        subtotal: roundCurrency(subtotal),
    };
}
function renderCustomerHubStats() {
    const activeOrders = (state.customer.orders || []).filter((order) => !['completed', 'cancelled'].includes(String(order.status || '').toLowerCase())).length;
    const favoritesCount = (state.customer.favorites || []).length;
    const productCount = (state.customer.products || []).length;
    const cartTotals = customerCartTotals();

    document.getElementById('customerHeroProductCount').textContent = num(productCount);
    document.getElementById('customerHeroCartCount').textContent = num(cartTotals.totalItems);
    document.getElementById('customerHeroOrderCount').textContent = num(activeOrders);
    document.getElementById('customerHeroSavedCount').textContent = num(favoritesCount);
    renderCustomerHome();
}
function renderCustomerHome() {
    const profile = state.customer.profile || state.user || {};
    const orders = state.customer.orders || [];
    const notifications = state.customer.notifications || [];
    const latestOrder = orders.slice().sort((a, b) => {
        const aTime = new Date(a.placed_at || a.created_at || 0).getTime() || 0;
        const bTime = new Date(b.placed_at || b.created_at || 0).getTime() || 0;
        return bTime - aTime;
    })[0] || null;
    const cartTotals = customerCartTotals();
    const productCount = (state.customer.products || []).length;
    const activeOrders = orders.filter((order) => !['completed', 'cancelled'].includes(String(order.status || '').toLowerCase())).length;
    const favoritesCount = (state.customer.favorites || []).length;
    const unreadCount = notifications.filter((item) => !item.is_read).length;
    const setText = (id, value) => {
        const el = document.getElementById(id);
        if (el) el.textContent = value;
    };

    setText('customerHomeProductCount', num(productCount));
    setText('customerHomeCartCount', num(cartTotals.totalItems));
    setText('customerHomeOrderCount', num(activeOrders));
    setText('customerHomeSavedCount', num(favoritesCount));
    setText('customerHomeProfileName', profile.name || state.user?.name || 'Customer');
    setText('customerHomeProfileEmail', profile.email || state.user?.email || '-');
    setText('customerHomeProfilePhone', profile.phone || 'Add a phone number');
    setText('customerHomeProfileAddress', profile.address || 'Add a delivery address');
    setText('customerHomeUnreadCount', num(unreadCount));
    setText('customerHomeLatestOrder', latestOrder?.order_number || 'No orders yet');
    setText('customerContactEmail', profile.email || state.user?.email || '-');
    setText('customerContactPhone', profile.phone || 'Add a phone number');
    setText('customerContactAddress', profile.address || 'Add a delivery address');
}
function toggleCustomerCartDrawer(forceOpen = null) {
    const drawer = document.getElementById('customerCartDrawer');
    if (!drawer) return;
    const open = forceOpen === null ? !drawer.classList.contains('open') : !!forceOpen;
    drawer.classList.toggle('open', open);
    drawer.setAttribute('aria-hidden', open ? 'false' : 'true');
}
function focusCustomerCheckout() {
    toggleCustomerCartDrawer(false);
    document.getElementById('customerCheckoutForm')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
}
function syncCustomerCheckoutPayment() {
    const current = String(document.getElementById('customerCheckoutPayment')?.value || 'cod').toLowerCase();
    document.getElementById('customerCartPaymentLabel').textContent = current === 'cod' ? 'COD' : (current === 'cash' ? 'Cash' : 'Online');
    document.getElementById('customerCheckoutBtn').textContent = current === 'cod'
        ? 'Place COD order'
        : (current === 'cash' ? 'Place cash order' : 'Place online order');
    document.getElementById('customerCheckoutPaymentHelp').textContent = current === 'cod'
        ? 'Pay when the order arrives. We use your saved delivery details for the order.'
        : (current === 'cash'
            ? 'Use this for cash payment arranged with the store.'
            : 'We will confirm payment details after the order is received.');
}
function customerTrackingStepsMarkup(status) {
    const normalized = String(status || 'pending').toLowerCase();
    if (normalized === 'cancelled') {
        return [
            '<div class="customer-track-step done">Order placed</div>',
            '<div class="customer-track-step cancelled">Order cancelled</div>',
        ].join('');
    }

    const steps = ['Order placed', 'Preparing order', 'Ready for release'];
    const activeIndex = normalized === 'pending' ? 0 : (normalized === 'processing' ? 1 : 2);
    return steps.map((label, index) => {
        const stepClass = index < activeIndex ? 'done' : (index === activeIndex ? 'active' : '');
        return `<div class="customer-track-step ${stepClass}">${label}</div>`;
    }).join('');
}
function renderCustomerProducts() {
    const rows = state.customer.products || [];
    const selectedId = Number(state.customer.selectedProductId || 0);
    document.getElementById('customerCatalogGrid').innerHTML = rows.length
        ? rows.map((product) => {
            const disabled = Number(product.current_stock || 0) <= 0 ? 'disabled' : '';
            return `<article class="customer-product-card ${Number(product.id) === selectedId ? 'active' : ''}">
                ${customerProductMediaMarkup(product, 'card')}
                <div class="customer-product-top">
                    <div>
                        <h4 class="customer-product-name">${esc(product.name || '-')}</h4>
                        <div class="customer-product-meta">${esc(product.sku || '-')} | ${esc(product.unit_of_measure || 'unit')}</div>
                    </div>
                    ${stockBadge(product)}
                </div>
                <p class="customer-product-copy">${esc(product.description || 'Ready for browsing, cart building, and customer ordering.')}</p>
                <div class="customer-product-price-row">
                    <strong>${money(product.unit_price || 0)}</strong>
                    <span>${num(product.current_stock || 0)} available</span>
                </div>
                <div class="customer-product-actions">
                    <button type="button" class="secondary btn-inline customer-view-product-btn" data-product-id="${product.id}">View</button>
                    <button type="button" class="secondary btn-inline customer-favorite-product-btn" data-product-id="${product.id}">Favorite</button>
                    <button type="button" class="btn-inline customer-add-cart-btn" data-product-id="${product.id}" ${disabled}>Add to Cart</button>
                </div>
            </article>`;
        }).join('')
        : `<div class="customer-empty-state"><strong>No products matched the current filters.</strong><span>Try resetting the search or switching the stock filter.</span></div>`;

    fillSelect('customerProductSelect', rows, (product) => `${product.name} (${product.sku})`, 'id', rows.length ? 'Select product' : 'No products');
    fillSelect('customerFavoriteProductSelect', rows, (product) => `${product.name} (${product.sku})`, 'id', rows.length ? 'Select product' : 'No products');
    fillSelect('customerReviewProductSelect', rows, (product) => `${product.name} (${product.sku})`, 'id', rows.length ? 'Select reviewed product' : 'No products');
    renderCustomerHubStats();
}
function renderCustomerSelectedProduct() {
    const wrap = document.getElementById('customerSelectedProductCard');
    const product = state.customer.selectedProductDetail || findCustomerProduct(state.customer.selectedProductId);
    if (!product) {
        wrap.innerHTML = `<div class="customer-empty-state"><strong>Select a product to view it.</strong><span>Product details, stock, and quick actions will appear here.</span></div>`;
        return;
    }

    const reviews = state.customer.selectedProductReviews || [];
    const averageRating = Number(state.customer.selectedProductRating || 0);
    const inventoryLines = Array.isArray(product.inventory)
        ? product.inventory.filter((item) => Number(item.quantity || item.stock || 0) > 0).slice(0, 3)
        : [];
    const inventoryMarkup = inventoryLines.length
        ? inventoryLines.map((item) => `<div class="customer-meta-card"><strong>${esc(item.warehouse?.name || 'Warehouse')}</strong><span>${num(item.quantity || item.stock || 0)} units available</span></div>`).join('')
        : `<div class="customer-meta-card"><strong>Availability</strong><span>${num(product.current_stock || 0)} units ready to order</span></div>`;
    const reviewMarkup = reviews.length
        ? reviews.slice(0, 3).map((review) => `<div class="customer-review-item">
            <div class="head"><span>${esc(review.user?.name || 'Customer')}</span><span class="customer-review-rating">${'*'.repeat(Number(review.rating || 0))} ${num(review.rating || 0)}/5</span></div>
            <div class="muted">${esc(review.review || 'Approved customer feedback.')}</div>
        </div>`).join('')
        : `<div class="customer-empty-state"><strong>No approved reviews yet.</strong><span>Be the first customer to leave product feedback after ordering.</span></div>`;

    wrap.innerHTML = `${customerProductMediaMarkup(product, 'spotlight')}
    <div class="customer-spotlight-hero" style="background:${customerProductAccent(product)};">
        <div class="customer-actions">
            <div>
                <h3 class="customer-spotlight-title">${esc(product.name || '-')}</h3>
                <p class="customer-spotlight-copy">${esc(product.description || 'This product is ready for catalog view and order placement.')}</p>
            </div>
            ${stockBadge(product)}
        </div>
        <div class="customer-meta-grid">
            <div class="customer-meta-card"><strong>Price</strong><span>${money(product.unit_price || 0)}</span></div>
            <div class="customer-meta-card"><strong>Average rating</strong><span>${averageRating > 0 ? `${averageRating.toFixed(1)} / 5` : 'New item'}</span></div>
            <div class="customer-meta-card"><strong>Category</strong><span>${esc(product.category?.name || 'Uncategorized')}</span></div>
            <div class="customer-meta-card"><strong>Supplier</strong><span>${esc(product.supplier?.name || 'Store inventory')}</span></div>
            <div class="customer-meta-card"><strong>Unit</strong><span>${esc(product.unit_of_measure || 'unit')}</span></div>
            <div class="customer-meta-card"><strong>Stock</strong><span>${num(product.current_stock || 0)} available now</span></div>
        </div>
        <div class="customer-product-actions">
            <button type="button" class="secondary btn-inline customer-favorite-product-btn" data-product-id="${product.id}">Favorite</button>
            <button type="button" class="secondary btn-inline customer-cod-product-btn" data-product-id="${product.id}" ${Number(product.current_stock || 0) <= 0 ? 'disabled' : ''}>Buy with COD</button>
            <button type="button" class="btn-inline customer-add-cart-btn" data-product-id="${product.id}" ${Number(product.current_stock || 0) <= 0 ? 'disabled' : ''}>Add to Cart</button>
        </div>
    </div>
    <div class="customer-meta-grid">${inventoryMarkup}</div>
    <div>
        <h4 class="title">Recent Customer Feedback</h4>
        <div class="customer-review-stack">${reviewMarkup}</div>
    </div>`;
}
function renderCustomerRequests() {
    const rows = state.customer.requests || [];
    document.getElementById('customerRequestRows').innerHTML = rows.length
        ? rows.map((request) => {
            const status = String(request.status || 'pending').toLowerCase();
            const canCancel = status === 'pending';
            return `<tr>
                <td>${esc(request.product?.name || '-')}</td>
                <td>${num(request.requested_quantity)}</td>
                <td>${badge('role', status)}</td>
                <td>${dateFmt(request.created_at)}</td>
                <td>${canCancel ? `<button type="button" class="btn-inline danger customer-cancel-btn" data-request-id="${request.id}">Cancel</button>` : '<span class="muted">-</span>'}</td>
            </tr>`;
        }).join('')
        : '<tr><td colspan="5">No requests submitted yet.</td></tr>';
}
function renderCustomerProfile() {
    const profile = state.customer.profile || {};
    document.getElementById('customerProfileName').value = profile.name || '';
    document.getElementById('customerProfileEmail').value = profile.email || '';
    document.getElementById('customerProfilePhone').value = profile.phone || '';
    document.getElementById('customerProfileAddress').value = profile.address || '';
    document.getElementById('customerDeliveryAddressText').textContent = profile.address
        ? `${profile.address}${profile.phone ? ` | ${profile.phone}` : ''}`
        : 'No delivery address saved yet. Update your profile to speed up COD checkout.';
    renderCustomerHome();
}
function renderCustomerOrders() {
    const rows = state.customer.orders || [];
    const counts = {
        pending: rows.filter((order) => String(order.status || '').toLowerCase() === 'pending').length,
        processing: rows.filter((order) => String(order.status || '').toLowerCase() === 'processing').length,
        completed: rows.filter((order) => String(order.status || '').toLowerCase() === 'completed').length,
        cancelled: rows.filter((order) => String(order.status || '').toLowerCase() === 'cancelled').length,
    };
    document.getElementById('customerOrderTrackingSummary').innerHTML = [
        `<div class="chip"><strong>${num(rows.length)}</strong><span>Total orders</span></div>`,
        `<div class="chip"><strong>${num(counts.pending)}</strong><span>Pending</span></div>`,
        `<div class="chip"><strong>${num(counts.processing)}</strong><span>Processing</span></div>`,
        `<div class="chip"><strong>${num(counts.completed)}</strong><span>Completed</span></div>`,
    ].join('');

    const featuredOrders = rows.filter((order) => ['pending', 'processing'].includes(String(order.status || '').toLowerCase()));
    const ordersForCards = featuredOrders.length ? featuredOrders : rows.slice(0, 3);
    document.getElementById('customerTrackingCards').innerHTML = ordersForCards.length
        ? ordersForCards.map((order) => {
            const items = (order.items || []).map((item) => `${item.product?.name || 'Item'} x${num(item.quantity || 0)}`).join(', ') || '-';
            return `<article class="customer-tracking-card">
                <div class="customer-tracking-top">
                    <div>
                        <h4 class="title">${esc(order.order_number || '-')}</h4>
                        <div class="customer-tracking-meta">${formatCustomerPaymentMethod(order.payment_method)} | ${dateFmt(order.placed_at || order.created_at)}</div>
                    </div>
                    ${badge('role', order.status || 'pending')}
                </div>
                <div class="customer-tracking-items">${esc(items)}</div>
                <div class="customer-tracking-meta">Order total: ${money(order.total || 0)}</div>
                <div class="customer-tracking-steps">${customerTrackingStepsMarkup(order.status)}</div>
                <div class="customer-row-actions">
                    <button type="button" class="btn-inline secondary customer-reorder-btn" data-order-id="${order.id}">Reorder</button>
                </div>
            </article>`;
        }).join('')
        : `<div class="customer-empty-state"><strong>No orders to track yet.</strong><span>Place a new order from the Shop tab and live tracking cards will appear here.</span></div>`;

    document.getElementById('customerOrderRows').innerHTML = rows.length
        ? rows.map((order) => {
            const items = (order.items || []).map((item) => `${item.product?.name || 'Item'} x${num(item.quantity || 0)}`).join(', ') || '-';
            return `<tr>
                <td>${esc(order.order_number || '-')}</td>
                <td>${esc(items)}</td>
                <td>${formatCustomerPaymentMethod(order.payment_method)}</td>
                <td>${badge('role', order.status || 'pending')}</td>
                <td>${money(order.total || 0)}</td>
                <td>${dateFmt(order.placed_at || order.created_at)}</td>
                <td><button type="button" class="btn-inline secondary customer-reorder-btn" data-order-id="${order.id}">Reorder</button></td>
            </tr>`;
        }).join('')
        : '<tr><td colspan="9">No orders yet.</td></tr>';
    renderCustomerHubStats();
}
function renderCustomerFavorites() {
    const rows = state.customer.favorites || [];
    document.getElementById('customerFavoriteRows').innerHTML = rows.length
        ? rows.map((product) => `<tr>
            <td>${esc(product.name || '-')}</td>
            <td>${esc(product.sku || '-')}</td>
            <td>${num(product.current_stock || 0)}</td>
            <td>
                <div class="customer-row-actions">
                    <button type="button" class="btn-inline secondary customer-favorite-view-btn" data-product-id="${product.id}">View</button>
                    <button type="button" class="btn-inline secondary customer-favorite-cart-btn" data-product-id="${product.id}">Add to Cart</button>
                    <button type="button" class="btn-inline danger customer-favorite-remove-btn" data-product-id="${product.id}">Remove</button>
                </div>
            </td>
        </tr>`).join('')
        : '<tr><td colspan="4">No favorite products yet.</td></tr>';
    renderCustomerHubStats();
}
function renderCustomerFavoriteAlerts() {
    const rows = state.customer.favoriteAlerts || [];
    document.getElementById('customerFavoriteAlertRows').innerHTML = rows.length
        ? rows.map((product) => `<tr>
            <td>${esc(product.name || '-')}</td>
            <td>${esc(product.sku || '-')}</td>
            <td>${num(product.current_stock || 0)}</td>
            <td>${num(product.reorder_point || 0)}</td>
        </tr>`).join('')
        : '<tr><td colspan="4">No low stock alerts for favorites.</td></tr>';
}
function renderCustomerNotifications() {
    const rows = state.customer.notifications || [];
    document.getElementById('customerNotificationRows').innerHTML = rows.length
        ? rows.map((notification) => `<tr>
            <td>${esc(notification.title || '-')}</td>
            <td>${esc(notification.message || '-')}</td>
            <td>${notification.is_read ? badge('ok', 'read') : badge('low', 'unread')}</td>
            <td>${dateFmt(notification.created_at)}</td>
        </tr>`).join('')
        : '<tr><td colspan="4">No notifications yet.</td></tr>';
    renderCustomerHome();
}
function renderCustomerSeasonalSuggestions() {
    const rows = state.customer.seasonalSuggestions || [];
    const meta = state.customer.seasonalMeta || {};
    const monthValue = String(state.customer.seasonalFilters.month || new Date().getMonth() + 1);
    const limitValue = String(state.customer.seasonalFilters.limit || '12');
    document.getElementById('customerSeasonMonth').value = monthValue;
    document.getElementById('customerSeasonLimit').value = limitValue;
    document.getElementById('customerSeasonInfo').textContent = meta.season
        ? `Season: ${String(meta.season).replace('_', ' ')} | Month: ${meta.month || '-'}`
        : 'Recommendations based on Philippine farming season and recent demand.';
    document.getElementById('customerSeasonRows').innerHTML = rows.length
        ? rows.map((item) => `<tr>
            <td>${esc(item.name || '-')}</td>
            <td>${esc(item.category || '-')}</td>
            <td>${num(item.stock || 0)}</td>
            <td>${num(item.score || 0)}</td>
        </tr>`).join('')
        : '<tr><td colspan="4">No seasonal suggestions available.</td></tr>';
}
function renderCustomerMobileCartDrawer() {
    const cart = state.customer.cart || [];
    const totals = customerCartTotals();
    document.getElementById('customerDrawerCartRows').innerHTML = cart.length
        ? cart.map((line) => `<div class="customer-cart-item">
            <div class="customer-cart-row">
                <div>
                    <div class="customer-cart-line-title">${esc(line.name || '-')}</div>
                    <div class="muted">${esc(line.sku || '-')} | ${money(line.unit_price || 0)} each</div>
                </div>
                <button type="button" class="btn-inline danger customer-cart-remove-btn" data-product-id="${line.product_id}">Remove</button>
            </div>
            <div class="customer-cart-row">
                <div class="customer-qty-controls">
                    <button type="button" class="btn-inline secondary customer-cart-qty-btn" data-product-id="${line.product_id}" data-action="dec">-</button>
                    <input type="number" min="1" max="${Math.max(Number(line.available_stock || 0), 1)}" value="${Number(line.quantity || 0)}" class="customer-cart-qty-input" data-product-id="${line.product_id}" inputmode="numeric" aria-label="Quantity for ${esc(line.name || 'product')}">
                    <button type="button" class="btn-inline secondary customer-cart-qty-btn" data-product-id="${line.product_id}" data-action="inc">+</button>
                </div>
                <div class="customer-cart-line-price">${money((Number(line.quantity || 0) * Number(line.unit_price || 0)))}</div>
            </div>
        </div>`).join('')
        : `<div class="customer-empty-state"><strong>Your cart is empty.</strong><span>Add items from the catalog to use the mobile cart drawer.</span></div>`;
    document.getElementById('customerMobileCartFabMeta').textContent = `${num(totals.totalItems)} items | ${money(totals.subtotal)}`;
    document.getElementById('customerDrawerCartCount').textContent = num(totals.totalItems);
    document.getElementById('customerDrawerCartTotal').textContent = money(totals.subtotal);
    document.getElementById('customerDrawerCheckoutBtn').disabled = !cart.length;
}
function renderCustomerCart() {
    const cart = state.customer.cart || [];
    const totals = customerCartTotals();
    document.getElementById('customerCartRows').innerHTML = cart.length
        ? cart.map((line) => `<div class="customer-cart-item">
            <div class="customer-cart-row">
                <div>
                    <div class="customer-cart-line-title">${esc(line.name || '-')}</div>
                    <div class="muted">${esc(line.sku || '-')} | ${money(line.unit_price || 0)} each</div>
                </div>
                <button type="button" class="btn-inline danger customer-cart-remove-btn" data-product-id="${line.product_id}">Remove</button>
            </div>
            <div class="customer-cart-row">
                <div class="customer-qty-controls">
                    <button type="button" class="btn-inline secondary customer-cart-qty-btn" data-product-id="${line.product_id}" data-action="dec">-</button>
                    <input type="number" min="1" max="${Math.max(Number(line.available_stock || 0), 1)}" value="${Number(line.quantity || 0)}" class="customer-cart-qty-input" data-product-id="${line.product_id}" inputmode="numeric" aria-label="Quantity for ${esc(line.name || 'product')}">
                    <button type="button" class="btn-inline secondary customer-cart-qty-btn" data-product-id="${line.product_id}" data-action="inc">+</button>
                </div>
                <div class="customer-cart-line-price">${money((Number(line.quantity || 0) * Number(line.unit_price || 0)))}</div>
            </div>
            <div class="muted">${num(line.available_stock || 0)} units available right now</div>
        </div>`).join('')
        : `<div class="customer-empty-state"><strong>Your cart is empty.</strong><span>Browse products and add items here to start a COD or regular order.</span></div>`;
    document.getElementById('customerCartItems').textContent = num(totals.totalItems);
    document.getElementById('customerCartSubtotal').textContent = money(totals.subtotal);
    document.getElementById('customerCartGrandTotal').textContent = money(totals.subtotal);
    document.getElementById('customerCartSummaryText').textContent = `${num(totals.totalItems)} items ready`;
    document.getElementById('customerCheckoutBtn').disabled = !cart.length;
    syncCustomerCheckoutPayment();
    renderCustomerMobileCartDrawer();
    if (!cart.length) toggleCustomerCartDrawer(false);
    renderCustomerHubStats();
}
function addProductToCustomerCart(productId, quantity = 1) {
    const product = findCustomerProduct(productId);
    if (!product) {
        notice(customerNotice, 'Product details are not available right now.', 'err');
        return;
    }
    const availableStock = Number(product.current_stock || 0);
    if (availableStock <= 0) {
        notice(customerNotice, `${product.name || 'This product'} is currently out of stock.`, 'err');
        return;
    }
    const targetQty = Math.max(Number(quantity || 1), 1);
    const line = (state.customer.cart || []).find((item) => Number(item.product_id) === Number(product.id));
    if (line) {
        const nextQty = Number(line.quantity || 0) + targetQty;
        if (nextQty > availableStock) {
            notice(customerNotice, `Only ${num(availableStock)} units of ${product.name} are available right now.`, 'err');
            return;
        }
        line.quantity = nextQty;
        line.available_stock = availableStock;
        line.unit_price = Number(product.unit_price || 0);
    } else {
        state.customer.cart.push({
            product_id: Number(product.id),
            name: product.name,
            sku: product.sku,
            quantity: targetQty,
            unit_price: Number(product.unit_price || 0),
            available_stock: availableStock,
        });
    }
    renderCustomerCart();
    notice(customerNotice, `${product.name || 'Product'} added to cart.`, 'ok');
}
function setCustomerCartLineQuantity(productId, nextQuantity) {
    const line = (state.customer.cart || []).find((item) => Number(item.product_id) === Number(productId));
    if (!line) return;
    const available = Number(line.available_stock || findCustomerProduct(productId)?.current_stock || 0);
    const resolvedQuantity = Math.floor(Number(nextQuantity || 0));

    if (!Number.isFinite(resolvedQuantity) || resolvedQuantity <= 0) {
        renderCustomerCart();
        return;
    }
    if (available <= 0) {
        removeCustomerCartLine(productId);
        return;
    }
    if (resolvedQuantity > available) {
        line.quantity = available;
        renderCustomerCart();
        notice(customerNotice, `Only ${num(available)} units are available for ${line.name || 'this product'}.`, 'err');
        return;
    }
    line.quantity = resolvedQuantity;
    renderCustomerCart();
}
function updateCustomerCartLineQuantity(productId, delta) {
    const line = (state.customer.cart || []).find((item) => Number(item.product_id) === Number(productId));
    if (!line) return;
    const available = Number(line.available_stock || findCustomerProduct(productId)?.current_stock || 0);
    const nextQty = Number(line.quantity || 0) + Number(delta || 0);
    if (delta > 0 && nextQty > available) {
        notice(customerNotice, `Only ${num(available)} units are available for ${line.name || 'this product'}.`, 'err');
        return;
    }
    if (nextQty <= 0) {
        removeCustomerCartLine(productId);
        return;
    }
    line.quantity = nextQty;
    renderCustomerCart();
}
function removeCustomerCartLine(productId) {
    state.customer.cart = (state.customer.cart || []).filter((item) => Number(item.product_id) !== Number(productId));
    renderCustomerCart();
}
function synchronizeCustomerCartWithProducts() {
    const catalogMap = new Map((state.customer.products || []).map((product) => [Number(product.id), product]));
    let changed = false;
    state.customer.cart = (state.customer.cart || []).map((line) => {
        const product = catalogMap.get(Number(line.product_id));
        if (!product) return line;
        const availableStock = Number(product.current_stock || 0);
        if (availableStock <= 0) {
            changed = true;
            return null;
        }
        const nextQuantity = Math.min(Number(line.quantity || 0), availableStock);
        if (nextQuantity !== Number(line.quantity || 0)
            || Number(line.unit_price || 0) !== Number(product.unit_price || 0)
            || Number(line.available_stock || 0) !== availableStock) {
            changed = true;
        }
        return {
            ...line,
            name: product.name,
            sku: product.sku,
            image: product.image,
            quantity: nextQuantity,
            unit_price: Number(product.unit_price || 0),
            available_stock: availableStock,
        };
    }).filter(Boolean);
    if (changed) renderCustomerCart();
}
async function addOrderToCustomerCart(orderId) {
    const order = (state.customer.orders || []).find((item) => Number(item.id) === Number(orderId));
    if (!order) return;
    let added = 0;
    for (const item of (order.items || [])) {
        const productId = Number(item.product_id || item.product?.id || 0);
        if (!productId) continue;

        let product = findCustomerProduct(productId);
        if (!product) {
            try {
                product = await api(`/products/${productId}`);
            } catch (_) {
                continue;
            }
        }

        const availableStock = Number(product.current_stock || 0);
        if (availableStock <= 0) continue;

        const existing = (state.customer.cart || []).find((line) => Number(line.product_id) === productId);
        const alreadyInCart = Number(existing?.quantity || 0);
        const remaining = Math.max(availableStock - alreadyInCart, 0);
        if (remaining <= 0) continue;

        const quantityToAdd = Math.min(Number(item.quantity || 0), remaining);
        if (quantityToAdd <= 0) continue;

        if (existing) {
            existing.quantity += quantityToAdd;
            existing.available_stock = availableStock;
            existing.unit_price = Number(product.unit_price || 0);
        } else {
            state.customer.cart.push({
                product_id: productId,
                name: product.name,
                sku: product.sku,
                image: product.image,
                quantity: quantityToAdd,
                unit_price: Number(product.unit_price || 0),
                available_stock: availableStock,
            });
        }
        added += quantityToAdd;
    }
    renderCustomerCart();
    setCustomerSection('shop');
    if (added > 0) {
        notice(customerNotice, `${num(added)} item(s) added to cart from order ${order.order_number || '-'}.`, 'ok');
        focusCustomerCheckout();
    } else {
        notice(customerNotice, 'No available stock could be reordered from that order.', 'err');
    }
}
function renderOperationsOrders() {
    const rows = state.operations.orders || [];
    const statuses = ['pending', 'processing', 'completed', 'cancelled'];
    const canUpdate = canManageOrders();

    document.getElementById('opOrderRows').innerHTML = rows.length
        ? rows.map((order) => {
            const statusOptions = statuses
                .map((status) => `<option value="${status}" ${String(order.status || 'pending') === status ? 'selected' : ''}>${status}</option>`)
                .join('');
            const customer = order.customer?.name || order.customer?.email || '-';
            const payment = formatCustomerPaymentMethod(order.payment_method);

            return `<tr>
                <td>${order.order_number || '-'}</td>
                <td>${customer}</td>
                <td>${badge('role', order.status || 'pending')}</td>
                <td>${payment}</td>
                <td>${money(order.total || 0)}</td>
                <td>${dateFmt(order.placed_at || order.created_at)}</td>
                <td>
                    <div class="inline-actions">
                        <select class="op-order-status" data-order-id="${order.id}" ${canUpdate ? '' : 'disabled'}>${statusOptions}</select>
                        <button type="button" class="btn-inline secondary op-order-update-btn" data-order-id="${order.id}" ${canUpdate ? '' : 'disabled'}>Update</button>
                    </div>
                </td>
            </tr>`;
        }).join('')
        : '<tr><td colspan="9">No orders found.</td></tr>';
}
function resetPromotionForm() {
    const form = document.getElementById('promotionForm');
    if (!form) return;
    form.reset();
    state.operations.editingPromotionId = null;
    document.getElementById('promotionIdField').value = '';
    document.getElementById('promotionSubmitBtn').textContent = 'Save Promotion';
    document.getElementById('promotionCancelEditBtn').classList.add('hidden');
    const activeInput = form.querySelector('input[name="is_active"]');
    if (activeInput) activeInput.checked = true;
}
function setPromotionEditMode(promotion) {
    const form = document.getElementById('promotionForm');
    if (!form || !promotion) return;

    state.operations.editingPromotionId = Number(promotion.id);
    document.getElementById('promotionIdField').value = String(promotion.id);
    form.elements.title.value = promotion.title || '';
    form.elements.code.value = promotion.code || '';
    form.elements.discount_type.value = promotion.discount_type || 'percent';
    form.elements.discount_value.value = Number(promotion.discount_value || 0);
    form.elements.starts_at.value = dateTimeLocalValue(promotion.starts_at);
    form.elements.ends_at.value = dateTimeLocalValue(promotion.ends_at);
    form.elements.description.value = promotion.description || '';
    form.elements.is_active.checked = !!promotion.is_active;

    document.getElementById('promotionSubmitBtn').textContent = 'Update Promotion';
    document.getElementById('promotionCancelEditBtn').classList.remove('hidden');
}
function renderOperationsPromotions() {
    const rows = state.operations.promotions || [];
    const canManage = canManagePromotions();

    document.getElementById('promotionRows').innerHTML = rows.length
        ? rows.map((promotion) => {
            const discountLabel = promotion.discount_type === 'percent'
                ? `${num(promotion.discount_value || 0)}%`
                : money(promotion.discount_value || 0);
            const schedule = `${promotion.starts_at ? dateFmt(promotion.starts_at) : 'No start'} - ${promotion.ends_at ? dateFmt(promotion.ends_at) : 'No end'}`;

            return `<tr>
                <td>${promotion.title || '-'}</td>
                <td>${promotion.code || '-'}</td>
                <td>${discountLabel}</td>
                <td>${schedule}</td>
                <td>${promotion.is_active ? badge('ok', 'active') : badge('out', 'inactive')}</td>
                <td>
                    <div class="inline-actions">
                        <button type="button" class="btn-inline secondary promotion-edit-btn" data-promotion-id="${promotion.id}" ${canManage ? '' : 'disabled'}>Edit</button>
                        <button type="button" class="btn-inline danger promotion-delete-btn" data-promotion-id="${promotion.id}" ${canManage ? '' : 'disabled'}>Delete</button>
                    </div>
                </td>
            </tr>`;
        }).join('')
        : '<tr><td colspan="6">No promotions available.</td></tr>';
}
function renderStockReceiptDraft() {
    const rows = state.operations.receiptDraftItems || [];
    const total = rows.reduce((sum, row) => sum + (Number(row.quantity || 0) * Number(row.unit_cost || 0)), 0);

    document.getElementById('stockReceiptDraftRows').innerHTML = rows.length
        ? rows.map((row, index) => `<tr>
            <td>${row.product_name || '-'}</td>
            <td>${row.batch_number || '-'}</td>
            <td>${dateFmt(row.manufacturing_date)}</td>
            <td>${dateFmt(row.expiry_date)}</td>
            <td>${num(row.quantity)}</td>
            <td>${money(row.unit_cost)}</td>
            <td>${money(Number(row.quantity || 0) * Number(row.unit_cost || 0))}</td>
            <td><button type="button" class="btn-inline danger stock-receipt-remove-item-btn" data-index="${index}">Remove</button></td>
        </tr>`).join('')
        : '<tr><td colspan="8">No delivery items added.</td></tr>';

    document.getElementById('stockReceiptDraftTotal').textContent = money(total);
    document.getElementById('stockReceiptSubmitBtn').disabled = rows.length === 0;
}
function renderStockReceipts() {
    const rows = state.operations.receipts || [];
    document.getElementById('stockReceiptRows').innerHTML = rows.length
        ? rows.map((receipt) => {
            const itemCount = (receipt.items || []).reduce((sum, item) => sum + Number(item.quantity || 0), 0);
            return `<tr>
                <td>${receipt.reference_no || '-'}</td>
                <td>${receipt.supplier?.name || '-'}</td>
                <td>${receipt.received_by?.name || receipt.receivedBy?.name || '-'}</td>
                <td>${num(itemCount)}</td>
                <td>${dateFmt(receipt.received_at || receipt.created_at)}</td>
            </tr>`;
        }).join('')
        : '<tr><td colspan="5">No stock receipts recorded.</td></tr>';
}
function setBranchFormAccess() {
    const form = document.getElementById('opBranchForm');
    const hint = document.getElementById('opBranchFormHint');
    if (!form || !hint) return;

    const canManage = canManageBranches();
    Array.from(form.elements || []).forEach((element) => {
        const field = element;
        if (!field || field.name === 'branch_id') return;
        field.disabled = !canManage;
    });

    document.getElementById('opBranchSubmitBtn').disabled = !canManage;
    if (!canManage) {
        hint.textContent = 'Read-only view. Ask a manager, admin, or super admin to manage branches.';
    } else {
        hint.textContent = 'Manage multiple farm supply store branches.';
    }
}
function resetBranchForm() {
    const form = document.getElementById('opBranchForm');
    if (!form) return;
    form.reset();
    state.operations.editingBranchId = null;
    document.getElementById('opBranchIdField').value = '';
    form.elements.is_active.value = '1';
    document.getElementById('opBranchSubmitBtn').textContent = 'Save Branch';
    document.getElementById('opBranchCancelBtn').classList.add('hidden');
    setBranchFormAccess();
}
function setBranchEditMode(branch) {
    const form = document.getElementById('opBranchForm');
    if (!form || !branch) return;

    state.operations.editingBranchId = Number(branch.id || 0);
    document.getElementById('opBranchIdField').value = String(branch.id || '');
    form.elements.name.value = branch.name || '';
    form.elements.code.value = branch.code || '';
    form.elements.location.value = branch.location || '';
    form.elements.contact_person.value = branch.contact_person || '';
    form.elements.phone.value = branch.phone || '';
    form.elements.is_active.value = branch.is_active ? '1' : '0';
    document.getElementById('opBranchSubmitBtn').textContent = 'Update Branch';
    document.getElementById('opBranchCancelBtn').classList.remove('hidden');
    setBranchFormAccess();
}
function renderOperationsBranches() {
    const rows = state.operations.branches || [];
    const canManage = canManageBranches();
    document.getElementById('opBranchRows').innerHTML = rows.length
        ? rows.map((branch) => `<tr>
            <td>${branch.code || '-'}</td>
            <td>${branch.name || '-'}</td>
            <td>${branch.location || '-'}</td>
            <td>${branch.is_active ? badge('ok', 'active') : badge('out', 'inactive')}</td>
            <td>${num(branch.warehouses_count || 0)}</td>
            <td>
                <div class="inline-actions">
                    <button type="button" class="btn-inline secondary op-branch-edit-btn" data-branch-id="${branch.id}" ${canManage ? '' : 'disabled'}>Edit</button>
                    <button type="button" class="btn-inline danger op-branch-delete-btn" data-branch-id="${branch.id}" ${canManage ? '' : 'disabled'}>Delete</button>
                </div>
            </td>
        </tr>`).join('')
        : '<tr><td colspan="6">No branches found.</td></tr>';
}
function renderOperationsForecast() {
    const rows = state.operations.forecast || [];
    const filters = state.operations.forecastFilters || {};
    document.getElementById('opForecastBranchSelect').value = String(filters.branch_id || '');
    document.getElementById('opForecastForm').elements.lookback_days.value = String(filters.lookback_days || '60');
    document.getElementById('opForecastForm').elements.forecast_days.value = String(filters.forecast_days || '30');
    document.getElementById('opForecastForm').elements.limit.value = String(filters.limit || '20');
    document.getElementById('opForecastRows').innerHTML = rows.length
        ? rows.map((item) => `<tr>
            <td>${item.name || '-'}</td>
            <td>${num(item.current_stock || 0)}</td>
            <td>${num(item.predicted_demand_qty || 0)}</td>
            <td>${num(item.suggested_restock_qty || 0)}</td>
        </tr>`).join('')
        : '<tr><td colspan="4">No forecast data available.</td></tr>';
}
function renderOperationsBranchOverview() {
    const rows = state.operations.branchOverview || [];
    document.getElementById('opBranchOverviewRows').innerHTML = rows.length
        ? rows.map((item) => `<tr>
            <td>${item.name || '-'} (${item.code || '-'})</td>
            <td>${num(item.warehouses_count || 0)}</td>
            <td>${num(item.products_count || 0)}</td>
            <td>${num(item.total_units || 0)}</td>
            <td>${money(item.inventory_value || 0)}</td>
        </tr>`).join('')
        : '<tr><td colspan="5">No branch inventory overview available.</td></tr>';

    const unassigned = state.operations.unassignedWarehouses || [];
    document.getElementById('opUnassignedWarehouseList').innerHTML = unassigned.length
        ? unassigned.map((warehouse) => `<div class="list-item">${warehouse.name || '-'} (${warehouse.code || '-'})</div>`).join('')
        : '<div class="list-item">All warehouses are assigned to branches.</div>';
}
function inventoryStatusBadge(status) {
    const value = String(status || 'unknown').toLowerCase();
    const label = value.replace(/_/g, ' ');
    if (value === 'available' || value === 'healthy') return badge('ok', label);
    if (value === 'reserved' || value === 'aging' || value === 'expiring') return badge('low', label);
    return badge('out', label);
}
function inventoryHealthBadge(item) {
    return inventoryStatusBadge(item?.inventory_health || item?.status || 'unknown');
}
function inventoryBatchLabel(item) {
    return `${item.product?.name || '-'} | ${item.warehouse?.name || '-'} | ${item.batch_number || 'No batch'} | ${num(item.quantity || 0)} units`;
}
function renderOperationsInventory() {
    const filters = state.operations.inventoryFilters || {};
    const summary = state.operations.inventorySummary || {};
    const warehouseRows = state.operations.inventoryWarehouseSummary || [];
    const batchRows = state.operations.inventoryBatches || [];
    const agingRows = state.operations.inventoryAging || [];
    const agingMeta = state.operations.inventoryAgingMeta || { threshold_days: 90, average_age_days: 0, buckets: { fresh: 0, monitor: 0, aging: 0 } };

    fillSelect('inventoryWarehouseFilter', state.warehouses, (warehouse) => `${warehouse.name} (${warehouse.code})`, 'id', 'All warehouses');
    document.getElementById('inventoryWarehouseFilter').value = String(filters.warehouse_id || '');
    document.getElementById('inventoryStatusFilter').value = String(filters.status || '');
    document.getElementById('inventorySearchInput').value = filters.search || '';
    document.getElementById('inventoryAgingThresholdInput').value = String(filters.threshold_days || '90');

    const currentInventoryId = document.getElementById('inventoryStatusInventorySelect').value || '';
    fillSelect('inventoryStatusInventorySelect', batchRows, inventoryBatchLabel, 'id', 'Select inventory batch');
    if (currentInventoryId && batchRows.some((item) => String(item.id) === String(currentInventoryId))) {
        document.getElementById('inventoryStatusInventorySelect').value = currentInventoryId;
    }
    syncAdjustmentInventoryOptions();

    document.getElementById('invSummaryBatches').textContent = num(summary.total_batches || 0);
    document.getElementById('invSummaryProducts').textContent = num(summary.active_products || 0);
    document.getElementById('invSummaryUnits').textContent = num(summary.total_units || 0);
    document.getElementById('invSummaryValue').textContent = money(summary.inventory_value || 0);
    document.getElementById('invSummaryRetail').textContent = money(summary.retail_value || 0);
    document.getElementById('invSummaryLowProducts').textContent = num(summary.low_stock_products || 0);
    document.getElementById('invSummaryExpiring').textContent = num(summary.expiring_batches || 0);
    document.getElementById('invSummaryZeroStock').textContent = num(summary.zero_stock_batches || 0);

    const statusBreakdown = summary.status_breakdown || [];
    document.getElementById('inventoryStatusBreakdown').innerHTML = statusBreakdown.length
        ? statusBreakdown.map((item) => `<div class="chip"><strong>${num(item.total_batches || 0)}</strong><span>${item.status || 'unknown'} | ${num(item.total_units || 0)} units</span></div>`).join('')
        : '<div class="chip"><strong>0</strong><span>No status breakdown</span></div>';

    document.getElementById('inventoryWarehouseRows').innerHTML = warehouseRows.length
        ? warehouseRows.map((item) => `<tr>
            <td>
                <strong>${item.warehouse_name || '-'}</strong>
                <div class="inventory-subtle">${item.warehouse_code || '-'}${item.branch_name ? ` | ${item.branch_name}` : ''}${item.warehouse_location ? ` | ${item.warehouse_location}` : ''}</div>
            </td>
            <td>${num(item.total_products || 0)}</td>
            <td>${num(item.total_batches || 0)}</td>
            <td>${num(item.total_units || 0)}</td>
            <td>${num(item.available_units || 0)}</td>
            <td>${money(item.inventory_value || 0)}</td>
            <td>${num(item.expiring_batches || 0)}</td>
        </tr>`).join('')
        : '<tr><td colspan="9">No warehouse inventory summary available.</td></tr>';

    document.getElementById('inventoryBatchRows').innerHTML = batchRows.length
        ? batchRows.map((item) => `<tr>
            <td>
                <strong>${item.product?.name || '-'}</strong>
                <div class="inventory-subtle">${item.batch_number || 'No batch'}${item.product?.sku ? ` | ${item.product.sku}` : ''}</div>
            </td>
            <td>${item.warehouse?.name || '-'}</td>
            <td>${num(item.quantity || 0)}</td>
            <td>${inventoryStatusBadge(item.status || 'unknown')}</td>
            <td>${inventoryHealthBadge(item)}</td>
            <td>${item.expiry_date ? dateFmt(item.expiry_date) : '-'}</td>
            <td>${money(item.stock_value || 0)}</td>
        </tr>`).join('')
        : '<tr><td colspan="9">No inventory batches found.</td></tr>';

    document.getElementById('inventoryAgingAverage').textContent = Number(agingMeta.average_age_days || 0).toFixed(1);
    document.getElementById('inventoryAgingFresh').textContent = num(agingMeta.buckets?.fresh || 0);
    document.getElementById('inventoryAgingMonitor').textContent = num(agingMeta.buckets?.monitor || 0);
    document.getElementById('inventoryAgingFlagged').textContent = num(agingMeta.buckets?.aging || 0);

    document.getElementById('inventoryAgingRows').innerHTML = agingRows.length
        ? agingRows.map((item) => {
            const daysToExpiry = item.days_to_expiry === null || item.days_to_expiry === undefined
                ? '-'
                : (Number(item.days_to_expiry) < 0 ? `${num(Math.abs(Number(item.days_to_expiry)))} overdue` : `${num(item.days_to_expiry)} days`);
            return `<tr>
                <td>
                    <strong>${item.product?.name || '-'}</strong>
                    <div class="inventory-subtle">${item.batch_number || 'No batch'}</div>
                </td>
                <td>${num(item.age_days || 0)} days</td>
                <td>${num(agingMeta.threshold_days || filters.threshold_days || 90)} days</td>
                <td>${daysToExpiry}</td>
                <td>${item.location_in_warehouse || '-'}</td>
            </tr>`;
        }).join('')
        : '<tr><td colspan="5">No aging inventory batches found.</td></tr>';
    applyResponsiveTableLabels(document.getElementById('operationsView'));
    renderSuperAdminFeatureSummary();
}
function posWarehouseSelected() {
    return Number(document.getElementById('posWarehouseSelect').value || state.pos.warehouseId || 0);
}
function findPosProduct(productId) {
    return (state.pos.products || []).find((item) => Number(item.id) === Number(productId));
}
function getPosAvailableStock(productId) {
    return Number(findPosProduct(productId)?.available_stock || 0);
}
function reconcilePosCartWithCatalog(announce = false) {
    const removed = [];
    const adjusted = [];

    state.pos.cart = (state.pos.cart || []).filter((line) => {
        const product = findPosProduct(line.product_id);
        const availableStock = Number(product?.available_stock || 0);

        if (!product || availableStock <= 0) {
            removed.push(line.name || `Product #${line.product_id}`);
            return false;
        }

        if (Number(line.quantity || 0) > availableStock) {
            line.quantity = availableStock;
            adjusted.push(`${line.name || product.name} (${availableStock})`);
        }

        line.name = product.name || line.name;
        line.sku = product.sku || line.sku;
        line.unit_price = Number(product.unit_price || line.unit_price || 0);
        line.available_stock = availableStock;
        return true;
    });

    if (announce && (removed.length || adjusted.length)) {
        const parts = [];
        if (removed.length) parts.push(`removed: ${removed.join(', ')}`);
        if (adjusted.length) parts.push(`adjusted: ${adjusted.join(', ')}`);
        notice(posNotice, `Cart synced to live warehouse stock (${parts.join(' | ')}).`, 'err');
    }
}
function renderPosHeader() {
    const warehouseId = posWarehouseSelected();
    const warehouse = state.pos.warehouse || (state.pos.warehouses || []).find((item) => Number(item.id) === warehouseId) || null;
    const allProducts = state.pos.products || [];
    const availableUnits = allProducts.reduce((sum, item) => sum + Number(item.available_stock || 0), 0);
    const totals = posCartTotals();

    state.pos.warehouse = warehouse;
    document.getElementById('posWarehouseLabel').textContent = warehouse
        ? `${warehouse.name || '-'} (${warehouse.code || '-'})`
        : 'No warehouse selected';

    const warehouseMeta = [warehouse?.branch?.name, warehouse?.location].filter(Boolean).join(' | ');
    document.getElementById('posWarehouseStatus').textContent = warehouse
        ? `Live stock source${warehouseMeta ? ` | ${warehouseMeta}` : ''}`
        : 'Choose a warehouse to load the live catalog.';

    document.getElementById('posCatalogCount').textContent = num(allProducts.length);
    document.getElementById('posAvailableCount').textContent = num(availableUnits);
    document.getElementById('posHeaderCartItems').textContent = num(totals.itemsTotal || 0);
    document.getElementById('posHeaderTotal').textContent = money(totals.grandTotal || 0);
    renderSuperAdminFeatureSummary();
    renderStaffHome();
}
function getPosCatalogProducts() {
    const term = (state.pos.search || '').trim().toLowerCase();
    return (state.pos.products || [])
        .filter((p) => {
            if (!p || p.is_active === false) return false;
            if (!term) return true;
            const haystacks = [p.name, p.sku, p.category_name].map((value) => String(value || '').toLowerCase());
            return haystacks.some((value) => value.includes(term));
        })
        .sort((left, right) => {
            const stockDiff = Number(right.available_stock || 0) - Number(left.available_stock || 0);
            if (stockDiff !== 0) return stockDiff;
            return String(left.name || '').localeCompare(String(right.name || ''));
        });
}
function renderPosCatalog() {
    const warehouseId = posWarehouseSelected();
    const rows = getPosCatalogProducts();
    document.getElementById('posSearchInput').value = state.pos.search || '';

    renderPosHeader();

    const catalogStatus = document.getElementById('posCatalogStatus');
    if (catalogStatus) {
        catalogStatus.textContent = !warehouseId
            ? 'Select a warehouse to load the live POS catalog.'
            : `${num(rows.length)} item(s) ready for ${state.pos.warehouse?.name || 'the selected warehouse'}.`;
    }

    document.getElementById('posProductRows').innerHTML = !warehouseId
        ? `<div class="pos-cart-empty"><strong>Select a warehouse first.</strong><span>Once a warehouse is selected, the live POS catalog will appear here.</span></div>`
        : rows.length
            ? rows.map((product) => {
                const stock = Number(product.available_stock || 0);
                const reorderPoint = Number(product.reorder_point || 0);
                const disabled = stock <= 0 ? 'disabled' : '';
                const expiryLabel = product.nearest_expiry_date ? dateFmt(product.nearest_expiry_date) : 'No expiry';
                const batchCount = Number(product.batch_count || 0);
                const stockBadge = stock <= 0
                    ? badge('out', 'Out')
                    : (stock <= reorderPoint ? badge('low', 'Low') : badge('ok', 'Ready'));

                return `<article class="pos-product-card" data-product-id="${product.id}">
                    <div class="pos-product-top">
                        <div class="pos-product-cell">
                            <strong>${esc(product.name || '-')}</strong>
                            <span class="pos-product-meta">${esc(product.sku || '-')}${product.unit_of_measure ? ` | ${esc(product.unit_of_measure)}` : ''}</span>
                        </div>
                        ${stockBadge}
                    </div>
                    <div class="pos-meta-grid">
                        <div class="pos-meta-card">
                            <span>Price</span>
                            <strong>${money(product.unit_price || 0)}</strong>
                        </div>
                        <div class="pos-meta-card">
                            <span>Available</span>
                            <strong>${num(stock)} unit(s)</strong>
                        </div>
                        <div class="pos-meta-card">
                            <span>Reorder point</span>
                            <strong>${num(reorderPoint)}</strong>
                        </div>
                        <div class="pos-meta-card">
                            <span>Batch / expiry</span>
                            <strong>${num(batchCount)} batch${batchCount === 1 ? '' : 'es'}</strong>
                            <small class="pos-product-meta">${expiryLabel}</small>
                        </div>
                    </div>
                    <div class="pos-card-actions">
                        <div class="pos-qty-field">
                            <label for="posCatalogQty${product.id}">Qty</label>
                            <input id="posCatalogQty${product.id}" class="pos-catalog-qty" data-product-id="${product.id}" type="number" min="1" max="${Math.max(stock, 1)}" value="1" ${disabled}>
                        </div>
                        <button type="button" class="pos-add-btn" data-product-id="${product.id}" ${disabled}>Add to Sale</button>
                    </div>
                </article>`;
            }).join('')
            : `<div class="pos-cart-empty"><strong>No products found.</strong><span>Try another search or choose a different warehouse.</span></div>`;

    applyResponsiveTableLabels(document.getElementById('posView'));
}
function posCartTotals() {
    const subtotal = state.pos.cart.reduce((sum, line) => sum + (Number(line.quantity || 0) * Number(line.unit_price || 0)), 0);
    const discountType = String(document.getElementById('posDiscountType').value || 'none').toLowerCase();
    const isGovDiscount = discountType === 'senior' || discountType === 'pwd';
    const rawDiscount = isGovDiscount
        ? roundCurrency(subtotal * 0.20)
        : Number(document.getElementById('posDiscountInput').value || 0);
    const discount = Math.min(Math.max(rawDiscount, 0), subtotal);
    const grandTotal = Math.max(subtotal - discount, 0);
    const itemsTotal = state.pos.cart.reduce((sum, line) => sum + Number(line.quantity || 0), 0);
    const paymentMethod = String(document.getElementById('posPaymentMethod').value || 'cash').toLowerCase();
    const cashReceived = Math.max(Number(document.getElementById('posCashReceivedInput').value || 0), 0);
    const amountTendered = paymentMethod === 'cash' ? cashReceived : grandTotal;
    const balanceDue = paymentMethod === 'cash' ? Math.max(grandTotal - cashReceived, 0) : 0;
    const change = paymentMethod === 'cash' ? Math.max(cashReceived - grandTotal, 0) : 0;

    return { subtotal, discount, grandTotal, itemsTotal, cashReceived, amountTendered, balanceDue, change, discountType, paymentMethod };
}
function renderPosCart() {
    const rows = state.pos.cart || [];
    const stockConflicts = rows.some((line) => Number(line.quantity || 0) > getPosAvailableStock(line.product_id));

    document.getElementById('posCartRows').innerHTML = rows.length
        ? rows.map((line) => {
            const product = findPosProduct(line.product_id);
            const availableStock = Number(product?.available_stock || line.available_stock || 0);
            line.available_stock = availableStock;
            line.name = product?.name || line.name;
            line.sku = product?.sku || line.sku;
            line.unit_price = Number(product?.unit_price || line.unit_price || 0);
            return `<div class="pos-cart-line">
                <div class="pos-cart-line-main">
                    <strong>${esc(line.name || '-')}</strong>
                    <span class="pos-cart-line-note">
                        <span>${esc(line.sku || '-')}</span>
                        <span>${money(line.unit_price || 0)} each</span>
                        <span>${num(availableStock)} available</span>
                    </span>
                </div>
                <div class="pos-cart-line-actions">
                    <div class="pos-cart-qty">
                        <label for="posQty${line.product_id}">Quantity</label>
                        <input id="posQty${line.product_id}" class="pos-qty-input" data-product-id="${line.product_id}" type="number" min="1" max="${Math.max(availableStock, 1)}" value="${num(line.quantity || 0)}">
                    </div>
                    <div class="pos-line-total">
                        <span>Line total</span>
                        <strong>${money(Number(line.quantity || 0) * Number(line.unit_price || 0))}</strong>
                    </div>
                    <button type="button" class="btn-inline danger pos-remove-btn" data-product-id="${line.product_id}">Remove</button>
                </div>
            </div>`;
        }).join('')
        : `<div class="pos-cart-empty"><strong>No items in the sale yet.</strong><span>Add products from the live catalog to begin checkout.</span></div>`;

    syncPosDiscountFields();
    const totals = posCartTotals();
    document.getElementById('posItemsTotal').textContent = num(totals.itemsTotal);
    document.getElementById('posSubtotal').textContent = money(totals.subtotal);
    document.getElementById('posDiscountAmount').textContent = money(totals.discount);
    document.getElementById('posGrandTotal').textContent = money(totals.grandTotal);
    document.getElementById('posAmountTendered').textContent = money(totals.amountTendered);
    document.getElementById('posBalanceDue').textContent = money(totals.balanceDue);
    document.getElementById('posChange').textContent = money(totals.change);
    const checkoutBtn = document.getElementById('posCheckoutBtn');
    const cashNeedsMore = totals.paymentMethod === 'cash' && totals.balanceDue > 0;
    const paymentStatusEl = document.getElementById('posPaymentStatus');
    checkoutBtn.disabled = rows.length === 0 || cashNeedsMore || stockConflicts;
    checkoutBtn.title = cashNeedsMore
        ? `Add ${money(totals.balanceDue)} more cash to continue.`
        : (stockConflicts ? 'Adjust cart quantity to match available warehouse stock.' : '');
    if (paymentStatusEl) {
        if (!rows.length) {
            paymentStatusEl.textContent = 'No items';
        } else if (stockConflicts) {
            paymentStatusEl.textContent = 'Check stock';
        } else if (cashNeedsMore) {
            paymentStatusEl.textContent = `Need ${money(totals.balanceDue)} more`;
        } else if (totals.paymentMethod === 'gcash') {
            paymentStatusEl.textContent = 'Ready (GCash)';
        } else {
            paymentStatusEl.textContent = 'Ready (Cash)';
        }
    }
    renderPosHeader();
    applyResponsiveTableLabels(document.getElementById('posView'));
}
function renderPosSales() {
    const rows = state.pos.sales || [];
    document.getElementById('posSalesRows').innerHTML = rows.length
        ? rows.map((sale) => `<tr>
            <td>${sale.sale_number}</td>
            <td>${sale.cashier_name || '-'}</td>
            <td>${num(sale.total_items)}</td>
            <td>${money(sale.total_amount)}</td>
            <td>${String(sale.payment_method || '-').toUpperCase()}</td>
            <td>${sale.gcash_reference_number || '-'}</td>
            <td>${dateFmt(sale.sold_at)}</td>
        </tr>`).join('')
        : '<tr><td colspan="7">No recent POS sales.</td></tr>';
    applyResponsiveTableLabels(document.getElementById('posView'));
}
function syncPosReceiptPrintButton() {
    const button = document.getElementById('posPrintReceiptBtn');
    if (!button) return;
    button.disabled = !state.pos.lastSale;
}
function renderPosLastSale() {
    const host = document.getElementById('posSuccessCard');
    if (!host) return;

    const sale = state.pos.lastSale;
    if (!sale) {
        host.className = 'pos-success-card pos-success-empty';
        host.innerHTML = '<strong>No completed sale yet.</strong><span>Finish a checkout to show the receipt summary here.</span>';
        return;
    }

    const lines = Array.isArray(sale.lines) ? sale.lines.slice(0, 4) : [];
    const customerLabel = sale.customer_name ? esc(sale.customer_name) : 'Walk-in customer';
    const paymentLabel = String(sale.payment_method || 'cash').toUpperCase();
    const extraBits = [];
    if (Number(sale.discount || 0) > 0) extraBits.push(`Discount ${money(sale.discount || 0)}`);
    if (sale.gcash_reference_number) extraBits.push(`Ref ${esc(sale.gcash_reference_number)}`);

    host.className = 'pos-success-card';
    host.innerHTML = `
        <div class="pos-success-header">
            <div class="pos-success-copy">
                <strong>Sale ${esc(sale.sale_number || '-')} completed</strong>
                <span>${customerLabel} | ${paymentLabel}</span>
                <small>${extraBits.length ? extraBits.join(' | ') : 'Payment received.'}</small>
            </div>
            ${badge('ok', 'Paid')}
        </div>
        <div class="pos-success-metrics">
            <div class="chip"><strong>${num(sale.total_items || 0)}</strong><span>Items sold</span></div>
            <div class="chip"><strong>${money(sale.total_amount || sale.total || 0)}</strong><span>Total paid</span></div>
            <div class="chip"><strong>${money(sale.change_due || 0)}</strong><span>Change</span></div>
        </div>
        <div class="pos-success-lines">
            ${lines.length
                ? lines.map((line) => `<div class="pos-success-line"><div><strong>${esc(line.product_name || '-')}</strong><span>${num(line.quantity || 0)} x ${money(line.unit_price || 0)}</span></div><small>${money(line.line_total || 0)}</small></div>`).join('')
                : '<div class="pos-success-line"><div><strong>Sale saved</strong><span>No line preview available.</span></div><small>Done</small></div>'}
        </div>`;
}
function applyPosSaleToCatalog(sale) {
    const lines = Array.isArray(sale?.lines) ? sale.lines : [];
    if (!lines.length) return;

    lines.forEach((line) => {
        const product = findPosProduct(line.product_id);
        if (!product) return;

        const soldQty = Number(line.quantity || 0);
        const nextAvailable = Math.max(Number(product.available_stock || 0) - soldQty, 0);
        const nextTotal = Math.max(Number(product.total_stock || product.available_stock || 0) - soldQty, 0);
        product.available_stock = nextAvailable;
        product.total_stock = nextTotal;
        product.stock_status = nextAvailable <= 0
            ? 'out_of_stock'
            : (nextAvailable <= Number(product.reorder_point || 0) ? 'low_stock' : 'in_stock');
    });
}
function prependPosRecentSale(sale) {
    if (!sale) return;

    state.pos.sales = [{
        sale_number: sale.sale_number || '-',
        cashier_name: state.user?.name || 'Cashier',
        total_items: Number(sale.total_items || 0),
        total_amount: Number(sale.total_amount || sale.total || 0),
        payment_method: sale.payment_method || 'cash',
        gcash_reference_number: sale.gcash_reference_number || null,
        sold_at: new Date().toISOString(),
    }, ...(state.pos.sales || [])].slice(0, 8);
    renderPosSales();
}
function addProductToPosCart(productId, requestedQuantity = 1) {
    const product = findPosProduct(productId);
    if (!product) return;

    const availableStock = Number(product.available_stock || 0);
    if (availableStock <= 0) {
        notice(posNotice, `${product.name || 'This product'} is out of stock in the selected warehouse.`, 'err');
        return;
    }

    const desiredQuantity = Math.max(parseInt(requestedQuantity, 10) || 1, 1);
    const line = state.pos.cart.find((item) => Number(item.product_id) === Number(product.id));
    const currentQuantity = Number(line?.quantity || 0);
    const nextQuantity = Math.min(currentQuantity + desiredQuantity, availableStock);
    const addedQuantity = nextQuantity - currentQuantity;

    if (addedQuantity <= 0) {
        notice(posNotice, `Only ${num(availableStock)} units of ${product.name} are available in this warehouse.`, 'err');
        return;
    }

    if (line) {
        line.quantity = nextQuantity;
        line.available_stock = availableStock;
        line.unit_price = Number(product.unit_price || line.unit_price || 0);
    } else {
        state.pos.cart.push({
            product_id: Number(product.id),
            name: product.name,
            sku: product.sku,
            quantity: nextQuantity,
            unit_price: Number(product.unit_price || 0),
            available_stock: availableStock,
        });
    }

    renderPosCart();

    const qtyInput = document.querySelector(`.pos-catalog-qty[data-product-id="${product.id}"]`);
    if (qtyInput) qtyInput.value = '1';

    if (addedQuantity < desiredQuantity) {
        notice(posNotice, `Only ${num(availableStock)} units of ${product.name} are available. Cart set to ${num(nextQuantity)}.`, 'err');
        return;
    }

    notice(posNotice, `${num(addedQuantity)} unit(s) of ${product.name} added to the sale.`, 'ok');
}
function setPosLineQuantity(productId, nextQuantity, announce = true) {
    const line = state.pos.cart.find((item) => Number(item.product_id) === Number(productId));
    if (!line) return;

    const availableStock = getPosAvailableStock(productId);
    let resolvedQuantity = parseInt(nextQuantity, 10);
    if (!Number.isFinite(resolvedQuantity)) {
        resolvedQuantity = Number(line.quantity || 1);
    }

    if (resolvedQuantity <= 0) {
        removePosLine(productId);
        if (announce) notice(posNotice, `${line.name || 'Item'} removed from the sale.`, 'ok');
        return;
    }

    if (resolvedQuantity > availableStock) {
        resolvedQuantity = availableStock;
        if (announce) {
            notice(posNotice, `Only ${num(availableStock)} units are available for ${line.name}.`, 'err');
        }
    }

    line.quantity = resolvedQuantity;
    line.available_stock = availableStock;
    renderPosCart();
}
function updatePosLineQuantity(productId, delta) {
    const line = state.pos.cart.find((item) => Number(item.product_id) === Number(productId));
    if (!line) return;
    setPosLineQuantity(productId, Number(line.quantity || 1) + Number(delta || 0));
}
function removePosLine(productId) {
    state.pos.cart = state.pos.cart.filter((item) => Number(item.product_id) !== Number(productId));
    renderPosCart();
}
function roundCurrency(value) {
    return Math.round(Number(value || 0) * 100) / 100;
}
function syncPosDiscountFields() {
    const discountType = String(document.getElementById('posDiscountType').value || 'none').toLowerCase();
    const discountInput = document.getElementById('posDiscountInput');
    const discountIdNumberWrap = document.getElementById('posDiscountIdNumberWrap');
    const discountIdNumberInput = document.getElementById('posDiscountIdNumberInput');
    const discountIdImageWrap = document.getElementById('posDiscountIdImageWrap');
    const discountIdImageInput = document.getElementById('posDiscountIdImageInput');
    const subtotal = state.pos.cart.reduce((sum, line) => sum + (Number(line.quantity || 0) * Number(line.unit_price || 0)), 0);
    const autoDiscount = discountType === 'senior' || discountType === 'pwd';
    const wasAuto = discountInput.dataset.autoDiscount === '1';

    discountInput.disabled = autoDiscount;
    discountInput.dataset.autoDiscount = autoDiscount ? '1' : '0';
    discountIdNumberWrap.classList.toggle('hidden', !autoDiscount);
    discountIdNumberInput.disabled = !autoDiscount;
    discountIdNumberInput.required = autoDiscount;
    discountIdImageWrap.classList.toggle('hidden', !autoDiscount);
    discountIdImageInput.disabled = !autoDiscount;
    discountIdImageInput.required = autoDiscount;

    if (autoDiscount) {
        discountInput.value = roundCurrency(subtotal * 0.20).toFixed(2);
        discountInput.placeholder = `${discountType.toUpperCase()} discount (20%)`;
        return;
    }

    discountInput.placeholder = 'Discount (PHP)';
    if (wasAuto) {
        discountInput.value = '0';
        discountIdNumberInput.value = '';
        discountIdImageInput.value = '';
    }
}
function syncPosPaymentFields() {
    const method = document.getElementById('posPaymentMethod').value || 'cash';
    const cashWrap = document.getElementById('posCashReceivedWrap');
    const cashInput = document.getElementById('posCashReceivedInput');
    const gcashReferenceWrap = document.getElementById('posGcashReferenceWrap');
    const gcashReferenceInput = document.getElementById('posGcashReferenceInput');
    const gcashReceiptWrap = document.getElementById('posGcashReceiptWrap');
    const gcashReceiptInput = document.getElementById('posGcashReceiptInput');
    const cashMode = method === 'cash';
    const gcashMode = method === 'gcash';

    cashWrap.classList.toggle('hidden', !cashMode);
    cashInput.disabled = !cashMode;
    cashInput.required = cashMode;
    if (!cashMode) {
        cashInput.value = '';
    }

    gcashReferenceWrap.classList.toggle('hidden', !gcashMode);
    gcashReferenceInput.disabled = !gcashMode;
    gcashReferenceInput.required = gcashMode;
    if (!gcashMode) {
        gcashReferenceInput.value = '';
    }

    gcashReceiptWrap.classList.toggle('hidden', !gcashMode);
    gcashReceiptInput.disabled = !gcashMode;
    gcashReceiptInput.required = gcashMode;
    if (!gcashMode) {
        gcashReceiptInput.value = '';
    }

    renderPosCart();
}
function applyPosCashQuickAmount(button) {
    const cashInput = document.getElementById('posCashReceivedInput');
    if (!cashInput || cashInput.disabled) return;

    const totals = posCartTotals();
    if (String(button.dataset.mode || '').toLowerCase() === 'exact') {
        cashInput.value = roundCurrency(totals.grandTotal).toFixed(2);
        renderPosCart();
        return;
    }

    const addValue = Number(button.dataset.add || 0);
    const current = Number(cashInput.value || 0);
    const nextValue = Math.max(roundCurrency(current + addValue), 0);
    cashInput.value = nextValue.toFixed(2);
    renderPosCart();
}

function fillSuperAdminUserOptions(users) {
    const list = users || [];

    fillSelect('saResetUserId', list, (u) => `${u.name} (${u.role})`, 'id', 'Select user');
    fillSelect('saRevokeUserId', list, (u) => `${u.name} (${u.role})`, 'id', 'Select user');
    fillSelect('saLoginUserId', list, (u) => `${u.name} (${u.role})`, 'id', 'All users');
    fillSelect('saAuditUserId', list, (u) => `${u.name} (${u.role})`, 'id', 'All users');
    fillSelect('saStatusUserId', list, (u) => `${u.name} (${u.role})`, 'id', 'Select user');
    fillSelect('saPermissionUserId', list, (u) => `${u.name} (${u.role})`, 'id', 'Select user');

    const bulk = document.getElementById('saBulkUsers');
    if (!bulk) return;
    bulk.innerHTML = list.map((u) => `<option value="${u.id}">${u.name} (${u.role}) - ${u.email}</option>`).join('');
}
function renderRoleDistribution(data) {
    const items = data?.items || [];
    document.getElementById('saRoleRows').innerHTML = items.length
        ? items.map((i) => `<tr><td>${i.role}</td><td>${num(i.total)}</td><td>${i.percentage}%</td></tr>`).join('')
        : '<tr><td colspan="3">No role data.</td></tr>';

    document.getElementById('roleChips').innerHTML = items.length
        ? items.map((i) => `<div class="chip"><strong>${num(i.total)}</strong><span>${i.role}</span></div>`).join('')
        : '<div class="chip"><strong>0</strong><span>No role data</span></div>';
}

function renderSuperActivity(data) {
    const items = data?.items || [];
    document.getElementById('saActivityRows').innerHTML = items.length
        ? items.map((r) => `<tr><td>${r.name}</td><td>${badge('role', r.role)}</td><td>${num(r.transaction_count)}</td><td>${num(r.total_quantity)}</td><td>${money(r.total_amount)}</td><td>${dateFmt(r.last_activity_at)}</td></tr>`).join('')
        : '<tr><td colspan="6">No activity data.</td></tr>';
}

function renderStaleAccounts(data) {
    const items = data?.items || [];
    document.getElementById('saStaleRows').innerHTML = items.length
        ? items.map((r) => `<tr><td>${r.name}</td><td>${badge('role', r.role)}</td><td>${r.email}</td><td>${dateFmt(r.last_activity_at)}</td><td>${num(r.total_transactions)}</td></tr>`).join('')
        : '<tr><td colspan="5">No stale accounts detected.</td></tr>';
}

function renderSecurityReport(data) {
    if (!data) {
        document.getElementById('saSecurityList').innerHTML = '<div class="list-item">No security data.</div>';
        return;
    }

    const rows = [
        `Active API tokens: ${num(data.active_tokens)}`,
        `Users without tokens: ${num(data.users_without_tokens)}`,
        `Users with 5+ tokens: ${num(data.users_with_5plus_tokens)}`,
        `New users in 7 days: ${num(data.new_users_7_days)}`,
        `Transactions without user: ${num(data.transactions_without_user)}`,
    ];

    const topUsers = (data.top_token_users || [])
        .slice(0, 5)
        .map((u) => `${u.name} (${u.role}) - ${u.tokens_count} tokens`);

    document.getElementById('saSecurityList').innerHTML = [
        ...rows.map((r) => `<div class="list-item">${r}</div>`),
        ...(topUsers.length ? [`<div class="list-item"><strong>Top token users:</strong><br>${topUsers.join('<br>')}</div>`] : []),
    ].join('');
}

function renderSuperOverview(data) {
    if (!data) return;
    document.getElementById('saTotalUsers').textContent = num(data.users_total);
    document.getElementById('saSuperAdmins').textContent = num(data.super_admins);
    document.getElementById('saTokens').textContent = num(data.active_tokens);
    document.getElementById('saTxToday').textContent = num(data.transactions_today);
    document.getElementById('saTxMonth').textContent = num(data.transactions_month);
    document.getElementById('saNewUsers').textContent = num(data.new_users_30_days);
    renderSuperAdminFeatureSummary();
}
function renderSuperAdminFeatureSummary() {
    const setValue = (id, value) => {
        const element = document.getElementById(id);
        if (element) element.textContent = value;
    };
    const categories = state.categories || [];
    const suppliers = state.suppliers || [];
    const warehouses = state.warehouses || [];
    const branches = state.operations?.branches || [];
    const products = state.products || [];
    const inventorySummary = state.operations?.inventorySummary || {};
    const kpis = state.dashboard?.kpis || {};
    const overview = state.superAdmin?.overview || {};
    const users = state.users || [];
    const activeProducts = Number(kpis.active_products ?? products.filter((item) => item.is_active !== false).length);
    const totalProducts = Number(kpis.total_products ?? products.length);
    const lowStock = Number(kpis.low_stock_products ?? inventorySummary.low_stock_products ?? 0);
    const totalBatches = Number(inventorySummary.total_batches ?? 0);
    const inventoryValue = Number(inventorySummary.inventory_value ?? kpis.inventory_value ?? 0);
    const setupCount = categories.length + suppliers.length + warehouses.length + branches.length;
    const totalUsers = Number(overview.users_total ?? users.length);

    setValue('saOverviewSetupCount', num(setupCount));
    setValue('saOverviewProductsCount', num(totalProducts));
    setValue('saOverviewInventoryCount', num(totalBatches));
    setValue('saOverviewLowCount', num(lowStock));
    setValue('saSetupCategoriesCount', num(categories.length));
    setValue('saSetupSuppliersCount', num(suppliers.length));
    setValue('saSetupWarehousesCount', num(warehouses.length));
    setValue('saSetupBranchesCount', num(branches.length));
    setValue('saProductsTotalCount', num(totalProducts));
    setValue('saProductsActiveCount', num(activeProducts));
    setValue('saProductsCategoryCount', num(categories.length));
    setValue('saStockWarehousesCount', num(warehouses.length));
    setValue('saStockMovementCount', num(totalProducts));
    setValue('saStockAdjustmentsCount', num(lowStock));
    setValue('saStockSuppliersCount', num(suppliers.length));
    setValue('saInventoryBatchesCount', num(totalBatches));
    setValue('saInventoryProductsCount', num(activeProducts));
    setValue('saInventoryValueCount', money(inventoryValue));
    setValue('saUsersTotalCount', num(totalUsers));
}
function renderSuperLoginActivities(data) {
    const rows = data?.data || [];
    document.getElementById('saLoginRows').innerHTML = rows.length
        ? rows.map((item) => `<tr>
            <td>${item.user?.name || '-'}</td>
            <td>${item.email || item.user?.email || '-'}</td>
            <td>${badge('role', item.action || '-')}</td>
            <td>${item.ip_address || '-'}</td>
            <td>${dateFmt(item.created_at)}</td>
        </tr>`).join('')
        : '<tr><td colspan="5">No login activities found.</td></tr>';
}
function renderSuperAuditLogs(data) {
    const rows = data?.data || [];
    document.getElementById('saAuditRows').innerHTML = rows.length
        ? rows.map((item) => `<tr>
            <td>${item.action || '-'}</td>
            <td>${item.entity_type || '-'} #${item.entity_id || '-'}</td>
            <td>${item.user?.name || '-'}</td>
            <td>${dateFmt(item.created_at)}</td>
        </tr>`).join('')
        : '<tr><td colspan="4">No audit logs found.</td></tr>';
}
function settingValue(value) {
    if (value === null || value === undefined || value === '') return '-';
    if (typeof value === 'object') {
        return JSON.stringify(value);
    }
    return String(value);
}
function renderSuperSystemSettings(data) {
    const rows = data?.items || [];
    document.getElementById('saSettingRows').innerHTML = rows.length
        ? rows.map((item) => `<tr>
            <td>${item.key || '-'}</td>
            <td>${settingValue(item.value)}</td>
            <td>${item.description || '-'}</td>
            <td>${item.updated_by?.name || item.updatedBy?.name || '-'}</td>
            <td>${dateFmt(item.updated_at)}</td>
        </tr>`).join('')
        : '<tr><td colspan="5">No system settings found.</td></tr>';
}

async function loadRefs() {
    const [categories, suppliers, warehouses, products, branches] = await Promise.all([
        api('/categories'),
        api('/suppliers'),
        api('/warehouses'),
        api('/products?per_page=100&sort_by=name&sort_dir=asc'),
        api('/branches?per_page=200'),
    ]);
    state.categories = categories || [];
    state.suppliers = suppliers?.data || [];
    state.warehouses = warehouses?.data || [];
    state.products = products?.products?.data || [];
    state.operations.branches = branches?.data || [];
    fillSelect('categorySelect', state.categories, (c) => c.name);
    fillSelect('supplierSelect', state.suppliers, (s) => s.name, 'id', 'No supplier');
    fillSelect('txWarehouseSelect', state.warehouses, (w) => `${w.name} (${w.code})`);
    fillSelect('adjustWarehouseSelect', state.warehouses, (w) => `${w.name} (${w.code})`);
    refreshOperationsProductUi();
    renderAdjustmentDraft();
    fillSelect('inventoryWarehouseFilter', state.warehouses, (w) => `${w.name} (${w.code})`, 'id', 'All warehouses');
    fillSelect('receiptSupplierSelect', state.suppliers, (s) => s.name, 'id', 'Select supplier');
    fillSelect('receiptWarehouseSelect', state.warehouses, (w) => `${w.name} (${w.code})`, 'id', 'Select warehouse');
    fillSelect('receiptProductSelect', state.products, (p) => `${p.name} (${p.sku})`, 'id', 'Select product');
    renderOperationsProducts();
    const editingProduct = findProductById(state.operations.editingProductId);
    if (editingProduct) {
        setProductEditMode(editingProduct);
    } else {
        resetProductForm();
    }
    fillBranchSelects(state.operations.branches);
    renderOperationsBranches();
    renderOperationsForecast();
    renderOperationsInventory();
}
async function loadPosCatalogData() {
    if (!canUsePos()) return;

    const warehouseId = posWarehouseSelected();
    if (!warehouseId) {
        state.pos.products = [];
        state.pos.warehouse = null;
        renderPosCatalog();
        renderPosCart();
        return;
    }

    const params = new URLSearchParams({ warehouse_id: String(warehouseId) });
    const response = await api(`/pos/catalog?${params.toString()}`);
    state.pos.products = response?.items || [];
    state.pos.warehouse = response?.warehouse || (state.pos.warehouses || []).find((item) => Number(item.id) === warehouseId) || null;
    state.pos.warehouseId = String(warehouseId);
    reconcilePosCartWithCatalog(true);
    renderPosCatalog();
    renderPosCart();
}
async function loadPosRefs() {
    if (!canUsePos()) return;

    const previousPosWarehouse = document.getElementById('posWarehouseSelect').value || state.pos.warehouseId || '';
    const warehouses = await api('/pos/warehouses');

    state.pos.warehouses = warehouses?.items || [];

    fillSelect(
        'posWarehouseSelect',
        state.pos.warehouses,
        (w) => `${w.name} (${w.code})${w.branch?.name ? ` - ${w.branch.name}` : ''}${w.is_active === false ? ' [Inactive]' : ''}`,
        'id',
        'Select warehouse'
    );

    let nextWarehouse = previousPosWarehouse;
    if (!nextWarehouse && state.pos.warehouses.length) {
        nextWarehouse = String(state.pos.warehouses[0].id || '');
    }

    if (nextWarehouse && state.pos.warehouses.some((w) => String(w.id) === String(nextWarehouse))) {
        document.getElementById('posWarehouseSelect').value = nextWarehouse;
    } else {
        document.getElementById('posWarehouseSelect').value = '';
    }

    state.pos.warehouseId = document.getElementById('posWarehouseSelect').value || '';
    await loadPosCatalogData();
    syncPosReceiptPrintButton();
}
async function loadDashboard() {
    const lowStockPromise = state.permissions.view_reports
        ? api('/reports/low-stock')
        : Promise.resolve({ items: [] });
    const [stats, low] = await Promise.all([api('/dashboard/stats'), lowStockPromise]);
    state.dashboard = { ...stats, lowStockItems: low?.items || [] };
    renderDashboard();
}
async function loadReports() {
    if (!state.permissions.view_reports) {
        renderMovement({ summary: [] });
        renderExpiring({ items: [] });
        renderBusinessReports({ daily_sales: [], top_selling_products: [], low_stock_report: [], inventory_status: {}, totals: { inventory_value: 0 } });
        return;
    }

    const [move, exp, business] = await Promise.all([
        api('/reports/movement-summary'),
        api('/reports/expiring-stock?days=45'),
        api('/reports/business-overview?limit=12'),
    ]);
    state.reports.business = business || null;
    renderMovement(move);
    renderExpiring(exp);
    renderBusinessReports(business);
}
async function loadUsers(filters = null) {
    if (!state.permissions.manage_users) return;

    if (filters) {
        state.userFilters = {
            ...state.userFilters,
            ...filters,
        };
    }
    document.getElementById('userSearchInput').value = state.userFilters.search || '';
    document.getElementById('userRoleFilter').value = state.userFilters.role || '';

    const params = new URLSearchParams({ per_page: '200' });

    const search = (state.userFilters.search || '').trim();
    const role = state.userFilters.role || '';

    if (search) params.set('search', search);
    if (role) params.set('role', role);

    const users = await api(`/users?${params.toString()}`);
    state.users = users?.data || [];
    renderUsers(users);
    if (isSuperAdmin()) fillSuperAdminUserOptions(state.users);
}
async function loadCustomerProducts(filters = null) {
    if (!isCustomer()) return;

    if (filters) {
        state.customer.filters = {
            ...state.customer.filters,
            ...filters,
        };
    }

    const search = (state.customer.filters.search || '').trim();
    const stockStatus = state.customer.filters.stock_status || '';
    const sort = state.customer.filters.sort || 'name_asc';

    document.getElementById('customerSearchInput').value = search;
    document.getElementById('customerStockFilter').value = stockStatus;
    document.getElementById('customerSortFilter').value = sort;

    const params = new URLSearchParams({
        per_page: '100',
        is_active: '1',
    });

    if (search) params.set('search', search);
    if (stockStatus) params.set('stock_status', stockStatus);

    switch (sort) {
        case 'price_asc':
            params.set('sort_by', 'unit_price');
            params.set('sort_dir', 'asc');
            break;
        case 'price_desc':
            params.set('sort_by', 'unit_price');
            params.set('sort_dir', 'desc');
            break;
        case 'stock_desc':
            params.set('sort_by', 'current_stock');
            params.set('sort_dir', 'desc');
            break;
        case 'latest':
            params.set('sort_by', 'created_at');
            params.set('sort_dir', 'desc');
            break;
        default:
            params.set('sort_by', 'name');
            params.set('sort_dir', 'asc');
            break;
    }

    const response = await api(`/products?${params.toString()}`);
    state.customer.products = response?.products?.data || [];
    synchronizeCustomerCartWithProducts();
    renderCustomerProducts();

    if (!state.customer.products.length) {
        state.customer.selectedProductId = null;
        state.customer.selectedProductDetail = null;
        state.customer.selectedProductReviews = [];
        state.customer.selectedProductRating = 0;
        renderCustomerSelectedProduct();
        renderCustomerCart();
        return;
    }

    const currentId = Number(state.customer.selectedProductId || 0);
    const currentVisible = state.customer.products.some((item) => Number(item.id) === currentId);
    const nextId = currentVisible ? currentId : Number(state.customer.products[0].id || 0);

    if (!nextId) {
        renderCustomerSelectedProduct();
        return;
    }

    if (!state.customer.selectedProductDetail || Number(state.customer.selectedProductId || 0) !== nextId || !currentVisible) {
        await loadCustomerProductDetail(nextId);
    } else {
        renderCustomerSelectedProduct();
    }
    renderCustomerCart();
}
async function loadCustomerProductDetail(productId) {
    if (!isCustomer()) return;

    const targetId = Number(productId || 0);
    state.customer.selectedProductId = targetId || null;
    renderCustomerProducts();

    if (!targetId) {
        state.customer.selectedProductDetail = null;
        state.customer.selectedProductReviews = [];
        state.customer.selectedProductRating = 0;
        renderCustomerSelectedProduct();
        return;
    }

    const wrap = document.getElementById('customerSelectedProductCard');
    if (wrap) {
        wrap.innerHTML = `<div class="customer-empty-state"><strong>Loading product view...</strong><span>Fetching current stock, supplier data, and customer feedback.</span></div>`;
    }

    try {
        const [detail, reviews] = await Promise.all([
            api(`/products/${targetId}`),
            api(`/products/${targetId}/reviews?per_page=3`).catch(() => ({ average_rating: 0, reviews: { data: [] } })),
        ]);

        if (Number(state.customer.selectedProductId || 0) !== targetId) return;
        state.customer.selectedProductDetail = detail || null;
        state.customer.selectedProductReviews = reviews?.reviews?.data || [];
        state.customer.selectedProductRating = Number(reviews?.average_rating || 0);
        renderCustomerSelectedProduct();
        renderCustomerProducts();
    } catch (err) {
        if (Number(state.customer.selectedProductId || 0) !== targetId) return;
        state.customer.selectedProductDetail = findCustomerProduct(targetId);
        state.customer.selectedProductReviews = [];
        state.customer.selectedProductRating = 0;
        renderCustomerSelectedProduct();
        notice(customerNotice, err.message, 'err');
    }
}
async function loadCustomerRequests() {
    if (!isCustomer()) return;

    const response = await api('/customer/requests?per_page=100');
    state.customer.requests = response?.data || [];
    renderCustomerRequests();
}
async function loadCustomerProfile() {
    if (!isCustomer()) return;

    state.customer.profile = await api('/customer/profile');
    renderCustomerProfile();
}
async function loadCustomerOrders() {
    if (!isCustomer()) return;

    const response = await api('/customer/orders?per_page=100');
    state.customer.orders = response?.data || [];
    renderCustomerOrders();
}
async function loadCustomerFavorites() {
    if (!isCustomer()) return;

    const response = await api('/customer/favorites');
    state.customer.favorites = response?.items || [];
    renderCustomerFavorites();
}
async function loadCustomerFavoriteAlerts() {
    if (!isCustomer()) return;

    const response = await api('/customer/alerts/favorites-low-stock');
    state.customer.favoriteAlerts = response?.items || [];
    renderCustomerFavoriteAlerts();
}
async function loadCustomerNotifications() {
    if (!isCustomer()) return;

    const response = await api('/customer/notifications?per_page=100');
    state.customer.notifications = response?.data || [];
    renderCustomerNotifications();
}
async function loadCustomerSeasonalSuggestions(filters = null) {
    if (!isCustomer() || !canViewSmartFeatures()) return;

    if (filters) {
        state.customer.seasonalFilters = {
            ...state.customer.seasonalFilters,
            ...filters,
        };
    }

    const month = String(state.customer.seasonalFilters.month || new Date().getMonth() + 1);
    const limit = String(state.customer.seasonalFilters.limit || '12');
    const params = new URLSearchParams();
    if (month) params.set('month', month);
    if (limit) params.set('limit', limit);

    const response = await api(`/smart/seasonal-suggestions?${params.toString()}`);
    state.customer.seasonalSuggestions = response?.items || [];
    state.customer.seasonalMeta = {
        month: response?.month || Number(month),
        season: response?.season || '',
    };
    renderCustomerSeasonalSuggestions();
}
async function loadCustomerHub() {
    if (!isCustomer()) return;
    await Promise.all([
        loadCustomerProducts(),
        loadCustomerRequests(),
        loadCustomerProfile(),
        loadCustomerOrders(),
        loadCustomerFavorites(),
        loadCustomerFavoriteAlerts(),
        loadCustomerNotifications(),
        loadCustomerSeasonalSuggestions(),
    ]);
}
async function loadPosRecentSales() {
    if (!canUsePos()) return;
    const data = await api('/pos/recent-sales?limit=8');
    state.pos.sales = data?.items || [];
    renderPosSales();
    syncPosReceiptPrintButton();
}
async function loadOperationsOrders(filters = null) {
    const canViewOrders = state.permissions.view_operations && (canManageOrders() || !!state.permissions.view_orders);
    if (!canViewOrders) {
        state.operations.orders = [];
        renderOperationsOrders();
        return;
    }

    if (filters) {
        state.operations.orderFilters = {
            ...state.operations.orderFilters,
            ...filters,
        };
    }

    document.getElementById('opOrderSearchInput').value = state.operations.orderFilters.search || '';
    document.getElementById('opOrderStatusFilter').value = state.operations.orderFilters.status || '';

    const params = new URLSearchParams({ per_page: '100' });
    const search = (state.operations.orderFilters.search || '').trim();
    const status = state.operations.orderFilters.status || '';
    if (search) params.set('search', search);
    if (status) params.set('status', status);

    const response = await api(`/orders?${params.toString()}`);
    state.operations.orders = response?.data || [];
    renderOperationsOrders();
}
async function loadOperationsPromotions() {
    const canViewPromotions = state.permissions.view_operations && canManagePromotions();
    if (!canViewPromotions) {
        state.operations.promotions = [];
        renderOperationsPromotions();
        return;
    }

    const response = await api('/promotions?active_only=0&per_page=100');
    state.operations.promotions = response?.data || [];
    renderOperationsPromotions();
}
async function loadOperationsStockReceipts() {
    const canViewReceipts = state.permissions.view_operations && canRecordStockReceipts();
    if (!canViewReceipts) {
        state.operations.receipts = [];
        renderStockReceipts();
        return;
    }

    const response = await api('/stock-receipts?per_page=100');
    state.operations.receipts = response?.data || [];
    renderStockReceipts();
}
async function loadOperationsBranches() {
    const canViewBranches = state.permissions.view_operations;
    if (!canViewBranches) {
        state.operations.branches = [];
        renderOperationsBranches();
        return;
    }

    const response = await api('/branches?per_page=200');
    state.operations.branches = response?.data || [];
    fillBranchSelects(state.operations.branches);
    renderOperationsBranches();
}
async function loadOperationsBranchOverview() {
    const canViewOverview = state.permissions.view_operations && canViewSmartFeatures();
    if (!canViewOverview) {
        state.operations.branchOverview = [];
        state.operations.unassignedWarehouses = [];
        renderOperationsBranchOverview();
        return;
    }

    const response = await api('/smart/branches/overview');
    state.operations.branchOverview = response?.items || [];
    state.operations.unassignedWarehouses = response?.unassigned_warehouses || [];
    renderOperationsBranchOverview();
}
async function loadOperationsForecast(filters = null) {
    const canViewForecast = state.permissions.view_operations && canViewSmartFeatures();
    if (!canViewForecast) {
        state.operations.forecast = [];
        renderOperationsForecast();
        return;
    }

    if (filters) {
        state.operations.forecastFilters = {
            ...state.operations.forecastFilters,
            ...filters,
        };
    }

    const selectedBranch = String(state.operations.forecastFilters.branch_id || '');
    const lookbackDays = String(state.operations.forecastFilters.lookback_days || '60');
    const forecastDays = String(state.operations.forecastFilters.forecast_days || '30');
    const limit = String(state.operations.forecastFilters.limit || '20');

    const params = new URLSearchParams();
    if (selectedBranch) params.set('branch_id', selectedBranch);
    if (lookbackDays) params.set('lookback_days', lookbackDays);
    if (forecastDays) params.set('forecast_days', forecastDays);
    if (limit) params.set('limit', limit);

    const response = await api(`/smart/forecast?${params.toString()}`);
    state.operations.forecast = response?.items || [];
    state.operations.forecastMeta = {
        lookback_days: response?.lookback_days || Number(lookbackDays),
        forecast_days: response?.forecast_days || Number(forecastDays),
        branch_id: response?.branch_id ?? (selectedBranch ? Number(selectedBranch) : null),
    };
    renderOperationsForecast();
}
async function loadOperationsInventory(filters = null) {
    const canViewOperations = state.permissions.view_operations;
    if (!canViewOperations) {
        state.operations.inventorySummary = null;
        state.operations.inventoryWarehouseSummary = [];
        state.operations.inventoryBatches = [];
        state.operations.inventoryAging = [];
        state.operations.inventoryAgingMeta = {
            threshold_days: 90,
            average_age_days: 0,
            buckets: { fresh: 0, monitor: 0, aging: 0 },
        };
        renderOperationsInventory();
        return;
    }

    if (filters) {
        state.operations.inventoryFilters = {
            ...state.operations.inventoryFilters,
            ...filters,
        };
    }

    const activeFilters = state.operations.inventoryFilters || {};
    const params = new URLSearchParams({ per_page: '100' });
    if (activeFilters.warehouse_id) params.set('warehouse_id', String(activeFilters.warehouse_id));
    if (activeFilters.status) params.set('status', String(activeFilters.status));
    if (activeFilters.search) params.set('search', String(activeFilters.search));

    const agingParams = new URLSearchParams(params.toString());
    agingParams.set('threshold_days', String(activeFilters.threshold_days || '90'));

    const [summary, warehouseSummary, batches, aging] = await Promise.all([
        api(`/inventory/summary?${params.toString()}`),
        api(`/inventory/warehouse-summary?${params.toString()}`),
        api(`/inventory/batches?${params.toString()}`),
        api(`/inventory/aging?${agingParams.toString()}`),
    ]);

    state.operations.inventorySummary = summary || null;
    state.operations.inventoryWarehouseSummary = warehouseSummary?.items || [];
    state.operations.inventoryBatches = batches?.data || [];
    state.operations.inventoryAging = aging?.items?.data || [];
    state.operations.inventoryAgingMeta = {
        threshold_days: Number(aging?.threshold_days || activeFilters.threshold_days || 90),
        average_age_days: Number(aging?.average_age_days || 0),
        buckets: aging?.buckets || { fresh: 0, monitor: 0, aging: 0 },
    };
    renderOperationsInventory();
}
async function loadOperationsAdjustments() {
    const canViewOperations = state.permissions.view_operations;
    if (!canViewOperations) {
        state.operations.adjustments = [];
        renderOperationsAdjustments();
        return;
    }

    const response = await api('/transactions?type=adjustment');
    state.operations.adjustments = response?.data || [];
    renderOperationsAdjustments();
}
async function loadOperationsHub() {
    if (!state.permissions.view_operations) return;
    await Promise.all([
        loadOperationsOrders(),
        loadOperationsPromotions(),
        loadOperationsStockReceipts(),
        loadOperationsBranches(),
        loadOperationsBranchOverview(),
        loadOperationsForecast(),
        loadOperationsInventory(),
        loadOperationsAdjustments(),
    ]);
    renderStockReceiptDraft();
    resetBranchForm();
}

async function loadSuperAdminLoginActivities(filters = null) {
    if (!isSuperAdmin()) return;

    if (filters) {
        state.superAdmin.loginFilters = {
            ...state.superAdmin.loginFilters,
            ...filters,
        };
    }

    const loginFilters = state.superAdmin.loginFilters || {};
    const form = document.getElementById('saLoginFilter');
    if (form) {
        form.elements.action.value = loginFilters.action || '';
        form.elements.user_id.value = loginFilters.user_id || '';
        form.elements.from.value = loginFilters.from || '';
        form.elements.to.value = loginFilters.to || '';
    }

    const params = new URLSearchParams({ per_page: '50' });
    if (loginFilters.action) params.set('action', loginFilters.action);
    if (loginFilters.user_id) params.set('user_id', String(loginFilters.user_id));
    if (loginFilters.from) params.set('from', loginFilters.from);
    if (loginFilters.to) params.set('to', loginFilters.to);

    state.superAdmin.loginActivities = await api(`/super-admin/login-activities?${params.toString()}`);
    renderSuperLoginActivities(state.superAdmin.loginActivities);
}
async function loadSuperAdminAuditLogs(filters = null) {
    if (!isSuperAdmin()) return;

    if (filters) {
        state.superAdmin.auditFilters = {
            ...state.superAdmin.auditFilters,
            ...filters,
        };
    }

    const auditFilters = state.superAdmin.auditFilters || {};
    const form = document.getElementById('saAuditFilter');
    if (form) {
        form.elements.action.value = auditFilters.action || '';
        form.elements.user_id.value = auditFilters.user_id || '';
        form.elements.from.value = auditFilters.from || '';
        form.elements.to.value = auditFilters.to || '';
    }

    const params = new URLSearchParams({ per_page: '50' });
    if (auditFilters.action) params.set('action', auditFilters.action);
    if (auditFilters.user_id) params.set('user_id', String(auditFilters.user_id));
    if (auditFilters.from) params.set('from', auditFilters.from);
    if (auditFilters.to) params.set('to', auditFilters.to);

    state.superAdmin.auditLogs = await api(`/super-admin/audit-logs?${params.toString()}`);
    renderSuperAuditLogs(state.superAdmin.auditLogs);
}
async function loadSuperAdminSystemSettings() {
    if (!isSuperAdmin()) return;
    state.superAdmin.settings = await api('/super-admin/system-settings');
    renderSuperSystemSettings(state.superAdmin.settings);
}

async function loadSuperAdminActivity(from = null, to = null) {
    if (!isSuperAdmin()) return;

    const params = new URLSearchParams();
    if (from) params.set('from', from);
    if (to) params.set('to', to);
    const path = `/super-admin/user-activity${params.toString() ? `?${params.toString()}` : ''}`;

    state.superAdmin.activity = await api(path);
    renderSuperActivity(state.superAdmin.activity);
}

async function loadSuperAdminStale(days = 45) {
    if (!isSuperAdmin()) return;

    const safeDays = Number(days || 45);
    state.superAdmin.stale = await api(`/super-admin/stale-accounts?days=${safeDays}`);
    renderStaleAccounts(state.superAdmin.stale);
}

async function loadSuperAdmin() {
    if (!isSuperAdmin()) return;

    const [overview, roles, security] = await Promise.all([
        api('/super-admin/overview'),
        api('/super-admin/role-distribution'),
        api('/super-admin/security-report'),
    ]);

    state.superAdmin.overview = overview;
    state.superAdmin.roles = roles;
    state.superAdmin.security = security;

    renderSuperOverview(overview);
    renderRoleDistribution(roles);
    renderSecurityReport(security);

    await Promise.all([
        loadSuperAdminActivity(),
        loadSuperAdminStale(45),
        loadSuperAdminLoginActivities(),
        loadSuperAdminAuditLogs(),
        loadSuperAdminSystemSettings(),
    ]);
}

async function downloadUsersCsv() {
    const headers = {};
    if (state.token) headers.Authorization = `Bearer ${state.token}`;

    const response = await fetch('/api/super-admin/export/users.csv', { headers });
    if (!response.ok) {
        const data = await response.json().catch(() => ({}));
        throw new Error(errMessage(data));
    }

    const blob = await response.blob();
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `users-export-${new Date().toISOString().slice(0, 10)}.csv`;
    document.body.appendChild(a);
    a.click();
    a.remove();
    window.URL.revokeObjectURL(url);
}
async function downloadBackupJson() {
    const headers = {};
    if (state.token) headers.Authorization = `Bearer ${state.token}`;

    const response = await fetch('/api/super-admin/backup/export', { headers });
    if (!response.ok) {
        const data = await response.json().catch(() => ({}));
        throw new Error(errMessage(data));
    }

    const blob = await response.blob();
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `system-backup-${new Date().toISOString().slice(0, 19).replace(/[:T]/g, '-')}.json`;
    document.body.appendChild(a);
    a.click();
    a.remove();
    window.URL.revokeObjectURL(url);
}

async function bootData() {
    const tasks = [];

    if (!isCustomer()) tasks.push(loadDashboard());
    if (isCustomer()) tasks.push(loadCustomerHub());
    if (state.permissions.view_operations) {
        tasks.push(loadRefs());
        tasks.push(loadOperationsHub());
    }
    if (canUsePos()) {
        tasks.push(loadPosRefs());
        tasks.push(loadPosRecentSales());
    }
    if (state.permissions.view_reports) tasks.push(loadReports());
    if (state.permissions.manage_users) tasks.push(loadUsers());
    if (isSuperAdmin()) tasks.push(loadSuperAdmin());

    await Promise.all(tasks);

    if (canUsePos()) {
    renderPosCatalog();
    renderPosCart();
    renderPosLastSale();
    syncPosReceiptPrintButton();
}
    applyResponsiveTableLabels(document);
}

function payload(form) { return Object.fromEntries(new FormData(form).entries()); }
function setAuthMode(mode) {
    const isLogin = mode === 'login';
    const loginTab = document.getElementById('loginTab');
    const registerTab = document.getElementById('registerTab');
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const authHeading = document.getElementById('authHeading');
    const authSubheading = document.getElementById('authSubheading');
    const authNotice = document.getElementById('authNotice');
    if (!loginTab || !registerTab || !loginForm || !registerForm || !authHeading || !authSubheading || !authNotice) {
        recoverInterfaceIfHidden(true);
        return;
    }

    loginTab.classList.toggle('active', isLogin);
    registerTab.classList.toggle('active', !isLogin);
    loginForm.classList.toggle('hidden', !isLogin);
    registerForm.classList.toggle('hidden', isLogin);
    authHeading.textContent = isLogin ? 'Welcome back' : 'Create your account';
    authSubheading.textContent = isLogin
        ? 'Sign in to continue.'
        : 'Create an account to get started.';
    authNotice.innerHTML = '';
}
function setSubmitState(form, loading, loadingText) {
    const submitButton = form.querySelector('button[type="submit"]');
    if (!submitButton) return;
    if (loading) {
        submitButton.dataset.label = submitButton.textContent;
        submitButton.disabled = true;
        submitButton.textContent = loadingText;
        return;
    }
    submitButton.disabled = false;
    submitButton.textContent = submitButton.dataset.label || submitButton.textContent;
}
async function submitForm(form, path, noticeEl, transform, after) {
    try {
        const p = payload(form); if (transform) transform(p);
        await api(path, { method: 'POST', body: JSON.stringify(p) });
        form.reset(); notice(noticeEl, 'Saved.', 'ok'); if (after) await after();
    } catch (e) { notice(noticeEl, e.message, 'err'); }
}
async function hydrateUser() {
    const me = await api('/user');
    state.user = me; state.permissions = me.permissions || {};
    localStorage.setItem('farm_user', JSON.stringify(state.user));
    updateUserBar();
    setupSuperAdminPanels();
    configureRoleSelects();
    resetUserForm();
    setMenuByRole();
    syncPosDiscountFields();
    syncPosPaymentFields();
    resetPromotionForm();
    resetProductForm();
    resetBranchForm();
    renderStockReceiptDraft();
    renderOperationsForecast();
    renderOperationsBranchOverview();
    renderCustomerSeasonalSuggestions();
}

setupUiRecoveryHandlers();
setupLiveVisualEffects();
recoverInterfaceIfHidden(false);
@include('partials.public-landing-scripts')

document.getElementById('loginTab').addEventListener('click', () => setAuthMode('login'));
document.getElementById('registerTab').addEventListener('click', () => setAuthMode('register'));
document.querySelectorAll('.pwd-toggle').forEach((btn) => {
    btn.addEventListener('click', () => {
        const target = document.getElementById(btn.dataset.target);
        if (!target) return;
        const willShow = target.type === 'password';
        target.type = willShow ? 'text' : 'password';
        btn.textContent = willShow ? 'Hide' : 'Show';
        btn.setAttribute('aria-pressed', willShow ? 'true' : 'false');
    });
});
document.querySelectorAll('.menu-btn').forEach((b) => b.addEventListener('click', () => {
    if (b.classList.contains('hidden')) return;
    if (b.dataset.view === 'customerView') {
        openCustomerSection(String(b.dataset.customerSection || 'shop'));
        return;
    }
    switchView(b.dataset.view);
}));
document.querySelectorAll('[data-home-target]').forEach((button) => {
    button.addEventListener('click', () => {
        const target = document.getElementById(String(button.dataset.homeTarget || ''));
        if (!target) return;
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });
});
document.getElementById('customerHomeShopBtn')?.addEventListener('click', () => openCustomerSection('shop'));
document.getElementById('customerHomeOrdersBtn')?.addEventListener('click', () => openCustomerSection('orders'));
document.getElementById('customerHomeProfileBtn')?.addEventListener('click', () => openCustomerSection('account'));
document.getElementById('customerHomeContactProfileBtn')?.addEventListener('click', () => openCustomerSection('account'));
document.getElementById('staffHomePosBtn')?.addEventListener('click', () => switchView('posView'));
document.getElementById('staffHomeInventoryBtn')?.addEventListener('click', () => openOperationsSection('setup'));
document.getElementById('staffHomeDeliveriesBtn')?.addEventListener('click', () => openOperationsSection('deliveries'));
document.getElementById('staffHomeReportsBtn')?.addEventListener('click', () => switchView('reportsView'));
document.getElementById('staffHomeLowStockBtn')?.addEventListener('click', () => openOperationsSection('setup'));
document.getElementById('staffHomeActivityBtn')?.addEventListener('click', () => switchView('reportsView'));
document.getElementById('staffHomePosSalesBtn')?.addEventListener('click', () => switchView('posView'));
document.getElementById('opSectionTabs')?.addEventListener('click', (e) => {
    const button = e.target.closest('button[data-op-section]');
    if (!button || button.disabled) return;
    setOperationsSection(String(button.dataset.opSection || 'setup'));
});
document.getElementById('customerSectionTabs')?.addEventListener('click', (e) => {
    const button = e.target.closest('button[data-customer-section]');
    if (!button || button.disabled) return;
    setCustomerSection(String(button.dataset.customerSection || 'shop'));
});
document.getElementById('reportsSectionTabs')?.addEventListener('click', (e) => {
    const button = e.target.closest('button[data-reports-section]');
    if (!button || button.disabled) return;
    setReportsSection(String(button.dataset.reportsSection || 'inventory'));
});
document.getElementById('usersSectionTabs')?.addEventListener('click', (e) => {
    const button = e.target.closest('button[data-users-section]');
    if (!button || button.disabled) return;
    setUserManagementSection(String(button.dataset.usersSection || 'directory'));
});
document.getElementById('superAdminSectionTabs')?.addEventListener('click', (e) => {
    const button = e.target.closest('button[data-super-section]');
    if (!button || button.disabled) return;
    setSuperAdminSection(String(button.dataset.superSection || 'overview'));
});
document.getElementById('superAdminView')?.addEventListener('click', (e) => {
    const button = e.target.closest('button[data-nav-view]');
    if (!button || button.disabled) return;
    openWorkspaceFeature(String(button.dataset.navView || 'superAdminView'), String(button.dataset.navSection || ''), String(button.dataset.navCard || ''));
});

document.getElementById('loginForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    setSubmitState(e.target, true, 'Signing in...');
    try {
        const data = await api('/login', { method: 'POST', body: JSON.stringify(payload(e.target)) });
        state.token = data.token;
        state.user = data.user;
        localStorage.setItem('farm_token', state.token);
        localStorage.setItem('farm_user', JSON.stringify(state.user));
        await hydrateUser();
        setAuth(true);
        await bootData();
    } catch (err) {
        notice(document.getElementById('authNotice'), err.message, 'err');
    } finally {
        setSubmitState(e.target, false, 'Signing in...');
    }
});
document.getElementById('registerForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    setSubmitState(e.target, true, 'Creating account...');
    try {
        const data = await api('/register', { method: 'POST', body: JSON.stringify(payload(e.target)) });
        state.token = data.token;
        state.user = data.user;
        localStorage.setItem('farm_token', state.token);
        localStorage.setItem('farm_user', JSON.stringify(state.user));
        await hydrateUser();
        setAuth(true);
        await bootData();
    } catch (err) {
        notice(document.getElementById('authNotice'), err.message, 'err');
    } finally {
        setSubmitState(e.target, false, 'Creating account...');
    }
});
document.getElementById('logoutBtn').addEventListener('click', async () => {
    const confirmedLogout = await requestLogoutConfirm();
    if (!confirmedLogout) return;

    try { await api('/logout', { method: 'POST' }); } catch (_) {}
    state.token = '';
    state.user = null;
    state.permissions = {};
    state.users = [];
    state.userFilters = { search: '', role: '' };
    state.customer = {
        products: [],
        requests: [],
        orders: [],
        favorites: [],
        favoriteAlerts: [],
        notifications: [],
        seasonalSuggestions: [],
        seasonalMeta: { month: null, season: '' },
        profile: null,
        filters: { search: '', stock_status: '' },
        seasonalFilters: { month: String(new Date().getMonth() + 1), limit: '12' },
    };
    state.pos = { search: '', cart: [], sales: [], products: [], warehouses: [], warehouseId: '', warehouse: null, lastSale: null };
    state.operations = {
        activeSection: 'setup',
        orderFilters: { status: '', search: '' },
        forecastFilters: { branch_id: '', lookback_days: '60', forecast_days: '30', limit: '20' },
        orders: [],
        branches: [],
        branchOverview: [],
        unassignedWarehouses: [],
        forecast: [],
        forecastMeta: { lookback_days: 60, forecast_days: 30, branch_id: null },
        inventoryFilters: { warehouse_id: '', status: '', search: '', threshold_days: '90' },
        inventorySummary: null,
        inventoryWarehouseSummary: [],
        inventoryBatches: [],
        inventoryAging: [],
        inventoryAgingMeta: { threshold_days: 90, average_age_days: 0, buckets: { fresh: 0, monitor: 0, aging: 0 } },
        promotions: [],
        receipts: [],
        receiptDraftItems: [],
        adjustments: [],
        adjustmentDraft: [],
        editingProductId: null,
        editingPromotionId: null,
        editingBranchId: null,
    };
    state.reports = { activeSection: 'inventory', business: null };
    state.userManagement = { activeSection: 'directory' };
    state.superAdmin = {
        activeSection: 'overview',
        overview: null,
        roles: null,
        activity: null,
        stale: null,
        security: null,
        loginActivities: null,
        auditLogs: null,
        settings: null,
        loginFilters: { action: '', user_id: '', from: '', to: '' },
        auditFilters: { action: '', user_id: '', from: '', to: '' },
    };
    localStorage.removeItem('farm_token');
    localStorage.removeItem('farm_user');
    syncShellMode();
    setAuth(false);
});
document.getElementById('logoutConfirmApproveBtn')?.addEventListener('click', () => resolveLogoutConfirm(true));
document.getElementById('logoutConfirmCancelBtn')?.addEventListener('click', () => resolveLogoutConfirm(false));
document.querySelectorAll('[data-logout-confirm-close]').forEach((element) => {
    element.addEventListener('click', () => resolveLogoutConfirm(false));
});
window.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && logoutConfirmResolver) {
        resolveLogoutConfirm(false);
    }
});
document.getElementById('refreshBtn').addEventListener('click', async () => {
    const posViewActive = document.getElementById('posView').classList.contains('active');
    const superAdminViewActive = document.getElementById('superAdminView').classList.contains('active');
    const reportsViewActive = document.getElementById('reportsView').classList.contains('active');
    const usersViewActive = document.getElementById('usersView').classList.contains('active');
    const refreshNotice = posViewActive
        ? document.getElementById('posNotice')
        : (superAdminViewActive ? document.getElementById('saNotice')
        : (reportsViewActive ? document.getElementById('reportsNotice')
        : (usersViewActive ? document.getElementById('userNotice')
        : (isCustomer() ? document.getElementById('customerNotice') : document.getElementById('opNotice')))));

    try {
        await bootData();
        notice(refreshNotice, 'Data refreshed.', 'ok');
    } catch (e) {
        notice(refreshNotice, e.message, 'err');
    }
});

const opNotice = document.getElementById('opNotice');
document.getElementById('categoryForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    await submitForm(e.target, '/categories', opNotice, null, async () => { await loadRefs(); await loadDashboard(); });
});
document.getElementById('supplierForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    await submitForm(e.target, '/suppliers', opNotice, null, async () => { await loadRefs(); });
});
document.getElementById('warehouseForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    await submitForm(e.target, '/warehouses', opNotice, (p) => {
        p.branch_id = p.branch_id ? Number(p.branch_id) : null;
    }, async () => { await loadRefs(); await loadReports(); await loadOperationsBranchOverview(); });
});
document.getElementById('productForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    try {
        const form = e.target;
        const formData = new FormData(form);
        const productId = Number(formData.get('product_id') || 0);
        const isUpdate = productId > 0;
        formData.delete('product_id');
        formData.set('supplier_id', String(formData.get('supplier_id') || ''));
        formData.set('unit_price', String(Number(formData.get('unit_price') || 0)));
        formData.set('min_stock_level', String(Number(formData.get('min_stock_level') || 0)));
        formData.set('reorder_point', String(Number(formData.get('reorder_point') || 0)));
        formData.set('max_stock_level', '');
        const imageFile = formData.get('image_file');
        if (!(imageFile instanceof File) || !imageFile.size) {
            formData.delete('image_file');
        }
        if (isUpdate) {
            formData.append('_method', 'PUT');
        }

        const response = await api(isUpdate ? `/products/${productId}` : '/products', {
            method: 'POST',
            body: formData,
        });
        const savedProduct = response?.product || null;
        if (savedProduct) {
            upsertProductState(savedProduct);
            refreshOperationsProductUi(!isUpdate ? savedProduct.id : productId);
        }

        notice(opNotice, isUpdate ? 'Product updated.' : 'Product added.', 'ok');
        resetProductForm();
        if (savedProduct && !isUpdate && document.getElementById('txProductSelect')) {
            document.getElementById('txProductSelect').value = String(savedProduct.id);
            syncQuickStockProductMeta();
        }
        await Promise.all([loadDashboard(), loadPosRefs(), state.permissions.view_operations ? loadOperationsInventory() : Promise.resolve(), loadCustomerProducts()]);
    } catch (err) {
        notice(opNotice, err.message, 'err');
    }
});
document.getElementById('productCancelEditBtn').addEventListener('click', () => {
    resetProductForm();
    notice(opNotice, 'Product edit canceled.', 'ok');
});
document.getElementById('txProductSelect')?.addEventListener('change', () => syncQuickStockProductMeta());
document.getElementById('opProductRows').addEventListener('click', async (e) => {
    const editButton = e.target.closest('.op-product-edit-btn');
    const toggleButton = e.target.closest('.op-product-toggle-btn');
    const deleteButton = e.target.closest('.op-product-delete-btn');
    if (!editButton && !toggleButton && !deleteButton) return;

    const productId = Number((editButton || toggleButton || deleteButton).dataset.productId || 0);
    if (!productId) return;

    const product = findProductById(productId);
    if (!product) {
        notice(opNotice, 'Product not found in the current list.', 'err');
        return;
    }

    if (editButton) {
        setProductEditMode(product);
        notice(opNotice, `Editing product: ${product.name}`, 'ok');
        return;
    }

    if (toggleButton) {
        const nextActive = String(toggleButton.dataset.nextActive || '0') === '1';
        const confirmToggle = window.confirm(`${nextActive ? 'Restore' : 'Remove'} product "${product.name}"?`);
        if (!confirmToggle) return;

        try {
            await api(`/products/${productId}/toggle-active`, {
                method: 'PATCH',
                body: JSON.stringify({ is_active: nextActive }),
            });
            notice(opNotice, nextActive ? 'Product restored.' : 'Product removed.', 'ok');
            await Promise.all([loadRefs(), loadDashboard(), loadPosRefs(), state.permissions.view_operations ? loadOperationsInventory() : Promise.resolve(), loadCustomerProducts()]);
        } catch (err) {
            notice(opNotice, err.message, 'err');
        }
        return;
    }

    const confirmDelete = window.confirm(`Delete product "${product.name}" permanently? This cannot be undone.`);
    if (!confirmDelete) return;

    try {
        await api(`/products/${productId}`, { method: 'DELETE' });
        if (Number(state.operations.editingProductId) === productId) {
            resetProductForm();
        }
        notice(opNotice, 'Product deleted.', 'ok');
        await Promise.all([loadRefs(), loadDashboard(), loadPosRefs(), state.permissions.view_operations ? loadOperationsInventory() : Promise.resolve(), loadCustomerProducts()]);
    } catch (err) {
        notice(opNotice, err.message, 'err');
    }
});
document.getElementById('txForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const selectedProductId = document.getElementById('txProductSelect')?.value || '';
    await submitForm(e.target, '/transactions', opNotice, (p) => {
        p.quantity = Number(p.quantity || 0);
        p.unit_price = Number(p.unit_price || 0);
    }, async () => {
        await Promise.all([
            loadDashboard(),
            state.permissions.view_reports ? loadReports() : Promise.resolve(),
            state.permissions.view_operations ? loadRefs() : Promise.resolve(),
            state.permissions.view_operations ? loadOperationsInventory() : Promise.resolve(),
            canUsePos() ? loadPosRefs() : Promise.resolve(),
        ]);
        if (selectedProductId && document.getElementById('txProductSelect')) {
            document.getElementById('txProductSelect').value = String(selectedProductId);
        }
        syncQuickStockProductMeta();
    });
});
document.getElementById('adjustmentForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    try {
        const form = e.target;
        const p = payload(form);
        const productId = Number(p.product_id || 0);
        const warehouseId = Number(p.warehouse_id || 0);
        const adjustmentType = String(p.adjustment_type || 'decrease');
        const adjustmentReason = String(p.adjustment_reason || 'correction');
        const quantity = Number(p.quantity || 0);
        const selectedInventoryId = Number(p.inventory_id || 0);
        const product = findProductRecord(productId);
        const warehouse = findWarehouseRecord(warehouseId);
        const matches = getAdjustmentInventoryMatches(productId, warehouseId);
        const selectedBatch = matches.find((item) => Number(item.id) === selectedInventoryId) || null;
        const resolvedInventoryId = selectedInventoryId || (adjustmentType === 'decrease' && matches.length === 1 ? Number(matches[0].id) : 0);
        const resolvedBatch = selectedBatch || (resolvedInventoryId && matches.length === 1 ? matches[0] : null);
        const resolvedUnitPrice = Number(p.unit_price || resolvedBatch?.unit_cost || product?.unit_price || 0);

        if (!productId || !warehouseId || quantity <= 0 || resolvedUnitPrice < 0) {
            throw new Error('Provide a valid product, warehouse, quantity, and unit cost.');
        }
        if (adjustmentType === 'decrease' && matches.length > 1 && !resolvedInventoryId) {
            throw new Error('Select the exact batch to deduct from because this product has multiple batches in the selected warehouse.');
        }

        state.operations.adjustmentDraft.push({
            id: `adj-${Date.now()}-${Math.random().toString(36).slice(2, 7)}`,
            product_id: productId,
            product_name: product?.name || 'Selected product',
            warehouse_id: warehouseId,
            warehouse_name: warehouse ? `${warehouse.name} (${warehouse.code})` : 'Selected warehouse',
            inventory_id: resolvedInventoryId || null,
            batch_label: resolvedBatch ? inventoryBatchLabel(resolvedBatch) : '',
            transaction_type: 'adjustment',
            adjustment_type: adjustmentType,
            adjustment_reason: adjustmentReason,
            quantity,
            unit_price: resolvedUnitPrice,
            reference_number: (p.reference_number || '').trim() || null,
            notes: (p.notes || '').trim() || null,
        });

        const preservedWarehouse = String(p.warehouse_id || '');
        const preservedType = adjustmentType;
        const preservedReason = adjustmentReason;
        const preservedReference = String(p.reference_number || '');
        form.reset();
        form.elements.warehouse_id.value = preservedWarehouse;
        form.elements.adjustment_type.value = preservedType;
        form.elements.adjustment_reason.value = preservedReason;
        form.elements.reference_number.value = preservedReference;
        syncAdjustmentInventoryOptions(false);
        renderAdjustmentDraft();
        notice(opNotice, 'Adjustment line added to draft.', 'ok');
    } catch (err) {
        notice(opNotice, err.message, 'err');
    }
});
document.getElementById('adjustmentFormResetBtn').addEventListener('click', () => {
    const form = document.getElementById('adjustmentForm');
    if (!form) return;
    form.reset();
    syncAdjustmentInventoryOptions(false);
});
document.getElementById('adjustmentSubmitAllBtn').addEventListener('click', async () => {
    const draft = [...(state.operations.adjustmentDraft || [])];
    if (!draft.length) {
        notice(opNotice, 'Add at least one adjustment line first.', 'err');
        return;
    }

    let processed = 0;
    try {
        for (const item of draft) {
            await api('/transactions', {
                method: 'POST',
                body: JSON.stringify({
                    product_id: item.product_id,
                    warehouse_id: item.warehouse_id,
                    inventory_id: item.inventory_id,
                    transaction_type: 'adjustment',
                    adjustment_type: item.adjustment_type,
                    adjustment_reason: item.adjustment_reason,
                    quantity: item.quantity,
                    unit_price: item.unit_price,
                    reference_number: item.reference_number,
                    notes: item.notes,
                }),
            });
            processed += 1;
        }

        state.operations.adjustmentDraft = [];
        renderAdjustmentDraft();
        notice(opNotice, `${processed} stock adjustment ${processed === 1 ? 'line was' : 'lines were'} posted.`, 'ok');
        await Promise.all([loadOperationsAdjustments(), loadDashboard(), state.permissions.view_reports ? loadReports() : Promise.resolve(), loadRefs(), state.permissions.view_operations ? loadOperationsInventory() : Promise.resolve(), canUsePos() ? loadPosRefs() : Promise.resolve()]);
    } catch (err) {
        state.operations.adjustmentDraft = draft.slice(processed);
        renderAdjustmentDraft();
        notice(opNotice, `${processed} line(s) posted. Remaining draft kept. ${err.message}`, 'err');
    }
});
document.getElementById('adjustmentClearDraftBtn').addEventListener('click', () => {
    state.operations.adjustmentDraft = [];
    renderAdjustmentDraft();
    notice(opNotice, 'Draft adjustments cleared.', 'ok');
});
document.getElementById('adjustmentDraftRows').addEventListener('click', (e) => {
    const removeButton = e.target.closest('.adjustment-draft-remove');
    if (!removeButton) return;
    const draftId = String(removeButton.dataset.draftId || '');
    state.operations.adjustmentDraft = (state.operations.adjustmentDraft || []).filter((item) => String(item.id) !== draftId);
    renderAdjustmentDraft();
});
document.getElementById('adjustProductSelect').addEventListener('change', () => syncAdjustmentInventoryOptions(false));
document.getElementById('adjustWarehouseSelect').addEventListener('change', () => syncAdjustmentInventoryOptions(false));
document.getElementById('adjustInventorySelect').addEventListener('change', () => syncAdjustmentInventoryOptions(true));
document.getElementById('opAdjustmentCard').addEventListener('click', (e) => {
    const preset = e.target.closest('.op-adjust-preset');
    if (!preset) return;
    const form = document.getElementById('adjustmentForm');
    form.elements.adjustment_type.value = String(preset.dataset.adjustType || 'decrease');
    form.elements.adjustment_reason.value = String(preset.dataset.adjustReason || 'correction');
    notice(opNotice, 'Adjustment preset applied.', 'ok');
});
document.getElementById('opOrderFilterForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    try {
        await loadOperationsOrders({
            search: document.getElementById('opOrderSearchInput').value || '',
            status: document.getElementById('opOrderStatusFilter').value || '',
        });
    } catch (err) {
        notice(opNotice, err.message, 'err');
    }
});
document.getElementById('opOrderFilterResetBtn').addEventListener('click', async () => {
    try {
        await loadOperationsOrders({ search: '', status: '' });
    } catch (err) {
        notice(opNotice, err.message, 'err');
    }
});
document.getElementById('opOrderRows').addEventListener('click', async (e) => {
    const updateButton = e.target.closest('.op-order-update-btn');
    if (!updateButton) return;

    const orderId = Number(updateButton.dataset.orderId || 0);
    if (!orderId) return;

    const select = document.querySelector(`.op-order-status[data-order-id="${orderId}"]`);
    const status = select?.value || '';
    if (!status) return;

    const note = window.prompt('Optional order status note:', '') || '';

    try {
        await api(`/orders/${orderId}/status`, {
            method: 'PATCH',
            body: JSON.stringify({
                status,
                notes: note.trim() || null,
            }),
        });
        notice(opNotice, 'Order status updated.', 'ok');
        await Promise.all([loadOperationsOrders(), loadDashboard()]);
    } catch (err) {
        notice(opNotice, err.message, 'err');
    }
});
document.getElementById('promotionForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    try {
        const p = payload(e.target);
        const promotionId = Number(p.promotion_id || 0);
        const promoPayload = {
            title: p.title,
            description: p.description || null,
            discount_type: p.discount_type,
            discount_value: Number(p.discount_value || 0),
            code: (p.code || '').trim() || null,
            starts_at: p.starts_at || null,
            ends_at: p.ends_at || null,
            is_active: !!p.is_active,
        };

        await api(promotionId ? `/promotions/${promotionId}` : '/promotions', {
            method: promotionId ? 'PUT' : 'POST',
            body: JSON.stringify(promoPayload),
        });

        notice(opNotice, promotionId ? 'Promotion updated.' : 'Promotion created.', 'ok');
        resetPromotionForm();
        await loadOperationsPromotions();
    } catch (err) {
        notice(opNotice, err.message, 'err');
    }
});
document.getElementById('promotionCancelEditBtn').addEventListener('click', () => {
    resetPromotionForm();
    notice(opNotice, 'Promotion edit canceled.', 'ok');
});
document.getElementById('promotionRows').addEventListener('click', async (e) => {
    const editButton = e.target.closest('.promotion-edit-btn');
    const deleteButton = e.target.closest('.promotion-delete-btn');
    if (!editButton && !deleteButton) return;

    const promotionId = Number((editButton || deleteButton).dataset.promotionId || 0);
    if (!promotionId) return;

    const promotion = (state.operations.promotions || []).find((item) => Number(item.id) === promotionId);
    if (!promotion) {
        notice(opNotice, 'Promotion not found in current list.', 'err');
        return;
    }

    if (editButton) {
        setPromotionEditMode(promotion);
        notice(opNotice, `Editing promotion: ${promotion.title}`, 'ok');
        return;
    }

    const confirmedDelete = window.confirm(`Delete promotion "${promotion.title}"? This cannot be undone.`);
    if (!confirmedDelete) return;

    try {
        await api(`/promotions/${promotionId}`, { method: 'DELETE' });
        notice(opNotice, 'Promotion deleted.', 'ok');
        resetPromotionForm();
        await loadOperationsPromotions();
    } catch (err) {
        notice(opNotice, err.message, 'err');
    }
});
document.getElementById('stockReceiptItemForm').addEventListener('submit', (e) => {
    e.preventDefault();
    const p = payload(e.target);
    const productId = Number(p.product_id || 0);
    const quantity = Number(p.quantity || 0);
    const unitCost = Number(p.unit_cost || 0);
    const batchNumber = String(p.batch_number || '').trim() || null;
    const manufacturingDate = String(p.manufacturing_date || '').trim() || null;
    const expiryDate = String(p.expiry_date || '').trim() || null;

    if (!productId || quantity <= 0 || unitCost < 0) {
        notice(opNotice, 'Provide a valid product, quantity, and unit cost.', 'err');
        return;
    }
    if (manufacturingDate && expiryDate && new Date(expiryDate) < new Date(manufacturingDate)) {
        notice(opNotice, 'Expiry date must be later than or equal to manufacturing date.', 'err');
        return;
    }

    const product = (state.products || []).find((item) => Number(item.id) === productId);
    const existing = state.operations.receiptDraftItems.find((item) => Number(item.product_id) === productId
        && Number(item.unit_cost) === unitCost
        && String(item.batch_number || '') === String(batchNumber || '')
        && String(item.manufacturing_date || '') === String(manufacturingDate || '')
        && String(item.expiry_date || '') === String(expiryDate || ''));

    if (existing) {
        existing.quantity = Number(existing.quantity || 0) + quantity;
    } else {
        state.operations.receiptDraftItems.push({
            product_id: productId,
            product_name: product?.name || `Product #${productId}`,
            batch_number: batchNumber,
            manufacturing_date: manufacturingDate,
            expiry_date: expiryDate,
            quantity,
            unit_cost: unitCost,
        });
    }

    e.target.reset();
    renderStockReceiptDraft();
});
document.getElementById('stockReceiptDraftRows').addEventListener('click', (e) => {
    const removeButton = e.target.closest('.stock-receipt-remove-item-btn');
    if (!removeButton) return;
    const index = Number(removeButton.dataset.index || -1);
    if (index < 0) return;
    state.operations.receiptDraftItems.splice(index, 1);
    renderStockReceiptDraft();
});
document.getElementById('stockReceiptForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    try {
        if (!state.operations.receiptDraftItems.length) {
            throw new Error('Add at least one delivery item before saving receipt.');
        }

        const p = payload(e.target);
        const receiptPayload = {
            supplier_id: Number(p.supplier_id || 0),
            warehouse_id: Number(p.warehouse_id || 0),
            reference_no: (p.reference_no || '').trim() || null,
            notes: (p.notes || '').trim() || null,
            items: state.operations.receiptDraftItems.map((item) => ({
                product_id: Number(item.product_id),
                quantity: Number(item.quantity),
                unit_cost: Number(item.unit_cost),
                batch_number: item.batch_number || null,
                manufacturing_date: item.manufacturing_date || null,
                expiry_date: item.expiry_date || null,
            })),
        };

        await api('/stock-receipts', {
            method: 'POST',
            body: JSON.stringify(receiptPayload),
        });

        state.operations.receiptDraftItems = [];
        e.target.reset();
        renderStockReceiptDraft();
        notice(opNotice, 'Delivery recorded.', 'ok');

        await Promise.all([
            loadOperationsStockReceipts(),
            loadDashboard(),
            state.permissions.view_reports ? loadReports() : Promise.resolve(),
            state.permissions.view_operations ? loadRefs() : Promise.resolve(),
            state.permissions.view_operations ? loadOperationsInventory() : Promise.resolve(),
            canUsePos() ? loadPosRefs() : Promise.resolve(),
        ]);
    } catch (err) {
        notice(opNotice, err.message, 'err');
    }
});
document.getElementById('opForecastForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    try {
        const p = payload(e.target);
        await loadOperationsForecast({
            branch_id: p.branch_id || '',
            lookback_days: String(p.lookback_days || '60'),
            forecast_days: String(p.forecast_days || '30'),
            limit: String(p.limit || '20'),
        });
        notice(opNotice, 'Forecast ready.', 'ok');
    } catch (err) {
        notice(opNotice, err.message, 'err');
    }
});
document.getElementById('opBranchOverviewRefreshBtn').addEventListener('click', async () => {
    try {
        await loadOperationsBranchOverview();
        notice(opNotice, 'Branch inventory overview refreshed.', 'ok');
    } catch (err) {
        notice(opNotice, err.message, 'err');
    }
});
document.getElementById('opBranchForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    if (!canManageBranches()) {
        notice(opNotice, 'You do not have permission to manage branches.', 'err');
        return;
    }

    try {
        const p = payload(e.target);
        const branchId = Number(p.branch_id || 0);
        const branchPayload = {
            name: p.name,
            code: p.code,
            location: (p.location || '').trim() || null,
            contact_person: (p.contact_person || '').trim() || null,
            phone: (p.phone || '').trim() || null,
            is_active: String(p.is_active || '1') === '1',
        };

        await api(branchId ? `/branches/${branchId}` : '/branches', {
            method: branchId ? 'PUT' : 'POST',
            body: JSON.stringify(branchPayload),
        });

        notice(opNotice, branchId ? 'Branch updated.' : 'Branch created.', 'ok');
        resetBranchForm();
        await Promise.all([loadOperationsBranches(), loadOperationsBranchOverview(), loadRefs()]);
    } catch (err) {
        notice(opNotice, err.message, 'err');
    }
});
document.getElementById('opBranchCancelBtn').addEventListener('click', () => {
    resetBranchForm();
    notice(opNotice, 'Branch edit canceled.', 'ok');
});
document.getElementById('opBranchRows').addEventListener('click', async (e) => {
    const editButton = e.target.closest('.op-branch-edit-btn');
    const deleteButton = e.target.closest('.op-branch-delete-btn');
    if (!editButton && !deleteButton) return;

    const branchId = Number((editButton || deleteButton).dataset.branchId || 0);
    if (!branchId) return;
    const branch = (state.operations.branches || []).find((item) => Number(item.id) === branchId);
    if (!branch) {
        notice(opNotice, 'Branch not found in current list.', 'err');
        return;
    }

    if (editButton) {
        setBranchEditMode(branch);
        notice(opNotice, `Editing branch: ${branch.name}`, 'ok');
        return;
    }

    if (!canManageBranches()) {
        notice(opNotice, 'You do not have permission to delete branches.', 'err');
        return;
    }

    const confirmedDelete = window.confirm(`Delete branch "${branch.name}"? This cannot be undone.`);
    if (!confirmedDelete) return;

    try {
        await api(`/branches/${branchId}`, { method: 'DELETE' });
        notice(opNotice, 'Branch deleted.', 'ok');
        resetBranchForm();
        await Promise.all([loadOperationsBranches(), loadOperationsBranchOverview(), loadRefs()]);
    } catch (err) {
        notice(opNotice, err.message, 'err');
    }
});
document.getElementById('inventoryFilterForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    try {
        const p = payload(e.target);
        await loadOperationsInventory({
            warehouse_id: p.warehouse_id || '',
            status: p.status || '',
            search: p.search || '',
            threshold_days: String(p.threshold_days || '90'),
        });
        notice(opNotice, 'Inventory filters applied.', 'ok');
    } catch (err) {
        notice(opNotice, err.message, 'err');
    }
});
document.getElementById('inventoryFilterResetBtn').addEventListener('click', async () => {
    try {
        await loadOperationsInventory({ warehouse_id: '', status: '', search: '', threshold_days: '90' });
        notice(opNotice, 'Inventory filters reset.', 'ok');
    } catch (err) {
        notice(opNotice, err.message, 'err');
    }
});
document.getElementById('inventoryStatusForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    try {
        const p = payload(e.target);
        const inventoryId = Number(p.inventory_id || 0);
        if (!inventoryId) {
            throw new Error('Select an inventory batch to update.');
        }

        await api(`/inventory/${inventoryId}/status`, {
            method: 'PATCH',
            body: JSON.stringify({
                status: p.status,
                location_in_warehouse: (p.location_in_warehouse || '').trim() || null,
                notes: (p.notes || '').trim() || null,
            }),
        });

        e.target.reset();
        document.getElementById('inventoryStatusSelect').value = 'available';
        notice(opNotice, 'Batch status updated.', 'ok');
        await Promise.all([
            loadRefs(),
            loadDashboard(),
            state.permissions.view_reports ? loadReports() : Promise.resolve(),
            state.permissions.view_operations ? loadOperationsInventory() : Promise.resolve(),
            canUsePos() ? loadPosRefs() : Promise.resolve(),
        ]);
    } catch (err) {
        notice(opNotice, err.message, 'err');
    }
});
const posNotice = document.getElementById('posNotice');
document.getElementById('posFilterForm').addEventListener('submit', (e) => {
    e.preventDefault();
    state.pos.search = document.getElementById('posSearchInput').value || '';
    renderPosCatalog();
});
document.getElementById('posFilterResetBtn').addEventListener('click', () => {
    state.pos.search = '';
    document.getElementById('posSearchInput').value = '';
    renderPosCatalog();
});
document.getElementById('posSearchInput').addEventListener('input', (e) => {
    state.pos.search = e.target.value || '';
    renderPosCatalog();
});
document.getElementById('posWarehouseSelect').addEventListener('change', async () => {
    const nextWarehouseId = String(document.getElementById('posWarehouseSelect').value || '');
    const previousWarehouseId = String(state.pos.warehouseId || '');

    if (state.pos.cart.length && previousWarehouseId && previousWarehouseId !== nextWarehouseId) {
        const confirmed = window.confirm('Changing warehouse will clear the current POS cart. Continue?');
        if (!confirmed) {
            document.getElementById('posWarehouseSelect').value = previousWarehouseId;
            return;
        }
        state.pos.cart = [];
        renderPosCart();
    }

    try {
        state.pos.warehouseId = nextWarehouseId;
        await loadPosCatalogData();
    } catch (err) {
        notice(posNotice, err.message, 'err');
    }
});
document.getElementById('posProductRows').addEventListener('click', (e) => {
    const addBtn = e.target.closest('.pos-add-btn');
    if (!addBtn) return;

    const warehouseId = posWarehouseSelected();
    if (!warehouseId) {
        notice(posNotice, 'Select a warehouse before adding products.', 'err');
        return;
    }

    const card = addBtn.closest('.pos-product-card');
    const qtyInput = card?.querySelector('.pos-catalog-qty');
    const quantity = Number(qtyInput?.value || 1);
    addProductToPosCart(Number(addBtn.dataset.productId || 0), quantity);
});
document.getElementById('posProductRows').addEventListener('keydown', (e) => {
    const qtyInput = e.target.closest('.pos-catalog-qty');
    if (!qtyInput || e.key !== 'Enter') return;

    e.preventDefault();
    addProductToPosCart(Number(qtyInput.dataset.productId || 0), Number(qtyInput.value || 1));
});
document.getElementById('posCartRows').addEventListener('click', (e) => {
    const removeBtn = e.target.closest('.pos-remove-btn');
    if (removeBtn) {
        removePosLine(Number(removeBtn.dataset.productId || 0));
        notice(posNotice, 'Item removed from the sale.', 'ok');
    }
});
document.getElementById('posCartRows').addEventListener('change', (e) => {
    const qtyInput = e.target.closest('.pos-qty-input');
    if (!qtyInput) return;
    setPosLineQuantity(Number(qtyInput.dataset.productId || 0), qtyInput.value);
});
document.getElementById('posCartRows').addEventListener('keydown', (e) => {
    const qtyInput = e.target.closest('.pos-qty-input');
    if (!qtyInput || e.key !== 'Enter') return;
    e.preventDefault();
    setPosLineQuantity(Number(qtyInput.dataset.productId || 0), qtyInput.value);
    qtyInput.blur();
});
document.getElementById('posPaymentMethod').addEventListener('change', () => {
    syncPosPaymentFields();
});
document.getElementById('posDiscountType').addEventListener('change', () => {
    syncPosDiscountFields();
    renderPosCart();
});
document.getElementById('posDiscountInput').addEventListener('input', () => {
    renderPosCart();
});
document.getElementById('posCashReceivedInput').addEventListener('input', () => {
    renderPosCart();
});
document.getElementById('posCashQuickActions')?.addEventListener('click', (e) => {
    const quickBtn = e.target.closest('.pos-cash-quick-btn');
    if (!quickBtn) return;
    applyPosCashQuickAmount(quickBtn);
});
document.getElementById('posPrintReceiptBtn')?.addEventListener('click', () => {
    if (!state.pos.lastSale) {
        notice(posNotice, 'Complete a sale first to print receipt.', 'err');
        return;
    }
    printPosReceipt(state.pos.lastSale);
});
document.getElementById('posCheckoutForm').addEventListener('submit', async (e) => {
    e.preventDefault();

    const warehouseId = posWarehouseSelected();
    if (!warehouseId) {
        notice(posNotice, 'Please select a warehouse for this sale.', 'err');
        return;
    }

    if (!state.pos.cart.length) {
        notice(posNotice, 'Add at least one product to cart before checkout.', 'err');
        return;
    }

    if (state.pos.cart.some((line) => Number(line.quantity || 0) > getPosAvailableStock(line.product_id))) {
        notice(posNotice, 'Adjust the cart to match available warehouse stock before checkout.', 'err');
        return;
    }

    try {
        const formData = new FormData(e.target);
        const paymentMethod = String(formData.get('payment_method') || 'cash').toLowerCase();
        const totals = posCartTotals();
        const discount = Number(totals.discount || 0);
        const discountType = String(formData.get('discount_type') || 'none').toLowerCase();
        const cashReceived = Number(totals.cashReceived || 0);
        const gcashReferenceNumber = String(formData.get('gcash_reference_number') || '').trim();
        const gcashReceipt = formData.get('gcash_receipt');
        const discountIdNumber = String(formData.get('discount_id_number') || '').trim();
        const discountIdImage = formData.get('discount_id_image');

        if (paymentMethod === 'cash' && totals.balanceDue > 0) {
            notice(posNotice, `Cash is short by ${money(totals.balanceDue)}.`, 'err');
            return;
        }

        if (paymentMethod === 'gcash' && !gcashReferenceNumber) {
            notice(posNotice, 'GCash reference number is required.', 'err');
            return;
        }

        if (paymentMethod === 'gcash' && (!(gcashReceipt instanceof File) || !gcashReceipt.size)) {
            notice(posNotice, 'Please upload a GCash receipt image.', 'err');
            return;
        }

        if ((discountType === 'senior' || discountType === 'pwd') && !discountIdNumber) {
            notice(posNotice, 'Senior/PWD ID number is required for 20% discount.', 'err');
            return;
        }

        if ((discountType === 'senior' || discountType === 'pwd') && (!(discountIdImage instanceof File) || !discountIdImage.size)) {
            notice(posNotice, 'Upload a Senior/PWD ID proof image to confirm discount.', 'err');
            return;
        }

        const checkoutPayload = new FormData();
        checkoutPayload.append('warehouse_id', String(warehouseId));
        checkoutPayload.append('payment_method', paymentMethod);
        checkoutPayload.append('discount_type', discountType);
        checkoutPayload.append('discount', String(discount));
        checkoutPayload.append('items', JSON.stringify(
            state.pos.cart.map((line) => ({
                product_id: Number(line.product_id),
                quantity: Number(line.quantity),
                unit_price: Number(line.unit_price || 0),
            }))
        ));

        const customerName = String(formData.get('customer_name') || '').trim();
        const notes = String(formData.get('notes') || '').trim();
        if (customerName) checkoutPayload.append('customer_name', customerName);
        if (notes) checkoutPayload.append('notes', notes);

        if (paymentMethod === 'cash') {
            checkoutPayload.append('cash_received', String(cashReceived));
        }

        if (paymentMethod === 'gcash') {
            checkoutPayload.append('gcash_reference_number', gcashReferenceNumber);
            checkoutPayload.append('gcash_receipt', gcashReceipt);
        }

        if (discountType === 'senior' || discountType === 'pwd') {
            checkoutPayload.append('discount_id_number', discountIdNumber);
            checkoutPayload.append('discount_id_image', discountIdImage);
        }

        const result = await api('/pos/checkout', {
            method: 'POST',
            body: checkoutPayload,
        });

        state.pos.lastSale = result.sale || null;
        syncPosReceiptPrintButton();
        state.pos.cart = [];
        applyPosSaleToCatalog(state.pos.lastSale);
        prependPosRecentSale(state.pos.lastSale);
        e.target.reset();
        document.getElementById('posDiscountType').value = 'none';
        document.getElementById('posDiscountInput').value = '0';
        document.getElementById('posPaymentMethod').value = 'cash';
        syncPosDiscountFields();
        syncPosPaymentFields();
        renderPosLastSale();
        renderPosCatalog();
        renderPosCart();

        notice(posNotice, `Sale ${result.sale?.sale_number || '-'} completed: ${money(result.sale?.total_amount || 0)}.`, 'ok');

        await Promise.all([
            canUsePos() ? loadPosCatalogData() : Promise.resolve(),
            state.permissions.view_operations ? loadRefs() : Promise.resolve(),
            state.permissions.view_operations ? loadOperationsInventory() : Promise.resolve(),
            loadPosRecentSales(),
            loadDashboard(),
            state.permissions.view_reports ? loadReports() : Promise.resolve(),
        ]);
    } catch (err) {
        notice(posNotice, err.message, 'err');
    }
});
const customerNotice = document.getElementById('customerNotice');
document.getElementById('customerCatalogFilter').addEventListener('submit', async (e) => {
    e.preventDefault();
    try {
        const formData = payload(e.target);
        await loadCustomerProducts({
            search: formData.search || '',
            stock_status: formData.stock_status || '',
            sort: formData.sort || 'name_asc',
        });
    } catch (err) {
        notice(customerNotice, err.message, 'err');
    }
});
document.getElementById('customerFilterResetBtn').addEventListener('click', async () => {
    try {
        await loadCustomerProducts({ search: '', stock_status: '', sort: 'name_asc' });
        notice(customerNotice, 'Customer catalog filters reset.', 'ok');
    } catch (err) {
        notice(customerNotice, err.message, 'err');
    }
});
document.getElementById('customerCatalogGrid').addEventListener('click', async (e) => {
    const viewBtn = e.target.closest('.customer-view-product-btn');
    if (viewBtn) {
        try {
            await loadCustomerProductDetail(Number(viewBtn.dataset.productId || 0));
        } catch (err) {
            notice(customerNotice, err.message, 'err');
        }
        return;
    }

    const favoriteBtn = e.target.closest('.customer-favorite-product-btn');
    if (favoriteBtn) {
        try {
            await api('/customer/favorites', {
                method: 'POST',
                body: JSON.stringify({ product_id: Number(favoriteBtn.dataset.productId || 0) }),
            });
            notice(customerNotice, 'Product added to favorites.', 'ok');
            await Promise.all([loadCustomerFavorites(), loadCustomerFavoriteAlerts()]);
        } catch (err) {
            notice(customerNotice, err.message, 'err');
        }
        return;
    }

    const addBtn = e.target.closest('.customer-add-cart-btn');
    if (addBtn) {
        addProductToCustomerCart(Number(addBtn.dataset.productId || 0));
    }
});
document.getElementById('customerSelectedProductCard').addEventListener('click', async (e) => {
    const favoriteBtn = e.target.closest('.customer-favorite-product-btn');
    if (favoriteBtn) {
        try {
            await api('/customer/favorites', {
                method: 'POST',
                body: JSON.stringify({ product_id: Number(favoriteBtn.dataset.productId || 0) }),
            });
            notice(customerNotice, 'Product added to favorites.', 'ok');
            await Promise.all([loadCustomerFavorites(), loadCustomerFavoriteAlerts()]);
        } catch (err) {
            notice(customerNotice, err.message, 'err');
        }
        return;
    }

    const codBtn = e.target.closest('.customer-cod-product-btn');
    if (codBtn) {
        addProductToCustomerCart(Number(codBtn.dataset.productId || 0));
        document.getElementById('customerCheckoutPayment').value = 'cod';
        syncCustomerCheckoutPayment();
        focusCustomerCheckout();
        return;
    }

    const addBtn = e.target.closest('.customer-add-cart-btn');
    if (addBtn) {
        addProductToCustomerCart(Number(addBtn.dataset.productId || 0));
    }
});
function handleCustomerCartAction(e) {
    const qtyBtn = e.target.closest('.customer-cart-qty-btn');
    if (qtyBtn) {
        const productId = Number(qtyBtn.dataset.productId || 0);
        const action = String(qtyBtn.dataset.action || '');
        if (action === 'inc') updateCustomerCartLineQuantity(productId, 1);
        if (action === 'dec') updateCustomerCartLineQuantity(productId, -1);
        return true;
    }

    const removeBtn = e.target.closest('.customer-cart-remove-btn');
    if (removeBtn) {
        removeCustomerCartLine(Number(removeBtn.dataset.productId || 0));
        notice(customerNotice, 'Item removed from cart.', 'ok');
        return true;
    }

    return false;
}
document.getElementById('customerCartRows').addEventListener('click', (e) => {
    handleCustomerCartAction(e);
});
document.getElementById('customerDrawerCartRows').addEventListener('click', (e) => {
    handleCustomerCartAction(e);
});
function handleCustomerCartQuantityChange(e) {
    const qtyInput = e.target.closest('.customer-cart-qty-input');
    if (!qtyInput) return false;
    setCustomerCartLineQuantity(Number(qtyInput.dataset.productId || 0), qtyInput.value);
    return true;
}
document.getElementById('customerCartRows').addEventListener('change', (e) => {
    handleCustomerCartQuantityChange(e);
});
document.getElementById('customerDrawerCartRows').addEventListener('change', (e) => {
    handleCustomerCartQuantityChange(e);
});
document.getElementById('customerMobileCartFab').addEventListener('click', () => {
    if (!(state.customer.cart || []).length) {
        notice(customerNotice, 'Your cart is still empty.', 'err');
        return;
    }
    toggleCustomerCartDrawer(true);
});
document.getElementById('customerCartDrawerBackdrop').addEventListener('click', () => {
    toggleCustomerCartDrawer(false);
});
document.getElementById('customerDrawerCloseBtn').addEventListener('click', () => {
    toggleCustomerCartDrawer(false);
});
document.getElementById('customerDrawerCheckoutBtn').addEventListener('click', () => {
    setCustomerSection('shop');
    focusCustomerCheckout();
});
document.getElementById('customerCheckoutPayment').addEventListener('change', () => {
    syncCustomerCheckoutPayment();
});
document.getElementById('customerSeasonForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    try {
        const p = payload(e.target);
        await loadCustomerSeasonalSuggestions({
            month: String(p.month || new Date().getMonth() + 1),
            limit: String(p.limit || '12'),
        });
        notice(customerNotice, 'Seasonal suggestions loaded.', 'ok');
    } catch (err) {
        notice(customerNotice, err.message, 'err');
    }
});
document.getElementById('customerSeasonRefreshBtn').addEventListener('click', async () => {
    try {
        await loadCustomerSeasonalSuggestions();
        notice(customerNotice, 'Seasonal suggestions refreshed.', 'ok');
    } catch (err) {
        notice(customerNotice, err.message, 'err');
    }
});
document.getElementById('customerRequestForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    try {
        const formData = payload(e.target);
        formData.requested_quantity = Number(formData.requested_quantity || 0);

        await api('/customer/requests', {
            method: 'POST',
            body: JSON.stringify(formData),
        });

        e.target.reset();
        notice(customerNotice, 'Request sent.', 'ok');
        await loadCustomerRequests();
    } catch (err) {
        notice(customerNotice, err.message, 'err');
    }
});
document.getElementById('customerCheckoutForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    if (!(state.customer.cart || []).length) {
        notice(customerNotice, 'Add at least one product to cart before placing an order.', 'err');
        return;
    }

    try {
        const formData = payload(e.target);
        const orderPayload = {
            payment_method: formData.payment_method || 'cod',
            promotion_code: formData.promotion_code || null,
            notes: formData.notes || null,
            items: state.customer.cart.map((line) => ({
                product_id: Number(line.product_id),
                quantity: Number(line.quantity),
            })),
        };

        await api('/customer/orders', {
            method: 'POST',
            body: JSON.stringify(orderPayload),
        });

        state.customer.cart = [];
        e.target.reset();
        document.getElementById('customerCheckoutPayment').value = 'cod';
        syncCustomerCheckoutPayment();
        renderCustomerCart();
        setCustomerSection('orders');
        notice(customerNotice, 'Order placed.', 'ok');
        await Promise.all([loadCustomerOrders(), loadCustomerNotifications()]);
    } catch (err) {
        notice(customerNotice, err.message, 'err');
    }
});
document.getElementById('customerRequestRows').addEventListener('click', async (e) => {
    const cancelButton = e.target.closest('.customer-cancel-btn');
    if (!cancelButton) return;

    const requestId = Number(cancelButton.dataset.requestId || 0);
    if (!requestId) return;

    const confirmedCancel = window.confirm('Cancel this customer request?');
    if (!confirmedCancel) return;

    try {
        await api(`/customer/requests/${requestId}`, { method: 'DELETE' });
        notice(customerNotice, 'Request canceled.', 'ok');
        await loadCustomerRequests();
    } catch (err) {
        notice(customerNotice, err.message, 'err');
    }
});
document.getElementById('customerProfileForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    try {
        const formData = payload(e.target);
        await api('/customer/profile', {
            method: 'PUT',
            body: JSON.stringify(formData),
        });
        notice(customerNotice, 'Profile updated.', 'ok');
        await loadCustomerProfile();
    } catch (err) {
        notice(customerNotice, err.message, 'err');
    }
});
document.getElementById('customerPasswordForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    try {
        const formData = payload(e.target);
        await api('/customer/change-password', {
            method: 'PUT',
            body: JSON.stringify(formData),
        });
        e.target.reset();
        notice(customerNotice, 'Password changed. Please login again.', 'ok');
    } catch (err) {
        notice(customerNotice, err.message, 'err');
    }
});
document.getElementById('customerFavoriteForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    try {
        const formData = payload(e.target);
        await api('/customer/favorites', {
            method: 'POST',
            body: JSON.stringify({ product_id: Number(formData.product_id || 0) }),
        });
        notice(customerNotice, 'Product added to favorites.', 'ok');
        await Promise.all([loadCustomerFavorites(), loadCustomerFavoriteAlerts()]);
    } catch (err) {
        notice(customerNotice, err.message, 'err');
    }
});
document.getElementById('customerFavoriteRows').addEventListener('click', async (e) => {
    const removeBtn = e.target.closest('.customer-favorite-remove-btn');
    if (!removeBtn) return;

    const productId = Number(removeBtn.dataset.productId || 0);
    if (!productId) return;

    try {
        await api(`/customer/favorites/${productId}`, { method: 'DELETE' });
        notice(customerNotice, 'Favorite removed.', 'ok');
        await Promise.all([loadCustomerFavorites(), loadCustomerFavoriteAlerts()]);
    } catch (err) {
        notice(customerNotice, err.message, 'err');
    }
});
document.getElementById('customerReviewForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    try {
        const formData = payload(e.target);
        await api('/customer/reviews', {
            method: 'POST',
            body: JSON.stringify({
                product_id: Number(formData.product_id || 0),
                rating: Number(formData.rating || 5),
                review: formData.review || null,
            }),
        });
        e.target.reset();
        notice(customerNotice, 'Review posted.', 'ok');
    } catch (err) {
        notice(customerNotice, err.message, 'err');
    }
});
document.getElementById('customerTrackingCards').addEventListener('click', async (e) => {
    const reorderBtn = e.target.closest('.customer-reorder-btn');
    if (!reorderBtn) return;
    await addOrderToCustomerCart(Number(reorderBtn.dataset.orderId || 0));
});
document.getElementById('customerOrderRows').addEventListener('click', async (e) => {
    const reorderBtn = e.target.closest('.customer-reorder-btn');
    if (!reorderBtn) return;
    await addOrderToCustomerCart(Number(reorderBtn.dataset.orderId || 0));
});
document.getElementById('customerMarkReadBtn').addEventListener('click', async () => {
    try {
        await api('/customer/notifications/read-all', { method: 'PATCH' });
        notice(customerNotice, 'All notifications marked as read.', 'ok');
        await loadCustomerNotifications();
    } catch (err) {
        notice(customerNotice, err.message, 'err');
    }
});
document.getElementById('userCancelEditBtn').addEventListener('click', () => {
    resetUserForm();
    notice(document.getElementById('userNotice'), 'Edit canceled.', 'ok');
});
document.getElementById('userFilterForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    try {
        setUserManagementSection('directory');
        await loadUsers({
            search: document.getElementById('userSearchInput').value,
            role: document.getElementById('userRoleFilter').value,
        });
    } catch (err) {
        notice(document.getElementById('userNotice'), err.message, 'err');
    }
});
document.getElementById('userFilterResetBtn').addEventListener('click', async () => {
    document.getElementById('userSearchInput').value = '';
    document.getElementById('userRoleFilter').value = '';
    try {
        setUserManagementSection('directory');
        await loadUsers({ search: '', role: '' });
    } catch (err) {
        notice(document.getElementById('userNotice'), err.message, 'err');
    }
});
document.getElementById('userRows').addEventListener('click', async (e) => {
    const editButton = e.target.closest('.user-edit-btn');
    const deleteButton = e.target.closest('.user-delete-btn');

    if (!editButton && !deleteButton) return;

    const userId = Number((editButton || deleteButton).dataset.userId || 0);
    if (!userId) return;

    if (editButton) {
        const user = findUserById(userId);
        if (!user) {
            notice(document.getElementById('userNotice'), 'User was not found in the current list.', 'err');
            return;
        }

        setUserEditMode(user);
        setUserManagementSection('editor');
        notice(document.getElementById('userNotice'), `Editing user: ${user.name}`, 'ok');
        return;
    }

    const user = findUserById(userId);
    if (!user) {
        notice(document.getElementById('userNotice'), 'User was not found in the current list.', 'err');
        return;
    }

    const confirmedDelete = window.confirm(`Delete account for ${user.name}? This cannot be undone.`);
    if (!confirmedDelete) return;

    try {
        await api(`/users/${userId}`, { method: 'DELETE' });
        notice(document.getElementById('userNotice'), 'User deleted.', 'ok');
        resetUserForm();
        await loadUsers();
        await loadSuperAdmin();
    } catch (err) {
        notice(document.getElementById('userNotice'), err.message, 'err');
    }
});
document.getElementById('userForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    const userNotice = document.getElementById('userNotice');

    try {
        const formPayload = payload(e.target);
        const userId = Number(formPayload.user_id || 0);

        delete formPayload.user_id;

        if (!formPayload.password) {
            delete formPayload.password;
        }

        await api(userId ? `/users/${userId}` : '/users', {
            method: userId ? 'PUT' : 'POST',
            body: JSON.stringify(formPayload),
        });

        notice(userNotice, userId ? 'User updated.' : 'User created.', 'ok');
        resetUserForm();
        await loadUsers();
        await loadSuperAdmin();
    } catch (err) {
        notice(userNotice, err.message, 'err');
    }
});

const saNotice = document.getElementById('saNotice');
const reportsNotice = document.getElementById('reportsNotice') || saNotice;
document.getElementById('saActivityFilter').addEventListener('submit', async (e) => {
    e.preventDefault();
    try {
        const p = payload(e.target);
        await loadSuperAdminActivity(p.from || null, p.to || null);
    } catch (err) {
        notice(saNotice, err.message, 'err');
    }
});
document.getElementById('saStaleFilter').addEventListener('submit', async (e) => {
    e.preventDefault();
    try {
        const p = payload(e.target);
        await loadSuperAdminStale(Number(p.days || 45));
    } catch (err) {
        notice(saNotice, err.message, 'err');
    }
});
document.getElementById('saLoginFilter').addEventListener('submit', async (e) => {
    e.preventDefault();
    try {
        const p = payload(e.target);
        await loadSuperAdminLoginActivities({
            action: p.action || '',
            user_id: p.user_id || '',
            from: p.from || '',
            to: p.to || '',
        });
    } catch (err) {
        notice(reportsNotice, err.message, 'err');
    }
});
document.getElementById('saLoginFilterResetBtn').addEventListener('click', async () => {
    try {
        state.superAdmin.loginFilters = { action: '', user_id: '', from: '', to: '' };
        await loadSuperAdminLoginActivities();
    } catch (err) {
        notice(reportsNotice, err.message, 'err');
    }
});
document.getElementById('saAuditFilter').addEventListener('submit', async (e) => {
    e.preventDefault();
    try {
        const p = payload(e.target);
        await loadSuperAdminAuditLogs({
            action: p.action || '',
            user_id: p.user_id || '',
            from: p.from || '',
            to: p.to || '',
        });
    } catch (err) {
        notice(reportsNotice, err.message, 'err');
    }
});
document.getElementById('saAuditFilterResetBtn').addEventListener('click', async () => {
    try {
        state.superAdmin.auditFilters = { action: '', user_id: '', from: '', to: '' };
        await loadSuperAdminAuditLogs();
    } catch (err) {
        notice(reportsNotice, err.message, 'err');
    }
});
document.getElementById('saSettingForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    try {
        const p = payload(e.target);
        await api('/super-admin/system-settings', {
            method: 'PUT',
            body: JSON.stringify({
                key: p.key,
                value: p.value || null,
                description: p.description || null,
            }),
        });
        e.target.reset();
        notice(reportsNotice, 'Setting saved.', 'ok');
        await Promise.all([loadSuperAdminSystemSettings(), loadSuperAdminAuditLogs()]);
    } catch (err) {
        notice(reportsNotice, err.message, 'err');
    }
});
document.getElementById('saBackupExportBtn').addEventListener('click', async () => {
    try {
        await downloadBackupJson();
        notice(reportsNotice, 'Backup JSON downloaded.', 'ok');
    } catch (err) {
        notice(reportsNotice, err.message, 'err');
    }
});
document.getElementById('saUserStatusForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    try {
        const p = payload(e.target);
        await api(`/super-admin/users/${p.user_id}/status`, {
            method: 'PATCH',
            body: JSON.stringify({
                status: p.status,
                revoke_tokens: !!p.revoke_tokens,
            }),
        });
        notice(reportsNotice, 'User status updated.', 'ok');
        await Promise.all([loadUsers(), loadSuperAdminAuditLogs()]);
    } catch (err) {
        notice(reportsNotice, err.message, 'err');
    }
});
document.getElementById('saPermissionForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    try {
        const p = payload(e.target);
        const rawJson = String(p.permissions_json || '').trim();
        let permissions = {};
        if (rawJson) {
            const parsed = JSON.parse(rawJson);
            if (!parsed || typeof parsed !== 'object' || Array.isArray(parsed)) {
                throw new Error('Permissions override must be a JSON object.');
            }
            permissions = parsed;
        }

        await api(`/super-admin/users/${p.user_id}/permissions`, {
            method: 'PATCH',
            body: JSON.stringify({ permissions }),
        });
        notice(reportsNotice, 'Permissions updated.', 'ok');
        await Promise.all([loadUsers(), loadSuperAdminAuditLogs()]);
    } catch (err) {
        notice(reportsNotice, err.message, 'err');
    }
});
document.getElementById('saCreateUserForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    try {
        const p = payload(e.target);
        await api('/super-admin/users', { method: 'POST', body: JSON.stringify(p) });
        e.target.reset();
        notice(saNotice, 'Privileged account created.', 'ok');
        await loadUsers();
        await loadSuperAdmin();
    } catch (err) {
        notice(saNotice, err.message, 'err');
    }
});
document.getElementById('saResetPasswordForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    try {
        const p = payload(e.target);
        await api(`/super-admin/users/${p.user_id}/reset-password`, {
            method: 'POST',
            body: JSON.stringify({ password: p.password, revoke_tokens: true }),
        });
        e.target.reset();
        notice(saNotice, 'Password reset and tokens revoked.', 'ok');
        await loadSuperAdmin();
    } catch (err) {
        notice(saNotice, err.message, 'err');
    }
});
document.getElementById('saRevokeTokensForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    try {
        const p = payload(e.target);
        const res = await api(`/super-admin/users/${p.user_id}/revoke-tokens`, { method: 'POST' });
        notice(saNotice, `Revoked ${res.revoked_tokens || 0} token(s).`, 'ok');
        await loadSuperAdmin();
    } catch (err) {
        notice(saNotice, err.message, 'err');
    }
});
document.getElementById('saBulkRoleForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    try {
        const formData = payload(e.target);
        const selectedUsers = Array.from(document.getElementById('saBulkUsers').selectedOptions).map((o) => Number(o.value));
        if (!selectedUsers.length) {
            throw new Error('Select at least one user for bulk role update.');
        }
        await api('/super-admin/users/bulk-role', {
            method: 'POST',
            body: JSON.stringify({ user_ids: selectedUsers, role: formData.role }),
        });
        notice(saNotice, `Updated ${selectedUsers.length} user role(s).`, 'ok');
        await loadUsers();
        await loadSuperAdmin();
    } catch (err) {
        notice(saNotice, err.message, 'err');
    }
});
document.getElementById('saExportUsersBtn').addEventListener('click', async () => {
    try {
        await downloadUsersCsv();
        notice(saNotice, 'Users CSV export downloaded.', 'ok');
    } catch (err) {
        notice(saNotice, err.message, 'err');
    }
});

(async function init() {
    setAuthMode('login');
    setupResponsiveTableLabels();
    setupSuperAdminPanels();
    if (!state.token) {
        setAuth(false);
        return;
    }
    try {
        await hydrateUser();
        setAuth(true);
        await bootData();
    } catch (_) {
        state.token = '';
        state.user = null;
        state.permissions = {};
        state.users = [];
        state.userFilters = { search: '', role: '' };
        state.customer = {
            products: [],
            requests: [],
            orders: [],
            favorites: [],
            favoriteAlerts: [],
            notifications: [],
            seasonalSuggestions: [],
            seasonalMeta: { month: null, season: '' },
            profile: null,
            filters: { search: '', stock_status: '' },
            seasonalFilters: { month: String(new Date().getMonth() + 1), limit: '12' },
        };
        state.pos = { search: '', cart: [], sales: [], products: [], warehouses: [], warehouseId: '', warehouse: null, lastSale: null };
        state.operations = {
            activeSection: 'setup',
            orderFilters: { status: '', search: '' },
            forecastFilters: { branch_id: '', lookback_days: '60', forecast_days: '30', limit: '20' },
            orders: [],
            branches: [],
            branchOverview: [],
            unassignedWarehouses: [],
            forecast: [],
            forecastMeta: { lookback_days: 60, forecast_days: 30, branch_id: null },
            inventoryFilters: { warehouse_id: '', status: '', search: '', threshold_days: '90' },
            inventorySummary: null,
            inventoryWarehouseSummary: [],
            inventoryBatches: [],
            inventoryAging: [],
            inventoryAgingMeta: { threshold_days: 90, average_age_days: 0, buckets: { fresh: 0, monitor: 0, aging: 0 } },
            promotions: [],
            receipts: [],
            receiptDraftItems: [],
            adjustments: [],
        adjustmentDraft: [],
            editingProductId: null,
            editingPromotionId: null,
            editingBranchId: null,
        };
        state.reports = { activeSection: 'inventory', business: null };
        state.userManagement = { activeSection: 'directory' };
        state.superAdmin = {
            activeSection: 'overview',
            overview: null,
            roles: null,
            activity: null,
            stale: null,
            security: null,
            loginActivities: null,
            auditLogs: null,
            settings: null,
            loginFilters: { action: '', user_id: '', from: '', to: '' },
            auditFilters: { action: '', user_id: '', from: '', to: '' },
        };
    localStorage.removeItem('farm_token');
    localStorage.removeItem('farm_user');
    syncShellMode();
    setAuth(false);
    } finally {
        recoverInterfaceIfHidden(false);
    }
})();
</script>
</body>
</html>























































































































