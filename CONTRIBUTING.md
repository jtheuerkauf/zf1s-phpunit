Contributing to PHPUnit
=======================

Contributions to PHPUnit, its related modules, and its documentation are always welcome. You make our lives easier by sending us your contributions through GitHub pull requests.

Pull requests for bug fixes must be based on the current stable branch whereas pull requests for new features must be based on `master`.

We are trying to keep backwards compatibility breaks in PHPUnit to an absolute minimum. Please take this into account when proposing changes.

Due to time constraints, we are not always able to respond as quickly as we would like. Please do not take delays personal and feel free to remind us here or on IRC if you feel that we forgot to respond.

Using PHPUnit From a Git Checkout
---------------------------------

The following commands can be used to perform the initial checkout of PHPUnit:

    git clone git://github.com/zf1s/phpunit.git
    cd phpunit

To retrieve PHPUnit's dependencies, you can use [Composer](http://getcomposer.org/download/). If you do not have Composer installed, you can download the latest PHAR with the following command:

    curl -O http://getcomposer.org/composer.phar

Once Composer is installed, you can fetch PHPUnit's dependencies with the following command:

    php composer.phar install --dev

The `phpunit.php` script can be used to invoke the PHPUnit test runner.

