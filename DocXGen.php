<?php
class DocXGen
{
    /*
     * Developed by psinetron
     * http://slybeaver.ru
     * https://github.com/psinetron
     * Params:
     * $filepath - path to docx file template
     * $templates - array of  pattern value
     * $output - path to output file
     *
     * !Attention! You need the ZipArchive library or other Zip Class on PHP. ZipArchive library included on PHP >=5.2
     */
    public function docxTemplate($filepath = false, $templates = false, $output = false)
    {
        if (($filepath===false)||($templates===false)||($output===false)){return false;}

        if (file_exists($output)) {
            unlink($output);
        }
        copy($filepath, $output);
        if (!file_exists($output)) {
            die('File not found.');
        }
        $zip = new ZipArchive();
        if (!$zip->open($output)) {
            die('File not open.');
        }
        $documentXml = $zip->getFromName('word/document.xml');
        $rekeys = array_keys($templates);

        for ($i = 0; $i < count($templates); $i++) {
            $reg = '';
            $reg .= substr($rekeys[$i], 0, 1);
            for ($i2 = 1; $i2 < strlen($rekeys[$i]); $i2++) {
                $reg .= '(<.*?>)*+' . substr($rekeys[$i], $i2, 1);
            }
            $reg = '#' . str_replace(array('#', '{', '[', ']', '}'), array('#', '{', '[', ']', '}'), $reg) . '#';
            $documentXml = preg_replace($reg, $templates[$rekeys[$i]], $documentXml);
            print '->' . $reg . '<br/>';
        }
        $zip->deleteName('word/document.xml');
        $zip->addFromString('word/document.xml', $documentXml);
        $zip->close();
    }
}

?>