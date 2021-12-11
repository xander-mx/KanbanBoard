<?php

namespace Kanboard\Validator;

use SimpleValidator\Validator;
use SimpleValidator\Validators;

class ProjectMemberValidator extends BaseValidator
{
  public function validateCreation(array $values)
  {
    $rules = array(
      new Validators\Required('project_id', t('The project id is required')),
      new Validators\Required('name', t('The name is required')),
      new Validators\Required('position', t('The position is required')),
    );

    $v = new Validator($values, array_merge($rules, $this->commonValidationRules()));

    return array(
      $v->execute(),
      $v->getErrors()
    );
  }

  public function validateModification(array $values)
  {
    $rules = array(
      new Validators\Required('id', t('The id is required')),
      new Validators\Required('name', t('The name is required')),
      new Validators\Required('position', t('The position is required')),
    );

    $v = new Validator($values, array_merge($rules, $this->commonValidationRules()));

    return array(
      $v->execute(),
      $v->getErrors()
    );
  }

  private function commonValidationRules()
  {
    return array(
      new Validators\Integer('id', t('The id must be an integer')),
      new Validators\Integer('project_id', t('The project id must be an integer')),
      new Validators\MaxLength('name', t('The maximum length is %d characters', 191), 191)
    );
  }
}