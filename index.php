<?php
// config.php
$services = [
    [
        'name' => 'Gel Polish',
        'price' => '€30',
        'description' => 'inc. detailed cuticle work, natural nail manicure, gel polish application, cuticle oil.'
    ],
    [
        'name' => 'Builder Gel/biab',
        'price' => '€35',
        'description' => 'inc. detailed cuticle work, natural nail manicure, builder gel application, file and shape, cuticle oil.'
    ],
    [
        'name' => 'Acrylic Extensions',
        'price' => '€40',
        'description' => 'inc. detailed cuticle work, natural nail manicure, acrylic application, file and shape, cuticle oil.'
    ],
    [
        'name' => 'Gel Polish on Toes',
        'price' => '€25',
        'description' => 'inc. foot soak, detailed cuticle work, natural nail manicure, gel polish application, cuticle oil.'
    ],
    [
        'name' => 'Full Pedicure',
        'price' => '€40',
        'description' => 'inc. foot soak, detailed cuticle work, hard skin removal, natural nail manicure, gel polish application, foot massage.'
    ],
    [
        'name' => 'Deluxe Pedicure',
        'price' => '€45',
        'description' => 'inc. foot soak, detailed cuticle work, callus removal treatment, natural nail manicure, gel polish application, foot massage.'
    ]
];

$additionalServices = [
    ['name' => 'Detailed Nail Art', 'price' => '+€5'],
    ['name' => 'French', 'price' => '+€5'],
    ['name' => 'Removal', 'price' => '+€10']
];

$promotions = [
    [
        'title' => 'Spring Special',
        'description' => '20% off all nail art services this month',
        'validUntil' => 'April 30, 2025'
    ],
    [
        'title' => 'First Visit Offer',
        'description' => 'Free nail care kit with any full set',
        'validUntil' => 'Ongoing'
    ]
];

$testimonials = [
    [
        'name' => 'Sarah M.',
        'quote' => 'Best nail salon I\'ve ever been to! Layla\'s attention to detail is amazing.',
        'rating' => 5
    ],
    [
        'name' => 'Jennifer K.',
        'quote' => 'The nail art is incredible and lasts for weeks. Highly recommend!',
        'rating' => 5
    ],
    [
        'name' => 'Michelle R.',
        'quote' => 'Professional, clean, and always on time. My go-to salon.',
        'rating' => 5
    ]
];

// functions.php
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function handleContactForm() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'] ?? '';
        $message = $_POST['message'] ?? '';
        
        if (!validateEmail($email)) {
            return ['success' => false, 'message' => 'Please enter a valid email address'];
        }
        
        // Here you would typically send an email or save to database
        // For demo purposes, we'll just return success
        return ['success' => true, 'message' => 'Message sent successfully!'];
    }
    return null;
}

$formResult = handleContactForm();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layla Lawlor Beauty</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
    .masonry-grid {
        columns: 1;
        column-gap: 1rem;
    }

    @media (min-width: 640px) {
        .masonry-grid {
            columns: 2;
        }
    }

    @media (min-width: 768px) {
        .masonry-grid {
            columns: 3;
        }
    }

    @media (min-width: 1024px) {
        .masonry-grid {
            columns: 4;
        }
    }

    .masonry-item {
        display: inline-block;
        width: 100%;
    }

    .filter-btn.active {
        background-color: rgb(244 114 182); /* bg-pink-400 */
        color: white;
    }
</style>
</head>
<body class="min-h-screen bg-pink-50">
    <!-- Hero Section -->
    <section class="relative h-96 bg-pink-200">
        <div class="absolute inset-0 bg-white/20"></div>
        <div class="container mx-auto px-6 h-full flex items-center">
            <div class="text-center md:text-left max-w-2xl">
                <h1 class="text-4xl md:text-6xl font-serif text-gray-800 mb-4">
                    Layla Lawlor Beauty
                </h1>
                <p class="text-xl text-gray-600 mb-8">
                    Professional Nail Care & Beauty Services
                </p>
                <button href="add_booking.php" class="bg-pink-400 text-white px-8 py-3 rounded-full hover:bg-pink-500 transition duration-300 inline-block">
                    Book Now
                </button>
            </div>
        </div>
    </section>

    <?php
