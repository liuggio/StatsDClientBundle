## Abstract

Monitor what is happening in your production Symfony2 application, with StatD and Graphite.

Within this bundle you could use ready-to-go monitor for

- Amount of user

- Logged vs Anonymous user

- SQL: Verbs used (amount of select/set/update/upgrade/delete)

- SQL: amount of time consumed by the query

- Amount of PHP ram used



And in your application you could use the service for send packet to StatD Server using the service
or create a personalized Event/Listener (suggested)

## Screenshot Graphite

http://blog.signalhq.com/wp-content/uploads/2011/12/graphite.png

http://graphite.wdfiles.com/local--files/screen-shots/graphite_fullscreen_800.png

http://graphite.wdfiles.com/local--files/screen-shots/graphite_cli_800.png


## Theory


#### [StatD](https://github.com/etsy/statsd)

StatD is a simple daemon for easy stats aggregation

#### [Graphite](http://graphite.wikidot.com/)

Graphite is a Scalable Realtime Graphing

#### The Client send data with UDP (faster)

https://www.google.com/search?q=tcp+vs+udp


## Installation

You have to install etsy/statd and Graphite

Install bundle with composer and add to kernel

``` yaml

liuggio_stats_d_client:
  connection:
    host: 31.222.167.143
    port: 8125
    fail_silently: true
  enable_collector: true
  collectors:
    liuggio_stats_d_client.collector.dbal: 'terravision.query'
    liuggio_stats_d_client.collector.visitor: 'terravision.visitor'
    liuggio_stats_d_client.collector.memory: 'terravision.memory'
    liuggio_stats_d_client.collector.user: 'terravision.user'

```

@todo improve this


## Test

@todo


# Advanced Usage

## What's in this bundle:

### StatsDataFactory

This service creates object (StatsDataInterface) to send

Reference: `liuggio_stats_d_client.factory`

### StatDClient

Reference: `liuggio_stats_d_client.service`

This service SEND the data over the UDP interface

from a controller call ``` $this->get('liuggio_stats_d_client.service')->send($StatData) ```

the `$StatData` is an object created by the factory

### StatsDCollectorService

Reference: `liuggio_stats_d_client.collector.service`

This service is called by the listener to collect data from all the collectors installed



## How to create your personal Collector

Create a class that extends StatsCollector then create the `collect` function

```
use Liuggio\StatsDClientBundle\StatsCollector\StatsCollector;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class StatsCollector extends StatsCollector

//...

 public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $statData = $this->getStatsDataFactory()->createStatsDataIncrement($this->getStatsDataKey());
        $this->addStatsData($statData);

        return true;
    }

```

## The Flow

The CollectorService collects all the collector classes that have a tag `data_collector` in their definition

1. A listener `StatsDCollectorListener` is subscribed to kernel events,

2. When an Event is thrown, `StatsDCollectorService` is called withe arguments (Response, Request, Exception)

3. `StatsDCollectorService`  calls all registered collectors that have `StatsCollectorInterface`

4. `StatsDCollectorService` sends all data to StatsDClientService

5. `StatsDClientService` provides to send to the server

6. On Graphite you'll have all data and all that happens in your application symfony2


