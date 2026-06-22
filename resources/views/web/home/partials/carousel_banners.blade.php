<!-- Carousel wrapper -->
<div id="carouselHomeBanner" class="carousel slide carousel-fade" data-mdb-ride="carousel" style="height:260px;">
    <!-- Indicators -->
    <div class="carousel-indicators">
        @php
            $i=0;
        @endphp
        @foreach($posts as $post)
            <button
            type="button"
            data-mdb-target="#carouselHomeBanner"
            data-mdb-slide-to={{ $i }}
            @if ($i == 0)
                class="active"
                aria-current="true"
            @endif
            aria-label={{ $post->title }}
            ></button>
            @php
                $i++;
            @endphp
        @endforeach
    </div>

    <!-- Inner -->
    <div class="carousel-inner" style="height:260px;">
        @php
            $img_bg = "";
            $verification = false;
        @endphp
        @foreach($posts as $post)
            @foreach($post->media as $img)
                @if($img->type_media_id == 1)
                    @php
                        $img_bg = $img->url;
                    @endphp
                @else
                    @php
                        $img_sm = $img->url;
                    @endphp
                @endif
            @endforeach
                @if ($verification)
                    <!-- Single item -->
                    <div class="carousel-item">
                        <img src="{{asset('storage/images/posts/' . $img_bg)}}" class="d-block w-100" alt="Sunset Over the City"/>
                        @if (!isset($post->title))
                            <div class="carousel-caption d-none d-md-block" >
                                <h5>{{ $post->title }}</h5>
                                <p>{{ $post->sub_title }}</p>
                            </div>
                        @endif
                    </div>
                @else
                    @php
                        $verification = true;
                    @endphp
                    <!-- Single item -->
                    <div class="carousel-item active">
                        <img src="{{asset('storage/images/posts/' . $img_bg)}}" class="d-block w-100" alt="Sunset Over the City"/>
                        @if (!isset($post->title))
                            <div class="carousel-caption d-none d-md-block">
                                <h5>{{ $post->title }}</h5>
                                <p>{{ $post->sub_title }}</p>
                            </div>
                        @endif
                    </div>
                @endif
        @endforeach
    </div>
    <!-- Inner -->

    <!-- Controls -->
    <button class="carousel-control-prev" type="button" data-mdb-target="#carouselHomeBanner" data-mdb-slide="prev">
        <span class="" aria-hidden="true"><</span>
        <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-mdb-target="#carouselHomeBanner" data-mdb-slide="next">
        <span class="" aria-hidden="true">></span>
        <span class="visually-hidden">Próximo</span>
    </button>
</div>
<!-- Carousel wrapper -->
