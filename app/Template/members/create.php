<div class="page-header">
  <h2><?= t('Add a new member') ?></h2>
</div>
<form method="post" action="<?= $this->url->href('ProjectMembersController', 'save', array('project_id' => $project['id'])) ?>" autocomplete="off">
  <?= $this->form->csrf() ?>

  <?= $this->form->label(t('Member'), 'name') ?>
  <?= $this->form->text('name', $values, $errors, array('autofocus', 'required')) ?>

  <?= $this->form->label(t('Position'), 'position') ?>
  <?= $this->form->text('position', $values, $errors, array('autofocus', 'required')) ?>

  <?= $this->modal->submitButtons() ?>
</form>
