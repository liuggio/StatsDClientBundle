StatsD Client Bundle
===================

[![Total Downloads](https://poser.pugx.org/liuggio/statsd-client-bundle/downloads.png)](https://packagist.org/packages/liuggio/statsd-client-bundle) [![Latest Stable Version](https://poser.pugx.org/liuggio/statsd-client-bundle/v/stable.png)](https://packagist.org/packages/liuggio/statsd-client-bundle) [![Build Status](https://secure.travis-ci.org/liuggio/StatsDClientBundle.png)](http://travis-ci.org/liuggio/StatsDClientBundle)

This bundle helps you to monitor your application.

It uses [statsd-php-client](https://github.com/liuggio/statsd-php-client) as **Client** for the etsy/Statsd API.

It Includes

* a **Service**, a **Factory** and an Entity callable by the DIC
* a **Monolog Handler**
* a series of **Collectors** in order to aggregate your personal data.
* a series of **Commands** in order to execute data also from cli.

## Check out the documentation

* [Installation and Usage](https://github.com/liuggio/StatsDClientBundle/blob/master/Resources/doc/installation.md)
* [Advanced usage](https://github.com/liuggio/StatsDClientBundle/blob/master/Resources/doc/advanced.md)

## Articles

* [Article:  ServerGrove - Interesting Symfony Bundles: StatsDClientBundle](http://blog.servergrove.com/2012/10/09/interesting-symfony-bundles-statsdclientbundle)
* [Article : Install Stats.d / Graphite on a debian server in order to monitor a Symfony2 application (1/2) ](http://www.elao.com/blog/linux/install-stats-d-graphite-on-a-debian-server-to-monitor-a-symfony2-application-12.html)
* [Article : Monitor your Symfony2 application via Stats.d and Graphite (2/2) ](http://www.elao.com/blog/symfony-2/monitor-your-symfony2-application-via-stats-d-and-graphite-22.html)
* [Slide : Building OpenSky with Symfony2 by Jonathan H. Wage](https://speakerdeck.com/jwage/building-opensky-with-symfony2)

## Abstract

Monitoring what is happening in your production Symfony2 application, with StatsD and Graphite.

Within this bundle you could use ready-to-go monitor for

- Monolog

- Amount of visitor

- Logged vs Anonymous user

- SQL: Verbs used (amount of select/set/update/upgrade/delete) (this feature is not suggested, please use a server monitor tool eg. nagios, munin)

- Amount of PHP ram used

- You could create your own using the Factory and the Service.

### On dev env the data are not pushed to the socket but to syslog.

If debug mode is enabled no packet are sent over the udp socket, and you could see what's going on reading the syslog with `tail -f /var/log/syslog`

```log
Mar 19 00:48:11 liuggio nginx: statsd-open
Mar 19 00:48:11 liuggio nginx: statsd-write "tvision.visitor:1|tvision.memory:43520|tvision.user.anonymous:1|tvision.query.start:1|tvision.query.insert:1|c" 118 Bytes
Mar 19 00:48:11 liuggio nginx: statsd-close
```
Note: by default in `dev` environment debug is true.

One UDP packet to rule them all
-------------------------------

With a proper config file, your StatsD server will receive in a single upd packet:

```txt
prefix.visitor:1|c                  # Increment visitor
prefix.user.anonymous:1|c           # The visitor is not logged

prefix.log.app.error.user_action:1  # Stats by monolog with $this->get('logger')->error('user_action')

prefix.memory:4480|g                # The php memory peak was 4480 MB

prefix.exception.exception.500:1|c  # Exception occurred, the Exception code was 500

prefix.query.insert:1|c             # Query Insert
prefix.query.select:1|c             # Query Select
```

## Short Theory and links

### Vagrant StatSD and Graphite

see this blog post to install [Easy install statsd graphite with vagrant](http://welcometothebundle.com/easily-install-statsd-and-graphite-with-vagrant/).

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




