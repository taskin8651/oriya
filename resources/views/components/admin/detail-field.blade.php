@props(['label', 'wide' => false, 'prose' => false])

<div @class(['detail-field', 'detail-field-wide' => $wide])>
    <dt>{{ $label }}</dt>
    <dd @class(['detail-value', 'detail-prose' => $prose, 'detail-value-empty' => $slot->isEmpty()])>
        @if($slot->isEmpty())
            <span aria-label="No value">—</span>
        @else
            {{ $slot }}
        @endif
    </dd>
</div>
