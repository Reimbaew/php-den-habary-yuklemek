<?php
function get_settings($field = "")
{
    global $conn;
    $value = "";
    if (!empty($field)) {
        $query = $conn->query("SELECT * FROM `settings` where meta_key = '{$field}'");
        if ($query->num_rows > 0) {
            $value = $query->fetch_array()['meta_value'];
        }
    }
    return $value;
}

function display_content($content = "")
{
    // Goýmak üçin maglumatlar
    $dti = stripslashes(htmlspecialchars_decode(get_settings("data-to-insert")));
    // Nirä salmaly
    $ins_location = get_settings("insert_to");
    //Iterated goýulmagyny ýa-da ýokdugyny barlaň
    $is_iterate = get_settings("is_iterate");
    $new_content = "";


    switch ($ins_location) {
        case 'after_1_paragraph':
            /**
             * 1-nji abzasdan soň blok goýmak
             * Iterated bolsa, bloklar her abzasdan soň görkeziler
             */

            $count = preg_match_all('/<p[^>]*>(.*?)<\/p>/si', $content, $matches);
            if ($is_iterate == 'no') {
                if ($count > 0) {
                    if (isset($matches[0][0])) {
                        $content = str_replace($matches[0][0], $matches[0][0] . $dti, $content);
                    }
                }
            } else {
                foreach ($matches[0] as $k => $v) {
                    $content = str_replace($v, $v . $dti, $content);
                }
            }
            break;

        case 'after_2_paragraph':
            /**
             * 2-nji abzasdan soň blok goýmak
             * Iterated bolsa, bloklar her 2-nji abzasdan soň görkeziler
             */

            $count = preg_match_all('/<p[^>]*>(.*?)<\/p>/si', $content, $matches);
            if ($is_iterate == 'no') {
                if ($count > 0) {
                    if (isset($matches[0][1])) {
                        $content = str_replace($matches[0][1], $matches[0][1] . $dti, $content);
                    }
                }
            } else {
                foreach ($matches[0] as $k => $v) {
                    if ((($k + 1) % 2) == 0)
                        $content = str_replace($v, $v . $dti, $content);
                }
            }
            break;
        case 'after_3_paragraph':
            /**
             * 3-nji abzasdan soň blok goýmak
             * Iterated bolsa, bloklar her 3-nji abzasdan soň görkeziler
             */

            $count = preg_match_all('/<p[^>]*>(.*?)<\/p>/si', $content, $matches);
            if ($is_iterate == 'no') {
                if ($count > 0) {
                    if (isset($matches[0][2])) {
                        $content = str_replace($matches[0][2], $matches[0][2] . $dti, $content);
                    }
                }
            } else {
                foreach ($matches[0] as $k => $v) {
                    if ((($k + 1) % 3) == 0)
                        $content = str_replace($v, $v . $dti, $content);
                }
            }
            break;

        case 'after_4_paragraph':
            /**
             * 4-nji abzasdan soň blok goýmak
             * Iterated bolsa, bloklar her 4-nji abzasdan soň görkeziler
             */

            $count = preg_match_all('/<p[^>]*>(.*?)<\/p>/si', $content, $matches);
            if ($is_iterate == 'no') {
                if ($count > 0) {
                    if (isset($matches[0][3])) {
                        $content = str_replace($matches[0][3], $matches[0][3] . $dti, $content);
                    }
                }
            } else {
                foreach ($matches[0] as $k => $v) {
                    if ((($k + 1) % 4) == 0)
                        $content = str_replace($v, $v . $dti, $content);
                }
            }
            break;
    }
    return $content;
}
?>
