body.customer-shell-active {
    color: #183127;
    background:
        radial-gradient(1100px 620px at 0% 0%, rgba(157, 204, 170, .22), transparent 58%),
        radial-gradient(900px 540px at 100% 12%, rgba(224, 196, 152, .24), transparent 56%),
        linear-gradient(180deg, #f8f5ee 0%, #f8fbf6 48%, #edf2e9 100%);
}
body.customer-shell-active::before,
body.customer-shell-active::after {
    opacity: .22;
    filter: blur(76px);
}
body.customer-shell-active .live-bg {
    opacity: .3;
    filter: saturate(.72);
}
body.customer-shell-active .live-bg .pointer-aura {
    opacity: .16;
}

.brand {
    display: grid;
    gap: 12px;
}
.brand-lockup {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 0;
}
.brand-logo {
    width: 48px;
    height: 48px;
    border-radius: 16px;
    overflow: hidden;
    flex-shrink: 0;
    box-shadow: 0 14px 26px rgba(11, 37, 52, .16);
}
.brand-logo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}
.brand-copy {
    display: grid;
    gap: 4px;
    min-width: 0;
}
.brand-copy h3 {
    margin: 0;
}
.brand-copy p {
    margin: 0;
}
.brand-mode-pill {
    display: none;
    align-items: center;
    width: fit-content;
    padding: 6px 10px;
    border-radius: 999px;
    border: 1px solid rgba(24, 49, 39, .08);
    background: rgba(244, 248, 241, .96);
    color: #355144;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: .1em;
    text-transform: uppercase;
}

