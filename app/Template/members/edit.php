<div class="page-header">
  <h2><?= t('Editing member "%s"', $project['name']) ?></h2>
</div>

<form method="post" action="<?= $this->url->href('ProjectMembersController', 'update', array('project_id' => $project['id'], 'member_id' => $values['id'])) ?>" autocomplete="off">
  <?= $this->form->csrf() ?>

  <?= $this->form->label(t('Member'), 'name') ?>
  <?= $this->form->text('name', $values, $errors, array('autofocus', 'required', 'maxlength="191"', 'tabindex="1"')) ?>

  <?= $this->form->label(t('Position'), 'description') ?>
  <?= $this->form->text('position', $values, $errors, array('tabindex' => 2)) ?>

  <?= $this->modal->submitButtons() ?>
</form>
