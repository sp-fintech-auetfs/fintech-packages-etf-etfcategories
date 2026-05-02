<?php

namespace Apps\Fintech\Packages\Etf\Categories;

use Apps\Fintech\Packages\Etf\Categories\Model\AppsFintechEtfCategories;
use System\Base\BasePackage;

class EtfCategories extends BasePackage
{
    protected $modelToUse = AppsFintechEtfCategories::class;

    protected $packageName = 'etfcategories';

    public $etfcategories;

    public function getEtfCategoryByName($name)
    {
        if ($this->config->databasetype === 'db') {
            $conditions =
                [
                    'conditions'    => 'name = :name:',
                    'bind'          =>
                        [
                            'name'  => $name
                        ]
                ];

            $etfcategory = $this->getByParams($conditions);
        } else {
            $this->ffStore = $this->ff->store($this->ffStoreToUse);

            $this->ffStore->setReadIndex(false);

            $etfcategory = $this->ffStore->findBy(['name', '=', $name]);
        }

        if ($etfcategory && count($etfcategory) > 0) {
            return $etfcategory[0];
        }

        return false;
    }

    public function addEtfCategories($data)
    {
        $this->ffStore = $this->ff->store($this->ffStoreToUse);

        $this->ffStore->setReadIndex(false);

        return $this->add($data);
    }

    public function updateEtfCategories($data)
    {
        $this->ffStore = $this->ff->store($this->ffStoreToUse);

        $this->ffStore->setReadIndex(false);

        if ($data['turn_around_time'] === '') {
            $data['turn_around_time'] = null;
        }

        return $this->update($data);
    }

    public function removeEtfCategories($data)
    {
        //
    }

    public function getEtfCategoryParent($childCategoryId)
    {
        $childCategory = $this->getById($childCategoryId);

        if ($childCategory && isset($childCategory['parent_id'])) {
            return $this->getById($childCategory['parent_id']);
        }

        return false;
    }

    public function calculateCategoriesPercentDiff($calculateMain, $calculateWith)
    {
        if ((float) $calculateMain <= 0 || (float) $calculateWith <= 0) {
            $this->addResponse('Numbers cannot be less than or equal to 0', 1);

            return false;
        }

        $total = $calculateMain + $calculateWith;

        $calculateMainPercent = ($calculateMain / $total) * 100;
        $calculateWithPercent = ($calculateWith / $total) * 100;

        if ($calculateMainPercent >= $calculateWithPercent) {
            $diff = $calculateMainPercent - $calculateWithPercent;
        } else {
            $diff = $calculateWithPercent - $calculateMainPercent;
        }

        $this->addResponse('Calculated', 0, ['diff' => $diff . '%']);

        return $diff;
    }

    public function getCategoryTurnAroundTime($categoryId)
    {
        //
    }
}