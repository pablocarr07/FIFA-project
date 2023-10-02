<?php
namespace App\Model\Entity;

use Cake\ORM\TableRegistry;
use Cake\ORM\Entity;

/**
 * Item Entity
 *
 * @property int $id
 * @property int $item_classification_id
 * @property string $name
 * @property string $item
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property \Cake\I18n\Time $deleted
 *
 * @property \App\Model\Entity\ItemsClassification $items_classification
 * @property \App\Model\Entity\Cdprequest[] $cdprequests
 * @property \App\Model\Entity\Type[] $types
 */
class Item extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    protected function _getItemClassification()
    {
      $concatenacion_item_classification = '';
      $arreglo_item_classfication = array();

      $parent_id = $this->item_classification_id;

      if ($parent_id) {

        do {

          $item_classification = TableRegistry::get('ItemsClassifications')->findById($parent_id)->first();
          array_unshift($arreglo_item_classfication, $item_classification->name);

          $parent_id = $item_classification->parent_id;


        } while ($parent_id);

        $first_item = False;
        foreach ($arreglo_item_classfication as $item) {

          if ($first_item) {
              $concatenacion_item_classification .= ' / ';
          } else {
            $concatenacion_item_classification .= '';
            $first_item = True;
          }

          $concatenacion_item_classification .= $item;

        }

      }

      return $concatenacion_item_classification;
    }

}
