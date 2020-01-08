<?php

class ModelBase extends \Phalcon\Mvc\Model
{

    public function initialize()
    {
        //读写分离设置
        //$this->setReadConnectionService('dbRead');
        //$this->setWriteConnectionService('dbWrite');

        //仅向数据库传递改变了的字段
        $this->useDynamicUpdate(true);
    }

    public function beforeCreate()
    {
        $this->created_at = $this->updated_at = date('Y-m-d H:i:s');
    }

    public function beforeUpdate()
    {
        $this->updated_at = date('Y-m-d H:i:s');
    }

}

