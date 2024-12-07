{{-- Load Items only on Tablet and Phone --}}
<pre>@verbatim
    @if (request()->header('User-Agent') &&
            preg_match(
                '/Mobile|Android|iPhone|iPad|iPod|iPad Mini|iPad Air|iPad Pro|Surface Pro 7|Surface Pro|Tablet|Kindle|Silk|PlayBook|BB10/i',
                request()->header('User-Agent')))
        {{-- Design Content goes Here --}}
    @endif
    @endverbatim</pre>

    {{-- Load Items not on Tablet and Phone --}}
    <pre>@verbatim
    @if (request()->header('User-Agent') &&
            !preg_match(
                '/Mobile|Android|iPhone|iPad|iPod|iPad Mini|iPad Air|iPad Pro|Surface Pro 7|Surface Pro|Tablet|Kindle|Silk|PlayBook|BB10/i',
                request()->header('User-Agent')))
        {{-- Design Content goes Here --}}
    @endif
    @endverbatim</pre>
