(() => {
    const authSection = document.getElementById('authSection');
    const appSection = document.getElementById('appSection');
    const authModal = document.getElementById('publicAuthModal');
    const themeToggle = document.getElementById('publicThemeToggle');
    const themeLabel = document.getElementById('publicThemeLabel');
    const previewButtons = Array.from(document.querySelectorAll('[data-preview-tab]'));
    const previewPanels = Array.from(document.querySelectorAll('[data-preview-panel]'));
    const faqButtons = Array.from(document.querySelectorAll('[data-faq-trigger]'));
    const dashboardButtons = Array.from(document.querySelectorAll('[data-dashboard-view]'));
    const heroStage = document.querySelector('[data-hero-stage]');
    const tiltNodes = Array.from(document.querySelectorAll('[data-tilt]'));
    const liveGreetingTargets = Array.from(document.querySelectorAll('[data-live-greeting]'));
    const liveTimeTargets = Array.from(document.querySelectorAll('[data-live-time]'));
    const dashboardTitle = document.querySelector('[data-dashboard-title]');
    const dashboardPeriod = document.querySelector('[data-dashboard-period]');
    const dashboardBannerTitle = document.querySelector('[data-dashboard-banner-title]');
    const dashboardBannerText = document.querySelector('[data-dashboard-banner-text]');
    const chart = document.querySelector('.landing-chart');
    const chartPolyline = chart?.querySelector('polyline');
    const chartPoints = chart ? Array.from(chart.querySelectorAll('span')) : [];
    const chartMetaCards = Array.from(document.querySelectorAll('.landing-chart-meta > div'));
    const chartLabel = document.querySelector('[data-chart-label]');
    const chartSignal = document.querySelector('[data-chart-signal]');
    const chartSignalNote = document.querySelector('[data-chart-signal-note]');
    const themeStorageKey = 'public-landing-theme-v2';
    const reduceMotion = typeof window.matchMedia === 'function' && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const chartXPositions = [7, 20, 37, 51, 67, 80, 94];
    const chartDatasets = {
        overview: {
            points: [71, 69, 44, 58, 36, 31, 23],
            meta: [
                { value: '12.4K', label: 'SKUs tracked' },
                { value: '18', label: 'Low stock alerts' },
                { value: '94%', label: 'Supplier readiness' },
            ],
        },
        catalog: {
            points: [76, 62, 58, 48, 40, 34, 29],
            meta: [
                { value: '248', label: 'Active products' },
                { value: '82', label: 'Seed SKUs' },
                { value: '5', label: 'Low stock groups' },
            ],
        },
        orders: {
            points: [82, 72, 60, 52, 38, 30, 26],
            meta: [
                { value: '19', label: 'Open purchase orders' },
                { value: '4', label: 'Awaiting approval' },
                { value: '92%', label: 'On-time receiving' },
            ],
        },
        alerts: {
            points: [35, 42, 56, 63, 57, 49, 39],
            meta: [
                { value: '18', label: 'Items at risk' },
                { value: '7', label: 'Urgent actions' },
                { value: '3', label: 'Branch watchlist' },
            ],
        },
        analytics: {
            points: [84, 78, 66, 50, 39, 31, 22],
            meta: [
                { value: '8.4%', label: 'Margin improvement' },
                { value: '2', label: 'Supplier risks' },
                { value: '11', label: 'Forecast recommendations' },
            ],
        },
    };
    const chartSummaries = {
        overview: { label: 'Stock value (PHP)', signal: '+8.2%', note: 'vs last 7 days' },
        catalog: { label: 'In-stock catalog', signal: '248 items', note: 'available today' },
        orders: { label: 'Open PO value', signal: 'PHP 266K', note: 'in active flow' },
        alerts: { label: 'Reorder alerts', signal: '7 urgent', note: 'need action now' },
        analytics: { label: 'Forecast confidence', signal: '94%', note: 'aligned with demand' },
        Dashboard: { label: 'Stock value (PHP)', signal: '+8.2%', note: 'vs last 7 days' },
        Inventory: { label: 'In-stock catalog', signal: '248 items', note: 'available today' },
        'Purchase Orders': { label: 'Open PO value', signal: 'PHP 266K', note: 'in active flow' },
        'Stock Alerts': { label: 'Reorder alerts', signal: '7 urgent', note: 'need action now' },
        Suppliers: { label: 'Covered suppliers', signal: '18 vendors', note: 'tracked live' },
        Branches: { label: 'Branch stock trend', signal: '6 branches', note: 'reporting today' },
        Warehouses: { label: 'Warehouse movement', signal: '214 lots', note: 'moved today' },
        Reports: { label: 'Report activity', signal: '24 exports', note: 'this month' },
        Analytics: { label: 'Forecast confidence', signal: '94%', note: 'aligned with demand' },
    };

    let currentChartKey = 'overview';
    let chartAnimationFrame = 0;
    let landingClockTimeout = 0;
    let landingClockInterval = 0;

    const setModalState = (open) => {
        if (!authModal) return;
        authModal.classList.toggle('hidden', !open);
        authModal.setAttribute('aria-hidden', open ? 'false' : 'true');
        document.body.classList.toggle('public-auth-open', open);
    };

    const setTheme = (theme) => {
        const nextTheme = theme === 'light' ? 'light' : 'dark';
        document.body.classList.toggle('public-theme-light', nextTheme === 'light');
        themeToggle?.setAttribute('aria-pressed', nextTheme === 'dark' ? 'true' : 'false');
        if (themeLabel) {
            themeLabel.textContent = nextTheme === 'dark' ? 'Dark' : 'Light';
        }
        try {
            window.localStorage.setItem(themeStorageKey, nextTheme);
        } catch (_) {}
    };

    const restoreTheme = () => {
        try {
            const savedTheme = window.localStorage.getItem(themeStorageKey);
            setTheme(savedTheme || 'light');
        } catch (_) {
            setTheme('light');
        }
    };

    const syncPublicMode = () => {
        if (!authSection || !appSection) return;
        const isPublicMode = !authSection.classList.contains('hidden') && appSection.classList.contains('hidden');
        document.body.classList.toggle('public-landing-active', isPublicMode);
        if (!isPublicMode) {
            setModalState(false);
        }
    };

    const setPreview = (key) => {
        previewButtons.forEach((button) => {
            const active = String(button.dataset.previewTab || '') === key;
            button.classList.toggle('active', active);
            button.setAttribute('aria-selected', active ? 'true' : 'false');
        });

        previewPanels.forEach((panel) => {
            const active = String(panel.dataset.previewPanel || '') === key;
            panel.classList.toggle('active', active);
            panel.hidden = !active;
        });
    };

    const buildChartGeometry = (datasetKey) => {
        const dataset = chartDatasets[datasetKey] || chartDatasets.overview;
        return dataset.points.map((y, index) => ({
            x: chartXPositions[index] ?? chartXPositions[chartXPositions.length - 1],
            y,
        }));
    };

    const renderChartGeometry = (geometry) => {
        if (!chartPolyline || !chartPoints.length) return;

        const svgPoints = geometry.map(({ x, y }) => `${(x / 100 * 520).toFixed(1)},${(y / 100 * 220).toFixed(1)}`).join(' ');
        chartPolyline.setAttribute('points', svgPoints);

        chartPoints.forEach((point, index) => {
            const currentPoint = geometry[index] || geometry[geometry.length - 1];
            point.style.setProperty('--point-x', `${currentPoint.x}%`);
            point.style.setProperty('--point-y', `${currentPoint.y}%`);
        });
    };

    const renderChartMeta = (datasetKey) => {
        const dataset = chartDatasets[datasetKey] || chartDatasets.overview;
        chartMetaCards.forEach((card, index) => {
            const strong = card.querySelector('strong');
            const small = card.querySelector('small');
            const entry = dataset.meta[index];
            if (!entry || !strong || !small) return;
            strong.textContent = entry.value;
            small.textContent = entry.label;
        });
    };

    const renderChartSummary = (datasetKey, buttonLabel = '') => {
        const normalizedLabel = String(buttonLabel || '').replace(/\s+/g, ' ').trim();
        const summary = chartSummaries[normalizedLabel] || chartSummaries[datasetKey] || chartSummaries.overview;

        if (chartLabel) {
            chartLabel.textContent = summary.label;
        }
        if (chartSignal) {
            chartSignal.textContent = summary.signal;
        }
        if (chartSignalNote) {
            chartSignalNote.textContent = summary.note;
        }
    };

    const easeInOutCubic = (value) => (value < 0.5)
        ? 4 * value * value * value
        : 1 - Math.pow(-2 * value + 2, 3) / 2;

    const animateChartTo = (datasetKey, immediate = false) => {
        if (!chart || !chartPolyline || !chartPoints.length) {
            currentChartKey = datasetKey;
            return;
        }

        const targetGeometry = buildChartGeometry(datasetKey);
        renderChartMeta(datasetKey);

        if (immediate || reduceMotion) {
            renderChartGeometry(targetGeometry);
            currentChartKey = datasetKey;
            return;
        }

        const startGeometry = buildChartGeometry(currentChartKey);
        cancelAnimationFrame(chartAnimationFrame);
        const startedAt = performance.now();
        const duration = 620;

        const tick = (time) => {
            const progress = Math.min((time - startedAt) / duration, 1);
            const eased = easeInOutCubic(progress);
            const frameGeometry = targetGeometry.map((point, index) => {
                const startPoint = startGeometry[index] || startGeometry[startGeometry.length - 1];
                return {
                    x: startPoint.x + (point.x - startPoint.x) * eased,
                    y: startPoint.y + (point.y - startPoint.y) * eased,
                };
            });

            renderChartGeometry(frameGeometry);

            if (progress < 1) {
                chartAnimationFrame = window.requestAnimationFrame(tick);
                return;
            }

            currentChartKey = datasetKey;
        };

        chartAnimationFrame = window.requestAnimationFrame(tick);
    };

    const setDashboardView = (button, options = {}) => {
        if (!button) return;
        const immediate = Boolean(options.immediate);

        dashboardButtons.forEach((entry) => {
            const active = entry === button;
            entry.classList.toggle('active', active);
            entry.setAttribute('aria-pressed', active ? 'true' : 'false');
        });

        if (dashboardTitle) {
            dashboardTitle.textContent = String(button.dataset.dashboardTitle || 'Inventory Overview');
        }
        if (dashboardPeriod) {
            dashboardPeriod.textContent = String(button.dataset.dashboardPeriod || 'This Week');
        }
        if (dashboardBannerTitle) {
            dashboardBannerTitle.textContent = String(button.dataset.dashboardBannerTitle || 'Everything in one connected workspace.');
        }
        if (dashboardBannerText) {
            dashboardBannerText.textContent = String(button.dataset.dashboardBannerText || 'Inventory, purchasing, alerts, reports, and more.');
        }

        const previewKey = String(button.dataset.dashboardView || 'overview');
        const buttonLabel = String(button.textContent || '');
        renderChartSummary(previewKey, buttonLabel);
        setPreview(previewKey);
        animateChartTo(previewKey, immediate);
    };

    const setFaqState = (button, expanded) => {
        const item = button.closest('.public-faq-item');
        const answer = item?.querySelector('.public-faq-answer');
        const icon = button.querySelector('[data-faq-icon]');
        button.setAttribute('aria-expanded', expanded ? 'true' : 'false');
        item?.classList.toggle('active', expanded);
        if (answer) answer.hidden = !expanded;
        if (icon) icon.textContent = expanded ? '-' : '+';
    };

    const getDayGreeting = (hour) => {
        if (hour >= 5 && hour < 12) return 'Good morning!';
        if (hour >= 12 && hour < 18) return 'Good afternoon!';
        return 'Good evening!';
    };

    const updateLandingClock = () => {
        if (!liveGreetingTargets.length && !liveTimeTargets.length) return;

        const now = new Date();
        const greeting = getDayGreeting(now.getHours());
        const timeText = new Intl.DateTimeFormat(undefined, {
            hour: 'numeric',
            minute: '2-digit',
        }).format(now);

        liveGreetingTargets.forEach((node) => {
            node.textContent = greeting;
        });

        liveTimeTargets.forEach((node) => {
            node.textContent = timeText;
        });
    };

    const startLandingClock = () => {
        updateLandingClock();

        if (landingClockTimeout) {
            window.clearTimeout(landingClockTimeout);
        }
        if (landingClockInterval) {
            window.clearInterval(landingClockInterval);
        }

        const now = new Date();
        const delay = ((60 - now.getSeconds()) * 1000) - now.getMilliseconds() + 40;

        landingClockTimeout = window.setTimeout(() => {
            updateLandingClock();
            landingClockInterval = window.setInterval(updateLandingClock, 60000);
        }, delay);
    };

    const resetHeroStage = () => {
        if (!heroStage) return;
        heroStage.style.setProperty('--hero-tilt-x', '0deg');
        heroStage.style.setProperty('--hero-tilt-y', '0deg');
        heroStage.style.setProperty('--hero-spot-x', '52%');
        heroStage.style.setProperty('--hero-spot-y', '38%');
    };

    const bindHeroStageMotion = () => {
        if (!heroStage || reduceMotion) return;

        const updateHero = (event) => {
            const rect = heroStage.getBoundingClientRect();
            const x = Math.max(0, Math.min(1, (event.clientX - rect.left) / rect.width));
            const y = Math.max(0, Math.min(1, (event.clientY - rect.top) / rect.height));
            const tiltX = (x - 0.5) * 7;
            const tiltY = (0.5 - y) * 5;

            heroStage.style.setProperty('--hero-tilt-x', `${tiltX.toFixed(2)}deg`);
            heroStage.style.setProperty('--hero-tilt-y', `${tiltY.toFixed(2)}deg`);
            heroStage.style.setProperty('--hero-spot-x', `${(x * 100).toFixed(2)}%`);
            heroStage.style.setProperty('--hero-spot-y', `${(y * 100).toFixed(2)}%`);
        };

        heroStage.addEventListener('pointermove', updateHero);
        heroStage.addEventListener('pointerleave', resetHeroStage);
        heroStage.addEventListener('pointercancel', resetHeroStage);
        resetHeroStage();
    };

    const bindTiltSurface = (node) => {
        if (!node || reduceMotion) return;

        const resetNode = () => {
            node.classList.remove('is-tilting');
            node.style.transform = '';
            node.style.removeProperty('--tilt-x');
            node.style.removeProperty('--tilt-y');
        };

        node.addEventListener('pointermove', (event) => {
            const rect = node.getBoundingClientRect();
            const x = Math.max(0, Math.min(1, (event.clientX - rect.left) / rect.width));
            const y = Math.max(0, Math.min(1, (event.clientY - rect.top) / rect.height));
            const rotateY = (x - 0.5) * 8;
            const rotateX = (0.5 - y) * 6;

            node.classList.add('is-tilting');
            node.style.setProperty('--tilt-x', `${(x * 100).toFixed(2)}%`);
            node.style.setProperty('--tilt-y', `${(y * 100).toFixed(2)}%`);
            node.style.transform = `perspective(1200px) rotateX(${rotateX.toFixed(2)}deg) rotateY(${rotateY.toFixed(2)}deg) translateY(-3px)`;
        });

        node.addEventListener('pointerleave', resetNode);
        node.addEventListener('pointercancel', resetNode);
    };

    const sceneStages = Array.from(document.querySelectorAll('[data-scene-stage]'));

    const resetSceneStage = (stage) => {
        if (!stage) return;
        stage.style.setProperty('--scene-tilt-x', '0deg');
        stage.style.setProperty('--scene-tilt-y', '0deg');
        stage.style.setProperty('--scene-pan-x', '0px');
        stage.style.setProperty('--scene-pan-y', '0px');
        stage.style.setProperty('--scene-light-x', '72%');
        stage.style.setProperty('--scene-light-y', '24%');
    };

    const bindSceneStageMotion = (stage) => {
        if (!stage) return;
        if (reduceMotion) {
            resetSceneStage(stage);
            return;
        }

        let frame = null;
        const updateScene = (event) => {
            if (frame) window.cancelAnimationFrame(frame);
            frame = window.requestAnimationFrame(() => {
                const rect = stage.getBoundingClientRect();
                const x = Math.max(0, Math.min(1, (event.clientX - rect.left) / rect.width));
                const y = Math.max(0, Math.min(1, (event.clientY - rect.top) / rect.height));
                const tiltX = (x - 0.5) * 10;
                const tiltY = (0.5 - y) * 8;
                const panX = (x - 0.5) * 26;
                const panY = (y - 0.5) * 20;

                stage.style.setProperty('--scene-tilt-x', `${tiltX.toFixed(2)}deg`);
                stage.style.setProperty('--scene-tilt-y', `${tiltY.toFixed(2)}deg`);
                stage.style.setProperty('--scene-pan-x', `${panX.toFixed(2)}px`);
                stage.style.setProperty('--scene-pan-y', `${panY.toFixed(2)}px`);
                stage.style.setProperty('--scene-light-x', `${(x * 100).toFixed(2)}%`);
                stage.style.setProperty('--scene-light-y', `${(y * 100).toFixed(2)}%`);
            });
        };

        const reset = () => {
            if (frame) window.cancelAnimationFrame(frame);
            resetSceneStage(stage);
        };

        stage.addEventListener('pointermove', updateScene);
        stage.addEventListener('pointerleave', reset);
        stage.addEventListener('pointercancel', reset);
        resetSceneStage(stage);
    };
    restoreTheme();
    startLandingClock();
    bindHeroStageMotion();
    tiltNodes.forEach(bindTiltSurface);
    sceneStages.forEach(bindSceneStageMotion);

    if (authSection && appSection) {
        const observer = new MutationObserver(syncPublicMode);
        observer.observe(authSection, { attributes: true, attributeFilter: ['class'] });
        observer.observe(appSection, { attributes: true, attributeFilter: ['class'] });
        syncPublicMode();
    }

    themeToggle?.addEventListener('click', () => {
        const isLight = document.body.classList.contains('public-theme-light');
        setTheme(isLight ? 'dark' : 'light');
    });

    if (previewButtons.length && previewPanels.length) {
        const initialKey = previewButtons.find((button) => button.classList.contains('active'))?.dataset.previewTab || 'overview';
        setPreview(String(initialKey));
        document.querySelectorAll('.public-tab-row').forEach((row) => {
            row.addEventListener('click', (event) => {
                const button = event.target instanceof Element ? event.target.closest('[data-preview-tab]') : null;
                if (!button) return;
                setPreview(String(button.getAttribute('data-preview-tab') || 'overview'));
            });
        });
    }

    if (dashboardButtons.length) {
        const activeButton = dashboardButtons.find((button) => button.classList.contains('active')) || dashboardButtons[0];
        setDashboardView(activeButton, { immediate: true });
        dashboardButtons.forEach((button) => {
            button.addEventListener('click', () => setDashboardView(button));
        });
    } else {
        renderChartSummary('overview');
        animateChartTo('overview', true);
    }

    faqButtons.forEach((button, index) => {
        const expanded = button.getAttribute('aria-expanded') === 'true' || index === 0;
        setFaqState(button, expanded);
        button.addEventListener('click', () => {
            const willExpand = button.getAttribute('aria-expanded') !== 'true';
            faqButtons.forEach((entry) => setFaqState(entry, false));
            setFaqState(button, willExpand);
        });
    });

    document.querySelectorAll('[data-auth-mode]').forEach((trigger) => {
        trigger.addEventListener('click', (event) => {
            const mode = String(trigger.getAttribute('data-auth-mode') || 'login');
            const shouldOpen = trigger.hasAttribute('data-auth-open');
            if ((mode === 'login' || mode === 'register') && typeof setAuthMode === 'function') {
                setAuthMode(mode);
            }
            if (shouldOpen) {
                event.preventDefault();
                setModalState(true);
            }
        });
    });

    authModal?.querySelectorAll('[data-auth-close]').forEach((button) => {
        button.addEventListener('click', () => setModalState(false));
    });

    window.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            setModalState(false);
        }
    });
})();









