StatsD Client Bundle v1.2.x
===================

[![Build Status](https://secure.travis-ci.org/liuggio/StatsDClientBundle.png)](http://travis-ci.org/liuggio/StatsDClientBundle)

This bundle helps you to monitor your application.

It uses [statsd-php-client](https://github.com/liuggio/statsd-php-client) as **Client** for the etsy/Statsd API.

It Includes

* a **Service**, a **Factory** and an Entity callable by the DIC
* a **Monolog Handler**
* a series of **Collectors** in order to aggregate your personal data.


## Check out the documentation

* [Installation and Usage](https://github.com/liuggio/StatsDClientBundle/blob/master/Resources/doc/installation.md)
* [Advanced usage](https://github.com/liuggio/StatsDClientBundle/blob/master/Resources/doc/advanced.md)

## Abstract

Monitoring what is happening in your production Symfony2 application, with StatsD and Graphite.

Within this bundle you could use ready-to-go monitor for

- Monolog (this is a new feature)

- Amount of user (collector)

- Logged vs Anonymous user (collector)

- SQL: Verbs used (amount of select/set/update/upgrade/delete) (this feature is not suggested, please use a server monitor tool eg. nagios, munin)

- Amount of PHP ram used (collector)



## Short Theory

### Easily Install StatSD and Graphite

In order to try this application monitor you have to install etsy/statsd and Graphite

see this blog post to install it with vagrant [Easy install statsd graphite](http://welcometothebundle.com/easily-install-statsd-and-graphite-with-vagrant/).


#### [StatsD](https://github.com/etsy/statsd)

StatsD is a simple daemon for easy stats aggregation

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
php composer.phar install --dev
```

- This will give you proper results:

``` bash
phpunit --coverage-html reports
```


## Contributors

https://github.com/liuggio/StatsDClientBundle/graphs/contributors




