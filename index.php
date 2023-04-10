<?php require_once("db-connect.php") ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css"
        integrity="sha512-ZbehZMIlGA8CTIOtdE+M81uj3mrcgyrh6ZFeG33A4FHECakGrOsTPlPQ8ijjLkxgImrdmSVUHn1j+ApjodYZow=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"
        integrity="sha512-lVkQNgKabKsM1DA/qbhJRFQU8TuwkLF2vSN3iU/c7+iayKs08Y8GXqfFxxTZr1IcpMovXnf2N/ZZoMgmZep1YQ=="
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
        <div class="col-lg-10 col-md-11 col-sm-12 mx-auto my-5">
            <div class="d-flex justify-content-end">
                <button class="btn btn-flat btn-primary rounded-0" id="post_btn">Täze habar ibermek</button>
            </div>
            <hr>
            <div class="list-group">
                <?php
                $query = $conn->query("SELECT * FROM `posts` order by abs(unix_timestamp(`date_added`)) desc");
                while ($row = $query->fetch_assoc()):
                    $content = strip_tags(htmlspecialchars_decode($row['content']));
                    ?>
                    <a href="view_post.php?id=<?= $row['id'] ?>"
                        class="list-group-item list-group-item-action text-decoration-none text-dark">
                        <div class="lh-1 d-flex w-100 justify-content-between align-items-center">
                            <div class="col-auto col-shrink-1 col-grow-1">
                                <h3 class="fw-bold">
                                    <?= htmlspecialchars_decode($row['title']) ?>
                                </h3>
                            </div>
                            <div class="col-auto">
                                <small class="text-muted">Ugradylan senesi:
                                    <?= date("M d, Y g:i A", strtotime($row['date_added'])) ?>
                                </small>
                            </div>
                        </div>
                        <hr>
                        <p>
                            <!-- bärde habar 0 dan başlap 623 harpy görkezýär -->
                            <?= substr($content, 0, 623) . (strlen($content) > 623 ? "..." : '') ?>
                        </p>
                    </a>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
    <!-- Form Modal -->
    <div class="modal fade" id="formModal" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog rounded-0 modal-xl modal-fullscreen-md-down modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-">
                    <h5 class="modal-title">Täze habar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body rounded-">
                    <div class="container-fluid">
                        <form action="save_post.php" id="new_form" method="POST">
                            <div class="mb-3">
                                <label for="title" class="form-label">Ady</label>
                                <textarea name="title" id="title" cols="30" rows="2"
                                    class="form-control form-control-sm rounded-0" required="required"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Mazmuny</label>
                                <textarea name="content" id="content" cols="30" rows="10"
                                    class="form-control form-control-sm rounded-0" required="required"></textarea>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" form="new_form" class="btn btn-primary rounded-0">Saklamak</button>
                    <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Ýok</button>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    $(document).ready(function () {
        $('#formModal').on('shown.bs.modal', function () {
            var content_editor = $('#content').summernote({
                placeholder: 'Mazmunyňyzy şu ýere ýazyň',
                tabsize: 2,
                height: "60vh",
                dialogsInBody: true
            });
            console.log(content_editor)
            $('.dropdown-toggle').dropdown()
        })

        $('#post_btn').click(function () {
            $('#formModal').modal('show')
        })

    })
</script>

</html>