// Enhanced gallery image function with categories
function getGalleryImages($directory = 'assets/img') {
    $images = [];
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    
    // Define categories and their patterns
    $categories = [
        'french' => ['french', 'white-tip'],
        'seasonal' => ['christmas', 'halloween', 'easter', 'valentine'],
        'art' => ['flower', 'star', 'glitter', 'design'],
        'gel' => ['gel', 'polish'],
        'pedicure' => ['pedi', 'toe', 'foot'],
    ];
    
    if (is_dir($directory)) {
        $files = scandir($directory);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') continue;
            
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (in_array($extension, $allowed_types)) {
                // Determine categories for this image
                $imageCategories = [];
                $filename = strtolower($file);
                foreach ($categories as $category => $patterns) {
                    foreach ($patterns as $pattern) {
                        if (strpos($filename, $pattern) !== false) {
                            $imageCategories[] = $category;
                            break;
                        }
                    }
                }
                
                // If no categories matched, add to 'other'
                if (empty($imageCategories)) {
                    $imageCategories[] = 'other';
                }
                
                $images[] = [
                    'path' => $directory . '/' . $file,
                    'name' => pathinfo($file, PATHINFO_FILENAME),
                    'alt' => ucwords(str_replace(['-', '_'], ' ', pathinfo($file, PATHINFO_FILENAME))),
                    'categories' => $imageCategories
                ];
            }
        }
    }
    return $images;
}

$galleryImages = getGalleryImages();

// Get unique categories
$uniqueCategories = [];
foreach ($galleryImages as $image) {
    foreach ($image['categories'] as $category) {
        $uniqueCategories[$category] = ucwords($category);
    }
}
asort($uniqueCategories);
?>

