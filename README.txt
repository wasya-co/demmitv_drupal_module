



== Forms ==

From: https://www.drupal.org/docs/drupal-apis/form-api/introduction-to-form-api

<pre>
$extra = '612-123-4567';
$form = \Drupal::formBuilder()->getForm('Drupal\mymodule\Form\ExampleForm', $extra);
...
public function buildForm(array $form, FormStateInterface $form_state, $extra = NULL)
  $form['phone_number'] = [
    '#type' => 'tel',
    '#title' => $this->t('Your phone number'),
    '#value' => $extra,
  ];
  return $form;
}
</pre>

