<?php

namespace Ugarit\Cashier\Tests\Unit;

use Ugarit\Cashier\Invoice;
use Ugarit\Cashier\Invoices\UgaritPdfInvoiceRenderer;
use Ugarit\Cashier\Tests\TestCase;
use Mockery as m;
use RuntimeException;

class UgaritPdfInvoiceRendererTest extends TestCase
{
    protected function tearDown(): void
    {
        m::close();

        parent::tearDown();
    }

    public function test_it_throws_a_runtime_exception_when_ugarit_pdf_is_not_installed()
    {
        $renderer = new class extends UgaritPdfInvoiceRenderer
        {
            protected static $ugaritPdfFacade = 'Spatie\\UgaritPdf\\Facades\\PdfThatDoesNotExist';
        };

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Please install spatie/ugarit-pdf to use the UgaritPdfInvoiceRenderer.');

        $renderer->render(m::mock(Invoice::class));
    }

    public function test_it_renders_the_invoice_view_to_html()
    {
        $invoice = m::mock(Invoice::class);

        $invoice->shouldReceive('view')
            ->once()
            ->with(['key' => 'value'])
            ->andReturn(new class
            {
                public function render(): string
                {
                    return '<p>invoice</p>';
                }
            });

        $renderer = new UgaritPdfInvoiceRenderer;

        $method = new \ReflectionMethod(UgaritPdfInvoiceRenderer::class, 'renderInvoice');
        $method->setAccessible(true);

        $this->assertSame('<p>invoice</p>', $method->invoke($renderer, $invoice, ['key' => 'value']));
    }
}
