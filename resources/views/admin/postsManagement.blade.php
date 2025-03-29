<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Posts Management</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Quicksand:wght@600;700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="{{ asset('css/postsManagement.css') }}" />
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
          <li><a href="#"><i data-feather="user"></i><span>Employees Management</span></a></li>
          <li><a href="#"><i data-feather="calendar"></i><span>Events Management</span></a></li>
          <li><a href="#" class="active"><i data-feather="message-square"></i><span>Posts Management</span></a></li>
        </ul>
      </nav>
    </aside>

    <section class="content">
      <div class="actions">
        <h1>Posts Management</h1>
        <div class="action-buttons">
          <button class="remove-btn"><i data-feather="trash-2"></i>&nbsp;&nbsp; Delete Post</button>
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
            <tr class="first-row">
              <td><input type="checkbox"/></td>
              <td>2354</td>
              <td>Arwa Ghelan</td>
              <td>Just secured the ...</td>
              <td>photo.jpg</td>
              <td>March 23, 2024</td>
              <td>84</td>
            </tr>
            <tr>
              <td><input type="checkbox" /></td>
              <td>2334</td>
              <td>Arwa Ghelan</td>
              <td>Just secured the ...</td>
              <td>photo.jpg</td>
              <td>March 23, 2024</td>
              <td>84</td>
            </tr>
            <!-- Repeat more rows as needed -->
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
