<li class="dropdown messages-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
    <i class="fa fa-envelope-o"></i>
    <span class="label label-success">{{ $notifikasi->count()}}</span>
    </a>
    <ul class="dropdown-menu">
       <li class="header">Kamu Mempunyai {{ $notifikasi->count()}} Pesan</li>
       <li>
          <ul class="menu">
            @foreach($notifikasi->get() as $notif)
             <li>
                <a href="/{{ $notif->link}}" target="new">
                   <div class="pull-left">
                      <img src="{{asset('adminlte/dist/img/avatar2.png')}}" class="img-circle" alt="User Image">
                   </div>
                   <h4>
                    {{ $notif->notifikasi_judul}}
                      <small><i class="fa fa-check-square fa-2" aria-hidden="true"></i>
                        Tandai</small>
                   </h4>
                   <p>{{ substr($notif->notifikasi_pesan,0,17)}} @ {{ substr($notif->created_at,0,16) }}</p>
                </a>
             </li>
             @endforeach
          </ul>
       </li>
       {{-- <li class="footer"><a href="#">See All Messages</a></li> --}}
    </ul>
 </li>