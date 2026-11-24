@push('css')
<style>
.client-section{
    /* background:#f8f9ff; */
    padding:60px 0;
}

/* slider container */
.logo-slider{
    overflow:hidden;
    position:relative;
    margin-top:50px;
    width:100%;
}

/* moving track */
.logo-track{
    display:flex;
    align-items:center;
    width:max-content;
    animation:scroll 35s linear infinite;
    will-change:transform;
}

.logo-slider:hover .logo-track{
    animation-play-state:paused;
}

/* card design same size */
.logo-card{
    background:#fff;
    border-radius:14px;
    padding:20px;
    margin:0 18px;
    display:flex;
    align-items:center;
    justify-content:center;
    height:140px;
    width:220px;
    box-shadow:0 6px 18px rgba(0,0,0,0.08);
    transition:.4s;
    border:1px solid #eee;
    flex-shrink:0;
}

/* image same width height */
.logo-card img{
    width:160px;
    height:80px;
    object-fit:contain;
    filter:grayscale(100%);
    transition:.4s;
}

/* hover effect */
.logo-card:hover{
    transform:translateY(-8px);
    border:1px solid #242a62;
    box-shadow:0 12px 25px rgba(36,42,98,0.25);
}
.logo-card:hover img{
    filter:grayscale(0%);
    transform:scale(1.05);
}

/* animation */
@keyframes scroll{
    0%{transform:translateX(0);}
    100%{transform:translateX(-50%);}
}

/* mobile */
@media(max-width:768px){
    .logo-card{
        width:160px;
        height:100px;
    }
    .logo-card img{
        width:120px;
        height:60px;
    }
}
</style>
    <style>
        @media only screen and (min-width: 768px) {
            .banner-hero .block-banner .form-find {
                display: flex !important;
            }
        }

        @media (max-width: 1199.98px) {
            .banner-hero .hero-1,
            .banner-hero.hero-1,
            .banner-hero .banner-inner {
                overflow: visible !important;
            }

            .banner-hero .block-banner .banner-description {
                display: block !important;
                visibility: visible !important;
                position: relative !important;
                z-index: 2;
            }

            .banner-hero .img-job-1,
            .img-job-1 {
                display: block !important;
                visibility: visible !important;
                opacity: 1 !important;
                position: relative !important;
                max-width: 220px;
                width: 100%;
                height: auto;
                margin: 16px auto 0;
                object-fit: contain;
            }
        }

        @media (max-width: 767.98px) {
            .banner-hero .img-job-1,
            .img-job-1 {
                max-width: 180px;
            }

            .banner-hero .block-banner .banner-description {
                font-size: 14px;
                line-height: 1.6;
            }
        }

        @media (max-width: 575.98px) {
            .banner-hero .img-job-1,
            .img-job-1 {
                max-width: 150px;
            }
        }

        .job-type-select {
            border: 1px solid #e0e0e0;
            border-radius: 13px;
            box-shadow: 12px 12px 5px #eee;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .job-type-select:hover {
            transform: scale(1.02);
            box-shadow: 0 0 10px rgba(36, 42, 98, 0.15);
        }

        .select-job {
            border: 2px solid #242a62;
        }

        #NonSkilledCategoryScreen {
            display: none;
        }
         .item-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px;
            background: #fff;
            border: 1px solid #e6e6e6;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .item-logo:hover {
            border-color: #00a8ff;
            box-shadow: 0 6px 15px rgba(0, 168, 255, 0.2);
            transform: translateY(-4px);
        }

        .image-left img {
            display: block;
            max-width: 40px;
            height: auto;
        }

        .text-info-right h4 {
            font-size: 16px;
            font-weight: 600;
            margin: 0;
            color: #333;
        }

        .text-info-right p {
            font-size: 13px;
            margin: 2px 0 0;
            color: #666;
        }

        .hover-up {
            transition: transform 0.3s ease;
        }

        .hover-up:hover {
            transform: translateY(-6px);
        }

        #loadMoreBtn {
            background-color: #00a8ff;
            border: none;
            border-radius: 6px;
            transition: background 0.3s ease;
        }

        #loadMoreBtn:hover {
            background-color: #0086cc;
        }
    </style>
<style>
/* Job Cards Styling - Simple & Attractive */
.job-card-simple-attractive {
    background: #FFFFFF !important;
    border-radius: 16px !important;
    padding: 25px !important;
    margin-bottom: 24px !important;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08) !important;
    border: 1px solid #242a65 !important;
    transition: all 0.3s ease !important;
    cursor: pointer !important;
    height: 390px !important;
    display: flex !important;
    flex-direction: column !important;
    position: relative !important;
    overflow: hidden !important;
}

.job-card-simple-attractive:hover {
    transform: translateY(-5px) !important;
    box-shadow: 0 12px 35px rgba(36, 42, 101, 0.15) !important;
    border-color: #242a65 !important;
}

/* Job Title */
.job-title-simple-attractive {
    font-size: 18px !important;
    font-weight: 700 !important;
    color: #242a65 !important;
    margin-bottom: 15px !important;
    line-height: 1.4 !important;
    display: -webkit-box !important;
    -webkit-line-clamp: 2 !important;
    -webkit-box-orient: vertical !important;
    overflow: hidden !important;
    min-height: 50px !important;
}

.job-title-simple-attractive a {
    color: inherit !important;
    text-decoration: none !important;
    transition: color 0.3s ease !important;
}

.job-title-simple-attractive a:hover {
    color: #f36825 !important;
}

/* Work Type & Time */
.job-meta-simple-attractive {
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
    margin-bottom: 15px !important;
    flex-wrap: wrap !important;
    gap: 8px !important;
}

.work-type-simple-attractive {
    background: #f36825 !important;
    color: white !important;
    padding: 6px 12px !important;
    border-radius: 20px !important;
    font-size: 12px !important;
    font-weight: 600 !important;
}

.job-time-simple-attractive {
    font-size: 12px !important;
    color: #666 !important;
    font-weight: 500 !important;
}

/* Location */
.job-location-simple-attractive {
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
    font-size: 14px !important;
    color: #666 !important;
    margin-bottom: 20px !important;
    padding: 12px !important;
    background: #f8faff !important;
    border-radius: 12px !important;
}

.job-location-simple-attractive i {
    color: #242a65 !important;
    flex-shrink: 0 !important;
}

.job-location-simple-attractive span {
    display: block !important;
    white-space: nowrap !important;
    overflow: hidden !important;
    text-overflow: ellipsis !important;
    line-height: 1.4 !important;
    max-width: 100% !important;
    word-break: normal !important;
}

/* Job Details Grid */
.job-details-simple-attractive {
    display: grid !important;
    grid-template-columns: 1fr 1fr !important;
    gap: 12px !important;
    margin-bottom: 20px !important;
    flex: 1 !important;
}

.job-detail-simple-item {
    display: flex !important;
    align-items: center !important;
    gap: 8px !important;
    font-size: 13px !important;
    color: #555 !important;
}

.job-detail-simple-item i {
    color: #242a65 !important;
    width: 16px !important;
    flex-shrink: 0 !important;
}

/* Footer */
.job-footer-simple-attractive {
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
    margin-top: auto !important;
    padding-top: 15px !important;
    border-top: 1px solid #f0f0f0 !important;
    flex-shrink: 0 !important;
}

