<?php
// Carregar dompdf
require_once '../../lib/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$id=$_GET['idvenda'];



 $html=file_get_contents("http://localhost/estoqueVendas/view/vendas/comprovanteVendaPdf.php?idvenda=".$id);


 
// Instanciamos um objeto da classe DOMPDF.
$pdf = new DOMPDF();
 
// Definimos o tamanho do papel e orientação.
$pdf->set_paper(array(0,0,150,250));
 
// Carregar o conteúdo html.
$pdf->load_html(utf8_decode($html));
 
// Renderizar PDF.
$pdf->render();
 
//ob_end_clean() irá limpar o buffer e cancelar a saída de dados.//utilizado para nao dar erro no PDF
ob_end_clean();

// Enviamos pdf para navegador.
$pdf->stream('comprovanteVenda.pdf');


?>
