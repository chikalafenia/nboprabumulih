<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- CHATBOT -->
<div id="chatbot-container">
  <div id="chatbot-toggle">💬</div>

  <div id="chatbot-box">
    <div class="chat-header">N'B'O Assistant 💖</div>

    <div id="chat-content"></div>

    <div class="chat-input">
      <input type="text" id="user-input" placeholder="Tanya sesuatu...">
      <button onclick="sendMessage()">Kirim</button>
    </div>
  </div>
</div>

<script>
let produk = [];

// ambil data dari database
fetch("get_produk.php")
.then(res => res.json())
.then(data => {
  produk = data;
});

// toggle chatbot (tidak diubah)
const toggle = document.getElementById("chatbot-toggle");
const box = document.getElementById("chatbot-box");

toggle.onclick = () => {
  box.style.display = box.style.display === "flex" ? "none" : "flex";
};

function sendMessage(){
  let input = document.getElementById("user-input");
  let chat = document.getElementById("chat-content");

  let userText = input.value;
  if(userText === "") return;

  chat.innerHTML += "<p><b>Kamu:</b> " + userText + "</p>";

  let botReply = getBotResponse(userText);
  chat.innerHTML += "<p>" + botReply + "</p>";

  input.value = "";
  chat.scrollTop = chat.scrollHeight;
}

function getBotResponse(input){
  input = input.toLowerCase();

  let hasil = "";

  // =========================
  // FILTER BERDASARKAN KATEGORI
  // =========================
  let kategori = "";
  if(input.includes("gamis")) kategori = "gamis";
  else if(input.includes("tunik")) kategori = "tunik";
  else if(input.includes("atasan") || input.includes("baju")) kategori = "atasan";

  // =========================
  // FILTER PRODUK
  // =========================
  let filtered = produk.filter(p => {
    if(kategori === "gamis") return p.nama.toLowerCase().includes("gamis");
    if(kategori === "tunik") return p.nama.toLowerCase().includes("tunik");
    if(kategori === "atasan") return p.nama.toLowerCase().includes("atasan") || p.nama.toLowerCase().includes("baju");
    return true;
  });

  // =========================
  // REKOMENDASI BAGUS (default)
  // =========================
  if(input.includes("rekomendasi") && input.includes("bagus")){
    hasil += "🔥 Rekomendasi Terbaik:<br>";

    filtered.slice(0,3).forEach(p=>{
      hasil += `
        <img src="${p.gambar}" width="70"><br>
        <b>${p.nama}</b><br>
        Rp ${parseInt(p.harga).toLocaleString()}<br><br>
      `;
    });

    return hasil;
  }

  // =========================
  // REKOMENDASI MURAH
  // =========================
  if(input.includes("murah")){
    hasil += "💸 Rekomendasi Termurah:<br>";

    let murah = filtered.sort((a,b)=>a.harga - b.harga).slice(0,3);

    murah.forEach(p=>{
      hasil += `
        <img src="${p.gambar}" width="70"><br>
        <b>${p.nama}</b><br>
        Rp ${parseInt(p.harga).toLocaleString()}<br><br>
      `;
    });

    return hasil;
  }

  // =========================
// ALAMAT BUTIK
// =========================
if(input.includes("alamat") || input.includes("lokasi") || input.includes("dimana")){
  return `
    📍 Alamat Butik N'B'O PRABUMULIH:<br><br>
    Jl. beringin no 01 rt 02 rw 03 dekat masjid al-istiqomah kel. anank petai kec prabumulih utara<br><br>

    <a href="https://maps.google.com/?q=prabumulih"
    target="_blank"
    style="
      display:inline-block;
      background:#ff1493;
      color:white;
      padding:8px 15px;
      border-radius:20px;
      text-decoration:none;
      font-weight:bold;
    ">
    📍 Lihat di Google Maps
    </a>
  `;
}

  // =========================
  // REKOMENDASI UMUM
  // =========================
  if(input.includes("rekomendasi")){
    hasil += "✨ Rekomendasi Produk:<br>";

    filtered.slice(0,3).forEach(p=>{
      hasil += `
        <img src="${p.gambar}" width="70"><br>
        ${p.nama} - Rp ${parseInt(p.harga).toLocaleString()}<br><br>
      `;
    });

    return hasil;
  }

  // =========================
  // HARGA
  // =========================
  if(input.includes("harga")){
    hasil += "📌 Daftar Harga:<br>";

    filtered.forEach(p=>{
      hasil += `${p.nama} - Rp ${parseInt(p.harga).toLocaleString()}<br>`;
    });

    return hasil;
  }

  // =========================
// PRODUK TIDAK TERSEDIA
// =========================
if(input.includes("celana")){
  return "❌ Maaf kak, kami tidak menjual produk celana 😊";
}
  // =========================
  // DETAIL PRODUK
  // =========================
  for(let p of produk){
  if(input.includes(p.nama.toLowerCase())){
    return `
      <img src="${p.gambar}" width="100"><br>
      <b>${p.nama}</b><br>
      💰 Rp ${parseInt(p.harga).toLocaleString()}<br>
      ${p.deskripsi}<br><br>

      <a href="https://wa.me/6285377682299?text=Halo saya ingin membeli ${p.nama}"
      target="_blank"
      style="
        display:inline-block;
        background:#25D366;
        color:white;
        padding:8px 15px;
        border-radius:20px;
        text-decoration:none;
        font-weight:bold;
      ">
      🛒 Beli Sekarang
      </a>
    `;
  }
}

  return "Coba ketik: rekomendasi gamis bagus / atasan murah / harga tunik 😊";
}
</script>

  <title>N'B'O PRABUMULIH</title>
  <style>
    
