<?php

namespace App\Controllers;

use App\Models\FaqsModel;
use CodeIgniter\Controller;

class Faqs extends BaseController
{
  protected $faqsModel;

  public function __construct()
  {
    $this->faqsModel = new FaqsModel();
  }

  // View FAQs for admin
  public function index()
  {
    $data['faqs'] = $this->faqsModel->findAll();
    return view(
      'admin/faqs/index',
      [
        'faqs' => $data['faqs'],
        'title' => 'FAQs',
        'subtitle' => 'Faqs title'
      ]
    );
  }

  // View FAQs for customer
  public function indexCustomer()
  {
    $data['faqs'] = $this->faqsModel->findAll();
    return view('customer/faqs/index', $data);
  }

  // Show form to create/edit FAQ
  public function form($id = null)
  {
    $data['faq'] = ($id) ? $this->faqsModel->find($id) : null;
    return view('admin/faqs/form', [
      'faq' => $data['faq'],
      'title' => 'FAQs',
      'subtitle' => 'Faqs title'
    ]);
  }

  // Store new FAQ or update existing FAQ
  public function save($id = null)
  {
    $faqData = [
      'question' => $this->request->getPost('question'),
      'answer' => $this->request->getPost('answer')
    ];

    if ($id) {
      $this->faqsModel->update($id, $faqData);
    } else {
      $this->faqsModel->save($faqData);
    }

    return redirect()->to('/faqs/index');
  }

  // Delete FAQ
  public function delete($id)
  {
    $this->faqsModel->delete($id);
    return redirect()->to('/faqs/index');
  }
}
