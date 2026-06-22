<!-- SHORTCUT ICONS -->
<div class="team-boxed" >
    <div class="container" >
        <div class="row people" >
            @foreach ($web_shortcuts as $web_shortcut)
                <div class="col-md-2 col-lg-2 item">
                    <a href="{{ $web_shortcut->link_url }}">
                        <div class="box">
                            <img class="rounded-circle" src="{{asset('storage/images/shortcutweb/' . $web_shortcut->img_url)}}">
                            <h3 class="name">{{ $web_shortcut->title }}</h3>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
