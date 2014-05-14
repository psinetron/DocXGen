<?php
require_once('DocXGen.php');
DocXGen::docxTemplate('original.docx',array('{NAME}'=>'John', '{SEX}'=>'man', '{LASTNAME}'=> 'Smith','#DOB#'=>'24 august 1967'),'result.docx');
print 'Compare <a href="original.docx">original</a> and <a href="result.docx">result</a> files';
?>