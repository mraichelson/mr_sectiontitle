<?php
/**
 * @file
 * This is an example of code that can be added to the TEMPLATE.PHP file of a
 * Drupal theme to allow for a specific field to be used to override the value
 * of the mr_sectiontitle block. 
 */

/**
 * Implements template_preprocess_block().
 *
 * Example code for doing a custom override of the section title module
 * based on a specific field.
 */
function mytheme_preprocess_block(&$vars, $hook) {
  if (module_exists('mr_sectiontitle')) {
    // name of the field to use for custom section title.
    $field_name = 'field_custom_section_label';

    $is_sectiontitle = FALSE;
    if ($vars['block_html_id'] == 'block-mr-sectiontitle-mr-sectiontitle') {
      $is_sectiontitle = TRUE;
    }
    
    $is_customtitle = FALSE;
    if (!empty(menu_get_object()->{$field_name})) {
      $is_customtitle = TRUE;
    }

    if($is_sectiontitle && $is_customtitle) {
      $node = menu_get_object();
      $element = variable_get('mr_sectiontitle_element');
      $is_id = trim(variable_get('mr_sectiontitle_id'));
      
      $markup = array();
      $markup[] = '<' . $element;
      if ($is_id) {
        $markup[] = ' id="' . $is_id .'"';
      }
      $markup[] = '>';
      $markup[] = trim($node->{$field_name}[LANGUAGE_NONE][0]['value']);
      $markup[] = '</' . $element . '>';

      $vars['content'] = implode($markup);
    }
  }
}