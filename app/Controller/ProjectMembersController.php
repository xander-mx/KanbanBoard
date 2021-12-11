<?php

namespace Kanboard\Controller;


use Kanboard\Core\Controller\AccessForbiddenException;
use Kanboard\Core\Controller\PageNotFoundException;

class ProjectMembersController extends BaseController
{

  public function index()
  {
    $project = $this->getProject();

    $this->response->html($this->helper->layout->project('members/index', array(
      'members' => $this->projectMemberModel->getAll($project['id']),
      'project' => $project,
      'title'   => t('Members'),
    )));
  }

  public function create(array $values = array(), array $errors = array())
  {
    $project = $this->getProject();

    $this->response->html($this->template->render('members/create', array(
      'values'  => $values + array('project_id' => $project['id']),
      'errors'  => $errors,
      'project' => $project,
    )));
  }

  public function save()
  {
    $project = $this->getProject();
    $values = $this->request->getValues();
    $values['project_id'] = $project['id'];

    list($valid, $errors) = $this->categoryValidator->validateCreation($values);

    if ($valid) {
      if ($this->projectMemberModel->create($values) !== false) {
        $this->flash->success(t('Member has been created successfully.'));
        $this->response->redirect($this->helper->url->to('ProjectMembersController', 'index', array('project_id' => $project['id'])), true);
        return;
      } else {
        $errors = array('name' => array(t('The member is already in this project')));
      }
    }

    $this->create($values, $errors);
  }

  public function edit(array $values = array(), array $errors = array())
  {
    $project = $this->getProject();
    $member = $this->getMember($project);

    $this->response->html($this->template->render('members/edit', array(
      'values'  => empty($values) ? $member : $values,
      'errors'  => $errors,
      'project' => $project,
    )));
  }

  protected function getMember(array $project)
  {
    $member = $this->projectMemberModel->getById($this->request->getIntegerParam('member_id'));

    if (empty($member)) {
      throw new PageNotFoundException();
    }

    if ($member['project_id'] != $project['id']) {
      throw new AccessForbiddenException();
    }

    return $member;
  }

  public function update()
  {
    $project = $this->getProject();
    $member = $this->getMember($project);

    $values = $this->request->getValues();
    $values['project_id'] = $project['id'];
    $values['id'] = $member['id'];

    list($valid, $errors) = $this->projectMemberValidator->validateModification($values);

    if ($valid) {
      if ($this->projectMemberModel->update($values)) {
        $this->flash->success(t('This member has been updated successfully.'));
        return $this->response->redirect($this->helper->url->to('ProjectMembersController', 'index', array('project_id' => $project['id'])));
      } else {
        $this->flash->failure(t('Unable to update this member.'));
      }
    }

    return $this->edit($values, $errors);
  }

  public function confirm()
  {
    $project = $this->getProject();
    $member = $this->getMember($project);

    $this->response->html($this->helper->layout->project('members/remove', array(
      'project'  => $project,
      'member' => $member,
    )));
  }

  public function remove()
  {
    $this->checkCSRFParam();
    $project = $this->getProject();
    $category = $this->getMember($project);

    if ($this->categoryModel->remove($category['id'])) {
      $this->flash->success(t('Category removed successfully.'));
    } else {
      $this->flash->failure(t('Unable to remove this category.'));
    }

    $this->response->redirect($this->helper->url->to('CategoryController', 'index', array('project_id' => $project['id'])));
  }
}