 <!-- ======= Footer ======= -->
 <footer id="footer">
    <div class="footer-top">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-6 footer-newsletter">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2861.237469739894!2d-42.021467196310255!3d-22.977964377262538!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x97194f7842e0ab%3A0x116b9a3223cb3499!2sSecretaria%20municipal%20de%20Meio%20Ambiente!5e0!3m2!1sen!2sbr!4v1646396450817!5m2!1sen!2sbr"  height="270" style="border:0;" allowfullscreen="" loading="lazy"></iframe>

          </div>
          <div class="col-lg-3 col-md-6 footer-info">
            <img class="img-profile" src="{{ asset('img/semas-white-logo.svg')}}" style="width:197px;margin-left:-5px;">
            <p><br>
              Rua Tókio, Nº 76 - Vila Canaa <br>
              Arraial do Cabo - RJ, BR<br><br>
              <strong>Whatsapp:</strong> 22 99758-7289<br>
              <strong>Email:</strong> gab.ambiente@arraial.rj.gov.br<br>
            </p>
            <div class="social-links mt-3">
              <a href="https://www.facebook.com/PrefeituraArraialDoCabo" class="facebook"><i class="bx bxl-facebook"></i></a>
              <a href="https://www.instagram.com/semas.ac/" class="instagram"><i class="bx bxl-instagram"></i></a>
            </div>
          </div>

          <div class="col-lg-2 col-md-6 footer-links">
            <h4>Institucional</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('institutional.thesecretariat') }}">A Secretaria</a></li>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('institutional.organstructure') }}">Estrutura Organizacional</a></li>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('institutional.customerservice') }}">Atendimento ao Público</a></li>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('institutional.managementreport') }}">Relatório de Gestão</a></li>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('institutional.projects') }}">Projetos</a></li>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('institutional.conservationunits') }}">Unidades de Conservação</a></li>
            </ul>
            <br>
            <h4>Serviços</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('services.environmentlicensing.home') }}">Licenciamento Ambiental</a></li>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('services.pruning') }}">Poda</a></li>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('services.animalcause') }}">Causa Animal</a></li>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('services.environmentprotection') }}">Proteção Ambiental</a></li>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('services.environmentquality') }}">Qualidade Ambiental</a></li>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('services.environmenteducation') }}">Educação Ambiental</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Meu Ambiente</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('myenvironment.about') }}">Sobre o Programa</a></li>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('myenvironment.publicpolicy') }}">Políticas Públicas</a></li>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('myenvironment.pillars') }}">Pilares do Programa</a></li>
            </ul>
            <br>
            <h4>Publicação</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('publication.home') }}">Publicações SEMAS</a></li>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('publication.researchs') }}">Pesquisas</a></li>
            </ul>
            <br>
            <h4>Transparência</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('transparency.portal') }}">Portal da Transparência</a></li>
              <li><i class="bx bx-chevron-right"></i>
                <a href="{{ route('transparency.environmentcouncil') }}">Conselho Municipal de Meio Ambiente</a></li>
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
      <p class="mb-1"> Desenvolvido pela Coordenadoria de Organização e Desenvolvimento Estratégico</p>
      <img src="{{ asset('img/pmac-governo.svg') }}" width="130" alt="">
      <img src="{{ asset('img/pmac-code.svg') }}" width="130" style="padding-left:10px;margin-left:10px;border-left:1px solid #858796;" alt="">
    </div>
  </footer><!-- End Footer -->