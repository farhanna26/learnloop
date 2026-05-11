<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profile – LearnLoop</title>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
:root {
  --bg: #f2f3f7;
  --white: #ffffff;
  --border: #e4e6ed;
  --text: #1a1a2e;
  --muted: #6b7280;
  --accent: #7c3aed;
  --accent-light: #ede9fe;
  --accent-mid: #8b5cf6;
  --sidebar-w: 240px;
}

* { margin: 0; padding: 0; box-sizing: border-box; }

body {
  font-family: 'Plus Jakarta Sans', sans-serif;
  background: var(--bg);
  color: var(--text);
  min-height: 100vh;
}

/* ── TOPBAR ── */
.topbar {
  position: fixed;
  top: 0; left: 0; right: 0;
  height: 56px;
  background: var(--white);
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 24px;
  z-index: 100;
}

.logo {
  display: flex;
  align-items: center;
  gap: 10px;
  font-weight: 700;
  font-size: 18px;
  color: var(--text);
}

.logo-icon {
  width: 34px;
  height: 34px;
  background: var(--accent);
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  font-weight: 700;
  font-size: 16px;
}

.topbar-avatar {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background: #c4b5fd;
  border: 2px solid var(--border);
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  font-weight: 600;
}

/* ── LAYOUT ── */
.layout {
  display: flex;
  padding-top: 56px;
  min-height: 100vh;
}

/* ── SIDEBAR ── */
.sidebar {
  width: var(--sidebar-w);
  position: fixed;
  top: 56px;
  left: 0;
  bottom: 0;
  background: var(--white);
  border-right: 1px solid var(--border);
  padding: 20px 12px;
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.nav-item {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 10px 14px;
  border-radius: 10px;
  font-size: 14px;
  font-weight: 500;
  color: var(--muted);
  cursor: pointer;
  text-decoration: none;
  transition: all 0.15s;
}

.nav-item:hover { background: var(--bg); color: var(--text); }

.nav-item.active {
  background: var(--accent-light);
  color: var(--accent);
}

.nav-item svg {
  width: 20px;
  height: 20px;
  flex-shrink: 0;
  stroke: currentColor;
  fill: none;
  stroke-width: 1.8;
}

/* ── MAIN ── */
.main {
  margin-left: var(--sidebar-w);
  flex: 1;
  padding: 24px;
  max-width: 860px;
}

/* ── PROFILE CARD ── */
.profile-card {
  background: var(--white);
  border-radius: 16px;
  border: 1px solid var(--border);
  overflow: hidden;
  margin-bottom: 20px;
}

.banner {
  width: 100%;
  height: 180px;
  background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
  position: relative;
  overflow: hidden;
}

/* starfield effect */
.banner::before {
  content: '';
  position: absolute;
  inset: 0;
  background-image:
    radial-gradient(1px 1px at 10% 20%, rgba(255,255,255,0.8) 0%, transparent 100%),
    radial-gradient(1px 1px at 30% 60%, rgba(255,255,255,0.6) 0%, transparent 100%),
    radial-gradient(1px 1px at 55% 15%, rgba(255,255,255,0.9) 0%, transparent 100%),
    radial-gradient(1px 1px at 70% 45%, rgba(255,255,255,0.5) 0%, transparent 100%),
    radial-gradient(1px 1px at 80% 25%, rgba(255,255,255,0.7) 0%, transparent 100%),
    radial-gradient(1px 1px at 20% 80%, rgba(255,255,255,0.4) 0%, transparent 100%),
    radial-gradient(1px 1px at 90% 70%, rgba(255,255,255,0.6) 0%, transparent 100%),
    radial-gradient(1.5px 1.5px at 45% 55%, rgba(255,255,255,0.5) 0%, transparent 100%),
    radial-gradient(1px 1px at 65% 80%, rgba(255,255,255,0.3) 0%, transparent 100%),
    radial-gradient(2px 2px at 85% 10%, rgba(255,255,255,0.7) 0%, transparent 100%);
}

/* moon */
.banner::after {
  content: '';
  position: absolute;
  width: 70px;
  height: 70px;
  border-radius: 50%;
  background: rgba(255,255,255,0.15);
  box-shadow: inset -12px -4px 0 0 rgba(255,255,255,0.4), 0 0 40px rgba(200,180,255,0.3);
  top: 30px;
  right: 80px;
}

.profile-body {
  padding: 0 24px 20px;
  position: relative;
}

.avatar-wrap {
  position: relative;
  width: 80px;
  height: 80px;
  margin-top: -40px;
  margin-bottom: 12px;
}

.avatar-img {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  border: 3px solid var(--white);
  background: #c4b5fd;
  object-fit: cover;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 22px;
  color: #fff;
  overflow: hidden;
}

.avatar-img img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.edit-btn {
  position: absolute;
  top: 16px;
  right: 24px;
  padding: 7px 18px;
  border: 1.5px solid var(--border);
  border-radius: 20px;
  background: var(--white);
  font-size: 13px;
  font-weight: 600;
  color: var(--text);
  cursor: pointer;
  text-decoration: none;
  transition: all 0.15s;
}

.edit-btn:hover { background: var(--bg); }

.profile-name {
  font-size: 20px;
  font-weight: 700;
  margin-bottom: 2px;
}

.profile-email {
  font-size: 13px;
  color: var(--muted);
  margin-bottom: 6px;
}

.profile-desc {
  font-size: 13.5px;
  color: var(--text);
  margin-bottom: 10px;
}

.profile-meta {
  display: flex;
  align-items: center;
  gap: 16px;
  font-size: 13px;
  color: var(--muted);
}

.profile-meta span {
  display: flex;
  align-items: center;
  gap: 5px;
}

.profile-meta svg {
  width: 15px;
  height: 15px;
  stroke: var(--muted);
  fill: none;
  stroke-width: 1.8;
}

/* SUCCESS FLASH */
.flash {
  padding: 12px 16px;
  margin-bottom: 16px;
  border-radius: 12px;
  background: #ecfdf5;
  color: #064e3b;
  border: 1px solid #86efac;
  font-size: 13.5px;
}

/* ── POST CARD ── */
.post-card {
  background: var(--white);
  border-radius: 16px;
  border: 1px solid var(--border);
  padding: 18px 20px;
  margin-bottom: 16px;
}

.post-header {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 12px;
}

.post-avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: var(--accent);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #fff;
  font-weight: 700;
  font-size: 14px;
  flex-shrink: 0;
}

