<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Profile – LearnLoop</title>

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
  text-decoration: none;
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
  font-size: 14px;
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
  padding: 32px 24px;
  display: flex;
  justify-content: center;
}

/* ── FORM CARD ── */
.form-card {
  width: 100%;
  max-width: 560px;
}

.page-heading {
  margin-bottom: 20px;
}

.page-heading h1 {
  font-size: 22px;
  font-weight: 700;
  margin-bottom: 4px;
}

.page-heading p {
  font-size: 13.5px;
  color: var(--muted);
  line-height: 1.6;
}

/* ALERT */
.alert-success {
  padding: 12px 16px;
  border-radius: 12px;
  background: #ecfdf5;
  color: #064e3b;
  border: 1px solid #86efac;
  font-size: 13.5px;
  margin-bottom: 16px;
}

.alert-error {
  padding: 12px 16px;
  border-radius: 12px;
  background: #fef2f2;
  color: #b91c1c;
  border: 1px solid #fecaca;
  font-size: 13.5px;
  margin-bottom: 16px;
}

.alert-error ul { padding-left: 18px; margin-top: 6px; }
.alert-error li { margin-bottom: 4px; }

/* ── AVATAR PREVIEW CARD ── */
.avatar-card {
  background: var(--white);
  border: 1px solid var(--border);
  border-radius: 16px;
  padding: 20px;
  display: flex;
  align-items: center;
  gap: 18px;
  margin-bottom: 16px;
}

.avatar-preview {
  width: 72px;
  height: 72px;
  border-radius: 50%;
  border: 3px solid var(--accent-light);
  background: #c4b5fd center/cover no-repeat;
  flex-shrink: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 22px;
  color: #fff;
  overflow: hidden;
  position: relative;
}

.avatar-preview img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.avatar-info strong {
  display: block;
  font-size: 14px;
  font-weight: 600;
  margin-bottom: 3px;
}

.avatar-info span {
  font-size: 12.5px;
  color: var(--muted);
  line-height: 1.5;
}

/* ── FORM SECTIONS ── */
.form-section {
  background: var(--white);
  border: 1px solid var(--border);
  border-radius: 16px;
  padding: 20px;
  margin-bottom: 16px;
}

.form-section + .form-section { margin-top: 0; }

.section-label {
  font-size: 12px;
  font-weight: 700;
  color: var(--muted);
  text-transform: uppercase;
  letter-spacing: 0.06em;
  margin-bottom: 14px;
}

.form-group {
  margin-bottom: 16px;
}

.form-group:last-child { margin-bottom: 0; }

label {
  display: block;
  font-size: 13px;
  font-weight: 600;
  color: var(--text);
  margin-bottom: 6px;
}

/* FILE INPUT */
.file-label {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 11px 16px;
  border: 1.5px dashed var(--border);
  border-radius: 12px;
  background: var(--bg);
  cursor: pointer;
  font-size: 13.5px;
  color: var(--muted);
  transition: all 0.15s;
}

.file-label:hover {
  border-color: var(--accent);
  color: var(--accent);
  background: var(--accent-light);
}

.file-label svg {
  width: 18px;
  height: 18px;
  stroke: currentColor;
  fill: none;
  stroke-width: 1.8;
  flex-shrink: 0;
}

input[type=file] {
  display: none;
}

#file-name {
  font-size: 12px;
  color: var(--muted);
  margin-top: 6px;
  padding-left: 2px;
}

/* TEXTAREA */
textarea {
  width: 100%;
  border-radius: 12px;
  border: 1.5px solid var(--border);
  background: var(--bg);
  color: var(--text);
  padding: 12px 14px;
  font: 13.5px/1.6 'Plus Jakarta Sans', sans-serif;
  min-height: 120px;
  resize: vertical;
  outline: none;
  transition: border-color 0.15s;
}

textarea:focus {
  border-color: var(--accent);
  background: var(--white);
}

