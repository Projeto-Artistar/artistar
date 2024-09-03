<?php


namespace Source\Model;

use PDO;


class CoreModal extends Core
{

    public function __construct()
    {
        global $db;
        $this->db=$db;
    }

    public function carregaSideBar($sidebar){

        try {
            $query = $this->db->prepare(" 
                select nm_sidebar, itsb.nm_item, itsb.url, itsb.class_icone, subsb.nm_item, subsb.url
                    from sidebar as s inner join itens_sidebar itsb on s.cd_sidebar = itsb.cd_sidebar
                        left join sub_sidebar as subsb on subsb.cd_item_sidebar = itsb.cd_item_sidebar
                            order by itsb.vl_ordem, subsb.vl_ordem where nm_sidebar = :sidebar;           
            ");
            $query->execute(array(
                ':sidebar' => $sidebar
            ));

            if ($query->rowCount() > 0) {
                return array("Erro" => false, "data" => $query->fetchall(PDO::FETCH_ASSOC));
            } else {
                return array("Erro" => true, "data" =>"Sidebar não econtrado");
            }
        } catch (PDOException $e) {
            echo 'Erro ao carregar Sidebar: ' . $e->getMessage();
        }
    }


}

