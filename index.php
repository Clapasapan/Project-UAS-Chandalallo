<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Cla Preloved</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Quicksand:wght@400;600&display=swap" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    body {
      background-color: #d6eaff; /* soft blue pastel */
      font-family: 'Quicksand', sans-serif;
      color: #333;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 20px;
    }

    h1 {
      font-family: 'Pacifico', cursive;
      font-size: 3.8rem;
      background: linear-gradient(90deg, #6ec5ff, #a1c4fd);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      animation: fadeInDown 1s ease;
      margin-bottom: 40px;
    }

    .btn-soft-blue, .btn-soft-lavender {
      padding: 12px 30px;
      border-radius: 12px;
      font-weight: 600;
      font-size: 1.1rem;
      text-decoration: none;
      transition: 0.3s ease;
      display: inline-block;
      margin: 10px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.12);
    }

    .btn-soft-blue {
      background-color: #a1c4fd;
      color: #fff;
    }

    .btn-soft-blue:hover {
      background-color: #7ebcfa;
      color: #fff;
    }

    .btn-soft-lavender {
      background-color: #d0bdf4;
      color: #fff;
    }

    .btn-soft-lavender:hover {
      background-color: #b99ff9;
      color: #fff;
    }

    @keyframes fadeInDown {
      from {
        opacity: 0;
        transform: translateY(-40px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
  </style>
</head>
<body>

  <h1>Cla Preloved</h1>

  <div>
    <a href="login.php" class="btn-soft-blue">Login Admin</a>
    <a href="login_pembeli.php" class="btn-soft-blue">Login Pembeli</a>
    <a href="register_pembeli.php" class="btn-soft-lavender">Register Pembeli</a>
  </div>

</body>
</html>
