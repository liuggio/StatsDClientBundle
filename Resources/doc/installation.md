Installation
============

* 1 First, add the dependent bundles to the vendor/bundles directory. Add the following lines to the composer.json file

```
"require": {
    # ..
    "liuggio/statsd-client-bundle": "1.6.*",
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

* 5 When you are in develop env (mmm when kernel.debug is true) the packets use the SyslogSender
see [full-configuration](#full-configuration--max-power) in order to modify it


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
    level: 'warning'
    formatter:
       context_logging: true # if you want additional packets for context, default is false.
       extra_logging: true   # if you want additional packets for extra, default is false.
       words: 2              # the number of the word in the stats key, default is 2.

```

But you also have to say to Monolog to use that handler

``` yaml
# app/config/config.yml

monolog:
    handlers:
        main:
            type:         fingers_crossed
            action_level: warning
            handler:      streamed
        streamed:
            type:  stream
            path:  %kernel.logs_dir%/%kernel.environment%.log
            level: critical
#----------------------------------
        stats_d:
            type:  service
            id: liuggio_stats_d_client.monolog.handler
            level: warning
#            channels:
#                type:     exclusive # Include all, except those listed below
#                elements: [ ]

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
    liuggio_stats_d_client.collector.time: 'my-app.time' # the time is a "fake" one, it is ~100ms smaller than the Kernel but you can still monitor the evolution of your application


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
    formatter:
#       class:               # if you want to change the formatter class.
#       format:              # if you want to change the format.
       context_logging: true # if you want additional packets for context.
       extra_logging: true   # if you want additional packets for extra.
       words: 2              # the number of the word in the stats key.
    level: 'warning'
    context_logging: true
  connection:
#    class: Liuggio\StatsdClient\Sender\SocketSender
#    debug_class: Liuggio\StatsdClient\Sender\SysLogSender # or EchoSender
#    debug: %kernel.debug%   # use false if you want to disable debugging and shot packet over Socket
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
    liuggio_stats_d_client.collector.time: 'my-app.time'


```

