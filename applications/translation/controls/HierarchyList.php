<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HierarchyList
 *
 * @author kimomicho
 */

include_once '../../../classes/BLL/BLL_hierarchies.php';
include_once '../../../classes/DAL/DAL_hierarchies.php';

function LoadHierarchyList($auto_submit, $onchange_function, $selected_index)
{   
    

    $hierarchies = BLL_hierarchies::load_all();

    ?>
    <select name="lstHierarchy"
            <?
            if ($auto_submit)
                printf('onchange="document.frm.submit();"');
            if ($onchange_function!='')
                printf('onchange="'.$onchange_function.'(this.value)"');
            ?> style="width: 100%">
        <option value="0"></option>
        <?
        foreach ($hierarchies as $hierarchy)
        {
            printf('<option value="'.$hierarchy->id.'" ');
            if ($selected_index==$hierarchy->id)
                   printf('selected="true"') ;
            printf('>'.$hierarchy->label.'</option>');
        }
        ?>
    </select>
    <?
}
?>