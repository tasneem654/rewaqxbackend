<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Employees Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Quicksand:wght@600;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />
    <script src="https://unpkg.com/feather-icons"></script>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png" />
    <style>
        /* Action buttons */
        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .edit-btn, .delete-btn, .upload-btn {
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 14px;
            text-decoration: none;
        }

        .edit-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
        }

        .delete-btn {
            background-color: #f44336;
            color: white;
            border: none;
        }

        .upload-btn {
            background-color: #2AD2C9;
            color: white;
            border: none;
        }

        /* Table styles */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        /* Image styles */
        .profile-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ddd;
        }

        .image-upload-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .image-upload-input {
            display: none;
        }

        /* Popup styles */
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            z-index: 1001;
            width: 400px;
            max-width: 90%;
        }

        .popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.5);
            z-index: 1000;
        }

        .popup-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .popup form div {
            margin-bottom: 15px;
        }

        .popup label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }

        .popup input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #4CAF50;
        }
    </style>
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
      <h1>Employees Management</h1>

      <div class="actions">
        <form method="GET" action="{{ route('employees.index') }}" class="actions mb-4">
          <div class="search-container">
              <i data-feather="search" class="search-icon"></i>
              <input 
                  type="text" 
                  name="search" 
                  value="{{ request('search') }}"
                  class="search-bar" 
                  placeholder="Search"
              />
          </div>
      </form>
      
        <div class="action-buttons">
          <button class="remove-btn" id="removeBtn"><i data-feather="trash-2"></i>&nbsp;&nbsp; Remove Employee</button>
          <button class="add-btn" onclick="openPopup()">+ Add New Employee</button>
        </div>
      </div>

      <!-- Employee Table -->
      <div class="table-wrapper">
        <table>
          <thead>
            <tr>
              <th><input type="checkbox" class="employee-checkbox" /></th>
              <th>ID</th>
              <th>Image</th>
              <th>Name</th>
              <th>Email</th>
              <th>Department</th>
              <th>Role</th>
              <th>Date of Birth</th>
              <th>Points</th>
              <th>Manager</th>
            </tr>
          </thead>
          <tbody>
            @foreach($employees as $employee)
            <tr>
              <td><input type="checkbox" class="employee-checkbox" /></td>
              <td>{{ $employee->id }}</td>
              <td>
                <div class="image-upload-container">
                  <img src="{{ optional($employee->profile)->image ? asset('storage/' . $employee->profile->image) : asset('images/profile_images/default-profile.png') }}" 
                       alt="Profile Image" 
                       class="profile-image"
                       id="image-{{ $employee->id }}">
                  <button class="upload-btn" onclick="document.getElementById('file-input-{{ $employee->id }}').click()">
                    <i data-feather="upload"></i> Change
                  </button>
                  <input type="file" 
                         id="file-input-{{ $employee->id }}" 
                         class="image-upload-input" 
                         accept="image/*"
                         onchange="uploadImage({{ $employee->id }}, this)">
                </div>
              </td>
              <td>{{ optional($employee->profile)->name ?? 'N/A' }}</td>
              <td>{{ $employee->email }}</td>
              <td>{{ optional($employee->profile)->department ?? 'N/A' }}</td>
              <td>{{ optional($employee->profile)->role ?? 'N/A' }}</td>
              <td>
                @if(optional($employee->profile)->dateOfBirth)
                  {{ \Carbon\Carbon::parse($employee->profile->dateOfBirth)->format('Y-m-d') }}
                @else
                  N/A
                @endif
              </td>
              <td>{{ optional($employee->points)->totalPoints ?? 0 }}</td>

              <td>
                <label class="switch">
                  <input type="checkbox" 
                         class="manager-toggle" 
                         data-user-id="{{ $employee->id }}" 
                         {{ $employee->isManager ? 'checked' : '' }}>
                  <span class="slider"></span>
                </label>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </section>
  </main>

  <!-- Popup Form for Adding New Employee -->
  <div class="popup-overlay" id="popupOverlay"></div>
  <div class="popup" id="popupForm">
    <h2>Add New Employee</h2>
    <form method="POST" action="{{ route('employees.store') }}" enctype="multipart/form-data">
      @csrf
      <div>
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" required />
      </div>
      <div>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required />
      </div>
      <div>
        <label for="dateOfBirth">Date of Birth</label>
        <input type="date" id="dateOfBirth" name="dateOfBirth" required />
      </div>
      <div>
        <label for="department">Department</label>
        <input type="text" id="department" name="department" required />
      </div>
      <div>
        <label for="role">Role</label>
        <input type="text" id="role" name="role" required />
      </div>
      <div>
        <label for="points">Initial Points</label>
        <input type="number" id="points" name="points" value="0" min="0" />
      </div>
      <div>
        <label for="image">Profile Image</label>
        <input type="file" id="image" name="image" accept="image/*" />
      </div>
      <div class="popup-buttons">
        <button type="submit" class="add-btn">Add Employee</button>
        <button type="button" class="cancel-btn" onclick="closePopup()">Cancel</button>
      </div>
    </form>
  </div>

  <!-- Edit Employee Popup -->
  <div class="popup" id="editPopupForm">
    <h2>Edit Employee</h2>
    <form method="POST" id="editEmployeeForm" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <div>
        <label for="edit_name">Name</label>
        <input type="text" id="edit_name" name="name" required />
      </div>
      <div>
        <label for="edit_email">Email</label>
        <input type="email" id="edit_email" name="email" required />
      </div>
      <div>
        <label for="edit_dateOfBirth">Date of Birth</label>
        <input type="date" id="edit_dateOfBirth" name="dateOfBirth" required />
      </div>
      <div>
        <label for="edit_department">Department</label>
        <input type="text" id="edit_department" name="department" required />
      </div>
      <div>
        <label for="edit_role">Role</label>
        <input type="text" id="edit_role" name="role" required />
      </div>
      <div>
        <label for="edit_image">Profile Image</label>
        <input type="file" id="edit_image" name="image" accept="image/*" />
        <img id="edit_image_preview" src="" style="max-width: 100px; margin-top: 10px; display: none;">
      </div>
      <div class="popup-buttons">
        <button type="submit" class="save-btn">Save Changes</button>
        <button type="button" class="cancel-btn" onclick="closeEditPopup()">Cancel</button>
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

  <script>
    feather.replace();

    // Image Upload Functionality
    function uploadImage(userId, input) {
        if (input.files && input.files[0]) {
            const formData = new FormData();
            formData.append('image', input.files[0]);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

            const imageElement = document.getElementById(`image-${userId}`);
            const originalSrc = imageElement.src;

            // Show loading state
            imageElement.style.opacity = '0.5';

            fetch(`/employees/${userId}/update-image`, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    imageElement.src = data.image_url;
                    // Create a temporary event to force image reload
                    imageElement.src = data.image_url + '?' + new Date().getTime();
                } else {
                    throw new Error('Image upload failed');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                imageElement.src = originalSrc;
                alert('Error uploading image: ' + error.message);
            })
            .finally(() => {
                imageElement.style.opacity = '1';
                input.value = ''; // Reset file input
            });
        }
    }

    // Manager toggle functionality
    document.querySelectorAll('.manager-toggle').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const userId = this.dataset.userId;
            const isManager = this.checked;
            const originalState = !isManager;

            fetch(`/employees/${userId}/toggle-manager`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ isManager })
            })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                if (!data.success) {
                    this.checked = originalState;
                    throw new Error('Failed to update manager status');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.checked = originalState;
                alert(error.message);
            });
        });
    });

    // Edit popup image preview
    document.getElementById('edit_image')?.addEventListener('change', function(e) {
        const preview = document.getElementById('edit_image_preview');
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(this.files[0]);
        }
    });

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

    // Open edit popup
    function openEditPopup(employeeId) {
        fetch(`/employees/${employeeId}/edit`)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                document.getElementById('edit_name').value = data.name || '';
                document.getElementById('edit_email').value = data.email || '';
                document.getElementById('edit_dateOfBirth').value = data.dateOfBirth || '';
                document.getElementById('edit_department').value = data.department || '';
                document.getElementById('edit_role').value = data.role || '';
                
                const imagePreview = document.getElementById('edit_image_preview');
                if (data.image) {
                    imagePreview.src = data.image;
                    imagePreview.style.display = 'block';
                } else {
                    imagePreview.style.display = 'none';
                }
                
                document.getElementById('editEmployeeForm').action = `/employees/${employeeId}`;
                
                document.getElementById('popupOverlay').style.display = 'block';
                document.getElementById('editPopupForm').style.display = 'block';
                feather.replace();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error loading employee data');
            });
    }

    // Close edit popup
    function closeEditPopup() {
        document.getElementById('popupOverlay').style.display = 'none';
        document.getElementById('editPopupForm').style.display = 'none';
    }

    // Open confirmation popup when Remove button is clicked
    document.getElementById('removeBtn')?.addEventListener('click', function() {
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
    const selected = document.querySelectorAll('tbody input[type="checkbox"]:checked');
    
    if (selected.length === 0) {
        closeConfirmationPopup();
        return;
    }

    // Create an array of delete promises for each selected employee
    const deletePromises = Array.from(selected).map(checkbox => {
        const row = checkbox.closest('tr');
        const userId = row.querySelector('td:nth-child(2)').textContent; // Gets ID from 2nd column
        
        return fetch(`/employees/${userId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });
    });

    // Execute all delete requests
    Promise.all(deletePromises)
        .then(responses => {
            // Check if all deletions were successful
            const allSuccess = responses.every(response => response.ok);
            if (!allSuccess) throw new Error('Some deletions failed');
            
            // Reload the page to see changes
            window.location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting employees. Please check console for details.');
        })
        .finally(() => {
            closeConfirmationPopup();
        });
}
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