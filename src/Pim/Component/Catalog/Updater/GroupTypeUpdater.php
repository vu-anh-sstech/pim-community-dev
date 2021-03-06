<?php

namespace Pim\Component\Catalog\Updater;

use Akeneo\Component\StorageUtils\Updater\ObjectUpdaterInterface;
use Doctrine\Common\Util\ClassUtils;
use Pim\Component\Catalog\Model\GroupTypeInterface;

/**
 * Updates a group type
 *
 * @author    Pierre Allard <pierre.allard@akeneo.com>
 * @copyright 2016 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class GroupTypeUpdater implements ObjectUpdaterInterface
{
    /**
     * {@inheritdoc}
     *
     * Expected input format :
     * [
     *     'code'       => 'variant',
     *     'is_variant' => true,
     *     'label'      => [
     *         'en_US' => 'variant',
     *         'fr_FR' => 'variantes',
     *     ]
     * ]
     */
    public function update($groupType, array $data, array $options = [])
    {
        if (!$groupType instanceof GroupTypeInterface) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Expects a "Pim\Component\Catalog\Model\GroupTypeInterface", "%s" provided.',
                    ClassUtils::getClass($groupType)
                )
            );
        }

        foreach ($data as $field => $value) {
            $this->setData($groupType, $field, $value);
        }

        return $this;
    }

    /**
     * @param GroupTypeInterface $groupType
     * @param string             $field
     * @param mixed              $data
     */
    protected function setData(GroupTypeInterface $groupType, $field, $data)
    {
        if ('code' == $field) {
            $groupType->setCode($data);
        } elseif ('is_variant' == $field) {
            $groupType->setVariant($data);
        } elseif ('label' == $field) {
            foreach ($data as $locale => $label) {
                $groupType->setLocale($locale);
                $groupType->setLabel($label);
            }
        }
    }
}
