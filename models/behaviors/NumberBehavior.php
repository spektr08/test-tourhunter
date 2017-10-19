<?php

namespace app\models\behaviors;

use yii\db\ActiveRecord;
use yii\behaviors\AttributeBehavior;

class NumberBehavior extends AttributeBehavior
{
    /**
     * @var string the attribute that will receive timestamp value
     * Set this property to false if you do not want to record the creation time.
     */
    public $attributes = [];
    /**
     * @var string the attribute that will receive timestamp value.
     * Set this property to false if you do not want to record the update time.
     */
    /**
     * @var callable|Expression The expression that will be used for generating the timestamp.
     * This can be either an anonymous function that returns the timestamp value,
     * or an [[Expression]] object representing a DB expression (e.g. `new Expression('NOW()')`).
     * If not set, it will use the value of `time()` to set the attributes.
     */

    public function events()
    {
        return array_fill_keys(array_keys($this->attributes), 'evaluateAttributes');
    }

    /**
     * Evaluates the attribute value and assigns it to the current attributes.
     * @param Event $event
     */
    public function evaluateAttributes($event)
    {
      
        if (!empty($this->attributes[$event->name])) {
            $attributes = (array) $this->attributes[$event->name];
            $value = $this->getValue($event);
            foreach ($attributes as $attribute) {
                    $this->owner->$attribute = round(floatval($this->owner->$attribute),2);
                // ignore attribute names which are not string (e.g. when set by TimestampBehavior::updatedAtAttribute)
            }
        }
    }

}