.view-job-btn-simple-attractive {
    background: #242a65 !important;
    color: white !important;
    text-decoration: none !important;
    padding: 8px 20px !important;
    border-radius: 8px !important;
    font-size: 14px !important;
    font-weight: 600 !important;
    transition: all 0.3s ease !important;
    display: inline-block !important;
}

.view-job-btn-simple-attractive:hover {
    background: #f36825 !important;
    color: white !important;
    transform: translateY(-1px) !important;
}

.job-salary-simple-attractive {
    font-size: 14px !important;
    font-weight: 700 !important;
    color: #242a65 !important;
}

/* Animation */
@keyframes fadeInUp {
    from {
        opacity: 0 !important;
        transform: translateY(20px) !important;
    }
    to {
        opacity: 1 !important;
        transform: translateY(0) !important;
    }
}

.job-card-simple-attractive {
    animation: fadeInUp 0.5s ease !important;
}

/* Responsive Design */
@media (max-width: 768px) {
    .job-card-simple-attractive {
        padding: 20px !important;
        margin-bottom: 10px !important;
        height: 490px !important;
    }
    
    .job-details-simple-attractive {
        grid-template-columns: 1fr !important;
        gap: 8px !important;
    }
    
    .job-footer-simple-attractive {
        flex-direction: column !important;
        gap: 10px !important;
        align-items: stretch !important;
    }
    
    .view-job-btn-simple-attractive {
        text-align: center !important;
    }
    
    .job-title-simple-attractive {
        font-size: 16px !important;
        min-height: 44px !important;
    }
}

/* Home promo banners (employer / candidate) */
.home-promo-wrap {
    padding: 10px 0 20px;
}
.home-promo-pagination {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-bottom: 18px;
    min-height: 12px;
}
.home-promo-pagination .swiper-pagination-bullet {
    width: 8px;
    height: 8px;
    background: #d8d8d8;
    opacity: 1;
    margin: 0 4px !important;
    border-radius: 50%;
}
.home-promo-pagination .swiper-pagination-bullet-active {
    background: #f26824;
}
.home-promo-card {
    display: grid;
    grid-template-columns: 1.08fr 1fr;
    border-radius: 28px;
    overflow: hidden;
    min-height: 340px;
    background: linear-gradient(90deg, #3d4aa3 0%, #2a3480 42%, #1f2770 100%);
    box-shadow: 0 12px 32px rgba(36, 42, 98, 0.18);
}
.home-promo-card.home-promo-join {
    grid-template-columns: 1fr 1.08fr;
    background: linear-gradient(270deg, #3d4aa3 0%, #2a3480 42%, #1f2770 100%);
}
.home-promo-photo {
    position: relative;
    min-height: 280px;
    overflow: hidden;
}
.home-promo-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    position: absolute;
    inset: 0;
}
.home-promo-hire .home-promo-photo::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg, rgba(36, 42, 98, 0.08) 0%, rgba(36, 42, 98, 0.55) 70%, rgba(31, 39, 112, 0.95) 100%);
}
.home-promo-join .home-promo-photo::after {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(270deg, rgba(36, 42, 98, 0.08) 0%, rgba(36, 42, 98, 0.55) 70%, rgba(31, 39, 112, 0.95) 100%);
}
.home-promo-copy {
    color: #fff;
    padding: 42px 42px 36px 28px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
    z-index: 1;
}
.home-promo-join .home-promo-copy {
    padding: 42px 28px 36px 42px;
}
.home-promo-copy h3 {
    color: #fff;
    font-size: 28px;
    font-weight: 700;
    line-height: 1.25;
    margin: 0 0 10px;
}
.home-promo-copy .home-promo-lead {
    color: rgba(255, 255, 255, 0.92);
    font-size: 14px;
    line-height: 1.55;
    margin-bottom: 16px;
}
.home-promo-copy h4 {
    color: #fff;
    font-size: 18px;
    font-weight: 700;
    margin: 0 0 10px;
}
.home-promo-copy ul {
    list-style: disc;
    padding-left: 18px;
    margin: 0 0 22px;
}
.home-promo-copy ul li {
    color: rgba(255, 255, 255, 0.95);
    font-size: 13.5px;
    line-height: 1.7;
}
.home-promo-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #f26824;
    color: #fff !important;
    font-size: 14px;
    font-weight: 600;
    padding: 10px 22px;
    border-radius: 8px;
    width: fit-content;
    text-decoration: none;
    transition: 0.25s ease;
}
.home-promo-btn:hover {
    background: #d45516;
    color: #fff !important;
    transform: translateY(-1px);
}
.home-promo-pagination .swiper-pagination-bullet-active {
    background: #f26824;
}

