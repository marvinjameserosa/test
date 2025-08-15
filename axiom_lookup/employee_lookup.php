<!DOCTYPE html>
<html>
  <head>
    <title>Axiom Corp - Employee Lookup</title>
    <style>
      body {
        background-color: #0a0e17;
        color: #7eeeff;
        font-family: "Segoe UI", Arial, sans-serif;
        margin: 0;
        overflow-x: hidden;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
      }
      
      .grid-bg {
        position: fixed;
        width: 200%;
        height: 200%;
        background: linear-gradient(rgba(16, 24, 38, 0.2) 1px, transparent 1px),
          linear-gradient(90deg, rgba(16, 24, 38, 0.2) 1px, transparent 1px);
        background-size: 30px 30px;
        transform: rotate(45deg);
        z-index: 0;
        pointer-events: none;
      }

      .glow {
        position: fixed;
        width: 800px;
        height: 800px;
        border-radius: 50%;
        background: radial-gradient(
          circle,
          rgba(126, 238, 255, 0.05) 0%,
          rgba(10, 14, 23, 0) 70%
        );
        z-index: 0;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        pointer-events: none;
      }
      
      /* Main content area */
      .main-content {
        margin-left: 220px;
        padding: 20px;
        flex: 1;
        z-index: 1;
      }
      
      .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
      }

      h1 {
        font-size: 2em;
        font-weight: 400;
        color: white;
        letter-spacing: 1px;
        margin: 0;
      }
      
      .user-info {
        display: flex;
        align-items: center;
        color: #7aaac3;
      }

      .user-avatar {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background-color: #1c2a44;
        margin-right: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: white;
      }
      
      .lookup-container {
        background-color: #111927;
        border-radius: 8px;
        padding: 20px;
        border: 1px solid #1a2539;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
      }
      
      .lookup-container h2 {
        color: white;
        margin-top: 0;
        font-weight: 400;
        font-size: 1.5em;
      }
      
      .form-group {
        margin-bottom: 20px;
      }
      
      label {
        display: block;
        margin-bottom: 5px;
        color: #7aaac3;
      }
      
      input[type="text"] {
        width: 100%;
        padding: 10px;
        border-radius: 4px;
        border: 1px solid #1a2539;
        background-color: #0a0e17;
        color: #7eeeff;
        box-sizing: border-box;
        max-width: 400px;
      }
      
      button {
        padding: 10px 15px;
        background-color: #172338;
        color: #7eeeff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 1em;
        transition: background-color 0.3s;
      }
      
      button:hover {
        background-color: #1c2a44;
      }
      
      .employee-results {
        background-color: #111927;
        border-radius: 8px;
        padding: 20px;
        border: 1px solid #1a2539;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      }
      
      .employee-card {
        background-color: rgba(28, 42, 68, 0.5);
        border-radius: 4px;
        padding: 15px;
        margin-bottom: 10px;
        border-left: 3px solid #7eeeff;
      }
      
      .employee-card h3 {
        color: white;
        margin-top: 0;
        margin-bottom: 10px;
      }
      
      .employee-card p {
        margin: 5px 0;
        color: #7aaac3;
      }
      
      .employee-card p strong {
        color: #7eeeff;
      }
      
      .note {
        font-size: 0.9em;
        color: #536b87;
        margin-top: 15px;
        font-style: italic;
      }
      
      .secure-message {
        margin-top: 30px;
        padding: 15px;
        background-color: rgba(255, 0, 0, 0.1);
        border: 1px solid rgba(255, 0, 0, 0.3);
        border-radius: 4px;
        font-family: monospace;
        white-space: pre-wrap;
        font-size: 0.8em;
        color: #ff5858;
      }
    </style>
  </head>
  <body>
    <div class="grid-bg"></div>
    <div class="glow"></div>
    
    
    <!-- Main Content Area -->
    <div class="main-content">
      <div class="header">
        <h1>Employee Database</h1>
        <div class="user-info">
          <div class="user-avatar">A</div>
          <span>Admin</span>
          <button style="margin-left: 20px;" onclick="location.href='logout.php'">Logout</button>
        </div>
      </div>
      
      <?php
      // Employee lookup functionality - vulnerable to SQL injection
      $employeeData = null;
      $errorMessage = null;
      $showAllEmployees = false;
      
      if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['employee_id'])) {
          $employeeId = $_GET['employee_id'];
          
          // This is intentionally vulnerable to SQL injection!
          // In a real application, this would be parameterized
          
          // Simulating database with hardcoded results
          if (strpos($employeeId, "AX-778") !== false) {
              $employeeData = [
                  [
                       'id' => 'AX-778',
                      'name' => 'SEEN{Dr_Aris_Thorne}',
                      'position' => 'Director, Cybernaut Program',
                      'department' => 'Research & Development',
                      'clearance' => 'Level 5 - Alpha',
                      'location' => 'Facility 9, Sector C'
                  ]
              ];
          } elseif ($employeeId == "' OR '1'='1") {
              // SQL Injection simulation - returning all employees
              $showAllEmployees = true;
              $employeeData = [
                  [
                      'id' => 'AX-778',
                      'name' => 'SEEN{Dr_Aris_Thorne}',
                      'position' => 'Director, Cybernaut Program',
                      'department' => 'Research & Development',
                      'clearance' => 'Level 5 - Alpha',
                      'location' => 'Facility 9, Sector C'
                  ],
                  [
                      'id' => 'AX-425',
                      'name' => 'Dr. Elena Reyes',
                      'position' => 'Lead Researcher',
                      'department' => 'Research & Development',
                      'clearance' => 'Level 4 - Beta',
                      'location' => 'Facility 9, Sector B'
                  ],
                  [
                      'id' => 'AX-901',
                      'name' => 'Samuel Wolfe',
                      'position' => 'Chief Security Officer',
                      'department' => 'Security',
                      'clearance' => 'Level 5 - Alpha',
                      'location' => 'Facility 1, Sector A'
                  ]
              ];
          } else if (empty($employeeId)) {
              $errorMessage = "Please enter an employee ID.";
          } else {
              $errorMessage = "No employee found with ID: " . htmlspecialchars($employeeId);
          }
      }
      ?>
      
      <div class="lookup-container">
        <h2>Employee Lookup</h2>
        <form method="get" action="">
          <div class="form-group">
            <label for="employee_id">Employee ID:</label>
            <input type="text" id="employee_id" name="employee_id" placeholder="Enter employee ID (e.g., AX-123)" value="<?php echo isset($_GET['employee_id']) ? htmlspecialchars($_GET['employee_id']) : ''; ?>">
            <button type="submit">Search</button>
            
          </div>
          
        </form>
        <div class="note">Note: Search is case sensitive. Use format AX-### for standard IDs.</div>
        
      </div>
      
      
      <?php if ($errorMessage): ?>
        <div style="color: #ff5858; margin: 20px 0;"><?php echo $errorMessage; ?></div>
      <?php endif; ?>
      
      <?php if ($employeeData): ?>
        <div class="employee-results">
          <h2><?php echo $showAllEmployees ? 'All Employees' : 'Search Results'; ?></h2>
          
          <?php foreach ($employeeData as $employee): ?>
            <div class="employee-card">
              <h3><?php echo $employee['name']; ?> (<?php echo $employee['id']; ?>)</h3>
              <p><strong>Position:</strong> <?php echo $employee['position']; ?></p>
              <p><strong>Department:</strong> <?php echo $employee['department']; ?></p>
              <p><strong>Clearance Level:</strong> <?php echo $employee['clearance']; ?></p>
              <p><strong>Location:</strong> <?php echo $employee['location']; ?></p>
            </div>
          <?php endforeach; ?>
        </div>
        
      
      <?php endif; ?>
    </div>
  </body>
</html>