.post-meta { flex: 1; }

.post-author {
  font-size: 14px;
  font-weight: 600;
}

.post-time {
  font-size: 12px;
  color: var(--muted);
  text-transform: uppercase;
  letter-spacing: 0.02em;
}

.post-text {
  font-size: 14px;
  margin-bottom: 12px;
  color: var(--text);
}

.post-image {
  width: 100%;
  border-radius: 10px;
  overflow: hidden;
  background: #1a1a2e;
  height: 240px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--muted);
  font-size: 13px;
  margin-bottom: 12px;
}

.post-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.post-actions {
  display: flex;
  align-items: center;
  gap: 16px;
}

.action-btn {
  display: flex;
  align-items: center;
  gap: 5px;
  font-size: 13px;
  color: var(--muted);
  cursor: pointer;
  border: none;
  background: none;
  font-family: inherit;
  padding: 4px 0;
  border-radius: 6px;
  transition: color 0.15s;
}

.action-btn:hover { color: var(--accent); }

.action-btn svg {
  width: 18px;
  height: 18px;
  stroke: currentColor;
  fill: none;
  stroke-width: 1.8;
}

/* CONTACT LINKS */
.contact-links {
  margin-top: 14px;
  display: flex;
  flex-direction: column;
  gap: 7px;
}

.contact-link {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 13px;
  color: var(--accent);
  text-decoration: none;
  font-weight: 500;
  transition: opacity 0.15s;
}

.contact-link:hover { opacity: 0.75; }

.contact-link svg {
  width: 15px;
  height: 15px;
  stroke: var(--accent);
  flex-shrink: 0;
}

/* EMPTY STATE */
.empty {
  text-align: center;
  padding: 40px;
  color: var(--muted);
  font-size: 14px;
}
</style>
</head>
<body>

