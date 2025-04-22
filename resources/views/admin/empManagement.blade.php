<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees Management</title>
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
      <li><a href="#"><img src="{{ asset('images/Home.png') }}" alt="Dashboard" class="icon"/><span>Dashboard</span></a></li>
      <li><a href="#" class="active"><img src="{{ asset('images/user icon.png') }}" alt="Employees Management" class="icon"/><span>Employees Management</span></a></li>
      <li><a href="#"><img src="{{ asset('images/calendar.png') }}" alt="Events Management" class="icon"/><span>Events Management</span></a></li>
      <li><a href="#"><img src="{{ asset('images/Message.png') }}" alt="Posts Management" class="icon"/><span>Posts Management</span></a></li>
    </ul>
  </nav>
</aside>

    <section class="content">
      <h1>Employees Management</h1>

      <div class="actions">
        <div class="search-container">
          <i data-feather="search" class="search-icon"></i>
          <input type="text" class="search-bar" placeholder="Search" />
        </div>
        <div class="action-buttons">
          <button class="remove-btn" id="removeBtn"><i data-feather="trash-2"></i>&nbsp;&nbsp; Remove Employee</button>
          <button class="add-btn" onclick="openPopup()">+ Add New Employee</button>
        </div>
      </div>

      <!-- Employee Table -->
      <div class="table-wrapper">
        <img src="{{ asset('images/Group 42251 left.png') }}" alt="Previous" class="arrow left-arrow">
        <table>
          <thead>
            <tr>
              <th><input type="checkbox" class="employee-checkbox" /></th>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Department</th>
              <th>Role</th>
              <th>Manager</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><input type="checkbox" class="employee-checkbox" /></td>
              <td>1</td>
              <td>John Doe</td>
              <td>johndoe@example.com</td>
              <td>Marketing</td>
              <td>Marketing Specialist</td>
              <td>
  <label class="switch">
    <input type="checkbox" />
    <span class="slider"></span>
  </label>
</td>

            </tr>
            @foreach($employees as $employee)
            <tr>
              <td><input type="checkbox" class="employee-checkbox" /></td>
              <td>{{ $employee->id }}</td>
              <td>{{ $employee->name }}</td>
              <td>{{ $employee->email }}</td>
              <td>{{ $employee->department ?? 'N/A' }}</td>
              <td>{{ $employee->role ?? 'N/A' }}</td>
              <td>
  <label class="switch">
    <input type="checkbox" />
    <span class="slider"></span>
  </label>
</td>


              <td>
                <a href="{{ route('employees.edit', $employee->id) }}">Edit</a>
                <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline;" class="delete-form">
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
      <label for="id">ID</label>
      <input type="text" id="id" name="id" required />
    </div>
    <div>
      <label for="name">Name</label>
      <input type="text" id="name" name="name" required />
    </div>
    <div>
      <label for="email">Email</label>
      <input type="email" id="email" name="email" required />
    </div>
    <div>
      <label for="department">Department</label>
      <input type="text" id="department" name="department" required />
    </div>
    <div>
      <label for="role">Role</label>
      <input type="text" id="role" name="role" required />
    </div>
    <div class="popup-buttons">
  <button type="submit" class="add-btn">Add Employee</button>
  <button type="button" class="cancel-btn" onclick="closePopup()">Cancel</button>
</div>
  </form>
</div>

<!-- Popup: No employee selected -->
<div class="popup" id="noEmployeePopup">
  <h2>Please select at least one employee to delete.</h2>
  <div class="popup-buttons">
    <button class="cancel-btn" onclick="closeNoEmployeePopup()">OK</button>
  </div>
</div>

<!-- Popup: Confirm delete -->
<div class="popup" id="confirmationPopup">
  <h2>Are you sure you want to remove the selected employee(s)?</h2>
  <div class="popup-buttons">
    <button class="remove-btn" onclick="confirmRemove()">Yes</button>
    <button class="cancel-btn" onclick="closeConfirmationPopup()">Cancel</button>
  </div>
</div>

<!-- Background overlay -->
<div class="popup-overlay" id="popupOverlay"></div>


<script>
  feather.replace();

  // Open the "Add New Employee" popup
  function openPopup() {
    document.getElementById('popupOverlay').style.display = 'block';
    document.getElementById('popupForm').style.display = 'block';
  }

  // Close the "Add New Employee" popup
  function closePopup() {
    document.getElementById('popupOverlay').style.display = 'none';
    document.getElementById('popupForm').style.display = 'none';
  }

  // Open confirmation popup when Remove button is clicked
  document.getElementById('removeBtn').addEventListener('click', function () {
  const selected = document.querySelectorAll('tbody input[type="checkbox"]:checked');
  if (selected.length === 0) {
    document.getElementById('popupOverlay').style.display = 'block';
    document.getElementById('noEmployeePopup').style.display = 'block';
  } else {
    document.getElementById('popupOverlay').style.display = 'block';
    document.getElementById('confirmationPopup').style.display = 'block';
  }
});

function closeNoEmployeePopup() {
  document.getElementById('popupOverlay').style.display = 'none';
  document.getElementById('noEmployeePopup').style.display = 'none';
}

function closeConfirmationPopup() {
  document.getElementById('popupOverlay').style.display = 'none';
  document.getElementById('confirmationPopup').style.display = 'none';
}

function confirmRemove() {
  document.querySelectorAll('tbody input[type="checkbox"]:checked').forEach(function (checkbox) {
    checkbox.closest('tr').querySelector('form').submit();
  });
  closeConfirmationPopup();
}

</script>

</body>
</html>
