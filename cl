{
    "hash": "e707d4c26ee0f2d98da5b6fd0692d054",
    "packages": [
        {
            "name": "doctrine/common",
            "version": "2.2.3",
            "source": {
                "type": "git",
                "url": "https://github.com/doctrine/common",
                "reference": "2.2.3"
            },
            "dist": {
                "type": "zip",
                "url": "https://github.com/doctrine/common/zipball/2.2.3",
                "reference": "2.2.3",
                "shasum": ""
            },
            "require": {
                "php": ">=5.3.2"
            },
            "time": "2012-08-29 08:04:14",
            "type": "library",
            "installation-source": "dist",
            "autoload": {
                "psr-0": {
                    "Doctrine\\Common": "lib/"
                }
            },
            "license": [
                "LGPL"
            ],
            "authors": [
                {
                    "name": "Jonathan Wage",
                    "email": "jonwage@gmail.com",
                    "homepage": "http://www.jwage.com/"
                },
                {
                    "name": "Guilherme Blanco",
                    "email": "guilhermeblanco@gmail.com"
                },
                {
                    "name": "Roman Borschel",
                    "email": "roman@code-factory.org"
                },
                {
                    "name": "Benjamin Eberlei",
                    "email": "kontakt@beberlei.de"
                },
                {
                    "name": "Johannes Schmitt",
                    "email": "schmittjoh@gmail.com",
                    "homepage": "http://jmsyst.com",
                    "role": "Developer of wrapped JMSSerializerBundle"
                }
            ],
            "description": "Common Library for Doctrine projects",
            "homepage": "http://www.doctrine-project.org",
            "keywords": [
                "collections",
                "spl",
                "eventmanager",
                "annotations",
                "persistence"
            ]
        },
        {
            "name": "doctrine/dbal",
            "version": "2.2.2",
            "source": {
                "type": "git",
                "url": "https://github.com/doctrine/dbal",
                "reference": "2.2.2"
            },
            "dist": {
                "type": "zip",
                "url": "https://github.com/doctrine/dbal/zipball/2.2.2",
                "reference": "2.2.2",
                "shasum": ""
            },
            "require": {
                "php": ">=5.3.2",
                "doctrine/common": ">=2.2.0,<=2.2.99"
            },
            "time": "2012-04-13 07:56:12",
            "type": "library",
            "installation-source": "dist",
            "autoload": {
                "psr-0": {
                    "Doctrine\\DBAL": "lib/"
                }
            },
            "license": [
                "LGPL"
            ],
            "authors": [
                {
                    "name": "Jonathan Wage",
                    "email": "jonwage@gmail.com",
                    "homepage": "http://www.jwage.com/"
                },
                {
                    "name": "Guilherme Blanco",
                    "email": "guilhermeblanco@gmail.com"
                },
                {
                    "name": "Roman Borschel",
                    "email": "roman@code-factory.org"
                },
                {
                    "name": "Benjamin Eberlei",
                    "email": "kontakt@beberlei.de"
                }
            ],
            "description": "Database Abstraction Layer",
            "homepage": "http://www.doctrine-project.org",
            "keywords": [
                "database",
                "persistence",
                "dbal",
                "queryobject"
            ]
        },
        {
            "name": "symfony/config",
            "version": "v2.1.1",
            "target-dir": "Symfony/Component/Config",
            "source": {
                "type": "git",
                "url": "https://github.com/symfony/Config",
                "reference": "v2.1.0-RC2"
            },
            "dist": {
                "type": "zip",
                "url": "https://github.com/symfony/Config/zipball/v2.1.0-RC2",
                "reference": "v2.1.0-RC2",
                "shasum": ""
            },
            "require": {
                "php": ">=5.3.3"
            },
            "time": "2012-08-22 13:48:41",
            "type": "library",
            "extra": {
                "branch-alias": {
                    "dev-master": "2.1-dev"
                }
            },
            "installation-source": "dist",
            "autoload": {
                "psr-0": {
                    "Symfony\\Component\\Config": ""
                }
            },
            "license": [
                "MIT"
            ],
            "authors": [
                {
                    "name": "Fabien Potencier",
                    "email": "fabien@symfony.com"
                },
                {
                    "name": "Symfony Community",
                    "homepage": "http://symfony.com/contributors"
                }
            ],
            "description": "Symfony Config Component",
            "homepage": "http://symfony.com"
        },
        {
            "name": "symfony/dependency-injection",
            "version": "v2.1.1",
            "target-dir": "Symfony/Component/DependencyInjection",
            "source": {
                "type": "git",
                "url": "https://github.com/symfony/DependencyInjection",
                "reference": "v2.1.1"
            },
            "dist": {
                "type": "zip",
                "url": "https://github.com/symfony/DependencyInjection/zipball/v2.1.1",
                "reference": "v2.1.1",
                "shasum": ""
            },
            "require": {
                "php": ">=5.3.3"
            },
            "require-dev": {
                "symfony/yaml": "2.1.*",
                "symfony/config": "2.1.*"
            },
            "suggest": {
                "symfony/yaml": "2.1.*",
                "symfony/config": "2.1.*"
            },
            "time": "2012-09-10 10:53:42",
            "type": "library",
            "extra": {
                "branch-alias": {
                    "dev-master": "2.1-dev"
                }
            },
            "installation-source": "dist",
            "autoload": {
                "psr-0": {
                    "Symfony\\Component\\DependencyInjection": ""
                }
            },
            "license": [
                "MIT"
            ],
            "authors": [
                {
                    "name": "Fabien Potencier",
                    "email": "fabien@symfony.com"
                },
                {
                    "name": "Symfony Community",
                    "homepage": "http://symfony.com/contributors"
                }
            ],
            "description": "Symfony DependencyInjection Component",
            "homepage": "http://symfony.com"
        },
        {
            "name": "symfony/event-dispatcher",
            "version": "v2.1.1",
            "target-dir": "Symfony/Component/EventDispatcher",
            "source": {
                "type": "git",
                "url": "https://github.com/symfony/EventDispatcher",
                "reference": "v2.1.1"
            },
            "dist": {
                "type": "zip",
                "url": "https://github.com/symfony/EventDispatcher/zipball/v2.1.1",
                "reference": "v2.1.1",
                "shasum": ""
            },
            "require": {
                "php": ">=5.3.3"
            },
            "require-dev": {
                "symfony/dependency-injection": "2.1.*"
            },
            "suggest": {
                "symfony/dependency-injection": "2.1.*",
                "symfony/http-kernel": "2.1.*"
            },
            "time": "2012-09-10 10:53:42",
            "type": "library",
            "extra": {
                "branch-alias": {
                    "dev-master": "2.1-dev"
                }
            },
            "installation-source": "dist",
            "autoload": {
                "psr-0": {
                    "Symfony\\Component\\EventDispatcher": ""
                }
            },
            "license": [
                "MIT"
            ],
            "authors": [
                {
                    "name": "Fabien Potencier",
                    "email": "fabien@symfony.com"
                },
                {
                    "name": "Symfony Community",
                    "homepage": "http://symfony.com/contributors"
                }
            ],
            "description": "Symfony EventDispatcher Component",
            "homepage": "http://symfony.com"
        },
        {
            "name": "symfony/filesystem",
            "version": "v2.1.1",
            "target-dir": "Symfony/Component/Filesystem",
            "source": {
                "type": "git",
                "url": "https://github.com/symfony/Filesystem",
                "reference": "v2.1.0-RC2"
            },
            "dist": {
                "type": "zip",
                "url": "https://github.com/symfony/Filesystem/zipball/v2.1.0-RC2",
                "reference": "v2.1.0-RC2",
                "shasum": ""
            },
            "require": {
                "php": ">=5.3.3"
            },
            "time": "2012-08-22 13:48:41",
            "type": "library",
            "extra": {
                "branch-alias": {
                    "dev-master": "2.1-dev"
                }
            },
            "installation-source": "dist",
            "autoload": {
                "psr-0": {
                    "Symfony\\Component\\Filesystem": ""
                }
            },
            "license": [
                "MIT"
            ],
            "authors": [
                {
                    "name": "Fabien Potencier",
                    "email": "fabien@symfony.com"
                },
                {
                    "name": "Symfony Community",
                    "homepage": "http://symfony.com/contributors"
                }
            ],
            "description": "Symfony Filesystem Component",
            "homepage": "http://symfony.com"
        },
        {
            "name": "symfony/framework-bundle",
            "version": "v2.1.1",
            "target-dir": "Symfony/Bundle/FrameworkBundle",
            "source": {
                "type": "git",
                "url": "https://github.com/symfony/FrameworkBundle",
                "reference": "v2.1.1"
            },
            "dist": {
                "type": "zip",
                "url": "https://github.com/symfony/FrameworkBundle/zipball/v2.1.1",
                "reference": "v2.1.1",
                "shasum": ""
            },
            "require": {
                "php": ">=5.3.3",
                "symfony/dependency-injection": "2.1.*",
                "symfony/config": "2.1.*",
                "symfony/event-dispatcher": "2.1.*",
                "symfony/http-kernel": "2.1.*",
                "symfony/filesystem": "2.1.*",
                "symfony/routing": "2.1.*",
                "symfony/templating": "2.1.*",
                "symfony/translation": "2.1.*",
                "doctrine/common": ">=2.2,<2.4-dev"
            },
            "require-dev": {
                "symfony/finder": "2.1.*"
            },
            "suggest": {
                "symfony/console": "2.1.*",
                "symfony/finder": "2.1.*",
                "symfony/form": "2.1.*",
                "symfony/validator": "2.1.*"
            },
            "time": "2012-09-10 10:53:42",
            "type": "symfony-bundle",
            "extra": {
                "branch-alias": {
                    "dev-master": "2.1-dev"
                }
            },
            "installation-source": "dist",
            "autoload": {
                "psr-0": {
                    "Symfony\\Bundle\\FrameworkBundle": ""
                }
            },
            "license": [
                "MIT"
            ],
            "authors": [
                {
                    "name": "Fabien Potencier",
                    "email": "fabien@symfony.com"
                },
                {
                    "name": "Symfony Community",
                    "homepage": "http://symfony.com/contributors"
                }
            ],
            "description": "Symfony FrameworkBundle",
            "homepage": "http://symfony.com"
        },
        {
            "name": "symfony/http-foundation",
            "version": "v2.1.1",
            "target-dir": "Symfony/Component/HttpFoundation",
            "source": {
                "type": "git",
                "url": "https://github.com/symfony/HttpFoundation",
                "reference": "v2.1.1"
            },
            "dist": {
                "type": "zip",
                "url": "https://github.com/symfony/HttpFoundation/zipball/v2.1.1",
                "reference": "v2.1.1",
                "shasum": ""
            },
            "require": {
                "php": ">=5.3.3"
            },
            "time": "2012-09-04 12:24:42",
            "type": "library",
            "extra": {
                "branch-alias": {
                    "dev-master": "2.1-dev"
                }
            },
            "installation-source": "dist",
            "autoload": {
                "psr-0": {
                    "Symfony\\Component\\HttpFoundation": "",
                    "SessionHandlerInterface": "Symfony/Component/HttpFoundation/Resources/stubs"
                }
            },
            "license": [
                "MIT"
            ],
            "authors": [
                {
                    "name": "Fabien Potencier",
                    "email": "fabien@symfony.com"
                },
                {
                    "name": "Symfony Community",
                    "homepage": "http://symfony.com/contributors"
                }
            ],
            "description": "Symfony HttpFoundation Component",
            "homepage": "http://symfony.com"
        },
        {
            "name": "symfony/http-kernel",
            "version": "v2.1.1",
            "target-dir": "Symfony/Component/HttpKernel",
            "source": {
                "type": "git",
                "url": "https://github.com/symfony/HttpKernel",
                "reference": "v2.1.1"
            },
            "dist": {
                "type": "zip",
                "url": "https://github.com/symfony/HttpKernel/zipball/v2.1.1",
                "reference": "v2.1.1",
                "shasum": ""
            },
            "require": {
                "php": ">=5.3.3",
                "symfony/event-dispatcher": "2.1.*",
                "symfony/http-foundation": "2.1.*"
            },
            "require-dev": {
                "symfony/browser-kit": "2.1.*",
                "symfony/class-loader": "2.1.*",
                "symfony/config": "2.1.*",
                "symfony/console": "2.1.*",
                "symfony/dependency-injection": "2.1.*",
                "symfony/finder": "2.1.*",
                "symfony/process": "2.1.*",
                "symfony/routing": "2.1.*"
            },
            "suggest": {
                "symfony/browser-kit": "2.1.*",
                "symfony/class-loader": "2.1.*",
                "symfony/config": "2.1.*",
                "symfony/console": "2.1.*",
                "symfony/dependency-injection": "2.1.*",
                "symfony/finder": "2.1.*"
            },
            "time": "2012-09-11 05:00:41",
            "type": "library",
            "extra": {
                "branch-alias": {
                    "dev-master": "2.1-dev"
                }
            },
            "installation-source": "dist",
            "autoload": {
                "psr-0": {
                    "Symfony\\Component\\HttpKernel": ""
                }
            },
            "license": [
                "MIT"
            ],
            "authors": [
                {
                    "name": "Fabien Potencier",
                    "email": "fabien@symfony.com"
                },
                {
                    "name": "Symfony Community",
                    "homepage": "http://symfony.com/contributors"
                }
            ],
            "description": "Symfony HttpKernel Component",
            "homepage": "http://symfony.com"
        },
        {
            "name": "symfony/routing",
            "version": "v2.1.1",
            "target-dir": "Symfony/Component/Routing",
            "source": {
                "type": "git",
                "url": "https://github.com/symfony/Routing",
                "reference": "v2.1.1"
            },
            "dist": {
                "type": "zip",
                "url": "https://github.com/symfony/Routing/zipball/v2.1.1",
                "reference": "v2.1.1",
                "shasum": ""
            },
            "require": {
                "php": ">=5.3.3"
            },
            "require-dev": {
                "symfony/config": "2.1.*",
                "symfony/yaml": "2.1.*",
                "symfony/http-kernel": "2.1.*",
                "doctrine/common": ">=2.2,<2.4-dev"
            },
            "suggest": {
                "symfony/config": "2.1.*",
                "symfony/yaml": "2.1.*",
                "doctrine/common": ">=2.2,<2.4-dev"
            },
            "time": "2012-09-10 10:53:42",
            "type": "library",
            "extra": {
                "branch-alias": {
                    "dev-master": "2.1-dev"
                }
            },
            "installation-source": "dist",
            "autoload": {
                "psr-0": {
                    "Symfony\\Component\\Routing": ""
                }
            },
            "license": [
                "MIT"
            ],
            "authors": [
                {
                    "name": "Fabien Potencier",
                    "email": "fabien@symfony.com"
                },
                {
                    "name": "Symfony Community",
                    "homepage": "http://symfony.com/contributors"
                }
            ],
            "description": "Symfony Routing Component",
            "homepage": "http://symfony.com"
        },
        {
            "name": "symfony/templating",
            "version": "v2.1.1",
            "target-dir": "Symfony/Component/Templating",
            "source": {
                "type": "git",
                "url": "https://github.com/symfony/Templating",
                "reference": "v2.1.1"
            },
            "dist": {
                "type": "zip",
                "url": "https://github.com/symfony/Templating/zipball/v2.1.1",
                "reference": "v2.1.1",
                "shasum": ""
            },
            "require": {
                "php": ">=5.3.3"
            },
            "time": "2012-08-22 13:48:41",
            "type": "library",
            "extra": {
                "branch-alias": {
                    "dev-master": "2.1-dev"
                }
            },
            "installation-source": "dist",
            "autoload": {
                "psr-0": {
                    "Symfony\\Component\\Templating": ""
                }
            },
            "license": [
                "MIT"
            ],
            "authors": [
                {
                    "name": "Fabien Potencier",
                    "email": "fabien@symfony.com"
                },
                {
                    "name": "Symfony Community",
                    "homepage": "http://symfony.com/contributors"
                }
            ],
            "description": "Symfony Templating Component",
            "homepage": "http://symfony.com"
        },
        {
            "name": "symfony/translation",
            "version": "v2.1.1",
            "target-dir": "Symfony/Component/Translation",
            "source": {
                "type": "git",
                "url": "https://github.com/symfony/Translation",
                "reference": "v2.1.1"
            },
            "dist": {
                "type": "zip",
                "url": "https://github.com/symfony/Translation/zipball/v2.1.1",
                "reference": "v2.1.1",
                "shasum": ""
            },
            "require": {
                "php": ">=5.3.3"
            },
            "require-dev": {
                "symfony/config": "2.1.*",
                "symfony/yaml": "2.1.*"
            },
            "suggest": {
                "symfony/config": "2.1.*",
                "symfony/yaml": "2.1.*"
            },
            "time": "2012-09-10 10:53:42",
            "type": "library",
            "extra": {
                "branch-alias": {
                    "dev-master": "2.1-dev"
                }
            },
            "installation-source": "dist",
            "autoload": {
                "psr-0": {
                    "Symfony\\Component\\Translation": ""
                }
            },
            "license": [
                "MIT"
            ],
            "authors": [
                {
                    "name": "Fabien Potencier",
                    "email": "fabien@symfony.com"
                },
                {
                    "name": "Symfony Community",
                    "homepage": "http://symfony.com/contributors"
                }
            ],
            "description": "Symfony Translation Component",
            "homepage": "http://symfony.com"
        },
        {
            "name": "symfony/yaml",
            "version": "v2.1.1",
            "target-dir": "Symfony/Component/Yaml",
            "source": {
                "type": "git",
                "url": "https://github.com/symfony/Yaml",
                "reference": "v2.1.0-RC2"
            },
            "dist": {
                "type": "zip",
                "url": "https://github.com/symfony/Yaml/zipball/v2.1.0-RC2",
                "reference": "v2.1.0-RC2",
                "shasum": ""
            },
            "require": {
                "php": ">=5.3.3"
            },
            "time": "2012-08-22 13:48:41",
            "type": "library",
            "extra": {
                "branch-alias": {
                    "dev-master": "2.1-dev"
                }
            },
            "installation-source": "dist",
            "autoload": {
                "psr-0": {
                    "Symfony\\Component\\Yaml": ""
                }
            },
            "license": [
                "MIT"
            ],
            "authors": [
                {
                    "name": "Fabien Potencier",
                    "email": "fabien@symfony.com"
                },
                {
                    "name": "Symfony Community",
                    "homepage": "http://symfony.com/contributors"
                }
            ],
            "description": "Symfony Yaml Component",
            "homepage": "http://symfony.com"
        }
    ],
    "packages-dev": null,
    "aliases": [

    ],
    "minimum-stability": "stable",
    "stability-flags": [

    ]
}
