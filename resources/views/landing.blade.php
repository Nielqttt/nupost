<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NUPost | Social Media Request System</title>
    <meta name="description" content="The official social media request platform for National University Lipa. Submit, track, and manage content requests seamlessly.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=DM+Serif+Display&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/landing.css">
</head>
<body>

    <!-- ── NAVBAR ── -->
    <nav class="navbar" id="navbar">
        <a href="/" class="nav-brand">
            <img src="/assets/nupostlogo.png" alt="NUPost Logo" style="height:70px;">
        </a>
        <div class="nav-links">
            <a href="#features">Features</a>
            <a href="#how-it-works">How It Works</a>

            <a href="{{ route('login') }}" class="btn-login">Sign In</a>
        </div>
    </nav>

    <!-- ── HERO ── -->
    <section class="hero">
        <div class="hero-bg"></div>
        <div class="blob blob-1" id="blob-1"></div>
        <div class="blob blob-2" id="blob-2"></div>
        <div class="blob blob-3" id="blob-3"></div>

        <div class="hero-inner">
            <div class="hero-content">
                <div class="hero-badge gs-hero"><span class="hero-badge-dot"></span> Official NU Lipa Platform</div>
                <h1 class="hero-title gs-hero">Request. Track.<br><span>Post. <span style="color:var(--amber);">NU</span>Post.</span></h1>
                <p class="hero-subtitle gs-hero" style="margin-bottom:16px;">Submit your social media requests and follow every step in one place.</p>
                <p class="hero-subtitle gs-hero" style="font-size:1rem;opacity:.75;margin-bottom:40px;">Create requests, upload your content, and get AI-assisted captions in seconds. Track progress from review to posting and receive real-time updates—so you always know the status of your request.</p>
                <div class="hero-cta gs-hero">
                    <a href="{{ route('login') }}" class="btn-primary">
                        Get Started
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                    <a href="#features" class="btn-outline">Explore Features</a>
                </div>
            </div>

            <div class="hero-visual">
                <div class="hero-float-card hfc-1 gs-float">
                    <div class="hfc-title">📋 New Post Request</div>
                    <div class="hfc-sub">Event Coverage — May 2026</div>
                    <div class="hfc-bar"><div class="hfc-bar-fill" style="width:75%;background:var(--navy-light);"></div></div>
                </div>
                <div class="hero-float-card hfc-2 gs-float">
                    <div class="hfc-title">✅ Status Update</div>
                    <div class="hfc-status" style="background:#dcfce7;color:#16a34a;">Approved</div>
                </div>
                <div class="hero-float-card hfc-3 gs-float">
                    <div class="hfc-title">📊 This Week's Reach</div>
                    <div style="font-size:28px;font-weight:800;color:var(--navy);margin-top:6px;">12,847</div>
                    <div class="hfc-sub" style="color:#10b981;">↑ 23% from last week</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ── FEATURES ── -->
    <section class="features" id="features">
        <div class="section-header">
            <div class="section-eyebrow gs-up">Features</div>
            <h2 class="section-title gs-up">Everything You Need</h2>
            <p class="section-subtitle gs-up">Designed specifically for the Marketing Office and student organizations.</p>
        </div>

        <div class="features-grid">
            <div class="feature-card gs-card">
                <div class="feature-icon" style="background:#dbeafe;color:#2563eb;">
                    <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
                </div>
                <h3 class="feature-title">Submit Requests</h3>
                <p class="feature-desc">Easily submit social media posting requests with your content, preferred date, target platforms, and media uploads — all in one simple form.</p>
            </div>
            <div class="feature-card gs-card">
                <div class="feature-icon" style="background:#fef3c7;color:#d97706;">
                    <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <h3 class="feature-title">Track Your Status</h3>
                <p class="feature-desc">Monitor your requests in real-time — from Pending to Under Review, Approved, and Posted. Always know exactly where things stand.</p>
            </div>
            <div class="feature-card gs-card">
                <div class="feature-icon" style="background:#dcfce7;color:#16a34a;">
                    <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2.5"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <h3 class="feature-title">Visual Calendar</h3>
                <p class="feature-desc">View your scheduled posts on an interactive calendar. Plan ahead, avoid date conflicts, and see when your content goes live.</p>
            </div>
            <div class="feature-card gs-card">
                <div class="feature-icon" style="background:#ede9fe;color:#7c3aed;">
                    <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </div>
                <h3 class="feature-title">Chat with Admin</h3>
                <p class="feature-desc">Communicate directly with administrators on each request. Get feedback, discuss changes, and resolve issues without leaving the platform.</p>
            </div>
            <div class="feature-card gs-card">
                <div class="feature-icon" style="background:#fce7f3;color:#db2777;">
                    <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                </div>
                <h3 class="feature-title">Instant Notifications</h3>
                <p class="feature-desc">Get notified the moment your request is reviewed, approved, or posted. Never miss an update on your submissions.</p>
            </div>
            <div class="feature-card gs-card">
                <div class="feature-icon" style="background:#fef2f2;color:#dc2626;">
                    <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h3 class="feature-title">Secure & Private</h3>
                <p class="feature-desc">Your data is protected with verified email accounts and role-based access. Only you can see your own requests and conversations.</p>
            </div>
        </div>
    </section>

    <!-- ── HOW IT WORKS ── -->
    <section class="how-it-works" id="how-it-works">
        <div class="section-header">
            <div class="section-eyebrow gs-up">Process</div>
            <h2 class="section-title gs-up">How It Works</h2>
            <p class="section-subtitle gs-up">Three simple steps from request to publication.</p>
        </div>

        <div class="steps-grid">
            <div class="step-card gs-step">
                <div class="step-num">1</div>
                <h3 class="step-title">Submit Request</h3>
                <p class="step-desc">Fill out a simple form with your content, preferred date, target platforms, and upload any media files.</p>
                <div class="step-connector"></div>
            </div>
            <div class="step-card gs-step">
                <div class="step-num">2</div>
                <h3 class="step-title">Review & Approve</h3>
                <p class="step-desc">Administrators review your submission, provide feedback via chat, and approve the content for publishing.</p>
                <div class="step-connector"></div>
            </div>
            <div class="step-card gs-step">
                <div class="step-num">3</div>
                <h3 class="step-title">Published & Tracked</h3>
                <p class="step-desc">Your content goes live on the selected platforms. Track reach, engagement, and performance in real-time.</p>
            </div>
        </div>
    </section>



    <!-- ── CTA BANNER ── -->
    <section class="cta-banner">
        <div class="blob" style="top:-50%;left:20%;width:400px;height:400px;background:var(--amber);"></div>
        <div class="blob" style="bottom:-40%;right:10%;width:350px;height:350px;background:#8b5cf6;"></div>
        <h2 class="cta-title gs-up">Ready to Request, Track, and Post?</h2>
        <p class="cta-sub gs-up">Join the departments and organizations already using NUPost to submit request for social media posting.</p>
        <a href="{{ route('login') }}" class="btn-primary gs-up">
            Get Started Now
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
    </section>

    <!-- ── FOOTER ── -->
    <footer class="footer">
        <div class="footer-inner">
            <div class="footer-brand">
                <div class="footer-logo">
                    <img src="/assets/Title.png" alt="NUPost Logo" style="height:100px;">
                </div>
                <p class="footer-text">The official social media request platform for National University Lipa.</p>
            </div>
            <div class="footer-col">
                <h4>Platform</h4>
                <a href="#features">Features</a>
                <a href="#how-it-works">How It Works</a>
            </div>
            <div class="footer-col">
                <h4>Access</h4>
                <a href="{{ route('login') }}">Sign In</a>
                <a href="{{ route('register') }}">Register</a>
            </div>
        </div>
        <div class="footer-bottom">
            &copy; {{ date('Y') }} NU Lipa Marketing Office. All rights reserved.
        </div>
    </footer>

    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script>
        gsap.registerPlugin(ScrollTrigger);

        // ── Hero entrance
        const tl = gsap.timeline({ defaults: { ease: "power4.out" } });
        tl.from(".nav-brand", { opacity:0, y:-20, duration:.7 })
          .from(".nav-links a", { opacity:0, y:-15, duration:.5, stagger:.08 }, "-=.4")
          .from(".gs-hero", { opacity:0, y:50, duration:1, stagger:.18 }, "-=.5")
          .from(".gs-float", { opacity:0, y:40, scale:.9, duration:.8, stagger:.2, ease:"back.out(1.4)" }, "-=.6");

        // ── Floating blobs
        gsap.to("#blob-1", { y:60, x:30, rotation:10, duration:7, repeat:-1, yoyo:true, ease:"sine.inOut" });
        gsap.to("#blob-2", { y:-50, x:-35, rotation:-12, duration:8, repeat:-1, yoyo:true, ease:"sine.inOut", delay:1 });
        gsap.to("#blob-3", { y:40, x:25, duration:9, repeat:-1, yoyo:true, ease:"sine.inOut", delay:2 });

        // ── Floating cards gentle hover
        gsap.utils.toArray(".gs-float").forEach((el, i) => {
            gsap.to(el, { y: "+=12", duration: 2.5 + i*.4, repeat:-1, yoyo:true, ease:"sine.inOut", delay: i*.3 });
        });

        // ── Stats counter
        ScrollTrigger.create({
            trigger: ".stats-bar",
            start: "top 90%",
            onEnter: () => {
                document.querySelectorAll(".counter").forEach(el => {
                    const target = +el.dataset.target;
                    gsap.to(el, {
                        innerText: target,
                        duration: 2,
                        snap: { innerText: 1 },
                        ease: "power2.out"
                    });
                });
            },
            once: true
        });

        // ── Helper: animate a group of elements on scroll
        function revealOnScroll(selector, triggerSelector, props) {
            const els = document.querySelectorAll(selector);
            if (!els.length) return;
            const trigger = document.querySelector(triggerSelector || selector);
            if (!trigger) return;

            // Set initial hidden state
            gsap.set(els, { opacity: 0, y: props.y || 40 });

            ScrollTrigger.create({
                trigger: trigger,
                start: "top 92%",
                onEnter: () => {
                    gsap.to(els, {
                        opacity: 1,
                        y: 0,
                        duration: props.duration || 0.7,
                        stagger: props.stagger || 0,
                        ease: props.ease || "power3.out",
                        overwrite: true
                    });
                },
                once: true
            });
        }

        revealOnScroll(".gs-stat", ".stats-bar", { y:30, duration:.7, stagger:.15 });
        revealOnScroll(".gs-card", ".features-grid", { y:50, duration:.7, stagger:.12, ease:"back.out(1.4)" });
        revealOnScroll(".gs-step", ".steps-grid", { y:50, duration:.8, stagger:.2, ease:"back.out(1.5)" });
        revealOnScroll(".gs-testi", ".testimonials-grid", { y:40, duration:.7, stagger:.15 });

        // Section headers
        gsap.utils.toArray(".gs-up").forEach(el => {
            gsap.set(el, { opacity: 0, y: 40 });
            ScrollTrigger.create({
                trigger: el,
                start: "top 92%",
                onEnter: () => {
                    gsap.to(el, { opacity:1, y:0, duration:.7, ease:"power3.out", overwrite:true });
                },
                once: true
            });
        });

        // ── Navbar scroll
        window.addEventListener("scroll", () => {
            document.getElementById("navbar").classList.toggle("scrolled", window.scrollY > 50);
        });

        // Force ScrollTrigger to recalculate after page fully loads (handles #hash navigation)
        window.addEventListener("load", () => {
            ScrollTrigger.refresh(true);
        });
    </script>
</body>
</html>
