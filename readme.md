# Callkeeper

Limit API calling to keep under limited rate per an unit time.

This implement is logic without using timer. So simple and light weight.


単位時間内でAPIの呼び出し回数を制限する。

タイマーを使用しない簡単なロジックで実装しているため、シンプルで軽い。

## Usage

~~~
require __DIR__ . '/vendor/autoload.php';

use Callkeeper\Callkeeper;

...

/* Initialize */
$keep = new Callkeeper(3, 3000); // 3 times per 3,000 ms (3 seconds)

/* check and wait if needed */
$keep->timeKeep();

$response = WebApiCalling(...);

...
~~~

## License

MIT License.

Copyright reserved by Hirohisa Kawase.

## Addition

Sorry for no test. It is hard to write tests for this type library... :P :D
