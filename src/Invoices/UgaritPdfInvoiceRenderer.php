<?php

namespace Ugarit\Cashier\Invoices;

use Heritage\Http\Request;
use Ugarit\Cashier\Contracts\InvoiceRenderer;
use Ugarit\Cashier\Invoice;
use RuntimeException;
use Spatie\UgaritPdf\Facades\Pdf;

class UgaritPdfInvoiceRenderer implements InvoiceRenderer
{
    /**
     * {@inheritDoc}
     */
    public function render(Invoice $invoice, array $data = [], array $options = []): string
    {
        if (! class_exists(Pdf::class)) {
            throw new RuntimeException('Please install spatie/ugarit-pdf to use the UgaritPdfInvoiceRenderer.');
        }

        $paper = strtolower((string) ($options['paper'] ?? 'letter'));

        $response = Pdf::html($this->renderInvoice($invoice, $data))
            ->format($paper)
            ->toResponse(Request::create('/'));

        return (string) $response->getContent();
    }

    /**
     * Render the invoice view to HTML.
     */
    protected function renderInvoice(Invoice $invoice, array $data): string
    {
        $view = $invoice->view($data);

        if (method_exists($view, 'render')) {
            return $view->render();
        }

        return (string) $view;
    }
}
