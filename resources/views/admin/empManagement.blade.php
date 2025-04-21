<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees Management</title>
    <!-- الربط بملفات CSS الخاصة بك -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Quicksand:wght@600;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body>
  <header>
    <div class="header-container">
      <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="RewaqX" />
      </div>
      <div class="user-profile">
        <img src="{{ asset('images/user-circle-2.png') }}" alt="Admin" class="profile-img" />
        <span>Admin</span>
        <img src="{{ asset('images/Chevron left.png') }}" alt="Dropdown" class="dropdown-icon" />
      </div>
    </div>
  </header>

  <main>
    <aside class="sidebar">
      <nav>
        <ul>
          <li><a href="#"><i data-feather="home"></i><span>Dashboard</span></a></li>
          <li><a href="#" class="active"><i data-feather="user"></i><span>Employees Management</span></a></li>
          <li><a href="#"><i data-feather="calendar"></i><span>Events Management</span></a></li>
          <li><a href="#"><i data-feather="message-square"></i><span>Posts Management</span></a></li>
        </ul>
      </nav>
    </aside>

    <section class="content">
      <h1>Employees Management</h1>

      <!-- Add New Employee Button -->
      <div class="actions">
        <div class="search-container">
          <i data-feather="search" class="search-icon"></i>
          <input type="text" class="search-bar" placeholder="Search" />
        </div>
        <div class="action-buttons">
          <button class="remove-btn"><i data-feather="trash-2"></i>&nbsp;&nbsp; Remove Employee</button>
          <button class="add-btn" onclick="openPopup()">+ Add New Employee</button>
        </div>
      </div>

      <!-- Employee Table -->
      <div class="table-wrapper">
        <img src="{{ asset('images/Group 42251.png') }}" alt="Previous" class="arrow left-arrow">
        <table>
          <thead>
            <tr>
              <th><input type="checkbox" /></th>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Department</th>
              <th>Role</th>
              <th>Manager</th>
            </tr>
          </thead>
          <tbody>
            @foreach($employees as $employee)
            <tr>
              <td><input type="checkbox" /></td>
              <td>{{ $employee->id }}</td>
              <td>{{ $employee->name }}</td>
              <td>{{ $employee->email }}</td>
              <td>{{ $employee->department ?? 'N/A' }}</td>
              <td>{{ $employee->role ?? 'N/A' }}</td>
              <td>
                <label class="switch">
                  <input type="checkbox" {{ $employee->is_manager ? 'checked' : '' }} />
                  <span class="slider"></span>
                </label>
              </td>
              <td>
                <a href="{{ route('employees.edit', $employee->id) }}">Edit</a>
                <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit">Delete</button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        <img src="{{ asset('images/Group 42251.png') }}" alt="Next" class="arrow right-arrow">
      </div>
    </section>
  </main>

  <!-- Popup Form for Adding New Employee -->
  <div class="popup-overlay" id="popupOverlay"></div>
  <div class="popup" id="popupForm">
    <h2>Add New Employee</h2>
    <form method="POST" action="{{ route('employees.store') }}">
      @csrf
      <div>
        <label for="name">Name</label>
        <input type="text" id="name" name="name" required />
      </div>
      <div>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required />
      </div>
      <div>
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required />
      </div>
      <button type="submit" class="add-btn">Add Employee</button>
      <button type="button" class="add-btn" onclick="closePopup()">Cancel</button>
    </form>
  </div>

  <script>
    feather.replace();

    function openPopup() {
      document.getElementById('popupOverlay').style.display = 'block';
      document.getElementById('popupForm').style.display = 'block';
    }

    function closePopup() {
      document.getElementById('popupOverlay').style.display = 'none';
      document.getElementById('popupForm').style.display = 'none';
    }
  </script>
</body>
</html>
