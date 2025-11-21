@php 
    use App\Models\Ad;
    use App\Models\Post;
    use App\Models\Category;

   

    $categories = Category::all();
   
@endphp

<!DOCTYPE html>
<html lang="hi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prameya News - Odisha's Leading News Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Devanagari:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#e11d48",
                        secondary: "#e11d48",
                        dark: "#111827"
                    },
                    fontFamily: {
                        'sans': ['Noto Sans Devanagari', 'Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Noto Sans Devanagari', 'Inter', sans-serif; }
        .marquee-container {
            overflow: hidden;
            white-space: nowrap;
            box-sizing: border-box;
        }
        .marquee-content {
            display: inline-block;
            padding-left: 100%;
            animation: marquee 30s linear infinite;
        }
        @keyframes marquee {
            0% { transform: translate(0, 0); }
            100% { transform: translate(-100%, 0); }
        }
        .news-card:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease;
        }
    </style>
</head>

<body class="bg-gray-50">

    <!-- TOP BAR -->
    <div class="bg-white border-b">
        <div class="container mx-auto px-4 py-2 flex justify-between text-sm">
            <div class="text-gray-500 flex items-center space-x-4">
                <span><i class="fa-regular fa-clock mr-1"></i> 24 जून, 2024 | सोमवार</span>
                <span><i class="fa-solid fa-location-dot mr-1"></i> भुवनेश्वर</span>
            </div>

            <div class="flex items-center space-x-4">
                <button class="hover:text-primary"><i class="fa-solid fa-search"></i></button>
                <button class="hover:text-primary"><i class="fa-regular fa-user"></i></button>
                <button class="hover:text-primary">English</button>
            </div>
        </div>
    </div>

    <!-- HEADER LOGO + LIVE TV -->
    <header class="bg-white shadow">
        <div class="container mx-auto px-4 py-4 flex flex-col md:flex-row justify-between items-center">

            <div class="text-center md:text-left flex items-center">
                <img src="https://dummyimage.com/300x80/e11d48/ffffff&text=PRAMEYA+NEWS7" alt="Prameya News" class="h-12 md:h-16">
            </div>

            <div class="flex items-center space-x-4 mt-3 md:mt-0">
                <a href="#" class="bg-primary text-white px-5 py-2 rounded-full font-semibold shadow hover:bg-red-700 flex items-center">
                    <i class="fa-solid fa-tv mr-2"></i> LIVE TV
                </a>
                <a href="#" class="bg-gray-800 text-white px-5 py-2 rounded-full font-semibold shadow hover:bg-gray-900 flex items-center">
                    <i class="fa-solid fa-newspaper mr-2"></i> ePaper
                </a>
            </div>
        </div>

        <!-- CATEGORY NAV -->
        <nav class="bg-dark">
            <div class="container mx-auto px-4">
                <ul class="flex items-center text-sm overflow-x-auto space-x-6 py-3 text-gray-200">
                    @foreach($categories as $category)

                   <li><a href="{{ route('category.posts', $category->slug) }}" class="hover:text-primary font-medium">
    {{ $category->name }}
</a></li>

                    @endforeach
                    <li><a href="#" class="hover:text-primary font-medium">ओडिशा</a></li>
                    <li><a href="#" class="hover:text-primary font-medium">राष्ट्रीय</a></li>
                    <li><a href="#" class="hover:text-primary font-medium">अंतर्राष्ट्रीय</a></li>
                    <li><a href="#" class="hover:text-primary font-medium">खेल</a></li>
                    <li><a href="#" class="hover:text-primary font-medium">मनोरंजन</a></li>
                    <li><a href="#" class="hover:text-primary font-medium">व्यापार</a></li>
                    <li><a href="#" class="hover:text-primary font-medium">राजनीति</a></li>
                    <li><a href="#" class="hover:text-primary font-medium">शिक्षा</a></li>
                    <li><a href="#" class="hover:text-primary font-medium">स्वास्थ्य</a></li>
                    <li><a href="#" class="hover:text-primary font-medium">तकनीक</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- BREAKING NEWS TICKER -->
    <div class="bg-primary text-white py-2">
        <div class="container mx-auto px-4 flex items-center">
            <span class="mr-3 font-bold whitespace-nowrap bg-red-800 px-2 py-1 rounded">ताज़ा खबर:</span>
            <div class="marquee-container w-full">
                <div class="marquee-content text-sm">
                    ओडिशा में नया मंत्रिमंडल गठित | भारत ने क्रिकेट विश्व कप जीता | कोरोना के नए वेरिएंट पर स्वास्थ्य मंत्रालय की एडवाइजरी | भुवनेश्वर में नए फ्लाईओवर का उद्घाटन | ओडिशा के खिलाड़ी ने जीता स्वर्ण पदक
                </div>
            </div>
        </div>
    </div>


    @yield('content')


    
    <!-- FOOTER -->
    <footer class="bg-gray-800 text-white mt-12 py-10">
        <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-8">

            <div>
                <h3 class="text-xl font-bold mb-4">PRAMEYA NEWS7</h3>
                <p class="text-gray-400 text-sm">ओडिशा का सबसे विश्वसनीय समाचार स्रोत। ताज़ा खबरें, ब्रेकिंग न्यूज और विश्लेषण।</p>
                <div class="flex space-x-4 mt-4">
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            <div>
                <h4 class="font-bold mb-4">कैटेगरी</h4>
                <ul class="space-y-1 text-gray-300 text-sm">
                    <li><a href="#" class="hover:text-white">मुख्य समाचार</a></li>
                    <li><a href="#" class="hover:text-white">ओडिशा</a></li>
                    <li><a href="#" class="hover:text-white">राष्ट्रीय</a></li>
                    <li><a href="#" class="hover:text-white">खेल</a></li>
                    <li><a href="#" class="hover:text-white">मनोरंजन</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold mb-4">लिंक्स</h4>
                <ul class="space-y-1 text-gray-300 text-sm">
                    <li><a href="#" class="hover:text-white">हमारे बारे में</a></li>
                    <li><a href="#" class="hover:text-white">संपर्क करें</a></li>
                    <li><a href="#" class="hover:text-white">गोपनीयता नीति</a></li>
                    <li><a href="#" class="hover:text-white">विज्ञापन दें</a></li>
                    <li><a href="#" class="hover:text-white">करियर</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold mb-4">संपर्क करें</h4>
                <p class="text-gray-300 text-sm mb-2">भुवनेश्वर, ओडिशा</p>
                <p class="text-gray-300 text-sm mb-2">Email: info@prameyanews.com</p>
                <p class="text-gray-300 text-sm">Phone: +91-XXXX-XXXXXX</p>
            </div>
        </div>

        <div class="border-t border-gray-700 mt-6 text-center py-4 text-gray-400 text-sm">
            © 2024 पत्रेमया न्यूज़7. सर्वाधिकार सुरक्षित।
        </div>
    </footer>

</body>
</html>