.shell.customer-shell {
    grid-template-columns: 1fr;
    width: min(100%, 1500px);
    gap: 18px;
    padding: 18px;
}
.shell.customer-shell::before {
    background: radial-gradient(560px circle at var(--fx-x) var(--fx-y), rgba(74, 158, 119, .12), rgba(214, 179, 111, .08) 42%, transparent 72%);
}
.shell.customer-shell .sidebar {
    position: relative;
    top: auto;
    height: auto;
    padding: 20px 22px;
    display: grid;
    grid-template-columns: minmax(250px, .92fr) minmax(0, 1.08fr);
    align-items: center;
    gap: 16px;
    border-radius: 28px;
    background: linear-gradient(145deg, rgba(255, 255, 255, .94), rgba(244, 248, 241, .96));
    border: 1px solid rgba(24, 49, 39, .08);
    box-shadow: 0 24px 48px rgba(35, 58, 44, .12);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
}
.shell.customer-shell .brand {
    margin: 0;
    padding: 0;
    border: none;
    align-items: flex-start;
}
.shell.customer-shell .brand-copy h3 {
    color: #183127;
    font-size: 24px;
    letter-spacing: -.03em;
}
.shell.customer-shell .brand-copy p {
    color: #5c7065;
    font-size: 12px;
    letter-spacing: .12em;
    text-transform: uppercase;
}
.shell.customer-shell .brand-mode-pill {
    display: inline-flex;
}
.shell.customer-shell .menu {
    display: flex;
    justify-content: flex-end;
    flex-wrap: wrap;
    gap: 10px;
}
.shell.customer-shell .menu button {
    width: auto;
    min-width: max-content;
    padding: 12px 16px;
    border-radius: 999px;
    background: #eef5ef;
    border: 1px solid rgba(24, 49, 39, .08);
    color: #355144;
    font-weight: 700;
    box-shadow: none;
}
.shell.customer-shell .menu button.active,
.shell.customer-shell .menu button:hover {
    background: linear-gradient(135deg, #1e7759, #329676);
    border-color: transparent;
    color: #f7fcf8;
    box-shadow: 0 14px 24px rgba(30, 119, 89, .18);
}
.shell.customer-shell .main {
    padding: 0;
    gap: 18px;
}
.shell.customer-shell .top {
    display: grid;
    grid-template-columns: minmax(0, 1fr) auto;
    align-items: start;
    gap: 16px;
    padding: 22px 24px;
    border-radius: 28px;
    background: linear-gradient(145deg, rgba(255, 255, 255, .94), rgba(244, 248, 241, .96));
    border: 1px solid rgba(24, 49, 39, .08);
    box-shadow: 0 24px 44px rgba(35, 58, 44, .1);
}
.shell.customer-shell .top h2 {
    font-size: clamp(28px, 3.2vw, 40px);
    color: #183127;
    letter-spacing: -.04em;
}
.shell.customer-shell .top p {
    color: #5c7065;
    max-width: 720px;
}
.shell.customer-shell .top .actions {
    justify-content: flex-end;
}
.shell.customer-shell .userbox {
    background: #f4f8f4;
    border: 1px solid rgba(24, 49, 39, .08);
    color: #244136;
    border-radius: 16px;
    padding: 12px 14px;
}
.shell.customer-shell button::before,
.shell.customer-shell button::after {
    display: none;
}
.shell.customer-shell button:hover {
    transform: translateY(-1px);
    filter: none;
}
.shell.customer-shell button:not(.menu-btn):not(.pwd-toggle):not(:disabled) {
    animation: none;
}
.shell.customer-shell button:not(.menu-btn):not(.pwd-toggle):not(.btn-inline):not(.secondary):not(.danger):not(:disabled),
.shell.customer-shell .customer-home-actions button:not(.secondary),
.shell.customer-shell #customerCheckoutBtn,
.shell.customer-shell #customerDrawerCheckoutBtn {
    background: linear-gradient(135deg, #1f7a5b, #319778);
    color: #ffffff;
    border-color: transparent;
    box-shadow: 0 16px 28px rgba(31, 122, 91, .18);
}
.shell.customer-shell button.secondary,
.shell.customer-shell .btn-inline.secondary {
    background: #eef5ef;
    color: #173328;
    border: 1px solid rgba(24, 49, 39, .12);
    box-shadow: none;
}
.shell.customer-shell button.danger {
    background: linear-gradient(135deg, #b64652, #d45d67);
    border-color: transparent;
    color: #ffffff;
    box-shadow: 0 16px 28px rgba(167, 71, 84, .18);
}
.shell.customer-shell .card {
    background: rgba(255, 255, 255, .88);
    border-color: rgba(24, 49, 39, .08);
    box-shadow: 0 18px 36px rgba(35, 58, 44, .1);
}
.shell.customer-shell .card::before {
    background:
        radial-gradient(360px 100px at -8% -10%, rgba(92, 177, 133, .08), transparent 62%),
        radial-gradient(320px 120px at 108% 112%, rgba(226, 194, 129, .08), transparent 66%);
    animation: none;
    opacity: 1;
}
.shell.customer-shell .card:hover {
    box-shadow: 0 22px 42px rgba(35, 58, 44, .12);
    border-color: rgba(30, 119, 89, .16);
}
.shell.customer-shell .title {
    color: #183127;
}
.shell.customer-shell .muted {
    color: #5c7065;
}
.shell.customer-shell input,
.shell.customer-shell select,
.shell.customer-shell textarea {
    background: #ffffff;
    color: #183127;
    border: 1px solid rgba(24, 49, 39, .12);
    box-shadow: none;
}
.shell.customer-shell input::placeholder,
.shell.customer-shell textarea::placeholder {
    color: #8aa194;
}
.shell.customer-shell input:focus,
.shell.customer-shell select:focus,
.shell.customer-shell textarea:focus {
    border-color: rgba(31, 122, 91, .34);
    box-shadow: 0 0 0 4px rgba(31, 122, 91, .08);
}
.shell.customer-shell .chip {
    background: #f5faf4;
    border-color: rgba(24, 49, 39, .08);
    color: #355144;
}
.shell.customer-shell .chip strong {
    color: #173328;
}
.shell.customer-shell .customer-home-hero {
    background:
        linear-gradient(145deg, rgba(255, 255, 255, .95), rgba(245, 248, 241, .98)),
        radial-gradient(circle at top right, rgba(100, 173, 127, .14), transparent 38%);
    border-color: rgba(24, 49, 39, .08);
}
.shell.customer-shell .customer-home-copy h3 {
    color: #183127;
    font-size: clamp(34px, 4vw, 54px);
    max-width: 10ch;
}
.shell.customer-shell .customer-home-copy p {
    color: #5c7065;
    max-width: 60ch;
}
.shell.customer-shell .customer-home-profile {
    background: #f8fbf7;
    border-color: rgba(24, 49, 39, .08);
}
.shell.customer-shell .customer-home-detail,
.shell.customer-shell .customer-home-mini-item {
    background: #ffffff;
    border-color: rgba(24, 49, 39, .08);
}
.shell.customer-shell .customer-home-detail span,
.shell.customer-shell .customer-home-tag,
.shell.customer-shell .customer-home-mini-item span {
    color: #5b7768;
}
.shell.customer-shell .customer-home-detail strong,
.shell.customer-shell .customer-home-mini-item strong {
    color: #183127;
}
.shell.customer-shell .customer-home-tag {
    background: #eff5ef;
    border-color: rgba(24, 49, 39, .08);
    color: #244236;
}
.shell.customer-shell .customer-layout-nav {
    border-color: rgba(26, 84, 64, .18);
    background: linear-gradient(135deg, rgba(20, 82, 63, .96), rgba(37, 117, 87, .94));
    box-shadow: 0 24px 42px rgba(20, 64, 49, .18);
}
.shell.customer-shell .customer-layout-nav .title,
.shell.customer-shell .customer-layout-nav .muted,
.shell.customer-shell .customer-layout-nav .hero-eyebrow {
    color: #f4fbf5;
}
.shell.customer-shell .customer-layout-nav .hero-eyebrow {
    background: rgba(255, 255, 255, .12);
    border-color: rgba(255, 255, 255, .14);
}
.shell.customer-shell .customer-layout-nav .chip {
    background: rgba(255, 255, 255, .12);
    border-color: rgba(255, 255, 255, .12);
    color: #e4f2ea;
}
.shell.customer-shell .customer-layout-nav .chip strong {
    color: #ffffff;
}
.shell.customer-shell .op-layout-tabs {
    gap: 10px;
}
.shell.customer-shell .op-layout-tabs button {
    background: rgba(255, 255, 255, .1);
    border-color: rgba(255, 255, 255, .12);
    color: #e4f2ea;
    padding: 10px 14px;
    border-radius: 999px;
}
.shell.customer-shell .op-layout-tabs button.active {
    background: #f8fbf8;
    color: #173328;
    box-shadow: none;
}
.shell.customer-shell .customer-inline-note {
    background: #eff6ef;
    border-color: rgba(24, 49, 39, .08);
    color: #224136;
}
.shell.customer-shell .customer-product-card {
    background: #ffffff;
    border-color: rgba(24, 49, 39, .08);
    box-shadow: 0 14px 30px rgba(35, 58, 44, .08);
}
.shell.customer-shell .customer-product-card.active {
    border-color: rgba(39, 122, 92, .26);
    box-shadow: 0 18px 34px rgba(35, 58, 44, .12);
}
.shell.customer-shell .customer-product-cover {
    background: linear-gradient(135deg, #376d5c, #63ad86);
}
.shell.customer-shell .customer-product-name {
    color: #183127;
}
.shell.customer-shell .customer-product-meta,
.shell.customer-shell .customer-product-copy {
    color: #5d7066;
}
.shell.customer-shell .customer-product-price-row {
    background: #f5f8f4;
    border-color: rgba(24, 49, 39, .08);
    color: #4d6557;
}
.shell.customer-shell .customer-product-price-row strong {
    color: #173328;
}
.shell.customer-shell .customer-spotlight-hero {
    background: linear-gradient(135deg, #2b7659, #62ad86);
}
.shell.customer-shell .customer-spotlight-copy {
    color: rgba(247, 252, 248, .9);
}
.shell.customer-shell .customer-meta-card,
.shell.customer-shell .customer-address-box,
.shell.customer-shell .customer-review-item,
.shell.customer-shell .customer-empty-state,
.shell.customer-shell .customer-cart-item,
.shell.customer-shell .customer-tracking-card {
    background: #f8fbf7;
    border-color: rgba(24, 49, 39, .08);
}
.shell.customer-shell .customer-meta-card strong,
.shell.customer-shell .customer-address-box strong {
    color: #5b7768;
}
.shell.customer-shell .customer-meta-card span,
.shell.customer-shell .customer-address-box span,
.shell.customer-shell .customer-empty-state,
.shell.customer-shell .customer-tracking-meta {
    color: #3b5648;
}
.shell.customer-shell .customer-empty-state strong,
.shell.customer-shell .customer-cart-line-title,
.shell.customer-shell .customer-tracking-items {
    color: #183127;
}
.shell.customer-shell .customer-cart-line-price,
.shell.customer-shell .customer-qty-value {
    color: #173328;
}
.shell.customer-shell .table {
    background: #ffffff;
    border-color: rgba(24, 49, 39, .08);
}
.shell.customer-shell th {
    background: #f1f6f0;
    color: #4b6558;
}
.shell.customer-shell td {
    color: #264034;
    border-bottom: 1px solid rgba(24, 49, 39, .08);
}
.shell.customer-shell .badge.ok {
    color: #1f6d51;
    background: rgba(61, 157, 119, .12);
    border-color: rgba(61, 157, 119, .22);
}
.shell.customer-shell .badge.low {
    color: #7b5b1f;
    background: rgba(210, 176, 109, .16);
    border-color: rgba(210, 176, 109, .22);
}
.shell.customer-shell .badge.out {
    color: #9f3b46;
    background: rgba(212, 93, 103, .12);
    border-color: rgba(212, 93, 103, .2);
}
.shell.customer-shell .customer-mobile-cart-fab {
    background: linear-gradient(135deg, #1f7a5b, #319778);
    box-shadow: 0 20px 32px rgba(31, 122, 91, .24);
}
.shell.customer-shell .customer-cart-drawer-backdrop {
    background: rgba(16, 33, 25, .26);
}
.shell.customer-shell .customer-cart-drawer-panel {
    background: linear-gradient(180deg, rgba(255, 255, 255, .98), rgba(244, 248, 241, .98));
    border-color: rgba(24, 49, 39, .08);
    box-shadow: 0 24px 40px rgba(35, 58, 44, .18);
}
.shell.customer-shell .customer-cart-drawer-panel .title {
    color: #183127;
}
.shell.customer-shell .customer-cart-drawer-panel .muted {
    color: #5c7065;
}

@media (max-width: 1100px) {
    .shell.customer-shell .sidebar,
    .shell.customer-shell .top {
        grid-template-columns: 1fr;
    }
    .shell.customer-shell .menu,
    .shell.customer-shell .top .actions {
        justify-content: flex-start;
    }
}

@media (max-width: 760px) {
    .shell.customer-shell {
        padding: 12px;
        gap: 14px;
    }
    .shell.customer-shell .sidebar,
    .shell.customer-shell .top,
    .shell.customer-shell .card {
        border-radius: 22px;
    }
    .shell.customer-shell .menu {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
    .shell.customer-shell .menu button {
        width: 100%;
        min-width: 0;
        text-align: center;
        justify-content: center;
    }
    .shell.customer-shell .customer-home-copy h3 {
        max-width: none;
    }
    .shell.customer-shell .customer-home-metrics,
    .shell.customer-shell .customer-kpi-strip {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 560px) {
    .shell.customer-shell .menu {
        grid-template-columns: 1fr;
    }
    .shell.customer-shell .customer-home-metrics,
    .shell.customer-shell .customer-kpi-strip {
        grid-template-columns: 1fr;
    }
    .shell.customer-shell .top .actions {
        width: 100%;
    }
    .shell.customer-shell .top .actions > * {
        width: 100%;
    }
}

.brand-logo {
    display: grid;
    place-items: center;
    width: 52px;
    height: 52px;
    aspect-ratio: 1 / 1;
    border-radius: 16px;
    overflow: hidden;
    flex-shrink: 0;
    background: transparent;
    box-shadow: 0 14px 26px rgba(11, 37, 52, .16);
}
.brand-logo svg,
.brand-logo img {
    width: 100%;
    height: 100%;
    display: block;
    object-fit: contain;
}
@media (max-width: 760px) {
    .brand-logo {
        width: 46px;
        height: 46px;
    }
}

.brand-logo{
    display:grid;
    place-items:center;
    width:52px;
    height:52px;
    aspect-ratio:1 / 1;
    padding:0;
    border-radius:18px;
    border:1px solid rgba(24,49,39,.08);
    background:rgba(255,255,255,.98);
    box-shadow:0 16px 30px rgba(13,38,53,.14);
    overflow:hidden;
}
.brand-logo svg,.brand-logo img{
    width:100%;
    height:100%;
    display:block;
    object-fit:contain;
    border-radius:18px;
}
@media (max-width:760px){.brand-logo{width:46px;height:46px}}

/* Final logo fix: remove the extra white tile and show only the brand mark */
.brand-logo{
    width:42px !important;
    height:42px !important;
    aspect-ratio:1 / 1;
    padding:0 !important;
    border:none !important;
    background:transparent !important;
    box-shadow:none !important;
    border-radius:0 !important;
    overflow:visible !important;
    display:grid !important;
    place-items:center !important;
}
.brand-logo svg,
.brand-logo img{
    width:42px !important;
    height:42px !important;
    display:block !important;
    object-fit:cover !important;
    border-radius:12px !important;
    box-shadow:0 10px 18px rgba(13,38,53,.16) !important;
}
@media (max-width:760px){
    .brand-logo,
    .brand-logo svg,
    .brand-logo img{
        width:38px !important;
        height:38px !important;
    }
}

/* Clean customer header emblem */
.brand-emblem{
    width:42px;
    height:42px;
    aspect-ratio:1 / 1;
    flex-shrink:0;
    display:grid;
    place-items:center;
    background:transparent;
    border:none;
    border-radius:0;
    box-shadow:none;
    overflow:visible;
}
.brand-emblem svg,
.brand-emblem img{
    width:42px;
    height:42px;
    display:block;
    object-fit:cover;
    border-radius:12px;
    box-shadow:0 10px 18px rgba(13,38,53,.16);
}
@media (max-width:760px){
    .brand-emblem,
    .brand-emblem svg,
    .brand-emblem img{
        width:38px;
        height:38px;
    }
}

/* Customer UX refinement */
.shell.customer-shell .customer-home-copy h3 {
    font-size: clamp(30px, 3.4vw, 44px);
    max-width: 11ch;
}
.shell.customer-shell .customer-layout-nav {
    display: grid;
    gap: 14px;
}
.shell.customer-shell .customer-guide-helper {
    padding: 12px 14px;
    border-radius: 18px;
    border: 1px solid rgba(255, 255, 255, .16);
    background: rgba(255, 255, 255, .1);
    color: #eef8f0;
    font-size: 13px;
    line-height: 1.5;
}
.shell.customer-shell .customer-home-step-list {
    display: grid;
    gap: 10px;
}
.shell.customer-shell .customer-home-step {
    display: grid;
    gap: 4px;
    padding: 12px 14px;
    border-radius: 16px;
    border: 1px solid rgba(24, 49, 39, .08);
    background: #ffffff;
}
.shell.customer-shell .customer-home-step strong {
    color: #183127;
    font-size: 14px;
}
.shell.customer-shell .customer-home-step span {
    color: #5d7066;
    font-size: 13px;
    line-height: 1.5;
}
.shell.customer-shell .customer-shop-grid {
    grid-template-columns: minmax(0, 1.12fr) minmax(340px, .88fr);
    align-items: start;
}
.shell.customer-shell .customer-side-grid {
    gap: 16px;
    align-content: start;
}
.shell.customer-shell .customer-product-copy {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
    overflow: hidden;
    min-height: 42px;
}
.shell.customer-shell .customer-spotlight-title {
    font-size: clamp(28px, 2.4vw, 38px);
}
.shell.customer-shell .customer-cart-item {
    gap: 10px;
}
.shell.customer-shell .customer-qty-controls {
    display: grid;
    grid-template-columns: auto 88px auto;
    align-items: center;
    gap: 8px;
}
.shell.customer-shell .customer-cart-qty-input {
    width: 100%;
    min-height: 40px;
    padding: 8px 10px;
    border-radius: 12px;
    border: 1px solid rgba(24, 49, 39, .12);
    background: #ffffff;
    color: #173328;
    text-align: center;
    font-weight: 700;
}
.shell.customer-shell .customer-cart-qty-input:focus {
    border-color: rgba(31, 122, 91, .34);
    box-shadow: 0 0 0 4px rgba(31, 122, 91, .08);
    outline: none;
}

@media (max-width: 980px) {
    .shell.customer-shell .customer-shop-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 640px) {
    .shell.customer-shell .customer-qty-controls {
        grid-template-columns: 1fr;
    }
    .shell.customer-shell .customer-home-copy h3 {
        max-width: none;
    }
}

/* Softer customer text contrast */
body.customer-shell-active {
    color: #243f34;
}
.shell.customer-shell .brand-copy h3,
.shell.customer-shell .top h2,
.shell.customer-shell .title,
.shell.customer-shell .customer-home-copy h3,
.shell.customer-shell .customer-product-name,
.shell.customer-shell .customer-empty-state strong,
.shell.customer-shell .customer-cart-line-title,
.shell.customer-shell .customer-tracking-items {
    color: #243f34;
}
.shell.customer-shell .brand-copy p,
.shell.customer-shell .top p,
.shell.customer-shell .muted,
.shell.customer-shell .customer-home-copy p,
.shell.customer-shell .customer-product-meta,
.shell.customer-shell .customer-product-copy,
.shell.customer-shell .customer-meta-card span,
.shell.customer-shell .customer-address-box span,
.shell.customer-shell .customer-tracking-meta,
.shell.customer-shell .customer-home-detail span,
.shell.customer-shell .customer-home-tag,
.shell.customer-shell .customer-home-mini-item span {
    color: #6a7f73;
}
.shell.customer-shell td {
    color: #305045;
}
