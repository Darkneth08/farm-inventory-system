body.staff-shell-active {
    color: #17253a;
    background:
        radial-gradient(1100px 620px at 0% 0%, rgba(107, 189, 183, .18), transparent 58%),
        radial-gradient(920px 540px at 100% 10%, rgba(244, 199, 112, .16), transparent 56%),
        linear-gradient(180deg, #eef3f6 0%, #f7faf8 48%, #e8eef2 100%);
}
body.staff-shell-active::before,
body.staff-shell-active::after {
    opacity: .18;
    filter: blur(74px);
}
body.staff-shell-active .live-bg {
    opacity: .24;
    filter: saturate(.7);
}
body.staff-shell-active .live-bg .pointer-aura {
    opacity: .14;
}

.shell.staff-shell {
    grid-template-columns: 310px minmax(0, 1fr);
    width: min(100%, 1540px);
    gap: 18px;
    padding: 18px;
}
.shell.staff-shell::before {
    background: radial-gradient(620px circle at var(--fx-x) var(--fx-y), rgba(70, 156, 150, .12), rgba(244, 199, 112, .08) 40%, transparent 74%);
}
.shell.staff-shell .sidebar {
    position: sticky;
    top: 18px;
    height: calc(100vh - 36px);
    padding: 22px;
    border-radius: 30px;
    background: linear-gradient(180deg, rgba(255, 255, 255, .92), rgba(245, 249, 248, .96));
    border: 1px solid rgba(23, 37, 58, .08);
    box-shadow: 0 26px 44px rgba(32, 54, 73, .12);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
}
.shell.staff-shell .brand {
    gap: 14px;
    padding-bottom: 18px;
    border-bottom: 1px solid rgba(23, 37, 58, .08);
}
.shell.staff-shell .brand-copy h3 {
    color: #16253a;
    font-size: 20px;
    line-height: 1.05;
    letter-spacing: -.03em;
}
.shell.staff-shell .brand-copy p {
    color: #5f7286;
    font-size: 12px;
    line-height: 1.45;
}
.shell.staff-shell .brand-mode-pill {
    display: inline-flex;
    background: rgba(38, 130, 120, .08);
    border-color: rgba(38, 130, 120, .14);
    color: #246d66;
}
.shell.staff-shell .menu {
    display: grid;
    gap: 10px;
}
.shell.staff-shell .menu button {
    width: 100%;
    text-align: left;
    padding: 14px 16px;
    border-radius: 18px;
    background: #f2f6f7;
    border: 1px solid rgba(23, 37, 58, .08);
    color: #365063;
    box-shadow: none;
    position: relative;
}
.shell.staff-shell .menu button::before,
.shell.staff-shell .menu button::after {
    display: none;
}
.shell.staff-shell .menu button:hover,
.shell.staff-shell .menu button.active {
    background: linear-gradient(135deg, #1f7d74, #2f998f);
    border-color: transparent;
    color: #f8fbfc;
    box-shadow: 0 18px 28px rgba(31, 125, 116, .16);
    transform: translateY(-1px);
}
.shell.staff-shell .main {
    padding: 0;
    gap: 18px;
}
.shell.staff-shell .top {
    display: grid;
    grid-template-columns: minmax(0, 1fr) auto;
    align-items: start;
    gap: 16px;
    padding: 26px 28px;
    border-radius: 30px;
    background:
        radial-gradient(340px 140px at 0% 0%, rgba(94, 182, 175, .16), transparent 72%),
        linear-gradient(145deg, rgba(255, 255, 255, .94), rgba(245, 249, 248, .96));
    border: 1px solid rgba(23, 37, 58, .08);
    box-shadow: 0 26px 44px rgba(32, 54, 73, .1);
}
.shell.staff-shell .top h2 {
    color: #16253a;
    font-size: clamp(30px, 3.4vw, 44px);
    letter-spacing: -.05em;
}
.shell.staff-shell .top p {
    color: #5f7286;
    max-width: 760px;
}
.shell.staff-shell .top .actions {
    justify-content: flex-end;
}
.shell.staff-shell .userbox {
    background: #f2f6f7;
    border: 1px solid rgba(23, 37, 58, .08);
    color: #22374c;
    border-radius: 18px;
    padding: 12px 14px;
}
.shell.staff-shell button:not(.menu-btn):not(.pwd-toggle):not(:disabled) {
    animation: none;
}
.shell.staff-shell button.secondary,
.shell.staff-shell .btn-inline.secondary {
    background: #f0f5f7;
    color: #1c3347;
    border: 1px solid rgba(23, 37, 58, .12);
    box-shadow: none;
}
.shell.staff-shell button.danger {
    background: linear-gradient(135deg, #c6525c, #dd6b74);
    border-color: transparent;
    color: #fff;
    box-shadow: 0 14px 24px rgba(198, 82, 92, .18);
}
.shell.staff-shell button:not(.menu-btn):not(.pwd-toggle):not(.btn-inline):not(.secondary):not(.danger):not(:disabled) {
    background: linear-gradient(135deg, #1f7d74, #2f998f);
    border-color: transparent;
    color: #fff;
    box-shadow: 0 16px 28px rgba(31, 125, 116, .16);
}
.shell.staff-shell .card {
    background: rgba(255, 255, 255, .9);
    border-color: rgba(23, 37, 58, .08);
    box-shadow: 0 18px 34px rgba(32, 54, 73, .08);
}
.shell.staff-shell .card::before {
    background:
        radial-gradient(360px 100px at -8% -10%, rgba(94, 182, 175, .08), transparent 62%),
        radial-gradient(300px 120px at 108% 112%, rgba(244, 199, 112, .08), transparent 66%);
    opacity: 1;
    animation: none;
}
.shell.staff-shell .title {
    color: #16253a;
}
.shell.staff-shell .muted {
    color: #617689;
}
.shell.staff-shell input,
.shell.staff-shell select,
.shell.staff-shell textarea {
    background: rgba(242, 246, 247, .9);
    border-color: rgba(23, 37, 58, .1);
    color: #183047;
}
.shell.staff-shell input::placeholder,
.shell.staff-shell textarea::placeholder {
    color: #738597;
}
.shell.staff-shell input:focus,
.shell.staff-shell select:focus,
.shell.staff-shell textarea:focus {
    border-color: rgba(47, 153, 143, .5);
    box-shadow: 0 0 0 3px rgba(47, 153, 143, .14);
}
.shell.staff-shell .chip {
    background: #f5f8f8;
    border-color: rgba(23, 37, 58, .08);
}
.shell.staff-shell .chip strong {
    color: #16253a;
}
.shell.staff-shell .op-layout-tabs {
    background: #f3f7f8;
    border-color: rgba(23, 37, 58, .08);
}
.shell.staff-shell .op-layout-tabs button {
    background: transparent;
    color: #4d6478;
}
.shell.staff-shell .op-layout-tabs button.active {
    background: linear-gradient(135deg, #1f7d74, #2f998f);
    color: #fff;
}

.staff-home-shell {
    display: grid;
    gap: 18px;
}
.staff-home-hero {
    display: grid;
    grid-template-columns: minmax(0, 1.1fr) minmax(300px, .9fr);
    gap: 18px;
    padding: 28px;
    border-radius: 30px;
}
.staff-home-copy {
    display: grid;
    gap: 16px;
    align-content: start;
}
.staff-home-copy h3 {
    margin: 0;
    font-family: Sora, Manrope, sans-serif;
    font-size: clamp(32px, 4vw, 48px);
    line-height: 1.02;
    letter-spacing: -.05em;
    color: #16253a;
    max-width: 11ch;
}
.staff-home-copy p {
    margin: 0;
    color: #5f7286;
    line-height: 1.75;
    max-width: 62ch;
}
.staff-home-primary,
.staff-home-alerts {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}
.staff-home-primary {
    align-items: center;
    gap: 14px;
}
.staff-home-primary button {
    width: auto;
}
.staff-home-note {
    margin: 0;
    font-size: 13px;
    line-height: 1.65;
    color: #587086;
    max-width: 28rem;
}
.staff-home-alerts span {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 14px;
    border-radius: 999px;
    background: rgba(31, 125, 116, .08);
    border: 1px solid rgba(31, 125, 116, .12);
    color: #256a63;
    font-size: 12px;
    font-weight: 700;
}
.staff-home-alerts span::before {
    content: "";
    width: 8px;
    height: 8px;
    border-radius: 999px;
    background: #2f998f;
}
.staff-home-metrics {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 12px;
}
.staff-home-metric {
    padding: 18px;
    border-radius: 22px;
    background: linear-gradient(180deg, rgba(247, 250, 251, .98), rgba(239, 245, 246, .96));
    border: 1px solid rgba(23, 37, 58, .08);
    box-shadow: inset 0 1px 0 rgba(255, 255, 255, .7);
}
.staff-home-metric span {
    display: block;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: .1em;
    font-weight: 800;
    color: #6b7f92;
}
.staff-home-metric strong {
    display: block;
    margin-top: 10px;
    font-family: Sora, Manrope, sans-serif;
    font-size: clamp(28px, 2.8vw, 36px);
    line-height: 1;
    color: #16253a;
}
.staff-home-metric small {
    display: block;
    margin-top: 8px;
    color: #617689;
    line-height: 1.55;
}
.staff-home-focus {
    display: grid;
    gap: 12px;
}
.staff-home-panel {
    display: grid;
    gap: 16px;
    align-content: start;
    padding: 22px;
    border-radius: 24px;
    background:
        radial-gradient(260px 140px at 100% 0%, rgba(94, 182, 175, .12), transparent 74%),
        linear-gradient(180deg, rgba(247, 250, 251, .98), rgba(239, 245, 246, .96));
    border: 1px solid rgba(23, 37, 58, .08);
}
.staff-home-panel h4 {
    margin: 0;
    font-family: Sora, Manrope, sans-serif;
    font-size: 22px;
    letter-spacing: -.03em;
    color: #16253a;
}
.staff-home-panel p {
    margin: 0;
    color: #617689;
    line-height: 1.7;
}
.staff-home-panel .chip-grid {
    margin-top: 2px;
}
.staff-home-flow {
    display: grid;
    gap: 10px;
}
.staff-home-flow-item {
    display: grid;
    gap: 6px;
    padding: 14px 16px;
    border-radius: 18px;
    background: #f4f8f9;
    border: 1px solid rgba(23, 37, 58, .08);
}
.staff-home-flow-item strong {
    color: #16253a;
    font-size: 14px;
}
.staff-home-flow-item span {
    color: #556b7f;
    line-height: 1.6;
}
.staff-home-grid {
    display: grid;
    grid-template-columns: minmax(0, 1.04fr) minmax(300px, .96fr);
    gap: 18px;
}
.staff-home-stack {
    display: grid;
    gap: 18px;
}
.staff-home-list {
    display: grid;
    gap: 10px;
}
.staff-home-list-item {
    display: grid;
    gap: 6px;
    padding: 14px 16px;
    border-radius: 18px;
    background: #f4f8f9;
    border: 1px solid rgba(23, 37, 58, .08);
}
.staff-home-list-item strong {
    color: #16253a;
}
.staff-home-list-item small {
    color: #617689;
    line-height: 1.55;
}
.staff-home-mini-table .table {
    margin-top: 0;
}
.staff-home-empty {
    padding: 16px;
    border-radius: 18px;
    background: #f4f8f9;
    border: 1px dashed rgba(23, 37, 58, .12);
    color: #617689;
}
.shell.staff-shell .staff-home-shell .table tr {
    background: #f8fbfb;
    border-color: rgba(23, 37, 58, .08);
}

@media (max-width: 1240px) {
    .shell.staff-shell {
        grid-template-columns: 1fr;
    }
    .shell.staff-shell .sidebar {
        position: relative;
        top: auto;
        height: auto;
        display: grid;
        grid-template-columns: minmax(240px, .86fr) minmax(0, 1.14fr);
        align-items: center;
        gap: 16px;
    }
    .shell.staff-shell .menu {
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-end;
    }
    .shell.staff-shell .menu button {
        width: auto;
    }
}
@media (max-width: 980px) {
    .staff-home-hero,
    .staff-home-grid {
        grid-template-columns: 1fr;
    }
    .staff-home-metrics {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}
@media (max-width: 760px) {
    .shell.staff-shell {
        padding: 14px;
    }
    .shell.staff-shell .sidebar,
    .shell.staff-shell .top,
    .staff-home-hero,
    .staff-home-panel {
        padding: 20px;
        border-radius: 24px;
    }
    .shell.staff-shell .sidebar {
        grid-template-columns: 1fr;
    }
    .shell.staff-shell .menu {
        justify-content: flex-start;
    }
    .shell.staff-shell .top {
        grid-template-columns: 1fr;
    }
    .staff-home-metrics {
        grid-template-columns: 1fr;
    }
    .staff-home-primary,
    .staff-home-alerts {
        flex-direction: column;
        align-items: stretch;
    }
    .staff-home-primary button {
        width: 100%;
    }
}

.shell.staff-shell,
.shell.staff-shell .table,
.shell.staff-shell table,
.shell.staff-shell td {
    color: #203448;
}
.shell.staff-shell .muted,
.shell.staff-shell .brand-copy p,
.shell.staff-shell .top p,
.shell.staff-shell .footer-note,
.shell.staff-shell .inventory-subtle,
.staff-home-copy p,
.staff-home-panel p,
.staff-home-metric small,
.staff-home-list-item small,
.staff-home-empty {
    color: #4f6478;
}
.shell.staff-shell th,
.shell.staff-shell label,
.shell.staff-shell .userbox span,
.shell.staff-shell .chip span,
.staff-home-metric span {
    color: #5b7084;
}
.shell.staff-shell .menu button,
.shell.staff-shell input,
.shell.staff-shell select,
.shell.staff-shell textarea,
.shell.staff-shell .chip,
.staff-home-alerts span,
.staff-home-list-item {
    color: #22384d;
}
.staff-home-alerts span {
    background: rgba(31, 125, 116, .12);
    border-color: rgba(31, 125, 116, .18);
}

/* Softer staff text contrast */
.shell.staff-shell,
.shell.staff-shell .title,
.staff-home-copy h3,
.staff-home-panel h4,
.staff-home-metric strong,
.staff-home-list-item strong {
    color: #25394d;
}
.shell.staff-shell .muted,
.shell.staff-shell .brand-copy p,
.shell.staff-shell .top p,
.shell.staff-shell .footer-note,
.shell.staff-shell .inventory-subtle,
.staff-home-copy p,
.staff-home-panel p,
.staff-home-metric small,
.staff-home-list-item small,
.staff-home-empty,
.shell.staff-shell th,
.shell.staff-shell label,
.shell.staff-shell .userbox span,
.shell.staff-shell .chip span,
.staff-home-metric span {
    color: #6d8193;
}
.shell.staff-shell td,
.shell.staff-shell .menu button,
.shell.staff-shell input,
.shell.staff-shell select,
.shell.staff-shell textarea,
.shell.staff-shell .chip,
.staff-home-alerts span,
.staff-home-list-item {
    color: #294055;
}


