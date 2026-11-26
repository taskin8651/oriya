@props(['media', 'label'])

@if($media)
    <a class="detail-image" href="{{ $media->getUrl() }}" target="_blank" rel="noopener">
        <img src="{{ $media->getUrl() }}" alt="{{ $label }}" loading="lazy">
    </a>
@endif
