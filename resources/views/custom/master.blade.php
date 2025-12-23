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
    $Banners = Ad::where('type', 'Banner')->where('status', 'active')->latest()->get();
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
    <title>Biplabi Parikrama</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Devanagari:wght@400;500;600;700&display=swap" rel="stylesheet">
<script src="https://sanketkumarofficial.com/js/websitevisit.js?api_key=3WBCCKO9Q8" defer></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: "#f9053aff",
                        secondary: "#fd0505ff",
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
<div class="bg-white border-b lg:block hidden">
    <div class="container mx-auto px-4 py-2 flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0">

        <!-- Left: Time -->
        <div class="flex items-center space-x-4 text-gray-500 text-sm">
            <span id="userTime"></span>
        </div>

        <!-- Right: Search + Language -->
        <div class="flex items-center space-x-4">

            <!-- Search Button -->
            <button onclick="openSearch()" class="hover:text-primary text-lg md:text-base">
                <i class="fa-solid fa-search"></i>
            </button>

            <!-- Language Menu -->
            <!-- <ul id="langList" class="lang-menu flex gap-2 md:gap-4 list-none p-0 m-0">
                <li data-lang="or" class="px-3 py-1 bg-gray-200 rounded-md cursor-pointer hover:bg-gray-300">ଓଡିଆ</li>
                <li data-lang="en" class="px-3 py-1 bg-gray-200 rounded-md cursor-pointer hover:bg-gray-300">English</li>
                <li data-lang="hi" class="px-3 py-1 bg-gray-200 rounded-md cursor-pointer hover:bg-gray-300">हिन्दी</li>
            </ul> -->
        </div>
    </div>
</div>

<!-- SEARCH POPUP OVERLAY -->
<div id="searchPopup" class="fixed inset-0 bg-black bg-opacity-60 hidden flex items-center justify-center z-50 p-4 ">
    <div class="bg-white rounded-xl w-full max-w-lg p-6 relative">

        <!-- Close Button -->
        <button onclick="closeSearch()" class="absolute top-3 right-3 text-gray-500 hover:text-black text-xl">
            &times;
        </button>

        <!-- Search Input -->
        <input 
            type="text"
            id="searchInput"
            class="w-full border border-gray-300 p-3 rounded-lg outline-none"
            placeholder="Search (News, Title, Content)..."
            onkeyup="liveSearch(this.value)"
        >

        <!-- Results -->
        <div id="searchResults" class="mt-4 max-h-60 overflow-auto"></div>
    </div>
</div>

<style>
.lang-menu li {
  list-style: none;
  cursor: pointer;
  transition: background 0.2s;
}
.lang-menu li:hover {
  background-color: #ddd;
}
</style>

<script>
function updateTime() {
    const now = new Date();
    const options = { day:'numeric', month:'short', year:'numeric', weekday:'short', hour:'2-digit', minute:'2-digit', second:'2-digit' };
    document.getElementById("userTime").innerText = now.toLocaleString('hi-IN', options);
}
updateTime();
setInterval(updateTime, 1000);

function openSearch() { document.getElementById("searchPopup").classList.remove("hidden"); document.getElementById("searchInput").focus(); }
function closeSearch() { document.getElementById("searchPopup").classList.add("hidden"); }

function liveSearch(query) {
    if(query.length < 2){ document.getElementById("searchResults").innerHTML = ""; return; }
    fetch(`/live-search?q=${query}`).then(res=>res.json()).then(data=>{
        let html = '';
        if(data.length === 0){ html = `<p class="text-gray-500">No results found</p>`; }
        else { data.forEach(item=>{ html+=`<a href="/post/${item.slug}" class="block p-2 border-b hover:bg-gray-100"><strong>${item.title}</strong></a>` }) }
        document.getElementById("searchResults").innerHTML = html;
    });
}

// Translation
// document.addEventListener("DOMContentLoaded", function() {
//   const skipTranslation = document.querySelector(".no-translate");
//   const elementsToTranslate = document.querySelectorAll("li, p, span, a, h1, h2, h3, h4, h5, h6, div, b, strong, button");
//   elementsToTranslate.forEach(el => { if(skipTranslation?.contains(el)) return; if(el.innerText.trim()!=="") el.dataset.translate="true"; });

//   const elements = document.querySelectorAll("[data-translate='true']");
//   const API_KEY = "AIzaSyAf4GFPHe6nTBL19AC-3cRyFwv42R8CwsQ";

//   elements.forEach(el => { if(!el.dataset.originalTextNodes){ const nodes=[]; el.childNodes.forEach(node=>{ if(node.nodeType===Node.TEXT_NODE && node.textContent.trim()!=="") nodes.push(node.textContent.trim()); }); el.dataset.originalTextNodes=JSON.stringify(nodes); } });

//   const translateNow = async targetLang=>{
//     const allTexts=[];
//     elements.forEach(el=>{ allTexts.push(...JSON.parse(el.dataset.originalTextNodes)) });

