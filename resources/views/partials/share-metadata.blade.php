@php
    $siteName = 'Biplabi Parikrama';
    $seo = \App\Models\Seo::with('media')->latest('id')->first();
    $pageTitle = trim($sharePreview['title'] ?? '');
    $shareTitle = $pageTitle !== '' ? $pageTitle : (trim($seo?->seo_title ?? '') ?: $siteName);

    $descriptions = [
        $sharePreview['description'] ?? null,
        $sharePreview['body'] ?? null,
        $seo?->description,
        'Latest news from Odisha and beyond.',
    ];

    foreach ($descriptions as $description) {
        $withSpacing = preg_replace('~</(?:p|div|li|h[1-6])\s*>|<br\b[^>]*>~i', ' ', $description ?? '');
        $shareDescription = \Illuminate\Support\Str::squish(html_entity_decode(strip_tags($withSpacing), ENT_QUOTES | ENT_HTML5, 'UTF-8'));

        if ($shareDescription !== '') {
            break;
        }
    }

    $shareDescription = \Illuminate\Support\Str::limit($shareDescription, 160);
    $shareMedia = $sharePreview['image'] ?? $seo?->social_share_image;
    $shareImage = url($shareMedia?->getUrl() ?? asset('images/social-share.jpg'));
    $shareUrl = url()->current();
@endphp
<title>{{ $shareTitle }}</title>
<meta name="description" content="{{ $shareDescription }}">
<meta property="og:site_name" content="{{ $siteName }}">
<meta property="og:type" content="{{ $sharePreview['type'] ?? 'website' }}">
<meta property="og:title" content="{{ $shareTitle }}">
<meta property="og:description" content="{{ $shareDescription }}">
<meta property="og:url" content="{{ $shareUrl }}">
<meta property="og:image" content="{{ $shareImage }}">
@if(!$shareMedia)
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
@endif
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $shareTitle }}">
<meta name="twitter:description" content="{{ $shareDescription }}">
<meta name="twitter:image" content="{{ $shareImage }}">
