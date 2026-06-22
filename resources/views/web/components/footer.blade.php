 <!-- ======= Footer ======= -->
 <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-6 footer-newsletter">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2861.237469739894!2d-42.021467196310255!3d-22.977964377262538!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x97194f7842e0ab%3A0x116b9a3223cb3499!2sSecretaria%20municipal%20de%20Meio%20Ambiente!5e0!3m2!1sen!2sbr!4v1646396450817!5m2!1sen!2sbr"  height="270" style="border:0;" allowfullscreen="" loading="lazy"></iframe>

          </div>
          <div class="col-lg-3 col-md-6 footer-info">
            <img class="img-profile" src="{{ isset($logoUrl) ? $logoUrl : asset('assets-web/img/pmac-governo.svg') }}" style="width:197px;margin-left:-5px;">
            <p><br>
              {{ app()->has('active_organ') ? app('active_organ')->sigla : (isset($unit) ? $unit->sigla : 'Prefeitura') }} <br>
              {{ isset($unit) ? $unit->address : '' }}<br>
              {{ isset($unit->organization) ? $unit->operation : '' }}<br><br>
              <strong>Whatsapp:</strong> {{ isset($unit->phone) ? $unit->phone : '' }}<br>
              <strong>Email:</strong> {{ isset($unit->email) ? $unit->email : '' }}<br>
            </p>
            <div class="social-links mt-3">
              <a href="https://www.facebook.com/" class="facebook"><i class="bx bxl-facebook"></i></a>
              <a href="https://www.instagram.com/" class="instagram"><i class="bx bxl-instagram"></i></a>
            </div>
          </div>

          <div class="col-lg-2 col-md-6 footer-links">
            <h4>Institucional</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('a_secretaria_web') }}">A Secretaria</a></li>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('web_institutional.organstructure') }}">Estrutura Organizacional</a></li>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('web_ombudsman') }}">Ouvidoria</a></li>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('relatorio_de_gestao_web_index') }}">Relatório de Gestão</a></li>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('projects_web_index') }}">Projetos</a></li>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('unid_conservacao_web_index') }}">Unidades de Conservação</a></li>
            </ul>
            <br>
            <h4>Serviços</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('licenciamento_ambiental_web') }}">Licenciamento Ambiental</a></li>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('web_services.pruning') }}">Poda</a></li>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('web_services.animalcause') }}">Causa Animal</a></li>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('web_services.environmentprotection') }}">Proteção Ambiental</a></li>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('web_services.environmentquality') }}">Qualidade Ambiental</a></li>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('web_services.environmenteducation') }}">Educação Ambiental</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Meu Ambiente</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('web_myenvironment.about') }}">Sobre o Programa</a></li>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('web_myenvironment.publicpolicy') }}">Políticas Públicas</a></li>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('web_myenvironment.pillars') }}">Pilares do Programa</a></li>
            </ul>
            <br>
            <h4>Publicação</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('web_publication.home') }}">Publicações {{ app()->has('active_organ') ? app('active_organ')->sigla : 'Prefeitura Municipal' }}</a></li>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('web_publication.researchs') }}">Pesquisas</a></li>
            </ul>
            <br>
            <h4>Transparência</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('web_transparency.portal') }}">Portal da Transparência</a></li>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('web_transparency.environmentcouncil') }}">Conselho Municipal de Meio Ambiente</a></li>
              <!-- <li><i class="bx bx-chevron-right"></i>
                <a href="#">Fundo do Meio Ambiente</a></li>
              <li><i class="bx bx-chevron-right"></i>
                <a href="#">Termo de Ajuste Ambiental</a></li> -->
            </ul>

          </div>

        </div>
      </div>
    </div>

    <div class="container b-5 px-3 pt-3 text-muted text-center text-small">
      <p class="mb-1"> Desenvolvido por github.com/FeCruz0</p>
      <img src="{{ asset('assets-web/img/pmac-governo.svg') }}" width="130" alt="">
      <img src="{{ asset('assets-web/img/pmac-code.svg') }}" width="130" style="padding-left:10px;margin-left:10px;border-left:1px solid #858796;" alt="">
    </div>
  </footer><!-- End Footer -->
