<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vacsin - Platform Edukasi Vaksin Indonesia</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body>
    <div class="container">
        <div class="left-section">
            <div class="logo-container">
                <h1><span class="logo-v">V</span>acsin</h1>
            </div>
            <div class="tagline">
                <h2>Platform Edukasi Vaksin Indonesia <span class="flag">🇮🇩</span></h2>
                <p>Ayo bantu Indonesia menuju endemi!</p>
            </div>
            <div class="gambar-dokter">
                <img src="{{ asset('images/dokter.png') }}" alt="Dokter">
            </div>
        </div>
        <div class="right-section">
            <div class="form-container">
                <h2>Registrasi</h2>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nama_depan">Nama Depan</label>
                            <input type="text" id="nama_depan" name="nama_depan" placeholder="Nama Depan" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_belakang">Nama Belakang</label>
                            <input type="text" id="nama_belakang" name="nama_belakang" placeholder="Nama Belakang" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nomor_identitas">Nomor Identitas</label>
                        <input type="text" id="nomor_identitas" name="nomor_identitas" placeholder="17926389237****" required>
                    </div>

                    <div class="form-group">
                        <label for="nomor_handphone">Nomor Handphone</label>
                        <div class="phone-input">
                            <div class="country-code">
                                <span class="flag">🇮🇩</span>
                                <span>+62</span>
                            </div>
                            <input type="tel" id="nomor_handphone" name="nomor_handphone" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="cth: example@gmail.id" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="password">Kata Sandi</label>
                            <input type="password" id="password" name="password" placeholder="Minimal 8 Karakter" required>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Minimal 8 Karakter" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">Daftar</button>
                </form>
                <div class="login-link">
                    <p>Sudah Memiliki Akun? <a href="{{ route('login') }}">Masuk</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
