<?php
/**
 * Description of AP_EditCommentsDelete
 *
 * @author olga
 */
class AP_CommentsDelete extends AdminPanel_ComponentPanelUI_Element_Delete {
    
    protected function setDeleteQuery() {
        $this->deleteQuery = "DELETE FROM `Feedbacks` WHERE `id`='".$this->alias."';";
    }

    protected function checkAlias() {
        $query = "SELECT * FROM `Feedbacks` WHERE `id`='".$this->alias."';";
        $result = $this->SQL_HELPER->select($query,1);
        return count($result) > 0;
    }
}