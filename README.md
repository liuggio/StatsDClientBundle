## Abstract

Monitoring what is happening in your production Symfony2 application, with StatD and Graphite.

Within this bundle you could use ready-to-go monitor for

- Monolog (this is a new feature)

- Amount of user

- Logged vs Anonymous user

- SQL: Verbs used (amount of select/set/update/upgrade/delete) (this feature is not suggested, please use a server monitor tool eg. nagios, munin)

- Amount of PHP ram used


And in your application you could use the service for send packet to StatsD Server using the service
or create a personalized Event/Listener

## Screenshot Graphite

http://graphite.wdfiles.com/local--files/screen-shots/graphite_fullscreen_800.png

http://graphite.wdfiles.com/local--files/screen-shots/graphite_cli_800.png


## Installation

You have to install etsy/statd and Graphite 

see this blog post to install it with vagrant [Easy install statsd graphite](http://welcometothebundle.com/easily-install-statsd-and-graphite-with-vagrant/).

add to your composer

``` 
"require": {
    # ..
    "liuggio/statsd-client-bundle": "v1.0.0"`
    # ..
}
```

then add to config/yaml

``` yaml

liuggio_stats_d_client:
  monolog:
    enable: true
    prefix: 'log'
    formatter: 'monolog.formatter.shortline'
    level: 'warning'
    context_logging: false # with this option you could also have the context in your graphs
  connection:
    host: localhost
    port: 8125
    fail_silently: true
  enable_collector: true #default is false, and it won't work
  collectors:
    liuggio_stats_d_client.collector.dbal: 'tvision.query'
    liuggio_stats_d_client.collector.visitor: 'tvision.visitor'
    liuggio_stats_d_client.collector.memory: 'tvision.memory'
    liuggio_stats_d_client.collector.user: 'tvision.user'
    liuggio_stats_d_client.collector.exception: 'tvision.exception'
## or
#    enable_collector: false


```

If you want to use monolog 

```

monolog:
    handlers:
        main:
            type:         fingers_crossed
            action_level: info #critical for 5xx problems, error for 4xx and 5xx problems
            handler:      grouped
        grouped:
            type:    group
            members: [streamed, stats_d]
        stats_d:
            type:  service
            id: monolog.handler.statsd
            level: error
            action_level: error
#            channels:
#                type:     exclusive # Include all, except those listed below
#                elements: [ ]
        streamed
            type:  stream
            path:  %kernel.logs_dir%/%kernel.environment%.log
            level: info

```



## Theory


#### [StatD](https://github.com/etsy/statsd)

StatD is a simple daemon for easy stats aggregation

#### [Graphite](http://graphite.wikidot.com/)

Graphite is a Scalable Realtime Graphing

#### The Client send data with UDP (faster)

https://www.google.com/search?q=tcp+vs+udp


## Contribution

Active contribution and patches are very welcome.
To keep things in shape we have quite a bunch of unit tests. If you're submitting pull requests please
make sure that they are still passing and if you add functionality please
take a look at the coverage as well it should be pretty high :)

- First fork or clone the repository

```
git clone git://github.com/liuggio/StatsDClientBundle.git
cd StatsDClientBundle
```

- Install vendors:

``` bash
composer.phar install
```

- This will give you proper results:

``` bash
phpunit --coverage-html reports
```



# Advanced Usage

## What's in this bundle:

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

### StatsDCollectorService

Reference: `liuggio_stats_d_client.collector.service`

This service is called by the listener to collect data from all the collectors installed


## How to create your personal Collector


- Create a class that extends StatsCollector then create the `collect` function

```
use Liuggio\StatsDClientBundle\StatsCollector\StatsCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ExceptionStatsCollector extends StatsCollector

//...

    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        if ...
        $statData = $this->getStatsDataFactory()->createStatsDataIncrement($this->getStatsDataKey());
        $this->addStatsData($statData);

        return true;
    }

```


- add the service

```
     liuggio_stats_d_client.collector.exception:
         class: %THE CLASS%
         tags:
             - { name: stats_d_collector} #this is important, this will be selected by the CollectorService

```

- enable it in the config.yml

```
  collectors:
#    serviceReference: prefix
    liuggio_stats_d_client.collector.exception: 'YOURNAME.exception'
```




## The Flow

The CollectorService collects all the collector classes that have a tag `data_collector` in their definition

1. A listener `StatsDCollectorListener` is subscribed to kernel events only if  the parameter `enable_collector` is true

2. When an Event is thrown, `StatsDCollectorService` is called withe arguments (Response, Request, Exception)

3. `StatsDCollectorService`  calls all the registered collectors that have `StatsCollectorInterface`

4. `StatsDCollectorService` sends all data to StatsDClientService

5. `StatsDClientService` provides to send to the server

6. On Graphite you'll have all data and all that happens in your Symfony2 application

A similar pattern is used by the Profiler in Symfony


# TODO


1. Tests cover just the 40% more test: on Compiler/Listener

    Planned for: end of July

2. Better stat for existing collector

3. More StatsCollectors+test

4. Spit the StatsDService into a library decoupled with bundles 

5. Logging integrated for debugging

5. Better example usage and explaination