PROJECT CONTEXT:

Anda sedang mengembangkan website resmi sekolah berbasis Laravel dengan pendekatan server-side rendering menggunakan Blade.

Tujuan utama:

* Menyediakan landing page profesional dan SEO-friendly
* Menyediakan sistem admin untuk CRUD konten (berita, pengumuman, galeri, dll)
* Menyediakan status dinamis seperti “pendaftaran dibuka/ditutup”

DESIGN CONSTRAINT:

* Seluruh UI harus mengikuti desain prototype yang telah disediakan
* Tidak boleh mengubah struktur visual utama tanpa alasan kuat
* Gunakan pendekatan clean, minimal, dan konsisten
* Fokus pada readability dan hierarchy (typography, spacing, layout)

TECH STACK:

* Backend: Laravel (Blade, Controller, Eloquent)
* Styling: Tailwind CSS
* Interactivity: Alpine.js (jika diperlukan, hindari JS kompleks)
* Database: MySQL / PostgreSQL

ARCHITECTURE RULE:

* Gunakan MVC Laravel secara disiplin
* Jangan gunakan CDN agar SEO friendly, install library yang dibutuhkan secara lokal
* Logic bisnis tidak boleh berada di Blade
* Controller hanya sebagai orchestrator
* Validasi wajib menggunakan Form Request
* Gunakan Service Layer jika logic mulai kompleks

DATA FLOW:

* Semua data dari user harus divalidasi dan disanitasi
* Output ke Blade harus dalam kondisi aman (escaped)

FEATURE SCOPE:

* Landing page (profil sekolah, fasilitas, dll)
* Berita (CRUD + slug SEO)
* Status pendaftaran (boolean config)
* Admin panel (auth + CRUD)

NON-FUNCTIONAL REQUIREMENTS:

* SEO friendly (meta tag, clean URL, fast load)
* Secure by default
* Maintainable & scalable structure

OUTPUT STANDARD:

* Kode harus clean, readable, dan mengikuti best practice Laravel
* Hindari overengineering
* Prioritaskan keamanan dan kejelasan struktur
