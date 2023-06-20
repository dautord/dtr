<?php
include 'header/main_header.php';
include 'sidebar/main_sidebar.php';

// Fetch all bulletin board items
$conn = new class_model();
$bulletins = $conn->getAllBulletins();

// Add new bulletin
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];

    // Move uploaded image to the desired location
    move_uploaded_file($image_tmp, "images/$image");

    // Add the bulletin to the database
    $conn->addBulletin($title, $content, $image);
    
    // Redirect to the bulletin board page
    header("Location: bulletin_board.php");
    exit();
  }
}
?>

<html>
<head>
  <style>
    .slideshow-container {
      max-width: 1000px;
      position: relative;
      margin: auto;
    }

    .slide {
      display: none;
      text-align: center;
    }

    .slide img {
      max-width: 100%;
      height: auto;
    }

    .slide-caption {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: rgba(0, 0, 0, 0.7);
      color: #fff;
      padding: 10px;
    }

    .slide-caption h2 {
      font-size: 24px;
      margin-bottom: 10px;
    }

    .slide-caption p {
      font-size: 16px;
      margin-bottom: 0;
    }
  </style>
</head>
<body>
  <div class="content-wrapper">
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Bulletin Board</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Bulletin Board</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-8">
            <div class="slideshow-container">
              <?php foreach ($bulletins as $bulletin): ?>
                <div class="slide">
                  <img src="images/<?php echo $bulletin['image']; ?>" alt="Slideshow Image">
                  <div class="slide-caption">
                    <h2><?php echo $bulletin['title']; ?></h2>
                    <p><?php echo $bulletin['content']; ?></p>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="col-md-4 offset-md-4">
            <h2>Add New Bulletin</h2>
            <form method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" name="title" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="content">Content:</label>
                <textarea name="content" class="form-control" required></textarea>
              </div>
              <div class="form-group">
                <label for="image">Image:</label>
                <input type="file" name="image" required>
              </div>
              <button type="submit" name="submit" class="btn btn-primary">Add Bulletin</button>
            </form>
          </div>

        </div>
      </div>
    </section>
  </div>

  <script>
    var slideIndex = 0;
    showSlides();

    function showSlides() {
      var slides = document.getElementsByClassName("slide");
      for (var i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
      }
      slideIndex++;
      if (slideIndex > slides.length) {
        slideIndex = 1;
      }
      slides[slideIndex - 1].style.display = "block";
      setTimeout(showSlides, 5000); // Change slide every 5 seconds
    }
  </script>
</body>
</html>
