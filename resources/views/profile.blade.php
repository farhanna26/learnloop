<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profile</title>

<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
:root{
  --bg:#ffffff;
  --surface:#f7f5ff;
  --border:#e6dcff;
  --text:#1c1c1c;
  --muted:#6b5b8c;
  --accent:#b794f4;
}

*{
  margin:0;
  padding:0;
  box-sizing:border-box;
}

body{
  background:var(--bg);
  font-family:'DM Sans',sans-serif;
  max-width:430px;
  margin:0 auto;
  color:var(--text);
}

/* TOPBAR */
.topbar{
  padding:10px 16px;
  border-bottom:1px solid var(--border);
  font-size:20px;
  font-weight:600;
  background:#fff;
}

/* PROFILE */
.profile{
  padding:16px;
}

/* AVATAR */
.avatar-wrapper{
  position:relative;
  width:96px;
  height:96px;
  margin-bottom:14px;
}

.avatar-ring{
  width:100%;
  height:100%;
  border-radius:50%;
  padding:3px;
  background:linear-gradient(135deg,#d7c5ff,#b794f4,#efe7ff);
}

.avatar{
  width:100%;
  height:100%;
  border-radius:50%;
  background:#f1f1f4;
  border:3px solid #fff;
  position:relative;
  overflow:hidden;
}

/* ICON ORANG */
.avatar::before{
  content:"";
  position:absolute;
  width:34px;
  height:34px;
  border-radius:50%;
  background:#9ea3b0;
  top:18px;
  left:50%;
  transform:translateX(-50%);
}

.avatar::after{
  content:"";
  position:absolute;
  width:85px;
  height:75px;
  border-radius:50%;
  background:#b8bcc8;
  bottom:-48px;
  left:50%;
  transform:translateX(-50%);
}

/* PLUS BUTTON */
.add-btn{
  position:absolute;
  bottom:5px;
  right:5px;
  width:28px;
  height:28px;
  border-radius:50%;
  background:#fff;
  border:2px solid var(--accent);
  display:flex;
  align-items:center;
  justify-content:center;
  font-size:18px;
  font-weight:600;
  color:var(--accent);
}

/* TEXT */
.name{
  font-size:20px;
  font-weight:700;
}

.desc{
  font-size:13px;
  color:var(--muted);
  margin-top:4px;
  line-height:1.5;
}

.info{
  font-size:13px;
  color:var(--muted);
  margin-top:6px;
}

/* LINK STYLE */
.links{
  margin-top:10px;
  font-size:13px;
  line-height:1.8;
}

.links a{
  color:var(--accent);
  text-decoration:none;
  font-weight:500;
}

.links a:hover{
  text-decoration:underline;
}

/* CONTENT HEADER */
.content-header{
  margin-top:18px;
  border-top:1px solid var(--border);
  display:flex;
  justify-content:center;
  align-items:center;
  padding-top:10px;
  margin-bottom:10px;
}

.content-tab{
  width:48px;
  height:48px;
  display:flex;
  align-items:center;
  justify-content:center;
  border-bottom:2px solid var(--accent);
}

.content-tab svg{
  width:24px;
  height:24px;
  stroke:var(--accent);
  fill:none;
  stroke-width:1.8;
}

/* GRID */
.grid{
  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:2px;
}

.item{
  aspect-ratio:1;
  background:var(--surface);
  border-radius:4px;
}

/* SPACER */
.scroll{
  height:95px;
}

/* BOTTOM NAVBAR */
.bottom{
  position:fixed;
  bottom:0;
  left:50%;
  transform:translateX(-50%);
  width:100%;
  max-width:430px;
  background:#fff;
  border-top:1px solid var(--border);
  display:flex;
  justify-content:space-around;
  padding:10px 0 14px;
}

.nav-item{
  display:flex;
  flex-direction:column;
  align-items:center;
  gap:4px;
  color:var(--muted);
  font-size:11px;
  font-weight:500;
}

.nav-item svg{
  width:24px;
  height:24px;
  stroke:var(--muted);
  fill:none;
  stroke-width:1.8;
}

.nav-item.active{
  color:var(--accent);
}

.nav-item.active svg{
  stroke:var(--accent);
}
</style>
</head>

<body>

<div class="topbar">
  Profile
</div>

@if(session('success'))
  <div style="padding:12px 14px; margin:0 16px 12px; border-radius:14px; background:#ecfdf5; color:#064e3b; border:1px solid #86efac;">
    {{ session('success') }}
  </div>
@endif

<div class="profile">

  <!-- AVATAR -->
  <div class="avatar-wrapper">
    <div class="avatar-ring">
      <div class="avatar" style="@if($user && $user->photo) background-image:url('{{ asset($user->photo) }}'); background-size:cover; background-position:center; @endif"></div>
    </div>
    <a class="add-btn" href="{{ url('/addprofile') }}">+</a>
  </div>

  <div class="name">{{ $user->name ?? 'Profil Anda' }}</div>

  <div class="desc">
    {{ $user->description ?? 'Tambahkan deskripsi singkat tentang diri Anda.' }}
  </div>

  <!-- LOCATION (CLICKABLE GMAPS) -->
  <div class="info">
    📍 
    <a 
      href="https://www.google.com/maps/search/?api=1&query=Gedung+H+Teknik+Elektro+Universitas+Lampung"
      target="_blank"
      style="color:inherit;text-decoration:none;"
    >
      Bandar Lampung, Indonesia
    </a>
  </div>

  <!-- LINKS -->
  <div class="links">

    <a href="https://www.linkedin.com/in/nabila-alyaa-putri-27457332a?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app" target="_blank">
      linkedin.com/in/nabila-alyaa-putri
    </a>

    <br>

    <a href="mailto:nabilaalyaaputri0204@gmail.com">
      nabilaalyaaputri0204@gmail.com
    </a>

  </div>

</div>

<!-- CONTENT ICON -->
<div class="content-header">
  <div class="content-tab">
    <svg viewBox="0 0 24 24">
      <rect x="3" y="3" width="7" height="7" rx="1"></rect>
      <rect x="14" y="3" width="7" height="7" rx="1"></rect>
      <rect x="3" y="14" width="7" height="7" rx="1"></rect>
      <rect x="14" y="14" width="7" height="7" rx="1"></rect>
    </svg>
  </div>
</div>

<!-- GRID -->
<div class="grid">
  <div class="item"></div>
  <div class="item"></div>
  <div class="item"></div>
  <div class="item"></div>
  <div class="item"></div>
  <div class="item"></div>
  <div class="item"></div>
  <div class="item"></div>
  <div class="item"></div>
</div>

<div class="scroll"></div>

<!-- BOTTOM NAV -->
<div class="bottom">

  <div class="nav-item">
    <svg viewBox="0 0 24 24">
      <rect x="3" y="3" width="7" height="7"></rect>
      <rect x="14" y="3" width="7" height="7"></rect>
      <rect x="3" y="14" width="7" height="7"></rect>
      <rect x="14" y="14" width="7" height="7"></rect>
    </svg>
    <span>Dashboard</span>
  </div>

  <div class="nav-item">
    <svg viewBox="0 0 24 24">
      <circle cx="11" cy="11" r="7"></circle>
      <line x1="20" y1="20" x2="16.5" y2="16.5"></line>
    </svg>
    <span>Search</span>
  </div>

  <div class="nav-item">
    <svg viewBox="0 0 24 24">
      <line x1="12" y1="5" x2="12" y2="19"></line>
      <line x1="5" y1="12" x2="19" y2="12"></line>
    </svg>
    <span>Add</span>
  </div>

  <div class="nav-item">
    <svg viewBox="0 0 24 24">
      <path d="M22 2L11 13"></path>
      <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
    </svg>
    <span>Message</span>
  </div>

  <div class="nav-item active">
    <svg viewBox="0 0 24 24">
      <circle cx="12" cy="8" r="4"></circle>
      <path d="M4 21c1.5-4 14.5-4 16 0"></path>
    </svg>
    <span>Profile</span>
  </div>

</div>

</body>
</html>