# 关于 yinxingping/phalcon-devtools

本项目基于[Phalcon](https://phalcon.io)的官方开发工具[phalcon-devtools](https://github.com/phalcon/phalcon-devtools)二次开发，适用于中国开发者进行API、WEB、CLI开发，利用此工具可大幅提升团队/个人开发效率。

一、全局性增加的功能
---
#### 1、增加.env配置

官方提供的项目框架没有将开发、测试、生产环境的配置文件分开，对于利用github公开方式托管代码的个人和小团队来说配置文件更涉及安全性，yinxingping/phalcon-devtools借助`vlucas/phpdotenv`实现配置和代码分开，开发环境的.env开发人员自己管理，测试和生产环境的.env由专门的运维人员管理和发布。

#### 2、增加默认时区

时区默认设置为"中国-上海"，避免时间混乱问题

#### 3、增加日志处理

根据.env中的APP_ENV设置（dev/test/production），production仅输出重要的日志；可以配置日志文件的位置

#### 4、项目框架自动创建README.md

可以利用README.md对项目功能、环境、部署等进行说明

#### 5、替换依赖注入器

官方开发工具为了降低初学者学习门槛，直接使用`Phalcon\Di\FactoryDefault`容器，这个容器默认包含了22个服务；yinxingping/phalcon-devtools改为空的容器`Phalcon\Di`,根据项目需求用到哪个服务注册哪个服务，最大程度降低占用，提升性能

二、全局性取消的功能
---
* 取消webtools工具
* 取消ini支持

三、不同类型项目框架的具体修改
---
* [DB类项目框架](./DB.md)
* [API类项目框架](./API.md)
* [WEB类项目框架](./WEB.md)

四、yinxingping/phalcon-devtools项目框架类型简介
---
#### 1、cli
适合开发命令行应用，如爬虫、后台处理等

#### 2、web
适合开发功能完整的网站

#### 3、simpleapi
适合开发不使用数据库的简单API，如文件请求、搜索引擎等的封装接口

#### 4、baseapi
适合开发封装底层数据库访问的基础API

#### 5、api
适合开发直接为客户端提供服务前端API

五、推荐环境配置
---
* 操作系统：Linux
* Web服务器：Nginx + PHP-FPM 7.0+
* Phalcon >= 3.3
* 数据库：MySQL
* 缓存和Session：Redis
* Composer

六、安装和配置
---

```bash
# 以下配置可用于linux和macOS

# 第一步：下载yinxingping/phalcon-devtools到指定目录，如/home/myname/public
cd /home/myname/public;
git clone git@github.com:yinxingping/phalcon-devtools.git

# 第二步：配置~/.bashrc,添加以下项
export PTOOLSPATH=/home/myname/public/phalcon-devtools
export PATH=$PTOOLSPATH:$PATH

# 第三步：保存~/.bashrc后使设置生效
source ~/.bashrc

# 第四步：验证
cd /home/myname/Workspace;
phalcon project my-first-phalcon microweb

# 第五步：将.env文件加入到.gitignore中
```

看到绿色的"Success: Project 'my-first-phalcon' was successfully created..."即表示成功。

七、phpstorm自动完成设置
---
1. 下载[Phalcon框架接口包](https://github.com/phalcon/ide-stubs)；
2. phpstorm新建项目后，右键点击 *External Libraries*，选择 *Configure PHP Include Paths*
3. 点击 *+*，选择*ide-stubs*下的*src/Phalcon*，即可将接口导入
4. 之后开发过程即可使用Phalcon框架的代码提示和自动完成


八、相关链接
---

Phalcon官网：
https://phalcon.io

Phalcon框架：
https://github.com/phalcon/cphalcon

Phalcon-devtools官方开发工具：
https://github.com/phalcon/phalcon-devtools

PHP+Phalcon之docker镜像
https://hub.docker.com/repository/docker/yinxingping/php
