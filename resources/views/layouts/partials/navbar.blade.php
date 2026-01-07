<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar sticky">
  <div class="form-inline mr-auto">
    <ul class="navbar-nav mr-3">
      <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn"> <i data-feather="align-justify"></i></a></li>
      <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
          <i data-feather="maximize"></i>
        </a></li>
      <li>
        <form class="form-inline mr-auto" action="{{ route('search.index') }}" method="GET">
          <div class="search-element">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="200" name="q"
              value="{{ request('q') }}">
            <button class="btn" type="submit">
              <i class="fas fa-search"></i>
            </button>
          </div>
        </form>
      </li>
    </ul>
  </div>
  <ul class="navbar-nav navbar-right">
    <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
        class="nav-link nav-link-lg message-toggle"><i data-feather="mail"></i>
        <span class="badge headerBadge1">
          6 </span> </a>
      <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
        <div class="dropdown-header">
          Messages
          <div class="float-right">
            <a href="#">Mark All As Read</a>
          </div>
        </div>
        <div class="dropdown-list-content dropdown-list-message">
          <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar
											text-white"> <img alt="image" src="/admin/assets/img/users/user-1.png" class="rounded-circle">
            </span> <span class="dropdown-item-desc"> <span class="message-user">John
                Deo</span>
              <span class="time messege-text">Please check your mail !!</span>
              <span class="time">2 Min Ago</span>
            </span>
          </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
              <img alt="image" src="/admin/assets/img/users/user-2.png" class="rounded-circle">
            </span> <span class="dropdown-item-desc"> <span class="message-user">Sarah
                Smith</span> <span class="time messege-text">Request for leave
                application</span>
              <span class="time">5 Min Ago</span>
            </span>
          </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
              <img alt="image" src="/admin/assets/img/users/user-5.png" class="rounded-circle">
            </span> <span class="dropdown-item-desc"> <span class="message-user">Jacob
                Ryan</span> <span class="time messege-text">Your payment invoice is
                generated.</span> <span class="time">12 Min Ago</span>
            </span>
          </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
              <img alt="image" src="/admin/assets/img/users/user-4.png" class="rounded-circle">
            </span> <span class="dropdown-item-desc"> <span class="message-user">Lina
                Smith</span> <span class="time messege-text">hii John, I have upload
                doc
                related to task.</span> <span class="time">30
                Min Ago</span>
            </span>
          </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
              <img alt="image" src="/admin/assets/img/users/user-3.png" class="rounded-circle">
            </span> <span class="dropdown-item-desc"> <span class="message-user">Jalpa
                Joshi</span> <span class="time messege-text">Please do as specify.
                Let me
                know if you have any query.</span> <span class="time">1
                Days Ago</span>
            </span>
          </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
              <img alt="image" src="/admin/assets/img/users/user-2.png" class="rounded-circle">
            </span> <span class="dropdown-item-desc"> <span class="message-user">Sarah
                Smith</span> <span class="time messege-text">Client Requirements</span>
              <span class="time">2 Days Ago</span>
            </span>
          </a>
        </div>
        <div class="dropdown-footer text-center">
          <a href="#">View All <i class="fas fa-chevron-right"></i></a>
        </div>
      </div>
    </li>
    <li class="dropdown dropdown-list-toggle">
      <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg">
        <i data-feather="bell"></i>
        @if(Auth::user()->unreadNotifications->count() > 0)
        <span class="badge headerBadge2">{{ Auth::user()->unreadNotifications->count() }}</span>
        @endif
      </a>
      <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
        <div class="dropdown-header">
          Notifications
          <div class="float-right">
            <a href="#" id="mark-all-read">Mark All As Read</a>
          </div>
        </div>
        <div class="dropdown-list-content dropdown-list-icons">
          @forelse(Auth::user()->unreadNotifications as $notification)
          <a href="#" class="dropdown-item mark-as-read" data-id="{{ $notification->id }}">
            <span class="dropdown-item-icon bg-primary text-white">
              <i class="fas fa-bell"></i>
            </span>
            <span class="dropdown-item-desc">
              {{ $notification->data['message'] ?? 'Notification received' }}
              <span class="time">{{ $notification->created_at->diffForHumans() }}</span>
            </span>
          </a>
          @empty
          <p class="text-muted text-center p-3">No new notifications</p>
          @endforelse
        </div>
        <div class="dropdown-footer text-center">
          <a href="{{ route('notifications.index') }}">View All <i class="fas fa-chevron-right"></i></a>
        </div>
      </div>
    </li>
    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
        <img alt="image" src="/admin/assets/img/pp.jpeg" class="user-img-radious-style"> <span
          class="d-sm-none d-lg-inline-block"></span></a>
      <div class="dropdown-menu dropdown-menu-right pullDown">
        <div class="dropdown-title">Hello {{ Auth::user()->name }}</div>

        <!-- Account Management -->
        <a href="{{ route('admin.profile') }}" class="dropdown-item has-icon">
          <i class="far fa-user"></i> Profile
        </a>

        @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
        <a href="{{ route('api-tokens.index') }}" class="dropdown-item has-icon">
          <i class="fas fa-key"></i> API Tokens
        </a>
        @endif

        <a href="{{ route('log-activity.index') }}" class="dropdown-item has-icon">
          <i class="fas fa-bolt"></i> Activities
        </a>

        <a href="#" class="dropdown-item has-icon">
          <i class="fas fa-cog"></i> Settings
        </a>

        <!-- Team Management -->
        @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
        <div class="dropdown-divider"></div>
        <div class="dropdown-title">Manage Team</div>

        <!-- Team Settings -->
        @if(Auth::user()->currentTeam)
        <a href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" class="dropdown-item has-icon">
          <i class="fas fa-users-cog"></i> Team Settings
        </a>
        @endif

        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
        <a href="{{ route('teams.create') }}" class="dropdown-item has-icon">
          <i class="fas fa-plus"></i> Create New Team
        </a>
        @endcan

        <!-- Team Switcher -->
        @if (Auth::user()->allTeams()->count() > 1)
        <div class="dropdown-divider"></div>
        <div class="dropdown-title">Switch Teams</div>

        @foreach (Auth::user()->allTeams() as $team)
        <form method="POST" action="{{ route('current-team.update') }}" x-data>
          @method('PUT')
          @csrf
          <input type="hidden" name="team_id" value="{{ $team->id }}">
          <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="dropdown-item has-icon">
            @if (Auth::user()->isCurrentTeam($team))
            <i class="fas fa-check-circle text-success"></i>
            @else
            <i class="far fa-circle"></i>
            @endif
            {{ $team->name }}
          </a>
        </form>
        @endforeach
        @endif
        @endif

        <div class="dropdown-divider"></div>
        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
          @csrf
        </form>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
          class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>
          Logout
        </a>
      </div>
    </li>
  </ul>
