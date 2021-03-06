<?php

namespace tests\integration\Pim\Component\Catalog\Standard;

use Test\Integration\TestCase;

/**
 * @author    Marie Bochu <marie.bochu@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class CategoryIntegration extends TestCase
{
    protected $purgeDatabaseForEachTest = false;

    public function testCategoryRoot()
    {
        $expected = [
            'code'   => 'master',
            'parent' => null,
            'labels' => []
        ];

        $this->assert('master', $expected);
    }

    public function testCategoryWithParent()
    {
        $expected = [
            'code'   => 'categoryA',
            'parent' => 'master',
            'labels' => []
        ];

        $this->assert('categoryA', $expected);
    }

    private function assert($identifier, array $expected)
    {
        $repository = $this->get('pim_catalog.repository.category');
        $serializer = $this->get('pim_serializer');

        $result = $serializer->normalize($repository->findOneByIdentifier($identifier), 'standard');

        $this->assertSame($expected, $result);
    }
}