<!-- TOPBAR -->
<div class="topbar">
  <div class="logo">
    <div class="logo-icon">L</div>
    LearnLoop
  </div>
  <div class="topbar-avatar">
    @if($user && $user->photo)
      <img src="{{ asset($user->photo) }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
    @else
      {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
    @endif
  </div>
</div>

<div class="layout">

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <a href="{{ url('/dashboard') }}" class="nav-item">
      <svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
      Beranda
    </a>
    <a href="{{ url('/messages') }}" class="nav-item">
      <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
      Pesan
    </a>
    <a href="{{ url('/profile') }}" class="nav-item active">
      <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 21c1.5-4 14.5-4 16 0"/></svg>
      Profil
    </a>
  </aside>

  <!-- MAIN -->
  <main class="main">

    @if(session('success'))
      <div class="flash">{{ session('success') }}</div>
    @endif

    <!-- PROFILE CARD -->
    <div class="profile-card">
      <div class="banner"></div>
      <div class="profile-body">

        <a class="edit-btn" href="{{ url('/addprofile') }}">Edit Profil</a>

        <div class="avatar-wrap">
          <div class="avatar-img">
            @if($user && $user->photo)
              <img src="{{ asset($user->photo) }}" alt="avatar">
            @else
              {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
            @endif
          </div>
        </div>

        <div class="profile-name">{{ $user->name ?? 'Nama Pengguna' }}</div>
        <div class="profile-email">{{ $user->email ?? 'email@example.com' }}</div>

        @if($user->description ?? false)
          <div class="profile-desc">{{ $user->description }}</div>
        @endif

        <div class="profile-meta">
          <span>
            <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
            Indonesia
          </span>
          <span>
            <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Bergabung {{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->translatedFormat('F Y') : 'Mei 2026' }}
          </span>
        </div>

        <!-- CONTACT LINKS -->
        <div class="contact-links">
          <a href="https://www.google.com/maps/search/?api=1&query=Gedung+H+Teknik+Elektro+Universitas+Lampung"
             target="_blank" class="contact-link">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
              <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0118 0z"/>
              <circle cx="12" cy="10" r="3"/>
            </svg>
            Bandar Lampung, Indonesia
          </a>

          <a href="https://www.linkedin.com/in/nabila-alyaa-putri-27457332a"
             target="_blank" class="contact-link">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
              <rect x="2" y="2" width="20" height="20" rx="4"/>
              <path d="M7 10v7M7 7v.01M11 17v-4a2 2 0 014 0v4M11 10v7"/>
            </svg>
            linkedin.com/in/nabila-alyaa-putri
          </a>

          <a href="mailto:nabilaalyaaputri0204@gmail.com" class="contact-link">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.8">
              <rect x="2" y="4" width="20" height="16" rx="2"/>
              <path d="M2 7l10 7 10-7"/>
            </svg>
            nabilaalyaaputri0204@gmail.com
          </a>
        </div>

      </div>
    </div>

    <!-- POSTS (loop dari database jika ada) -->
    @if(isset($posts) && $posts->count())
      @foreach($posts as $post)
      <div class="post-card">
        <div class="post-header">
          <div class="post-avatar">{{ strtoupper(substr($user->name ?? 'U', 0, 2)) }}</div>
          <div class="post-meta">
            <div class="post-author">{{ $user->name }}</div>
            <div class="post-time">{{ $post->created_at->diffForHumans() }}</div>
          </div>
        </div>

        @if($post->content)
          <div class="post-text">{{ $post->content }}</div>
        @endif

        @if($post->image)
          <div class="post-image">
            <img src="{{ asset($post->image) }}" alt="post image">
          </div>
        @endif

        <div class="post-actions">
          <button class="action-btn">
            <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 000-7.78z"/></svg>
            {{ $post->likes_count ?? 0 }}
          </button>
          <button class="action-btn">
            <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
            {{ $post->comments_count ?? 0 }}
          </button>
        </div>
      </div>
      @endforeach
    @else
      <div class="post-card">
        <div class="empty">Belum ada postingan. Mulai berbagi sesuatu!</div>
      </div>
    @endif

  </main>
</div>

</body>
</html>