/* Awareness */
.home-awareness {
    background: linear-gradient(180deg, #f7f8ff 0%, #ffffff 100%);
    padding: 70px 0;
}
.home-awareness-badge {
    display: inline-block;
    background: rgba(242, 104, 36, 0.12);
    color: #f26824;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 0.6px;
    text-transform: uppercase;
    padding: 6px 14px;
    border-radius: 30px;
    margin-bottom: 12px;
}
.home-awareness-card {
    background: #fff;
    border: 1px solid #ececf5;
    border-radius: 18px;
    padding: 28px 24px;
    height: 100%;
    box-shadow: 0 8px 24px rgba(36, 42, 98, 0.06);
    transition: 0.3s ease;
}
.home-awareness-card:hover {
    transform: translateY(-6px);
    border-color: #242a62;
    box-shadow: 0 14px 30px rgba(36, 42, 98, 0.14);
}
.home-awareness-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    margin-bottom: 16px;
    color: #fff;
}
.home-awareness-icon.navy { background: #242a62; }
.home-awareness-icon.orange { background: #f26824; }
.home-awareness-card h5 {
    color: #242a62;
    font-weight: 700;
    font-size: 18px;
    margin-bottom: 10px;
}
.home-awareness-card p {
    color: #667085;
    font-size: 14px;
    line-height: 1.65;
    margin: 0;
}

/* Shared homepage section helpers */
.home-section-head {
    text-align: center;
    margin-bottom: 36px;
}
.home-kicker {
    display: inline-block;
    background: rgba(242, 104, 36, 0.12);
    color: #f26824;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 0.7px;
    text-transform: uppercase;
    padding: 5px 14px;
    border-radius: 30px;
    margin-bottom: 10px;
}
.home-view-all {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #f26824;
    font-weight: 700;
    font-size: 15px;
    text-decoration: none;
}
.home-view-all:hover { color: #242a62; }

/* Pathways */
.home-pathway {
    padding: 10px 0 10px;
}
.home-path-card {
    background: #fff;
    border: 1px solid #ececf5;
    border-radius: 20px;
    padding: 28px 24px;
    height: 100%;
    box-shadow: 0 8px 22px rgba(36, 42, 98, 0.06);
    transition: 0.3s ease;
    text-decoration: none !important;
    display: block;
}
.home-path-card:hover {
    transform: translateY(-6px);
    border-color: #242a62;
    box-shadow: 0 14px 30px rgba(36, 42, 98, 0.14);
}
.home-path-icon {
    width: 58px;
    height: 58px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: #fff;
    margin-bottom: 16px;
}
.home-path-icon.navy { background: #242a62; }
.home-path-icon.orange { background: #f26824; }
.home-path-card h4 {
    color: #242a62;
    font-weight: 700;
    font-size: 20px;
    margin-bottom: 8px;
}
.home-path-card p {
    color: #667085;
    font-size: 14px;
    line-height: 1.65;
    margin: 0 0 12px;
}
.home-path-card span.link {
    color: #f26824;
    font-weight: 700;
    font-size: 14px;
}

/* How it works */
.home-steps {
    background: #242a62;
    padding: 70px 0;
    border-radius: 0;
}
.home-steps h2,
.home-steps p.lead {
    color: #fff;
}
.home-steps p.lead {
    opacity: 0.85;
    max-width: 640px;
    margin: 0 auto;
}
.home-step-card {
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 18px;
    padding: 28px 22px;
    height: 100%;
    color: #fff;
}
.home-step-num {
    width: 46px;
    height: 46px;
    border-radius: 50%;
    background: #f26824;
    color: #fff;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 16px;
    font-size: 16px;
}
.home-step-card h5 {
    color: #fff;
    font-weight: 700;
    font-size: 18px;
    margin-bottom: 8px;
}
.home-step-card p {
    color: rgba(255,255,255,0.8);
    font-size: 14px;
    line-height: 1.65;
    margin: 0;
}

/* Internship cards */
.home-intern-card {
    background: #fff;
    border: 1.5px solid #e8eaf2;
    border-radius: 18px;
    padding: 22px;
    height: 100%;
    cursor: pointer;
    transition: 0.25s ease;
    display: flex;
    flex-direction: column;
    box-shadow: 0 4px 16px rgba(0,0,0,0.05);
}
.featured-internships-row > [class*="col-"] {
    display: flex;
}
.featured-internships-row .home-intern-card {
    width: 100%;
    min-height: 238px;
}
.home-intern-card:hover {
    border-color: #242a62;
    transform: translateY(-4px);
    box-shadow: 0 12px 28px rgba(36, 42, 98, 0.12);
}
.home-intern-top {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 12px;
}
.home-intern-top h5 {
    color: #242a62;
    font-size: 16px;
    font-weight: 800;
    margin: 0 0 4px;
    line-height: 1.35;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.home-intern-top p {
    color: #6b7280;
    font-size: 13px;
    margin: 0;
}
.home-intern-logo {
    width: 52px;
    height: 52px;
    border-radius: 12px;
    background: #eef0fb;
    color: #242a62;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    flex-shrink: 0;
}
.home-intern-logo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.home-intern-meta {
    font-size: 13px;
    color: #4b5563;
    margin-bottom: 12px;
    display: flex;
    flex-wrap: wrap;
    gap: 6px 12px;
}
.home-intern-meta span {
    margin-right: 0;
    white-space: normal;
    overflow-wrap: anywhere;
}
.home-intern-meta i { color: #9ca3af; margin-right: 4px; }
.home-intern-tags { margin-bottom: 16px; }
.home-intern-tag {
    display: inline-block;
    background: #eef0fb;
    color: #242a62;
    font-size: 12px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
    margin: 0 6px 6px 0;
}
.home-intern-tag.green {
    background: #f0fdf4;
    color: #16a34a;
}
.home-intern-view {
    margin-top: auto;
    color: #f26824;
    font-weight: 700;
    font-size: 14px;
}
@media (max-width: 767.98px) {
    .featured-internships-row > [class*="col-"] {
        display: block;
    }

    .featured-internships-row .home-intern-card {
        min-height: 0;
    }
}

/* Skillothon */
.home-skillothon {
    background: linear-gradient(120deg, #242a62 0%, #3a428a 100%);
    border-radius: 24px;
    overflow: hidden;
    color: #fff;
}
.home-skillothon-inner {
    display: grid;
    grid-template-columns: 1.1fr 1fr;
    min-height: 300px;
}
.home-skillothon-copy {
    padding: 48px 40px;
}
.home-skillothon-copy h2 {
    color: #fff;
    font-size: 30px;
    font-weight: 800;
    margin-bottom: 12px;
}
.home-skillothon-copy p {
    color: rgba(255,255,255,0.88);
    font-size: 15px;
    line-height: 1.7;
    margin-bottom: 22px;
}
.home-skillothon-photo {
    min-height: 260px;
    position: relative;
}
.home-skillothon-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    position: absolute;
    inset: 0;
}

/* Dual audience */
.home-audience-card {
    border-radius: 22px;
    padding: 36px 32px;
    height: 100%;
    color: #fff;
}
.home-audience-card.navy { background: #242a62; }
.home-audience-card.orange { background: #f26824; }
.home-audience-card h3 {
    color: #fff;
    font-size: 26px;
    font-weight: 800;
    margin-bottom: 10px;
}
.home-audience-card p {
    color: rgba(255,255,255,0.9);
    font-size: 15px;
    line-height: 1.65;
    margin-bottom: 18px;
}
.home-audience-card ul {
    padding-left: 18px;
    margin-bottom: 22px;
}
.home-audience-card ul li {
    color: rgba(255,255,255,0.92);
    font-size: 14px;
    line-height: 1.7;
}
.home-audience-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #fff;
    color: #242a62 !important;
    font-weight: 700;
    padding: 10px 20px;
    border-radius: 8px;
    text-decoration: none;
}
.home-audience-card.orange .home-audience-btn { color: #f26824 !important; }
.home-audience-btn:hover { transform: translateY(-1px); }

/* Blog cards */
.home-blog-card {
    background: #fff;
    border-radius: 22px;
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
    box-shadow: 0 8px 22px rgba(36, 42, 98, 0.06);
    transition: 0.3s ease;
    border: 1px solid #ececf5;
}
.home-blog-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 14px 30px rgba(36, 42, 98, 0.14);
}
.home-blog-card img.cover {
    width: 100%;
    height: 200px;
    object-fit: cover;
}
.home-blog-body { padding: 18px 18px 22px; display: flex; flex-direction: column; flex-grow: 1; }
.home-blog-tag {
    display: inline-block;
    background: rgba(243,104,37,0.12);
    color: #f36825;
    font-size: 13px;
    font-weight: 600;
    padding: 5px 14px;
    border-radius: 20px;
    margin-bottom: 10px;
    width: fit-content;
}
.home-blog-body h5 {
    color: #252a62;
    font-size: 18px;
    font-weight: 700;
    line-height: 1.4;
    margin-bottom: 8px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.home-blog-body p {
    font-size: 14px;
    color: #6b7280;
    line-height: 1.6;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: 16px;
}
.home-blog-foot {
    margin-top: auto;
    display: flex;
    align-items: center;
    gap: 10px;
}
.home-blog-foot img {
    width: 42px;
    height: 42px;
    border-radius: 50%;
}
.home-blog-foot strong { color: #252a62; font-size: 14px; display: block; }
.home-blog-foot small { color: #9ca3af; font-size: 12px; }

/* Testimonial polish — equal card height in the slider */
.home-testimonial .swiper-wrapper {
    align-items: stretch;
}
.home-testimonial .swiper-slide {
    height: auto !important;
    display: flex;
    align-self: stretch;
}
.home-testimonial .card-grid-6 {
    background: #fff;
    border: 1px solid #ececf5;
    border-radius: 18px;
    padding: 22px 20px 18px;
    height: auto;
    width: 100%;
    display: flex;
    flex-direction: column;
    box-shadow: 0 8px 22px rgba(36, 42, 98, 0.05);
}
.home-testimonial .card-text-desc {
    flex: 1 1 auto;
    min-height: 160px;
    margin-bottom: 18px !important;
}
.home-testimonial .card-image {
    margin-top: 0;
    align-items: center;
}
.home-testimonial .card-grid-6 .card-image .image {
    width: 64px;
    min-width: 64px;
    height: 64px;
    overflow: hidden;
    flex: 0 0 64px;
}
.home-testimonial .card-grid-6 .card-image .image img {
    width: 64px !important;
    height: 64px !important;
    object-fit: contain;
    display: block;
}

@media (max-width: 991.98px) {
    .home-promo-card,
    .home-promo-card.home-promo-join {
        grid-template-columns: 1fr;
        min-height: auto;
    }
    .home-promo-photo {
        min-height: 220px;
        order: -1;
    }
    .home-promo-copy,
    .home-promo-join .home-promo-copy {
        padding: 28px 24px 32px;
    }
    .home-promo-copy h3 {
        font-size: 22px;
    }
    .home-promo-hire .home-promo-photo::after,
    .home-promo-join .home-promo-photo::after {
        background: linear-gradient(180deg, rgba(36, 42, 98, 0.05) 0%, rgba(31, 39, 112, 0.55) 100%);
    }
    .home-skillothon-inner {
        grid-template-columns: 1fr;
    }
    .home-skillothon-photo {
        min-height: 220px;
        order: -1;
    }
    .home-skillothon-copy {
        padding: 32px 24px;
    }
    .home-skillothon-copy h2 { font-size: 24px; }
}
</style>
@endpush


@extends('website.layout.layout')
@section('website-content')
    <script>
        page_active_id = "Home";
    </script>

    <main class="main">
        <div class="bg-homepage1"></div>
        <section class="section-box">
            <div class="banner-hero hero-1">
                <div class="banner-inner">
                    <div class="row g-4 featured-internships-row">
                        <div class="col-xl-8 col-lg-12">
                            <div class="block-banner">
                                <!-- <h1 class="heading-banner wow animate__animated animate__fadeInUp">Find Your Dream Job with
                                    <span class="color-brand-2">Zobpot</span><br class="d-none d-lg-block">
                                </h1> -->
                                <h1 class="heading-banner wow animate__animated animate__fadeInUp">Empowering Youth Education With
                                    <span class="color-brand-2">Zobpot</span><br class="d-none d-lg-block">
                                </h1>
                                <!-- <div class="banner-description mt-20 wow animate__animated animate__fadeInUp"
                                    data-wow-delay=".1s">Explore thousands of career opportunities across the industrial and corporate sectors of India.<br
                                        class="d-none d-lg-block">  Over 2M job seekers trust our website as<br
                                        class="d-none d-lg-block">most genuine and supportive in terms of job searching and placements. whether you’re a fresher or a professional, just grab your perfect career opportunity with us.</div> -->
                                        <div class="banner-description mt-20 wow animate__animated animate__fadeInUp"
                                    data-wow-delay=".1s">We believe every young person deserves the right guidance, platform, <br
                                        class="d-none d-lg-block">and opportunity to build a successful career.<br
                                        class="d-none d-lg-block">From education to internships, skills to employment, we help youth move from learning to earning.
                                        Empower the youth. Build skills. Create opportunities. Shape the future.</div>
                        
                                <div class="col-lg-12 col-sm-12 d-flex justify-content-center mt-20 banner-job-img-wrap">
                                    <img class="img-job-1" alt="jobBox"
                                        src="{{ asset('assets/imgs/page/homepage1/startup.png') }}" width="270">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-12 d-none d-xl-block col-md-6">
                            <div class="banner-imgs">
                                <div class="block-1 shape-1"><img class="img-responsive" style="max-width:60%;" alt="jobBox"
                                        src="{{ asset('assets/imgs/page/homepage1/gemini-2.5-flash-image-preview (nano-banana)_plaese_add_indian_yo.png') }}"></div>
                                <div class="block-2 shape-2"><img class="img-responsive" alt="jobBox"
                                        src="{{ asset('assets/imgs/page/homepage1/banner2.png') }}"></div>
                                <div class="block-3 shape-3"><img class="img-responsive" alt="jobBox"
                                        src="{{ asset('assets/imgs/page/homepage1/icon-top-banner.png') }}"></div>
                                <div class="block-4 shape-3"><img class="img-responsive" alt="jobBox"
                                        src="{{ asset('assets/imgs/page/homepage1/icon-bottom-banner.png') }}"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-box mt-50 mb-20 home-pathway">
            <div class="container">
                <div class="home-section-head">
                    <span class="home-kicker">One platform. Three ways forward.</span>
                    <h2 class="section-title mb-10">Explore opportunities on Zobpot</h2>
                    <p class="font-lg color-text-paragraph-2">From jobs and internships to Skillothon — build skills, gain experience, and get hired.</p>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <a class="home-path-card" href="{{ route('job') }}">
                            <div class="home-path-icon navy"><i class="fa fa-briefcase"></i></div>
                            <h4>Find a Job</h4>
                            <p>Browse skilled and unskilled openings across industries and apply with a profile that stands out.</p>
                            <span class="link">Search jobs <i class="fa fa-arrow-right"></i></span>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <a class="home-path-card" href="{{ route('internship') }}">
                            <div class="home-path-icon orange"><i class="fa fa-graduation-cap"></i></div>
                            <h4>Internships</h4>
                            <p>Learn by doing. Join verified internships, complete tasks, and earn certificates from industry and college.</p>
                            <span class="link">View internships <i class="fa fa-arrow-right"></i></span>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <a class="home-path-card" href="{{ route('skillthon') }}">
                            <div class="home-path-icon navy"><i class="fa fa-lightbulb-o"></i></div>
                            <h4>Skillothon</h4>
                            <p>Pre-register for Skillothon by Zobpot and turn real skills into career-ready opportunities.</p>
                            <span class="link">Register now <i class="fa fa-arrow-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

         <section class="section-box mt-50">
            <div class="section-box wow animate__animated animate__fadeIn">
                <div class="container">
                    <div class="text-center">
                        <h2 class="section-title mb-10 wow animate__animated animate__fadeInUp">Search by category</h2>
                        <p class="font-lg color-text-paragraph-2 wow animate__animated animate__fadeInUp">Find the job
                            that&rsquo;s perfect for you. about 800+ new jobs everyday</p>

                        <!-- Skill Type Selection Boxes -->
                        <div class="row justify-content-center mt-4 wow animate__animated animate__fadeInUp"
                            data-wow-delay="0.2s">



                            <!-- Skilled Box -->
                            <div class="col-lg-3 col-md-4 col-6 mb-3">
                                <div class="job-type-select select-job text-center" id="skill"
                                    onclick="SelectJobType('Skilled')">
                                    <div class="row align-items-center">
                                        <div class="col-lg-3 col-md-3 col-4">
                                            <img src="{{ asset('assets/imgs/skill.png') }}" alt="Skilled"
                                                style="max-width: 100%;">
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-8">
                                            <h5 class="mb-0"><b>Skilled</b></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--UnSkilled Box -->
                            <div class="col-lg-3 col-md-4 col-6 mb-3">
                                <div class="job-type-select  text-center" id="noneskill"
                                    onclick="SelectJobType('Non-Skilled')">
                                    <div class="row align-items-center">
                                        <div class="col-lg-3 col-md-3 col-4">
                                            <img src="{{ asset('assets/imgs/noneskill.png') }}" alt="UnSkilled"
                                                style="max-width: 100%;">
                                        </div>
                                        <div class="col-lg-9 col-md-9 col-8">
                                            <h5 class="mb-0"><b>UnSkilled</b></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  
                    <div id="SkilledCategoryScreen">
                        <div class="row mt-50">
                            @php $skillCount = 0; @endphp
                            @foreach ($CategoryData as $category)
                                @if ($category->preference_type == 1)
                                    @php $skillCount++; @endphp
                                    <div class="col-lg-3 col-md-3 col-12 mb-3 hover-up category-item-skill"
                                        style="display: {{ $skillCount <= 12 ? 'block' : 'none' }};">
                                        <a href="javascript:void(0);"
                                            onclick="FilterJobByCategory({{ $category->category_id }})">
                                            <div class="item-logo">
                                                <div class="image-left">
                                                    <img alt="{{ $category->category_nm }}"
                                                        src="{{ asset('uploads/category_img/' . ($category->image ?? 'default.png')) }}"
                                                        style="max-width: 40px;">
                                                </div>
                                                <div class="text-info-right">
                                                    <h4>{{ $category->category_nm }}</h4>
                                                    {{-- <p class="font-xs">{{ $category->totalJob ?? 0 }} <span>Jobs Available</span></p> --}}
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        @if ($skillCount > 12)
                            <div class="text-center mt-4">
                                <button id="loadMoreBtnSkill" class="btn btn-default font-sm">View More</button>
                            </div>
                        @endif
                    </div>

                    <div id="NonSkilledCategoryScreen">
                        <div class="row mt-50">
                            @php $nonSkillCount = 0; @endphp
                            @foreach ($CategoryData as $category)
                                @if ($category->preference_type == 2)
                                    @php $nonSkillCount++; @endphp
                                    <div class="col-lg-3 col-md-3 col-12 mb-3 hover-up category-item-nonskill"
                                        style="display: {{ $nonSkillCount <= 12 ? 'block' : 'none' }};">
                                        <a href="javascript:void(0);"
                                            onclick="FilterJobByCategory({{ $category->category_id }})">
                                            <div class="item-logo">
                                                <div class="image-left">
                                                    <img alt="{{ $category->category_nm }}"
                                                        src="{{ asset('uploads/category_img/' . ($category->image ?? 'default.png')) }}"
                                                        style="max-width: 40px;">
                                                </div>
                                                <div class="text-info-right">
                                                    <h4>{{ $category->category_nm }}</h4>
                                                    {{-- <p class="font-xs">{{ $category->totalJob ?? 0 }} <span>Jobs
                                                            Available</span>
                                                        </p> --}}
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>

 @if ($nonSkillCount > 12)
                        <div class="text-center mt-4">
                            <button id="loadMoreBtnNonSkill" class="btn btn-default font-sm">View More</button>
                        </div>
                          @endif
                    </div>
                </div>
            </div>
        </section>

        <section class="section-box mt-60 mb-20">
            <div class="container home-promo-wrap">
                <div class="home-section-head">
                    <span class="home-kicker">Hiring &amp; applying, made simpler</span>
                    <h2 class="section-title mb-10">Built for companies and candidates</h2>
                    <p class="font-lg color-text-paragraph-2">Hire the right talent, or turn your skills into the next opportunity.</p>
                </div>
                <div class="home-promo-pagination"></div>
                <div class="swiper swiper-home-promo">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="home-promo-card home-promo-hire">
                                <div class="home-promo-photo">
                                    <img src="{{ asset('assets/imgs/about-us-home.png') }}" alt="Hire talent on Zobpot">
                                </div>
                                <div class="home-promo-copy">
                                    <h3>Hire the Right Talent, Faster and Smarter</h3>
                                    <p class="home-promo-lead">Empower your hiring with intelligent tools, targeted filters, and a pool of pre-qualified candidates ready to contribute.</p>
                                    <h4>Why Choose Us?</h4>
                                    <ul>
                                        <li>Access Qualified Talent instantly from diverse industries and skill levels.</li>
                                        <li>Streamline Your Hiring with an efficient, end-to-end recruitment process.</li>
                                        <li>Boost Your Employer Brand with customizable, standout company profiles.</li>
                                        <li>Recruit Cost-Effectively with solutions tailored to your hiring needs.</li>
                                        <li>Simplify Communication &amp; Scheduling for a smoother candidate experience.</li>
                                    </ul>
                                    <a class="home-promo-btn" href="{{ route('find-candidates') }}">Know More <i class="fa fa-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="home-promo-card home-promo-join">
                                <div class="home-promo-copy">
                                    <h3>Turn Your Skills Into Opportunities</h3>
                                    <p class="home-promo-lead">Discover a platform built to connect you with the right employers, faster and smarter.</p>
                                    <h4>Why Join Us?</h4>
                                    <ul>
                                        <li>Access Diverse Opportunities across leading industries that match your skills and aspirations.</li>
                                        <li>Apply with Ease using our intuitive, mobile-friendly interface.</li>
                                        <li>Showcase Your Profile with a professional, standout summary.</li>
                                        <li>Get Tailored Job Matches designed to fit your career goals.</li>
                                        <li>Connect Directly With Employers for a faster, smoother hiring journey.</li>
                                    </ul>
                                    <a class="home-promo-btn" href="{{ route('job') }}">Know More <i class="fa fa-arrow-right"></i></a>
                                </div>
                                <div class="home-promo-photo">
                                    <img src="{{ asset('assets/imgs/page/homepage1/img1.png') }}" alt="Find jobs on Zobpot">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- @if ($adBanner)
            <div class="section-box mb-30">
                <div class="container">
                    <a href="{{ $adBanner->ad_link }}" target="_blank">
                        <img src="{{ asset('uploads/ad_banner_img/' . $adBanner->img_nm) }}" alt="img">
                    </a>
                </div>
            </div>
        @endif -->

        @if (!$jobData->isEmpty())
            <section class="section-box mt-50">
                <div class="container">
                    <div class="text-center">
                        <span class="home-kicker">Latest openings</span>
                        <h2 class="section-title mb-10 wow animate__animated animate__fadeInUp">Recently Posted Jobs</h2>
                        <p class="font-lg color-text-paragraph-2 wow animate__animated animate__fadeInUp">Search and
                            connect with the right company faster.</p>
                        <a class="home-view-all mt-10 d-inline-flex" href="{{ route('job') }}">View all jobs <i class="fa fa-arrow-right"></i></a>
                    </div>
                    <div class="mt-70">
                        <div class="tab-content" id="myTabContent-1">
                            <div class="tab-pane fade show active" id="tab-job-1" role="tabpanel"
                                aria-labelledby="tab-job-1">
                                <!-- <div class="row">
                                    @foreach ($jobData as $row)
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                            <a href="{{ route('job-detail', ['job_id' => $row->job_id]) }}">
                                                <div class="card-grid-2 hover-up">
                                                    <div class="card-block-info mt-20">
                                                        <a href="{{ route('job-detail', ['job_id' => $row->job_id]) }}" class="card-block-info d-block text-decoration-none">
                                                            <h6>{{ $row->job_title }}</h6>
                                                            <div class="mt-5">
                                                                <span class="card-briefcase">{{ $row->work_type_name }}</span>
                                                                <span class="card-time">{{ \Carbon\Carbon::parse($row->datetime)->diffForHumans() }}</span>
                                                            </div>
                                                            <p class="font-sm color-text-paragraph mt-15 mb-0">
                                                                <i class="fa fa-map-marker"></i>&nbsp;{{ $row->company_address }}
                                                            </p>
                                                        </a>

                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div> -->
                                <div class="row">
                                    @foreach ($jobData as $row)
                                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12">
                                            <div class="job-card-simple-attractive" onclick="window.location.href='{{ route('job-detail', ['job_id' => $row->job_id]) }}'">
                                                <!-- Job Title -->
                                                <h5 class="job-title-simple-attractive">
                                                    <a href="{{ route('job-detail', ['job_id' => $row->job_id]) }}">{{ $row->job_title }}</a>
                                                </h5>

                                                <!-- Work Type & Time -->
                                                <div class="job-meta-simple-attractive">
                                                    <span class="work-type-simple-attractive">{{ $row->work_type_name }}</span>
                                                    <span class="job-time-simple-attractive">{{ \Carbon\Carbon::parse($row->datetime)->diffForHumans() }}</span>
                                                </div>

                                                <!-- Location -->
                                                <div class="job-location-simple-attractive">
                                                    <i class="fa fa-map-marker"></i>
                                                    <span>{{ $row->company_address }}</span>
                                                </div>

                                                <!-- Job Details -->
                                                <div class="job-details-simple-attractive">
                                                    <div class="job-detail-simple-item">
                                                        <i class="fa fa-briefcase"></i>
                                                        <span>{{ $row->job_type_name ?? 'Full Time' }}</span>
                                                    </div>
                                                    <div class="job-detail-simple-item">
                                                        <i class="fa fa-users"></i>
                                                        <span>{{ $row->number_of_openings ?? 1 }} Vacancy</span>
                                                    </div>
                                                    <div class="job-detail-simple-item">
                                                        <i class="fa fa-graduation-cap"></i>
                                                        <span>{{ $row->qualification_nm }}</span>
                                                    </div>
                                                    <div class="job-detail-simple-item">
                                                        <i class="fa fa-venus-mars"></i>
                                                        <span>{{ $row->gender }}</span>
                                                    </div>
                                                </div>

                                                <!-- Footer -->
                                                <div class="job-footer-simple-attractive">
                                                    @if($row->salary_budget)
                                                    <div class="job-salary-simple-attractive d-flex align-items-center">
                                                         <i class="fi-rr-money me-1"></i>{{$row->salary_budget}}
                                                    </div>
                                                    @else
                                                    <div></div>
                                                    @endif
                                                    <a href="{{ route('job-detail', ['job_id' => $row->job_id]) }}" class="view-job-btn-simple-attractive">
                                                        View Job
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        @if (isset($internshipData) && !$internshipData->isEmpty())
        <section class="section-box mt-70 mb-20">
            <div class="container">
                <div class="text-center mb-40">
                    <span class="home-kicker">Learn. Practice. Get certified.</span>
                    <h2 class="section-title mb-10">Featured Internships</h2>
                    <p class="font-lg color-text-paragraph-2">Verified internships with tasks, feedback, and certificates — only on Zobpot.</p>
                    <a class="home-view-all mt-10 d-inline-flex" href="{{ route('internship') }}">View all internships <i class="fa fa-arrow-right"></i></a>
                </div>
                <div class="row">
                    @foreach ($internshipData as $item)
                        @php
                            $companyName = $item->company ? $item->company->name : 'Company';
                            $companyInitials = strtoupper(substr($companyName, 0, 2));
                            $modeLabels = [
                                'Online' => 'Work from Home',
                                'Offline' => 'In Office',
                                'Hybrid' => 'Hybrid',
                            ];
                            $modeLabel = $modeLabels[$item->mode] ?? ($item->mode ?: 'Internship');
                        @endphp
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="home-intern-card" onclick="window.location.href='{{ route('internship.detail', $item->slug ?? $item->id) }}'">
                                <div class="home-intern-top">
                                    <div>
                                        <h5>{{ $item->internship_title }}</h5>
                                        <p>{{ $companyName }}</p>
                                    </div>
                                    <div class="home-intern-logo">
                                        @if($item->company && !empty($item->company->profile_img) && file_exists(public_path('uploads/profile/' . $item->company->profile_img)))
                                            <img src="{{ asset('uploads/profile/' . $item->company->profile_img) }}" alt="{{ $companyName }}">
                                        @else
                                            {{ $companyInitials }}
                                        @endif
                                    </div>
                                </div>
                                <div class="home-intern-meta">
                                    <span><i class="fa fa-briefcase"></i> {{ $modeLabel }}</span>
                                    @if($item->duration)
                                        <span><i class="fa fa-clock-o"></i> {{ $item->duration }}</span>
                                    @endif
                                    @if($item->location)
                                        <span><i class="fa fa-map-marker"></i> {{ $item->location }}</span>
                                    @endif
                                </div>
                                <div class="home-intern-tags">
                                    @if($item->jobCategory)
                                        <span class="home-intern-tag">{{ \Illuminate\Support\Str::limit($item->jobCategory->category_nm, 22) }}</span>
                                    @endif
                                    @if($item->stipend > 0)
                                        <span class="home-intern-tag green">Stipend ₹{{ number_format($item->stipend) }}/Mo</span>
                                    @endif
                                </div>
                                <span class="home-intern-view">View internship <i class="fa fa-arrow-right"></i></span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <section class="section-box mt-50 mb-20">
            <div class="container">
                <div class="home-skillothon">
                    <div class="home-skillothon-inner">
                        <div class="home-skillothon-copy">
                            <span class="home-kicker" style="background:rgba(242,104,36,0.2);color:#fff;">Pre-registration open</span>
                            <h2>Skillothon by Zobpot</h2>
                            <p>“Real power lies in skills, not titles.” Pre-book your seat, compete with peers, and grab the opportunity to turn learning into earning.</p>
                            <a class="home-promo-btn" href="{{ route('skillthon') }}">Register for Skillothon <i class="fa fa-arrow-right"></i></a>
                        </div>
                        <div class="home-skillothon-photo">
                            <img src="{{ asset('assets/imgs/page/homepage1/banner1.png') }}" alt="Skillothon by Zobpot">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-box overflow-visible mt-80 mb-80">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="box-image-job">
                            <img class="img-job-2" alt="jobBox"
                                src="{{ asset('assets/imgs/page/homepage1/controlcard.png') }}">
                            <figure class="wow animate__animated animate__fadeIn"><img alt="jobBox"
                                    src="{{ asset('assets/imgs/about-us-home.png') }}"></figure>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="content-job-inner"><span class="color-text-mutted text-32">About us</span>
                            <h2 class="text-42 wow animate__animated animate__fadeInUp">About <span
                                    class="color-brand-2">Zobpot</span></h2>
                            <div class="mt-40 pr-50 text-md-lh28 wow animate__animated animate__fadeInUp about-desc">
                                @php
                                    echo $About->about_us;
                                @endphp
                            </div>
                            <div class="mt-40">
                                <div class="wow animate__animated animate__fadeInUp">
    
                                   @if(Auth::check() && Auth::user()->profile_type !== 'Company')
                                        <a class="btn btn-default" href="{{ route('job') }}">
                                            Search Jobs
                                        </a>
                                    @endif

                                    <a class="btn btn-link" href="{{ route('about') }}">
                                        Read More
                                    </a>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @if (!$Achievement->isEmpty())
        <section class="section-box overflow-visible mt-50 mb-50 pt-40 pb-40" style="background: #f2682412;">
            <div class="container">
                <div class="row">
                    @foreach ($Achievement as $row)
                        <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                            <div class="text-center">
                                <h1 class="color-brand-2"><span class="count">{{ $row->count }}</span><span>K+</span>
                                </h1>
                                <h5 style="color: #252a62;">{{ $row->title }}</h5>
                                <p style="color: #252a62;" class="font-sm color-text-paragraph mt-10">
                                    {{ $row->description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <section class="home-awareness">
            <div class="container">
                <div class="text-center mb-40">
                    <span class="home-awareness-badge">Stay Alert. Stay Informed.</span>
                    <h2 class="section-title mb-10 wow animate__animated animate__fadeInUp">Youth Career Awareness</h2>
                    <p class="font-lg color-text-paragraph-2 wow animate__animated animate__fadeInUp">
                        Empower the youth. Build skills. Create opportunities. Shape the future — with safe, verified hiring on Zobpot.
                    </p>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                        <div class="home-awareness-card">
                            <div class="home-awareness-icon navy"><i class="fa fa-shield"></i></div>
                            <h5>Never Pay for a Job</h5>
                            <p>Genuine employers never ask for money, OTP, or bank details to hire you. Report such requests immediately.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                        <div class="home-awareness-card">
                            <div class="home-awareness-icon orange"><i class="fa fa-check-circle"></i></div>
                            <h5>Verify Before You Apply</h5>
                            <p>Check the company profile, job details, and reviews on Zobpot before sharing personal documents or attending interviews.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                        <div class="home-awareness-card">
                            <div class="home-awareness-icon navy"><i class="fa fa-graduation-cap"></i></div>
                            <h5>Skills Open Doors</h5>
                            <p>Use internships, Skillothon, and learning opportunities to build experience before you apply for full-time roles.</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 mb-4">
                        <div class="home-awareness-card">
                            <div class="home-awareness-icon orange"><i class="fa fa-bullhorn"></i></div>
                            <h5>Apply Only on Zobpot</h5>
                            <p>Stay on the official platform for jobs and internships so your application, communication, and progress stay tracked and safe.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @if (isset($Testimonial) && !$Testimonial->isEmpty())
            <section class="section-box mt-50 mb-40 home-testimonial">
                <div class="container">
                    <div class="home-section-head">
                        <span class="home-kicker">Testimonials</span>
                        <h2 class="section-title mb-10 wow animate__animated animate__fadeInUp">What people say about Zobpot</h2>
                        <p class="font-lg color-text-paragraph-2 wow animate__animated animate__fadeInUp">Real stories from candidates and companies who found the right match on Zobpot.</p>
                    </div>
                    <div class="row mt-20">
                        <div class="box-swiper">
                            <div class="swiper-container swiper-group-3 swiper">
                                <div class="swiper-wrapper pb-70 pt-5">
                                    @foreach ($Testimonial as $row)
                                        <div class="swiper-slide">
                                            <div class="card-grid-6 hover-up">
                                                <div class="card-text-desc mt-10">
                                                    <p class="font-md color-text-paragraph">{{ $row->description }}</p>
                                                </div>
                                                <div class="card-image">
                                                    <div class="image">
                                                        <figure><img alt="{{ $row->username }}"
                                                                src="{{ asset('uploads/testimonial_img/' . $row->profile_img) }}">
                                                        </figure>
                                                    </div>
                                                    <div class="card-profile">
                                                        <h6>{{ $row->username }}</h6><span>{{ $row->designation }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-pagination swiper-pagination3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        @if (!$Blog->isEmpty())
            <section class="section-box mt-50 mb-40">
                <div class="container">
                    <div class="home-section-head">
                        <span class="home-kicker">Blog &amp; Tips</span>
                        <h2 class="section-title mb-10">Career news and guidance</h2>
                        <p class="font-lg color-text-paragraph-2">Stay updated with hiring tips, internship advice, and youth career stories.</p>
                        <a class="home-view-all" href="{{ route('blog') }}">View all blogs <i class="fa fa-arrow-right"></i></a>
                    </div>
                    <div class="row">
                        @foreach ($Blog as $row)
                            <div class="col-lg-4 col-md-6 mb-4 d-flex">
                                <a href="{{ route('blog-detail', $row->id) }}" class="home-blog-card w-100" style="text-decoration:none;">
                                    <img class="cover" src="{{ asset('uploads/blog_img/' . $row->image) }}" alt="{{ $row->title }}">
                                    <div class="home-blog-body">
                                        <span class="home-blog-tag">Blog</span>
                                        <h5>{{ $row->title }}</h5>
                                        <p>{{ \Illuminate\Support\Str::limit(strip_tags($row->desc), 90) }}</p>
                                        <div class="home-blog-foot">
                                            <img src="{{ asset('assets/imgs/profile.png') }}" alt="Zobpot">
                                            <div>
                                                <strong>Zobpot</strong>
                                                <small>{{ \Carbon\Carbon::parse($row->datetime)->format('d F Y') }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <section class="home-steps mt-40 mb-0">
            <div class="container">
                <div class="text-center mb-40">
                    <span class="home-kicker" style="background:rgba(242,104,36,0.2);color:#fff;">Simple process</span>
                    <h2 class="mb-10">How Zobpot works</h2>
                    <p class="lead">Three steps to move from learning to earning — whether you are a student, a job seeker, or a company.</p>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-4 mb-4">
                        <div class="home-step-card">
                            <div class="home-step-num">01</div>
                            <h5>Create your profile</h5>
                            <p>Register as a candidate or company, add skills, education, and a standout profile that recruiters can trust.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 mb-4">
                        <div class="home-step-card">
                            <div class="home-step-num">02</div>
                            <h5>Apply or hire</h5>
                            <p>Candidates apply to jobs and internships. Companies post openings and shortlist verified talent faster.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 mb-4">
                        <div class="home-step-card">
                            <div class="home-step-num">03</div>
                            <h5>Grow with Zobpot</h5>
                            <p>Complete internships, earn certificates, join Skillothon, and build a career path that is tracked on one platform.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-box mt-50 mb-20">
            <div class="container">
                <div class="home-section-head">
                    <span class="home-kicker">Get started</span>
                    <h2 class="section-title mb-10">Who is Zobpot for?</h2>
                    <p class="font-lg color-text-paragraph-2">One platform designed for youth careers and for companies that want the right hire.</p>
                </div>
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="home-audience-card navy">
                            <h3>For Candidates</h3>
                            <p>Find jobs, internships, and skill programs that match where you are today — and where you want to go.</p>
                            <ul>
                                <li>Apply to verified jobs and internships</li>
                                <li>Build a professional profile and resume</li>
                                <li>Join Skillothon and get certified</li>
                            </ul>
                            <a class="home-audience-btn" href="{{ route('emp-type', ['login_type' => 'register']) }}">Create candidate account <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                        <div class="home-audience-card orange">
                            <h3>For Companies</h3>
                            <p>Hire faster with targeted filters, pre-qualified candidates, and an end-to-end recruitment flow.</p>
                            <ul>
                                <li>Post jobs and internships in minutes</li>
                                <li>Access skilled and unskilled talent</li>
                                <li>Manage applications, tasks, and certificates</li>
                            </ul>
                            <a class="home-audience-btn" href="{{ route('company-register') }}">Register your company <i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        
         {{-- <section class="section-box mt-50 mb-50">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-title mb-10 wow animate__animated animate__fadeInUp">Our Valuable Clients</h2>
                    <p class="font-lg color-text-paragraph-2 wow animate__animated animate__fadeInUp">Discover opportunities that fit you — only on Zobpot.</p>
                </div>
            </div>
            <div class="container">
                <div class="box-swiper mt-50">
                    <div class="swiper-container swiper-group-1 swiper-style-2 swiper">
                        <div class="swiper-wrapper pt-5">
                            <div class="swiper-slide">
                                <div class="item-5 hover-up wow animate__animated animate__fadeIn">
                                
                                        <img src="{{ asset('assets/imgs/patner/partner1.png') }}" alt="patner-1" style="height: 115px;width: 100%;">
                                    
                                </div>
                                <div class="item-5 hover-up wow animate__animated animate__fadeIn">
                                
                                        <img src="{{ asset('assets/imgs/patner/patner-5.jpg') }}" alt="patner-2" style="height: 115px;width: 100%;">
                                
                                </div>
                                <div class="item-5 hover-up wow animate__animated animate__fadeIn">
                                
                                        <img src="{{ asset('assets/imgs/patner/partner3.png') }}" alt="patner-3" style="height: 115px;width: 100%;">
                                
                                </div>
                                <div class="item-5 hover-up wow animate__animated animate__fadeIn">
                                
                                        <img src="{{ asset('assets/imgs/patner/partner4.png') }}" alt="patner-4" style="height: 115px;width: 100%;">
                                
                                </div>
                                <div class="item-5 hover-up wow animate__animated animate__fadeIn">
                                        <img src="{{ asset('assets/imgs/patner/partner5.png') }}" alt="patner-5" style="height: 115px;width: 100%;">
                                </div>
                                <div class="item-5 hover-up wow animate__animated animate__fadeIn">
                                        <img src="{{ asset('assets/imgs/patner/partner6.png') }}" alt="patner-6" style="height: 115px;width: 100%;">
                                </div>
                                <div class="item-5 hover-up wow animate__animated animate__fadeIn">
                                        <img src="{{ asset('assets/imgs/patner/partner7.png') }}" alt="patner-7" style="height: 115px;width: 100%;">
                                </div>
                                <div class="item-5 hover-up wow animate__animated animate__fadeIn">
                                        <img src="{{ asset('assets/imgs/patner/partner8.png') }}" alt="patner-8" style="height: 115px;width: 100%;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-button-next swiper-button-next-1"></div>
                    <div class="swiper-button-prev swiper-button-prev-1"></div>
                </div>
            </div>
        </section> --}}
        
        <section class="section-box mt-50 mb-50 client-section">
            <div class="container">
                <div class="text-center">
                    <span class="home-kicker">Trusted by industry</span>
                    <h2 class="section-title mb-10">Top companies trust us</h2>
                    <p class="font-lg color-text-paragraph-2">
                        Discover opportunities that fit you — only on Zobpot.
                    </p>
                </div>
            </div>

            <!-- LOGO SLIDER -->
            <div class="logo-slider">
                <div class="logo-track">
                    @if (count($partner) > 0)
                        @foreach ($partner as $row)
                            <div class="logo-card">
                                <img src="{{ asset('uploads/partner_img/' . ($row->image ?? 'default.png')) }}" alt="{{ $row->name }}">
                            </div>
                        @endforeach

                        @foreach ($partner as $row)
                            <div class="logo-card" aria-hidden="true">
                                <img src="{{ asset('uploads/partner_img/' . ($row->image ?? 'default.png')) }}" alt="{{ $row->name }}">
                            </div>
                        @endforeach
                    @else
                        <div class="col-12 text-center py-5">
                            <img src="{{ asset('assets/imgs/Empty.png') }}" alt="No Partners" style="max-width: 200px; opacity: 0.5;">
                            <h4 class="mt-4 color-text-paragraph-2">No Partners Available</h4>
                            <p class="font-md color-text-paragraph-2">We're currently building our network of valuable clients.</p>
                        </div>
                    @endif


                </div>
            </div>
        </section>



        <div id="pageLoader" style="display:none;">
            <div class="preloader d-flex align-items-center justify-content-center">
                <div class="preloader-inner position-relative">
                    <div class="text-center"><img src="{{ asset('assets/imgs/template/loading.gif') }}" alt="Loader">
                    </div>
                </div>
            </div>
        </div>


        <script src="{{ asset('assets/js/plugins/counterup.js') }}"></script>
    </main>


@endsection


@push('script')
    <script>
        function equalizeHomeTestimonials() {
            var slides = document.querySelectorAll('.home-testimonial .swiper-slide');
            if (!slides.length) return;
            slides.forEach(function (slide) {
                slide.style.alignSelf = 'flex-start';
                var card = slide.querySelector('.card-grid-6');
                if (card) {
                    card.style.minHeight = '0px';
                    card.style.height = 'auto';
                }
            });
            var max = 0;
            slides.forEach(function (slide) {
                var card = slide.querySelector('.card-grid-6');
                if (card && card.offsetHeight > max) max = card.offsetHeight;
            });
            slides.forEach(function (slide) {
                slide.style.alignSelf = '';
                var card = slide.querySelector('.card-grid-6');
                if (card && max) {
                    card.style.height = max + 'px';
                    card.style.minHeight = max + 'px';
                }
            });
        }
        document.addEventListener('DOMContentLoaded', function () {
            equalizeHomeTestimonials();
            window.addEventListener('load', equalizeHomeTestimonials);
            window.addEventListener('resize', equalizeHomeTestimonials);
            if (typeof Swiper === 'undefined') {
                return;
            }
            var promoEl = document.querySelector('.swiper-home-promo');
            if (promoEl) {
                new Swiper(promoEl, {
                    slidesPerView: 1,
                    spaceBetween: 0,
                    loop: true,
                    autoplay: {
                        delay: 7000,
                        disableOnInteraction: false
                    },
                    pagination: {
                        el: '.home-promo-pagination',
                        clickable: true
                    }
                });
            }
        });
    </script>
    <script>
        window.addEventListener("pageshow", function () {
            const loader = document.getElementById("pageLoader");
            if (loader) {
                loader.style.display = "none";
            }
            sessionStorage.removeItem("loader_show");
        });
    </script>

    <script>
        // function FilterJobByCategory(id) {
        //     sessionStorage.setItem('job_category_id', id);

        //     window.location.href = "{{ route('job') }}";
        // }
        function FilterJobByCategory(id) {

            sessionStorage.setItem('job_category_id', id);

            // loader show
            sessionStorage.setItem("loader_show", "yes");

            document.getElementById("pageLoader").style.display = "flex";

            setTimeout(function () {
                window.location.href = "{{ route('job') }}?category=" + id;
            }, 400);
        }




        function FindJob() {
            var job_category = $("#home_job_category").val();
            var job_location = $("#home_job_location").val();
            var job_title = $("#home_job_title").val();


            // ✅ Store in sessionStorage
            sessionStorage.setItem('job_category', job_category);
            sessionStorage.setItem('job_location', job_location);
            sessionStorage.setItem('job_title', job_title);

            // ✅ Redirect to the job listing page
            window.location.href = "{{ route('job') }}";
        }

        function SelectJobType(type) {
            $('.job-type-select').removeClass('select-job');

            if (type === 'Non-Skilled') {
                $('#noneskill').addClass('select-job');
                document.getElementById("NonSkilledCategoryScreen").style.display = "block";
                document.getElementById("SkilledCategoryScreen").style.display = "none";
            } else if (type === 'Skilled') {
                $('#skill').addClass('select-job');
                document.getElementById("NonSkilledCategoryScreen").style.display = "none";
                document.getElementById("SkilledCategoryScreen").style.display = "block";
            }
        }
    </script>
@endpush
