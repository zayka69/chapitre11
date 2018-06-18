<?php
/**
 * HTML2PDF Librairy 
 *
 * http://html2pdf.fr/
 */

    // get the HTML
    ob_start();
    include('vue.php');
    $content = ob_get_clean();

    //appel de la bibliothèque html2pdf
    require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
	// convert to PDF
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('RIB.pdf'); //génération du fichier RIB.pdf
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

