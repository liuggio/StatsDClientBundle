# Contributing to StatsD Client Bundle

:+1::tada: Thanks for taking the time to contribute! 
Your Contributions, Suggestions and Feedbacks are valuable to us.

The following is a set of guidelines for contributing to StatsD Client Bundle. These are guidelines, not rules. 

## What should I know before I get started?

Please refer to README.md file for articles and documentations which will help you understand the project better.

Active contribution and patches are very welcome.
To keep things in shape we have quite a bunch of unit tests. If you're submitting pull requests please make sure that they are still passing and if you add functionality please
take a look at the coverage as well it should be pretty high :)

- First fork and then clone the repository

```
git clone git://github.com/liuggio/StatsDClientBundle.git
cd StatsDClientBundle
```

- Create a new branch
```
git -b checkout "your-branch-name"
```

- Install vendors:

``` bash
php composer.phar install --dev
```

- This will give you proper results:

``` bash
phpunit --coverage-html reports
```

## How Can I Contribute?

### Reporting Bugs by creating Issues
### Suggesting Enhancements
### Getting Started with first contribution - Check out Issues listed

## Pull Requests

Create a Pull Request in order to get your code changes added to the repository.

The process described here has several goals:
- Make sure you create PR’s from a different branch and not from the master branch of your fork.
- Maintain Code quality.
- Fix problems that are important.
- Engage with the community to get reviews and work towards better.

Thanks :)
