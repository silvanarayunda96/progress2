<?php
// Include database connection and functions
require_once 'functions.php';

// Get vaccination statistics
$stats = getVaccinationStats();

// Get vaccination benefits
$benefits = getVaccinationBenefits();

// Get patient rules
$rules = getPatientRules();

// Get vaccine variants
$variants = getVaccineVariants();

// Get testimonials
$testimonials = getTestimonials();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vacsin - Program Vaksinasi COVID-19</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Header Navigation -->
    <header>
        <div class="container">
            <nav class="navbar">
                <div class="logo">
                    <a href="index.php"><span class="v-logo">V</span>acsin</a>
                </div>
                <ul class="nav-menu">
                    <li><a href="index.php" class="active">Home</a></li>
                    <li><a href="varian.php">Varian</a></li>
                    <li><a href="edukasi.php">Edukasi</a></li>
                    <li><a href="lokasi.php">Lokasi Vaksin</a></li>
                    <li><a href="kontak.php">Kontak</a></li>
                    <li><a href="registrasi.php" class="register-btn">Registrasi</a></li>
                </ul>
                <div class="hamburger-menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1>Ayo Ikuti Program Pemerintah Vaksin COVID-19.</h1>
                    <p>Vaksin penting untuk menjaga kesehatan diri dan keluarga. Pmerintah menjamin vaksin yang digunakan sesuai dengan standar keamanan dan melewati uji klinik yang ketat</p>
                    <a href="registrasi.php" class="cta-btn">Vaksin Sekarang</a>
                </div>
                <div class="hero-image">
                    <!-- Placeholder for hero image -->
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="statistics">
        <div class="container">
            <h2>Total Vaksinasi Yang Telah Dilakukan</h2>
            <div class="stats-container">
                <div class="stat-box">
                    <h3><?php echo $stats['dosis1']; ?>%</h3>
                    <p>Vaksinasi Dosis 1</p>
                </div>
                <div class="stat-box">
                    <h3><?php echo $stats['dosis2']; ?>%</h3>
                    <p>Vaksinasi Dosis 2</p>
                </div>
                <div class="stat-box">
                    <h3><?php echo $stats['dosis3']; ?>%</h3>
                    <p>Vaksinasi Dosis 3</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Vaccinate Section -->
    <section class="why-vaccinate">
        <div class="container">
            <h2>Mengapa saya harus vaksin?</h2>
            <p class="section-description">Untuk melawan hoax yang beredar di sosial media, pemerintah memberikan edukasi dengan memberikan empat manfaat dari vaksinasi Covid-19. Berikut diantaranya:</p>
            
            <div class="benefits">
                <?php foreach($benefits as $benefit): ?>
                <div class="benefit-item" data-id="<?php echo $benefit['id']; ?>">
                    <span class="benefit-number"><?php echo str_pad($benefit['id'], 2, '0', STR_PAD_LEFT); ?></span>
                    <div class="benefit-content">
                        <h3><?php echo $benefit['title']; ?></h3>
                        <div class="expand-icon">+</div>
                    </div>
                    <div class="benefit-description" style="display: none;">
                        <p><?php echo $benefit['description']; ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Patient Rules Section -->
    <section class="patient-rules">
        <div class="container">
            <div class="rules-header">
                <h2>Beberapa aturan yang harus dipatuhi pasien.</h2>
                <p>Agar tidak terjadi hal yang tidak diinginkan Ada beberapa syarat yang dipenuhi oleh penerima vaksin. Berikut syarat sebelum menerima vaksin</p>
            </div>
            <div class="rules-grid">
                <?php foreach($rules as $rule): ?>
                <div class="rule-item">
                    <span class="rule-number"><?php echo str_pad($rule['id'], 2, '0', STR_PAD_LEFT); ?></span>
                    <h3><?php echo $rule['title']; ?></h3>
                    <p><?php echo $rule['description']; ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Vaccine Variants -->
    <section class="vaccine-variants">
        <div class="container">
            <h2>Varian Vaksin</h2>
            <p class="section-description">Sebelum divaksin, ada baiknya ketahui sendiri vaksin dan keuntungan menggunakannya</p>
            
            <div class="variant-slider">
                <?php foreach($variants as $variant): ?>
                <div class="variant-card">
                    <img src="<?php echo $variant['image']; ?>" alt="<?php echo $variant['name']; ?>">
                    <h3><?php echo $variant['name']; ?></h3>
                    <p><?php echo $variant['short_desc']; ?></p>
                    <a href="detail-<?php echo $variant['slug']; ?>.php" class="read-more-btn">Baca Selangkapnya</a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials">
        <div class="container">
            <h2>Testimoni</h2>
            <p class="section-description">Kata mereka yang telah melakukan vaksinasi dari program pemerintah</p>
            
            <div class="testimonial-slider">
                <?php foreach($testimonials as $testimonial): ?>
                <div class="testimonial-card">
                    <img src="<?php echo $testimonial['image']; ?>" alt="<?php echo $testimonial['name']; ?>">
                    <h3><?php echo $testimonial['name']; ?></h3>
                    <p class="job-title"><?php echo $testimonial['job']; ?></p>
                    <p class="quote">" <?php echo $testimonial['quote']; ?> "</p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <a href="index.php"><span class="v-logo">V</span>acsin <img src="img/indonesia-flag.png" alt="Indonesia Flag" class="flag"></a>
                    <p>Vacsin adalah platform edukasi vaksinasi</p>
                </div>
                <div class="footer-links">
                    <div class="footer-col">
                        <h3>Perusahaan</h3>
                        <ul>
                            <li><a href="about.php">Tentang</a></li>
                            <li><a href="kontak.php">Kontak</a></li>
                        </ul>
                    </div>
                    <div class="footer-col">
                        <h3>Layanan</h3>
                        <ul>
                            <li><a href="edukasi.php">Edukasi</a></li>
                            <li><a href="varian.php">Varian</a></li>
                            <li><a href="vaksin.php">Vaksin</a></li>
                        </ul>
                    </div>
                    <div class="footer-col">
                        <h3>Kebijakan</h3>
                        <ul>
                            <li><a href="syarat.php">Syarat & Ketentuan</a></li>
                            <li><a href="privacy.php">Kebijakan Privasi</a></li>
                            <li><a href="faq.php">FAQ</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; <?php echo date('Y'); ?> Vacsin. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="scripts.js"></script>
</body>
</html>