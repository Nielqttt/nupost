@extends('layouts.admin')
@section('title', 'Settings')

@section('head-styles')
<style>
.page-hd { margin-bottom: 24px; }
.page-hd__title { font-family: var(--font-disp); font-size: 22px; color: var(--ink); }
.page-hd__sub   { font-size: 13px; color: var(--ink-soft); margin-top: 3px; }

.settings-layout { display: grid; grid-template-columns: 220px 1fr; gap: 22px; align-items: start; }

/* SIDENAV */
.settings-nav { background: var(--card); border-radius: var(--radius); border: 1px solid rgba(0,0,0,0.06); box-shadow: var(--shadow-sm); overflow: hidden; position: sticky; top: 0; }
.settings-nav__item {
    display: flex; align-items: center; gap: 10px;
    padding: 13px 18px; font-size: 13.5px; font-weight: 500;
    color: var(--ink-soft); text-decoration: none; transition: all .15s;
    border-bottom: 1px solid var(--cream-dark); cursor: pointer;
    background: none; border-left: none; border-right: none; border-top: none;
    width: 100%; font-family: var(--font); text-align: left;
}
.settings-nav__item:last-child { border-bottom: none; }
.settings-nav__item:hover { background: var(--cream-dark); color: var(--ink); }
.settings-nav__item.active { background: var(--navy); color: white; font-weight: 600; }
.settings-nav__item.active svg { color: white !important; }

/* PANEL */
.sp { background: var(--card); border-radius: var(--radius); border: 1px solid rgba(0,0,0,0.06); box-shadow: var(--shadow-sm); overflow: hidden; margin-bottom: 18px; }
.sp:last-child { margin-bottom: 0; }
.sp__head { padding: 18px 22px; border-bottom: 1.5px solid var(--card-border); background: var(--cream-dark); }
.sp__title { font-family: var(--font-disp); font-size: 17px; color: var(--ink); }
.sp__sub   { font-size: 12.5px; color: var(--ink-soft); margin-top: 3px; }
.sp__body  { padding: 22px; }

/* FIELDS */
.field { margin-bottom: 18px; }
.field:last-child { margin-bottom: 0; }
.field label { display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--ink-faint); margin-bottom: 7px; }
.field input, .field select, .field textarea {
    width: 100%; border: 1px solid rgba(0,0,0,0.06); border-radius: 11px;
    padding: 10px 14px; font-size: 13.5px; font-family: var(--font);
    color: var(--ink); background: var(--cream); outline: none; transition: border-color .15s;
}
.field input:focus, .field select:focus, .field textarea:focus { border-color: var(--navy-light); box-shadow: 0 0 0 3px rgba(30,79,216,0.08); }
.field input[readonly] { background: var(--cream-dark); color: var(--ink-soft); cursor: not-allowed; }
.field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.field-hint { font-size: 11.5px; color: var(--ink-faint); margin-top: 5px; }

/* TOGGLE */
.toggle-list { display: flex; flex-direction: column; }
.toggle-item { display: flex; align-items: center; justify-content: space-between; padding: 14px 0; border-bottom: 1px solid var(--cream-dark); }
.toggle-item:last-child { border-bottom: none; }
.toggle-label { font-size: 13.5px; font-weight: 600; color: var(--ink); margin-bottom: 2px; }
.toggle-desc  { font-size: 12px; color: var(--ink-soft); }
.toggle-switch { position: relative; display: inline-block; width: 44px; height: 24px; flex-shrink: 0; }
.toggle-switch input { opacity: 0; width: 0; height: 0; }
.toggle-slider { position: absolute; cursor: pointer; inset: 0; border-radius: 24px; background: var(--cream-dark); transition: .2s; }
.toggle-slider:before { content: ''; position: absolute; width: 18px; height: 18px; left: 3px; bottom: 3px; border-radius: 50%; background: white; transition: .2s; box-shadow: 0 1px 4px rgba(0,0,0,0.15); }
.toggle-switch input:checked + .toggle-slider { background: var(--navy); }
.toggle-switch input:checked + .toggle-slider:before { transform: translateX(20px); }

/* SYSINFO */
.sysinfo { display: flex; flex-direction: column; }
.sysinfo-row { display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid var(--cream-dark); }
.sysinfo-row:last-child { border-bottom: none; }
.sysinfo-label { font-size: 12.5px; color: var(--ink-soft); }
.sysinfo-value { font-size: 12.5px; font-weight: 600; color: var(--ink); }

