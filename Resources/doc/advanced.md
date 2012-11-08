Advanced use
============

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
        $statData = $this->getStatsdDataFactory()->increment($this->getStatsDataKey());
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

4. `StatsDCollectorService` sends all data to StatsdClientInterface

5. `StatsdClientInterface` provides to send to the server

6. On Graphite you'll have all data and all that happens in your Symfony2 application

A similar pattern is used by the Profiler in Symfony
