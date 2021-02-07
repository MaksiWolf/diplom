<?php

namespace App\Controllers;

use App\Model\Posts as postData;
use League\Plates\Engine;
use Delight\Auth\Auth;
use \Tamtamchik\SimpleFlash\Flash;
Use App\Model\User;

class Posts
{
    private $templates, $queryBuilder, $auth, $user;

    public function __construct(Engine $engine, postData $db, Auth $auth, Flash $flash, User $user)
    {
        $this->templates = $engine;
        $this->db = $db;
        $this->auth = $auth;
        $this->flash = $flash;
        $this->user = $user;
    }

    public function index()
    {
        if ($this->auth->isLoggedIn()) {
            $this->db->getAllFromTable('posts', false);
            $result = $this->db->getResults();
            // Render a template
            echo $this->templates->render('posts', ['results' => $result, 'auth' => $this->auth]);
        } else {
            $this->db->getAllFromTable('posts', true);
            $result = $this->db->getResults();
            // Render a template
            echo $this->templates->render('posts', ['results' => $result, 'auth' => $this->auth]);
        }
    }


    public function viewpost($id)
    {

        if ($this->auth->isLoggedIn()) {

            $this->db->getAllFromTable('posts', false);
            $result = $this->db->getResults();

            // Render a template
            foreach ($result as $post) {
                if($post['id'] == $id) {
                    echo $this->templates->render('post_view', ['result' => $post, 'auth' => $this->auth]);
                }
            }
        }

    }

    public function editpost($id)
    {
        $this->db->getById('posts', $id);
        $result = $this->db->getResults();
        $oldImgPath = $result['0']['img'];
        if (!empty($_POST)) {
            if (!$id == null) {
                $params = $_POST;
                $this->db->updateTableById('posts', $id, $params);
                $this->flash->success('Success edit');
            }
        }
        if ($id == null) {
            header('Location: ' . SITE_HOST . PROJECT_FOLDER);
        } else {
            $this->db->getById('posts', $id);
            $result = $this->db->getResults();
            $this->db->category();
            // Render a template

            echo $this->templates->render('post_edit', ['results' => $result, 'category' => $this->db->getCategory(), 'auth' => $this->auth, 'errors' => $this->flash]);
        }
    }

    public function deletepostbyId($id)
    {
        if ($id == null) {
            header('Location: ' . SITE_HOST . PROJECT_FOLDER);
        } else {
            $this->db->deleteById('posts', $id);
            header('Location: ' . SITE_HOST . PROJECT_FOLDER);
        }
    }

    public function insertpost()
    {
        if (!empty($_POST)) {

            $params = $_POST;
            $params['user_id'] = $this->auth->getUserId();
            $this->db->insert('posts', $params);
            header('Location: ' . SITE_HOST . PROJECT_FOLDER);
        } else {
            echo $this->templates->render('post_insert', ['auth' => $this->auth, 'errors' => $this->flash]);
        }
    }
}
