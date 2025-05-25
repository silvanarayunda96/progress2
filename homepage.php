<?php
// Database configuration
$host = 'localhost';
$dbname = 'vacsin_db';
$username = 'root';
$password = '';

// Connect to database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // echo "Connection failed: " . $e->getMessage();
}

// Fetch vaccination statistics
function getVaccinationStats($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM vaccination_stats ORDER BY id DESC LIMIT 1");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        return [
            'dose1_percentage' => 91.55,
            'dose2_percentage' => 69.03,
            'dose3_percentage' => 4.71
        ];
    }
}

// Fetch testimonials
function getTestimonials($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM testimonials WHERE is_active = 1 ORDER BY created_at DESC LIMIT 3");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        return [
            [
                'name' => 'Steve John',
                'job' => 'Pegawai Swasta',
                'testimonial' => 'Sebelum divaksin sebaiknya ketahui sendiri vaksin dan keuntungan menggunakannya',
                'avatar' => 'https://via.placeholder.com/60x60/333/fff?text=SJ'
            ],
            [
                'name' => 'Clara Ren',
                'job' => 'Pegawai Swasta',
                'testimonial' => 'Sebelum divaksin sebaiknya ketahui sendiri vaksin dan keuntungan menggunakannya',
                'avatar' => 'https://via.placeholder.com/60x60/333/fff?text=CR'
            ],
            [
                'name' => 'Steve John',
                'job' => 'Pegawai Swasta',
                'testimonial' => 'Sebelum divaksin sebaiknya ketahui sendiri vaksin dan keuntungan menggunakannya',
                'avatar' => 'https://via.placeholder.com/60x60/333/fff?text=SJ'
            ]
        ];
    }
}

// Fetch vaccine variants
function getVaccineVariants($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM vaccine_variants WHERE is_active = 1 ORDER BY id");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch(PDOException $e) {
        return [
            [
                'name' => 'AstraZeneca',
                'description' => 'Vaksin AstraZeneca menggunakan virus tidak aktif (inactive virus). Jarak pemberian vaksin...',
                'logo_url' => 'https://via.placeholder.com/200x60/f4a261/fff?text=AstraZeneca'
            ],
            [
                'name' => 'Sinovac',
                'description' => 'Vaksin Sinovac menggunakan virus tidak aktif (inactive virus). Jarak pemberian vaksin...',
                'logo_url' => 'https://via.placeholder.com/200x60/e63946/fff?text=SINOVAC'
            ],
            [
                'name' => 'Moderna',
                'description' => 'Vaksin Moderna menggunakan virus tidak aktif (inactive virus)...',
                'logo_url' => 'https://via.placeholder.com/200x60/2a9d8f/fff?text=moderna'
            ]
        ];
    }
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'register':
                handleRegistration($pdo, $_POST);
                break;
            case 'contact':
                handleContact($pdo, $_POST);
                break;
        }
    }
}

function handleRegistration($pdo, $data) {
    try {
        $stmt = $pdo->prepare("INSERT INTO registrations (name, email, phone, vaccine_type, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([
            $data['name'],
            $data['email'], 
            $data['phone'],
            $data['vaccine_type']
        ]);
        $success_message = "Registrasi berhasil! Kami akan menghubungi Anda segera.";
    } catch(PDOException $e) {
        $error_message = "Registrasi gagal. Silakan coba lagi.";
    }
}

function handleContact($pdo, $data) {
    try {
        $stmt = $pdo->prepare("INSERT INTO contacts (name, email, subject, message, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute([
            $data['name'],
            $data['email'],
            $data['subject'],
            $data['message']
        ]);
        $success_message = "Pesan berhasil dikirim! Terima kasih atas pertanyaan Anda.";
    } catch(PDOException $e) {
        $error_message = "Pesan gagal dikirim. Silakan coba lagi.";
    }
}

// Get data for display
$vaccinationStats = getVaccinationStats($pdo);
$testimonials = getTestimonials($pdo);
$vaccineVariants = getVaccineVariants($pdo);