textarea::placeholder { color: #b0b7c3; }

/* ── BUTTONS ── */
.btn-row {
  display: flex;
  gap: 10px;
  margin-top: 4px;
}

.btn-primary {
  flex: 1;
  border: none;
  border-radius: 12px;
  padding: 13px 18px;
  font: 600 14px/1.2 'Plus Jakarta Sans', sans-serif;
  background: var(--accent);
  color: #fff;
  cursor: pointer;
  transition: background 0.15s;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
}

.btn-primary:hover { background: var(--accent-mid); }

.btn-primary svg {
  width: 16px;
  height: 16px;
  stroke: #fff;
  fill: none;
  stroke-width: 2;
}

.btn-secondary {
  padding: 13px 18px;
  border-radius: 12px;
  border: 1.5px solid var(--border);
  background: var(--white);
  color: var(--text);
  font: 600 14px/1.2 'Plus Jakarta Sans', sans-serif;
  cursor: pointer;
  text-decoration: none;
  display: flex;
  align-items: center;
  transition: background 0.15s;
}

.btn-secondary:hover { background: var(--bg); }
</style>
</head>
<body>

<!-- TOPBAR -->
<div class="topbar">
  <a href="{{ url('/dashboard') }}" class="logo">
    <div class="logo-icon">L</div>
    LearnLoop
  </a>
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
    <div class="form-card">

      <div class="page-heading">
        <h1>Edit Profil</h1>
        <p>Foto profil dan deskripsi bersifat opsional. Biarkan kosong jika tidak ingin mengubah.</p>
      </div>

      @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
      @endif

      @if($errors->any())
        <div class="alert-error">
          <strong>Perbaiki dulu:</strong>
          <ul>
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- AVATAR PREVIEW -->
      <div class="avatar-card">
        <div class="avatar-preview" id="avatarPreview"
          @if($user && $user->photo)
            style="background-image:url('{{ asset($user->photo) }}'); background-size:cover; background-position:center;"
          @endif
        >
          @if(!($user && $user->photo))
            {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
          @endif
        </div>
        <div class="avatar-info">
          <strong>Foto Profil Saat Ini</strong>
          <span>Pilih file baru untuk mengganti foto.<br>Format: JPG, PNG, GIF. Maks 2MB.</span>
        </div>
      </div>

      <form action="{{ url('/addprofile') }}" method="post" enctype="multipart/form-data">
        @csrf

        <!-- FOTO UPLOAD -->
        <div class="form-section">
          <div class="section-label">Foto Profil</div>
          <div class="form-group">
            <label for="photo">Unggah foto baru</label>
            <label class="file-label" for="photo">
              <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
              <span id="file-label-text">Klik untuk memilih foto…</span>
            </label>
            <input id="photo" name="photo" type="file" accept="image/*" onchange="previewPhoto(this)">
            <div id="file-name"></div>
          </div>
        </div>

        <!-- DESKRIPSI -->
        <div class="form-section">
          <div class="section-label">Tentang Saya</div>
          <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea id="description" name="description"
              placeholder="Contoh: Mahasiswa Teknik Informatika yang suka belajar hal baru…">{{ old('description', $user->description ?? '') }}</textarea>
          </div>
        </div>

        <!-- ACTIONS -->
        <div class="btn-row">
          <a class="btn-secondary" href="{{ url('/profile') }}">Batal</a>
          <button type="submit" class="btn-primary">
            <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
            Simpan Profil
          </button>
        </div>

      </form>

    </div>
  </main>

</div>

<script>
function previewPhoto(input) {
  const file = input.files[0];
  if (!file) return;

  // update label text
  document.getElementById('file-label-text').textContent = file.name;
  document.getElementById('file-name').textContent = (file.size / 1024).toFixed(1) + ' KB';

  // live preview on avatar
  const reader = new FileReader();
  reader.onload = e => {
    const av = document.getElementById('avatarPreview');
    av.style.backgroundImage = `url('${e.target.result}')`;
    av.style.backgroundSize = 'cover';
    av.style.backgroundPosition = 'center';
    av.textContent = '';
  };
  reader.readAsDataURL(file);
}
</script>

</body>
</html>