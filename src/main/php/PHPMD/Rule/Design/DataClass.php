<?php

namespace PHPMD\Rule\Design;

use PHPMD\AbstractNode;
use PHPMD\AbstractRule;
use PHPMD\Rule\ClassAware;

/**
 * This rule checks a given class against a configured weighted method count
 * threshold.
 *
 * @since      0.2.5
 */
class DataClass extends AbstractRule implements ClassAware
{
    /**
     * @param \PHPMD\AbstractNode $node
     * @return void
     */
    public function apply(AbstractNode $node)
    {
        $wocLevel = 1. / 3.;
        $wmcHigh = $this->getIntProperty('wmchigh');
        $wmcVeryHigh = $this->getIntProperty('wmcveryhigh');
        $accessorOrFieldFew = $this->getIntProperty('accessororfieldfew');
        $accessorOrFieldMany = $this->getIntProperty('accessororfieldmany');
        $wmc = $node->getMetric('wmc');
        $npm = $node->getMetric('npm');
        $nopa = $node->getMetric('nopa');
        $varsnp = $node->getMetric('varsnp');

        if ((($nopa + $varsnp > $accessorOrFieldFew && $wmc < $wmcHigh) || ($nopa + $varsnp > $accessorOrFieldMany && $wmc < $wmcVeryHigh))
            && ($npm - $nopa) / $npm < $wocLevel) {
            $this->addViolation($node, array($node->getName()));
        }
    }

}
