<?php

namespace Ugarit\Cashier;

use Ugarit\Cashier\Concerns\HandlesTaxes;
use Ugarit\Cashier\Concerns\ManagesCustomer;
use Ugarit\Cashier\Concerns\ManagesInvoices;
use Ugarit\Cashier\Concerns\ManagesPaymentMethods;
use Ugarit\Cashier\Concerns\ManagesSubscriptions;
use Ugarit\Cashier\Concerns\ManagesUsageBilling;
use Ugarit\Cashier\Concerns\PerformsCharges;

trait Billable
{
    use HandlesTaxes;
    use ManagesCustomer;
    use ManagesInvoices;
    use ManagesPaymentMethods;
    use ManagesSubscriptions;
    use ManagesUsageBilling;
    use PerformsCharges;
}
