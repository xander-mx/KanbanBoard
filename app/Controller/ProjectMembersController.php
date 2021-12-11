<?php

namespace Kanboard\Controller;


class ProjectMembersController extends BaseController
{

  public function index()
  {
    $project = $this->getProject();

    $this->response->html($this->helper->layout->project('members/index', array(
      'members' => $this->projectMemberModel->getAll($project['id']),
      'project' => $project,
      'colors'  => $this->colorModel->getList(),
      'title'   => t('Members'),
    )));
  }

  public function create(array $values = array(), array $errors = array())
  {
    $project = $this->getProject();

    $this->response->html($this->template->render('members/create', array(
      'values'  => $values + array('project_id' => $project['id']),
      'colors'  => $this->colorModel->getList(),
      'errors'  => $errors,
      'project' => $project,
    )));
  }

  public function save()
  {
    $project = $this->getProject();
    $values = $this->request->getValues();
    $values['project_id'] = $project['id'];

    //list($valid, $errors) = $this->categoryValidator->validateCreation($values);

    //if ($valid) {
      if ($this->projectMemberModel->create($values) !== false) {
        $this->flash->success(t('Member has been created successfully.'));
        $this->response->redirect($this->helper->url->to('ProjectMembersController', 'index', array('project_id' => $project['id'])), true);
        return;
      } else {
        $errors = array('name' => array(t('The member is already in this project')));
      }
    //}

    $this->create($values, $errors);
  }
}