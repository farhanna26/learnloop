<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Profile</title>
<style>
:root {
  --bg: #ffffff;
  --surface: #f7f5ff;
  --border: #e6dcff;
  --text: #1c1c1c;
  --muted: #6b5b8c;
  --accent: #b794f4;
}

body {
  margin: 0;
  min-height: 100vh;
  font-family: 'DM Sans', sans-serif;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #faf8ff;
  color: var(--text);
  padding: 24px;
}

.page {
  width: 100%;
  max-width: 520px;
  background: #ffffff;
  border: 1px solid var(--border);
  border-radius: 28px;
  box-shadow: 0 28px 80px rgba(120, 87, 255, 0.08);
  padding: 32px;
}

h1 {
  margin: 0 0 10px;
  font-size: 1.85rem;
}

.note {
  margin: 0 0 24px;
  color: var(--muted);
  line-height: 1.6;
}

.form-group {
  margin-bottom: 20px;
}

label {
  display: block;
  margin-bottom: 10px;
  font-weight: 600;
  color: var(--text);
}

input[type=file], textarea {
  width: 100%;
  border-radius: 16px;
  border: 1px solid var(--border);
  background: var(--surface);
  color: var(--text);
  padding: 14px 16px;
  font: 1rem/1.5 sans-serif;
}

textarea {
  min-height: 140px;
  resize: vertical;
}

.preview {
  display: flex;
  align-items: center;
  gap: 16px;
  margin-bottom: 24px;
}

.photo {
  width: 96px;
  height: 96px;
  border-radius: 50%;
  background: #f1f0ff;
  border: 2px solid var(--border);
  background-size: cover;
  background-position: center;
}

.info {
  min-width: 0;
}

.info strong {
  display: block;
  margin-bottom: 6px;
  color: var(--text);
}

.info span {
  color: var(--muted);
  line-height: 1.6;
}

button {
  width: 100%;
  border: none;
  border-radius: 16px;
  padding: 14px 18px;
  font: 600 1rem/1.2 sans-serif;
  background: var(--accent);
  color: #fff;
  cursor: pointer;
  transition: background .2s ease;
}

button:hover {
  background: #9f7aea;
}

.alert {
  margin-bottom: 18px;
  padding: 14px 16px;
  border-radius: 16px;
  background: #ecfdf5;
  color: #065f46;
  border: 1px solid #a7f3d0;
}

.error-list {
  margin-bottom: 18px;
  padding: 14px 16px;
  border-radius: 16px;
  background: #fef2f2;
  color: #b91c1c;
  border: 1px solid #fecaca;
}

.error-list li {
  margin-bottom: 8px;
}

.link-back {
  display: inline-block;
  margin-top: 20px;
  color: var(--accent);
  text-decoration: none;
}
</style>
</head>
<body>
<div class="page">
  <h1>Edit Profile</h1>
  <p class="note">Foto profil dan deskripsi bersifat opsional. Biarkan kosong jika tidak ingin mengubah.</p>

  @if(session('success'))
    <div class="alert">{{ session('success') }}</div>
  @endif

  @if($errors->any())
    <div class="error-list">
      <strong>Perbaiki dulu:</strong>
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ url('/addprofile') }}" method="post" enctype="multipart/form-data">
    @csrf

    <div class="preview">
      <div class="photo" style="@if($user && $user->photo) background-image:url('{{ asset($user->photo) }}'); @endif"></div>
      <div class="info">
        <strong>Foto saat ini</strong>
        <span style="color:#94a3b8; line-height:1.6;">Pilih file baru jika ingin mengganti.</span>
      </div>
    </div>

    <div class="form-group">
      <label for="photo">Unggah foto profil</label>
      <input id="photo" name="photo" type="file" accept="image/*">
    </div>

    <div class="form-group">
      <label for="description">Deskripsi</label>
      <textarea id="description" name="description" placeholder="Contoh: Mahasiswa Teknik Informatika">{{ old('description', $user->description ?? '') }}</textarea>
    </div>

    <button type="submit">Simpan profil</button>
  </form>

  <a class="link-back" href="{{ url('/profile') }}">Kembali ke profil</a>
</div>
</body>
</html>
