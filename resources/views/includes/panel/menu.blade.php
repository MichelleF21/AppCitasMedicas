        <h6 class="navbar-heading text-muted">
          @if(auth()->user()->role == 'admin')
          Gestión
          @else
          Menú
          @endif
        </h6>

        <ul class="navbar-nav">

          @if (auth()->user()->role == 'admin')
              
          <li class="nav-item  active ">
            <a class="nav-link  active " href="./home">
              <i class="ni ni-tv-2 text-primary"></i> Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="{{ url('/especialidades') }}">
              <i class="fas fa-first-aid text-blue"></i> Especialidades
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="{{ url('/medicos') }}">
              <i class="fas fa-stethoscope text-orange"></i> Médicos
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="{{ url('/pacientes') }}">
              <i class="fas fa-procedures text-info"></i> Pacientes 
            </a>
          </li>

          @elseif(auth()->user()->role == 'medico')

          <li class="nav-item">
            <a class="nav-link " href="{{ url('/horarios') }}">
              <i class="fas fa-clock text-primary"></i> Gestionar horario
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="{{ url('/') }}">
              <i class="fas fa-paste text-info"></i> Mis citas 
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="{{ url('/') }}">
              <i class="fas fa-procedures text-danger"></i> Mis pacientes 
            </a>
          </li>

          @elseif(auth()->user()->role == 'paciente')

          <li class="nav-item">
            <a class="nav-link " href="{{ url('/') }}">
              <i class="fas fa-clock text-primary"></i> Reservar cita
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="{{ url('/') }}">
              <i class="fas fa-paste text-info"></i> Mis citas 
            </a>
          </li>

          @endif

          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault(); document.getElementById('formLogout').submit();"    
            >
              <i class="fas fa-door-open"></i> Cerrar Sesión
            </a>
            <form action="{{ route('logout') }}" method="POST" style="display: none;" id="formLogout">
            @csrf
            </form>
            
          </li>
        </ul>

        @if(auth()->user()->role == 'admin')
        <!-- Divider -->
        <hr class="my-3">
        <!-- Heading -->
        <h6 class="navbar-heading text-muted">Reportes</h6>
        <!-- Navigation -->
        <ul class="navbar-nav mb-md-3">
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="ni ni-books text-primary"></i> Citas
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="ni ni-chart-bar-32 text-warning"></i> Desempeño Médico
            </a>
          </li>
        </ul>
        @endif
