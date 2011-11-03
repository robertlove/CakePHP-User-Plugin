<?php

App::uses('CakeEmail', 'Network/Email');

/**
 * Users Controller
 */
class UsersController extends UserAppController
{
    /**
     * Components
     *
     * @var array
     */
    public $components = array(
        'Auth' => array(
            'authenticate' => array(
                'Form' => array(
                    'fields' => array(
                        'username' => 'email',
                    ),
                    'scope' => array('User.active' => 1)
                )
            ),
            'loginAction' => array(
                'controller' => 'users',
                'action' => 'login',
                'plugin' => 'user'
            )
        )
    );

    /**
     * Uses
     *
     * @var array
     */
    public $uses = array(
        'User'
    );

    /**
     * Before Filter
     *
     * @return void
     */
    public function beforeFilter()
    {
        if (($this->Auth->loggedIn()) && ($this->action != 'logout')) {
            return $this->redirect('/');
        }
        $this->Auth->allow('*');
    }

    /**
     * Activate
     *
     * @return void
     */
    public function activate($secret = null)
    {
        $id = $this->User->field('id', array(
            'secret' => $secret
        ));
        $this->User->id = $id;
        if (!$this->User->exists()) {
            $this->redirect(array('action' => 'logout'));
        }
        $this->User->saveField('active', 1, false);
        $this->Session->setFlash(__('The user has been activated'));
        $this->redirect(array('action' => 'login'));
    }

    /**
     * Add
     *
     * @return void
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $password = $this->getPassword();
            $secret = $this->getSecret();
            $this->request->data['User']['password'] = $this->Auth->password($password);
            $this->request->data['User']['secret'] = $secret;
            $this->request->data['User']['active'] = 0;
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $message = 'Click the following link to activate your account.' . "\n\n" . Router::url(array('plugin' => 'user', 'action' => 'activate', $secret), true);
                $email = new CakeEmail();
                $email->from(array('noreply@example.com' => 'Site Name'));
                $email->to($this->request->data['User']['email']);
                $email->subject('Account Activation');
                $email->send($message);
                $this->Session->setFlash(__('Your account has been created. Please check your email for activation instructions.'));
                $this->redirect(array('action' => 'login'));
            } else {
                $this->Session->setFlash(__('Your account could not be created. Please try again.'));
            }
        }
        $this->set('title_for_layout', __('Sign Up'));
    }

    /**
     * Forgot
     *
     * @return void
     */
    public function forgot()
    {
        if ($this->request->is('post')) {
            $id = $this->User->field('id', array(
                'email' => $this->request->data['User']['email']
            ));
            $this->User->id = $id;
            if ($this->User->exists()) {
                $secret = $this->User->field('secret');
                $message = 'Click the following link to reset your password.' . "\n\n" . Router::url(array('plugin' => 'user', 'action' => 'password', $secret), true);
                debug($message);exit;
                $email = new CakeEmail();
                $email->from(array('noreply@example.com' => 'Site Name'));
                $email->to($this->request->data['User']['email']);
                $email->subject('Reset Password');
                $email->send($message);
                $this->Session->setFlash(__('Check your email'));
            } else {
                $this->Session->setFlash(__('You don\'t exist'));
            }
        }
        $this->set('title_for_layout', __('Forgot Password'));
    }

    /**
     * Login
     *
     * @return void
     */
    public function login()
    {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->redirect($this->Auth->redirect());
            } else {
                $this->Session->setFlash(__('Email or Password is incorrect'), 'default', array(), 'auth');
            }
        }
        $this->set('title_for_layout', __('Login'));
    }

    /**
     * Logout
     *
     * @return void
     */
    public function logout()
    {
        $this->redirect($this->Auth->logout());
    }

    /**
     * Password
     *
     * @return void
     */
    public function password($secret = null)
    {
        $id = $this->User->field('id', array(
            'secret' => $secret
        ));
        $this->User->id = $id;
        if (!$this->User->exists()) {
            $this->redirect(array('action' => 'logout'));
        }
        if ($this->request->is('post')) {
            if ($this->request->data['User']['password'] != $this->request->data['User']['confirm_password']) {
                return $this->Session->setFlash(__('Passwords do not match.'));
            }
            if ($this->request->data['User']['password'] == '') {
                return $this->Session->setFlash(__('Passwords cannot be empty.'));
            }
            $this->request->data['User']['id'] = $id;
            $this->request->data['User']['active'] = 1;
            $this->request->data['User']['password'] = $this->Auth->password($this->request->data['User']['password']);
            unset($this->request->data['User']['confirm_password']);
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('Your password has been saved.'));
                $this->redirect(array('action' => 'login'));
            } else {
                $this->Session->setFlash(__('Your password could not be saved. Please try again.'));
            }
        }
        $this->User->validate['confirm_password']['notempty']['rule'] = array('notempty');
        $this->set('title_for_layout', __('Reset Password'));
    }
}