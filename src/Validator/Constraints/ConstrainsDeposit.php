<?php
/**
 * Created by PhpStorm.
 * User: niki
 * Date: 10/28/19
 * Time: 6:29 PM
 */

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ConstrainsDeposit extends Constraint
{
    public $message = 'The account id  "{{ account_id }}" does not exist.';
}