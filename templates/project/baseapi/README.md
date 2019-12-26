# 主要功能

用于封装底层数据库访问的基础API

## 具体环境要求

0. PHP-FPM >= 7.2
1. PHP框架：Phalcon >= 3.3
2. 开发工具：[yinxingping/phalcon-devtools](https://github.com/yinxingping/phalcon-devtools)

## 注意事项

1. 为了使用自动添加created_at的功能，数据库字段created_at必须设置默认为null
2. 用工具生成model时.env部分没有生效，所以需要在config.php中修改数据库连接相关默认参数为实际开发环境的参数
3. 生成模型的命令：
```
phalcon model --excludefields=updated_at --extends=ModelBase --annotate --name=shops
```

