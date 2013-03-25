Installation
============

* 1 First, add the dependent bundles to the vendor/bundles directory. Add the following lines to the composer.json file

```
"require": {
    # ..
    "liuggio/statsd-client-bundle": ">=1.4.2",
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

* 4 Then add to config/yaml the minimal configuration

``` yaml

# app/config/config.yml
liuggio_stats_d_client:
  connection:
    host: localhost
    port: 8125

```

Working with the `Service`
-------------

### StatsdDataFactory

This service creates the (StatsDataInterface) object to send

Reference: `liuggio_stats_d_client.factory`

```
$data = $this->get('liuggio_stats_d_client.factory')->increment('log.error');

```

### StatsDClient

Reference: `liuggio_stats_d_client.service`

This service SENDS the data over the UDP interface

from a controller call ``` $this->get('liuggio_stats_d_client.service')->send($data) ```

the `$data` is the object created by the factory

the send method will optimise the data sent in order to speed up the connection.



Working with `Monolog`
-------------

To monitor your logs, add the following lines to your application configuration
file, in order to enable the StatsDHandler


``` yaml
# app/config/config.yml

liuggio_stats_d_client:
  connection:
    host: localhost
    port: 8125
    protocol: udp
    reduce_packet: true
    fail_silently: true
  enable_collector: false #default is false
  monolog:
    enable: true
    prefix: 'my-app'
    formatter: 'monolog.formatter.shortline' # optional but this will prettify the statsd key
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
        streamed:
            type:  stream
            path:  %kernel.logs_dir%/%kernel.environment%.log
            level: critical

```


Working with Personal Collector
-------------

If the information from Monolog is not enough for you, you can use the Collectors that collect the information and then send the data to the StatsD Server.


``` yaml

# app/config/config.yml
liuggio_stats_d_client:
  connection:
    host: localhost
    port: 8125
    protocol: udp
    reduce_packet: true
    fail_silently: true
  enable_collector: true
  collectors:
    liuggio_stats_d_client.collector.dbal: 'my-app.query'
    liuggio_stats_d_client.collector.visitor: 'my-app.visitor'
    liuggio_stats_d_client.collector.memory: 'my-app.memory'
    liuggio_stats_d_client.collector.user: 'my-app.user'
    liuggio_stats_d_client.collector.exception: 'my-app.exception'


```

For example the `liuggio_stats_d_client.collector.dbal` will collect a lot of the information provided by the doctrine logging.

In order to enable the query collector you also have to add to your doctrine.dbal the profiling variable from your config.yml
eg.
``` yaml

# Doctrine Configuration
doctrine:
    dbal:
        profiling: true

```



Full Configuration / Max Power
------------


then add to config/yaml

``` yaml

# app/config/config.yml
liuggio_stats_d_client:
  monolog:
    enable: true
    prefix: 'my-app.log'
    formatter: 'monolog.formatter.shortline'
    level: 'warning'
    context_logging: true
  connection:
 #   class: Liuggio\StatsdClient\Sender\SocketSender
 #   debug_class: Liuggio\StatsdClient\Sender\SysLogSender # or EchoSender
 #   debug: %kernel.debug%   # use false if you want to disable debugging and shot packet over Socket
    host: localhost
    port: 8125
#    protocol: udp
#    reduce_packet: true
#    fail_silently: true
  enable_collector: true
  collectors:
    liuggio_stats_d_client.collector.dbal: 'my-app.query'
    liuggio_stats_d_client.collector.visitor: 'my-app.visitor'
    liuggio_stats_d_client.collector.memory: 'my-app.memory'
    liuggio_stats_d_client.collector.user: 'my-app.user'
    liuggio_stats_d_client.collector.exception: 'my-app.exception'


```

