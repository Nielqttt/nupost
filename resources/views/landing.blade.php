<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NUPost | Social Media Request System</title>
    <meta name="description" content="The official social media request platform for National University Lipa. Submit, track, and manage content requests seamlessly.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/landing.css">
</head>
<body>

    <!-- Ambient Subtle Glows (Hardware Accelerated, No Heavy Runtime Blurs) -->
    <div class="ambient-bg" aria-hidden="true">
        <div class="ambient-glow glow-top"></div>
        <div class="ambient-glow glow-bottom"></div>
    </div>

    <!-- ── NAVBAR ── -->
    <header class="navbar" id="navbar">
        <div class="nav-container">
            <a href="/" class="nav-brand">
                <img src="/assets/nupostlogo.png" alt="NUPost Logo" width="130" height="42">
            </a>
            <nav class="nav-menu">
                <a href="#features" class="nav-link">Features</a>
                <a href="#how-it-works" class="nav-link">Process</a>
                <a href="#demo" class="nav-link">Interactive Demo</a>
                <a href="#faq" class="nav-link">FAQ</a>
            </nav>
            <div class="nav-actions">
                <a href="{{ route('login') }}" class="btn btn-sm btn-subtle">Sign In</a>
                <a href="{{ route('register') }}" class="btn btn-sm btn-gold">Get Started</a>
            </div>
        </div>
    </header>

    <main>
        <!-- ── HERO SECTION ── -->
        <section class="hero" id="hero">
            <div class="hero-container">
                
                <!-- Left Column -->
                <div class="hero-left">
                    <div class="badge-live">
                        <span class="pulse-dot"></span>
                        <span>Official NU Lipa Platform</span>
                    </div>
                    
                    <h1 class="hero-title">
                        Request. Track.<br>
                        <span class="gradient-text">Post. NU Post.</span>
                    </h1>
                    
                    <p class="hero-lead">
                        The all-in-one social media request platform built for NU Lipa departments and student organizations. From idea to approved publication in minutes.
                    </p>
                    
                    <div class="hero-cta-group">
                        <a href="{{ route('login') }}" class="btn btn-lg btn-navy">
                            <span>Submit a Request</span>
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                        <a href="#demo" class="btn btn-lg btn-subtle">
                            <span>Try Live Simulator</span>
                        </a>
                    </div>
                    
                    <div class="trust-pills">
                        <div class="trust-item">
                            <span class="trust-check">✓</span>
                            <span>AI Caption Generation</span>
                        </div>
                        <div class="trust-item">
                            <span class="trust-check">✓</span>
                            <span>Direct Admin Feedback</span>
                        </div>
                        <div class="trust-item">
                            <span class="trust-check">✓</span>
                            <span>Live Status Tracking</span>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Interactive Simulator -->
                <div class="hero-right" id="demo">
                    <div class="demo-window">
                        <div class="demo-header">
                            <div class="demo-dots">
                                <span class="demo-dot red"></span>
                                <span class="demo-dot yellow"></span>
                                <span class="demo-dot green"></span>
                            </div>
                            <div class="demo-badge-interactive">
                                <span>✨ Interactive Playground</span>
                            </div>
                        </div>

                        <div class="demo-body">
                            <!-- Category Buttons -->
                            <div class="demo-tabs-label">
                                <span>Select Post Template</span>
                                <span class="hint">Click to test live preview 👇</span>
                            </div>

                            <div class="demo-tabs">
                                <button class="demo-tab-btn active" data-type="event">🎓 Event</button>
                                <button class="demo-tab-btn" data-type="sports">🏆 Sports</button>
                                <button class="demo-tab-btn" data-type="org">📢 Notice</button>
                            </div>

                            <!-- Live Card Preview -->
                            <div class="demo-card-preview">
                                <div class="preview-top">
                                    <div class="preview-org">
                                        <div class="preview-avatar" id="demoAvatar">NU</div>
                                        <div class="preview-org-meta">
                                            <h5 id="demoTitle">College of Computing — Tech Summit 2026</h5>
                                            <p id="demoOrg">Target Date: May 24, 2026 • 2:00 PM</p>
                                        </div>
                                    </div>
                                    <span class="status-chip chip-approved" id="demoStatus">Approved</span>
                                </div>

                                <div class="preview-caption-box">
                                    <span class="ai-tag">✨ Gemini AI Assist</span>
                                    <p id="demoCaption" class="demo-caption-text">
                                        "Gear up for innovation! Join us at the NU Lipa Tech Summit 2026. Explore hands-on AI workshops and keynote talks from industry leaders. 🚀💡 #NULipa #TechSummit2026 #NationalUniversity"
                                    </p>
                                </div>

                                <div class="preview-bottom-bar">
                                    <div class="preview-platforms">
                                        <span class="platform-pill">📱 Facebook</span>
                                        <span class="platform-pill">📸 Instagram</span>
                                    </div>
                                    <div class="preview-media-badge">
                                        📎 3 Assets Attached
                                    </div>
                                </div>
                            </div>

                            <!-- Interactive Action Simulator -->
                            <div class="demo-interactive-action">
                                <span id="demoActionHint">Need captions? Let AI write it for you:</span>
                                <button type="button" class="btn-sparkle" id="btnGenCaption">
                                    ✨ Regenerate AI Caption
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Floating Mini Badges -->
                    <div class="float-tag float-tag-1">
                        <div class="float-icon" style="background:#dcfce7;color:#16a34a;">⚡</div>
                        <div class="float-meta">
                            <h6>Rapid Review</h6>
                            <p>Average < 24h turnaround</p>
                        </div>
                    </div>

                    <div class="float-tag float-tag-2">
                        <div class="float-icon" style="background:#dbeafe;color:#2563eb;">🔒</div>
                        <div class="float-meta">
                            <h6>Verified NU Accounts</h6>
                            <p>Role-based access control</p>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- ── STATS SECTION ── -->
        <section class="stats-section">
            <div class="stats-card-wrapper">
                <div class="stat-box">
                    <div class="stat-value">100<span>%</span></div>
                    <div class="stat-name">Paperless Requests</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value">< <span>24h</span></div>
                    <div class="stat-name">Fast Turnaround</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value">3<span>+</span></div>
                    <div class="stat-name">Channels Published</div>
                </div>
                <div class="stat-box">
                    <div class="stat-value">24<span>/7</span></div>
                    <div class="stat-name">Real-Time Tracking</div>
                </div>
            </div>
        </section>

        <!-- ── BENTO FEATURES SECTION ── -->
        <section class="features-section" id="features">
            <div class="section-head">
                <div class="section-tag">Powerful Features</div>
                <h2 class="section-headline">Everything needed to streamline campus communication</h2>
                <p class="section-desc">Designed specifically for the NU Lipa Marketing Office, student council, and recognized student organizations.</p>
            </div>

            <div class="bento-grid">
                <!-- Bento 1: AI Assistant (Wide) -->
                <div class="bento-card bento-col-8">
                    <div>
                        <div class="bento-icon" style="background:#fef3c7;color:#d97706;">✨</div>
                        <h3 class="bento-title">AI-Powered Social Media Captioning</h3>
                        <p class="bento-text">Stuck on what to write? Our integrated Gemini AI crafts tailored, engaging captions with relevant hashtags and event highlights in seconds.</p>
                    </div>
                    <div class="bento-visual-ai">
                        <span class="ai-prompt-chip">Prompt: Campus Intramurals 2026 Announcement</span>
                        <div class="ai-output-stream">
                            "Unleash the Bulldog spirit! 🐶🔥 Are you ready to champion your college? Intramurals 2026 kickstarts this Monday at the Main Gymnasium. Be there, be proud!"<span class="cursor"></span>
                        </div>
                    </div>
                </div>

                <!-- Bento 2: Status Tracking (4 cols) -->
                <div class="bento-card bento-col-4">
                    <div>
                        <div class="bento-icon" style="background:#dbeafe;color:#2563eb;">📡</div>
                        <h3 class="bento-title">Live Tracking</h3>
                        <p class="bento-text">Know exactly when your post is queued, in review, or published.</p>
                    </div>
                    <div class="bento-visual-timeline">
                        <div class="timeline-step-dot done" title="Submitted">✓</div>
                        <div class="timeline-step-dot done" title="Review">✓</div>
                        <div class="timeline-step-dot active" title="Approved">●</div>
                        <div class="timeline-step-dot" title="Posted">4</div>
                    </div>
                </div>

                <!-- Bento 3: Admin Chat (4 cols) -->
                <div class="bento-card bento-col-4">
                    <div>
                        <div class="bento-icon" style="background:#ede9fe;color:#7c3aed;">💬</div>
                        <h3 class="bento-title">Admin Feedback</h3>
                        <p class="bento-text">Direct 1-on-1 comments per request for fast revisions and creative approval.</p>
                    </div>
                    <div class="bento-visual-chat">
                        <div class="chat-bubble-mini admin">"Please upload the high-res poster format!"</div>
                        <div class="chat-bubble-mini user">"Done! Attached the 4K PNG file."</div>
                    </div>
                </div>

                <!-- Bento 4: Visual Calendar (Wide 8 cols) -->
                <div class="bento-card bento-col-8">
                    <div>
                        <div class="bento-icon" style="background:#dcfce7;color:#16a34a;">📅</div>
                        <h3 class="bento-title">Conflict-Free Visual Calendar</h3>
                        <p class="bento-text">Prevent overlapping promotions and schedule posts strategically across official social channels with our interactive schedule grid.</p>
                    </div>
                    <div class="bento-calendar-preview">
                        <div class="cal-mini-day active">
                            <span class="day-num">18</span>
                            <span class="day-dot bg-amber"></span>
                            <span class="day-label">General Assembly</span>
                        </div>
                        <div class="cal-mini-day">
                            <span class="day-num">19</span>
                            <span class="day-dot bg-blue"></span>
                            <span class="day-label">Quiz Bee</span>
                        </div>
                        <div class="cal-mini-day">
                            <span class="day-num">20</span>
                            <span class="day-dot bg-green"></span>
                            <span class="day-label">Bulldog Sports</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ── 3-STEP PROCESS SECTION ── -->
        <section class="process-section" id="how-it-works">
            <div class="section-head">
                <div class="section-tag">Streamlined Flow</div>
                <h2 class="section-headline">From Submission to Social Media in 3 Steps</h2>
                <p class="section-desc">No complicated paper forms. Everything is tracked digitally in real time.</p>
            </div>

            <div class="steps-container">
                <div class="step-card-modern">
                    <div class="step-number-badge">
                        <span>01</span>
                        <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
                    </div>
                    <h3 class="step-card-title">Create Request</h3>
                    <p class="step-card-text">Provide event details, select posting dates, target channels, and upload your graphic assets or pubmats.</p>
                </div>

                <div class="step-card-modern">
                    <div class="step-number-badge">
                        <span>02</span>
                        <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                    </div>
                    <h3 class="step-card-title">Review & Refine</h3>
                    <p class="step-card-text">The Marketing Office verifies brand guidelines, polishes captions with AI, and coordinates via direct chat.</p>
                </div>

                <div class="step-card-modern">
                    <div class="step-number-badge">
                        <span>03</span>
                        <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 14 14"/><path d="M22 12A10 10 0 0 0 12 2v10z"/></svg>
                    </div>
                    <h3 class="step-card-title">Publish & Monitor</h3>
                    <p class="step-card-text">Content goes live on scheduled channels. Monitor post reach, engagement, and confirmed status.</p>
                </div>
            </div>
        </section>

        <!-- ── FAQ SECTION ── -->
        <section class="faq-section" id="faq">
            <div class="section-head">
                <div class="section-tag">Frequently Asked Questions</div>
                <h2 class="section-headline">Got Questions? We have answers.</h2>
            </div>

            <div class="faq-list">
                <div class="faq-item open">
                    <div class="faq-question">
                        <span>Who can submit posting requests?</span>
                        <svg class="faq-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                    <div class="faq-answer">
                        Any recognized student organization, academic department, faculty member, or office head with a verified NU Lipa email address can submit and manage requests.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>How far in advance should I submit my post request?</span>
                        <svg class="faq-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                    <div class="faq-answer">
                        We recommend submitting requests at least 3–5 business days before your target posting date to ensure proper marketing review, branding compliance, and optimal scheduling.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question">
                        <span>How does the AI caption generator work?</span>
                        <svg class="faq-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                    <div class="faq-answer">
                        When creating or editing a request, simply click "Generate AI Caption". Our integrated AI analyzes your title, event context, and target platforms to produce catchy, professional captions and hashtags in seconds.
                    </div>
                </div>
            </div>
        </section>

        <!-- ── CTA BANNER ── -->
        <section class="cta-wrapper">
            <div class="cta-box">
                <h2>Ready to publish your next campus event?</h2>
                <p>Join student leaders and department officers who organize and schedule social media campaigns seamlessly with NUPost.</p>
                <div class="cta-actions">
                    <a href="{{ route('register') }}" class="btn btn-lg btn-gold">Create an Account</a>
                    <a href="{{ route('login') }}" class="btn btn-lg btn-subtle" style="color:#ffffff;background:rgba(255,255,255,0.12);border-color:rgba(255,255,255,0.2);">Sign In to Platform</a>
                </div>
            </div>
        </section>
    </main>

    <!-- ── FOOTER ── -->
    <footer class="footer-modern">
        <div class="footer-top">
            <div class="footer-brand-block">
                <div class="footer-logo-wrap">
                    <img src="/assets/Title.png" alt="NUPost Title Logo" height="50">
                </div>
                <p class="footer-tagline">The official social media request and management system for National University Lipa.</p>
            </div>
            
            <div class="footer-nav-groups">
                <div class="footer-group">
                    <h4>Navigation</h4>
                    <ul>
                        <li><a href="#hero">Overview</a></li>
                        <li><a href="#features">Features</a></li>
                        <li><a href="#how-it-works">Process Flow</a></li>
                        <li><a href="#faq">FAQ</a></li>
                    </ul>
                </div>
                <div class="footer-group">
                    <h4>Account</h4>
                    <ul>
                        <li><a href="{{ route('login') }}">Sign In</a></li>
                        <li><a href="{{ route('register') }}">Create Account</a></li>
                        <li><a href="{{ route('password.forgot') }}">Forgot Password</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <span>&copy; {{ date('Y') }} NU Lipa Marketing Office. All rights reserved.</span>
            <span>National University Lipa • Education That Works</span>
        </div>
    </footer>

    <!-- Lightweight Native Script (Zero Heavy Libraries, Ultra Fast & Smooth) -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1. Navbar Scroll state
            const navbar = document.getElementById('navbar');
            window.addEventListener('scroll', () => {
                if (window.scrollY > 30) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            }, { passive: true });

            // 2. Interactive Simulator Dataset
            const demoData = {
                event: {
                    avatar: "CS",
                    title: "College of Computing — Tech Summit 2026",
                    org: "Target Date: May 24, 2026 • 2:00 PM",
                    status: "Approved",
                    statusClass: "chip-approved",
                    captions: [
                        '"Gear up for innovation! Join us at the NU Lipa Tech Summit 2026. Explore hands-on AI workshops and keynote talks from industry leaders. 🚀💡 #NULipa #TechSummit2026"',
                        '"Code, build, and lead! 💻 The future of technology unfolds at NU Lipa Tech Summit 2026. Free admission for all students! #BulldogPride #CCIT"',
                        '"Level up your digital skills! Join our interactive workshop tracks this May 24th at the Multipurpose Hall. Register now! 🔥✨ #NUPost #NULipa"'
                    ]
                },
                sports: {
                    avatar: "ATH",
                    title: "Bulldogs Athletics — University Games 2026",
                    org: "Target Date: June 02, 2026 • 9:00 AM",
                    status: "Scheduled",
                    statusClass: "chip-scheduled",
                    captions: [
                        '"Hear the Bulldogs roar! 🐶🏆 Catch our varsity teams in action at the Southern Luzon University Games. Let\'s bring home the championship! #GoBulldogs #NUAthletics"',
                        '"Game day ready! Support our athletes as they defend the court this Tuesday. Gates open at 8:00 AM. Wear your Gold & Blue! 💙💛 #BulldogPride"',
                        '"Unstoppable spirit, unmatched energy! Watch the livestreams right here on our official Facebook page. 🔥🏀 #NULipaSports"'
                    ]
                },
                org: {
                    avatar: "SSC",
                    title: "Supreme Student Council — General Assembly",
                    org: "Target Date: May 28, 2026 • 10:00 AM",
                    status: "Under Review",
                    statusClass: "chip-review",
                    captions: [
                        '"Your voice, your council! 📢 Join the SSC Year-End General Assembly. Submit your agenda items and hear key project updates. See you there! #SSC2026 #OneNU"',
                        '"Transparency in action! All student leaders and org representatives are invited to our term review this Thursday. 🤝✨ #NULipaSSC"',
                        '"Lead the change! Check the link in bio for the complete assembly agenda and open forum guidelines. 📋🇵🇭 #StudentLeadership"'
                    ]
                }
            };

            let currentType = 'event';
            let captionIndex = 0;

            const tabButtons = document.querySelectorAll('.demo-tab-btn');
            const demoAvatar = document.getElementById('demoAvatar');
            const demoTitle = document.getElementById('demoTitle');
            const demoOrg = document.getElementById('demoOrg');
            const demoStatus = document.getElementById('demoStatus');
            const demoCaption = document.getElementById('demoCaption');
            const btnGenCaption = document.getElementById('btnGenCaption');

            function updateDemo(type) {
                currentType = type;
                captionIndex = 0;
                const data = demoData[type];
                
                demoAvatar.textContent = data.avatar;
                demoTitle.textContent = data.title;
                demoOrg.textContent = data.org;
                demoStatus.textContent = data.status;
                demoStatus.className = 'status-chip ' + data.statusClass;
                
                // Animate text typing
                typeWriterText(demoCaption, data.captions[0]);
            }

            function typeWriterText(element, text) {
                element.style.opacity = '0.5';
                setTimeout(() => {
                    element.textContent = text;
                    element.style.opacity = '1';
                }, 150);
            }

            tabButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    tabButtons.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');
                    updateDemo(btn.dataset.type);
                });
            });

            if (btnGenCaption) {
                btnGenCaption.addEventListener('click', () => {
                    const data = demoData[currentType];
                    captionIndex = (captionIndex + 1) % data.captions.length;
                    btnGenCaption.classList.add('btn-sparkle-active');
                    typeWriterText(demoCaption, data.captions[captionIndex]);
                    setTimeout(() => {
                        btnGenCaption.classList.remove('btn-sparkle-active');
                    }, 400);
                });
            }

            // 3. Lightweight FAQ Accordion
            const faqItems = document.querySelectorAll('.faq-item');
            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question');
                question.addEventListener('click', () => {
                    const isOpen = item.classList.contains('open');
                    faqItems.forEach(other => other.classList.remove('open'));
                    if (!isOpen) {
                        item.classList.add('open');
                    }
                });
            });
        });
    </script>
</body>
</html>
