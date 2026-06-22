<!-- ======= About Us Section ======= -->
<section id="about" class="about">
  <h1 class="mt-4 mb-4" style="color: rgb(17, 114, 82); font-family: 'Helvetica Neue', sans-serif; font-size: 75px; font-weight: bold; letter-spacing: -1px; line-height: 1; text-align: center;">Notícias</h1>
  <div class="container">
    <div class="row no-gutters">

      <div class="row">
          @php
              $i = 0;
          @endphp
          @if(isset($news))
              @foreach($news as $new)
                  @if ($i == 0)
                      @php
                          $i++;
                      @endphp
                      <div class="col-lg-6 d-flex flex-column justify-content-top about-content" style="background: url({{asset('storage/images/news/' . $new->image)}});background-repeat: no-repeat;background-size: cover;">
                          <div class="p-4 p-md-5 mb-4 text-white rounded " style="background: rgba(77, 63, 63, .8);">
                              <div class="col-md-12 px-0">
                                  <h5 class="display-4 " style="color: #ffffff; font-family: 'Trocchi', serif; font-size: 50px; font-weight: 600; line-height: 56px; margin: 0;">{{ $new->title }}</h5>
                                  <p class="lead my-3" style="color: #ffffff; font-family: 'Source Sans Pro', sans-serif; font-size: 24px; font-weight: 400; line-height: 26px; margin: 0 0 24px;">{{$new->description}}</p>
                                  <p class="lead mb-0" style="color: #7c795d; font-family: 'Source Sans Pro', sans-serif; font-size: 28px; font-weight: 400; line-height: 32px; margin: 0 0 24px;"><a class="text-white fw-bold" href="{{ route('news_web_show', $new->id) }}">Continue lendo...</a></p>
                              </div>
                          </div>
                      </div>
                  @endif
              @endforeach
              <div class="col-lg-6 d-flex flex-column justify-content-top about-content" >
                  @foreach($news as $new)
                      @if ($i > 1 && $i <= 3)
                              <div class="row g-0 rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative" style="background: url({{asset('storage/images/news/' . $new->image)}});background-repeat: no-repeat;background-size: contain;">
                                  <div class="col p-4 d-flex flex-column position-static" style="background-color: rgba(77, 63, 63, .8);">
                                      <h4 class="mb-0 " style="color: #ffffff; forgb(255, 255, 255)ly: 'Trocchi', serif; font-size: 25px; font-weight: 600; line-height: 28px; margin: 0;">{{$new->title}}</h4>
                                      <div class="mb-1 mt-1" style="color: #ffffff; font-family: 'Source Sans Pro', sans-serif; font-size: 14px; font-weight: 400; line-height: 18px; margin: 0 0 24px;">{{ date('d/m/Y', strtoTime($new->created_at))}}</div>
                                      <p class="card-text mb-auto" style="ont-family: 'Source Sans Pro', sans-serif; font-size: 14px; line-height: 20px; margin: 0 0 24px;">{{$new->description}}</p>
                                      <a href="{{ route('news_web_show', $new->id) }}" class="stretched-link" style="color: #ffffff; font-family: 'Source Sans Pro', sans-serif; font-size: 20px; font-weight: 600; line-height: 22px; margin: 0 0 24px;">Continue lendo...</a>
                                  </div>
                              </div>
                      @endif
                      @php
                          $i++;
                      @endphp
                  @endforeach
              </div>
          @endif
      </div>

    </div>
  </div>
</section><!-- End About Us Section -->
