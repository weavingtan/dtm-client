English | [中文](./README-CN.md)

<p align="center"><a href="https://hyperf.wiki" target="_blank" rel="noopener noreferrer"><img width="70" src="https://avatars.githubusercontent.com/u/6055142?s=200&v=4" alt="DTM Logo"></a></p>

<p align="center">
  <a href="https://github.com/dtm-php/dtm-client/releases"><img src="https://poser.pugx.org/dtm-php/dtm-client/v/stable" alt="Stable Version"></a>
  <a href="https://www.php.net"><img src="https://img.shields.io/badge/php-%3E=7.4-brightgreen.svg?maxAge=2592000" alt="Php Version"></a>
  <a href="https://github.com/dtm-php/dtm-client/blob/master/LICENSE"><img src="https://img.shields.io/github/license/dtm-php/dtm-client.svg" alt="dtm-client License"></a>
</p>
<p align="center">
  <a href="https://github.com/dtm-php/dtm-client/actions"><img src="https://github.com/dtm-php/dtm-client/actions/workflows/test.yml/badge.svg" alt="PHPUnit for dtm-client"></a>
  <a href="https://packagist.org/packages/dtm/dtm-client"><img src="https://poser.pugx.org/dtm/dtm-client/downloads" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/dtm/dtm-client"><img src="https://poser.pugx.org/dtm/dtm-client/d/monthly" alt="Monthly Downloads"></a>
</p>

# Introduction

