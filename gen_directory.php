<?php

function mb_substr_replace($original, $replacement, $position, $length)
{
    $startString = mb_substr($original, 0, $position, "UTF-8");
    $endString   = mb_substr($original, $position + $length, mb_strlen($original), "UTF-8");

    $out = $startString . $replacement . $endString;

    return $out;
}

$docdir    = "docs";
$subfolder = array_diff(scandir($docdir), array('.', '..'));

$content = "";
foreach ($subfolder as $f) {
    $filedir  = rtrim($docdir, "/") . '/' . $f;
    $tmpfiles = array_diff(scandir($filedir), array('.', '..'));

    $content .= "### [{$f}]({$filedir})\n";
    foreach ($tmpfiles as $file) {
        $content .= sprintf("- [%s](%s)\n", rtrim($file, ".md"), $filedir . "/{$file}");
    }
}

$marker = "<dicrectory>";

$readme = file_get_contents("README.md");
$finalContent = preg_replace("/<directory>.*\s+<\/directory>/u", "<directory>\n\n" . $content . "\n</directory>", $readme);

file_put_contents("README.md", $finalContent);

exit("done");