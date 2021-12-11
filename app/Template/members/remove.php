<div class="page-header">
  <h2><?= t('Remove Member') ?></h2>
</div>

<div class="confirm">
  <p class="alert alert-info">
    <?= t('Do you really want to remove this member: "%s"?', $member['name']) ?>
  </p>

  <?= $this->modal->confirmButtons(
    'CategoryController',
    'remove',
    array('project_id' => $project['id'], 'category_id' => $member['id'])
  ) ?>
</div>
