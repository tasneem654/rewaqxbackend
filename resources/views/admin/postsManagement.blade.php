<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Posts Management</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Quicksand:wght@600;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('css/postsManagement.css') }}" />
  <script src="https://unpkg.com/feather-icons"></script>
  <!-- Favicon -->
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
    <h1>Posts Management</h1>
      <div class="actions">
        <div class="action-buttons">
          <form id="deleteForm" method="POST" action="{{ route('admin.posts.delete') }}">
            @csrf
            <input type="hidden" name="post_ids[]" id="postIdsInput">
            <button type="button" class="remove-btn" id="deleteBtn">
              <i data-feather="trash-2"></i>&nbsp;&nbsp; Delete Post
            </button>
          </form>
        </div>
      </div>

      <div class="table-wrapper">
        <img src="{{ asset('images/Group 42251 left.png') }}" alt="Previous" class="arrow left-arrow">
        <table>
          <thead>
            <tr>
              <th></th>
              <th>Post ID</th>
              <th>Created by</th>
              <th>Content</th>
              <th>Image</th>
              <th>Created on</th>
              <th>Reactions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($posts as $post)
            <tr class="{{ $loop->first ? 'first-row' : '' }}">
              <td>
                <input type="checkbox" class="post-checkbox" value="{{ $post['id'] ?? '' }}" />
              </td>
              <td>{{ $post['id'] ?? '—' }}</td>
              <td>{{ $post['user_name'] ?? 'Unknown' }}</td>
              <td>{{ \Illuminate\Support\Str::limit($post['content'] ?? '', 20) }}</td>
              <td>
                @if(!empty($post['image']))
                  <a href="{{ $post['image_full'] ?? '#' }}" target="_blank">{{ $post['image'] }}</a>
                @else
                  No Image
                @endif
              </td>
              <td>{{ $post['created_at'] ?? '—' }}</td>
              <td>{{ $post['reactions_count'] ?? 0 }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <img src="{{ asset('images/Group 42251.png') }}" alt="Next" class="arrow right-arrow">
      </div>
    </section>
  </main>

  <script>
    feather.replace();

    document.addEventListener('DOMContentLoaded', function () {
      const checkboxes = document.querySelectorAll('.post-checkbox');
      const postIdsInput = document.getElementById('postIdsInput');
      const deleteBtn = document.getElementById('deleteBtn');
      const deleteForm = document.getElementById('deleteForm');

      deleteBtn.addEventListener('click', function () {
        const selected = Array.from(checkboxes)
          .filter(cb => cb.checked)
          .map(cb => cb.value);

        if (selected.length === 0) {
          alert('Please select at least one post to delete.');
          return;
        }

        if (confirm('Are you sure you want to delete the selected post(s)?')) {
          // Clear existing hidden inputs if any
          document.querySelectorAll('#deleteForm input[name="post_ids[]"]').forEach(el => el.remove());

          // Add one hidden input for each post ID
          selected.forEach(id => {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'post_ids[]';
            hiddenInput.value = id;
            deleteForm.appendChild(hiddenInput);
          });

          deleteForm.submit();
        }
      });
    });
  </script>
   <script>
    // JavaScript for handling dropdown menu
    const dropdownToggle = document.getElementById('dropdown-toggle');
    const dropdownMenu = document.getElementById('dropdown-menu');

    // Toggle dropdown menu visibility
    dropdownToggle.addEventListener('click', () => {
      dropdownMenu.style.display = (dropdownMenu.style.display === 'block') ? 'none' : 'block';
    });

    
  </script>
</body>
</html>
