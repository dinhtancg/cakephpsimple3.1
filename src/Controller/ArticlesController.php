<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\NotFoundException;

/**
 * Articles Controller
 *
 * @property \App\Model\Table\ArticlesTable $Articles
 */
class ArticlesController extends AppController
{
    // public $paginate =
    // [
    //   'order' =>['Articles.title' => 'asc'],
    //   'maxLmit'=> 2
    // ];
    //
    // public function initialize()
    // {
    //     parent::initialize();
    //     $this->loadComponent('Paginator');
    // }
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $this->paginate = ['contain' => ['Categories']];
        $articles = $this->paginate($this->Articles);

        $this->set(compact('articles'));
        $this->set('_serialize', ['articles']);
    }

    /**
     * View method
     *
     * @param string|null $id Article id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $article = $this->Articles->get($id, [
            'contain' => ['Categories']
        ]);

        $this->set('article', $article);
        // debug($this->Articles->isOwnedBy($article->id, 5));
        // die;
        $this->set('_serialize', ['article']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
     public function add()
     {
         $article = $this->Articles->  newEntity();
         if ($this  ->request->is('post')) {
             $article = $this->Articles->patchEntity($article, $this->request->data);
             $article->user_id = $this->Auth->user('id');
             if ($this->Articles->save($article)) {
                 $this->Flash->success(__('Your article has been saved.'));
                 return $this->redirect(['action' => 'index']);
             }
             $this->Flash->error(__('Unable to add your article.'));
         }
         $this->set('article', $article);

    // Just added the categories list to be able to choose
    // one category for an article
    $categories = $this->Articles->Categories->find('treeList');
         $this->set(compact('categories'));
     }

    /**
     * Edit method
     *
     * @param string|null $id Article id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $article = $this->Articles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $article = $this->Articles->patchEntity($article, $this->request->data);
            if ($this->Articles->save($article)) {
                $this->Flash->success(__('The article has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The article could not be saved. Please, try again.'));
            }
        }
        $categories = $this->Articles->Categories->find('treeList');
        $this->set(compact('article', 'categories'));

        $this->set('_serialize', ['article']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Article id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $article = $this->Articles->get($id);
        if ($this->Articles->delete($article)) {
            $this->Flash->success(__('The article has been deleted.'));
        } else {
            $this->Flash->error(__('The article could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

    //override AppController's isAuthorized()
    public function isAuthorized($user)
    {
        //all user can add
      if ($this->request->param('action') ==='add') {
          return true;
      }
      // the owner of an article can edit and deleted
      if (in_array($this->request->param('action'), ['edit', 'delete'])) {
          $articleId = (int)$this->request->param('pass.0');
          if ($this->Articles->isOwnedBy($articleId, $user['id'])) {
              return true;
          }
      }

        return parent::isAuthorized($user);
    }
}
