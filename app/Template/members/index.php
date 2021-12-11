<div class="page-header">
  <h2><?= t('Members') ?></h2>
  <ul>
    <li>
      <?= $this->modal->medium('plus', t('Add a new member'), 'ProjectMembersController', 'create', array('project_id' => $project['id'])) ?>
    </li>
  </ul>
</div>
<?php if (empty($members)): ?>
  <p class="alert"><?= t('There is no members in this project.') ?></p>
<?php else: ?>
  <table class="table-striped">
    <tr>
      <th><?= t('Member') ?></th>
      <th><?= t('Position') ?></th>
    </tr>
    <?php foreach ($members as $member): ?>
      <tr>
        <td>
          <div class="dropdown">
            <a href="#" class="dropdown-menu dropdown-menu-link-icon"><i class="fa fa-cog"></i><i class="fa fa-caret-down"></i></a>
            <ul>
              <li>
                <?= $this->modal->medium('edit', t('Edit'), 'ProjectMembersController', 'edit', array('project_id' => $project['id'], 'member_id' => $member['id'])) ?>
              </li>
              <li>
                <?= $this->modal->confirm('trash-o', t('Remove'), 'ProjectMembersController', 'confirm', array('project_id' => $project['id'], 'member_id' => $member['id'])) ?>
              </li>
            </ul>
          </div>
          <?= $this->text->e($member['name']) ?>
        </td>
        <td><?= $this->text->e($member['position'] ?? '') ?></td>
      </tr>
    <?php endforeach ?>
  </table>
<?php endif ?>
