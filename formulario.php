<?php

function pdf_escape($s)
{

    return str_replace(["\\", "(", ")"], ["\\\\", "\\(", "\\)"], $s);
}

function build_simple_pdf($lines)
{


    $content_lines = [];


    $content_lines[] = "0.902 0.949 0.984 rg";
    $content_lines[] = "50 740 495 80 re f";


    $title = "Formulário preenchido";
    $content_lines[] = "0 0.22 0.45 rg";
    $content_lines[] = "BT /F2 18 Tf 55 785 Td (" . pdf_escape($title) . ") Tj ET";

    $subtitle = isset($lines[0]) ? $lines[0] : '';
    $content_lines[] = "0.15 0.15 0.15 rg";
    $content_lines[] = "BT /F1 10 Tf 55 770 Td (" . pdf_escape($subtitle) . ") Tj ET";

    $content_lines[] = "0.85 0.88 0.92 RG";
    $content_lines[] = "50 755 m 545 755 l S";


    $y = 740 - 40;
    $line_height = 16;
    for ($i = 1; $i < count($lines); $i++) {
        $ln = $lines[$i];
        if (trim($ln) === '') {
            $y -= $line_height;
            continue;
        }


        $parts = explode(':', $ln, 2);
        if (count($parts) == 2) {
            $key = trim($parts[0]);
            $value = trim($parts[1]);
        } else {
            $key = '';
            $value = trim($ln);
        }


        if ($key !== '') {

            $content_lines[] = "0 0 0 rg";
            $content_lines[] = "BT /F2 12 Tf 55 " . $y . " Td (" . pdf_escape($key) . ":) Tj ET";


            $xpos = 200;
            $wrapped = wordwrap($value, 60, "\n", true);
            $val_lines = explode("\n", $wrapped);
            foreach ($val_lines as $li => $vline) {
                $vy = $y - ($li * ($line_height - 2));
                $content_lines[] = "0 0 0 rg";
                $content_lines[] = "BT /F1 11 Tf " . $xpos . " " . $vy . " Td (" . pdf_escape($vline) . ") Tj ET";
            }
            $y = $y - (count($val_lines) * ($line_height - 2)) - 8;
        } else {

            $wrapped = wordwrap($value, 90, "\n", true);
            $val_lines = explode("\n", $wrapped);
            foreach ($val_lines as $li => $vline) {
                $vy = $y - ($li * ($line_height - 2));
                $content_lines[] = "0 0 0 rg";
                $content_lines[] = "BT /F1 11 Tf 55 " . $vy . " Td (" . pdf_escape($vline) . ") Tj ET";
            }
            $y = $y - (count($val_lines) * ($line_height - 2)) - 8;
        }

        $content_lines[] = "0.92 0.92 0.94 RG";
        $content_lines[] = "50 " . ($y + 4) . " m 545 " . ($y + 4) . " l S";
    }


    $footer_y = 28;
    $content_lines[] = "0.8 0.82 0.85 RG";
    $content_lines[] = "50 " . ($footer_y + 10) . " m 545 " . ($footer_y + 10) . " l S";
    $content_lines[] = "0.4 0.45 0.5 rg";
    $content_lines[] = "BT /F1 9 Tf 55 " . $footer_y . " Td (Gerado em: " . pdf_escape(date('d/m/Y H:i:s')) . ") Tj ET";

    $content_lines = [];

    $y = 800;
    $line_height = 16;


    for ($i = 1; $i < count($lines); $i++) {
        $ln = trim($lines[$i]);
        if ($ln === '') {
            continue;
        }


        $parts = explode(':', $ln, 2);
        $value = (count($parts) == 2) ? trim($parts[1]) : trim($ln);
        if ($value === '') {
            continue;
        }


        $wrapped = wordwrap($value, 90, "\n", true);
        $val_lines = explode("\n", $wrapped);
        foreach ($val_lines as $li => $vline) {
            $vy = $y - ($li * $line_height);
            $content_lines[] = "BT /F1 12 Tf 55 " . $vy . " Td (" . pdf_escape($vline) . ") Tj ET";
        }


        $y -= (count($val_lines) * $line_height) + 6;


        if ($y < 60) {
            $content_lines[] = "BT /F1 10 Tf 55 60 Td (... mais valores não mostrados ...) Tj ET";
            break;
        }
    }

    $content = implode("\n", $content_lines);

    $pdf = "%PDF-1.4\n";

    $offsets = [];
    $offsets[] = strlen($pdf);
    $pdf .= "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n";

    $offsets[] = strlen($pdf);
    $pdf .= "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n";


    $offsets[] = strlen($pdf);
    $pdf .= "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Resources << /Font << /F1 4 0 R /F2 5 0 R >> >> /Contents 6 0 R >>\nendobj\n";

    $offsets[] = strlen($pdf);
    $pdf .= "4 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>\nendobj\n";

    $offsets[] = strlen($pdf);
    $pdf .= "5 0 obj\n<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica-Bold >>\nendobj\n";

    $stream = $content;
    $stream_len = strlen($stream);

    $offsets[] = strlen($pdf);
    $pdf .= "6 0 obj\n<< /Length " . $stream_len . " >>\nstream\n" . $stream . "\nendstream\nendobj\n";

    $xref_pos = strlen($pdf);
    $pdf .= "xref\n0 " . (count($offsets) + 1) . "\n";
    $pdf .= sprintf("%010d 65535 f \n", 0);
    foreach ($offsets as $off) {
        $pdf .= sprintf("%010d 00000 n \n", $off);
    }

    $pdf .= "trailer\n<< /Size " . (count($offsets) + 1) . " /Root 1 0 R >>\nstartxref\n" . $xref_pos . "\n%%EOF";

    return $pdf;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $lines = [];
    $lines[] = "Formulário gerado em: " . date('d/m/Y H:i:s');
    $lines[] = "";
    foreach ($_POST as $k => $v) {
        if (is_array($v)) {
            $v = implode(', ', $v);
        }
        $lines[] = $k . ": " . $v;
    }

    $pdf = build_simple_pdf($lines);


    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="formulario_preenchido.pdf"');
    header('Content-Length: ' . strlen($pdf));
    echo $pdf;
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gerar PDF - Formulário</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        .note {
            background: #f5f5f5;
            padding: 12px;
            border-radius: 6px;
        }
    </style>
</head>

<body>
    <h2>Gerar PDF do formulário</h2>
    <p class="note">Este arquivo recebe os dados via <code>POST</code> e retorna um PDF contendo todos os campos
        enviados.</p>
    <p>Para usar com seu formulário: defina <code>action="formulario.php" method="post"</code> no elemento &lt;form&gt;
        e adicione um botão de envio (por exemplo, &lt;button type="submit"&gt;Gerar PDF&lt;/button&gt;).</p>
    <p>Se preferir que eu atualize automaticamente seus arquivos HTML/JS, autorize o acesso correto aos arquivos (posso
        não estar conseguindo ler alguns arquivos no workspace atual).</p>
</body>

</html>

</html>