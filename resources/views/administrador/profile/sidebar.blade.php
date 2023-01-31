<!-- ======= Sidebar ======= -->
@php
$currentRoute = Route::current()->uri;
@endphp
<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a href="/admin/index" class="nav-link collapsed {{$currentRoute == 'admin/index' ? 'active' : ''}} text-black">
          <i class="bi bi-house"></i><span>Inicio</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="/admin/agenda" class="nav-link collapsed {{$currentRoute == 'admin/agenda' ? 'active' : ''}} text-black">
          <i class="bi bi-calendar-week"></i><span>Agendar</span>
        </a>
      </li>
      @if(in_array($currentRoute, ['admin/verClientes', 'admin/verBarberos' ]))
      <a class="nav-link" data-bs-target="#forms-nav" data-bs-toggle="collapse" aria-expanded="true" href="#">
        <i class="bi bi-journal-text"></i><span>Registros</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="forms-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav" aria-expanded="false">
      @else
      <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-journal-text"></i><span>Registros</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>   
      <ul id="forms-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav" aria-expanded="false">   
      @endif
        <li>
            <a href="/admin/verClientes" class="{{$currentRoute == 'admin/verClientes' ? 'active' : ''}} text-black">
            <i class="bi bi-person"></i></i><span>Clientes</span>
          </a>
        </li>
       
        <li>
          <a href="/admin/verBarberos" class="{{$currentRoute == 'admin/verBarberos' ? 'active' : ''}} text-black">
          <i class="bi bi-person"></i></i><span>Barberos</span>
          </a>
        </li>        
      </ul>
      <li class="nav-item">
        <a href="/admin/reportes" class="nav-link collapsed {{$currentRoute == 'admin/reporte' ? 'active' : ''}} text-black">
          <i class="bi bi-file-earmark-bar-graph"></i><span>Reporte general</span>
        </a>
      </li>          
      <li class="nav-item">
        <a href="/admin/logout" class="nav-link collapsed {{$currentRoute == 'admin/logout' ? 'active' : ''}} text-black">
          <i class="bi bi-door-closed"></i><span>Salir</span>
        </a>
      </li>
  </ul>

</aside>
<!-- End Sidebar-->