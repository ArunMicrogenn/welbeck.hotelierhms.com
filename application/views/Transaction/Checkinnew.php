<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Hotel Check-In</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f5f6fa; }
    .sidebar {
      background-color: #0c1b2a;
      min-height: 100vh;
      padding-top: 1rem;
    }
    .sidebar .nav-link {
      color: #fff;
      text-align: center;
      margin-bottom: 1rem;
    }
    .room-list .btn { margin: 0.2rem; }
    .form-section {
      background: #fff;
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .btn-gold {
      background-color: #c4a000;
      color: white;
    }
  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-1 sidebar d-none d-md-block">
      <div class="nav flex-column text-center">
        <a class="nav-link" href="#">🏠</a>
        <a class="nav-link" href="#">👤</a>
        <a class="nav-link" href="#">🛏️</a>
        <a class="nav-link" href="#">🖨️</a>
        <a class="nav-link" href="#">📄</a>
      </div>
    </div>

    <!-- Main Content -->
    <div class="col-md-11 p-4">
      <h5 class="mb-4">Rooms > Status > Check-In</h5>

      <div class="mb-3">
        <strong>Select Room:</strong>
        <div class="d-flex flex-wrap room-list">
          <?php
          $rooms = [101, 102, 104, 105, 106, 112, 113, 114, 115, 117, 118, 120];
          foreach ($rooms as $room) {
            echo "<button class='btn btn-outline-success btn-sm'>$room</button>";
          }
          ?>
        </div>
      </div>

      <!-- Check-In Form -->
      <form action="process_checkin.php" method="POST" enctype="multipart/form-data">
        
        <!-- Check-In Info -->
        <div class="form-section row g-3">
          <h6>Check-In</h6>
          <div class="col-md-3">
            <label>In-Date</label>
            <input type="date" name="in_date" class="form-control" required>
          </div>
          <div class="col-md-3">
            <label>Exp-Date</label>
            <input type="date" name="exp_date" class="form-control" required>
          </div>
          <div class="col-md-2">
            <label>Nights</label>
            <input type="number" name="nights" class="form-control" min="1" required>
          </div>
          <div class="col-md-2">
            <label>Room No</label>
            <input type="text" name="room_no" value="102" class="form-control" readonly>
          </div>
        </div>

        <!-- Room Details -->
        <div class="form-section row g-3">
          <h6>Room Details</h6>
          <div class="col-md-3">
            <label>Room Type</label>
            <input type="text" name="room_type" class="form-control" required>
          </div>
          <div class="col-md-3">
            <label>Rate Type</label>
            <input type="text" name="rate_type" class="form-control" required>
          </div>
          <div class="col-md-2">
            <label>Male</label>
            <input type="number" name="male" class="form-control" min="0" value="0">
          </div>
          <div class="col-md-2">
            <label>Female</label>
            <input type="number" name="female" class="form-control" min="0" value="0">
          </div>
          <div class="col-md-2">
            <label>Child</label>
            <input type="number" name="child" class="form-control" min="0" value="0">
          </div>
          <div class="col-md-2">
            <label>Total Pax</label>
            <input type="number" name="pax" class="form-control" min="1" required>
          </div>
          <div class="col-md-2 d-flex align-items-end">
            <button type="button" class="btn btn-warning w-100">Dynamic Tariff</button>
          </div>
        </div>

        <!-- Guest Details -->
        <div class="form-section row g-3">
          <h6>Guest Details</h6>
          <div class="col-md-2">
            <label>Title</label>
            <select name="title" class="form-control">
              <option>Mr</option>
              <option>Mrs</option>
              <option>Ms</option>
              <option>Dr</option>
            </select>
          </div>
          <div class="col-md-3">
            <label>First Name</label>
            <input type="text" name="first_name" class="form-control" required>
          </div>
          <div class="col-md-3">
            <label>Last Name</label>
            <input type="text" name="last_name" class="form-control" required>
          </div>
          <div class="col-md-4">
            <label>Mobile</label>
            <input type="text" name="mobile" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label>Email</label>
            <input type="email" name="email" class="form-control">
          </div>
          <div class="col-md-6">
            <label>Address</label>
            <textarea name="address" class="form-control" rows="2"></textarea>
          </div>
        </div>

        <!-- ID Proof -->
        <div class="form-section row g-3">
          <h6>ID Proof</h6>
          <div class="col-md-3">
            <label>ID Type</label>
            <input type="text" name="id_type" class="form-control" required>
          </div>
          <div class="col-md-3">
            <label>ID Number</label>
            <input type="text" name="id_number" class="form-control" required>
          </div>
          <div class="col-md-3">
            <label>ID Photo</label>
            <input type="file" name="id_photo" class="form-control" accept="image/*">
          </div>
        </div>

        <!-- Submit Buttons -->
        <div class="form-section text-end">
          <button type="reset" class="btn btn-outline-secondary">Cancel</button>
          <button type="submit" class="btn btn-gold">Check-In</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
