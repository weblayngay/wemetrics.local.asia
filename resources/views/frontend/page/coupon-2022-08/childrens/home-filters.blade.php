@php
    $blockCode = 'home-filters';
    foreach($blocks as $key => $block_item)
    {
        if($block_item->block_code == $blockCode)
        {
            $description = $block_item->block_description;
            // dd($description);
        }
    }
    // dd($banners);
@endphp
<section class="home-filters">
    <div class="container">
        {!! $description !!}
    </div>
</section>