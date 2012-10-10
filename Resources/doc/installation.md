Installation
============

* 1 To begin, add the dependent bundles to the vendor/bundles directory. Add the following lines to the composer.json file

```
"require": {
    # ..
    "liuggio/statsd-client-bundle": ">1.0.0",
    # ..
}
```

* 2 Then run `composer install`


* 3 Then add in your `app/AppKernel`

``` yaml

 class AppKernel extends Kernel
 {
     public function registerBundles()
     {
         $bundles = array(
         // ...
            new Liuggio\StatsDClientBundle\LiuggioStatsDClientBundle(),
         // ...

```

* 4 Then add to config/yaml the minimum configuration

``` yaml

# app/config/config.yml
liuggio_stats_d_client:
  connection:
    host: localhost
    port: 8125
    fail_silently: true
  enable_collector: false #default is false

```

Working with the `Service`
-------------

### StatsDataFactory

This service creates object (StatsDataInterface) to send

Reference: `liuggio_stats_d_client.factory`

```
$data = $this->get('liuggio_stats_d_client.factory')->createStatsDataIncrement('log.error');

```

### StatDClient

Reference: `liuggio_stats_d_client.service`

This service SEND the data over the UDP interface

from a controller call ``` $this->get('liuggio_stats_d_client.service')->send($data) ```

the `$data` is the object created by the factory

and the send will reduce the data to send, in order to speed up the connections.



Working with `Monolog`
-------------

To Monitorize your log, add the following lines to your application configuration
file, in order to enable the StatsDHandler


``` yaml
# app/config/config.yml

liuggio_stats_d_client:
  connection:
    host: localhost
    port: 8125
    fail_silently: true
  enable_collector: false #default is false
  monolog:
    enable: true
    prefix: 'log'
    formatter: 'monolog.formatter.shortline' # is optional but this will prettify the statsd key
    level: 'warning'
    context_logging: false # with this option you could also have the monolog context variable in your graphs


```

But you also have to say to Monolog to use that handler

``` yaml
# app/config/config.yml

monolog:
    handlers:
        main:
            type:         fingers_crossed
            action_level: warning
            handler:      grouped
        grouped:
            type:    group
            members: [streamed, stats_d]
        stats_d:
            type:  service
            id: monolog.handler.statsd
            level: warning
#            channels:
#                type:     exclusive # Include all, except those listed below
#                elements: [ ]
        streamed
            type:  stream
            path:  %kernel.logs_dir%/%kernel.environment%.log
            level: critical

```


Working with Personal Collector
-------------

If the information Monolog are not enough for you, you can use the Collectors that collect the information and then send data to StatsD Server.

# TODO


1. Tests cover just the 40% more test: on Compiler/Listener

    Planned for: end of July

2. Better stat for existing collector

3. More StatsCollectors+test

4. Spit the StatsDService into a library decoupled with bundles

5. Logging integrated for debugging

5. Better example usage and explanation
Some Collectors are into the StatsCollector folder, but you can build your own personal collector.
The idea of the collector follows many of the Symfony2 Profiler.


``` yaml

# app/config/config.yml
liuggio_stats_d_client:
  connection:
    host: localhost
    port: 8125
    fail_silently: true
  enable_collector: true
  collectors:
    liuggio_stats_d_client.collector.dbal: 'collect.query'
    liuggio_stats_d_client.collector.visitor: 'collect.visitor'
    liuggio_stats_d_client.collector.memory: 'collect.memory'
    liuggio_stats_d_client.collector.user: 'collect.user'
    liuggio_stats_d_client.collector.exception: 'collect.exception'


```

For example the `liuggio_stats_d_client.collector.dbal` will collect a lot of information about doctrine logging.



Full Configuration / Max Power
------------


then add to config/yaml

``` yaml

# app/config/config.yml
liuggio_stats_d_client:
  monolog:
    enable: true
    prefix: 'log'
    formatter: 'monolog.formatter.shortline'
    level: 'warning'
    context_logging: true
  connection:
    host: localhost
    port: 8125
    fail_silently: true
  enable_collector: true
  collectors:
    liuggio_stats_d_client.collector.dbal: 'tvision.query'
    liuggio_stats_d_client.collector.visitor: 'tvision.visitor'
    liuggio_stats_d_client.collector.memory: 'tvision.memory'
    liuggio_stats_d_client.collector.user: 'tvision.user'
    liuggio_stats_d_client.collector.exception: 'tvision.exception'



```
