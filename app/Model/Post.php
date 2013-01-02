<?php
/**
 * Created by Webonise Lab.
 * User: Hrishikesh
 * Date: 28/12/12 6:19 PM
 */
class Post extends AppModel
{
    public $validate = array(
        'title' => array(
            'rule' => 'notEmpty'
        ),
        'body' => array(
            'rule' => 'notEmpty'
        )
    );
}
