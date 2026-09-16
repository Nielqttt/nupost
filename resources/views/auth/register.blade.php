<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NUPost – Register</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;300;400;700&family=Arimo:wght@400&display=swap" rel="stylesheet">
<style>
:root {
    --color-primary: #002366;
    --color-white: #ffffff;
    --color-input-border: rgba(0,0,0,0.2);
    --font-inter: 'Inter', sans-serif;
    --radius-card: 8px;
    --radius-input: 5px;
    --radius-btn: 5px;
    --shadow-card: 0px 10px 15px rgba(0,0,0,0.1), 0px 4px 6px rgba(0,0,0,0.1);
    --card-width: 448px;
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html, body { height: 100%; font-family: var(--font-inter); }
.register { position: relative; width: 100%; min-height: 100vh; display: flex; align-items: center; justify-content: center; overflow: hidden; }
.register__bg { position: absolute; inset: 0; z-index: 0; }
.register__bg img { width: 100%; height: 100%; object-fit: cover; }
.register__card {
    position: relative; z-index: 1; background: white;
    width: var(--card-width); border-radius: var(--radius-card);
    box-shadow: var(--shadow-card); padding: 32px;
    display: flex; flex-direction: column; align-items: center;
}
.register__logo { width: 200px; margin-bottom: 24px; }
.register__logo img { width: 100%; }
.register__form { width: 100%; display: flex; flex-direction: column; gap: 20px; }
.register__field { display: flex; flex-direction: column; gap: 8px; }
.register__label { font-size: 12px; font-weight: 300; }
.register__input {
    width: 100%; height: 44px; border: 1px solid var(--color-input-border);
    border-radius: var(--radius-input); padding: 0 12px; font-size: 12px; outline: none; transition: border-color .15s;
}
.register__input:focus { border-color: var(--color-primary); }
.register__button {
    width: 100%; height: 40px; background: var(--color-primary);
    color: white; border: none; border-radius: var(--radius-btn);
    font-weight: 700; font-size: 12px; cursor: pointer; transition: opacity .15s;
}
.register__button:hover { opacity: .9; }
.message { font-size: 12px; text-align: center; padding: 8px 12px; border-radius: 6px; }
.error { color: #dc2626; background: #fee2e2; border: 1px solid #fecaca; }
.login-link { margin-top: 15px; font-size: 12px; text-align: center; }
.login-link a { color: var(--color-primary); text-decoration: none; font-weight: 600; }
.login-link a:hover { text-decoration: underline; }
.verify-notice {
    display: flex; align-items: flex-start; gap: 10px;
    background: #eff6ff; border: 1px solid #bfdbfe;
    border-radius: 8px; padding: 12px 14px; font-size: 12px; color: #1e40af; line-height: 1.5;
    width: 100%; margin-bottom: 20px;
}
.verify-notice svg { flex-shrink: 0; margin-top: 1px; }
@media(max-width: 768px) { .register__card { width: 92%; padding: 28px 24px; } }
</style>
</head>
<body>
<main class="register">
    <div class="register__bg">
        <img src="/assets/nubg1.png" alt="NU Lipa Campus">
    </div>
    <section class="register__card">
        <div class="register__logo">
            <img src="/assets/nupostlogo.png" alt="NUPost Logo">
        </div>
        <div class="verify-notice">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                <polyline points="22,6 12,13 2,6"/>
            </svg>
            A 6-digit verification code will be sent to your email after registration.
        </div>
        <form class="register__form" method="POST" action="{{ route('register.store') }}">
            @csrf
            @if(session('error'))
                <div class="message error">{{ session('error') }}</div>
            @endif
            <div class="register__field">
                <label class="register__label">FULL NAME:</label>
                <input class="register__input" type="text" name="name"
                       placeholder="Juan Dela Cruz" required value="{{ old('name') }}">
            </div>
            <div class="register__field">
                <label class="register__label">EMAIL ADDRESS:</label>
                <input class="register__input" type="email" name="email"
                       placeholder="your.email@nu-lipa.edu.ph" required value="{{ old('email') }}">
            </div>
            <div class="register__field">
                <label class="register__label">PASSWORD:</label>
                <div style="position:relative;">
                    <input class="register__input" type="password" name="password" id="reg-password" required
                           placeholder="Min. 8 chars, uppercase, number, symbol" style="padding-right: 40px;">
                    <button type="button" onclick="togglePassword('reg-password', this)" style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#6b7280; display:flex; align-items:center; padding:0;">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>
            <div class="register__field">
                <label class="register__label">CONFIRM PASSWORD:</label>
                <div style="position:relative;">
                    <input class="register__input" type="password" name="confirm_password" id="reg-confirm" required placeholder="Re-enter password" style="padding-right: 40px;">
                    <button type="button" onclick="togglePassword('reg-confirm', this)" style="position:absolute; right:12px; top:50%; transform:translateY(-50%); background:none; border:none; cursor:pointer; color:#6b7280; display:flex; align-items:center; padding:0;">
                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>
            <button class="register__button" type="submit">CREATE ACCOUNT</button>
        </form>
        <div class="login-link">
            Already have an account? <a href="{{ route('login') }}">Login here</a>
        </div>
    </section>
</main>
<script>
function togglePassword(id, btn) {
    const input = document.getElementById(id);
    const svg = btn.querySelector('svg');
    if (input.type === 'password') {
        input.type = 'text';
        svg.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
    } else {
        input.type = 'password';
        svg.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
    }
}
</script>
</body>
</html>