// Page title and meta data
$pageTitle = "Vacsin - Program Pemerintah Vaksin COVID-19";
$pageDescription = "Platform edukasi vaksinasi COVID-19 dari pemerintah Indonesia. Dapatkan informasi lengkap tentang vaksin, lokasi vaksinasi, dan daftar sekarang.";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <meta name="description" content="<?php echo $pageDescription; ?>">
    <meta name="keywords" content="vaksin, covid-19, vaksinasi, pemerintah, indonesia, kesehatan">
    <link rel="stylesheet" href="homepage.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <?php if (isset($success_message)): ?>
        <div class="alert alert-success">
            <?php echo $success_message; ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($error_message)): ?>
        <div class="alert alert-error">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <h2>V<span>acsin</span></h2>
            </div>
            <ul class="nav-menu">
                <li><a href="#" class="nav-link active">Home</a></li>
                <li><a href="#variants" class="nav-link">Varian</a></li>
                <li><a href="#edukasi" class="nav-link">Edukasi</a></li>
                <li><a href="#lokasi" class="nav-link">Lokasi Vaksin</a></li>
                <li><a href="#kontak" class="nav-link">Kontak</a></li>
                <li><a href="#" class="nav-link register-btn" onclick="openRegistrationModal()">Registrasi</a></li>
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-container">
            <div class="hero-content">
                <h1>Ayo Ikuti Program Pemerintah Vaksin COVID-19.</h1>
                <p>Vaksin penting untuk menjaga kesehatan diri dan keluarga. Pemerintah menjamin vaksin yang digunakan sesuai dengan standar keamanan dan melewati uji klinik yang ketat</p>
                <button class="cta-button" onclick="openRegistrationModal()">Vaksin Sekarang</button>
            </div>
            <div class="hero-image">
                <div class="placeholder-image"></div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="statistics">
        <div class="container">
            <h2>Total Vaksinasi Yang Telah Dilakukan</h2>
            <div class="stats-grid">
                <div class="stat-item">
                    <h3><?php echo number_format($vaccinationStats['dose1_percentage'], 2); ?>%</h3>
                    <p>Vaksinasi Dosis 1</p>
                </div>
                <div class="stat-item">
                    <h3><?php echo number_format($vaccinationStats['dose2_percentage'], 2); ?>%</h3>
                    <p>Vaksinasi Dosis 2</p>
                </div>
                <div class="stat-item">
                    <h3><?php echo number_format($vaccinationStats['dose3_percentage'], 2); ?>%</h3>
                    <p>Vaksinasi Dosis 3</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Partner Logos -->
    <section class="partners">
        <div class="container">
            <div class="partner-logos">
                <div class="partner-logo">
                    <img src="https://via.placeholder.com/120x60/333/fff?text=GERMAS" alt="GERMAS">
                </div>
                <div class="partner-logo">
                    <img src="https://via.placeholder.com/120x60/333/fff?text=KEMENKES" alt="Kementerian Kesehatan">
                </div>
                <div class="partner-logo">
                    <img src="https://via.placeholder.com/120x60/333/fff?text=PMI" alt="Palang Merah Indonesia">
                </div>
                <div class="partner-logo">
                    <img src="https://via.placeholder.com/120x60/333/fff?text=WHO" alt="World Health Organization">
                </div>
                <div class="partner-logo">
                    <img src="https://via.placeholder.com/120x60/333/fff?text=KPC+PEN" alt="KPC PEN">
                </div>
            </div>
        </div>
    </section>

    <!-- Why Vaccine Section -->
    <section class="why-vaccine" id="edukasi">
        <div class="container">
            <div class="why-content">
                <div class="why-image">
                    <img src="https://via.placeholder.com/400x400/4a9b8e/fff?text=Vaksin+Image" alt="Why Vaccine">
                </div>
                <div class="why-text">
                    <h2>Mengapa saya harus vaksin?</h2>
                    <p>Jangan percaya hoax yang beredar di sosial media, pemerintah memberikan edukasi dan memberikan empat manfaat dari vaksinasi Covid-19. Berikut diantaranya:</p>
                    
                    <div class="accordion">
                        <div class="accordion-item">
                            <div class="accordion-header" onclick="toggleAccordion(this)">
                                <span>01</span>
                                <h3>Merangsang Sistem Kekebalan Tubuh</h3>
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="accordion-content">
                                <p>Vaksin membantu sistem kekebalan tubuh mengenali dan melawan virus COVID-19 dengan aman.</p>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <div class="accordion-header" onclick="toggleAccordion(this)">
                                <span>02</span>
                                <h3>Mengurangi Risiko Penularan</h3>
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="accordion-content">
                                <p>Vaksinasi mengurangi kemungkinan Anda tertular dan menularkan virus kepada orang lain.</p>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <div class="accordion-header" onclick="toggleAccordion(this)">
                                <span>03</span>
                                <h3>Mengurangi Dampak Berat Dari Virus</h3>
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="accordion-content">
                                <p>Vaksin melindungi dari gejala berat COVID-19 yang dapat menyebabkan komplikasi serius.</p>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <div class="accordion-header" onclick="toggleAccordion(this)">
                                <span>04</span>
                                <h3>Mencapai Herd Immunity</h3>
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="accordion-content">
                                <p>Dengan vaksinasi massal, kita dapat mencapai kekebalan kelompok untuk melindungi masyarakat.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Rules Section -->
    <section class="rules">
        <div class="container">
            <div class="rules-content">
                <div class="rules-text">
                    <h2>Beberapa aturan yang harus dipatuhi pasien.</h2>
                    <p>Agar tidak terjadi hal yang tidak diinginkan Ada beberapa syarat yang dipenuhi oleh penerima vaksin. Berikut syarat sebelum menerima vaksin</p>
                </div>
                
                <div class="rules-grid">
                    <div class="rule-item">
                        <h3><span>01</span> Tekanan Darah Harus Normal</h3>
                        <p>Apabila saat skrining kesehatan kamu memiliki tekanan darah diatas 180/110, atau memiliki riwayat hipertensi artinya vaksinasi tidak dapat diberikan.</p>
                    </div>
                    <div class="rule-item">
                        <h3><span>02</span> Hindari Alkohol</h3>
                        <p>Hal ini penting dilakukan agar sistem imun Anda tetap kuat dan dapat menghasilkan reaksi kekebalan tubuh yang baik untuk mencegah infeksi virus Corona.</p>
                    </div>
                    <div class="rule-item">
                        <h3><span>03</span> Tidur yang cukup</h3>
                        <p>Beberapa hari sebelum disuntik vaksin COVID-19, usahakan untuk tidak begadang dan cukupi waktu istirahat dengan tidur selama 7–9 jam setiap malamnya.</p>
                    </div>
                    <div class="rule-item">
                        <h3><span>04</span> Informasikan kondisi kesehatan diri</h3>
                        <p>Beri tahu dokter atau petugas vaksinasi COVID-19 mengenai kondisi kesehatan Anda saat hendak divaksin, seperti: Demam, Penyakit tertentu, konsumsi obat-obatan tertentu.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Vaccine Variants Section -->
    <section class="variants" id="variants">
        <div class="container">
            <h2>Varian Vaksin</h2>
            <p class="section-subtitle">Sebelum divaksin, ada baiknya ketahui sendiri vaksin dan keuntungan menggunakannya</p>
            
            <div class="variants-grid">
                <?php foreach ($vaccineVariants as $variant): ?>
                <div class="variant-card">
                    <div class="variant-logo">
                        <img src="<?php echo $variant['logo_url']; ?>" alt="<?php echo $variant['name']; ?>">
                    </div>
                    <p><?php echo $variant['description']; ?></p>
                    <button class="read-more-btn" onclick="showVariantDetails('<?php echo $variant['name']; ?>')">Baca Selengkapnya</button>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials">
        <div class="container">
            <h2>Testimoni</h2>
            <p class="section-subtitle">Kata mereka yang telah melakukan vaksinasi dari program pemerintah</p>
            
            <div class="testimonials-grid">
                <?php foreach ($testimonials as $testimonial): ?>
                <div class="testimonial-card">
                    <div class="testimonial-header">
                        <img src="<?php echo $testimonial['avatar']; ?>" alt="<?php echo $testimonial['name']; ?>">
                        <div class="testimonial-info">
                            <h3><?php echo $testimonial['name']; ?></h3>
                            <p><?php echo $testimonial['job']; ?></p>
                        </div>
                    </div>
                    <p>"<?php echo $testimonial['testimonial']; ?>"</p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Registration Modal -->
    <div id="registrationModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeRegistrationModal()">&times;</span>
            <h2>Registrasi Vaksinasi</h2>
            <form method="POST" action="">
                <input type="hidden" name="action" value="register">
                <div class="form-group">
                    <label for="name">Nama Lengkap:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Nomor Telepon:</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="vaccine_type">Pilih Jenis Vaksin:</label>
                    <select id="vaccine_type" name="vaccine_type" required>
                        <option value="">Pilih Vaksin</option>
                        <?php foreach ($vaccineVariants as $variant): ?>
                        <option value="<?php echo $variant['name']; ?>"><?php echo $variant['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="submit-btn">Daftar Sekarang</button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer" id="kontak">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>V<span>acsin</span> 🇮🇩</h3>
                    <p>Vacsin adalah platform edukasi vaksinasi</p>
                </div>
                <div class="footer-section">
                    <h4>Perusahaan</h4>
                    <ul>
                        <li><a href="#">Tentang</a></li>
                        <li><a href="#">Kontak</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Layanan</h4>
                    <ul>
                        <li><a href="#edukasi">Edukasi</a></li>
                        <li><a href="#variants">Varian</a></li>
                        <li><a href="#lokasi">Vaksin</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Kebijakan</h4>
                    <ul>
                        <li><a href="#">Syarat & Ketentuan</a></li>
                        <li><a href="#">Kebijakan Privasi</a></li>
                        <li><a href="#">FAQ</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="homepage.js"></script>
</body>
</html>
