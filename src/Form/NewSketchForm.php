<?

namespace Drupal\demmitv_drupal_module\Form;

use \Drupal\Core\Form\FormBase;
use \Drupal\Core\Form\FormStateInterface;
use \Drupal\node\Entity\Node;
use \Drupal\file\Entity\File;

/**
 * Implements an example form.
**/
class NewSketchForm extends FormBase {

  /**
   * {@inheritdoc}
  **/
  public function getFormId() {
    return 'new_sketch_form';
  }

  /**
   * {@inheritdoc}
  **/
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
    ];
    $form['image'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Image'),
    ];
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Create'),
      '#button_type' => 'primary',
    ];
    return $form;
  }

  // /**
  //  * {@inheritdoc}
  // **/
  // public function validateForm(array &$form, FormStateInterface $form_state) {
  //   if (strlen($form_state->getValue('phone_number')) < 3) {
  //     $form_state->setErrorByName('phone_number', $this->t('The phone number is too short. Please enter a full phone number.'));
  //   }
  // }

  /**
   * {@inheritdoc}
  **/
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $image = $form_state->getValue('image');
    $file = File::load( $image[0] );
    $file->setPermanent();
    $file->save();

    $node = Node::create([
      'type'        => 'sketch',
      'title'       => $form_state->getValue('title'),
      'field_image' =>  [
        'target_id' => $file->id(),
        'alt'       => $form_state->getValue('title'),
        'title'     => $form_state->getValue('title'),
      ],
    ]);
    $node->save();

    $this->messenger()->addStatus($this->t('This form has been submitted.') );
  }

}