</nav>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Handle Mark as Read
    document.querySelectorAll('.mark-as-read').forEach(item => {
      item.addEventListener('click', function(e) {
        e.preventDefault();
        const id = this.getAttribute('data-id');
        const url = `{{ url('/notifications') }}/${id}/mark-as-read`;

        fetch(url, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Accept': 'application/json',
              'Content-Type': 'application/json'
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              this.remove();
              // Update badge count
              const badge = document.querySelector('.headerBadge1');
              if (badge) {
                let count = parseInt(badge.textContent);
                count--;
                if (count <= 0) {
                  badge.remove();
                  document.querySelector('[data-feather="bell"]').classList.remove('bell');
                } else {
                  badge.textContent = count;
                }
              }
              if (document.querySelectorAll('.mark-as-read').length === 0) {
                document.querySelector('.dropdown-list-icons').innerHTML =
                  '<p class="text-muted text-center p-3">No new notifications</p>';
              }
            }
          });
      });
    });

    // Handle Mark All as Read
    const markAllReadBtn = document.getElementById('mark-all-read');
    if (markAllReadBtn) {
      markAllReadBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const url = `{{ route('notifications.markAllAsRead') }}`;

        fetch(url, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}',
              'Accept': 'application/json',
              'Content-Type': 'application/json'
            }
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              document.querySelectorAll('.mark-as-read').forEach(el => el.remove());
              const badge = document.querySelector('.headerBadge1');
              if (badge) badge.remove();
              document.querySelector('[data-feather="bell"]').classList.remove('bell');
              document.querySelector('.dropdown-list-icons').innerHTML =
                '<p class="text-muted text-center p-3">No new notifications</p>';
            }
          });
      });
    }
  });
</script>