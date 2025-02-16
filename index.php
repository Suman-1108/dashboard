<?php
    $page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
?>
<!DOCTYPE html method="POST">
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard</title>
        <!-- Style  -->
        <link rel="stylesheet" href="style.css">
        <!-- fontAwnsome -->
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
        <!-- links -->

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
        <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous"> -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"> 
        <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.bootstrap5.css"> 
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css"> 
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css" > 
        <!-- script file -->

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Bootstrap JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/json2/20160511/json2.min.js" integrity="sha512-uWk2ZXl3GVrq6DZsrL5dSg1S/F3MNQ9VaDFigqXOoKUnWG58UxOuJGfTrzh5KjpoBvPiFniL2PahU2HUTFMJXw=="crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>  -->
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script> 
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script> 
        <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.1.8/js/dataTables.bootstrap5.js"></script>  
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> 

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.css">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>


    </head>
    <body>
        <div class="navbar">
            <?php include 'navbar.php'; ?>
        </div>
        <div class="dashboard">
            <?php include 'sidebar.php'; ?>
            <div class="content">
                <?php
                    $content_file = "content/$page.php";
                    if (file_exists($content_file)) {
                        include $content_file;
                    } else {
                        echo "<h1>404 - Page Not Found</h1>";
                    }
                ?>
            </div>
        </div>
    </body>
</html>