<?php require_once("db-connect.php"); ?>
<?php require_once("function.php"); ?>
<?php
if (isset($_GET['id'])) {
    $query = $conn->query("SELECT * FROM `posts` where id = '{$_GET['id']}'");
    if ($query->num_rows > 0) {
        $data = $query->fetch_array();
        $data['title'] = (htmlspecialchars_decode($data['title']));
        $data['content'] = (htmlspecialchars_decode($data['content']));
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css"
        integrity="sha512-ngQ4IGzHQ3s/Hh8kMyG4FC74wzitukRMIcTOoKT3EyzFZCILOPF0twiXOQn75eDINUfKBYmzYn2AA8DkAk8veQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js"
        integrity="sha512-6F1RVfnxCprKJmfulcxxym1Dar5FsT/V2jiEUvABiaEiFWoQ8yHvqRM/Slf0qJKiwin6IDQucjXuolCfCKnaJQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        html,
        body {
            min-height: 100%;
            width: 100%;
        }
    </style>
</head>

<body>

    <div class="container-fluid px-5 my-3 h-75">
        <div class="col-lg-8 col-md-10 col-sm-12 mx-auto my-5">
            <div class="d-flex justify-content-end">
                <a href="index.php" class="btn btn-flat btn-light border-dark rounded-0" id="post_btn">Yza dolanmak</a>
            </div>
            <hr>
            <div class="card rounde-0 shadow">
                <div class="card-body rounded-0">
                    <div class="container-fluid">
                        <h2 class="text-center fw-bold">
                            <?= isset($data['title']) ? $data['title'] : '' ?>
                        </h2>
                        <hr>
                        <p>
                            <?= isset($data['content']) ? display_content($data['content']) : '' ?>
                        </p>
                        <div class="my-1 d-flex w-100 justify-content-end lh-1">
                            <small class="text-muted">Goýulan senesi:
                                <?= isset($data['date_added']) ? date("M d,Y g:i A", strtotime($data['date_added'])) : '' ?>
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
</script>

</html>
