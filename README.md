# queue-bundle

供symfony2.8、symfony3.4使用的一个基于redis的任务队列


## 安装

## 配置

注册bundle

```php
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            ...
            new Jaggle\QueueBundle\JaggleQueueBundle(),
        ...
        ];
        ...
     }
     ...
}
```