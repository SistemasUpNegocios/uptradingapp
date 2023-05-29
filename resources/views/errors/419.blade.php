@extends('errors::minimal')

@section('title', "Página expirada")

@section('content')
  <section class="u-align-left u-clearfix u-image u-valign-middle-lg u-valign-middle-md u-section-2" id="sec-9979" data-image-width="1980" data-image-height="1320">
    <div class="u-clearfix u-sheet u-sheet-1">
      <div class="u-clearfix u-expanded-width u-layout-wrap u-layout-wrap-1">
        <div class="u-gutter-0 u-layout">
          <div class="u-layout-row">
            <div class="u-size-26">
              <div class="u-layout-col">
                <div class="u-align-center u-container-style u-layout-cell u-right-cell u-shape-rectangle u-size-60 u-layout-cell-1">
                  <div class="u-container-layout u-valign-middle-lg u-valign-middle-xl u-container-layout-1">
                    <h1 class="u-custom-font u-text u-text-palette-1-base u-text-1">Error 419 <br>
                    </h1>
                    <p class="u-text u-text-palette-1-base u-text-2">La página o sesión expiró, vuelve autenticarte. </p>
                    <a href="{{url("/admin/dashboard")}}" class="u-active-palette-1-base u-align-center u-btn u-btn-rectangle u-button-style u-custom-font u-font-open-sans u-hover-palette-1-base u-palette-3-base u-radius-0 u-text-active-white u-text-hover-white u-text-palette-1-base u-btn-1">Ir a la página de inicio</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="u-size-34">
              <div class="u-layout-col">
                <div class="u-align-left u-container-style u-layout-cell u-left-cell u-size-60 u-layout-cell-2">
                  <div class="u-container-layout u-valign-bottom-lg u-valign-bottom-xl u-valign-middle-md u-valign-middle-sm u-valign-middle-xs u-container-layout-2">
                    <img class="u-expanded-width u-image u-image-contain u-image-1" src="//images01.nicepage.com/c461c07a441a5d220e8feb1a/f5b7e1f63c1c5f34860d9bd8/2634442.png" data-image-width="1100" data-image-height="868">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