//     try{
//       const res = await fetch(`https://translation.googleapis.com/language/translate/v2?key=${API_KEY}`, {
//         method:"POST", headers:{"Content-Type":"application/json"},
//         body:JSON.stringify({q:allTexts,target:targetLang})
//       });
//       const data = await res.json();
//       const translations = data.data?.translations?.map(t=>t.translatedText)||[];
//       let counter=0;
//       elements.forEach(el=>{
//         const nodes=JSON.parse(el.dataset.originalTextNodes);
//         el.childNodes.forEach(node=>{
//           if(node.nodeType===Node.TEXT_NODE && node.textContent.trim()!==""){ node.textContent=" "+(translations[counter]||nodes[counter]); counter++; }
//         });
//       });
//     } catch(e){ console.error("Translation failed:", e); }
//   }

//   translateNow("or");

//   document.querySelectorAll("#langList li").forEach(item=>{
//     item.addEventListener("click",function(){ const lang=this.getAttribute("data-lang"); translateNow(lang); });
//   });
// });

// });
</script>

  <!-- HEADER LOGO + LIVE TV -->
<header class="bg-white shadow">

    <div class="container mx-auto px-4 py-3 flex flex-col md:flex-row items-center justify-between gap-4 md:gap-0">

        <!-- Left: Logo -->
        <div class="flex-shrink-0">
            <img src="{{ $headerlogo->upload_image?->getUrl() ?? 'https://via.placeholder.com/150x50' }}" 
                alt="{{ $headerlogo->title ?? '--' }}" 
                class="h-12 md:h-16 object-contain">
        </div>

       @isset($Banners)
<div class="flex-1 flex justify-center w-full">
    <div class="relative w-full max-w-[708px] h-[60px] sm:h-[48px] md:h-[56px] lg:h-[80px] overflow-hidden rounded-lg border border-dashed border-gray-400 bg-gray-200">

        <!-- Slides -->
        <div id="adCarousel" class="flex transition-transform duration-500 ease-in-out">
            @foreach($Banners as $banner)
                <a href="{{ $banner->link ?? '#' }}" class="min-w-full h-[80px] block">
                    <img
                        src="{{ $banner->banner->getUrl() }}"
                        alt="Advertisement"
                        class="w-full h-full object-cover rounded-lg">
                </a>
            @endforeach
        </div>

        <!-- Dots -->
        <div class="absolute bottom-1 left-1/2 -translate-x-1/2 flex gap-1">
            @foreach($Banners as $key => $banner)
                <span class="w-1.5 h-1.5 rounded-full bg-white/70"></span>
            @endforeach
        </div>

    </div>
</div>
@endisset
<script>
    const carousel = document.getElementById('adCarousel');
    const slides = carousel.children;
    let index = 0;

    setInterval(() => {
        index = (index + 1) % slides.length;
        carousel.style.transform = `translateX(-${index * 100}%)`;
    }, 8000); // 3 sec
</script>



        <!-- Right: Buttons + Social -->
        <div class="flex flex-col md:flex-row items-center gap-3 md:gap-4 w-full md:w-auto">

            <!-- Buttons -->
            <div class="flex flex-wrap md:flex-nowrap items-center space-x-0 md:space-x-4 gap-2 md:gap-0 justify-center">
                <a href="/gallery" class="bg-primary text-white px-5 py-2 rounded-full font-semibold shadow hover:bg-red-700 flex items-center">
                    <i class="fa-solid fa-tv mr-2"></i> Gallery
                </a>

                <a href="/epaper" class="bg-gray-800 text-white px-5 py-2 rounded-full font-semibold shadow hover:bg-gray-900 flex items-center">
                    <i class="fa-solid fa-newspaper mr-2"></i> ePaper
                </a>
            </div>

           <!-- Social Media -->
<div class="flex items-center space-x-4 mt-4">

    <!-- Facebook -->
    <a href="#"
       aria-label="Facebook"
       class="w-12 h-12 flex items-center justify-center rounded-md bg-[#1877F2] hover:opacity-80 transition">
        <i class="fab fa-facebook-f text-xl text-white"></i>
    </a>

    <!-- X (Twitter) -->
    <a href="#"
       aria-label="X"
       class="w-12 h-12 flex items-center justify-center rounded-md bg-black hover:opacity-80 transition">
        <i class="fab fa-twitter text-xl text-white"></i>
    </a>

    <!-- YouTube -->
    <a href="https://youtube.com/@biplabiparikramanews?si=P7nNPAwLt1ZtKPfu"
       aria-label="YouTube"
       class="w-12 h-12 flex items-center justify-center rounded-md bg-[#FF0000] hover:opacity-80 transition">
        <i class="fab fa-youtube text-xl text-white"></i>
    </a>

    <!-- Instagram -->
    <a href="#"
       aria-label="Instagram"
       class="w-12 h-12 flex items-center justify-center rounded-md bg-gradient-to-tr from-[#F58529] via-[#DD2A7B] to-[#8134AF] hover:opacity-80 transition">
        <i class="fab fa-instagram text-xl text-white"></i>
    </a>

    <!-- WhatsApp -->
    <a href="https://api.whatsapp.com/send?text={{ urlencode(request()->url()) }}"
       aria-label="WhatsApp"
       class="w-12 h-12 flex items-center justify-center rounded-md bg-green-500 hover:opacity-80 transition">
        <i class="fab fa-whatsapp text-xl text-white"></i>
    </a>

