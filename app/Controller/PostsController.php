<?php
/**
 * Created by Webonise Lab.
 * User: Hrishikesh
 * Date: 28/12/12 6:21 PM
 */
App::uses('AppController', 'Controller');
/**
 * @property Post $Post
 */
class PostsController extends AppController
{
    public $helpers = array('Html', 'Form');
    public $layout = 'roles_layout';

    /**
     * Displays the list of posts
     */
    public function index()
    {
        $this->set('posts', $this->Post->find('all'));
    }

    /**
     * Displays single post
     * @param null $id
     * @throws NotFoundException
     */
    public function view($id = null)
    {
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }

        $post = $this->Post->findById($id);
        if (!$post) {
            throw new NotFoundException(__('Invalid post'));
        }

        $this->set('post', $post);
    }

    /**
     * To Add a new post
     */
    public function add() {
        if ($this->request->is('post')) {
            $this->request->data['Post']['user_id'] = $this->Auth->user('id');
            $this->Post->create();
            if ($this->Post->save($this->request->data)) {
                $this->Session->setFlash('Your post has been saved.');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Unable to add your post.');
            }
        }
    }

    /**
     * To Edit selected post
     * @param null $id
     * @throws NotFoundException
     */
    public function edit($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }

        $post = $this->Post->findById($id);
        if (!$post) {
            throw new NotFoundException(__('Invalid post'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->Post->id = $id;
            if ($this->Post->save($this->request->data)) {
                $this->Session->setFlash('Your post has been updated.');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Unable to update your post.');
            }
        }

        if (!$this->request->data) {
            $this->request->data = $post;
        }
    }

    /**
     * Delete a single post
     * @param $id
     * @throws MethodNotAllowedException
     */
    public function delete($id) {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }

        if ($this->Post->delete($id)) {
            $this->Session->setFlash('The post with id: ' . $id . ' has been deleted.');
            $this->redirect(array('action' => 'index'));
        }
    }


    public function isAuthorized($user) {
        // All registered users can add posts
        if ($this->action === 'add') {
            return true;
        }

        // The owner of a post can edit and delete it
        if (in_array($this->action, array('edit', 'delete'))) {
            $postId = $this->request->params['pass'][0];
            if ($this->Post->isOwnedBy($postId, $user['id'])) {
                return true;
            }
        }

        return parent::isAuthorized($user);
    }
}
