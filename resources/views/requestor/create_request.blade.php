@extends('layouts.requestor')

@section('title', 'Create Request')
@section('page-title', 'Create Request')

@section('head-styles')
<style>

/* ── PAGE SHELL ─────────────────────── */
.create-page {
    min-height: calc(100vh - 64px);
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 32px 24px 60px;
    background: #e8ecf4;
}

/* ── HERO CARD ───────────────────────── */
.hero-card {
    width: 100%; max-width: 680px;
    background: linear-gradient(135deg, #001a4d 0%, #002366 60%, #003080 100%);
    border-radius: 22px; padding: 30px 32px 26px;
    margin-bottom: 18px; position: relative; overflow: hidden;
}
.hero-card::before {
    content: '';
    position: absolute; right: -40px; top: -40px;
    width: 200px; height: 200px; border-radius: 50%;
    background: rgba(59,110,245,0.1);
}
.hero-card::after {
    content: '';
    position: absolute; right: 60px; bottom: -60px;
    width: 140px; height: 140px; border-radius: 50%;
    background: rgba(59,110,245,0.06);
}
.hero-eyebrow {
    display: inline-flex; align-items: center; gap: 6px;
    font-size: 10px; font-weight: 700; letter-spacing: 1.1px; text-transform: uppercase;
    color: #93c5fd; background: rgba(147,197,253,0.12);
    border: 1px solid rgba(147,197,253,0.22);
    padding: 4px 12px; border-radius: 20px; margin-bottom: 14px;
    position: relative; z-index: 1;
}
.hero-card h1 {
    font-size: 26px; font-weight: 800; color: white;
    letter-spacing: -0.6px; margin-bottom: 8px; line-height: 1.15;
    position: relative; z-index: 1;
}
.hero-card h1 span { color: #93c5fd; }
.hero-card p {
    font-size: 12.5px; color: rgba(255,255,255,0.45);
    line-height: 1.65; max-width: 460px; position: relative; z-index: 1;
}
.hero-progress { margin-top: 22px; position: relative; z-index: 1; }
.hero-progress__label {
    display: flex; justify-content: space-between;
    font-size: 10.5px; color: rgba(255,255,255,0.38); margin-bottom: 7px;
}
.hero-progress__track {
    height: 4px; background: rgba(255,255,255,0.1); border-radius: 4px;
}
.hero-progress__fill {
    height: 4px; background: linear-gradient(90deg, #3b6ef5, #60a5fa);
    border-radius: 4px; width: 33%;
    transition: width .4s ease;
}

/* ── ALERTS ─────────────────────────── */
.alert {
    padding: 12px 16px; border-radius: 12px; font-size: 13px;
    margin-bottom: 16px; font-weight: 500; width: 100%; max-width: 680px;
}
.alert--success { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
.alert--error   { background: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }

/* ── FORM WRAPPER ───────────────────── */
.form-body { width: 100%; max-width: 680px; display: flex; flex-direction: column; gap: 14px; }

/* ── SECTION CARD ───────────────────── */
.form-section {
    background: white; border-radius: 18px;
    border: 1.5px solid #e4e8f0;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    transition: box-shadow .2s, border-color .2s;
}
.form-section:focus-within {
    box-shadow: 0 4px 20px rgba(59,110,245,0.08);
    border-color: rgba(59,110,245,0.25);
}
.section-head {
    display: flex; align-items: center; gap: 14px;
    padding: 15px 22px; border-bottom: 1.5px solid #f0f2f8;
    background: #fafbfd;
}
.section-num {
    width: 28px; height: 28px; border-radius: 8px;
    background: #002366; color: white;
    font-size: 12px; font-weight: 800;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.section-title-txt { font-size: 13.5px; font-weight: 700; color: #111827; }
.section-sub { font-size: 11px; color: #9ca3af; margin-top: 1px; }
.section-body { padding: 22px 24px; }

/* ── FIELDS ─────────────────────────── */
.field { margin-bottom: 16px; }
.field:last-child { margin-bottom: 0; }
.field label {
    display: block; font-size: 10.5px; font-weight: 700; color: #6b7280;
    margin-bottom: 7px; letter-spacing: 0.4px; text-transform: uppercase;
}
.field label .req { color: #ef4444; margin-left: 2px; }
.field label .opt { color: #d1d5db; font-weight: 400; text-transform: none; font-size: 11px; letter-spacing: 0; }
.field input[type="text"],
.field input[type="date"],
.field select,
.field textarea {
    width: 100%; border: 1.5px solid #e4e8f0; border-radius: 11px;
    padding: 11px 14px; font-size: 13.5px; font-family: var(--font);
    color: #111827; background: #fafbfd;
    outline: none; transition: border-color .15s, box-shadow .15s, background .15s;
}
.field input:focus, .field select:focus, .field textarea:focus {
    border-color: #3b6ef5; background: white;
    box-shadow: 0 0 0 3px rgba(59,110,245,0.08);
}
.field textarea { resize: vertical; min-height: 110px; line-height: 1.65; }
.field input::placeholder, .field textarea::placeholder { color: #d1d5db; }
.field select { appearance: none; cursor: pointer; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 12px center; padding-right: 36px; }
.field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

/* ── DATE PICKER WITH CALENDAR LOAD ─── */
.date-wrapper { position: relative; }
.date-input-wrap { position: relative; }
.date-input-wrap input[type="date"] { padding-right: 44px; cursor: pointer; }
.date-cal-icon {
    position: absolute; right: 13px; top: 50%; transform: translateY(-50%);
    color: #9ca3af; pointer-events: none;
}

/* Calendar load panel */
.cal-load-panel {
    display: none; margin-top: 10px;
    background: white; border: 1.5px solid #e4e8f0;
    border-radius: 14px; overflow: hidden;
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    animation: panelIn .18s ease;
}
@keyframes panelIn { from { opacity:0; transform:translateY(-6px); } to { opacity:1; transform:none; } }
.cal-load-panel.visible { display: block; }

.cal-panel-header {
    padding: 12px 16px; border-bottom: 1px solid #f0f2f8;
    background: #fafbfd; display: flex; align-items: center; justify-content: space-between;
}
.cal-panel-date-label {
    font-size: 12.5px; font-weight: 700; color: #111827;
}
.cal-panel-meta { font-size: 11px; color: #9ca3af; }

.cal-load-body { padding: 14px 16px; }

/* Capacity bar */
.cal-capacity-wrap { margin-bottom: 14px; }
.cal-capacity-label {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 6px;
}
.cal-capacity-label span { font-size: 11.5px; color: #6b7280; font-weight: 500; }
.cal-capacity-label strong { font-size: 13px; font-weight: 800; }
.cal-capacity-label strong.low    { color: #16a34a; }
.cal-capacity-label strong.medium { color: #d97706; }
.cal-capacity-label strong.high   { color: #dc2626; }

.cal-bar-track {
    height: 8px; background: #f3f4f6; border-radius: 8px; overflow: hidden;
}
.cal-bar-fill {
    height: 8px; border-radius: 8px;
    transition: width .5s cubic-bezier(.34,1.4,.64,1);
}
.cal-bar-fill.low    { background: linear-gradient(90deg, #4ade80, #16a34a); }
.cal-bar-fill.medium { background: linear-gradient(90deg, #fbbf24, #d97706); }
.cal-bar-fill.high   { background: linear-gradient(90deg, #f87171, #dc2626); }

/* Existing requests mini-list */
.cal-req-list { display: flex; flex-direction: column; gap: 7px; margin-top: 12px; }
.cal-req-item {
    display: flex; align-items: center; gap: 10px;
    padding: 9px 12px; border-radius: 9px;
    background: #f8f9fb; border: 1px solid #f0f2f8;
    font-size: 12px;
}
.cal-req-dot {
    width: 8px; height: 8px; border-radius: 50%; flex-shrink: 0;
}
.cal-req-dot.pending      { background: #9ca3af; }
.cal-req-dot.approved     { background: #16a34a; }
.cal-req-dot.under-review { background: #d97706; }
.cal-req-name { font-weight: 600; color: #374151; flex: 1; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.cal-req-status { font-size: 10.5px; color: #9ca3af; white-space: nowrap; }

.cal-empty-day {
    display: flex; flex-direction: column; align-items: center; gap: 6px;
    padding: 18px 0; text-align: center;
}
.cal-empty-day p { font-size: 12.5px; color: #9ca3af; }
.cal-empty-day strong { display: block; font-size: 13px; color: #16a34a; font-weight: 700; }

.cal-tip {
    margin-top: 12px; padding: 9px 12px;
    background: #fffbeb; border: 1px solid #fde68a; border-radius: 9px;
    font-size: 11.5px; color: #92400e; line-height: 1.5;
    display: none;
}
.cal-tip.visible { display: block; }

.cal-loading {
    padding: 20px; text-align: center;
    font-size: 12.5px; color: #9ca3af;
    display: flex; align-items: center; justify-content: center; gap: 8px;
}
.cal-spinner {
    width: 16px; height: 16px; border: 2px solid #e4e8f0;
    border-top-color: #3b6ef5; border-radius: 50%;
    animation: spin 0.7s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* ── PLATFORM BUTTONS ───────────────── */
.platform-group { display: flex; gap: 8px; flex-wrap: wrap; }
.platform-btn {
    padding: 9px 18px; border-radius: 10px; border: 1.5px solid #e4e8f0;
    font-size: 12.5px; font-weight: 600; cursor: pointer;
    background: #fafbfd; color: #6b7280;
    font-family: var(--font); transition: all .15s;
    display: flex; align-items: center; gap: 8px;
}
.platform-btn:hover:not(.selected) { border-color: #93c5fd; color: #1d4ed8; background: #eff6ff; }
.platform-btn.selected { background: #002366; color: white; border-color: #002366; box-shadow: 0 2px 10px rgba(0,26,110,0.25); }
.platform-dot { width: 9px; height: 9px; border-radius: 50%; }
.platform-dot--fb { background: #1877f2; }
.platform-dot--li { background: #0a66c2; }
.platform-btn.selected .platform-dot--fb,
.platform-btn.selected .platform-dot--li { background: rgba(255,255,255,0.6); }

/* ── MEDIA UPLOAD ───────────────────── */
.upload-zone {
    border: 2px dashed #d1d5db; border-radius: 14px;
    padding: 28px 20px; text-align: center; background: #fafbfd;
    display: flex; flex-direction: column; align-items: center; gap: 10px;
    cursor: pointer; transition: all .15s;
}
.upload-zone:hover { border-color: #3b6ef5; background: #eff6ff; }
.upload-icon-wrap {
    width: 44px; height: 44px; border-radius: 12px;
    background: #dbeafe; display: flex; align-items: center; justify-content: center;
}
.upload-zone p { font-size: 13px; color: #6b7280; }
.upload-zone strong { color: #3b6ef5; font-weight: 700; }
.upload-tags { display: flex; gap: 6px; }
.upload-tag { font-size: 10.5px; color: #9ca3af; background: #f3f4f6; padding: 3px 9px; border-radius: 6px; font-weight: 500; }
.upload-previews { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 12px; }
.preview-wrap { position: relative; width: 82px; height: 82px; }
.preview-thumb { width: 82px; height: 82px; border-radius: 10px; object-fit: cover; border: 1.5px solid #e4e8f0; display: block; }
.preview-remove {
    position: absolute; top: -7px; right: -7px;
    width: 22px; height: 22px; background: #ef4444; color: white;
    border: 2px solid white; border-radius: 50%; font-size: 12px;
    cursor: pointer; display: flex; align-items: center; justify-content: center;
    box-shadow: 0 1px 4px rgba(0,0,0,0.15);
}
#media-input { display: none; }

/* ── AI SECTION ─────────────────────── */
.ai-section {
    background: white;
    border: 1.5px solid #e4e8f0;
    border-top: 3px solid #7c3aed;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
.ai-head {
    display: flex; align-items: center; justify-content: space-between;
    padding: 15px 22px; border-bottom: 1.5px solid #f0f2f8;
    background: #fafbfd;
}
.ai-head-left { display: flex; align-items: center; gap: 10px; }
.ai-icon {
    width: 32px; height: 32px; border-radius: 9px;
    background: #ede9fe; display: flex; align-items: center; justify-content: center;
}
.ai-title-name { font-size: 13.5px; font-weight: 700; color: #111827; }
.ai-badge {
    font-size: 9px; font-weight: 800; letter-spacing: 0.5px;
    color: #7c3aed; background: #ede9fe; border: 1px solid #ddd6fe;
    padding: 2px 8px; border-radius: 20px;
}
.ai-generate-btn {
    display: flex; align-items: center; gap: 7px; padding: 9px 18px;
    background: #5b21b6; color: white; border: none; border-radius: 10px;
    font-size: 12.5px; font-weight: 700; cursor: pointer; font-family: var(--font);
    transition: all .15s; box-shadow: 0 2px 8px rgba(91,33,182,0.25);
}
.ai-generate-btn:hover { background: #4c1d95; transform: translateY(-1px); }
.ai-generate-btn:disabled { opacity: .5; cursor: not-allowed; transform: none; }
.ai-body { padding: 20px 22px; }
.ai-hint { font-size: 12px; color: #9ca3af; margin-bottom: 10px; }
.ai-textarea {
    width: 100%; border: 1.5px solid #e4e8f0; border-radius: 11px;
    padding: 12px 14px; font-size: 13.5px; font-family: var(--font);
    background: #fafbfd; color: #111827;
    outline: none; resize: vertical; min-height: 140px;
    transition: border-color .15s, box-shadow .15s; line-height: 1.65;
}
.ai-textarea:focus { border-color: #8b5cf6; background: white; box-shadow: 0 0 0 3px rgba(139,92,246,0.1); }
.ai-textarea::placeholder { color: #d1d5db; }
.ai-footer-preview {
    margin-top: 12px; padding: 11px 14px;
    background: #f5f3ff; border: 1px solid #ddd6fe; border-radius: 10px;
    font-size: 11.5px; color: #6d28d9; line-height: 1.7;
}
.ai-footer-preview__label {
    display: block; font-size: 9px; font-weight: 800; letter-spacing: 0.6px;
    text-transform: uppercase; color: #7c3aed; margin-bottom: 6px; opacity: 0.7;
}

/* ── FORM ACTIONS ───────────────────── */
.form-actions {
    display: flex; justify-content: space-between; align-items: center;
    padding: 18px 22px; background: white; border-radius: 18px;
    border: 1.5px solid #e4e8f0; box-shadow: 0 1px 3px rgba(0,0,0,0.04);
}
.form-actions__left { font-size: 12px; color: #9ca3af; }
.form-actions__left span { color: #ef4444; }
.actions-right { display: flex; gap: 10px; }
.btn-cancel {
    padding: 10px 22px; border-radius: 10px; border: 1.5px solid #e4e8f0;
    background: white; font-size: 13.5px; font-weight: 600; cursor: pointer;
    color: #6b7280; font-family: var(--font); transition: all .15s;
}
.btn-cancel:hover { background: #f3f4f6; border-color: #c8cdd8; color: #374151; }
.btn-submit {
    padding: 10px 28px; border-radius: 10px; border: none;
    background: #002366; color: white; font-size: 13.5px; font-weight: 700;
    cursor: pointer; font-family: var(--font);
    transition: all .15s; display: flex; align-items: center; gap: 8px;
    box-shadow: 0 3px 12px rgba(0,26,110,0.3);
}
.btn-submit:hover { background: #001a56; transform: translateY(-1px); box-shadow: 0 5px 18px rgba(0,26,110,0.35); }

@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
@media (max-width: 600px) { .field-row { grid-template-columns: 1fr; } }
</style>
@endsection

@section('content')
<div class="create-page">

    {{-- HERO CARD --}}
    <div class="hero-card" style="width:100%;max-width:680px;">
        <div class="hero-eyebrow">
            <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            New Post Request
        </div>
        <h1>What would you like to <span>post?</span></h1>
        <p>Fill in the details below and our admin team will review your request. The more detail you provide, the faster we can approve it.</p>
        <div class="hero-progress">
            <div class="hero-progress__label">
                <span>Step 1 of 3 — Basic Info</span>
                <span>33%</span>
            </div>
            <div class="hero-progress__track">
                <div class="hero-progress__fill"></div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert--success">✅ {{ session('success') }} <a href="{{ route('requestor.requests') }}" style="color:inherit;font-weight:700;margin-left:6px;">View requests →</a></div>
    @endif
    @if(session('error'))
        <div class="alert alert--error">❌ {{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('requestor.requests.store') }}" enctype="multipart/form-data" id="create-form" class="form-body">
        @csrf

        {{-- SECTION 1: BASIC INFO --}}
        <div class="form-section">
            <div class="section-head">
                <div class="section-num">1</div>
                <div>
                    <div class="section-title-txt">Basic Information</div>
                    <div class="section-sub">Title, category, priority, and preferred date</div>
                </div>
            </div>
            <div class="section-body">
                <div class="field">
                    <label>Post Title <span class="req">*</span></label>
                    <input type="text" name="title" id="title-field" placeholder="e.g., College Week 2025 Opening Ceremony" value="{{ old('title') }}" required>
                </div>
                <div class="field">
                    <label>Description <span class="req">*</span></label>
                    <textarea name="description" id="desc-field" placeholder="Describe your event or announcement in detail. Include key info like date, time, and location..." required>{{ old('description') }}</textarea>
                </div>
                <div class="field-row">
                    <div class="field" style="margin-bottom:0;">
                        <label>Category <span class="req">*</span></label>
                        <select name="category" id="cat-field" required>
                            <option value="" disabled {{ !old('category') ? 'selected' : '' }}>Select category</option>
                            @foreach(['Events','Announcements','Academic','Sports','Community','Others'] as $cat)
                                <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field" style="margin-bottom:0;">
                        <label>Priority <span class="req">*</span></label>
                        <select name="priority" required>
                            <option value="" disabled {{ !old('priority') ? 'selected' : '' }}>Select priority</option>
                            @foreach(['Low','Medium','High','Urgent'] as $pri)
                                <option value="{{ $pri }}" {{ old('priority') === $pri ? 'selected' : '' }}>{{ $pri }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- PREFERRED DATE WITH LOAD INDICATOR --}}
                <div class="field" style="margin-top:16px;margin-bottom:0;">
                    <label>Preferred Post Date <span class="opt">(Optional)</span></label>
                    <div class="date-wrapper">
                        <div class="date-input-wrap">
                            <input type="date" name="post_date" id="post-date-input"
                                   value="{{ old('post_date') }}" min="{{ date('Y-m-d') }}">
                            <span class="date-cal-icon">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2.5"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            </span>
                        </div>

                        {{-- CALENDAR LOAD PANEL --}}
                        <div class="cal-load-panel" id="cal-load-panel">
                            <div class="cal-panel-header">
                                <div class="cal-panel-date-label" id="cal-date-label">—</div>
                                <div class="cal-panel-meta" id="cal-meta">Checking schedule…</div>
                            </div>
                            <div class="cal-load-body" id="cal-load-body">
                                <div class="cal-loading">
                                    <div class="cal-spinner"></div>
                                    Loading schedule…
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- SECTION 2: PLATFORMS --}}
        <div class="form-section">
            <div class="section-head">
                <div class="section-num">2</div>
                <div>
                    <div class="section-title-txt">Target Platforms</div>
                    <div class="section-sub">Where should this be posted?&nbsp;<span style="color:#ef4444;font-size:11px;">*</span></div>
                </div>
            </div>
            <div class="section-body">
                @php $selected_platforms = old('platforms', []); @endphp
                <div class="platform-group" id="platform-group">
                    @foreach(['Facebook','LinkedIn'] as $p)
                        <button type="button"
                            class="platform-btn {{ in_array($p, $selected_platforms) ? 'selected' : '' }}"
                            data-platform="{{ $p }}">
                            <span class="platform-dot {{ $p === 'Facebook' ? 'platform-dot--fb' : 'platform-dot--li' }}"></span>
                            {{ $p }}
                        </button>
                    @endforeach
                </div>
                <div id="platform-inputs">
                    @foreach($selected_platforms as $p)
                        <input type="hidden" name="platforms[]" value="{{ $p }}">
                    @endforeach
                </div>
            </div>
        </div>

        {{-- SECTION 3: MEDIA --}}
        <div class="form-section">
            <div class="section-head">
                <div class="section-num">3</div>
                <div>
                    <div class="section-title-txt">Media Attachments</div>
                    <div class="section-sub">Up to 10 images · Max 10MB each</div>
                </div>
            </div>
            <div class="section-body">
                <label class="upload-zone" for="media-input" id="upload-zone">
                    <div class="upload-icon-wrap">
                        <svg width="22" height="22" fill="none" stroke="#3b6ef5" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="16 16 12 12 8 16"/><line x1="12" y1="12" x2="12" y2="21"/><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/></svg>
                    </div>
                    <p><strong>Click to upload</strong> or drag and drop</p>
                    <div class="upload-tags">
                        <span class="upload-tag">JPG</span>
                        <span class="upload-tag">PNG</span>
                        <span class="upload-tag">MP4</span>
                        <span class="upload-tag">MOV</span>
                        <span class="upload-tag">Max 10MB</span>
                    </div>
                </label>
                <div class="upload-previews" id="upload-previews"></div>
                <input type="file" id="media-input" name="media[]" multiple accept="image/*,video/mp4,video/quicktime">
            </div>
        </div>

        {{-- AI CAPTION --}}
        <div class="ai-section">
            <div class="ai-head">
                <div class="ai-head-left">
                    <div class="ai-icon">
                        <svg width="16" height="16" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
                    </div>
                    <div class="ai-title-name">AI Caption Generator</div>
                    <span class="ai-badge">✦ Gemini AI</span>
                </div>
                <button type="button" class="ai-generate-btn" id="generate-btn" onclick="generateCaption()">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                    Generate Caption
                </button>
            </div>
            <div class="ai-body">
                <p class="ai-hint">Fill in title &amp; description first, then click Generate.</p>
                <textarea class="ai-textarea" name="caption" id="caption-field"
                          placeholder="Your AI-generated caption will appear here. You can also write your own...">{{ old('caption') }}</textarea>
                <div class="ai-footer-preview">
                    <span class="ai-footer-preview__label">✦ Auto-added when you submit — not shown in the box above</span>
                    Apply now and secure your place for the upcoming academic year: https://onlineapp.nu-lipa.edu.ph/quest/register.php<br>
                    Experience 𝘌𝘥𝘶𝘤𝘢𝘵𝘪𝘰𝘯 𝘛𝘩𝘢𝘵 𝘞𝘰𝘳𝘬𝘴.<br>
                    #NULipa #EducationThatWorks
                </div>
            </div>
        </div>

        {{-- SUBMIT BAR --}}
        <div class="form-actions">
            <div class="form-actions__left">Fields marked <span>*</span> are required</div>
            <div class="actions-right">
                <button type="button" class="btn-cancel" onclick="history.back()">Cancel</button>
                <button type="submit" class="btn-submit">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                    Submit Request
                </button>
            </div>
        </div>

    </form>
</div>
@endsection

@section('scripts')
<script>
// ── FIXED FOOTER ──────────────────────────────────────────────────
const FIXED_FOOTER = "\n\nApply now and secure your place for the upcoming academic year: https://onlineapp.nu-lipa.edu.ph/quest/register.php\nExperience \u{1D60C}\u{1D625}\u{1D636}\u{1D624}\u{1D622}\u{1D635}\u{1D62A}\u{1D630}\u{1D62F} \u{1D61B}\u{1D629}\u{1D622}\u{1D635} \u{1D61E}\u{1D630}\u{1D633}\u{1D62C}\u{1D634}.\n#NULipa\n#EducationThatWorks";

document.getElementById('create-form').addEventListener('submit', function() {
    const box     = document.getElementById('caption-field');
    const current = box.value.trim();
    if (current && !current.includes('onlineapp.nu-lipa.edu.ph')) {
        box.value = current + FIXED_FOOTER;
    }
});

// ── PLATFORM BUTTONS ──────────────────────────────────────────────
const platformInputs = document.getElementById('platform-inputs');
function updatePlatformInputs() {
    platformInputs.innerHTML = '';
    document.querySelectorAll('.platform-btn.selected').forEach(btn => {
        const inp = document.createElement('input');
        inp.type = 'hidden'; inp.name = 'platforms[]'; inp.value = btn.dataset.platform;
        platformInputs.appendChild(inp);
    });
}
document.querySelectorAll('.platform-btn').forEach(btn => {
    btn.addEventListener('click', () => { btn.classList.toggle('selected'); updatePlatformInputs(); });
});

// ── MEDIA PREVIEW ─────────────────────────────────────────────────
const mediaInput    = document.getElementById('media-input');
const uploadPreviews = document.getElementById('upload-previews');
const uploadZone    = document.getElementById('upload-zone');

mediaInput.addEventListener('change', () => {
    uploadPreviews.innerHTML = '';
    const files = Array.from(mediaInput.files).slice(0, 10);
    files.forEach(file => {
        if (!file.type.startsWith('image/')) return;
        const reader = new FileReader();
        reader.onload = e => {
            const wrap = document.createElement('div'); wrap.className = 'preview-wrap';
            const img  = document.createElement('img'); img.src = e.target.result; img.className = 'preview-thumb';
            const rm   = document.createElement('button'); rm.type = 'button'; rm.className = 'preview-remove'; rm.innerHTML = '×';
            rm.onclick = () => wrap.remove();
            wrap.appendChild(img); wrap.appendChild(rm);
            uploadPreviews.appendChild(wrap);
        };  
        reader.readAsDataURL(file);
    });
    uploadZone.style.display = files.length >= 10 ? 'none' : 'flex';
});

// ── CALENDAR LOAD INDICATOR ───────────────────────────────────────
const dateInput  = document.getElementById('post-date-input');
const calPanel   = document.getElementById('cal-load-panel');
const calLabel   = document.getElementById('cal-date-label');
const calMeta    = document.getElementById('cal-meta');
const calBody    = document.getElementById('cal-load-body');

const MONTH_NAMES = ['January','February','March','April','May','June','July','August','September','October','November','December'];
const DAY_NAMES   = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];

function formatDateLabel(dateStr) {
    const [y, m, d] = dateStr.split('-').map(Number);
    const dt = new Date(y, m - 1, d);
    return `${DAY_NAMES[dt.getDay()]}, ${MONTH_NAMES[m - 1]} ${d}, ${y}`;
}

function getCapacityClass(count) {
    if (count === 0) return 'low';
    if (count <= 2)  return 'medium';
    return 'high';
}

function getCapacityWidth(count) {
    const pct = Math.min(count * 20, 100);
    return pct + '%';
}

function getCapacityLabel(count) {
    if (count === 0) return 'Open — no requests yet';
    if (count === 1) return 'Light — 1 request';
    if (count <= 2)  return `Moderate — ${count} requests`;
    return `Busy — ${count} requests`;
}

function renderCalPanel(data, dateStr) {
    const count   = data.total || 0;
    const reqs    = data.requests || [];
    const cls     = getCapacityClass(count);
    const width   = getCapacityWidth(count);
    const lbl     = getCapacityLabel(count);

    calLabel.textContent = formatDateLabel(dateStr);
    calMeta.textContent  = count === 0 ? 'Free day' : `${count} request${count !== 1 ? 's' : ''} scheduled`;

    let html = `
        <div class="cal-capacity-wrap">
            <div class="cal-capacity-label">
                <span>Schedule load</span>
                <strong class="${cls}">${lbl}</strong>
            </div>
            <div class="cal-bar-track">
                <div class="cal-bar-fill ${cls}" style="width:${width};"></div>
            </div>
        </div>`;

    if (reqs.length > 0) {
        html += `<div class="cal-req-list">`;
        reqs.slice(0, 5).forEach(r => {
            const statusRaw = (r.status || '').toLowerCase();
            let dotClass = 'pending';
            if (statusRaw.includes('approved')) dotClass = 'approved';
            else if (statusRaw.includes('review')) dotClass = 'under-review';
            const statusLabel = r.status || 'Pending';
            const title = r.title ? (r.title.length > 36 ? r.title.slice(0, 36) + '…' : r.title) : 'Untitled';
            html += `
                <div class="cal-req-item">
                    <div class="cal-req-dot ${dotClass}"></div>
                    <span class="cal-req-name">${escHtml(title)}</span>
                    <span class="cal-req-status">${escHtml(statusLabel)}</span>
                </div>`;
        });
        if (reqs.length > 5) {
            html += `<div style="font-size:11.5px;color:#9ca3af;text-align:center;padding:4px 0;">+${reqs.length - 5} more</div>`;
        }
        html += `</div>`;
    } else {
        html += `
            <div class="cal-empty-day">
                <svg width="28" height="28" fill="none" stroke="#d1fae5" stroke-width="1.5" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                <div>
                    <strong>Great choice!</strong>
                    <p>No requests on this day yet.</p>
                </div>
            </div>`;
    }

    // Tip if busy
    if (count >= 3) {
        html += `<div class="cal-tip visible">⚠️ This day is quite busy. Consider choosing a nearby date for faster turnaround.</div>`;
    }

    calBody.innerHTML = html;
}

function escHtml(str) {
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

dateInput.addEventListener('change', function() {
    const val = this.value;
    if (!val) { calPanel.classList.remove('visible'); return; }

    // Show panel with loading state
    calPanel.classList.add('visible');
    calLabel.textContent = formatDateLabel(val);
    calMeta.textContent  = 'Checking schedule…';
    calBody.innerHTML    = `<div class="cal-loading"><div class="cal-spinner"></div> Loading schedule…</div>`;

    // Fetch requests for this date from the public calendar endpoint
    fetch(`/requestor/calendar/requests-by-date?date=${val}`, {
        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    })
    .then(r => r.json())
    .then(data => renderCalPanel(data, val))
    .catch(() => {
        calBody.innerHTML = `<div class="cal-loading" style="color:#ef4444;">Could not load schedule. Try again.</div>`;
    });
});

// Hide panel when date is cleared
dateInput.addEventListener('input', function() {
    if (!this.value) calPanel.classList.remove('visible');
});

// ── AI CAPTION GENERATOR ──────────────────────────────────────────
async function generateCaption() {
    const title = document.getElementById('title-field').value.trim();
    const desc  = document.getElementById('desc-field').value.trim();
    const cat   = document.getElementById('cat-field').value || 'General';
    const plats = Array.from(document.querySelectorAll('.platform-btn.selected'))
                       .map(b => b.dataset.platform).join(', ');
    const btn   = document.getElementById('generate-btn');
    const box   = document.getElementById('caption-field');

    if (!title || !desc) {
        alert('Please fill in the Title and Description first.');
        return;
    }

    const orig = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = `<svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="animation:spin 1s linear infinite;display:inline-block;"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg> Generating...`;

    try {
        const res = await fetch('/api/generate-caption', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ title, description: desc, category: cat, platforms: plats })
        });

        const data = await res.json();
        if (data.error) throw new Error(data.error);
        if (!data.caption) throw new Error('No caption returned.');

        let caption = data.caption
            .replace(/#\w+/g, '')
            .replace(/Apply now[\s\S]*?register\.php/gi, '')
            .replace(/https?:\/\/onlineapp\.nu-lipa\.edu\.ph[^\s]*/gi, '')
            .replace(/Experience\s+\S*[Ee]ducation\S*\s+\S*[Tt]hat\S*\s+\S*[Ww]orks\S*/gi, '')
            .replace(/\n{3,}/g, '\n\n')
            .trim();

        box.value = caption;

    } catch(e) {
        alert('Caption generation failed: ' + e.message);
    } finally {
        btn.disabled = false;
        btn.innerHTML = orig;
    }
}

// ── PROGRESS BAR — update as user fills in fields ─────────────────
function updateProgress() {
    const title    = document.getElementById('title-field').value.trim();
    const desc     = document.getElementById('desc-field').value.trim();
    const cat      = document.getElementById('cat-field').value;
    const platform = document.querySelectorAll('.platform-btn.selected').length > 0;

    let filled = 0;
    if (title)    filled++;
    if (desc)     filled++;
    if (cat)      filled++;
    if (platform) filled++;

    const pct  = Math.round((filled / 4) * 100);
    const step = filled <= 1 ? 1 : filled <= 2 ? 2 : 3;
    const stepLabels = ['', 'Basic Info', 'Platforms', 'Ready to submit'];

    document.querySelector('.hero-progress__fill').style.width = pct + '%';
    document.querySelector('.hero-progress__label span:first-child').textContent =
        `Step ${step} of 3 — ${stepLabels[step]}`;
    document.querySelector('.hero-progress__label span:last-child').textContent = pct + '%';
}

document.getElementById('title-field').addEventListener('input', updateProgress);
document.getElementById('desc-field').addEventListener('input', updateProgress);
document.getElementById('cat-field').addEventListener('change', updateProgress);
document.querySelectorAll('.platform-btn').forEach(b => b.addEventListener('click', updateProgress));
</script>
@endsection