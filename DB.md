# 数据库类项目框架

#### 1、增加了数据库访问日志

通过这个日志，你可以观察并统计数据请求类型以及耗时状况，帮助你随时发现数据库请求瓶颈并及时进行优化

#### 2、利用metadata缓存提高数据库访问性能

默认生产环境使用Redis缓存metadata，其他环境则使用Phalcon自带的Memcache（仅当次请求周期内有效）

#### 3、关于数据表中的created_at和updated_at字段
 
* 这两个字段在每个数据表中都必须存在，且按如下定义
    ```
    created_at datetime comment '创建时间',
    updated_at timestamp comment '更新时间', 
    ```   
* phalcon命令执行时.env还没有生效，故用phalcon命令创建model前需修改config.php中数据库设置默认值为当前开发环境实际值,如下面的代码片段
    ```php
    'database' => [
        'adapter'    => 'Mysql',
        'host'     => getenv('DB_HOST') ?: 'localhost',
        'username' => getenv('DB_USERNAME') ?: 'root',
        'password' => getenv('DB_PASSWORD') ?: 'test123456',
        'dbname'   => getenv('DB_DATABASE') ?: 'database',
        'charset'    => 'utf8',
    ],
    ```
* 使用phalcon命令创建model时，一定要使用`--excludefields=udated_at`参数
* 按照如上设置后，插入数据时created_at和updated_at将自动生成，created_at是通过工具生成model的以下代码实现
    ```php
   public function initialize()
    {
        $this->setSchema("qin_user");
        $this->setSource("user");
        $this->hasMany('id', 'Child', 'user_id', ['alias' => 'Child']);

        // created_at必须为nullable=true
        $this->addBehavior(
            new \Phalcon\Mvc\Model\Behavior\Timestampable(
                [
                    'beforeCreate' => [
                        'field' => 'created_at',
                        'format'=> 'Y-m-d H:i:s',
                    ]
                ]
            )
        );
    }
    ```
#### 4、关于Mysql

鉴于Mysql流行程度以及为了代码简洁度，项目框架仅绑定了Mysql。但开发者随时可以更换为自己喜欢的其他数据库。

#### 5、目前支持数据库的项目框架
* cli
* microweb
* web
* baseapi
