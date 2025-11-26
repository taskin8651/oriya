@php 
    use App\Models\Ad;
    use App\Models\Post;
    use App\Models\Category;
    use App\Models\BreakingNews;
    use App\Models\HeaderLogo;
    use App\Models\FooterLogo;
    use App\Models\ContactDetail;

   

    $categories = Category::all();
    $breakingNews = BreakingNews::where('status','active')->latest()->get();
    $Banner = Ad::where('type', 'Banner')->where('status', 'active')->latest()->first();
     // Header logo
        $headerlogo = HeaderLogo::first();
    // Footer logo
        $footerlogo = FooterLogo::first();

        $contactDetails = ContactDetail::first();
   
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
                

<select id="lang">
  <option value="or" selected>Odia</option>
  <option value="en">English</option>
  <option value="hi">Hindi</option>
  <option value="fr">French</option>
</select>

<script>
document.addEventListener("DOMContentLoaded", function() {
  // 1️⃣ Auto add data-translate="true" to all relevant elements
  const elementsToTranslate = document.querySelectorAll("li, p, span, a, h1, h2, h3, h4, h5, h6, div,b");
  elementsToTranslate.forEach(el => {
    if(el.innerText.trim() !== "") {
      el.dataset.translate = "true";
    }
  });

  // 2️⃣ Now select all elements with data-translate
  const elements = document.querySelectorAll("[data-translate='true']");
  const API_KEY = "AIzaSyAf4GFPHe6nTBL19AC-3cRyFwv42R8CwsQ"; // ⚠️ Only for testing

  // Store original text nodes
  elements.forEach(el => {
    if (!el.dataset.originalTextNodes) {
      const textNodes = [];
      el.childNodes.forEach(node => {
        if (node.nodeType === Node.TEXT_NODE && node.textContent.trim() !== "") {
          textNodes.push(node.textContent.trim());
        }
      });
      el.dataset.originalTextNodes = JSON.stringify(textNodes);
    }
  });

  const translateNow = async (targetLang) => {
    const allTexts = [];
    elements.forEach(el => {
      const nodes = JSON.parse(el.dataset.originalTextNodes);
      allTexts.push(...nodes);
    });

    try {
      const url = "https://translation.googleapis.com/language/translate/v2?key=" + API_KEY;
      const response = await fetch(url, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ q: allTexts, target: targetLang })
      });
      const data = await response.json();
      const translations = data.data?.translations?.map(t => t.translatedText) || [];

      // Map translations back to elements
      let counter = 0;
      elements.forEach(el => {
        const nodes = JSON.parse(el.dataset.originalTextNodes);
        el.childNodes.forEach(node => {
          if (node.nodeType === Node.TEXT_NODE && node.textContent.trim() !== "") {
            node.textContent = " " + (translations[counter] || nodes[counter]);
            counter++;
          }
        });
      });

    } catch (err) {
      console.error("Translation failed:", err);
      alert("Translation failed!");
    }
  };

  // Default translate to Odia
  translateNow("or");

  // Auto translate on dropdown change
  const langSelect = document.getElementById("lang");
  if(langSelect){
    langSelect.addEventListener("change", function () {
      translateNow(this.value);
    });
  }
});
</script>
            </div>
        </div>
    </div>

    <!-- HEADER LOGO + LIVE TV -->
    <header class="bg-white shadow">
      <div class="container mx-auto px-4  flex items-center justify-between">

     <!-- Left: Logo -->
    <div class="flex-shrink-0">
       <img src="{{ $headerlogo->upload_image?->getUrl() ?? 'https://via.placeholder.com/150x50' }}" 
     alt="{{ $headerlogo->title ?? '--'  }} " class="h-12 md:h-16 object-contain">

    </div>

    <!-- Center: Ad -->
