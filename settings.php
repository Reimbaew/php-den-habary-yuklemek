<?php require_once("db-connect.php"); ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_POST['is_iterate'] = !isset($_POST['is_iterate']) ? 'no' : "yes";
    $data = "";
    foreach ($_POST as $k => $v) {
        if ($k == 'data-to-insert')
            $v = htmlspecialchars(addslashes($v));
        else
            $v = addslashes($conn->real_escape_string($v));
        if (!empty($data))
            $data .= ", ";
        $check = $conn->query("SELECT id FROM `settings` where `meta_key` = '{$k}' ");
        if ($check->num_rows > 0) {
            $id = $check->fetch_array()['id'];
            $sql = "UPDATE `settings` set `meta_value` = '{$v}' where id = '{$id}'";
        } else {
            $sql = "INSERT INTO `settings` set `meta_value` = '{$v}', `meta_key` = '{$k}'";
        }
        $save = $conn->query($sql);
        if (!$save) {
            echo '<script> alert("Maglumat täzelenende nädogry bir zat boldy."); location.replace("./settings.php"); </script>';
            exit;
        }
    }

    echo '<script> alert("Sazlamalar üstünlikli täzelendi."); location.replace("./settings.php"); </script>';

}
$query = $conn->query("SELECT * FROM `settings`");
$data = [];
while ($row = $query->fetch_assoc()) {
    $data[$row['meta_key']] = $row['meta_value'];
}
$data['data-to-insert'] = isset($data['data-to-insert']) ? htmlspecialchars_decode($data['data-to-insert']) : '';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP </title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.min.css"
        integrity="sha512-uf06llspW44/LZpHzHT6qBOIVODjWtv4MxCricRxkzvopAlSWnTf6hpZTFxuuZcuNE9CBQhqE0Seu1CoRk84nQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/theme/lesser-dark.min.css"
        integrity="sha512-rcv22E/xD3QRYj/qKfy+mAlmCF45muYFRPBXJL7hv2F7Sn9k/VKK2070s0bhZOWOKbasRAhLdDCRFQFMMJEhug=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
        integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/codemirror.min.js"
        integrity="sha512-8RnEqURPUc5aqFEN04aQEiPlSAdE0jlFS/9iGgUyNtwFnSKCXhmB6ZTNl7LnDtDWKabJIASzXrzD0K+LYexU9g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/6.65.7/mode/htmlmixed/htmlmixed.min.js"
        integrity="sha512-HN6cn6mIWeFJFwRN9yetDAMSh+AK9myHF1X9GlSlKmThaat65342Yw8wL7ITuaJnPioG0SYG09gy0qd5+s777w=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
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
    <div class="container px-5 my-3 h-75">
        <div class="col-lg-10 col-md-11 col-sm-12 mx-auto my-5 pt-5">
            <div class="card rounded-0 shadow">
                <div class="card-header">
                    <h2 class="card-title text-center">Maglumat goýujy sazlamalar</h2>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <form action="" id="settingsForm" method="POST">
                            <div class="row align-items-center">
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Goýmak üçin maglumatlar</label>
                                        <textarea name="data-to-insert" class="form-control" id="data-to-insert"
                                            rows="10"><?= isset($data['data-to-insert']) ? ($data['data-to-insert']) : "" ?></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <div class="mb-3">
                                        <label for="" class="form-label">Goýmak</label>
                                        <select name="insert_to" id="insert_to" class="form-select rounded-0">
                                            <option value="after_1_paragraph" <?= (isset($data['insert_to']) && $data['insert_to'] == 'after_1_paragraph') ? 'selected' : '' ?>>
                                                Her 1-nji abzasdan soň</option>
                                            <option value="after_2_paragraph" <?= (isset($data['insert_to']) && $data['insert_to'] == 'after_2_paragraph') ? 'selected' : '' ?>>
                                                Her 2-nji abzasdan soň</option>
                                            <option value="after_3_paragraph" <?= (isset($data['insert_to']) && $data['insert_to'] == 'after_3_paragraph') ? 'selected' : '' ?>>
                                                Her 3-nji abzasdan soň</option>
                                            <option value="after_4_paragraph" <?= (isset($data['insert_to']) && $data['insert_to'] == 'after_4_paragraph') ? 'selected' : '' ?>>
                                                Her 4-nji abzasdan soň</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="is_iterate"
                                                name="is_iterate" <?= (isset($data['is_iterate']) && $data['is_iterate'] == 'yes') ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="is_iterate">
                                                Iterate Blok goýmak
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-footer py-2 text-center">
                    <button class="btn btn-primary rounded-pill col-lg-3 col-md-5 col-sm-12"
                        form="settingsForm">Täzelemek</button>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    $(document).ready(function () {
        var codeEditor = CodeMirror.fromTextArea(document.getElementById('data-to-insert'), {
            lineNumbers: true,
            mode: "htmlmixed",
            styleActiveLine: true,
            matchBrackets: true,
            theme: 'lesser-dark',
            lineWrapping: true,
        });
    })
</script>
<?php if (isset($conn))
    $conn->close(); ?>

</html>