/* TOAST */
.toast { position: fixed; bottom: 24px; right: 24px; z-index: 999; background: #059669; color: white; padding: 12px 20px; border-radius: 14px; font-size: 13px; font-weight: 500; box-shadow: 0 4px 20px rgba(0,0,0,0.15); display: flex; align-items: center; gap: 10px; animation: slideUp .3s ease, fadeOut .4s ease 2.6s forwards; }
@keyframes slideUp { from { transform: translateY(16px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
@keyframes fadeOut { from { opacity: 1; } to { opacity: 0; pointer-events: none; } }
</style>
@endsection

@section('content')

<div class="page-hd">
    <div class="page-hd__title">Settings</div>
    <div class="page-hd__sub">Manage admin account, notifications & system configuration</div>
</div>

<div class="settings-layout">

    {{-- SIDENAV --}}
    <div class="settings-nav">
        <button class="settings-nav__item active" onclick="navScrollTo(event,'account')">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Account
        </button>
        <button class="settings-nav__item" onclick="navScrollTo(event,'security')">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            Security
        </button>
        <button class="settings-nav__item" onclick="navScrollTo(event,'notifications')">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            Notifications
        </button>
        <button class="settings-nav__item" onclick="navScrollTo(event,'system')">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
            System Info
        </button>
    </div>

    {{-- CONTENT --}}
    <div>
        {{-- ACCOUNT --}}
        <div class="sp" id="account">
            <div class="sp__head">
                <div class="sp__title">Admin Account</div>
                <div class="sp__sub">Your NUPost administrator profile</div>
            </div>
            <div class="sp__body">
                {{-- Avatar --}}
                <div style="display:flex;align-items:center;gap:18px;margin-bottom:24px;padding-bottom:20px;border-bottom:1.5px solid var(--card-border);">
                    <div style="width:64px;height:64px;border-radius:50%;background:var(--navy);display:flex;align-items:center;justify-content:center;font-size:26px;font-weight:800;color:white;flex-shrink:0;box-shadow:0 4px 16px rgba(0,35,102,0.2);">A</div>
                    <div>
                        <div style="font-size:16px;font-weight:700;color:var(--ink);">{{ session('admin_name', 'Administrator') }}</div>
                        <div style="font-size:13px;color:var(--ink-soft);margin-top:2px;">{{ session('admin_email', 'admin@nupost.com') }}</div>
                        <div style="margin-top:8px;"><span style="font-size:11px;padding:3px 10px;background:var(--navy-pale);color:var(--navy);border-radius:20px;font-weight:700;border:1px solid rgba(0,35,102,0.15);">ADMIN</span></div>
                    </div>
                </div>
                <form action="{{ route('admin.settings.profile') }}" method="POST">
                    @csrf
                    <div class="field-row">
                        <div class="field"><label>Name</label><input type="text" name="name" value="{{ session('admin_name', 'Administrator') }}" required></div>
                        <div class="field"><label>Email Address</label><input type="email" value="{{ session('admin_email', 'admin@nupost.com') }}" readonly><div class="field-hint">Admin credentials are managed in the database.</div></div>
                    </div>
                    <div class="field"><label>Organization</label><input type="text" value="NU Lipa Marketing Office" readonly></div>
                    <div style="margin-top:20px;text-align:right;">
                        <button type="submit" style="background:var(--navy);color:white;border:none;padding:10px 20px;border-radius:10px;font-size:13.5px;font-weight:600;cursor:pointer;font-family:var(--font);box-shadow:0 2px 8px rgba(0,35,102,0.2);">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- SECURITY --}}
        <div class="sp" id="security">
            <div class="sp__head">
                <div class="sp__title">Security</div>
                <div class="sp__sub">Password and login settings</div>
            </div>
            <div class="sp__body">
                <div style="background:var(--navy-pale);border:1.5px solid rgba(0,35,102,0.15);border-radius:12px;padding:14px 18px;margin-bottom:20px;font-size:13px;color:var(--navy);display:flex;align-items:flex-start;gap:10px;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px;"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    <div>Admin credentials are securely stored in the database. Contact the system administrator to change your password.</div>
                </div>
                <div class="field-row">
                    <div class="field"><label>Current Password</label><input type="password" value="********" readonly></div>
                    <div class="field"><label>Email</label><input type="email" value="{{ session('admin_email', 'admin@nupost.com') }}" readonly></div>
                </div>
                <p style="font-size:12.5px;color:var(--ink-soft);margin-top:4px;">Passwords are encrypted using bcrypt and cannot be viewed.</p>
            </div>
        </div>

        {{-- NOTIFICATIONS --}}
        <div class="sp" id="notifications">
            <div class="sp__head">
                <div class="sp__title">Notification Settings</div>
                <div class="sp__sub">Configure when requestors receive email notifications</div>
            </div>
            <div class="sp__body">
                @php
                    $notif_settings=[
                        ['label'=>'Status Update Emails', 'desc'=>'Send email when request status changes'],
                        ['label'=>'Approval Emails',      'desc'=>'Notify requestors when request is approved'],
                        ['label'=>'Rejection Emails',     'desc'=>'Notify requestors when request is rejected'],
                        ['label'=>'Comment Notifications','desc'=>'Send email when admin posts a comment'],
                        ['label'=>'New Request Alert',    'desc'=>'Receive notification when a new request is submitted'],
                    ];
                @endphp
                <div class="toggle-list">
                    @foreach($notif_settings as $ns)
                    <div class="toggle-item">
                        <div>
                            <div class="toggle-label">{{ $ns['label'] }}</div>
                            <div class="toggle-desc">{{ $ns['desc'] }}</div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" checked>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                    @endforeach
                </div>
                <p style="font-size:12px;color:var(--ink-faint);margin-top:16px;padding-top:16px;border-top:1.5px solid var(--card-border);">Admin email is sent via Gmail SMTP configured in your <code style="background:var(--cream-dark);padding:2px 5px;border-radius:4px;">.env</code> file.</p>
            </div>
        </div>

        {{-- SYSTEM INFO --}}
        <div class="sp" id="system">
            <div class="sp__head">
                <div class="sp__title">System Information</div>
                <div class="sp__sub">Current environment and configuration</div>
            </div>
            <div class="sp__body">
                <div class="sysinfo">
                    <div class="sysinfo-row"><span class="sysinfo-label">Application</span><span class="sysinfo-value">NUPost — NU Lipa Social Media Request System</span></div>
                    <div class="sysinfo-row"><span class="sysinfo-label">Laravel Version</span><span class="sysinfo-value">{{ app()->version() }}</span></div>
                    <div class="sysinfo-row"><span class="sysinfo-label">PHP Version</span><span class="sysinfo-value">{{ PHP_VERSION }}</span></div>
                    <div class="sysinfo-row"><span class="sysinfo-label">Environment</span><span class="sysinfo-value" style="color:{{ app()->environment('production')?'#10b981':'#f59e0b' }}">{{ ucfirst(app()->environment()) }}</span></div>
                    <div class="sysinfo-row"><span class="sysinfo-label">Database</span><span class="sysinfo-value">{{ config('database.default') }} — {{ config('database.connections.mysql.database') }}</span></div>
                    <div class="sysinfo-row"><span class="sysinfo-label">Mail Driver</span><span class="sysinfo-value">{{ config('mail.default') }} ({{ config('mail.mailers.smtp.host') }})</span></div>
                    <div class="sysinfo-row"><span class="sysinfo-label">Total Requests</span><span class="sysinfo-value">{{ \App\Models\PostRequest::count() }}</span></div>
                    <div class="sysinfo-row"><span class="sysinfo-label">Total Users</span><span class="sysinfo-value">{{ \App\Models\User::count() }}</span></div>
                    <div class="sysinfo-row"><span class="sysinfo-label">Server Time</span><span class="sysinfo-value">{{ now()->format('F j, Y g:i A') }}</span></div>
                    <div class="sysinfo-row">
                        <span class="sysinfo-label">Gemini AI</span>
                        <span class="sysinfo-value" style="color:{{ config('services.gemini.key')?'#10b981':'#ef4444' }}">
                            {{ config('services.gemini.key')? '✅ Connected (gemini-flash-lite-latest)' : '❌ Not configured' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
<div class="toast" id="toast">
    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
    {{ session('success') }}
</div>
@endif
@endsection

@section('scripts')
<script>
function navScrollTo(e, id){
    e.preventDefault();
    const section = document.getElementById(id);
    const scroller = document.querySelector('.page-content');
    if(section && scroller){
        const offset = section.offsetTop - scroller.offsetTop - 16;
        scroller.scrollTo({ top: offset, behavior: 'smooth' });
    }
    document.querySelectorAll('.settings-nav__item').forEach(el => el.classList.remove('active'));
    e.currentTarget.classList.add('active');
}
setTimeout(()=>document.getElementById('toast')?.remove(), 3000);
</script>
@endsection