<div class="flex-1 flex justify-center ">
    <div class="w-[328px] h-[42px] bg-gray-200 rounded-lg flex items-center justify-center text-gray-600 border border-dashed border-gray-400 overflow-hidden">
        @if(isset($Banner) && $Banner->banner)
            <a href="{{ $Banner->link ?? '#' }}" class="block w-full h-full">
                <img src="{{ $Banner->banner->getUrl() }}"
                     class="w-full h-full object-cover rounded-lg"
                     alt="Advertisement">
            </a>
        @else
            <div class="flex flex-col items-center justify-center h-full">
                <i class="fa-solid fa-ad text-2xl mb-1"></i>
                <p class="text-xs">विज्ञापन</p>
            </div>
        @endif
    </div>
</div>


    <!-- Right: Buttons -->
    <div class="flex items-center space-x-4 flex-shrink-0">
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
                   
                </ul>
            </div>
        </nav>
    </header>

    <!-- BREAKING NEWS TICKER -->
    <div class="bg-primary text-white py-2">
        <div class="container mx-auto px-4 flex items-center">
            <span class="mr-3 font-bold whitespace-nowrap bg-red-800 px-2 py-1 rounded">ताज़ा खबर:</span>
            <div class="marquee-container w-full">
                <div class="marquee-content text-sm text-white">
                    @foreach($breakingNews as $news)
                    <p class="text-white-800 font-bold inline-block">
                        {{ $news->title }} &nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                    </p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


    @yield('content')


    
    <!-- FOOTER -->
    <footer class="bg-gray-800 text-white mt-12 py-10">
        <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-8">

           <div>
    <!-- Logo Image -->
    <div class="mb-2">
        <h3 class="text-xl font-bold mb-2">{{$footerlogo->title ?? '--'}}</h3>
        <img src="{{ $footerlogo->upload_image?->getUrl() ?? 'https://via.placeholder.com/150x50' }}" 
             alt="{{ $footerlogo->title ?? 'Logo' }}" 
             class="w-60 h-40 ">
    </div>

    <p class="text-gray-400 text-sm">{{ $footerlogo->description ?? '--' }}</p>
    
    <div class="flex space-x-4 mt-4">
        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter"></i></a>
        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-youtube"></i></a>
        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
    </div>
</div>


          <div>
    <h4 class="font-bold mb-4">कैटेगरी</h4>
    <ul class="grid grid-cols-2 gap-y-1 text-gray-300 text-sm">
        @foreach($categories as $cat)
            <li>
                <a href="{{ route('category.posts', $cat->slug) }}" class="hover:text-white">
                    {{ $cat->name ?? '-' }}
                </a>
            </li>
        @endforeach
    </ul>
</div>


            <div>
                <h4 class="font-bold mb-4">Links</h4>
                <ul class="space-y-1 text-gray-300 text-sm">
                    <li><a href="#" class="hover:text-white">Home</a></li>
                    <li><a href="#" class="hover:text-white">About</a></li>
                    <li><a href="#" class="hover:text-white">Contact</a></li>
                    <li><a href="#" class="hover:text-white">Gallery</a></li>
                    
                </ul>
            </div>

           <div>
    <h4 class="font-bold mb-4">संपर्क करें</h4>
    <!-- Contact Info with Links -->
    <p class="text-gray-300 text-sm mb-2">
        <a href="mailto:{{$contactDetails->email ?? '-'}}" class="hover:underline">
            Email: {{$contactDetails->email ?? '--'}}
        </a>
    </p>
    <p class="text-gray-300 text-sm">
        <a href="tel:{{$contactDetails->number ?? '--'}}" class="hover:underline">
            Phone: {{$contactDetails->numbe0r ?? '--'}}
        </a>
    </p>
    <p class="text-gray-300 text-sm mb-2">
        Address: {{$contactDetails->address ?? '--'}}
    </p>
    
    <!-- Embedded Google Map -->
    <div class="mb-2">
        <iframe
    src="https://www.google.com/maps?q={{ $contactDetails->address ? urlencode($contactDetails->address) : '' }}&output=embed"
    width="100%"
    height="150"
    class="rounded-lg border-0"
    allowfullscreen
    loading="lazy">
</iframe>

    </div>

    
</div>

        </div>

        <div class="border-t border-gray-700 mt-6 text-center py-4 text-gray-400 text-sm">
            © 2024 पत्रेमया न्यूज़7. सर्वाधिकार सुरक्षित।
        </div>
    </footer>

</body>
</html>