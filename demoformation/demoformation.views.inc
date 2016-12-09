<?php

 function demoformation_views_data_alter(array &$data){
   $data['node']['random'] = array(
     'title' => t('Random field'),
     'field' => array(
       'title' => t('Random field'),
       'help'  => t('Champs random entre 0 et la valeur de l option'),
       'id' => 'random_field',
     )
   );
 }
