<?php
if (isset($_POST['submit'])):
    $thumbnail = $_POST['thumbnail'];
    $story = $_POST['story'];
    $hcg = explode("\r\n", $_POST['hcg']);
    $title = $_POST['title'];
    $release = $_POST['release'];
    $developer = $_POST['developer'];
    $version = $_POST['version'];
    $language = array();
    foreach ($_POST['language'] as $lang)
        array_push($language, $lang);
    $platform = array();
    foreach ($_POST['platform'] as $os)
        array_push($platform, $os);
    $censorship = $_POST['censorship'];
    $main_name = $_POST['main-name'];
    $main_link = $_POST['main-link'];
    $fields = array();
    for ($i = 0; $i < 10; ++$i) {
        if (empty($_POST["name$i"]) || empty($_POST["link$i"]))
            break;
        $fields[$i] = array(
            'name' => $_POST["name$i"],
            'link' => $_POST["link$i"]
        );
    }
    $os = $_POST['os'];
    $cpu = $_POST['cpu'];
    $vga = $_POST['vga'];
    $ram = $_POST['ram'];
    $directx = $_POST['directx'];
    $storage = $_POST['storage'];
    $guide = explode("\r\n", $_POST['guide']);
    $embed = $_POST['embed'];
    $contents = array();
    for ($i = 0; $i < 3; ++$i) {
        if (empty($_POST["name-content$i"]) || empty($_POST["content$i"]))
            break;
        $contents[$i] = array(
            'name' => $_POST["name-content$i"],
            'content' => $_POST["content$i"]
        );
    }

    $data = '<div class="w3-container">' . "\n";
    $data .= '<div class="w3-panel w3-border-left w3-border-red w3-animate-top w3-justify">' . "\n";
    $data .= "$story\n";
    $data .= '</div><br>' . "\n\n";

    $data .= '<div class="w3-center w3-animate-bottom">' . "\n";
    $data .= '  <img class="w3-border w3-image" src="' . $thumbnail . '">' . "\n";
    $data .= '</div><br>' . "\n\n";

    $data .= '<div class="w3-bar w3-black">' . "\n";
    $data .= '  <li class="w3-bar-item w3-button tablink w3-red" onclick="setData(event,\'info\')">Infomation</li>' . "\n";
    $data .= '  <li class="w3-bar-item w3-button tablink" onclick="setData(event,\'image\')">Screenshots</li>' . "\n";
    $data .= '  <li class="w3-bar-item w3-button tablink" onclick="setData(event,\'download\')">Download</li>' . "\n";
    $data .= '  <li class="w3-bar-item w3-button tablink" onclick="setData(event,\'guide\')">Guide</li>' . "\n";
    $have_requirements = !empty($os) || !empty($cpu) || !empty($vga) || !empty($directx) || !empty($storage);
    $data .= $have_requirements ? '  <li class="w3-bar-item w3-button tablink" onclick="setData(event,\'requirement\')">Requirement</li>' . "\n" : null;
    if (!empty($contents)) {
        $count = 1;
        foreach ($contents as $content) {
            $data .= '  <li class="w3-bar-item w3-button tablink" onclick="setData(event,\'content' . $count . '\')">' . $content['name'] . '</li>' . "\n";
            ++$count;
        }
    }
    $data .= '</div><br>' . "\n\n";

    $data .= '<div id="info" class="w3-justify w3-animate-left data">' . "\n";
    $data .= !(empty($title)) ? '  <b class="w3-text-blue"><i class="fa fa-caret-right"></i> Original title:</b> ' . "$title\n" : null;
    $data .= '  <b class="w3-text-blue"><i class="fa fa-caret-right"></i> Version:</b> ' . "$version\n";
    $data .= get_the_terms($language, '  <b class="w3-text-blue"><i class="fa fa-caret-right"></i> Language:</b> ', ', ', "\n");
    $data .= '  <b class="w3-text-blue"><i class="fa fa-caret-right"></i> Developer:</b> ' . "$developer\n";
    $date = explode('-', $release);
    $data .= '  <b class="w3-text-blue"><i class="fa fa-caret-right"></i> Release:</b> ' . "$date[2]/$date[1]/$date[0]\n";
    $data .= '  <b class="w3-text-blue"><i class="fa fa-caret-right"></i> Censorship:</b> ' . "$censorship\n";
    $data .= get_the_terms($platform, '  <b class="w3-text-blue"><i class="fa fa-caret-right"></i> OS platform:</b> ', ', ', "\n");
    $data .= '</div>' . "\n\n";

    if (count($hcg) > 0):
        $data .= '<div id="image" class="w3-center w3-animate-bottom data" style="display:none">' . "\n";
        $data .= '  <img class="w3-animate-zoom w3-round-xlarge w3-image w3-border" src="' . $hcg[0] . '">' . "\n";
        $count_hcg = count($hcg);
        for ($i = 1; $i < $count_hcg; ++$i)
            $data .= '  <br><img class="w3-animate-zoom w3-round-xlarge w3-image w3-border" src="' . $hcg[$i] . '">' . "\n";
        $data .= '</div>' . "\n\n";
    endif;

    $data .= '<div id="download" class="w3-center w3-animate-top data" style="display:none">' . "\n";
    $data .= '  <h3 class="w3-text-blue">Please spend time to read <a class="w3-text-red" href="https://kimochi.info/faqs/" target="_blank">FAQs</a> before downloading. Sometimes it may help you.</h3>' . "\n";
    $data .= '  <h3><b><a class="w3-text-green w3-hover-text-purple" href="' . $main_link . '" target="_blank">' . $main_name . '</a></b></h3>' . "\n";
    if (!empty($fields)):
        foreach ($fields as $field)
            $data .= '  <h3><b><a class="w3-text-green w3-hover-text-purple" href="' . $field['link'] . '" target="_blank">' . $field['name'] . '</a></b></h3>' . "\n";
    endif;
    $data .= '  <h4><span class="w3-text-blue">Password:</span> <span class="w3-text-yellow w3-hover-text-purple">kimochi.info</span></h4>' . "\n";
    $data .= '</div>' . "\n\n";

    $data .= '<div id="guide" class="w3-left w3-animate-right data" style="display:none">' . "\n";
    foreach ($guide as $line)
        $data .= "  <li>$line</li>\n";
    $data .= '</div>' . "\n\n";

    if ($have_requirements):
        $data .= '<div id="requirement" class="w3-left w3-animate-left data" style="display:none">' . "\n";
        $data .= !empty($os) ? '  <b class="w3-text-blue"><i class="fa fa-caret-right"></i> OS:</b> ' . "$os\n" : null;
        $data .= !empty($cpu) ? '  <b class="w3-text-blue"><i class="fa fa-caret-right"></i> CPU:</b> ' . "$cpu\n" : null;
        $data .= !empty($vga) ? '  <b class="w3-text-blue"><i class="fa fa-caret-right"></i> VGA:</b> ' . "$vga\n" : null;
        $data .= !empty($ram) ? '  <b class="w3-text-blue"><i class="fa fa-caret-right"></i> RAM:</b> ' . "$ram\n" : null;
        $data .= !empty($directx) ? '  <b class="w3-text-blue"><i class="fa fa-caret-right"></i> DIRECTX:</b> ' . "$directx\n" : null;
        $data .= !empty($storage) ? '  <b class="w3-text-blue"><i class="fa fa-caret-right"></i> STORAGE:</b> ' . "$storage\n" : null;
        $data .= '</div>' . "\n\n";
    endif;

    if (!empty($contents)):
        $count = 1;
        foreach ($contents as $content) {
            $data .= '<div id="content' . $count . '" class="w3-left w3-animate-left data" style="display:none">' . "\n";
            $data .= $content['content'] . "\n";
            $data .= '</div>' . "\n\n";
            ++$count;
        }
    endif;

    $data .= '</div><br>' . "\n\n";

    if (!empty($embed)):
        $data .= '<div class="w3-center w3-animate-top">' . "\n";
        $data .= "  $embed\n";
        $data .= '</div>';
    endif;
endif;

function get_the_terms($array, $before, $separator, $after) {
    $data = null;
    if ($count = count($array)) {
        $data = $before;
        for ($i = 0; $i < $count - 1; ++$i)
            $data .= $array[$i] . $separator;
        $data .= $array[$count - 1] . $after;
    }
    return $data;
}

?>
<button onclick="copyall()">Copy all</button><br><br>
<textarea id="result" rows="50" cols="160"><?php echo $data ?></textarea>
<script>
    function copyall() {
        const result = document.getElementById('result');
        result.select();
        document.execCommand('copy');
        alert('Copied');
    }
</script>