<!-- Gallery Section with Masonry and Filters -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-3xl font-serif text-center mb-8">Our Gallery</h2>
            
            <!-- Category Filters -->
            <div class="flex flex-wrap justify-center gap-2 mb-8">
                <button 
                    class="filter-btn active px-4 py-2 rounded-full bg-pink-100 hover:bg-pink-200 transition-colors duration-300"
                    data-category="all"
                >
                    All Styles
                </button>
                <?php foreach ($uniqueCategories as $category => $label): ?>
                <button 
                    class="filter-btn px-4 py-2 rounded-full bg-pink-100 hover:bg-pink-200 transition-colors duration-300"
                    data-category="<?= htmlspecialchars($category) ?>"
                >
                    <?= htmlspecialchars($label) ?>
                </button>
                <?php endforeach; ?>
            </div>
            
            <!-- Masonry Gallery Grid -->
            <div class="masonry-grid">
                <?php foreach ($galleryImages as $index => $image): ?>
                <div 
                    class="masonry-item mb-4 break-inside-avoid"
                    data-categories='<?= json_encode($image['categories']) ?>'
                >
                    <div class="group relative overflow-hidden rounded-lg bg-gray-100 hover:shadow-lg transition duration-300">
                        <img 
                            src="<?= htmlspecialchars($image['path']) ?>" 
                            alt="<?= htmlspecialchars($image['alt']) ?>"
                            class="w-full h-auto object-cover gallery-image"
                            loading="lazy"
                        >
                        <!-- Hover Overlay -->
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center">
                            <div class="text-white opacity-0 group-hover:opacity-100 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300">
                                <i data-feather="zoom-in" class="w-8 h-8"></i>
                            </div>
                        </div>
                        <!-- Category Tags -->
                        <div class="absolute bottom-2 left-2 flex flex-wrap gap-1">
                            <?php foreach ($image['categories'] as $category): ?>
                            <span class="text-xs px-2 py-1 rounded-full bg-white bg-opacity-90 text-pink-600">
                                <?= htmlspecialchars(ucwords($category)) ?>
                            </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const masonryItems = document.querySelectorAll('.masonry-item');
    
    // Filter functionality
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const category = this.dataset.category;
            
            // Update active button state
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Filter items
            masonryItems.forEach(item => {
                const categories = JSON.parse(item.dataset.categories);
                if (category === 'all' || categories.includes(category)) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });

    // Lightbox functionality (from previous code)
    function openLightbox(imageSrc) {
        const lightbox = document.getElementById('lightbox');
        const lightboxImage = document.getElementById('lightbox-image');
        lightboxImage.src = imageSrc;
        lightbox.classList.remove('hidden');
    }

    const galleryImages = document.querySelectorAll('.gallery-image');
    galleryImages.forEach(img => {
        img.addEventListener('click', function() {
            openLightbox(this.src);
        });
    });
});
</script>

    <!-- Promotions Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-serif text-center mb-12">Special Offers</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <?php foreach ($promotions as $promo): ?>
                <div class="bg-gradient-to-br from-pink-50 to-pink-100 p-6 rounded-lg shadow-sm">
                    <h3 class="text-xl font-semibold mb-2"><?= htmlspecialchars($promo['title']) ?></h3>
                    <p class="text-gray-600 mb-4"><?= htmlspecialchars($promo['description']) ?></p>
                    <p class="text-sm text-gray-500">Valid until: <?= htmlspecialchars($promo['validUntil']) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-16 bg-pink-100">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-serif text-center mb-12">Price List</h2>
            <div class="max-w-3xl mx-auto space-y-6">
                <?php foreach ($services as $service): ?>
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-xl font-semibold"><?= htmlspecialchars($service['name']) ?></h3>
                        <span class="text-lg font-bold text-pink-600"><?= htmlspecialchars($service['price']) ?></span>
                    </div>
                    <p class="text-gray-600 text-sm"><?= htmlspecialchars($service['description']) ?></p>
                </div>
                <?php endforeach; ?>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <div class="space-y-2">
                        <?php foreach ($additionalServices as $service): ?>
                        <div class="flex justify-between items-center">
                            <span class="font-semibold"><?= htmlspecialchars($service['name']) ?></span>
                            <span class="text-pink-600"><?= htmlspecialchars($service['price']) ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <p class="text-sm text-gray-500 mt-4">
                        Refills are the same price as a full set for BIAB or Acrylic
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-serif text-center mb-12">What Our Clients Say</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <?php foreach ($testimonials as $testimonial): ?>
                <div class="bg-pink-50 p-6 rounded-lg">
                    <div class="flex mb-4">
                        <?php for ($i = 0; $i < $testimonial['rating']; $i++): ?>
                        <i data-feather="star" class="w-5 h-5 text-yellow-400 fill-current"></i>
                        <?php endfor; ?>
                    </div>
                    <p class="text-gray-600 mb-4 italic">"<?= htmlspecialchars($testimonial['quote']) ?>"</p>
                    <p class="font-semibold"><?= htmlspecialchars($testimonial['name']) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-16 bg-white">
        <div class="container mx-auto px-6">
            <div class="grid md:grid-cols-2 gap-12">
                <div>
                    <h2 class="text-3xl font-serif mb-8">Contact Us</h2>
                    <?php if ($formResult): ?>
                    <div class="mb-6 p-4 rounded-lg <?= $formResult['success'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                        <?= htmlspecialchars($formResult['message']) ?>
                    </div>
                    <?php endif; ?>
                    <form method="POST" class="space-y-6">
                        <div>
                            <label class="block text-gray-700 mb-2">Email</label>
                            <input
                                type="email"
                                name="email"
                                class="w-full p-3 border border-gray-300 rounded-lg"
                                placeholder="your@email.com"
                                required
                            >
                        </div>
                        <textarea
                            name="message"
                            class="w-full p-3 border border-gray-300 rounded-lg h-32"
                            placeholder="Your message"
                            required
                        ></textarea>
                        <button
                            type="submit"
                            class="bg-pink-400 text-white px-6 py-3 rounded-lg hover:bg-pink-500 transition duration-300"
                        >
                            Send Message
                        </button>
                    </form>
                </div>
                <div>
                    <div class="bg-pink-50 p-6 rounded-lg shadow-sm mb-6">
                        <h3 class="text-xl font-serif mb-4">Visit Us</h3>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <i data-feather="map-pin" class="w-5 h-5 text-pink-400 mr-3"></i>
                                <p>123 Beauty Lane, Suite 100<br>Los Angeles, CA 90001</p>
                            </div>
                            <div class="flex items-center">
                                <i data-feather="phone" class="w-5 h-5 text-pink-400 mr-3"></i>
                                <p>(555) 123-4567</p>
                            </div>
                            <div class="flex items-center">
                                <i data-feather="mail" class="w-5 h-5 text-pink-400 mr-3"></i>
                                <p>contact@laylalawlorbeauty.com</p>
                            </div>
                        </div>
                    </div>
                    <!-- Map placeholder -->
                    <div class="bg-gray-200 h-64 rounded-lg">
                        <!-- Add your map integration here -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-pink-900 text-white py-12">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-8 md:mb-0">
                    <h3 class="text-2xl font-serif mb-4">Layla Lawlor Beauty</h3>
                    <p class="text-pink-200">Professional Nail Care & Beauty Services</p>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="hover:text-pink-300 transition duration-300">
                        <i data-feather="instagram" class="w-6 h-6"></i>
                    </a>
                    <a href="#" class="hover:text-pink-300 transition duration-300">
                        <i data-feather="facebook" class="w-6 h-6"></i>
                    </a>
                </div>
            </div>
            <div class="border-t border-pink-800 mt-8 pt-8 text-center text-pink-200">
                <p>&copy; <?= date('Y') ?> Layla Lawlor Beauty. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        feather.replace();
    </script>
</body>
</html>