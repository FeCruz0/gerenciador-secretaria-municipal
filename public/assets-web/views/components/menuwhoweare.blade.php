<!-- MENU QUEM SOMOS -->
    <section id=navwho>
        <div class="nav-scroller bg-body shadow-sm">
            <nav class="nav">
                <a class="nav-link {{ (request()->is('estruturaorganizacional')) || (request()->is('estruturaorganizacional')) ? 'active' : '' }}" href="{{ route('whoweare.organestructure') }}">Estrutura Organizacional</a>
                <a class="nav-link {{ (request()->is('fundacaoambiente')) || (request()->is('fundacaoambiente')) ? 'active' : '' }}" href="{{ route('whoweare.naturefoundation') }}">Fundação do Meio Ambiente</a>
                <a class="nav-link {{ (request()->is('conselhoambiente')) || (request()->is('conselhoambiente')) ? 'active' : '' }}" href="{{ route('whoweare.naturecouncil') }}">Conselho Municipal de Meio Ambiente</a>
                <a class="nav-link {{ (request()->is('fundoambiente')) || (request()->is('fundoambiente')) ? 'active' : '' }}" href="{{ route('whoweare.naturefund') }}">Fundo Municipal de Meio Ambiente</a>
                <a class="nav-link {{ (request()->is('diretorias')) || (request()->is('diretorias')) ? 'active' : '' }}" href="{{ route('whoweare.board') }}">Diretorias</a>
            </nav>
        </div>
    </section>