[dtm/dtm-client](https://packagist.org/packages/dtm/dtm-client) is the PHP client of Distributed Transaction Manager [DTM](https://github.com/dtm-labs/dtm). It has supported distributed transaction patterns of TCC pattern, Saga pattern, and two-phase message pattern. In communicate protocol it has supported communicate with DTM Server through HTTP protocol or gRPC protocol. Also the client can safely run in PHP-FPM and Swoole coroutine environment, and it has also make support more easier for [Hyperf](https://github.com/hyperf/hyperf) framework.

# About DTM

DTM is an open source distributed transaction manager based on Go language, which provides the powerful function of combining transactions across languages and storage engines. DTM elegantly solves distributed transaction problems such as interface idempotent, null compensation, and transaction suspension, and also provides a distributed transaction solutions that are easy to use, high performance, and easy to scale horizontally.

## Advantage

* Easy to start
  - Start the service with zero configuration and provide a very simple and clear HTTP interface, which greatly reduces the difficulty of getting started with distributed transactions
* Cross Programming language
  - Can be used by companies with multiple language stacks. It is convenient to use in various languages such as Go, Python, PHP, NodeJs, Ruby, C#, etc.
* Simple to use
  - Developers no longer worry about transaction suspension, null compensation, interface idempotent and other issues, and the first sub-transaction barrier technology handles it for you
* Easy to deploy and expand
  - Depends only on MySQL/Redis, easy to deploy, easy to cluster, and easy to scale horizontally
* Multiple distributed transaction protocol support
  - TCC, SAGA, XA, two-stage message, one-stop solution to various distributed transaction problems

## Comparison

In non-Java languages, there is still no mature distributed transaction manager other than DTM, so here is a comparison between DTM and Seata, the most mature open source project in Java:

|                                          Features                                          |                                                DTM                                                |                                              SEATA                                               |                                      Memo                                       |
|:------------------------------------------------------------------------------------------:|:-------------------------------------------------------------------------------------------------:|:------------------------------------------------------------------------------------------------:|:-------------------------------------------------------------------------------:|
|              [language supports](https://dtm.pub/other/opensource.html#lang)               |                     <span style="color:green">Go、C#、Java、Python、PHP...</span>                     |                              <span style="color:orange">Java</span>                              |             DTM is easier implemented the client to a new language              |
|               [Storage Engine](https://dtm.pub/other/opensource.html#store)                |               <span style="color:green">Support Database, Redis, Mongo, etc.</span>               |                            <span style="color:orange">Database</span>                            ||
|            [Exception Handle](https://dtm.pub/other/opensource.html#exception)             |        <span style="color:green"> Sub-transaction barrier is handled automatically </span>        |                           <span style="color:orange">By manual</span>                            | DTM solves transaction suspension, null compensation, interface idempotent etc. |
|                     [SAGA](https://dtm.pub/other/opensource.html#saga)                     |                           <span style="color:green">Easy to use</span>                            |                     <span style="color:orange">Complex state machine</span>                      ||
|               [Two-phase message](https://dtm.pub/other/opensource.html#msg)               |                                <span style="color:green">✓</span>                                 |                                 <span style="color:red">✗</span>                                 |                Minimal Message Eventual Consistency Architecture                |
|                      [TCC](https://dtm.pub/other/opensource.html#tcc)                      |                                <span style="color:green">✓</span>                                 |                                <span style="color:green">✓</span>                                ||
|                       [XA](https://dtm.pub/other/opensource.html#xa)                       |                                <span style="color:green">✓</span>                                 |                                <span style="color:green">✓</span>                                ||
|                       [AT](https://dtm.pub/other/opensource.html#at)                       |                     <span style="color:orange">XA is more recommended</span>                      |                                <span style="color:green">✓</span>                                |                  AT is similar to XA, but with dirty rollback                   |
| [Single service with multiple data sources](https://dtm.pub/other/opensource.html#multidb) |                                <span style="color:green">✓</span>                                 |                                 <span style="color:red">✗</span>                                 ||
|           [Communicate protocol](https://dtm.pub/other/opensource.html#protocol)           |                                             HTTP、gRPC                                             |                                            Dubbo etc.                                            |                      DTM is more friendly to cloud native                       |
|                   [Github Stargazers](https://dtm.pub/other/opensource.html#star)                    | <img src="https://img.shields.io/github/stars/dtm-labs/dtm.svg?style=social" alt="github stars"/> | <img src="https://img.shields.io/github/stars/seata/seata.svg?style=social" alt="github stars"/> |          DTM released version 0.1 from 2021-06-04, developing rapidly           |

From the characteristics of the comparison above, DTM has great advantages in many aspects. If you consider multi-language support and multi-storage engine support, then DTM is undoubtedly your first choice.

# Installation

It is very convenient to install dtm-client through Composer

```bash
composer require dtm/dtm-client
```

* Don't forget to start DTM Server before you use it

# Configuration

## Configuration file

If you are using the Hyperf framework, after installing the component, you can publish a configuration file to `./config/autoload/dtm.php` with the following `vendor:publish` command

```bash
php bin/hyperf.php vendor:publish dtm/dtm-client
```

If you are using a non-Hyperf framework, copy the `./vendor/dtm/dtm-client/publish/dtm.php` file to the corresponding configuration directory.

```php
use DtmClient\Constants\Protocol;
use DtmClient\Constants\DbType;

return [
    // The communication protocol between the client and the DTM Server, supports Protocol::HTTP and Protocol::GRPC
    'protocol' => Protocol::HTTP,
    // DTM Server address
    'server' => '127.0.0.1',
    // DTM Server port
    'port' => [
        'http' => 36789,
        'grpc' => 36790,
    ],
    // Sub-transaction barrier
    'barrier' => [
        // Subtransaction barrier configuration in DB mode 
        'db' => [
            'type' => DbType::MySQL
        ],
        // Subtransaction barrier configuration in Redis mode
        'redis' => [
            // Timeout for subtransaction barrier records
            'expire_seconds' => 7 * 86400,
        ],
        // Classes that apply sub-transaction barriers in non-Hyperf frameworks or without annotation usage
        'apply' => [],
    ],
    // Options of Guzzle client under HTTP protocol
    'guzzle' => [
        'options' => [],
    ],
];
```

## Configure middleware

Before using it, you need to configure the `DtmClient\Middleware\DtmMiddleware` middleware as the server's global middleware. This middleware supports the PSR-15 specification and is applicable to all frameworks that support this specification.
For middleware configuration in Hyperf, please refer to [Hyperf Documentation - Middleware](https://www.hyperf.wiki/2.2/#/zh-cn/middleware/middleware) chapter.

# Usage

The usage of dtm-client is very simple, we provide a sample project [dtm-php/dtm-sample](https://github.com/dtm-php/dtm-sample) to help you better understand and debug.
Before using this component, it is also strongly recommended that you read the [DTM official documentation](https://dtm.pub/) for a more detailed understanding.

## TCC pattern

The TCC pattern is a very popular flexible distributed transaction solution. The concept of TCC is composed of the acronyms of the three words Try-Confirm-Cancel. It was first published in a paper named [Life beyond Distributed Transactions:an Apostate’s Opinion](https://www.ics.uci.edu/~cs223/papers/cidr07p15.pdf) by Pat Helland in 2007.

### Three stages of TCC

Try phase: try to execute, complete all business checks (consistency), reserve necessary business resources (pre-isolation)
Confirm stage: If all branches of the Try are successful, go to the Confirm stage. Confirm actually executes the business without any business check, and only uses the business resources reserved in the Try phase
Cancel stage: If one of the Try of all branches fails, go to the Cancel stage. Releases the business resources reserved in the Try phase.

If we want to carry out a business similar to inter-bank transfer between banks, the transfer out (TransOut) and the transfer in (TransIn) are in different microservices, and a typical sequence diagram of a successfully completed TCC transaction is as follows:

<img src="https://en.dtm.pub/assets/tcc_normal.85ceb661.jpg" height=600 />

### Example

The following shows how to use it in the Hyperf framework, other frameworks are similar

```php
<?php
namespace App\Controller;

use DtmClient\TCC;
use DtmClient\TransContext;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Throwable;

#[Controller(prefix: '/tcc')]
class TccController
{

    protected string $serviceUri = 'http://127.0.0.1:9501';

    #[Inject]
    protected TCC $tcc;

    #[GetMapping(path: 'successCase')]
    public function successCase()
    {
        try {
            
            $this->tcc->globalTransaction(function (TCC $tcc) {
                // Create call data for subtransaction A
                $tcc->callBranch(
                    // Arguments for calling the Try method
                    ['amount' => 30],
                    // URL of Try stage
                    $this->serviceUri . '/tcc/transA/try',
                    // URL of Confirm stage
                    $this->serviceUri . '/tcc/transA/confirm',
                    // URL of Cancel stage
                    $this->serviceUri . '/tcc/transA/cancel'
                );
                // Create call data for subtransaction B, and so on
                $tcc->callBranch(
                    ['amount' => 30],
                    $this->serviceUri . '/tcc/transB/try',
                    $this->serviceUri . '/tcc/transB/confirm',
                    $this->serviceUri . '/tcc/transB/cancel'
                );
            });
        } catch (Throwable $e) {
            var_dump($e->getMessage(), $e->getTraceAsString());
        }
        // Get the global transaction ID through TransContext::getGid() and return it to the client
        return TransContext::getGid();
    }
}
```

## Saga pattern

The Saga pattern is one of the most well-known solutions in the field of distributed transactions, and it is also very popular in major systems. It first appeared in the paper [SAGAS](https://www.cs.cornell.edu/andru/cs711/2002fa/reading/sagas.pdf) published by Hector Garcaa-Molrna & Kenneth Salem in 1987.

Saga is an eventual consistency transaction, also a flexible transaction, also known as a long-running transaction . Saga is composed of a series of local transactions. After each local transaction updates the database, it will publish a message or an event to trigger the execution of the next local transaction in the Saga global transaction. If a local transaction fails because some business rules cannot be satisfied, Saga performs compensating actions for all transactions that were successfully committed before the failed transaction. Therefore, when the Saga pattern is compared with the TCC pattern, it often becomes more troublesome to implement the rollback logic due to the lack of resource reservation steps.

### Sub-transaction split of Saga

For example, we want to carry out a business similar to inter-bank transfer between banks, and transfer 30 dollar in account A to account B. According to the principle of Saga transaction, we will split the entire global transaction into the following services:
- Transfer out (TransOut) service, the account A will deduct 30 dollar
- Transfer out compensation (TransOutCompensate) service, roll back the above transfer out operation, that is, increase the account A by 30 dollar
- Transfer in (TransIn) service, the account B will be increased by 30 dollar
- Transfer in compensation (TransInCompensate) service, roll back the above transfer in operation, that is, the account B is reduced by 30 dollar

The logic of the entire transaction is:

Execute the transfer out successfully => Execute the transfer in successfully => the global transaction is completed

If an error occurs in the middle, such as an error in transferring to the B account, the compensation operation of the executed branch will be called, namely:

Execute transfer out successfully => execute transfer in failure => execute transfer in compensation successfully => execute transfer out compensation successfully => global transaction rollback completed

The following is a typical sequence diagram of a successfully completed SAGA transaction:

<img src="https://en.dtm.pub/assets/saga_normal.59a75c01.jpg" height=428 />

### Example

The following shows how to use it in the Hyperf framework, other frameworks are similar

```php
namespace App\Controller;

use DtmClient\Saga;
use DtmClient\TransContext;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;

#[Controller(prefix: '/saga')]
class SagaController
{

    protected string $serviceUri = 'http://127.0.0.1:9501';
    
    #[Inject]
    protected Saga $saga;

    #[GetMapping(path: 'successCase')]
    public function successCase(): string
    {
        $payload = ['amount' => 50];
        // Init Saga global transaction
        $this->saga->init();
        // Add TransOut sub-transaction
        $this->saga->add(
            $this->serviceUri . '/saga/transOut', 
            $this->serviceUri . '/saga/transOutCompensate', 
            $payload
        );
        // Add TransIn sub-transaction
        $this->saga->add(
            $this->serviceUri . '/saga/transIn', 
            $this->serviceUri . '/saga/transInCompensate', 
            $payload
        );
        // Submit Saga global transaction
        $this->saga->submit();
        // Get the global transaction ID through TransContext::getGid() and return it to the client
        return TransContext::getGid();
    }
}
```
