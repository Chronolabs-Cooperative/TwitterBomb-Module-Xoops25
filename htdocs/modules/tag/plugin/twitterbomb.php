<?php
if (!defined('XOOPS_ROOT_PATH')) { exit(); }

function twitterbomb_tag_iteminfo(&$items)
{
    if (empty($items) || !is_array($items)) {
        return false;
    }
    
    $items_id = array();
    foreach (array_keys($items) as $cat_id) {
        // Some handling here to build the link upon catid
        // catid is not used in twitterbomb, so just skip it
        foreach (array_keys($items[$cat_id]) as $item_id) {
            // In twitterbomb, the item_id is "topic_id"
            $items_id[] = intval($item_id);
        }
    }
    $item_handler =& xoops_getmodulehandler('log', 'twitterbomb');
    $items_obj = $item_handler->getObjects(new Criteria("lid", "(" . implode(", ", $items_id) . ")", "IN"), true);
    $myts =& MyTextSanitizer::getInstance();
    foreach (array_keys($items) as $cat_id) {
        foreach (array_keys($items[$cat_id]) as $item_id) {
            $item_obj =& $items_obj[$item_id];
            if (is_object($item_obj))
			$items[$cat_id][$item_id] = array(
                "title"     => $item_obj->getVar("tweet"),
                "uid"       => $item_obj->getVar("uid"),
                "link"      => 'go.php?lid='.$item_id.'&sid='.$item_obj->getVar("sid").'&cid='.$item_obj->getVar("cid").'&catid='.$item_obj->getVar("catid").'&uri='.$item_obj->getVar("url"),
                "time"      => $item_obj->getVar("date"),
                "tags"      => tag_parse_tag($item_obj->getVar("tags", "n")),
                "content"   => $myts->displayTarea($item_obj->getVar("tweet"),true,true,true,true,true,true)
                );
        }
    }
    unset($items_obj);    
}

/**
 * Remove orphan tag-item links
 *
 * @return    boolean
 * 
 */
function twitterbomb_tag_synchronization($mid)
{
    $item_handler =& xoops_getmodulehandler("log", "twitterbomb");
    $link_handler =& xoops_getmodulehandler("link", "tag");
        
    /* clear tag-item links */
    if (version_compare( mysql_get_server_info(), "4.1.0", "ge" )):
    $sql =  "    DELETE FROM {$link_handler->table}" .
            "    WHERE " .
            "        tag_modid = {$mid}" .
            "        AND " .
            "        ( tag_itemid NOT IN " .
            "            ( SELECT DISTINCT {$item_handler->keyName} " .
            "                FROM {$item_handler->table} " .
            "                WHERE {$item_handler->table}.approved > 0" .
            "            ) " .
            "        )";
    else:
    $sql =  "    DELETE {$link_handler->table} FROM {$link_handler->table}" .
            "    LEFT JOIN {$item_handler->table} AS aa ON {$link_handler->table}.tag_itemid = aa.{$item_handler->keyName} " .
            "    WHERE " .
            "        tag_modid = {$mid}" .
            "        AND " .
            "        ( aa.{$item_handler->keyName} IS NULL" .
            "            OR aa.approved < 1" .
            "        )";
    endif;
    if (!$result = $link_handler->db->queryF($sql)) {
        //xoops_error($link_handler->db->error());
    }
}
?>