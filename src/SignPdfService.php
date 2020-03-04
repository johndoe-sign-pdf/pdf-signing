<?php

namespace Milepanic\PdfSigning;

use setasign\Fpdi\Tcpdf\Fpdi;

class SignPdfService
{
    protected $pdfDocument;
    protected $certificate;
    protected $privateKey;

    public function __construct(string $pdfDocument, string $certificate, string $privateKey)
    {
        $this->pdfDocument = $pdfDocument;
        $this->certificate = "file://{$certificate}";
        $this->privateKey = "file://{$privateKey}";
    }

    public function execute(): string
    {
        $pdf = $this->loadPdf();
        $signedPdf = $this->signDocument($pdf);

        return $signedPdf->Output('signed.pdf', 'S');
    }

    protected function loadPdf()
    {
        $pdf = new Fpdi(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        return $pdf;
    }

    protected function signDocument($pdf)
    {
        $certificateDetails = openssl_x509_parse($this->certificate);

        $pages = $pdf->setSourceFile($this->pdfDocument);

        for ($i = 1; $i <= $pages; $i++) {
            $pdf->AddPage();
            $page = $pdf->importPage($i);
            $pdf->useTemplate($page, 0, 0);

            $pdf->setSignature($this->certificate, $this->privateKey, '', '', 2, [
                'Name' => 'TCPDF',
                'Location' => 'Office',
                'Reason' => 'Proof of author',
                'ContactInfo' => 'http://www.tcpdf.org',
            ]);
        }

        return $pdf;
    }
}
