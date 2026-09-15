<?php

namespace Ugarit\Cashier\Jobs;

use Heritage\Bus\Queueable;
use Heritage\Contracts\Queue\ShouldQueue;
use Heritage\Foundation\Bus\Dispatchable;
use Heritage\Queue\InteractsWithQueue;
use Heritage\Queue\SerializesModels;

class SyncCustomerDetails implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * The billable model instance.
     *
     * @var \Ugarit\Cashier\Billable
     */
    public $billable;

    /**
     * Create a new job instance.
     *
     * @param  \Ugarit\Cashier\Billable  $billable
     * @return void
     */
    public function __construct($billable)
    {
        $this->billable = $billable;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->billable->syncStripeCustomerDetails();
    }
}
