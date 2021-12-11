<?php

namespace Kanboard\Model;

use Kanboard\Core\Base;

class ProjectMemberModel  extends Base
{
  const TABLE = 'project_members';

  public function exists($member_id)
  {
    return $this->db->table(self::TABLE)->eq('id', $member_id)->exists();
  }

  public function getById($member_id)
  {
    return $this->db->table(self::TABLE)->eq('id', $member_id)->findOne();
  }

  public function getProjectId($member_id)
  {
    return $this->db->table(self::TABLE)->eq('id', $member_id)->findOneColumn('project_id') ?: 0;
  }

  public function getAll($project_id)
  {
    return $this->db->table(self::TABLE)
      ->eq('project_id', $project_id)
      ->asc('name')
      ->findAll();
  }

  public function create(array $values)
  {
    return $this->db->table(self::TABLE)->persist($values);
  }

  public function update(array $values)
  {
    return $this->db->table(self::TABLE)->eq('id', $values['id'])->save($values);
  }

  public function remove($member_id)
  {
    $this->db->startTransaction();

    $this->db->table(TaskModel::TABLE)->eq('member_id', $member_id)->update(array('member_id' => 0));

    if (! $this->db->table(self::TABLE)->eq('id', $member_id)->remove()) {
      $this->db->cancelTransaction();
      return false;
    }

    $this->db->closeTransaction();

    return true;
  }

  public function createDefaultCategories($project_id)
  {
    $results = array();
    $members = array_unique(explode_csv_field($this->configModel->get('project_members')));

    foreach ($members as $member) {
      $results[] = $this->db->table(self::TABLE)->insert(array(
        'project_id' => $project_id,
        'name' => $member,
      ));
    }

    return in_array(false, $results, true);
  }
}