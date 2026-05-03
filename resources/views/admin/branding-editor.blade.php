@extends('layouts.admin')
@section('title', 'Templates')

@section('head-styles')
<style>
.tw { max-width: 1280px; }
.back-btn {
    display:inline-flex; align-items:center; gap:7px; padding:9px 16px;
    background:var(--card); border:1px solid rgba(0,0,0,0.08); border-radius:12px;
    font-size:13px; font-weight:600; color:var(--ink-mid); text-decoration:none;
    transition:all .15s; margin-bottom:18px;
}
.back-btn:hover { background:var(--cream-dark); }

/* HERO */
.hero {
    background:linear-gradient(135deg,#001a4d 0%,#002e7a 55%,#003a8c 100%);
    border-radius:22px; padding:22px 28px; margin-bottom:20px;
    display:flex; align-items:center; justify-content:space-between; gap:16px;
    box-shadow:0 8px 32px rgba(0,26,77,0.3); position:relative; overflow:hidden;
}
.hero::before { content:''; position:absolute; top:-40px; right:-40px; width:220px; height:220px; border-radius:50%; background:radial-gradient(circle,rgba(59,130,246,0.18) 0%,transparent 65%); pointer-events:none; }
.hero__title { font-family:'DM Serif Display',Georgia,serif; font-size:20px; color:white; margin-bottom:3px; position:relative;z-index:1; }
.hero__sub   { font-size:12px; color:rgba(255,255,255,0.5); position:relative;z-index:1; }
.hero__req   { background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.2); border-radius:14px; padding:10px 16px; position:relative;z-index:1; font-size:12px; color:rgba(255,255,255,0.75); }
.hero__req strong { color:white; display:block; font-size:13px; margin-bottom:2px; }

/* LAYOUT: canvas | right panel */
.layout { display:grid; grid-template-columns:1fr 320px; gap:18px; align-items:start; }

