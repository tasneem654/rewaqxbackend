<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
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
          <li><a href="#"><i data-feather="home"></i><span>Dashboard</span></a></li>
          <li><a href="#" class="active"><i data-feather="user"></i><span>Employees Management</span></a></li>
          <li><a href="#"><i data-feather="calendar"></i><span>Events Management</span></a></li>
          <li><a href="#"><i data-feather="message-square"></i><span>Posts Management</span></a></li>
        </ul>
      </nav>
    </aside>

    <script>
      feather.replace();
    </script>

    <section class="content">
      <h1>Employees Management</h1>

      <div class="actions">
        <div class="search-container">
          <i data-feather="search" class="search-icon"></i>
          <input type="text" class="search-bar" placeholder="Search" />
        </div>
        <div class="action-buttons">
          <button class="remove-btn"><i data-feather="trash-2"></i>&nbsp;&nbsp; Remove Employee</button>
          <button class="add-btn"> +&nbsp;&nbsp;Add New Employee</button>
        </div>
      </div>

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
              <th>Manger</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><input type="checkbox" /></td>
              <td>4111813</td>
              <td>Arwa Ghelan</td>
              <td>4010552@upm.edu.sa</td>
              <td>Marketing Department</td>
              <td>Marketing Specialist</td>
              <td>
                <label class="switch">
                  <input type="checkbox" checked />
                  <span class="slider"></span>
                </label>
              </td>
            </tr>
            <tr>
              <td><input type="checkbox" /></td>
              <td>4111814</td>
              <td>John Doe</td>
              <td>4010553@upm.edu.sa</td>
              <td>Sales Department</td>
              <td>Sales Executive</td>
              <td>
                <label class="switch">
                  <input type="checkbox" />
                  <span class="slider"></span>
                </label>
              </td>
            </tr>
            <tr>
              <td><input type="checkbox" /></td>
              <td>4111815</td>
              <td>Salma Tariq</td>
              <td>4010554@upm.edu.sa</td>
              <td>HR Department</td>
              <td>HR Manager</td>
              <td>
                <label class="switch">
                  <input type="checkbox" />
                  <span class="slider"></span>
                </label>
              </td>
            </tr>
            <tr>
              <td><input type="checkbox" /></td>
              <td>4111816</td>
              <td>Omar Khalid</td>
              <td>4010555@upm.edu.sa</td>
              <td>IT Department</td>
              <td>Software Engineer</td>
              <td>
                <label class="switch">
                  <input type="checkbox" checked />
                  <span class="slider"></span>
                </label>
              </td>
            </tr>
            <tr>
              <td><input type="checkbox" /></td>
              <td>4111817</td>
              <td>Lina Saeed</td>
              <td>4010556@upm.edu.sa</td>
              <td>Marketing Department</td>
              <td>Marketing Specialist</td>
              <td>
                <label class="switch">
                  <input type="checkbox" />
                  <span class="slider"></span>
                </label>
              </td>
            </tr>
            <tr>
              <td><input type="checkbox" /></td>
              <td>4111818</td>
              <td>Faisal Ahmed</td>
              <td>4010557@upm.edu.sa</td>
              <td>Finance Department</td>
              <td>Accountant</td>
              <td>
                <label class="switch">
                  <input type="checkbox" />
                  <span class="slider"></span>
                </label>
              </td>
            </tr>
          </tbody>
        </table>
        <img src="{{ asset('images/Group 42251.png') }}" alt="Next" class="arrow right-arrow">
      </div>
    </section>
  </main>

  <script>
    feather.replace();
  </script>
</body>
</html>