body {margin:0;font-family:Arial;background:#fff0f5;}

header{background:#ff4da6;color:#fff;padding:10px;text-align:center;font-weight:bold;}

.navbar{display:flex;align-items:center;justify-content:space-between;padding:10px 20px;background:#fff;}

.logo{display:flex;align-items:center;gap:10px;}

.logo img{width:50px;height:50px;border-radius:50%;object-fit:cover;}

.brand-center{display:flex;flex-direction:column;align-items:center;justify-content:center;padding:20px;background:#ffe4ec;}

.brand-center img{width:150px;height:150px;border-radius:50%;object-fit:cover;border:5px solid #ff4da6;box-shadow:0 4px 10px rgba(0,0,0,0.2);} 

.brand-center h1{margin-top:10px;color:#ff1493;font-size:28px;}

.menu a{margin:0 10px;text-decoration:none;color:#ff4da6;font-weight:bold;}

/* CHATBOT STYLE */
#chatbot-container{
  position:fixed;
  bottom:20px;
  left:20px;
  z-index:999;
}

#chatbot-toggle{
  background:#ff4da6;
  color:#fff;
  padding:15px;
  border-radius:50%;
  cursor:pointer;
  box-shadow:0 4px 10px rgba(0,0,0,0.2);
}

#chatbot-box{
  width:300px;
  height:400px;
  background:#fff;
  border-radius:15px;
  box-shadow:0 5px 15px rgba(0,0,0,0.2);
  display:none;
  flex-direction:column;
  overflow:hidden;
}

.chat-header{
  background:#ff4da6;
  color:#fff;
  padding:10px;
  text-align:center;
  font-weight:bold;
}

#chat-content{
  flex:1;
  padding:10px;
  overflow-y:auto;
  font-size:14px;
}

.chat-input{
  display:flex;
  border-top:1px solid #ddd;
}

.chat-input input{
  flex:1;
  padding:10px;
  border:none;
}

.chat-input button{
  background:#ff4da6;
  color:#fff;
  border:none;
  padding:10px;
  cursor:pointer;
}

.hero-text{
  max-width:500px;
  text-align:center;
  margin:auto;
  padding:10px;
}

.hero-text h2{
  color:#ff1493;
  font-size:24px;
}

.btn-group{
  display:flex;
  justify-content:center;
  gap:15px;
  margin-top:20px;
  flex-wrap:wrap;
}

.btn{
  padding:12px 20px;
  border:none;
  border-radius:25px;
  text-decoration:none;
  color:#fff;
  font-weight:bold;
}

.wa-btn{background:#25D366;}
.fb-btn{background:#1877F2;}

.btn:hover{
  transform:scale(1.05);
  transition:0.3s;
}

/* 🔥 SCROLL SAMPING */
.kategori{
  display:flex;
  overflow-x:auto;
  gap:15px;
  padding:20px;
  scroll-snap-type:x mandatory;
  scroll-behavior:smooth;
}

.kategori::-webkit-scrollbar{
  display:none;
}

.card{
  background:#fff;
  padding:10px; /* lebih kecil biar tidak kosong */
  border-radius:10px;
  text-align:center;
  box-shadow:0 2px 5px rgba(0,0,0,0.1);
  min-width:160px; /* lebih pas */
  max-width:180px; /* biar tidak melebar */
  flex:0 0 auto;
  scroll-snap-align:start;
}
.card img{
  width:100%;
  height:auto; /* BIAR IKUT ASLI */
  border-radius:10px;
}

h2{
  text-align: center;
  margin-top: 30px;
  margin-bottom: 10px;
  color: #ff1493;
}



.about{padding:20px;background:#fff;margin:20px;border-radius:10px;}

.section{padding:10px;text-align:center;}

.maps{padding:20px;}

.footer{background:#ff4da6;color:#fff;text-align:center;padding:15px;}

.wa{position:fixed;bottom:20px;right:20px;background:#25D366;color:#fff;padding:15px;border-radius:50%;text-decoration:none;}
.fb{position:fixed;bottom:80px;right:20px;background:#1877F2;color:#fff;padding:15px;border-radius:50%;text-decoration:none;}

</style>
</head>
<body>

<header>Welcome To N'B'O PRABUMULIH</header>

<div class="navbar">
  <div class="logo">
    <img src="logo.jpeg" alt="logo butik">
    <b>N'B'O PRABUMULIH</b>
  </div>
  <div class="menu">
    <a href="#">Beranda</a>
    <a href="#kategori">Kategori</a>
    <a href="#about">Tentang</a>
  </div>
</div>

<div class="brand-center">
  <img src="logo.jpeg" alt="logo besar">
  <h1>N'B'O PRABUMULIH</h1>
</div>

<div class="hero-text">
  <h2>Tampil Cantik, Elegan & Percaya Diri Setiap Hari ✨</h2>
  <p>Dapatkan koleksi fashion wanita modern & muslimah dengan kualitas terbaik, model terbaru, dan harga terjangkau hanya di N'B'O PRABUMULIH 💖</p>

  <div class="btn-group">
    <a href="https://wa.me/6285377682299" class="btn wa-btn">Chat WhatsApp</a>
    <a href="https://facebook.com/nirta.birhap.9" class="btn fb-btn">Kunjungi Facebook</a>
  </div>
</div>

<h2>Kategori Baju Atasan</h2>

<div class="kategori">

  <div class="card">
    <img src="baju7.jpeg">
    <p>Baju 1</p>
    <p style="color:#ff1493;font-weight:bold;">Rp 90.000</p>
  </div>

  <div class="card">
    <img src="baju2.jpeg">
    <p>Baju 2</p>
    <p style="color:#ff1493;font-weight:bold;">Rp 105.000</p>
  </div>

  <div class="card">
    <img src="baju3.jpeg">
    <p>Baju 3</p>
    <p style="color:#ff1493;font-weight:bold;">Rp 75.000</p>
  </div>

  <div class="card">
    <img src="baju4.jpeg">
    <p>Baju 4</p>
    <p style="color:#ff1493;font-weight:bold;">Rp 99.000</p>
  </div>

  <div class="card">
    <img src="baju5.jpeg">
    <p>Baju 5</p>
    <p style="color:#ff1493;font-weight:bold;">Rp 78.000</p>
  </div>

  <div class="card">
    <img src="baju6.jpeg">
    <p>Baju 6</p>
    <p style="color:#ff1493;font-weight:bold;">Rp 66.000</p>
  </div>

</div>

<h2>Kategori Gamis </h2>

<div class="kategori">

  <div class="card">
    <img src="gamis1.jpeg">
    <p>Gamis 1</p>
    <p style="color:#ff1493;font-weight:bold;">Rp 150.000</p>
  </div>

  <div class="card">
    <img src="gamis2.jpeg">
    <p>Gamis 2</p>
    <p style="color:#ff1493;font-weight:bold;">Rp 160.000</p>
  </div>

  <div class="card">
    <img src="gamis3.jpeg">
    <p>Gamis 3</p>
    <p style="color:#ff1493;font-weight:bold;">Rp 155.000</p>
  </div>

  <div class="card">
    <img src="gamis4.jpeg">
    <p>Gamis 4</p>
    <p style="color:#ff1493;font-weight:bold;">Rp 163.000</p>
  </div>

  <div class="card">
    <img src="gamis5.jpeg">
    <p>Gamis 5</p>
    <p style="color:#ff1493;font-weight:bold;">Rp 138.000</p>
  </div>

  <div class="card">
    <img src="gamis6.jpeg">
    <p>Gamis 6</p>
    <p style="color:#ff1493;font-weight:bold;">Rp 130.000</p>
  </div>

</div>
  
 <h2>Kategori Tunik </h2>

<div class="kategori">

  <div class="card">
    <img src="tunik1.jpeg">
    <p>Tunik 1 1</p>
    <p style="color:#ff1493;font-weight:bold;">Rp 99.000</p>
  </div>

  <div class="card">
    <img src="tunik2.jpeg">
    <p>Tunik 2</p>
    <p style="color:#ff1493;font-weight:bold;">Rp 115.000</p>
  </div>

  <div class="card">
    <img src="tunik3.jpeg">
    <p>Tunik 3</p>
    <p style="color:#ff1493;font-weight:bold;">Rp 89.000</p>
  </div>

  <div class="card">
    <img src="tunik4.jpeg">
    <p>Tunik 4</p>
    <p style="color:#ff1493;font-weight:bold;">Rp 120.000</p>
  </div>

  <div class="card">
    <img src="tunik5.jpeg">
    <p>Tunik 5</p>
    <p style="color:#ff1493;font-weight:bold;">Rp 135.000</p>
  </div>

  <div class="card">
    <img src="tunik6.jpeg">
    <p>Tunik 6</p>
    <p style="color:#ff1493;font-weight:bold;">Rp 150.000</p>
  </div>

</div>
  </div>


<div class="about" id="about">
  <h2>Tentang Butik</h2>

  <p><b>N'B'O PRABUMULIH</b> merupakan butik fashion wanita yang berfokus pada penyediaan pakaian modern dan muslimah dengan desain yang elegan, kekinian, serta nyaman digunakan dalam berbagai aktivitas sehari-hari maupun acara formal.</p>

  <p>Butik ini didirikan dan dikelola oleh <b>NIRTA BIRHAP</b>, dengan tujuan menghadirkan produk fashion yang tidak hanya mengikuti tren, tetapi juga tetap menjaga nilai kesopanan dan kenyamanan bagi para wanita.</p>

  <p>Kami menyediakan berbagai jenis pakaian seperti <b>tunik, kemeja, gamis, dan celana</b> yang dipilih dengan kualitas bahan terbaik, jahitan rapi, serta model yang selalu update mengikuti perkembangan fashion saat ini.</p>

  <p>N'B'O PRABUMULIH beroperasi secara online, sehingga pelanggan dapat dengan mudah melakukan pemesanan dari mana saja melalui <b>WhatsApp</b> dan melihat update produk terbaru melalui <b>Facebook</b>. Sistem ini memudahkan pelanggan tanpa harus datang langsung ke toko.</p>

  <p>Kami selalu mengutamakan kepuasan pelanggan dengan memberikan pelayanan yang ramah, respon cepat, serta proses pemesanan yang mudah dan terpercaya.</p>

  <p><b>Keunggulan N'B'O PRABUMULIH:</b></p>
  <ul>
    <li>Produk berkualitas dengan bahan nyaman dipakai</li>
    <li>Model selalu update dan mengikuti tren</li>
    <li>Pelayanan cepat dan responsif</li>
    <li>Pemesanan mudah melalui WhatsApp</li>
    <li>Update produk aktif di Facebook</li>
  </ul>

  <p><b>Visi:</b><br>
  Menjadi butik fashion wanita terpercaya di Prabumulih yang menyediakan produk berkualitas dan selalu mengikuti perkembangan tren fashion.</p>

  <p><b>Misi:</b></p>
  <ul>
    <li>Menyediakan pakaian wanita yang modis dan berkualitas</li>
    <li>Memberikan pelayanan terbaik kepada pelanggan</li>
    <li>Mempermudah proses pembelian secara online</li>
    <li>Selalu menghadirkan produk terbaru dan menarik</li>
  </ul>

  <p>Untuk melihat koleksi terbaru dan update produk, silakan kunjungi Facebook kami atau hubungi langsung melalui WhatsApp yang tersedia di website ini.</p>
</div>

<div class="maps">
  <h2>Lokasi</h2>
  <iframe src="https://maps.google.com/maps?q=prabumulih&t=&z=13&ie=UTF8&iwloc=&output=embed" width="100%" height="300"></iframe>
</div>

<a class="wa" href="https://wa.me/6285377682299">WA</a>
<a class="fb" href="https://facebook.com/nirta.birhap.9">FB</a>

<div class="footer">© 2026 N'B'O PRABUMULIH</div>

</body>
</html>