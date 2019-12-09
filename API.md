# API类项目框架

#### 1、紧凑的结构和高效的性能

API类项目框架都采用了Phalcon提供的MVC微应用框架（Phalcon/Mvc/Micro），适合于瘦应用，很少的代码即可实现强大的功能。

#### 2、精简的代码

去除了所有与前端有关的代码（包括css, js和 view），并根据实际需求提供了多个不同用途的API项目框架供选用，最简单的项目你仅需添加几行代码即可实现

#### 3、提供了统一的API输出

提供了统一的json输出方法（包括错误和异常状况下的输出）和输出状态配置文件。输出格式为：

```
{
    code: 0,
    status: 'ok',
    detail: [
        {
            'user_id': 1,
            'user_name': 'david',
            'sex': 1,
            'age': 13
        },
        {
            'user_id': 2,
            'user_name': 'tom',
            'sex': 2,
            'age': 13
        }
    ]
}
```

#### 4、目前提供的API类项目模版
* simpleapi
* baseapi
* api

