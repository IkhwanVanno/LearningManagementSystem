<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduSmarts - We Can Teach You!</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/welcome.css', 'resources/js/welcome.js'])
</head>

<body>
    <!-- Navigation -->
    <nav>
        <div class="nav-container">
            <div class="logo">
                <i class="fas fa-graduation-cap"></i> EduSmarts
            </div>
            <ul class="nav-menu">
                <li><a href="#home">Home</a></li>
                <li><a href="#courses">Courses</a></li>
                <li><a href="#membership">Membership</a></li>
                <li><a href="#pages">Pages</a></li>
                <li><a href="#blog">Blog</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
            <div class="nav-buttons">
                <a href="{{ url('/auth/login') }}" class="btn-login">Login</a>
                <a href="{{ url('/auth/register') }}" class="btn-signup">Sign Up</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-content">
            <h1>We Can Teach You!</h1>
            <p>Bergabunglah dengan ribuan siswa yang telah meningkatkan skill mereka bersama kami. Platform pembelajaran
                online terpercaya dengan instruktur profesional.</p>
            <div class="hero-buttons">
                <button class="btn-primary">Get Started</button>
                <button class="btn-secondary">Learn More</button>
            </div>
            <div class="categories">
                <div class="category-icon" style="background: #00bcd4;">
                    <i class="fas fa-laptop-code"></i>
                    <span>Design</span>
                </div>
                <div class="category-icon" style="background: #4caf50;">
                    <i class="fas fa-chart-line"></i>
                    <span>Business</span>
                </div>
                <div class="category-icon" style="background: #9c27b0;">
                    <i class="fas fa-microscope"></i>
                    <span>Science</span>
                </div>
                <div class="category-icon" style="background: #ff9800;">
                    <i class="fas fa-palette"></i>
                    <span>Art</span>
                </div>
                <div class="category-icon" style="background: #f44336;">
                    <i class="fas fa-language"></i>
                    <span>Language</span>
                </div>
                <div class="category-icon" style="background: #00bcd4;">
                    <i class="fas fa-camera"></i>
                    <span>Media</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services" id="services">
        <div class="container">
            <div class="section-header">
                <div class="section-subtitle">What We Offer</div>
                <h2 class="section-title">Our Services</h2>
                <p class="section-description">Kami menyediakan berbagai layanan pembelajaran untuk membantu Anda
                    mencapai tujuan karir dan pendidikan Anda.</p>
            </div>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h3>Notification & Emails</h3>
                    <p>Dapatkan notifikasi real-time untuk setiap update kursus dan pengumuman penting langsung ke email
                        Anda.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon" style="background: linear-gradient(135deg, #48c6ef 0%, #6f86d6 100%);">
                        <i class="fas fa-certificate"></i>
                    </div>
                    <h3>Certification</h3>
                    <p>Raih sertifikat resmi yang diakui industri setelah menyelesaikan setiap kursus dengan sukses.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                        <i class="fas fa-campground"></i>
                    </div>
                    <h3>Engage Campus</h3>
                    <p>Berinteraksi dengan instruktur dan sesama siswa melalui forum diskusi dan sesi live interaktif.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Courses -->
    <section class="courses" id="courses">
        <div class="container">
            <div class="section-header">
                <div class="section-subtitle">Learn Anything</div>
                <h2 class="section-title">Popular Online Courses</h2>
                <p class="section-description">Jelajahi kursus-kursus terpopuler kami yang dirancang oleh para ahli di
                    bidangnya dengan kurikulum yang up-to-date.</p>
            </div>
            <div class="courses-carousel">
                <div class="courses-track" id="coursesTrack">
                    <div class="course-card">
                        <div class="course-image">
                            <i class="fas fa-code"></i>
                        </div>
                        <div class="course-content">
                            <div class="course-category">Web Development</div>
                            <h3 class="course-title">Web Development Master Course</h3>
                            <div class="course-meta">
                                <span><i class="fas fa-user"></i> 2,340 Students</span>
                                <span><i class="fas fa-star" style="color: #ffc107;"></i> 4.9</span>
                            </div>
                            <p style="color: #666; font-size: 14px; margin-bottom: 15px;">Learn modern web development
                                from scratch with HTML, CSS, JavaScript and frameworks.</p>
                            <div class="course-price">$49</div>
                        </div>
                    </div>
                    <div class="course-card">
                        <div class="course-image"
                            style="background: linear-gradient(135deg, #48c6ef 0%, #6f86d6 100%);">
                            <i class="fas fa-paint-brush"></i>
                        </div>
                        <div class="course-content">
                            <div class="course-category">UI/UX Design</div>
                            <h3 class="course-title">UI/UX Design Fundamentals</h3>
                            <div class="course-meta">
                                <span><i class="fas fa-user"></i> 1,850 Students</span>
                                <span><i class="fas fa-star" style="color: #ffc107;"></i> 4.8</span>
                            </div>
                            <p style="color: #666; font-size: 14px; margin-bottom: 15px;">Master the art of creating
                                beautiful and functional user interfaces and experiences.</p>
                            <div class="course-price">$59</div>
                        </div>
                    </div>
                    <div class="course-card">
                        <div class="course-image"
                            style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                            <i class="fas fa-database"></i>
                        </div>
                        <div class="course-content">
                            <div class="course-category">Data Science</div>
                            <h3 class="course-title">Data Science with Python</h3>
                            <div class="course-meta">
                                <span><i class="fas fa-user"></i> 3,120 Students</span>
                                <span><i class="fas fa-star" style="color: #ffc107;"></i> 5.0</span>
                            </div>
                            <p style="color: #666; font-size: 14px; margin-bottom: 15px;">Learn data analysis,
                                visualization and machine learning using Python libraries.</p>
                            <div class="course-price">$79</div>
                        </div>
                    </div>
                    <div class="course-card">
                        <div class="course-image"
                            style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="course-content">
                            <div class="course-category">Mobile Development</div>
                            <h3 class="course-title">Mobile App Development</h3>
                            <div class="course-meta">
                                <span><i class="fas fa-user"></i> 2,670 Students</span>
                                <span><i class="fas fa-star" style="color: #ffc107;"></i> 4.7</span>
                            </div>
                            <p style="color: #666; font-size: 14px; margin-bottom: 15px;">Build native mobile
                                applications for iOS and Android platforms from scratch.</p>
                            <div class="course-price">$69</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-dots">
                <div class="dot active"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
        </div>
    </section>

    <!-- What We Do -->
    <section class="what-we-do">
        <div class="container">
            <div class="what-grid">
                <div>
                    <div class="section-subtitle">Why Choose Us</div>
                    <h2 class="section-title">What We Do</h2>
                    <p class="section-description" style="text-align: left; margin: 0 0 30px 0;">Kami berkomitmen untuk
                        memberikan pengalaman belajar terbaik dengan metode pembelajaran yang inovatif dan instruktur
                        berpengalaman.</p>
                    <ul class="what-list">
                        <li>Learn with experts who are passionate about teaching</li>
                        <li>Access course materials anytime, anywhere at your own pace</li>
                        <li>Interactive learning with quizzes and hands-on projects</li>
                        <li>Join a community of learners and expand your network</li>
                        <li>Get career support and job placement assistance</li>
                    </ul>
                </div>
                <div>
                    <div class="what-image">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="how-it-works">
        <div class="container">
            <div class="section-header">
                <div class="section-subtitle">Research & Delivery</div>
                <h2 class="section-title">How It Works?</h2>
                <p class="section-description">Proses pembelajaran yang sederhana dan efektif untuk memaksimalkan hasil
                    belajar Anda dalam waktu singkat.</p>
            </div>
            <div class="steps-grid">
                <div class="step-card">
                    <div class="step-image">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3>Find Your Course</h3>
                    <p>Pilih dari ratusan kursus berkualitas sesuai minat dan kebutuhan Anda untuk memulai perjalanan
                        belajar.</p>
                </div>
                <div class="step-card">
                    <div class="step-image" style="background: linear-gradient(135deg, #48c6ef 0%, #6f86d6 100%);">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3>E-Learning</h3>
                    <p>Akses materi pembelajaran interaktif dengan video, quiz, dan latihan praktis kapan saja.</p>
                </div>
                <div class="step-card">
                    <div class="step-image" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                        <i class="fas fa-video"></i>
                    </div>
                    <h3>Video Courses</h3>
                    <p>Belajar melalui video pembelajaran berkualitas HD dengan penjelasan yang mudah dipahami.</p>
                </div>
                <div class="step-card">
                    <div class="step-image" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <h3>Best Teachers</h3>
                    <p>Dibimbing oleh instruktur berpengalaman dan ahli di bidangnya dengan track record terbukti.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial -->
    <section class="testimonials">
        <div class="container">
            <div class="section-header">
                <div class="section-subtitle">What Students Say</div>
                <h2 class="section-title">Student Testimonials</h2>
            </div>
            <div class="testimonial-card">
                <div class="testimonial-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <p class="testimonial-text">"Platform pembelajaran yang luar biasa! Materi mudah dipahami dan
                    instrukturnya sangat responsif. Saya berhasil meningkatkan skill programming saya dalam waktu
                    singkat dan mendapat pekerjaan impian."</p>
                <div class="testimonial-author">Andi Wijaya</div>
                <div style="color: #00bcd4;">Full Stack Developer</div>
            </div>
            <div class="carousel-dots" style="margin-top: 30px;">
                <div class="dot active"></div>
                <div class="dot"></div>
                <div class="dot"></div>
            </div>
        </div>
    </section>

    <!-- Pricing -->
    <section class="pricing" id="membership">
        <div class="container">
            <div class="section-header">
                <div class="section-subtitle">Find The Right Plan</div>
                <h2 class="section-title">Pricing Plans</h2>
                <p class="section-description">Pilih paket yang sesuai dengan kebutuhan belajar Anda. Semua paket
                    include akses selamanya ke materi yang dibeli.</p>
            </div>
            <div class="pricing-grid">
                <div class="pricing-card">
                    <div class="pricing-type">For Individuals</div>
                    <h3>Basic Plan</h3>
                    <div class="pricing-amount">$20</div>
                    <ul class="pricing-features">
                        <li>1 User Account</li>
                        <li>5 Courses / Month</li>
                        <li>Limited Access</li>
                        <li>Standard Support</li>
                        <li>Email Updates</li>
                    </ul>
                    <button class="btn-pricing outline">Choose Plan</button>
                </div>
                <div class="pricing-card featured">
                    <div class="pricing-badge">Best Value</div>
                    <div class="pricing-type">For Professionals</div>
                    <h3>Professional</h3>
                    <div class="pricing-amount">$50</div>
                    <ul class="pricing-features">
                        <li>3 User Accounts</li>
                        <li>Unlimited Courses</li>
                        <li>Certificate Included</li>
                        <li>Priority Support</li>
                        <li>Lifetime Access</li>
                    </ul>
                    <button class="btn-pricing solid">Choose Plan</button>
                </div>
                <div class="pricing-card">
                    <div class="pricing-type">For Enterprises</div>
                    <h3>Business</h3>
                    <div class="pricing-amount">$100</div>
                    <ul class="pricing-features">
                        <li>Unlimited Users</li>
                        <li>All Courses Access</li>
                        <li>Custom Content</li>
                        <li>Dedicated Support</li>
                        <li>Analytics Dashboard</li>
                    </ul>
                    <button class="btn-pricing outline">Choose Plan</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h3>About</h3>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Courses</a></li>
                    <li><a href="#">Events</a></li>
                    <li><a href="#">Career</a></li>
                    <li><a href="#">Become a Teacher</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Popular Courses</h3>
                <ul>
                    <li><a href="#">Web Development</a></li>
                    <li><a href="#">Data Science</a></li>
                    <li><a href="#">UI/UX Design</a></li>
                    <li><a href="#">Mobile Development</a></li>
                    <li><a href="#">Digital Marketing</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Support</h3>
                <ul>
                    <li><a href="#">Documentation</a></li>
                    <li><a href="#">Forums</a></li>
                    <li><a href="#">Language Packs</a></li>
                    <li><a href="#">Release Status</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Flexible Learning</h3>
                <div class="footer-map">
                    <i class="fas fa-globe"></i>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 EduSmarts. All Rights Reserved. Made with <i class="fas fa-heart"
                    style="color: #e74c3c;"></i> by Your Team</p>
        </div>
    </footer>
    @push('scripts')
        @vite('resources/js/welcome.js')
    @endpush
</body>

</html>