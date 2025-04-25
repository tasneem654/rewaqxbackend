<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Quicksand:wght@600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" />
  <script src="https://unpkg.com/feather-icons"></script>
  <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png" />
</head>
<body>
  <header>
    <div class="header-container">
      <div class="logo">
        <img src="{{ asset('images/logo.svg') }}" alt="RewaqX" />
      </div>
      <div class="user-profile">
        <img src="{{ asset('images/user-circle-2.png') }}" alt="Admin" class="profile-img" />
        <span>Admin</span>
        <img id="dropdown-toggle" src="{{ asset('images/Chevron left.png') }}" alt="Dropdown" class="dropdown-icon" />
        <!-- Dropdown Menu -->
        <div id="dropdown-menu" class="dropdown-menu">
          <a href="{{ route('logout') }}">Log out</a>
        </div>
      </div>
    </div>
  </header>

  <main>
  <aside class="sidebar">
  <nav>
    <ul>
    <!-- Dashboard -->
      <li>
        <a href="{{ route('admin.dashboard') }}"
           class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
          <img src="{{ asset('images/Home.png') }}" alt="Dashboard" class="icon"/>
          <span>Dashboard</span>
        </a>
      </li>
      
    <!-- Employees Management  -->
      <li>
        <a href="{{ route('employees.index') }}"
           class="{{ request()->routeIs('employees.*') ? 'active' : '' }}">
          <img src="{{ asset('images/user icon.png') }}" alt="Employees Management" class="icon"/>
          <span>Employees Management</span>
        </a>
      </li>

    <!-- Posts Management  -->
      <li>
        <a href="{{ route('posts.management') }}"
           class="{{ request()->routeIs('posts.management') ? 'active' : '' }}">
          <img src="{{ asset('images/Message.png') }}" alt="Posts Management" class="icon"/>
          <span>Posts Management</span>
        </a>
      </li>
    </ul>
  </nav>
</aside>


    <section class="content">
      <div class="actions">
        <h1 class="dashboard-heading">Dashboard</h1>
      </div>

      <!-- Metrics Cards -->
      <div class="metrics-cards">
      <div class="card">
      <div class="card-icon">
            <img src="{{ asset('images/user.png') }}" alt="Employees" class="icon-img">
        </div>
        <div class="card-info">
            <span>Total Employees</span>
            <strong>{{ $totalUsers }}</strong>
          </div>
        </div>
        <div class="card">
          <div class="card-icon">  
            <img src="{{ asset('images/paper-plane.png') }}" alt="Posts" class="icon-img">
        </div>
        <div class="card-info">
            <span>Total Posts</span>
            <strong>{{ $totalPosts }}</strong>
          </div>
        </div>
        <div class="card">
        <div class="card-icon">
            <img src="{{ asset('images/heart.png') }}" alt="Reactions" class="icon-img">
        </div>
        <div class="card-info">
            <span>Total Reactions</span>
            <strong>{{ $totalReactions }}</strong>
          </div>
        </div>
        <div class="card">
        <div class="card-icon">
            <img src="{{ asset('images/comment.png') }}" alt="Comments" class="icon-img">
        </div>
        <div class="card-info">
            <span>Total Comments</span>
            <strong>{{ $totalComments }}</strong>
          </div>
        </div>
      </div>

      <div class="dashboard-content">
      <!-- Active Users Percentage -->
      <div class="circle-status-box">
  <div class="circle-header">
    <h3>Employees</h3>
    <form method="GET" action="{{ url()->current() }}" style="display:inline;">
    <label for="month" class="circle-label">Show:</label>
      <select name="month" class="circle-period" onchange="this.form.submit()">
        <option value="current" {{ (request('month','current')=='current') ? 'selected' : '' }}>
          This month
        </option>
        <option value="1" {{ request('month')=='1' ? 'selected' : '' }}>January 2025</option>
        <option value="2" {{ request('month')=='2' ? 'selected' : '' }}>February 2025</option>
        <option value="3" {{ request('month')=='3' ? 'selected' : '' }}>March 2025</option>
        <option value="4"  {{ request('month')=='4'  ? 'selected' : '' }}>April 2025</option>
        <option value="5"  {{ request('month')=='5'  ? 'selected' : '' }}>May 2025</option>
        <option value="6"  {{ request('month')=='6'  ? 'selected' : '' }}>June 2025</option>
        <option value="7"  {{ request('month')=='7'  ? 'selected' : '' }}>July 2025</option>
        <option value="8"  {{ request('month')=='8'  ? 'selected' : '' }}>August 2025</option>
        <option value="9"  {{ request('month')=='9'  ? 'selected' : '' }}>September 2025</option>
        <option value="10" {{ request('month')=='10' ? 'selected' : '' }}>October 2025</option>
        <option value="11" {{ request('month')=='11' ? 'selected' : '' }}>November 2025</option>
        <option value="12" {{ request('month')=='12' ? 'selected' : '' }}>December 2025</option>
      </select>
    </form>
  </div>

  <div class="circle-chart">
    <svg viewBox="0 0 36 36" class="circular-chart">
      <!-- Background circle -->
      <path
        class="circle-bg"
        d="M18 2.0845
           a 15.9155 15.9155 0 0 1 0 31.831
           a 15.9155 15.9155 0 0 1 0 -31.831" />
      <!-- Active slice -->
      <path
        class="circle-active"
        stroke-dasharray="{{ $activePercentage }}, 100"
        stroke-linecap="round"
        d="M18 2.0845
           a 15.9155 15.9155 0 0 1 0 31.831
           a 15.9155 15.9155 0 0 1 0 -31.831" />
      <!-- Percentage text -->
      <text
        x="18"
        y="18"
        class="percentage-text"
        text-anchor="middle"
        dominant-baseline="central">
        {{ $activePercentage }}%
      </text>
    </svg>

    <div class="circle-legend">
      <span><span class="dot active-dot"></span> Active</span>
      <span><span class="dot inactive-dot"></span> Inactive</span>
    </div>
  </div>
</div>

<!-- Users points List -->
<div class="list-users">
    <h3>Distribution of Points</h3>
    <ul>
        @foreach($users as $user)
            <li class="user-entry">
                <img src="{{ $user->profile->image ?? asset('images/default-user.png') }}" alt="Image">
                <div class="user-details">
                    <strong>{{ $user->profile->name ?? 'No Name' }}</strong><br>
                    <span>{{ $user->profile->role ?? 'No Role' }} - {{ $user->profile->department ?? 'No Department' }}</span>
                </div>
                <span class="points">{{ $user->points->totalPoints ?? 0 }} points</span>
            </li>
        @endforeach
    </ul>
</div>
</div>
      <!-- Community Engagement Chart -->
      <div class="chart-container">
        <canvas id="communityEngagementChart"></canvas>
      </div>



    </section>
  </main>
  <script>
    // JavaScript for handling dropdown menu
    const dropdownToggle = document.getElementById('dropdown-toggle');
    const dropdownMenu = document.getElementById('dropdown-menu');

    // Toggle dropdown menu visibility
    dropdownToggle.addEventListener('click', () => {
      dropdownMenu.style.display = (dropdownMenu.style.display === 'block') ? 'none' : 'block';
    });

    
  </script>

  <script>feather.replace();</script>
</body>
</html>