/* PANEL */
.pnl { background:var(--card); border:1px solid rgba(0,0,0,0.06); border-radius:18px; overflow:hidden; margin-bottom:16px; }
.pnl:last-child { margin-bottom:0; }
.pnl__h { padding:13px 18px; border-bottom:1px solid rgba(0,0,0,0.05); background:#fafbfc; display:flex; align-items:center; gap:9px; }
.pnl__ico { width:28px; height:28px; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.pnl__ttl { font-size:13.5px; font-weight:700; color:var(--ink); }
.pnl__b { padding:16px 18px; }
.pnl__sub { font-size:11.5px; color:var(--ink-soft); margin-bottom:14px; line-height:1.5; }

/* CANVAS PANEL */
.cvp { background:var(--card); border:1px solid rgba(0,0,0,0.06); border-radius:18px; overflow:hidden; position:sticky; top:16px; }
.cvp__h { padding:13px 18px; border-bottom:1px solid rgba(0,0,0,0.05); background:#fafbfc; display:flex; align-items:center; justify-content:space-between; }
.cvp__left { }
.cvp__ttl { font-size:13.5px; font-weight:700; color:var(--ink); }
.cvp__dim { font-size:10.5px; color:var(--ink-faint); margin-top:2px; }
.cvbg { background:#111; display:flex; align-items:center; justify-content:center; padding:12px; min-height:360px; position:relative; }
#tc { display:block; max-width:100%; max-height:520px; border-radius:4px; box-shadow:0 4px 24px rgba(0,0,0,0.5); }
.cv-hint { position:absolute; bottom:18px; left:50%; transform:translateX(-50%); background:rgba(0,0,0,0.65); color:white; font-size:11px; padding:4px 14px; border-radius:20px; pointer-events:none; backdrop-filter:blur(4px); white-space:nowrap; }
.drag-on { position:absolute; top:14px; left:50%; transform:translateX(-50%); background:rgba(0,60,220,0.85); color:white; font-size:11px; font-weight:700; padding:4px 14px; border-radius:20px; display:none; backdrop-filter:blur(4px); white-space:nowrap; }

/* PHOTO STRIP */
.photo-strip { display:flex; gap:8px; overflow-x:auto; padding-bottom:4px; margin-bottom:12px; }
.photo-strip::-webkit-scrollbar { height:4px; }
.photo-strip::-webkit-scrollbar-thumb { background:rgba(0,0,0,0.1); border-radius:4px; }
.ps-item {
    flex-shrink:0; width:64px; height:64px; border-radius:9px; overflow:hidden;
    cursor:pointer; border:2.5px solid transparent; transition:all .18s; position:relative;
    background:var(--cream-dark);
}
.ps-item:hover { border-color:rgba(0,46,122,0.4); }
.ps-item.active { border-color:#002e7a; box-shadow:0 0 0 3px rgba(0,46,122,0.2); }
.ps-item img { width:100%; height:100%; object-fit:cover; display:block; }
.ps-item__ck { position:absolute; top:3px; right:3px; width:16px; height:16px; border-radius:50%; background:#002e7a; display:none; align-items:center; justify-content:center; }
.ps-item.active .ps-item__ck { display:flex; }

/* SCALE ROW */
.sc-row { display:flex; align-items:center; gap:8px; padding:9px 18px; border-top:1px solid rgba(0,0,0,0.05); background:#fafbfc; }
.sc-row label { font-size:11px; color:var(--ink-soft); font-weight:600; white-space:nowrap; }
.sc-row input[type=range] { flex:1; accent-color:#002e7a; }
.sc-row .sv { font-size:11px; color:var(--ink-soft); width:40px; text-align:right; }

/* TOOLBAR */
.tb { display:flex; gap:6px; flex-wrap:wrap; padding:9px 18px; border-top:1px solid rgba(0,0,0,0.05); background:#fafbfc; }

/* WHITE FADE ROW */
.fade-row { display:flex; align-items:center; gap:8px; padding:10px 18px; border-top:1px solid rgba(0,0,0,0.05); background:#fafbfc; }
.fade-row label { font-size:11px; color:var(--ink-soft); font-weight:600; white-space:nowrap; width:85px; }
.fade-row input[type=range] { flex:1; accent-color:#002e7a; }
.fade-row span { font-size:11px; color:var(--ink-soft); width:36px; text-align:right; }

/* BUTTONS */
.btn { display:inline-flex; align-items:center; gap:6px; padding:8px 14px; border-radius:9px; font-size:12.5px; font-weight:600; cursor:pointer; font-family:var(--font); transition:all .15s; border:1px solid rgba(0,0,0,0.1); background:var(--card); color:var(--ink-mid); white-space:nowrap; text-decoration:none; }
.btn:hover { background:var(--cream-dark); color:var(--ink); }
.btn.on    { background:#002e7a; color:white; border-color:#002e7a; }
.btn--navy { background:#002e7a; color:white; border-color:#002e7a; }
.btn--navy:hover { background:#001a5c; color:white; }
.btn--green { background:#10b981; color:white; border-color:#10b981; }
.btn--green:hover { background:#059669; }
.btn--amber { background:#f59e0b; color:white; border-color:#f59e0b; }
.btn--amber:hover { background:#d97706; }
.btn--blue  { background:#1877f2; color:white; border-color:#1877f2; }
.btn--blue:hover { background:#1563c9; }
.btn--full  { width:100%; justify-content:center; padding:11px; }
.btn--sm    { padding:6px 12px; font-size:12px; }
.btn--red   { background:#dc2626; color:white; border-color:#dc2626; }
.btn--red:hover { background:#b91c1c; }

/* CAPTION BOX */
.cap-textarea {
    width:100%; border:1.5px solid rgba(0,0,0,0.1); border-radius:10px;
    padding:12px 14px; font-size:13.5px; font-family:var(--font); color:var(--ink);
    resize:vertical; outline:none; min-height:120px; line-height:1.6;
    background:var(--cream); transition:border-color .15s; box-sizing:border-box;
}
.cap-textarea:focus { border-color:#002e7a; box-shadow:0 0 0 3px rgba(0,46,122,0.08); }
.cap-label { font-size:10px; font-weight:800; letter-spacing:0.8px; text-transform:uppercase; color:var(--ink-faint); margin-bottom:6px; display:block; }

/* PROGRESS */
.prog-wrap { margin-top:10px; display:none; }
.prog-bar { height:6px; background:#e5e7eb; border-radius:3px; overflow:hidden; }
.prog-fill { height:100%; background:#002e7a; border-radius:3px; transition:width .3s; }
.prog-label { font-size:11.5px; color:var(--ink-soft); margin-top:6px; text-align:center; }

/* RESULTS */
.results-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:8px; margin-top:12px; }
.r-item { border-radius:8px; overflow:hidden; position:relative; cursor:pointer; transition:all .15s; background:var(--cream-dark); }
.r-item:hover { transform:scale(1.04); box-shadow:0 4px 12px rgba(0,0,0,0.15); }
.r-item img { width:100%; aspect-ratio:1; object-fit:cover; display:block; }
.r-item__num { position:absolute; bottom:4px; left:5px; background:rgba(0,0,0,0.6); color:white; font-size:10px; font-weight:700; padding:2px 7px; border-radius:10px; }
.r-item__dl  { position:absolute; inset:0; background:rgba(0,46,122,0.65); display:none; align-items:center; justify-content:center; color:white; font-size:11px; font-weight:700; border-radius:8px; }
.r-item:hover .r-item__dl { display:flex; }

/* DIVIDER */
.div { height:1px; background:rgba(0,0,0,0.06); margin:14px 0; }

/* POST TO FB SECTION */
.fb-section { background:linear-gradient(135deg,#e8f0fe,#f0f4ff); border:1.5px solid #c7d9ff; border-radius:14px; padding:16px; }
.fb-section__title { font-size:14px; font-weight:700; color:#1877f2; margin-bottom:4px; display:flex; align-items:center; gap:8px; }
.fb-section__sub { font-size:11.5px; color:#4a6fa5; margin-bottom:12px; line-height:1.5; }

/* COPIED BADGE */
.copied-badge { display:none; font-size:11px; color:#059669; font-weight:600; margin-left:8px; }

/* TOAST */
.toast { position:fixed; bottom:24px; right:24px; z-index:999; padding:12px 20px; border-radius:14px; font-size:13px; font-weight:500; box-shadow:0 4px 20px rgba(0,0,0,0.2); display:flex; align-items:center; gap:10px; animation:slideUp .3s ease,fadeOut .4s ease 2.8s forwards; }
.toast--ok  { background:#059669; color:white; }
.toast--err { background:#dc2626; color:white; }
.toast--info { background:#002e7a; color:white; }
@keyframes slideUp { from{transform:translateY(16px);opacity:0}to{transform:translateY(0);opacity:1} }
@keyframes fadeOut { from{opacity:1}to{opacity:0;pointer-events:none} }
</style>
@endsection

@section('content')
@php
    $mf = $request->media_files
        ? (is_array($request->media_files) ? $request->media_files
            : (json_decode($request->media_files, true) ?? explode(',', $request->media_files)))
        : [];
    $mf = array_values(array_filter(array_map(
        fn($f) => trim(is_array($f) ? ($f['path'] ?? $f['file'] ?? $f['filename'] ?? '') : $f), $mf
    )));
    $images = array_values(array_filter($mf, fn($f) =>
        in_array(strtolower(pathinfo($f, PATHINFO_EXTENSION)), ['jpg','jpeg','png','gif','webp'])
    ));
    $reqCaption = $request->caption ?? $request->description ?? '';
@endphp

<div class="tw">

<a href="{{ route('admin.requests.show', $request->id) }}" class="back-btn">
    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    Back to Request
</a>

<div class="hero">
    <div>
        <div class="hero__title">🖼 Templates</div>
        <div class="hero__sub">Apply NU LIPA frame · Drag photo · Edit caption · Post to Facebook</div>
    </div>
    <div class="hero__req">
        <strong>{{ $request->title }}</strong>
        {{ $request->requester }} · {{ $request->created_at->format('M j, Y') }}
    </div>
</div>

<div class="layout">

    {{-- LEFT: CANVAS ──────────────────────────── --}}
    <div>
        <div class="cvp">
            <div class="cvp__h">
                <div class="cvp__left">
                    <div class="cvp__ttl">Live Preview</div>
                    <div class="cvp__dim" id="cv-dim">Loading frame…</div>
                </div>
                <div style="display:flex;gap:6px;">
                    <button class="btn btn--sm" id="btn-drag" onclick="toggleDrag()" title="Drag photo to reposition">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="5 9 2 12 5 15"/><polyline points="9 5 12 2 15 5"/><polyline points="15 19 12 22 9 19"/><polyline points="19 9 22 12 19 15"/><line x1="2" y1="12" x2="22" y2="12"/><line x1="12" y1="2" x2="12" y2="22"/></svg>
                        Drag Photo
                    </button>
                    <button class="btn btn--sm" onclick="resetPhoto()">
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.5"/></svg>
                        Reset
                    </button>
                </div>
            </div>

            {{-- PHOTO STRIP --}}
            <div style="padding:12px 18px 0; background:#fafbfc; border-bottom:1px solid rgba(0,0,0,0.05);">
                <div class="photo-strip" id="photo-strip">
                    @foreach($images as $i => $img)
                    <div class="ps-item {{ $i===0?'active':'' }}"
                         data-src="/uploads/{{ $img }}"
                         data-filename="{{ $img }}"
                         onclick="pickPhoto(this)">
                        <img src="/uploads/{{ $img }}" alt="">
                        <div class="ps-item__ck">
                            <svg width="9" height="9" fill="none" stroke="white" stroke-width="3" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        </div>
                    </div>
                    @endforeach
                    {{-- Upload custom --}}
                    <div class="ps-item" style="display:flex;align-items:center;justify-content:center;border:2px dashed rgba(0,46,122,0.25);" onclick="document.getElementById('u-photo').click()" title="Upload photo">
                        <svg width="20" height="20" fill="none" stroke="#002e7a" stroke-width="1.8" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        <input type="file" id="u-photo" accept="image/*" style="display:none" onchange="uploadPhoto(this)">
                    </div>
                </div>
            </div>

            <div class="cvbg" id="cvbg">
                <canvas id="tc"></canvas>
                <div class="cv-hint" id="cv-hint">← Select a photo above</div>
                <div class="drag-on" id="drag-on">🖱 Drag Mode — click & drag to reposition photo</div>
            </div>

            {{-- SCALE --}}
            <div class="sc-row">
                <label>Photo Scale</label>
                <input type="range" id="sc" min="10" max="300" value="100" oninput="onScale(this.value)">
                <span class="sv" id="sv">100%</span>
            </div>

            {{-- WHITE FADE --}}
            <div class="fade-row">
                <label>White Fade Height</label>
                <input type="range" id="fade-h" min="0" max="60" value="20" oninput="document.getElementById('fh-v').textContent=this.value+'%';redraw()">
                <span id="fh-v">20%</span>
            </div>
            <div class="fade-row" style="padding-top:0;">
                <label>Fade Opacity</label>
                <input type="range" id="fade-o" min="0" max="100" value="90" oninput="document.getElementById('fo-v').textContent=this.value+'%';redraw()">
                <span id="fo-v">90%</span>
            </div>

            {{-- TOOLBAR --}}
            <div class="tb">
                <button class="btn btn--sm" id="btn-frm" onclick="toggleFrame()">Hide Frame</button>
                <button class="btn btn--sm" onclick="redraw()">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.5"/></svg>
                    Refresh
                </button>
                <button class="btn btn--green btn--sm" onclick="dlCurrent()">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Save This Photo
                </button>
            </div>
        </div>
    </div>

    {{-- RIGHT: CAPTION + ACTIONS ──────────── --}}
    <div>

        {{-- CAPTION --}}
        <div class="pnl">
            <div class="pnl__h">
                <div class="pnl__ico" style="background:#dbeafe;">
                    <svg width="13" height="13" fill="none" stroke="#2563eb" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </div>
                <div class="pnl__ttl">Caption</div>
            </div>
            <div class="pnl__b">
                <span class="cap-label">Edit your caption</span>
                <textarea class="cap-textarea" id="cap-text" placeholder="Write your caption here…">{{ $reqCaption }}</textarea>
                <div style="display:flex;gap:6px;margin-top:8px;">
                    <button class="btn btn--sm" onclick="resetCap()" style="flex:1;justify-content:center;">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.5"/></svg>
                        Reset
                    </button>
                    <button class="btn btn--navy btn--sm" onclick="copyCap()" style="flex:1;justify-content:center;">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                        Copy
                        <span class="copied-badge" id="copied-badge">✓ Copied!</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- APPLY ALL --}}
        <div class="pnl">
            <div class="pnl__h">
                <div class="pnl__ico" style="background:#dcfce7;">
                    <svg width="13" height="13" fill="none" stroke="#16a34a" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                </div>
                <div class="pnl__ttl">Apply to All Photos</div>
            </div>
            <div class="pnl__b">
                <p class="pnl__sub">Apply current frame + white fade to all <strong>{{ count($images) }} photos</strong>. Review thumbnails before saving.</p>

                <button class="btn btn--amber btn--full" id="btn-apply" onclick="applyAll()">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    Apply Template to All ({{ count($images) }} photos)
                </button>

                <div class="prog-wrap" id="prog-wrap">
                    <div class="prog-bar"><div class="prog-fill" id="prog-fill" style="width:0%"></div></div>
                    <div class="prog-label" id="prog-label">Processing…</div>
                </div>

                <div class="results-grid" id="results-grid"></div>

                <div id="save-all-wrap" style="display:none;margin-top:10px;">
                    <button class="btn btn--green btn--full" onclick="saveAll()">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                        Save All Photos
                    </button>
                </div>
            </div>
        </div>

        {{-- POST TO FACEBOOK --}}
        <div class="pnl">
            <div class="pnl__h">
                <div class="pnl__ico" style="background:#e8f0fe;">
                    <svg width="13" height="13" fill="#1877f2" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                </div>
                <div class="pnl__ttl" style="color:#1877f2;">Post to Facebook</div>
            </div>
            <div class="pnl__b">
                <div class="fb-section">
                    <div class="fb-section__title">
                        <svg width="16" height="16" fill="#1877f2" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                        How it works
                    </div>
                    <div class="fb-section__sub">
                        1. Click the button below<br>
                        2. Caption is auto-copied to your clipboard<br>
                        3. Facebook Create Post opens in new tab<br>
                        4. Paste caption (Ctrl+V) + attach your saved photo<br>
                        5. Click Post! 🚀
                    </div>
                    <button class="btn btn--blue btn--full" onclick="postToFB()" style="font-size:14px;padding:13px;">
                        <svg width="16" height="16" fill="white" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                        Copy Caption + Open Facebook
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
@endsection

@section('scripts')
<script>
/* ═══════════════════════
   STATE
═══════════════════════ */
let uImg = null, fImg = null;
let dragMode = false, showFrame = true;
let CW = 3840, CH = 3840;
const ph = { x:0, y:0, scale:1, dragging:false, sx:0, sy:0, ox:0, oy:0 };

const REQ_CAPTION = @json($reqCaption);
const ALL_PHOTOS  = @json(array_map(fn($f) => '/uploads/'.$f, $images));
const ALL_NAMES   = @json($images);
const REQ_ID      = {{ $request->id }};

let processedResults = []; // stores {dataUrl, name}

/* ═══════════════════════
   INIT
═══════════════════════ */
window.addEventListener('load', () => {
    initCanvas();
    loadFrame('/assets/templates/frame.png');
    bindDrag();

    const p = new URLSearchParams(window.location.search).get('photo');
    if (p) {
        const el = document.querySelector(`.ps-item[data-filename="${p}"]`);
        if (el) { document.querySelectorAll('.ps-item[data-src]').forEach(o=>o.classList.remove('active')); el.classList.add('active'); }
        loadPhoto('/uploads/' + p);
    } else {
        const first = document.querySelector('.ps-item[data-src].active');
        if (first) loadPhoto(first.dataset.src);
    }
});

function initCanvas() {
    const c = document.getElementById('tc');
    c.width = CW; c.height = CH;
    const ctx = c.getContext('2d');
    ctx.fillStyle = '#1a1a2e'; ctx.fillRect(0,0,CW,CH);
    ctx.fillStyle = 'rgba(255,255,255,0.15)';
    ctx.font = 'bold 80px Arial'; ctx.textAlign = 'center';
    ctx.fillText('← Select a photo', CW/2, CH/2);
}

/* ═══════════════════════
   FRAME
═══════════════════════ */
function loadFrame(src) {
    const img = new Image(); img.crossOrigin = 'anonymous';
    img.onload = () => {
        fImg = img; CW = img.naturalWidth; CH = img.naturalHeight;
        const c = document.getElementById('tc'); c.width=CW; c.height=CH;
        document.getElementById('cv-dim').textContent = CW + '×' + CH + 'px';
        redraw();
    };
    img.onerror = () => {
        document.getElementById('cv-dim').textContent = 'No frame.png — save to public/assets/templates/';
    };
    img.src = src + '?t=' + Date.now();
}

/* ═══════════════════════
   PHOTO
═══════════════════════ */
function loadPhoto(src) {
    document.getElementById('cv-hint').style.display = 'none';
    const img = new Image(); img.crossOrigin = 'anonymous';
    img.onload = () => {
        uImg=img; ph.x=0; ph.y=0; ph.scale=1;
        document.getElementById('sc').value=100;
        document.getElementById('sv').textContent='100%';
        redraw();
    };
    img.onerror = () => toast('Could not load photo.','err');
    img.src = src.startsWith('data:') ? src : src+'?t='+Date.now();
}

function pickPhoto(el) {
    document.querySelectorAll('.ps-item[data-src]').forEach(o=>o.classList.remove('active'));
    el.classList.add('active');
    loadPhoto(el.dataset.src);
}

function uploadPhoto(input) {
    const file = input.files[0]; if(!file) return;
    const r = new FileReader(); r.onload = e => {
        const img = new Image(); img.onload = ()=>{uImg=img;ph.x=0;ph.y=0;ph.scale=1;document.getElementById('sc').value=100;document.getElementById('sv').textContent='100%';redraw();};
        img.src = e.target.result;
    }; r.readAsDataURL(file);
}

/* ═══════════════════════
   DRAW
═══════════════════════ */
function redraw() {
    const canvas = document.getElementById('tc');
    if (canvas.width!==CW||canvas.height!==CH){canvas.width=CW;canvas.height=CH;}
    const ctx = canvas.getContext('2d');
    ctx.clearRect(0,0,CW,CH);

    // 1. White bg
    ctx.fillStyle='#ffffff'; ctx.fillRect(0,0,CW,CH);

    // 2. Photo — full canvas
    if (uImg) {
        const base=Math.max(CW/uImg.width,CH/uImg.height);
        const s=base*ph.scale, dw=uImg.width*s, dh=uImg.height*s;
        const dx=(CW-dw)/2+ph.x, dy=(CH-dh)/2+ph.y;
        ctx.save(); ctx.rect(0,0,CW,CH); ctx.clip();
        ctx.drawImage(uImg,dx,dy,dw,dh); ctx.restore();
    }

    // 3. White fade gradient (top)
    const fh = parseFloat(document.getElementById('fade-h').value)/100*CH;
    const fo = parseFloat(document.getElementById('fade-o').value)/100;
    if (fo>0 && fh>0) {
        const g=ctx.createLinearGradient(0,0,0,fh);
        g.addColorStop(0,   `rgba(255,255,255,${fo})`);
        g.addColorStop(0.5, `rgba(255,255,255,${(fo*0.6).toFixed(2)})`);
        g.addColorStop(1,   'rgba(255,255,255,0)');
        ctx.fillStyle=g; ctx.fillRect(0,0,CW,fh);
    }

    // 4. Frame PNG (logo on top)
    if (showFrame && fImg) ctx.drawImage(fImg,0,0,CW,CH);
}

/* ═══════════════════════
   DRAG
═══════════════════════ */
function bindDrag() {
    const c = document.getElementById('tc');
    c.addEventListener('mousedown', e=>{
        if(!dragMode||!uImg)return;
        const p=pos(e,c);ph.dragging=true;ph.sx=p.x;ph.sy=p.y;ph.ox=ph.x;ph.oy=ph.y;c.style.cursor='grabbing';
    });
    c.addEventListener('mousemove', e=>{
        if(!ph.dragging)return;
        const p=pos(e,c);ph.x=ph.ox+(p.x-ph.sx);ph.y=ph.oy+(p.y-ph.sy);redraw();
    });
    c.addEventListener('mouseup',()=>{ph.dragging=false;if(dragMode)c.style.cursor='grab';});
    c.addEventListener('mouseleave',()=>{ph.dragging=false;});
    c.addEventListener('wheel',e=>{
        if(!dragMode||!uImg)return;e.preventDefault();
        ph.scale=Math.max(0.1,Math.min(4,ph.scale+(e.deltaY>0?-0.05:0.05)));
        const pct=Math.round(ph.scale*100);
        document.getElementById('sc').value=pct;document.getElementById('sv').textContent=pct+'%';redraw();
    },{passive:false});
    c.addEventListener('touchstart',e=>{if(!dragMode)return;e.preventDefault();const p=pos(e.touches[0],c);ph.dragging=true;ph.sx=p.x;ph.sy=p.y;ph.ox=ph.x;ph.oy=ph.y;},{passive:false});
    c.addEventListener('touchmove', e=>{if(!ph.dragging)return;e.preventDefault();const p=pos(e.touches[0],c);ph.x=ph.ox+(p.x-ph.sx);ph.y=ph.oy+(p.y-ph.sy);redraw();},{passive:false});
    c.addEventListener('touchend',()=>{ph.dragging=false;});
}

function pos(e,c){const r=c.getBoundingClientRect();return{x:(e.clientX-r.left)*(CW/r.width),y:(e.clientY-r.top)*(CH/r.height)};}
function toggleDrag(){dragMode=!dragMode;document.getElementById('btn-drag').classList.toggle('on',dragMode);document.getElementById('drag-on').style.display=dragMode?'block':'none';document.getElementById('tc').style.cursor=dragMode?'grab':'crosshair';}
function onScale(v){ph.scale=v/100;document.getElementById('sv').textContent=v+'%';redraw();}
function resetPhoto(){ph.x=0;ph.y=0;ph.scale=1;document.getElementById('sc').value=100;document.getElementById('sv').textContent='100%';redraw();}
function toggleFrame(){showFrame=!showFrame;document.getElementById('btn-frm').textContent=showFrame?'Hide Frame':'Show Frame';redraw();}

/* ═══════════════════════
   CAPTION
═══════════════════════ */
function resetCap(){ document.getElementById('cap-text').value = REQ_CAPTION; }

function copyCap(){
    const txt = document.getElementById('cap-text').value;
    if(!txt){toast('Caption is empty!','err');return;}
    navigator.clipboard.writeText(txt).then(()=>{
        const badge = document.getElementById('copied-badge');
        badge.style.display='inline';
        setTimeout(()=>badge.style.display='none', 2000);
        toast('Caption copied to clipboard! ✓');
    }).catch(()=>{
        // Fallback
        const ta=document.createElement('textarea');ta.value=txt;document.body.appendChild(ta);ta.select();document.execCommand('copy');document.body.removeChild(ta);
        toast('Caption copied! ✓');
    });
}

/* ═══════════════════════
   APPLY ALL
═══════════════════════ */
async function applyAll() {
    if(ALL_PHOTOS.length===0){toast('No photos in this request.','err');return;}
    const btn=document.getElementById('btn-apply');
    const progWrap=document.getElementById('prog-wrap');
    const progFill=document.getElementById('prog-fill');
    const progLabel=document.getElementById('prog-label');
    const grid=document.getElementById('results-grid');
    const saveWrap=document.getElementById('save-all-wrap');

    btn.disabled=true; btn.textContent='Processing…';
    progWrap.style.display='block'; grid.innerHTML=''; saveWrap.style.display='none';
    processedResults=[];

    // Save current photo state
    const savedImg=uImg, savedPh={...ph};

    for(let i=0;i<ALL_PHOTOS.length;i++){
        progLabel.textContent=`Applying template to photo ${i+1} of ${ALL_PHOTOS.length}…`;
        progFill.style.width=((i/ALL_PHOTOS.length)*100)+'%';

        await new Promise(res=>{
            const img=new Image();img.crossOrigin='anonymous';
            img.onload=()=>{
                uImg=img;
                ph.x=0;ph.y=0;ph.scale=1;
                redraw();
                setTimeout(()=>{
                    const dataUrl=document.getElementById('tc').toDataURL('image/jpeg',0.93);
                    const name='nupost_{{ $request->id }}_'+(i+1)+'_'+ALL_NAMES[i];
                    processedResults.push({dataUrl,name,src:ALL_PHOTOS[i]});

                    // Thumbnail
                    const item=document.createElement('div');
                    item.className='r-item';item.title='Click to save';
                    item.innerHTML=`<img src="${dataUrl}"><div class="r-item__num">${i+1}</div><div class="r-item__dl">⬇ Save</div>`;
                    const dl=(()=>{const d=dataUrl,n=name;return()=>{const a=document.createElement('a');a.href=d;a.download=n;a.click();};})();
                    item.onclick=dl;
                    grid.appendChild(item);
                    res();
                },120);
            };
            img.onerror=()=>res();
            img.src=ALL_PHOTOS[i]+'?t='+Date.now();
        });
    }

    // Restore original photo
    uImg=savedImg; Object.assign(ph,savedPh);
    if(uImg){document.getElementById('sc').value=Math.round(ph.scale*100);document.getElementById('sv').textContent=Math.round(ph.scale*100)+'%';}
    redraw();

    progFill.style.width='100%';
    progLabel.textContent=`✅ Done! ${processedResults.length} photos ready. Click thumbnails to save individually.`;
    btn.disabled=false;
    btn.innerHTML='<svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg> Apply Template to All ({{ count($images) }} photos)';
    saveWrap.style.display='block';
    toast(`✅ ${processedResults.length} photos ready!`,'ok');
}

function saveAll(){
    if(processedResults.length===0){toast('Apply template first!','err');return;}
    processedResults.forEach((r,i)=>{
        setTimeout(()=>{
            const a=document.createElement('a');a.href=r.dataUrl;a.download=r.name;a.click();
        },i*400);
    });
    toast(`Saving ${processedResults.length} photos…`,'info');
}

/* ═══════════════════════
   DOWNLOAD CURRENT
═══════════════════════ */
function dlCurrent(){
    if(!uImg){toast('Select a photo first!','err');return;}
    const a=document.createElement('a');
    a.href=document.getElementById('tc').toDataURL('image/jpeg',0.95);
    a.download='nupost_{{ $request->id }}_'+Date.now()+'.jpg';
    a.click();toast('Photo saved!');
}

/* ═══════════════════════
   POST TO FACEBOOK
═══════════════════════ */
function postToFB(){
    const caption = document.getElementById('cap-text').value || REQ_CAPTION;

    // Copy caption to clipboard
    if(caption){
        navigator.clipboard.writeText(caption).then(()=>{
            toast('Caption copied! Now paste it in Facebook after the tab opens. 📋','info');
        }).catch(()=>{
            // Fallback
            const ta=document.createElement('textarea');ta.value=caption;document.body.appendChild(ta);ta.select();document.execCommand('copy');document.body.removeChild(ta);
            toast('Caption copied! Now paste it in Facebook. 📋','info');
        });
    }

    // Open FB create post (with a small delay so toast shows first)
    setTimeout(()=>{
        window.open('https://www.facebook.com/', '_blank');
    }, 600);
}

/* TOAST */
function toast(msg,type='ok'){
    document.getElementById('_t')?.remove();
    const t=document.createElement('div');t.id='_t';t.className='toast toast--'+type;
    t.innerHTML=`<svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">${type==='ok'?'<polyline points="20 6 9 17 4 12"/>':type==='info'?'<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>':'<circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>'}</svg>${msg}`;
    document.body.appendChild(t);setTimeout(()=>t.remove(),3500);
}
</script>
@endsection