</div>



        </div>

    </div>
</header>

<header class="bg-dark text-white shadow">

    <!-- TOP BAR -->
    <div class="container mx-auto px-4 flex items-center justify-between h-14">

        <!-- Mobile: Menu Button (LEFT) -->
        <button id="menuToggle"
                class="md:hidden text-white text-3xl p-2">
            <i class="fa-solid fa-bars"></i>
        </button>

        <!-- Desktop: Category Menu (LEFT) -->
        <ul class="hidden md:flex items-center space-x-6 text-gray-200">
            <li>
                <a href="/" class="hover:text-primary font-bold text-lg">
                    Home
                </a>
            </li>
            @foreach($categories as $category)
                <li>
                    <a href="{{ route('category.posts', $category->slug) }}"
                       class="hover:text-primary font-bold text-lg">
                        {{ $category->name }}
                    </a>
                </li>
            @endforeach
        </ul>

        <!-- Event Button / Icon (RIGHT – both mobile & desktop) -->
        <a href="/events"
           class="flex items-center gap-2 px-3 py-2
                  bg-primary text-white text-sm font-semibold rounded
                  hover:bg-primary/90 transition">
            <i class="fa-solid fa-calendar-days text-xl md:text-base"></i>
            <span class="hidden md:inline">Events</span>
        </a>

    </div>

</header>


<!-- ───────── MOBILE DRAWER ───────── -->
<!-- MOBILE SLIDE DOWN MENU -->
<div id="mobileMenu"
     class="md:hidden bg-dark text-white overflow-hidden max-h-0 transition-all duration-300 ease-in-out">

    <div class="px-4  border-t border-gray-700 flex flex-col items-center">
  <!-- Home Icon -->
        <a href="/"
           class="flex items-center justify-center w-10 h-10  hover:bg-primary transition mb-4">
            <i class="fa-solid fa-house text-lg"></i>
        </a>

        <!-- Divider -->
        <span class="w-12 h-[1px] bg-gray-600"></span>
        <!-- Category List (Always Visible) -->
        <div class="space-y-3 text-center">
            @foreach($categories as $category)
                <a href="{{ route('category.posts', $category->slug) }}"
                   class="block text-base font-medium hover:text-primary">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

    </div>
</div>

<script>
    const menuToggle = document.getElementById("menuToggle");
    const mobileMenu = document.getElementById("mobileMenu");

    menuToggle.addEventListener("click", () => {
        if (mobileMenu.classList.contains("max-h-0")) {
            mobileMenu.classList.remove("max-h-0");
            mobileMenu.classList.add("max-h-[1000px]");
        } else {
            mobileMenu.classList.add("max-h-0");
            mobileMenu.classList.remove("max-h-[1000px]");
        }
    });

    // Category Toggle
    const toggleCategory = document.getElementById("toggleCategory");
    const categoryList = document.getElementById("categoryList");
    const categoryIcon = document.getElementById("categoryIcon");

    toggleCategory.addEventListener("click", () => {
        categoryList.classList.toggle("hidden");
        categoryIcon.classList.toggle("rotate-180");
    });
</script>




    <!-- BREAKING NEWS TICKER -->
    <div class="bg-primary text-white py-2">
        <div class="container mx-auto px-1 flex items-center">
            <span class="mr-3 font-bold whitespace-nowrap bg-red-800 px-2 py-1 rounded"> Breaking</span>
            <div class="marquee-container w-full">
                <div class="marquee-content text-lg text-white">
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
        <a href="#" class="text-gray-400 hover:text-white">
    <img src="/images/facebook.png" alt="Facebook" class="w-8 h-8">
</a>

<a href="#" class="text-gray-400 hover:text-white">
    <img src="/images/x.png" alt="Twitter" class="w-8 h-8">
</a>

<a href="https://youtube.com/@biplabiparikramanews?si=P7nNPAwLt1ZtKPfu" class="text-gray-400 hover:text-white">
    <img src="/images/yt.png" alt="YouTube" class="w-8 h-8">
</a>

<a href="#" class="text-gray-400 hover:text-white">
    <img src="/images/instagram.png" alt="Instagram" class="w-8 h-8">
</a>

    </div>
</div>


          <div>
    <h4 class="font-bold mb-4">Category</h4>
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
                    <li><a href="/" class="hover:text-white">Home</a></li>
                    <!-- <li><a href="/post" class="hover:text-white">News</a></li> -->
                    <li><a href="/epaper" class="hover:text-white">ePaper</a></li>
                    <li><a href="/gallery" class="hover:text-white">Gallery</a></li>
                    
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
    src="https://www.google.com/maps?q={{ $contactDetails?->location_url ?? '' }}&output=embed"
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
           © 2024 Biplabi Parikrama. All rights reserved. 
<a href="https://sanketkumarofficial.com/" class="text-primary hover:underline">
    sanketkumarofficial.com
</a>

        </div>
    </footer>

</body>
</html>